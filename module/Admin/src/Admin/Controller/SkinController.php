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
class SkinController extends ActionController
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
            $this->_modelTable = $this->getServiceLocator()->get('Admin\Model\SkinTable');
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

    public function logoAction()
    {
    	$error     = array();
        //Tiêu đề
    	$title      =  'Logo website';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        
        
        $logoAdminForm       = $this->serviceLocator->get('FormElementManager')->get('logoAdminForm');
            
        if($this->getRequest()->isPost()){
            $data   = $this->getRequest()->getPost();
            $logoAdminForm->setData($data);

            if($logoAdminForm->isValid() && empty($error)){
                
                $item           = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));
            
                $arrConfig  = \Zend\Json\Json::decode($item->config_logo);

                //Chống tấn công XSS
                $purifier   = new \HTMLPurifier_HTMLPurifier();

                $arrConfigLogo = array(
                    'slogan'    => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['name'])),
                    'logo'      => $arrConfig->logo,
                );
                
                $data    =  array(
                    'id'            => 1, 
                    'config_logo'   => \Zend\Json\Json::encode($arrConfigLogo),
                );

                $this->getTable()->saveItem($data,array('task'=>'edit'));
                $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được lưu thành công');
                $this->redirect()->toUrl('/admin/skin/logo');
            }
        }
        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'myForm'            =>  $logoAdminForm,
            'error'             =>  $error,
        ));
    	
    }
    //Ajax load indexAction
    public function logoAjaxAction(){
        $view               = new ViewModel();
        $dataItems          = null;
        $dataPaginator      = null;
        $isXmlHttpRequest   = false;

      
        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;

            $item                  = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));      

            $arrConfigLogo  = \Zend\Json\Json::decode($item->config_logo);

            $logoAdminForm       = $this->serviceLocator->get('FormElementManager')->get('logoAdminForm');
            
            //Bind
            $object = new ArrayObject(array(
                    'name'  => $arrConfigLogo->slogan,                            
            ));
            $logoAdminForm->bind($object);
            
        }    
        
        $view->setVariables(array(
            'isXmlHttpRequest'  =>  $isXmlHttpRequest,
            'item'              =>  $item,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'myForm'            =>  $logoAdminForm,
        ));
        $view->setTerminal(true);
        return $view;


    }

    public function footerAction()
    {
        $error     = array();
        //Tiêu đề
        $title      =  'Chân trang(footer)';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        
        
        $footerAdminForm       = $this->serviceLocator->get('FormElementManager')->get('footerAdminForm');
            
        if($this->getRequest()->isPost()){
            $data   = $this->getRequest()->getPost();
            $footerAdminForm->setData($data);

            if($footerAdminForm->isValid() && empty($error)){
                

                //Chống tấn công XSS
                $purifier   = new \HTMLPurifier_HTMLPurifier();

                $arrConfigFooter = array(
                    'content'    => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['content'])),
                );
                
                $data    =  array(
                    'id'            => 1, 
                    'config_footer'   => \Zend\Json\Json::encode($arrConfigFooter),
                );

                $this->getTable()->saveItem($data,array('task'=>'edit'));
                $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được lưu thành công');
                $this->redirect()->toUrl('/admin/skin/footer');
            }
        }
        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'myForm'            =>  $footerAdminForm,
            'error'             =>  $error,
        ));
        
    }

    //Ajax load indexAction
    public function footerAjaxAction(){
        $view               = new ViewModel();
        $dataItems          = null;
        $dataPaginator      = null;
        $isXmlHttpRequest   = false;

      
        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;

            $item                  = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));      

            $arrConfigFooter  = \Zend\Json\Json::decode($item->config_footer);

            $footerAdminForm       = $this->serviceLocator->get('FormElementManager')->get('footerAdminForm');
            
            //Bind
            $object = new ArrayObject(array(
                    'content'  => $arrConfigFooter->content,                            
            ));
            $footerAdminForm->bind($object);
            
        }    
        
        $view->setVariables(array(
            'isXmlHttpRequest'  =>  $isXmlHttpRequest,
            'item'              =>  $item,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'myForm'            =>  $footerAdminForm,
        ));
        $view->setTerminal(true);
        return $view;


    }
    public function bannerAction()
    {
        $error     = array();
        //Tiêu đề
        $title      =  'Banner website';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        
        
        $bannerAdminForm       = $this->serviceLocator->get('FormElementManager')->get('bannerAdminForm');
            
        if($this->getRequest()->isPost()){
            $data   = $this->getRequest()->getPost();
            $bannerAdminForm->setData($data);

            if($bannerAdminForm->isValid() && empty($error)){
                
                $item           = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));
            
                $arrConfig  = \Zend\Json\Json::decode($item->config_banner);

                //Chống tấn công XSS
                $purifier   = new \HTMLPurifier_HTMLPurifier();

                $arrConfigBanner = array(
                    'banner'      => $arrConfig->banner,
                    'width'     =>  $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['width'])),
                    'height'    =>  $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['height'])),
                    'url'       =>  $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['url'])),
                );
                
                $data    =  array(
                    'id'            => 1, 
                    'config_banner'   => \Zend\Json\Json::encode($arrConfigBanner),
                );

                $this->getTable()->saveItem($data,array('task'=>'edit'));
                $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được lưu thành công');
                $this->redirect()->toUrl('/admin/skin/banner');
            }
        }
        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'myForm'            =>  $bannerAdminForm,
            'error'             =>  $error,
        ));
        
    }
    //Ajax load indexAction
    public function bannerAjaxAction(){
        $view               = new ViewModel();
        $dataItems          = null;
        $dataPaginator      = null;
        $isXmlHttpRequest   = false;

      
        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;

            $item                  = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));      

            $arrConfigBanner  = \Zend\Json\Json::decode($item->config_banner);

            $bannerAdminForm       = $this->serviceLocator->get('FormElementManager')->get('bannerAdminForm');
            
            //Bind
            $object = new ArrayObject(array(
                    'width'     => $arrConfigBanner->width, 
                    'height'    => $arrConfigBanner->height,
                    'url'       => $arrConfigBanner->url,                          
            ));
            $bannerAdminForm->bind($object);
            
        }    
        
        $view->setVariables(array(
            'isXmlHttpRequest'  =>  $isXmlHttpRequest,
            'item'              =>  $item,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'myForm'            =>  $bannerAdminForm,
        ));
        $view->setTerminal(true);
        return $view;


    }
    public function backgroundAction()
    {
        
        $error     = array();
        //Tiêu đề
        $title      =  'Thay đồi hình nền';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        
           
        if($this->getRequest()->isPost()){
           
            
            //Kiểm tra chọn select box
            if(empty($this->_arrPost['background'])){
                $error[]    = 'Bạn phải chọn hình nền!';
            }


            if(empty($error)){
                
                $item           = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));
            
                $arrConfig  = \Zend\Json\Json::decode($item->config_background);

                foreach ($arrConfig->listBackground as $key => $item) {
                    $arrBackground['listBackground'][] = array('name'=>$item->name,'type'=>$item->type);

                }

                $fixed_bg   = (!empty($this->_arrPost['fixed_bg'])) ? 'fixed' : '';
                $arrBackground['curentBackground'] =  array(
                        'background'    =>  str_replace("/public/upload/skin/", "", $this->_arrPost['background']),
                        'style'         =>  $fixed_bg,   
                );

               
                //Chống tấn công XSS
                $purifier   = new \HTMLPurifier_HTMLPurifier();

                
                $data    =  array(
                    'id'            => 1, 
                    'config_background'   => \Zend\Json\Json::encode($arrBackground),
                );

                $this->getTable()->saveItem($data,array('task'=>'edit'));
                $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được lưu thành công');
                $this->redirect()->toUrl('/admin/skin/background');
            }
        }
        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'error'             =>  $error,
        ));
        
    }
    //Ajax load indexAction
    public function backgroundAjaxAction(){
        $view               = new ViewModel();
        $dataItems          = null;
        $dataPaginator      = null;
        $isXmlHttpRequest   = false;

      
        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;

            $item                  = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));       
            
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
    //ajax upload avatar
    public function uploadAction(){
        $view               = new ViewModel();
        $dataItems          = null;
        $dataPaginator      = null;
        $isXmlHttpRequest   = false;

        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true; 
            if($this->getRequest()->isPost()){
                $upload = new \ZendVN\File\Upload();
                $upload->addValidator('Extension', true, array('png','jpg'), 'image' );
                $upload->addValidator ('Size', false, array('min' => '1kb','max' => '500kb'), 'image' );
                if($upload->isValid('image')){
                    //upload ảnh mới
                    $fileName = $upload->uploadFile('image', UPLOAD_PATH .'/skin/', array('task' => 'rename'), 'batdongsan_');
                    //Thực hiện xóa ảnh cũ
                    
                    $upload->removeFile(UPLOAD_PATH .'/skin/'.$this->_arrPost['image_hidden']);
                    $item                  = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));      

                    if($this->_arrPost['type_hidden'] == 'upload_logo'){
                        $configLogo  = \Zend\Json\Json::decode($item->config_logo);
                        $arrConfigLogo = array(
                            'slogan'=>$configLogo->slogan,
                            'logo'  => $fileName,
                        );    
                        //update database
                        $arrParam = array(
                            'id'            =>  1,
                            'config_logo'   =>  \Zend\Json\Json::encode($arrConfigLogo),
                        );
                    }

                    if($this->_arrPost['type_hidden'] == 'upload_banner'){
                        $configBanner  = \Zend\Json\Json::decode($item->config_banner);
                        $arrConfigBanner = array(
                            'banner'    => $fileName,
                            'width'     =>  $configBanner->width,
                            'height'    =>  $configBanner->height,
                            'url'       =>  $configBanner->url,
                        );    
                        //update database
                        $arrParam = array(
                            'id'            =>  1,
                            'config_banner'   =>  \Zend\Json\Json::encode($arrConfigBanner),
                        );
                    }
                    
                    $this->getTable()->saveItem($arrParam,array('task'=>'edit'));

                }else{
                    $fileName   = $this->_arrPost['image_hidden'];
                    $messages   = $upload->getMessages();
                    if(!empty($messages['fileExtensionFalse'])){
                        echo '<script>alert("Định dạng file không hợp lệ");</script>';
                    }if(!empty($messages['fileSizeTooBig'])){
                        echo '<script>alert("Kích thước file quá lớn");</script>';
                    }if(!empty($messages['fileSizeTooSmall'])){
                        echo '<script>alert("Kích thước file quá nhỏ");</script>';
                    } 
                }   
            }
        } 

        $view->setVariables(array(
            'isXmlHttpRequest'  =>  $isXmlHttpRequest,
            'fileName'          =>  $fileName,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
        ));
        $view->setTerminal(true);
        return $view;   
    }

    //ajax upload avatar
    public function uploadBackgroundAction(){
        $view               = new ViewModel();
        $dataItems          = null;
        $dataPaginator      = null;
        $isXmlHttpRequest   = false;

        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true; 
            if($this->getRequest()->isPost()){
                $upload = new \ZendVN\File\Upload();
                $upload->addValidator('Extension', true, array('png','jpg'), 'image' );
                $upload->addValidator ('Size', false, array('min' => '1kb','max' => '500kb'), 'image' );
                if($upload->isValid('image')){
                    //upload ảnh mới
                    $fileName = $upload->uploadFile('image', UPLOAD_PATH .'/skin/', array('task' => 'rename'), 'batdongsan_');
                    //Thực hiện xóa ảnh cũ
                    
                    $item           = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));
            
                    $arrConfig  = \Zend\Json\Json::decode($item->config_background);

                    foreach ($arrConfig->listBackground as $key => $item) {
                        $arrBackground['listBackground'][] = array('name'=>$item->name,'type'=>$item->type);
                    }

                    $arrBackground['listBackground'][] = array('name'=>$fileName,'type'=>'system');
                    $arrBackground['curentBackground'] =  array(
                            'background'    =>  $arrConfig->curentBackground->background,
                            'style'         =>  $arrConfig->curentBackground->style,   
                    );

                   
                    //Chống tấn công XSS
                    $purifier   = new \HTMLPurifier_HTMLPurifier();

                    
                    $arrParam    =  array(
                        'id'            => 1, 
                        'config_background'   => \Zend\Json\Json::encode($arrBackground),
                    );

                    
                    $this->getTable()->saveItem($arrParam,array('task'=>'edit'));

                }else{
                    $fileName   = $this->_arrPost['image_hidden'];
                    $messages   = $upload->getMessages();
                    if(!empty($messages['fileExtensionFalse'])){
                        echo '<script>alert("Định dạng file không hợp lệ");</script>';
                    }if(!empty($messages['fileSizeTooBig'])){
                        echo '<script>alert("Kích thước file quá lớn");</script>';
                    }if(!empty($messages['fileSizeTooSmall'])){
                        echo '<script>alert("Kích thước file quá nhỏ");</script>';
                    } 
                }   
            }
        } 

        $view->setVariables(array(
            'isXmlHttpRequest'  =>  $isXmlHttpRequest,
            'fileName'          =>  $fileName,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
        ));
        $view->setTerminal(true);
        return $view;   
    }
    
    
    
}

