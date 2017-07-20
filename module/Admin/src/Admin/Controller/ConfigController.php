<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;
use Zend\EventManager\EventManagerInterface;
use ZendVN\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container as Container;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Validator\Db\RecordExists;
use Zend\Validator\Db\NoRecordExists;
use Zend\Stdlib\ArrayObject;
class ConfigController extends ActionController
{
    
	//======Mảng tham số Router nhận được ở mỗi Action===//
    protected $_arrParam;
    //======Mảng tham số Post nhận được ở mỗi action=====//
    protected $_arrPost;
    //======Đường dẫn của Controller=====================//
    protected $_currentController;
 	//======Đường dẫn của Action chính===================//
 	protected $_actionMain;
    //======Đối tượng view helper========================//
    protected $_viewHelper;
 	//======Lưu session==================================//
 	protected $_namespace;
    //======Phân trang===================================//
    protected $_paginatorParams = array(
        'itemCountPerPage'  =>  10,
        'pageRange'         =>  4,

    );

    protected $_modelTable;


    public function getTable(){
        if(empty($this->_modelTable)){
            $this->_modelTable = $this->getServiceLocator()->get('Admin\Model\ConfigTable');
        }
        return $this->_modelTable;
    }
   
    public function init()
    {
        

        $controller = $this;
        
           
            //Mảng tham số Router nhận được ở mỗi Action
        	$this->_arrParam 	= $this->params()->fromRoute();

            //Mảng tham số Post nhận được ở mỗi Action
            $this->_arrPost     = $this->params()->fromPost();

            //Đối tượng view Helper
            $this->_viewHelper  = $this->getServiceLocator()->get('Zend\View\Renderer\PhpRenderer');

        	//Đường dẫn của Controller
        	$paramController 			   = $this->_arrParam['controller'];
        	$tmp 						   = explode("\\", $paramController);
        	$this->_arrParam['module']     = strtolower($tmp[0]);//get module name
        	$this->_arrParam['controller'] = strtolower($tmp[2]);//get controller name

        	$this->_currentController 	= '/' . $this->_arrParam['module'] 
									 	. '/' . $this->_arrParam['controller'];


		
        	//Đường dẫn của Action chính		
			$this->_actionMain 			= '/' . $this->_arrParam['module'] 
							 			. '/' . $this->_arrParam['controller']	. '/' . $this->_arrParam['action'];	
        	
      		//---------Dat ten SESSION-----------------------------------------
			$this->_namespace 							= $this->_arrParam['module'] . '_' . $this->_arrParam['controller'] ;
			$ssFilter 									= new Container($this->_namespace);

            if(empty($ssFilter->col)){
                $ssFilter->keywords     = '';
                $ssFilter->col          = 'id';
                $ssFilter->order        = 'DESC';
            }
            if(empty($ssFilter->record)){
                $ssFilter->record   = 10;
            }
        	$this->_arrParam['ssFilter']['keywords'] 	= $ssFilter->keywords;
        	$this->_arrParam['ssFilter']['sort'] 		= $ssFilter->sort;
   	    	$this->_arrParam['ssFilter']['col'] 		= $ssFilter->col;
        	$this->_arrParam['ssFilter']['order'] 		= $ssFilter->order;
            $this->_arrParam['ssFilter']['record']      = $ssFilter->record;
            $this->_arrParam['ssFilter']['field']       = $ssFilter->field ;
            $this->_arrParam['ssFilter']['status']      = $ssFilter->status;
            $this->_arrParam['ssFilter']['group']       = $ssFilter->group;
            $this->_arrParam['ssFilter']['city']        = $ssFilter->city;

           
           
            $this->_paginatorParams['itemCountPerPage'] = (int) $ssFilter->record;
            $this->_paginatorParams['currentPageNumber']= $this->params()->fromRoute('page',1);
            $this->_arrParam['paginator']               = $this->_paginatorParams;

            //Load templates
           	$this->layout('layout/list');

            $this->_arrParam['id']  = 1;


        
    }

    

