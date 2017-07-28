<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace User\Controller;
use Zend\EventManager\EventManagerInterface;
use ZendVN\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container as Container;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Validator\Db\RecordExists;
use Zend\Validator\Db\NoRecordExists;
use Zend\Stdlib\ArrayObject;


class RealEstateController extends ActionController
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
        'itemCountPerPage'  =>  5,
        'pageRange'         =>  4,

    );

    protected $_userTable;
    protected $_userGroupTable;

    public function getTable(){
        if(empty($this->_userTable)){
            $this->_userTable = $this->getServiceLocator()->get('User\Model\RealEstateTable');
        }
        return $this->_userTable;
    }
    public function getUserGroupTable(){
        if(empty($this->_userGroupTable)){
            $this->_userGroupTable = $this->getServiceLocator()->get('Admin\Model\UserGroupTable');
        }
        return $this->_userGroupTable;
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
                
                $ssFilter->col          = 'id';
                $ssFilter->order        = 'DESC';
            }
            if(empty($ssFilter->record)){
                $ssFilter->record   = 10;
            }
        	$this->_arrParam['ssFilter']['keywords'] 	        = $ssFilter->keywords;
        	$this->_arrParam['ssFilter']['sort'] 		        = $ssFilter->sort;
   	    	$this->_arrParam['ssFilter']['col'] 		        = $ssFilter->col;
        	$this->_arrParam['ssFilter']['order'] 		        = $ssFilter->order;
            $this->_arrParam['ssFilter']['record']              = $ssFilter->record;
            $this->_arrParam['ssFilter']['status']              = $ssFilter->status ;
            $this->_arrParam['ssFilter']['city']                = $ssFilter->city ;
            $this->_arrParam['ssFilter']['district']            = $ssFilter->district ;
            $this->_arrParam['ssFilter']['type_news']           = $ssFilter->type_news  ;
            $this->_arrParam['ssFilter']['type_transaction']    = $ssFilter->type_transaction ;
            $this->_arrParam['ssFilter']['type_real_estate']    = $ssFilter->type_real_estate ;
            $this->_arrParam['ssFilter']['date_start']          = $ssFilter->date_start ;
            $this->_arrParam['ssFilter']['date_end']            = $ssFilter->date_end ;

           
           
            $this->_paginatorParams['itemCountPerPage'] = (int) $ssFilter->record;
            $this->_paginatorParams['currentPageNumber']= $this->params()->fromRoute('page',1);
            $this->_arrParam['paginator']               = $this->_paginatorParams;


            $render     = $this->getServiceLocator()->get('Zend\View\Renderer\PhpRenderer');
            //headLink
            /*$headLink   = $render->headLink();
            $headLink->prependStylesheet(PUBLIC_URL   .'/scripts/uploadify-v3.1/css/uploadify.css');
            $headLink->prependStylesheet(TEMPLATE_URL .'/user/css/js-form.css');
            $headLink->prependStylesheet(TEMPLATE_URL .'/user/css/blocksui/osx.css');*/

            //headScript
            $headScript = $render->headScript();

            //$headScript->prependFile(TEMPLATE_URL .'/user/js/jquery.min.js', 'text/javascript');
            //$headScript->prependFile(TEMPLATE_URL .'/user/js/jquery.form.js', 'text/javascript');
            //$headScript->prependFile(TEMPLATE_URL .'/user/js/blocksui/jquery.simplemodal.js', 'text/javascript');
            //$headScript->prependFile(TEMPLATE_URL .'/user/js/blocksui/osx.js', 'text/javascript');
            //Load templates
           	$this->layout('layout/user');


        
    }

    public function indexAction()
    {
    	
        //Tiêu đề
    	$title      =  'Danh sách bất động sản';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        
        //Nested Menu Left
        $view       = new ViewModel();
        $view->setTemplate('user/real-estate/index');
       
        $menuLeft   = new ViewModel(array('nameMenu' => 'Trang thành viên'));
        $menuLeft->setTemplate('user/block/menuLeft');
        $view->addChild($menuLeft, 'menuLeft');
        
        $itemsTypeRealEstate    = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-type-real-estate'));
        $itemsCity              = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-city'));
        
        

        $view->setVariables(array(
            'title'                     =>  $title,
            'arrParam'                  =>  $this->_arrParam,
            'currentController'         =>  $this->_currentController,
            'itemsCity'                 =>  $itemsCity,
            'itemsTypeRealEstate'       =>  $itemsTypeRealEstate,
            
        ));
        return $view;
    	
    }

    //Ajax load indexAction
    public function listAction(){
        $view               = new ViewModel();
        $dataItems          = null;
        $dataPaginator      = null;
        $isXmlHttpRequest   = false;

        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;

            if($this->params()->fromQuery() == true){
                $option = $this->params()->fromQuery('option');
                if($option == 'order'){
                    $id     = $this->params()->fromQuery('id');
                    $value  = $this->params()->fromQuery('value');
                    $arrParam = array(
                        'id'    =>  $id,
                        'order' =>  $value,
                    );
                    $this->getTable()->saveItem($arrParam,array('task'=>'edit'));
                }

                $this->_arrParam['staffId']           = $this->params()->fromQuery('staffId');
                
                
               
            }

            
            $this->_arrParam['userId']  = $this->identity()->id;

            //Nếu là thành viên(chủ doanh nghiệp) parent = 0, sẽ tìm nhân viên
            if($this->identity()->parent == 0){
                $staffs         = $this->getTable()->getItem(array('id'=>$this->identity()->id),array('task'=>'staff')); 
                $staff = '';
                $i = 1;
                if(!empty($staffs)){
                    foreach($staffs as $value){
                        
                        if($i == 1){
                            $staff .= $value['id'];
                        }else{
                            $staff .= ','.$value['id'];
                        }
                        $i++;
                    }
                }

                $this->_arrParam['staff'] = $staff;
            }

            //Nếu là nhân viên
            if($this->identity()->parent != 0){
                //Tìm chủ doanh nghiệp
                $this->_arrParam['parent']  = $this->identity()->parent;
                //Lại tìm các nhân viên khác cùng cấp
                $staffs         = $this->getTable()->getItem(array('id'=>$this->_arrParam['parent']),array('task'=>'staff')); 
                $staff = '';
                $i = 1;
                if(!empty($staffs)){
                    foreach($staffs as $value){
                        
                        if($i == 1){
                            $staff .= $value['id'] .','.$this->_arrParam['parent'];
                        }else{
                            $staff .= ','.$value['id'];
                        }
                        $i++;
                    }
                }

                $this->_arrParam['staff'] = $staff;
            }
            $totalItem      = $this->getTable()->countItem($this->_arrParam);
            $items          = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-items-paginator'));
            $dataItems      = $items;
            $dataPaginator  = \ZendVN\Paginator\Paginator::createPaginator($totalItem,$this->_paginatorParams);
                

        }    
        
        $view->setVariables(array(
            'isXmlHttpRequest'  =>  $isXmlHttpRequest,
            'items'             =>  $dataItems,
            'paginator'         =>  $dataPaginator,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'totalItem'         =>  $totalItem,
        ));
        $view->setTerminal(true);
        return $view;


    }
    public function favoriteAction()
    {
        
        //Tiêu đề
        $title      =  'Bất động sản yêu thích';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        
        //Nested Menu Left
        $view       = new ViewModel();
       
        
        $this->_arrParam['userId']  = $this->identity()->id;

        $totalItem      = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-favorite'));
        
        
        $view->setVariables(array(
            'title'                     =>  $title,
            'arrParam'                  =>  $this->_arrParam,
            'currentController'         =>  $this->_currentController,
            'totalItem'                 =>  $totalItem,
            
            
        ));
        return $view;
        
    }
     //Ajax load indexAction
    public function favoriteAjaxAction(){
        $view               = new ViewModel();
        $dataItems          = null;
        $dataPaginator      = null;
        $isXmlHttpRequest   = false;

        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;

            if($this->params()->fromQuery() == true){
                $option = $this->params()->fromQuery('option');
                if($option == 'order'){
                    $id     = $this->params()->fromQuery('id');
                    $value  = $this->params()->fromQuery('value');
                    $arrParam = array(
                        'id'    =>  $id,
                        'order' =>  $value,
                    );
                    $this->getTable()->saveItem($arrParam,array('task'=>'edit'));
                }

                $this->_arrParam['userId']  = $this->identity()->id;
               
               
            }

            $totalItem      = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-favorite'));
            $items          = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-items-paginator-favorite'));
            $dataItems      = $items;
            $dataPaginator  = \ZendVN\Paginator\Paginator::createPaginator($totalItem,$this->_paginatorParams);
                

        }    
        
        $view->setVariables(array(
            'isXmlHttpRequest'  =>  $isXmlHttpRequest,
            'items'             =>  $dataItems,
            'paginator'         =>  $dataPaginator,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'totalItem'         =>  $totalItem,
        ));
        $view->setTerminal(true);
        return $view;


    }
     //Ajax load indexAction
    public function loadViewBdsAction(){
        $view               = new ViewModel();
        $dataItems          = null;
        $isXmlHttpRequest   = false;

        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;

            if($this->params()->fromQuery() == true){
               

                $this->_arrParam['real_estate_id']  = $this->params()->fromQuery('id');
                $this->_arrParam['date_time']       = $this->params()->fromQuery('date');
               
            }

            
            $dataItems          = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-view-bds'));
            
              

        }    
        
        $view->setVariables(array(
            'isXmlHttpRequest'  =>  $isXmlHttpRequest,
            'items'             =>  $dataItems,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            
        ));
        $view->setTerminal(true);
        return $view;


    }

     //Ajax load indexAction
    public function loadTransactionHistoryAction(){
        $view               = new ViewModel();
        $dataItems          = null;
        $isXmlHttpRequest   = false;

        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;

            if($this->params()->fromQuery() == true){
               

                $this->_arrParam['real_estate_id']  = $this->params()->fromQuery('id');
                
            }

            
            $dataItems          = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-TransactionHistory'));
            
              

        }    
        
        $view->setVariables(array(
            'isXmlHttpRequest'  =>  $isXmlHttpRequest,
            'items'             =>  $dataItems,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            
        ));
        $view->setTerminal(true);
        return $view;


    }
    public function addAction(){

        $error = array();
        //Tiêu đề
        $title      =  'Đăng tin bất động sản';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
        
        //Item select box
        $itemsTypeRealEstate  = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-type-real-estate'));
        $itemsCity            = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-city'));
        
        //Form
        $RealEstateForm       = $this->serviceLocator->get('FormElementManager')->get('RealEstateForm');

        //Nested Menu Left
        $view = new ViewModel();
        $view->setTemplate('user/real-estate/add');
       
        $menuLeft = new ViewModel(array('nameMenu' => 'Trang thành viên'));
        $menuLeft->setTemplate('user/block/menuLeft');
        $view->addChild($menuLeft, 'menuLeft');


        

        //Bind
        $object = new ArrayObject(array(
                'fullname'  => $this->identity()->fullname,                
                'phone'     => $this->identity()->phone,               
                'skype'     => $this->identity()->website,               
                'email'     => $this->identity()->email,              
        ));
        $RealEstateForm->bind($object);

        if($this->getRequest()->isPost()){
            
            $data = $this->getRequest()->getPost();


            $RealEstateForm->setData($data);

            //Kiểm tra chọn select box
            if(empty($this->_arrPost['type_real_estate'])){
                $error[]    = 'Bạn phải chọn loại Bất động sản!';
            }if(empty($this->_arrPost['city'])){
                $error[]    = 'Bạn phải chọn Thành phố!';
            }if(empty($this->_arrPost['district'])){
                $error[]    = 'Bạn phải chọn Quận huyện!';
            }

            //Upload File
            $jsonImage          = '';
            $arrFileName        = array();
            $upload             = new \ZendVN\File\Upload();
            $fileName           = $upload->getFileName();
            if(!empty($fileName)){
                if(!is_array($fileName)){
                    $arrFileName['image_0_']    = $fileName;
                }else{
                    $arrFileName                = $fileName;
                }     
                foreach($arrFileName as $key => $value){
                    $upload->addValidator('Extension', true, array('png','jpg'), $key );
                    $upload->addValidator ('Size', false, array('min' => '10kb','max' => '500kb'), $key );
                    if(!$upload->isValid($key)){
                        $messages   = $upload->getMessages();
                        if(!empty($messages['fileExtensionFalse'])){
                            $error[]    = 'Định dạng file không hợp lệ';
                        }if(!empty($messages['fileSizeTooBig'])){
                            $error[]    = 'Kích thước file quá lớn';
                        }if(!empty($messages['fileSizeTooSmall'])){
                            $error[]    = 'Kích thước file quá nhỏ';
                        } 
                    }else{
                        $arrImages[]= $upload->uploadFile($key, UPLOAD_PATH .'/real-estate/', array('task' => 'rename'), 'batdongsan_');          
                    }
                }
                $jsonImage          = \Zend\Json\Json::encode($arrImages);  
            }


            if($RealEstateForm->isValid() && empty($error)){


                //Lấy ngày hiện tại
                $date_start = date('d/m/Y');
                //Cộng thêm 7 ngày
                $date_end   = strtotime(date("d-m-Y", strtotime(date('d-m-Y'))) . " +7 day");
                $date_end   = strftime("%d/%m/%Y",$date_end);

                //Chống tấn công XSS
                $purifier   = new \HTMLPurifier_HTMLPurifier();
                $data       =  array(
                    'cat_id'        => $purifier->purify($this->_arrPost['type_real_estate_child']),
                    'title'         => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['title'])),
                    'content'       => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['content'])),
                    'images'        => $jsonImage,
                    'transaction'   => $purifier->purify($this->_arrPost['type_transaction']),
                    'area'          => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['area'])),
                    'price'         => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['price'])),
                    'price_m2'      => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['price_m2'])),
                    'price_display' => $purifier->purify($this->_arrPost['display_price']),
                    'direction'     => $purifier->purify($this->_arrPost['direction']),
                    'avenue'        => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['avenue'])),
                    'juridical'     => $purifier->purify($this->_arrPost['juridical']),
                    'floor'         => $purifier->purify($this->_arrPost['floor']),
                    'bedroom'       => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['bedroom'])),
                    'bathroom'      => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['bathroom'])),
                    'city'          => $purifier->purify($this->_arrPost['city']),
                    'district'      => $purifier->purify($this->_arrPost['district']),
                    'ward'          => $purifier->purify($this->_arrPost['ward']),
                    'project'       => $purifier->purify($this->_arrPost['project_bds']),
                    'numberhouse'   => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['numberhouse'])),
                    'nameavenue'    => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['nameavenue'])),
                    'user_id'       => $this->identity()->id,
                    'latitude_gmap' => $purifier->purify($this->_arrPost['latitude']),
                    'longitude_gmap'=> $purifier->purify($this->_arrPost['longitude']),
                    'date_modifi'   => $date_start,
                    'date_start'    => $date_start,
                    'date_end'      => $date_end,
                );

                
                $id = $this->getTable()->saveItem($data,array('task'=>'add'));
                
                //Gửi tin bất động sản phù hợp tới người đăng kí email
                $this->sendRealEstateToEmail($id);

                $this->redirect()->toUrl('/user/real-estate/active/'.$id);
            
            }
        }


        $view->setVariables(array(
            'arrParam'                  =>  $this->_arrParam,
            'currentController'         =>  $this->_currentController,
            'myForm'                    =>  $RealEstateForm ,
            'itemsTypeRealEstate'       =>  $itemsTypeRealEstate,
            'itemsCity'                 =>  $itemsCity,
            'error'                     =>  $error,
        ));

        return $view;

    }
    public function editAction(){
        $error = array();
        //Tiêu đề
        $title      =  'Sửa tin bất động sản';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
        
        //Item select box
        $itemsTypeRealEstate  = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-type-real-estate'));
        $itemsCity            = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-city'));
        
        

        //Nested Menu Left
        $view = new ViewModel();
        $view->setTemplate('user/real-estate/edit');
       
        $menuLeft = new ViewModel(array('nameMenu' => 'Trang thành viên'));
        $menuLeft->setTemplate('user/block/menuLeft');
        $view->addChild($menuLeft, 'menuLeft');

        $item           = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));

        //Bind
        $RealEstateForm       = $this->serviceLocator->get('FormElementManager')->get('RealEstateForm');
        $RealEstateForm->setInputFilter(new \User\Form\RealEstateFilter(array('task'=>'edit', 'id'=>$this->_arrParam['id'])));
        $RealEstateForm->bind($item);
        $object = new ArrayObject(array(
                'fullname'  => $this->identity()->fullname,                
                'phone'     => $this->identity()->phone,               
                'skype'     => $this->identity()->website,               
                'email'     => $this->identity()->email,              
        ));
        $RealEstateForm->bind($object);

        //find parent Cat
        $parentCat        = $this->getTable()->getItem($item->cat_id,array('task'=>'get-item-find-parent-cat'));

        if($this->getRequest()->isPost()){
            
            $data = $this->getRequest()->getPost();
            $RealEstateForm->setData($data);
            
            //Kiểm tra chọn select box
            if(empty($this->_arrPost['type_real_estate'])){
                $error[]    = 'Bạn phải chọn loại Bất động sản!';
            }if(empty($this->_arrPost['city'])){
                $error[]    = 'Bạn phải chọn Thành phố!';
            }if(empty($this->_arrPost['district'])){
                $error[]    = 'Bạn phải chọn Quận huyện!';
            }
                
             
                    
            if($RealEstateForm->isValid() && empty($error)){
                //Lấy ngày hiện tại
                $date_start = date('d/m/Y');
                //Cộng thêm 7 ngày
                $date_end   = strtotime(date("d-m-Y", strtotime(date('d-m-Y'))) . " +7 day");
                $date_end   = strftime("%d/%m/%Y",$date_end); 

                //Chống tấn công XSS
                $purifier   = new \HTMLPurifier_HTMLPurifier();
                $data       =  array(
                    'id'            => $purifier->purify($this->_arrPost['id']), 
                    'cat_id'        => $purifier->purify($this->_arrPost['type_real_estate_child']),
                    'title'         => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['title'])),
                    'content'       => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['content'])),
                    'transaction'   => $purifier->purify($this->_arrPost['type_transaction']),
                    'area'          => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['area'])),
                    'price'         => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['price'])),
                    'price_m2'      => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['price_m2'])),
                    'price_display' => $purifier->purify($this->_arrPost['display_price']),
                    'direction'     => $purifier->purify($this->_arrPost['direction']),
                    'avenue'        => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['avenue'])),
                    'juridical'     => $purifier->purify($this->_arrPost['juridical']),
                    'floor'         => $purifier->purify($this->_arrPost['floor']),
                    'bedroom'       => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['bedroom'])),
                    'bathroom'      => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['bathroom'])),
                    'city'          => $purifier->purify($this->_arrPost['city']),
                    'district'      => $purifier->purify($this->_arrPost['district']),
                    'ward'          => $purifier->purify($this->_arrPost['ward']),
                    'project'       => $purifier->purify($this->_arrPost['project_bds']),
                    'numberhouse'   => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['numberhouse'])),
                    'nameavenue'    => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['nameavenue'])),
                    'user_id'       => $this->identity()->id,
                    'latitude_gmap' => $purifier->purify($this->_arrPost['latitude']),
                    'longitude_gmap'=> $purifier->purify($this->_arrPost['longitude']),
                    'date_modifi'   => $date_start,
                    /*'type_news'     => 1,
                    'date_start'    => $date_start,
                    'date_end'      => $date_end,*/
                );

               
                $this->getTable()->saveItem($data,array('task'=>'edit'));
                
                $this->redirect()->toUrl('/user/real-estate/active/');
            
            }
        }
       
                    

        $view->setVariables(array(
            'arrParam'                  =>  $this->_arrParam,
            'currentController'         =>  $this->_currentController,
            'myForm'                    =>  $RealEstateForm ,
            'itemsTypeRealEstate'       =>  $itemsTypeRealEstate,
            'itemsCity'                 =>  $itemsCity,
            'error'                     =>  $error,
            'item'                      =>  $item,
            'parentCat'                 =>  $parentCat,
        ));

        return $view;

    }
      //Upload ảnh sản phẩm
      //Upload ảnh sản phẩm
    public function uploadifyDbAction(){
        $result = array();
        if($this->getRequest()->isPost()){
            if(!empty($_FILES)){


                //Upload File
                $upload             = new \ZendVN\File\Upload();
                $fileName           = $upload->getFileName();
                if(!empty($fileName)){
                    $upload->addValidator('Extension', true, array('png','jpg'),'Filedata');
                    $upload->addValidator ('Size', false, array('min' => '10kb','max' => '500kb'), 'Filedata');
                    if(!$upload->isValid('Filedata')){
                        $result['status']   = 'error';
                        $messages           = $upload->getMessages();
                        if(!empty($messages['fileExtensionFalse'])){
                            $result['messages']['upload']    = 'Định dạng file không hợp lệ';
                        }if(!empty($messages['fileSizeTooBig'])){
                             $result['messages']['upload']   = 'Kích thước file quá lớn';
                        }if(!empty($messages['fileSizeTooSmall'])){
                             $result['messages']['upload']   = 'Kích thước file quá nhỏ';
                        } 
                    }else{
                        $filename           = $upload->uploadFile('Filedata', UPLOAD_PATH .'/real-estate/', array('task' => 'rename'), 'batdongsan_');          
                        $item               = $this->getTable()->getItem($this->_arrPost,array('task'=>'get-item'));

                        //Mảng hình ảnh lấy từ database
                        $Imgdata            = \Zend\Json\Json::decode($item->images);

                        // mảng chưa file upload hiện tại
                        $newValue           = array();
                        $newValue[]         = $filename;

                        //Gộp 2 mảng 
                        if(!empty($Imgdata)){
                            $newValue       = array_merge($newValue,$Imgdata);
                        }
                        //mảng chứa chuỗi json hình ảnh
                        $arrParam['id']     = $this->_arrPost['id'];
                        $arrParam['images'] = \Zend\Json\Json::encode($newValue);

                        //Cập nhật hình ảnh vào database
                        $this->getTable()->saveItem($arrParam,array('task'=>'edit'));
                        $result['status']   = 'success';
                        $result['messages']['upload'] = 'Thành công';
                    }
                }               
            }
        }
        echo \Zend\Json\Json::encode($result);      
        return $this->getResponse();   
    }
     //Xóa ảnh
    public function deleteImgAction(){
        if($this->getRequest()->isPost()){ 
            $item       = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));

            //Mảng hình ảnh lấy từ database
            $Imgdata    = \Zend\Json\Json::decode($item->images);

            //lấy ra hình ảnh được chọn
            $check      = $this->_arrPost["check"];

            foreach($check as $key=>$val){
                $check  = $this->_arrPost["check"][$key];
                //--------------xóa file ảnh  ----------------------
                $upload = new \ZendVN\File\Upload();
                   
                $upload->removeFile(UPLOAD_PATH .'/real-estate/'.$Imgdata[$check]);
                   
                //Xỏa ảnh ra khỏi mảng
                unset($Imgdata[$check]);
                $arrParam['id']     = $this->_arrParam['id']; 
                $arrParam['images'] = \Zend\Json\Json::encode($Imgdata);

                //Cập nhật hình ảnh vào database
                $this->getTable()->saveItem($arrParam,array('task'=>'edit'));
            }



            $flagType = 'success';
            $reponse['type'] = $flagType;
            echo \Zend\Json\Json::encode($reponse);
            
        }
        
        return $this->getResponse();   
    }   


    public function successAction(){
        $view               = new ViewModel();
        $dataItems          = null;
        $dataPaginator      = null;
        $isXmlHttpRequest   = false;

        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;
            $arrParam['id']   = $this->params()->fromQuery('id');
            $item    = $this->getTable()->getItem($arrParam,array('task'=>'get-item'));
        }    
        $view->setVariables(array(
            'arrParam'                  =>  $this->_arrParam,
            'currentController'         =>  $this->_currentController,
            'item'                      =>  $item, 
        ));

        $view->setTerminal(true);
        return $view;
    }
    public function activeAction(){
        $error      = array();
        $title      =  'Kích hoạt tin > Thêm mới';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        $view       = new ViewModel();
        
        //danh sách loại tin
        $listItemTypeNews           = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-type-news'));
        
        //Thông tin dịch vụ tài khoản cao cấp
        $itemStatisticService       = $this->getTable()->getItem($this->identity()->id,array('task'=>'get-item-statistic-service'));
        if(!empty($itemStatisticService)){
            $infoAccountService = \Zend\Json\Json::decode($itemStatisticService['info_service_account']);
           
                $normal             = $infoAccountService->normal;
                $vip                = $infoAccountService->vip;
                $hot                = $infoAccountService->hot;
                $free               = $infoAccountService->free;
                $chinhchu           = $infoAccountService->chinhchu;
                $date_start         = $infoAccountService->date_start;
                $date_end           = $infoAccountService->date_end;
                $service_account    = $infoAccountService->service_account;
        }
                    
        $item       = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));



        if($this->getRequest()->isPost()){
            //Kiểm tra chọn select box
            if(empty($this->_arrPost['sltEventType'])){
                $error[]    = 'Bạn phải chọn loại tin!';
            }if(empty($this->_arrPost['txtEndDate'])){
                $error[]    = 'Ngày hết hạn không được trống!';
                $validator = new \Zend\Validator\Date(array('format' => 'dd/MM/yyyy'));
                if(!$validator->isValid($this->_arrPost['txtEndDate'])){
                    $error[]    = 'Ngày hết hạn không hợp lệ!';
                }
            }

            //Kiểm tra  thời hạn sử dụng tài khoản cao cấp
            if($date_end != 'Vô hạn'){
                $hansudung = explode("-",$date_end);
                //tính số ngày còn lại sử dụng dịch vụ
               
                $month  = !empty($hansudung[1]) ? $hansudung[1] : '';
                $day    = !empty($hansudung[0]) ? $hansudung[0] : '';
                $year   = !empty($hansudung[2]) ? $hansudung[2] : '';
                $remain = ceil((mktime(0,0,0,$month,$day,$year) - time()) / 86400);
                if($remain <= 0){
                    $error[]    = $service_account. ' của bạn đã hết hạn sử dụng!';
                }    
            }

            //Kiểm tra xem số tin kích hoạt nếu hết tin thì không cho kích hoạt loại tin đó
            //Tin miễn phí
            if($this->_arrPost['sltEventType'] == 1){
                if($free == 0){
                    $error[]    = 'Bạn đã hết tin Miễn phí để kích hoạt!';
                }
                $free = $free - 1;//sau khi kích hoạt tin trừ đi 1 lần kích hoạt
            }
            //Tin Thường
            if($this->_arrPost['sltEventType'] == 2){
                if($normal == 0){
                    $error[]    = 'Bạn đã hết tin Thường để kích hoạt!';
                }
                $normal = $normal - 1;//sau khi kích hoạt tin trừ đi 1 lần kích hoạt
            }
            //Tin VIP
            if($this->_arrPost['sltEventType'] == 3){
                if($vip == 0){
                    $error[]    = 'Bạn đã hết tin VIP để kích hoạt!';
                }
                $vip = $vip - 1;//sau khi kích hoạt tin trừ đi 1 lần kích hoạt
            }
            //Tin HOT
            if($this->_arrPost['sltEventType'] == 4){
                if($hot == 0){
                    $error[]    = 'Bạn đã hết tin HOT để kích hoạt!';
                }
                $hot = $hot - 1;//sau khi kích hoạt tin trừ đi 1 lần kích hoạt
            }
            //Tin Chính chủ
            if($this->_arrPost['sltEventType'] == 5){
                if($chinhchu == 0){
                    $error[]    = 'Bạn đã hết tin Chính Chủ để kích hoạt!';
                }
                $chinhchu = $chinhchu - 1;//sau khi kích hoạt tin trừ đi 1 lần kích hoạt
            }
            
            

            if(empty($error)){
                //cập nhật trạng thái
                $data = array(
                    'id'        =>  $this->_arrPost['id'],
                    'status'    =>  5,
                    'type_news' =>  $this->_arrPost['sltEventType'],
                    'date_end'  =>  $this->_arrPost['txtEndDate']
                );
                $this->getTable()->saveItem($data,array('task'=>'edit'));

                //lưu lịch sử giao dịch
                $dataHitory = array(
                    'service_id'    =>  $this->_arrPost['id'],
                    'type_news'     =>  $this->_arrPost['sltEventType'],
                    'user_id'       =>  $this->identity()->id,
                    'date_time'     =>  date('d/m/Y h:i:s')
                );
                $this->getTable()->saveItem($dataHitory,array('task'=>'save-history-transaction'));

            
                //Cập nhật lại số tin đã dùng
                $array = array(
                    'service_account'=>$service_account,
                    'normal'    =>$normal,
                    'vip'       =>$vip,
                    'hot'       =>$hot,
                    'free'      =>$free,
                    'chinhchu'  =>$chinhchu,
                    'date_start'=>$date_start,
                    'date_end'  =>$date_end
                    );
                $infoServiceAccountJson = \Zend\Json\Json::encode($array);
                $dataUser = array(
                    'id'                    =>  $this->identity()->id,
                    'info_service_account'  =>  $infoServiceAccountJson,
                );

                $this->getTable()->saveItem($dataUser,array('task'=>'update-info-user'));

                $this->redirect()->toUrl('/user/real-estate/');
            }

        }    
        $view->setVariables(array(
            'arrParam'                  =>  $this->_arrParam,
            'currentController'         =>  $this->_currentController,
            'item'                      =>  $item,
            'error'                     =>  $error,
            'listItemTypeNews'          =>  $listItemTypeNews,
        ));

        return $view;

    }

    //Tin được làm mới ngày đăng, và không thay đổi ngày hết hạn tính từ ngày kích hoạt
    public function refreshAction(){
        if(!empty($this->_arrParam['id'])){
            $filter     = new \Zend\Filter\Digits();
            $id         = $filter->filter($this->_arrParam['id']);
            $arrParam   = array('id'=>$id,'status'=>1,'date_modifi'=>date('d/m/Y'),'type_news'=>'','date_start'=>date('d/m/Y'));
            $this->getTable()->saveItem($arrParam,array('task'=>'edit'));
            $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được cập nhật thành công');
        }
        $this->redirect()->toUrl('/user/real-estate/');    
        return $this->getResponse();
    }
    //Tin sẽ ngừng giao dịch
    public function untradeableAction(){
        if(!empty($this->_arrParam['id'])){
            $filter     = new \Zend\Filter\Digits();
            $id         = $filter->filter($this->_arrParam['id']);
            $arrParam   = array('id'=>$id,'status'=>3);
            $this->getTable()->saveItem($arrParam,array('task'=>'edit'));
            $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được cập nhật thành công');
        }
        $this->redirect()->toUrl('/user/real-estate/');    
        return $this->getResponse();
    }
    //Tin sẽ xóa khỏi danh sách
    public function deleteAction(){
        if(!empty($this->_arrParam['id'])){
            $filter   = new \Zend\Filter\Digits();
            $id       = $filter->filter($this->_arrParam['id']);
            $arrParam = array('id'=>$id);
            $item = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));
            
            $upload = new \ZendVN\File\Upload();
            $images = \Zend\Json\Json::decode($item->images);
            if(!empty($images)){
                foreach($images as $image){
                    $upload->removeFile(UPLOAD_PATH .'/real-estate/'.$image);
                }      
            }

            $this->getTable()->deleteItem($arrParam,array('task'=>'delete-item'));
            $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được xóa thành công');
            
        }
        $this->redirect()->toUrl('/user/real-estate/');
        return $this->getResponse();    
    }
    //Tin sẽ xóa khỏi danh sách
    public function deleteFavoriteAction(){
        if(!empty($this->_arrParam['id'])){
            $filter   = new \Zend\Filter\Digits();
            $id       = $filter->filter($this->_arrParam['id']);
            $arrParam = array($id);
           

            $this->getTable()->deleteItem($arrParam,array('task'=>'delete-item-favorite'));
            $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được xóa thành công');
            
        }
        $this->redirect()->toUrl('/user/real-estate/favorite/');
        return $this->getResponse();    
    }
    public function filterAction(){
        $ssFilter   = new Container($this->_namespace);
        $purifier   = new \HTMLPurifier_HTMLPurifier();
        if($this->_arrParam['type'] == 'search'){
            if($this->_arrParam['col'] == 'null' && $this->_arrParam['by'] == 'null' && $this->_arrParam['key'] == 1){
                if($this->params()->fromPost('keywords') != ''){
                    $ssFilter->keywords = $this->params()->fromPost('keywords');
                }
                $ssFilter->status           = $this->params()->fromPost('status');
                $ssFilter->city             = $this->params()->fromPost('city');
                $ssFilter->district         = $this->params()->fromPost('district');
                $ssFilter->type_news        = $this->params()->fromPost('type_news');
                $ssFilter->type_transaction = $this->params()->fromPost('type_transaction');
                $ssFilter->type_real_estate = $this->params()->fromPost('type_real_estate');
                $ssFilter->date_start       = $this->params()->fromPost('date_start');
                $ssFilter->date_end         = $this->params()->fromPost('date_end');
                
            }if($this->_arrParam['col'] == 'null' && $this->_arrParam['by'] == 'null' && $this->_arrParam['key'] == 0){
                $ssFilter->getManager()->getStorage()->clear($this->_namespace);
            }
        }

       
        if($this->_arrParam['type'] == 'record'){
            $ssFilter->record   = $this->params()->fromPost('record');

        }
        
        $this->redirect()->toUrl('/user/real-estate/');
        return $this->getResponse();   
    }


    public function loadSelectTypeRealEstateAction(){
        $view               = new ViewModel();
        $isXmlHttpRequest   = false;
        $data               = null;
        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;
            $itemsRealEstateChild  = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-item-type-real-estate-child'));
            $tyleLand = $this->params()->fromQuery('type');
            foreach($itemsRealEstateChild as $key=>$value){
                if($value['parent'] == $tyleLand) $data[] = $value;
            }  
        }    
        $view->setVariables(array(
            'isXmlHttpRequest'  =>  $isXmlHttpRequest,
            'data'              =>  $data,
        ));
        $view->setTerminal(true);
        return $view;
    }
    

    public function loadSelectDistrictAction(){
        $view               = new ViewModel();
        $isXmlHttpRequest   = false;
        $data               = null;
        $currentDistrict    = null;
        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;
            
            $itemsDistrict  = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-item-district'));
            $city = $this->params()->fromQuery('city');
            foreach($itemsDistrict as $key=>$value){
                if($value['city_id'] == $city) $data[] = $value;
            }
            if($this->params()->fromQuery('currentDistrict') != ''){
                $currentDistrict = $this->params()->fromQuery('currentDistrict');
            }  
        }    
        $view->setVariables(array(
            'isXmlHttpRequest'  =>  $isXmlHttpRequest,
            'data'              =>  $data,
            'currentDistrict'   =>  $currentDistrict,
        ));
        $view->setTerminal(true);
        return $view;
    }
    public function loadSelectWardAction(){
        $view               = new ViewModel();
        $isXmlHttpRequest   = false;
        $data               = null;
        $currentWard        = null;
        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;
            $itemsWard  = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-item-ward'));

            $district   = $this->params()->fromQuery('district');
            foreach($itemsWard as $key=>$value){
                if($value['district_id'] == $district) $data[] = $value;
            }
            if($this->params()->fromQuery('currentWard') != ''){
                $currentWard = $this->params()->fromQuery('currentWard');
            }    
        }    
        $view->setVariables(array(
            'isXmlHttpRequest'  =>  $isXmlHttpRequest,
            'data'              =>  $data,
            'currentWard'       =>  $currentWard,
        ));
        $view->setTerminal(true);
        return $view;

    }
   public function loadSelectProjectAction(){
        $view               = new ViewModel();
        $isXmlHttpRequest   = false;
        $data               = null;
        $currentProject     = null;
        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;
            $itemsProject   = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-item-project'));
            $district       = $this->params()->fromQuery('district');
            foreach($itemsProject as $key=>$value){
                if($value['district'] == $district) $data[] = $value;
            }
            if($this->params()->fromQuery('currentProject') != ''){
                $currentProject = $this->params()->fromQuery('currentProject');
            }   
        }    
        $view->setVariables(array(
            'isXmlHttpRequest'  =>  $isXmlHttpRequest,
            'data'              =>  $data,
            'currentProject'    =>  $currentProject,
        ));
        $view->setTerminal(true);
        return $view;

    }

    //Gửi tin bất động sản phù hợp tới người đã đăng kí nhận email
    protected function sendRealEstateToEmail($realEstateId){
        //Tin bất động sản vừa đăng
        $RealEstateTable    = $this->getServiceLocator()->get('Home\Model\RealEstateTable');
        $item               = $RealEstateTable->getItem(array('id'=>$realEstateId));
        

        //Danh sách email
        $listItemEmailRegister   = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-register-email'));
        
        foreach ($listItemEmailRegister as $key => $value) {

            if($item['transaction']   == $value['transaction'] 
                && $item['cat_id']    == $value['cat_id']
                && $item['city']      == $value['city']
                && $item['district']  == $value['district']
                && $item['area']      == $value['area']
                && $item['avenue']    == $value['road']
                && $item['direction'] == $value['direction']
                && $item['juridical'] == $value['juridical']
            ){
                if($value['pricefrom'] <= $item['price'] && $item['price'] <= $value['priceto']){
                    $id             = $item['id'];
                    $title          = $item['title'];
                    $name_city      = $item['name_city'];
                    $name_district  = $item['name_district'];
                    $name_ward      = $item['name_ward'];
                    $adress         = $name_ward .' - ' .$name_district .' - '.$name_city;
                    $date_start     = $item['date_start'];
                    $content        = $item['content'];
                    $fullname       = $item['fullname'];
                    $phone          = $item['phone'];
                    $name_type      = $item['name_type'];

                    $date_start     = $item['date_start'];
                    $date_end       = $item['date_end'];
                    $date_modifi    = $item['date_modifi'];
                    $name_project   = $item['name_project'];
                    $floor          = $item['floor'];
                    $bedroom        = $item['bedroom'];
                    $bathroom       = $item['bathroom'];
                    $direction      = $item['direction'];
                    $area           = $item['area'];
                    $type_news      = $item['type_news'];
                    $status         = $item['status'];
                    $cat_id         = $item['cat_id'];
                    $avenue         = (!empty($item['avenue'])) ? $item['avenue'] : 'Chưa cập nhật';
                    $name_juridical = (!empty($item['name_juridical'])) ? $item['name_juridical'] : 'Chưa cập nhật';
                    $direction      = (!empty($item['direction'])) ? $item['direction'] : 'Chưa cập nhật';
                    $bedroom        = (!empty($item['bedroom'])) ? $item['bedroom'] : 'Chưa cập nhật';
                    $bathroom       = (!empty($item['bathroom'])) ? $item['bathroom'] : 'Chưa cập nhật';
                    $floor          = (!empty($item['floor'])) ? $item['floor'] : 'Chưa cập nhật';
                    $content    =  '<h2>'.$item['title'].'</h2><br>';
                    $content    .=  '<ul class="basicInfo" style="display: block;">
                                    <li><span>Địa chỉ:</span><span>'.$adress.'</span></li>
                                    <li><span>Loại BĐS:</span><span>'.$name_type.'</span></li>
                                    <li><span>Giá:</span><span>'.\ZendVN\Convert\Price::convert($item['price']).'</span></li>
                                    <li><span>Diện tích:</span><span>'. $area.' m<sup>2</sup> ( Lộ giới: '. $avenue.' m)</span></li>
                                    <li><span>Pháp lý:</span><span>'. $name_juridical.'</span></li>
                                    <li><span>Hướng:</span><span>'. $direction .'</span></li>
                                    <li><span>Phòng ốc:</span><span><span>'.$bedroom.' PN | '. $bathroom.' WC </span> </span></li>
                                    <li><span>Số tầng:</span><span>'.$floor.'> </span></li>
                                    <li><span>Đường trước nhà:</span><span>'. $avenue.' m</span></li>
                                    <li><span>Mã BĐS:</span><span>'. $id.'</span></li>      
                                    <li><span>Ngày đăng:</span><span>'.$date_start.'</span></li>
                                    <li><span>Ngày hết hạn:</span><span>'. $date_end.'</span></li>
                                    <li><span>ID:</span><span>'. $id.'</span></li>
                                    </ul><br>';
                    
                    $content    .= '====================================================<br>';
                    $content    .= 'Liên hệ '.$fullname .' ('.$phone.')<br>'; 
                    $content    .= '====================================================<br>';                                             
                    $content    .= $item['content'];

                    //Gửi email
                    $mailService = $this->getServiceLocator()->get('AcMailer\Service\MailService');
                    $mailService->setSubject($value['name'])
                                ->setBody($content); // This can be a string, HTML or even a zend\Mime\Message or a Zend\Mime\Part
                    
                    $message = $mailService->getMessage();
                    $message->addTo($value['email']);
                                
                    $result = $mailService->send();
                    if ($result->isValid()) {
                        $messages =  'Message sent. Congratulations!';
                    } else {
                        if ($result->hasException()) {
                            $messages = sprintf('An error occurred. Exception: \n %s', $result->getException()->getTraceAsString());
                        } else {
                            $messages = sprintf('An error occurred. Message: %s', $result->getMessage());
                        }
                    }
                }
                
            }
            
        }
    }

    
    
    
}