/*
$arrBackground = array(
            'listBackground'    => array(
                array('name'=>'Noel (1).png','type'=>'Events'),
                array('name'=>'Noel (2).png','type'=>'Events'),
                array('name'=>'Noel (3).png','type'=>'Events'),
                array('name'=>'Noel (4).jpg','type'=>'Events'),
                array('name'=>'Noel (5).gif','type'=>'Events'),
                array('name'=>'Noel (6).gif','type'=>'Events'),
                array('name'=>'Noel (7).gif','type'=>'Events'),
                array('name'=>'Noel (8).jpg','type'=>'Events'),
                array('name'=>'Noel (9).jpg','type'=>'Events'),
                array('name'=>'Quy Ty 2013 (1).jpg','type'=>'Events'),
                array('name'=>'Quy Ty 2013 (2).jpg','type'=>'Events'),
                array('name'=>'Quy Ty 2013 (3).jpg','type'=>'Events'),
                array('name'=>'Quy Ty 2013 (4).jpg','type'=>'Events'),
                array('name'=>'Quy Ty 2013 (5).jpg','type'=>'Events'),
                array('name'=>'Quy Ty 2013 (6).jpg','type'=>'Events'),
                array('name'=>'Quy Ty 2013 (7).jpg','type'=>'Events'),
                array('name'=>'Quy Ty 2013 (8).jpg','type'=>'Events'),
                array('name'=>'Quy Ty 2013 (9).png','type'=>'Events'),
                array('name'=>'Quy Ty 2013 (10).jpg','type'=>'Events'),
                array('name'=>'Quy Ty 2013 (11).jpg','type'=>'Events'),
                array('name'=>'Quy Ty 2013 (12).gif','type'=>'Events'),
                array('name'=>'trung_thu (1).jpg','type'=>'Events'),
                array('name'=>'trung_thu (2).jpg','type'=>'Events'),
                array('name'=>'trung_thu (3).jpg','type'=>'Events'),
                array('name'=>'trung_thu (4).jpg','type'=>'Events'),
                array('name'=>'BG-01-2014.jpg','type'=>'Tet_2014'),
                array('name'=>'BG-02-2014.jpg','type'=>'Tet_2014'),
                array('name'=>'BG-03-2014.jpg','type'=>'Tet_2014'),
                array('name'=>'BG-04-2014.jpg','type'=>'Tet_2014'),
                array('name'=>'BG-05-2014.jpg','type'=>'Tet_2014'),
                array('name'=>'BG-06-2014.jpg','type'=>'Tet_2014'),
                array('name'=>'BG-07-2014.jpg','type'=>'Tet_2014'),
                array('name'=>'BG-08-2014.jpg','type'=>'Tet_2014'),
                array('name'=>'Aqua Blue.jpg','type'=>'system'),
                array('name'=>'Baby (2).gif','type'=>'system'),
                array('name'=>'Baby (3).gif','type'=>'system'),
                array('name'=>'Baby.gif','type'=>'system'),
                array('name'=>'Bamboo Seamless.png','type'=>'system'),
                array('name'=>'Bricks (1).gif','type'=>'system'),
                array('name'=>'Bricks (2).gif','type'=>'system'),
                array('name'=>'Bricks (3).gif','type'=>'system'),
                array('name'=>'Bricks (4).gif','type'=>'system'),
                array('name'=>'Bricks (5).gif','type'=>'system'),
                array('name'=>'Bricks (6).gif','type'=>'system'),
                array('name'=>'Cloudy (1).gif','type'=>'system'),
                array('name'=>'Cloudy (2).gif','type'=>'system'),
                array('name'=>'Cloudy.jpg','type'=>'system'),
                array('name'=>'Embossed (1).gif','type'=>'system'),
                array('name'=>'Embossed (2).gif','type'=>'system'),
                array('name'=>'Embossed (3).gif','type'=>'system'),
                array('name'=>'Embossed (4).gif','type'=>'system'),
                array('name'=>'Embossed (5).gif','type'=>'system'),
                array('name'=>'Faux.png','type'=>'system'),
                array('name'=>'Ice (1).gif','type'=>'system'),
                array('name'=>'Ice (2).gif','type'=>'system'),
                array('name'=>'Ice (3).gif','type'=>'system'),
                array('name'=>'Ice (4).gif','type'=>'system'),
                array('name'=>'Light (1).gif','type'=>'system'),
                array('name'=>'Light (2).gif','type'=>'system'),
                array('name'=>'Light (3).gif','type'=>'system'),
                array('name'=>'Line (4).gif','type'=>'system'),
                array('name'=>'Line (5).gif','type'=>'system'),
                array('name'=>'Marble (1).gif','type'=>'system'),
                array('name'=>'Marble (2).gif','type'=>'system'),
                array('name'=>'Marble (3).gif','type'=>'system'),
                array('name'=>'Marble (4).gif','type'=>'system'),
                array('name'=>'Nature (2).gif','type'=>'system'),
                array('name'=>'Nature (3).gif','type'=>'system'),
                array('name'=>'Nature (4).gif','type'=>'system'),
                array('name'=>'Nature (5).gif','type'=>'system'),
                array('name'=>'Nature (6).gif','type'=>'system'),
                array('name'=>'Nature.gif','type'=>'system'),
                array('name'=>'Patterns (1).gif','type'=>'system'),
                array('name'=>'Patterns (2).gif','type'=>'system'),
                array('name'=>'Patterns (2).gif','type'=>'system'),
                array('name'=>'Patterns (3).gif','type'=>'system'),
                array('name'=>'Patterns (4).gif','type'=>'system'),
                array('name'=>'Spider.jpg','type'=>'system'),
                array('name'=>'Starry (1).gif','type'=>'system'),
                array('name'=>'Starry (2).gif','type'=>'system'),
                array('name'=>'Starry (3).gif','type'=>'system'),
                array('name'=>'Starry (4).gif','type'=>'system'),
                array('name'=>'Starry (5).gif','type'=>'system'),
                array('name'=>'Starry (6).gif','type'=>'system'),
                array('name'=>'Starry (7).gif','type'=>'system'),
                array('name'=>'Starry (8).gif','type'=>'system'),
                array('name'=>'Starry (9).gif','type'=>'system'),
                array('name'=>'Surfaces (1).gif','type'=>'system'),
                array('name'=>'Surfaces (2).gif','type'=>'system'),
                array('name'=>'Surfaces (3).gif','type'=>'system'),
                array('name'=>'Surfaces (4).gif','type'=>'system'),
                array('name'=>'Templates (2).gif','type'=>'system'),
                array('name'=>'Templates (3).gif','type'=>'system'),
                array('name'=>'Templates (4).gif','type'=>'system'),
                array('name'=>'Templates (5).gif','type'=>'system'),
                array('name'=>'Templates (6).gif','type'=>'system'),
                array('name'=>'Templates (7).gif','type'=>'system'),
                array('name'=>'Templates (8).gif','type'=>'system'),
                array('name'=>'Templates (9).gif','type'=>'system'),
                array('name'=>'Templates (10).gif','type'=>'system'),
                array('name'=>'Templates (11).gif','type'=>'system'),
                array('name'=>'Wood (1).jpg','type'=>'system'),
                array('name'=>'Wood (2).gif','type'=>'system'),


            ),
            'curentBackground'=> array(
                'background'    =>  'Noel (1).png',
                'style'         =>  'fixed',
            ),
             
        );

        echo $string = \Zend\Json\Json::encode($arrBackground);
        */