    public function indexAction()
    {
        $error     = array();
        //Tiêu đề
        $title      =  'Cấu hình website';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        
        
        $configWebsiteAdminForm       = $this->serviceLocator->get('FormElementManager')->get('configWebsiteAdminForm');
            
        if($this->getRequest()->isPost()){
            $data   = $this->getRequest()->getPost();
            $configWebsiteAdminForm->setData($data);

            if($configWebsiteAdminForm->isValid() && empty($error)){
                
                //Chống tấn công XSS
                $purifier   = new \HTMLPurifier_HTMLPurifier();

                $arrConfig = array(
                    'title'    => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['title'])),
                    'keyword'  => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['keyword'])),
                    'description'  => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['description'])),
                );
                
                $data    =  array(
                    'id'            => 1, 
                    'website'   => \Zend\Json\Json::encode($arrConfig),
                );

                $this->getTable()->saveItem($data,array('task'=>'edit'));
                $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được lưu thành công');
                $this->redirect()->toUrl('/admin/config/index');
            }
        }
        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'myForm'            =>  $configWebsiteAdminForm,
            'error'             =>  $error,
        ));
        
    }

    //Ajax load indexAction
    public function indexAjaxAction(){
        $view               = new ViewModel();
        $dataItems          = null;
        $dataPaginator      = null;
        $isXmlHttpRequest   = false;

      
        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;

            $item                  = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));      

            $arrConfig  = \Zend\Json\Json::decode($item->website);

            $configWebsiteAdminForm       = $this->serviceLocator->get('FormElementManager')->get('configWebsiteAdminForm');
            
            //Bind
            $object = new ArrayObject(array(
                    'title'  => $arrConfig->title,
                    'keyword'  => $arrConfig->keyword, 
                    'description'  => $arrConfig->description,                             
            ));
            $configWebsiteAdminForm->bind($object);
            
        }    
        
        $view->setVariables(array(
            'isXmlHttpRequest'  =>  $isXmlHttpRequest,
            'item'              =>  $item,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'myForm'            =>  $configWebsiteAdminForm,
        ));
        $view->setTerminal(true);
        return $view;


    }

    public function companyAction()
    {
        $error     = array();
        //Tiêu đề
        $title      =  'Thông tin liên hệ';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        
        
        $configCompanyAdminForm       = $this->serviceLocator->get('FormElementManager')->get('configCompanyAdminForm');
            
        if($this->getRequest()->isPost()){
            $data   = $this->getRequest()->getPost();
            $configCompanyAdminForm->setData($data);

            if($configCompanyAdminForm->isValid() && empty($error)){
                
                //Chống tấn công XSS
                $purifier   = new \HTMLPurifier_HTMLPurifier();

                $arrConfig = array(
                    'name'    => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['name'])),
                    'slogan'  => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['slogan'])),
                    'address'  => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['address'])),
                    'phone'  => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['phone'])),
                    'fax'  => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['fax'])),
                    'email'  => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['email'])),
                    'website'  => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['website'])),
                );
                
                $data    =  array(
                    'id'            => 1, 
                    'company'   => \Zend\Json\Json::encode($arrConfig),
                );

                $this->getTable()->saveItem($data,array('task'=>'edit'));
                $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được lưu thành công');
                $this->redirect()->toUrl('/admin/config/company');
            }
        }
        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'myForm'            =>  $configCompanyAdminForm,
            'error'             =>  $error,
        ));
        
    }

    //Ajax load indexAction
    public function companyAjaxAction(){
        $view               = new ViewModel();
        $dataItems          = null;
        $dataPaginator      = null;
        $isXmlHttpRequest   = false;

      
        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;

            $item                  = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));      

            $arrConfig  = \Zend\Json\Json::decode($item->company);

            $configCompanyAdminForm       = $this->serviceLocator->get('FormElementManager')->get('configCompanyAdminForm');
            
            //Bind
            $object = new ArrayObject(array(
                    'name'          => $arrConfig->name,
                    'slogan'        => $arrConfig->slogan, 
                    'address'       => $arrConfig->address,
                    'phone'         => $arrConfig->phone, 
                    'fax'           => $arrConfig->fax, 
                    'email'         => $arrConfig->email,
                    'website'         => $arrConfig->website,                             
            ));
            $configCompanyAdminForm->bind($object);
            
        }    
        
        $view->setVariables(array(
            'isXmlHttpRequest'  =>  $isXmlHttpRequest,
            'item'              =>  $item,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'myForm'            =>  $configCompanyAdminForm,
        ));
        $view->setTerminal(true);
        return $view;


    }

     public function mapAction()
    {
        $error     = array();
        //Tiêu đề
        $title      =  'Bản đồ';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        
        
           
        if($this->getRequest()->isPost()){
             
                //Chống tấn công XSS
                $purifier   = new \HTMLPurifier_HTMLPurifier();

                $arrConfig = array(
                    'latitude_gmap'     => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['latitude'])),
                    'longitude_gmap'    => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['longitude'])),
                );
                
                $data    =  array(
                    'id'            => 1, 
                    'map'   => \Zend\Json\Json::encode($arrConfig),
                );

                $this->getTable()->saveItem($data,array('task'=>'edit'));
                $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được lưu thành công');
                $this->redirect()->toUrl('/admin/config/map');
            
        }
        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'error'             =>  $error,
        ));
        
    }

    //Ajax load indexAction
    public function mapAjaxAction(){
        $view               = new ViewModel();
        $dataItems          = null;
        $dataPaginator      = null;
        $isXmlHttpRequest   = false;

      
        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;

            $item                  = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));      

            $arrConfig  = \Zend\Json\Json::decode($item->company);

          
            
        }    
        
        $view->setVariables(array(
            'isXmlHttpRequest'  =>  $isXmlHttpRequest,
            'item'              =>  $item,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            
        ));
        $view->setTerminal(true);
        return $view;


    }

    public function emailAction()
    {
        $error     = array();
        //Tiêu đề
        $title      =  'Cấu hình email';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        
        
        $configEmailAdminForm       = $this->serviceLocator->get('FormElementManager')->get('configEmailAdminForm');
            
        if($this->getRequest()->isPost()){
            $data   = $this->getRequest()->getPost();
            $configEmailAdminForm->setData($data);

            if($configEmailAdminForm->isValid() && empty($error)){
                
                //Chống tấn công XSS
                $purifier   = new \HTMLPurifier_HTMLPurifier();

                $arrConfig = array(
                    'protocol'    => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['protocol'])),
                    'server'  => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['server'])),
                    'email'  => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['email'])),
                    'password'  => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['password'])),
                    'port'  => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['port'])),
                    
                );
                
                $data    =  array(
                    'id'            => 1, 
                    'email'   => \Zend\Json\Json::encode($arrConfig),
                );

                $this->getTable()->saveItem($data,array('task'=>'edit'));
                $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được lưu thành công');
                $this->redirect()->toUrl('/admin/config/email');
            }
        }
        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'myForm'            =>  $configEmailAdminForm,
            'error'             =>  $error,
        ));
        
    }

    //Ajax load indexAction
    public function emailAjaxAction(){
        $view               = new ViewModel();
        $dataItems          = null;
        $dataPaginator      = null;
        $isXmlHttpRequest   = false;

      
        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;

            $item                  = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));      

            $arrConfig  = \Zend\Json\Json::decode($item->email);

            $configEmailAdminForm       = $this->serviceLocator->get('FormElementManager')->get('configEmailAdminForm');
            
            //Bind
            $object = new ArrayObject(array(
                    'protocol'      => $arrConfig->protocol,
                    'server'        => $arrConfig->server, 
                    'email'         => $arrConfig->email,
                    'password'      => $arrConfig->password, 
                    'port'          => $arrConfig->port,                            
            ));
            $configEmailAdminForm->bind($object);
            
        }    
        
        $view->setVariables(array(
            'isXmlHttpRequest'  =>  $isXmlHttpRequest,
            'item'              =>  $item,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'myForm'            =>  $configEmailAdminForm,
        ));
        $view->setTerminal(true);
        return $view;


    }

    public function advanceAction()
    {
        $error     = array();
        //Tiêu đề
        $title      =  'Cấu hình nâng cao';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        
        
        $configAdvanceAdminForm       = $this->serviceLocator->get('FormElementManager')->get('configAdvanceAdminForm');
            
        if($this->getRequest()->isPost()){
            $data   = $this->getRequest()->getPost();
            $configAdvanceAdminForm->setData($data);

            if($configAdvanceAdminForm->isValid() && empty($error)){
                
                //Chống tấn công XSS
                $purifier   = new \HTMLPurifier_HTMLPurifier();

                $arrConfig = array(
                    'GoogleAnalyticsCode'       => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['GoogleAnalyticsCode'])),
                    'activeAccountEmail'        => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['activeAccountEmail'])),
                    'limitSendEmailMarketing'   => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['limitSendEmailMarketing'])), 
                );
                
                $data    =  array(
                    'id'            => 1, 
                    'advance'   => \Zend\Json\Json::encode($arrConfig),
                );



                $this->getTable()->saveItem($data,array('task'=>'edit'));
                $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được lưu thành công');
                $this->redirect()->toUrl('/admin/config/advance');
            }
        }
        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'myForm'            =>  $configAdvanceAdminForm,
            'error'             =>  $error,
        ));
        
    }

    //Ajax load indexAction
    public function advanceAjaxAction(){
        $view               = new ViewModel();
        $dataItems          = null;
        $dataPaginator      = null;
        $isXmlHttpRequest   = false;

      
        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;

            $item                  = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));      

            $arrConfig  = \Zend\Json\Json::decode($item->advance);

            $configAdvanceAdminForm       = $this->serviceLocator->get('FormElementManager')->get('configAdvanceAdminForm');
            
            //Bind
            $object = new ArrayObject(array(
                    'GoogleAnalyticsCode'       => $arrConfig->GoogleAnalyticsCode,
                    'activeAccountEmail'        => $arrConfig->activeAccountEmail, 
                    'limitSendEmailMarketing'   => $arrConfig->limitSendEmailMarketing,
                                              
            ));
            $configAdvanceAdminForm->bind($object);
            
        }    
        
        $view->setVariables(array(
            'isXmlHttpRequest'  =>  $isXmlHttpRequest,
            'item'              =>  $item,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'myForm'            =>  $configAdvanceAdminForm,
        ));
        $view->setTerminal(true);
        return $view;


    }

    public function displayAction()
    {
        $error     = array();
        //Tiêu đề
        $title      =  'Cấu hình hiển thị';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        
        
        $configDisplayAdminForm       = $this->serviceLocator->get('FormElementManager')->get('configDisplayAdminForm');
          
        if($this->getRequest()->isPost()){
            $data   = $this->getRequest()->getPost();
            $configDisplayAdminForm->setData($data);


            if($configDisplayAdminForm->isValid() && empty($error)){
                
                //Chống tấn công XSS
                $purifier   = new \HTMLPurifier_HTMLPurifier();

                $arrConfig = array(
                    'descriptionNews'       => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['descriptionNews'])),
                    'descriptionRealEstate'        => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['descriptionRealEstate'])),
                    'descriptionLegalhousing'   => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['descriptionLegalhousing'])), 
                    'commentFacebook'   => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['commentFacebook'])),
                );
                
                $data    =  array(
                    'id'            => 1, 
                    'display'   => \Zend\Json\Json::encode($arrConfig),
                );
                

                $this->getTable()->saveItem($data,array('task'=>'edit'));
                $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được lưu thành công');
                $this->redirect()->toUrl('/admin/config/display');
            }else{
                //echo '<pre>';
                //print_r($configDisplayAdminForm->getMessages());
                //echo '</pre>';
            }
        }
        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'myForm'            =>  $configDisplayAdminForm,
            'error'             =>  $error,
        ));
        
    }

    //Ajax load indexAction
    public function displayAjaxAction(){
        $view               = new ViewModel();
        $dataItems          = null;
        $dataPaginator      = null;
        $isXmlHttpRequest   = false;

      
        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;

            $item                  = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));      

            $arrConfig  = \Zend\Json\Json::decode($item->display);

            $configDisplayAdminForm       = $this->serviceLocator->get('FormElementManager')->get('configDisplayAdminForm');
            
            //Bind
            $object = new ArrayObject(array(
                    'descriptionNews'       => $arrConfig->descriptionNews,
                    'descriptionRealEstate'       => $arrConfig->descriptionRealEstate,
                    'descriptionLegalhousing'        => $arrConfig->descriptionLegalhousing, 
                    'commentFacebook'   => $arrConfig->commentFacebook,
                                              
            ));
            $configDisplayAdminForm->bind($object);
            
        }    
        
        $view->setVariables(array(
            'isXmlHttpRequest'  =>  $isXmlHttpRequest,
            'item'              =>  $item,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'myForm'            =>  $configDisplayAdminForm,
        ));
        $view->setTerminal(true);
        return $view;


    }

    public function maintenanceAction()
    {
        $error     = array();
        //Tiêu đề
        $title      =  'Chế độ bảo trì';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        
        
        $configMaintenanceAdminForm       = $this->serviceLocator->get('FormElementManager')->get('configMaintenanceAdminForm');
            
        if($this->getRequest()->isPost()){
            $data   = $this->getRequest()->getPost();
            $configMaintenanceAdminForm->setData($data);

            if($configMaintenanceAdminForm->isValid() && empty($error)){
                
                //Chống tấn công XSS
                $purifier   = new \HTMLPurifier_HTMLPurifier();

                $arrConfig = array(
                    'notice'       => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['notice'])),
                    'status'        => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['status'])), 
                );
                
                $data    =  array(
                    'id'            => 1, 
                    'maintenance'   => \Zend\Json\Json::encode($arrConfig),
                );

               

                $this->getTable()->saveItem($data,array('task'=>'edit'));
                $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được lưu thành công');
                $this->redirect()->toUrl('/admin/config/maintenance');
            }
        }
        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'myForm'            =>  $configMaintenanceAdminForm,
            'error'             =>  $error,
        ));
        
    }

    //Ajax load indexAction
    public function maintenanceAjaxAction(){
        $view               = new ViewModel();
        $dataItems          = null;
        $dataPaginator      = null;
        $isXmlHttpRequest   = false;

      
        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;

            $item                  = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));      

            $arrConfig  = \Zend\Json\Json::decode($item->maintenance);

            $configMaintenanceAdminForm       = $this->serviceLocator->get('FormElementManager')->get('configMaintenanceAdminForm');
            
            //Bind
            $object = new ArrayObject(array(
                    'notice'       => $arrConfig->notice,
                    'status'       => $arrConfig->status,                            
            ));
            $configMaintenanceAdminForm->bind($object);
            
        }    
        
        $view->setVariables(array(
            'isXmlHttpRequest'  =>  $isXmlHttpRequest,
            'item'              =>  $item,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'myForm'            =>  $configMaintenanceAdminForm,
        ));
        $view->setTerminal(true);
        return $view;


    }

    
    
    
    
}

