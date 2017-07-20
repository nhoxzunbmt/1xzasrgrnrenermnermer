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
class BusinessController extends ActionController
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

    protected $_businessTable;
    protected $_userGroupTable;

    public function getTable(){
        if(empty($this->_businessTable)){
            $this->_businessTable = $this->getServiceLocator()->get('User\Model\BusinessTable');
        }
        return $this->_businessTable;
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
           	$this->layout('layout/user');


    }

    public function indexAction()
    {
    	//Tiêu đề
    	$title      =  'Thông tin doanh nghiệp';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        
        $this->_arrParam['alias'] = $this->identity()->username;
        $item           = $this->getTable()->getItem($this->_arrParam);

        //Chưa có trang doanh nghiệp chuyến tới mục khởi tạo trang doanh nghiệp
        if(empty($item)){
            $this->redirect()->toUrl('/user/business/add/');
        }

        $this->_arrParam['alias'] = $this->identity()->username;
        $item           = $this->getTable()->getItem($this->_arrParam);
       
       
        
        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'item'              =>  $item,
            'currentController' =>  $this->_currentController,
        ));
    	
    }
   

    public function addAction(){
        $error          = array();
        //Tiêu đề
        $title          =  'Doanh nghiệp BĐS > Tạo doanh nghiệp';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        
        //kiểm tra xem thành viên đã tạo trang doanh nghiệp chưa
        //1 thành viên chỉ được tạo duy nhất 1 trang doanh nghiệp

        $this->_arrParam['alias'] = $this->identity()->username;
        $item           = $this->getTable()->getItem($this->_arrParam);

        //Mỗi thành viên chỉ được tạo duy nhất 1 trang doanh nghiệp
        if(!empty($item)){
            $this->redirect()->toUrl('/user/business/');
        }

        //Thành viên có parent khác 0(tức là nhân viên của thành viên khac) không khởi tạo được trang doanh nghiệp
        if($this->identity()->parent != 0){
            $this->redirect()->toUrl('/user/account/');
        }
        
        $businessForm       = $this->serviceLocator->get('FormElementManager')->get('businessUserForm');
        
        //list city
        $itemsCity          = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-city'));
        
        //loại hình doanh nghiệp
        $itemsTypeBusinesss =   $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-type-business'));
        //Bind
        $object = new ArrayObject(array(
                'name'      => $this->identity()->fullname,                
                'alias'     => $this->identity()->username,                            
        ));
        $businessForm->bind($object);
        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
            $businessForm->setData($data);


            //Kiểm tra chọn select box
            if(empty($this->_arrPost['city'])){
                $error[]    = 'Bạn phải chọn thông tin Thành phố của doanh nghiệp!';
            }if(empty($this->_arrPost['district'])){
                $error[]    = 'Bạn phải chọn thông tin Quận huyện của doanh nghiệp!';
            }if(empty($this->_arrPost['type_business'])){
                $error[]    = 'Bạn phải chọn thông tin loại hình doanh nghiệp!';
            }

            //Upload 
            $logo     = '';
            $upload     = new \ZendVN\File\Upload();
            $fileName   = $upload->getFileName();
            if(!empty($fileName)){
                $upload->addValidator('Extension', true, array('png','jpg'), 'image' );
                $upload->addValidator ('Size', false, array('min' => '1kb','max' => '500kb'), 'image' );
                if(!$upload->isValid('image')){
                    $messages   = $upload->getMessages();
                    if(!empty($messages['fileExtensionFalse'])){
                        $error[]    = 'Định dạng file không hợp lệ!';
                    }if(!empty($messages['fileSizeTooBig'])){
                        $error[]    = 'Kích thước file quá lớn!';
                    }if(!empty($messages['fileSizeTooSmall'])){
                        $error[]    = 'Kích thước file quá nhỏ!';
                    } 
                }else{
                    //upload ảnh mới
                    $logo = $upload->uploadFile('image', UPLOAD_PATH .'/logo-business/', array('task' => 'rename'), 'batdongsan_');
                }
            } 

            if($businessForm->isValid() && empty($error)){
               
                    
                    //Chống tấn công XSS
                    $purifier   = new \HTMLPurifier_HTMLPurifier();
                    $data    =  array(
                        'type_business' =>  $purifier->purify($this->_arrPost['type_business']),
                        'name'          => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['name'])),
                        'alias'         => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['alias'])),
                        'logo'          => $logo,
                        'address'       => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['address'])),
                        'city'          => $purifier->purify($this->_arrPost['city']),
                        'district'      => $purifier->purify($this->_arrPost['district']),
                        'ward'          => $purifier->purify($this->_arrPost['ward']),
                        'phone'         => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['phone'])),
                        'fax'           => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['fax'])),
                        'website'       => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['website'])),
                        'intro'         => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['intro'])),
                        'contact'       => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['contact'])),
                        'department'    => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['department'])),
                        'date_time'     => date('d/m/y h:i:s'),
                    );
                    $this->getTable()->saveItem($data,array('task'=>'add'));
                    $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được lưu thành công');
                    $this->redirect()->toUrl('/user/business/');
            }else{
                //echo '<pre>';
                //print_r($businessForm->getMessages());
                //echo '</pre>';
            }
        }


        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'myForm'            =>  $businessForm,
            'itemsTypeBusinesss'=>  $itemsTypeBusinesss,
            'itemsCity'         =>  $itemsCity,
            'error'             =>  $error,
        ));
    }
    public function editAction(){
        $error          = array();
        //Tiêu đề
        $title          =  'Doanh nghiệp BĐS > Chỉnh sửa';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        
        //list city
        $itemsCity          = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-city'));
        
        //loại hình doanh nghiệp
        $itemsTypeBusinesss =   $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-type-business'));
        

        $item           = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));
       


        $businessForm       = $this->serviceLocator->get('FormElementManager')->get('businessUserForm');
        $businessForm->setInputFilter(new \User\Form\BusinessFilter(array('task'=>'edit', 'id'=>$this->_arrParam['id'])));
        $businessForm->bind($item);
        if($this->getRequest()->isPost()){
            $data   = $this->getRequest()->getPost();
            $businessForm->setData($data);

             //Kiểm tra chọn select box
            if(empty($this->_arrPost['city'])){
                $error[]    = 'Bạn phải chọn thông tin Thành phố của doanh nghiệp!';
            }if(empty($this->_arrPost['district'])){
                $error[]    = 'Bạn phải chọn thông tin Quận huyện của doanh nghiệp!';
            }if(empty($this->_arrPost['type_business'])){
                $error[]    = 'Bạn phải chọn thông tin loại hình doanh nghiệp!';
            }

            if($businessForm->isValid() && empty($error)){
               
                //Chống tấn công XSS
                $purifier   = new \HTMLPurifier_HTMLPurifier();
                $data    =  array(
                    'id'        => $purifier->purify($this->_arrPost['id']), 
                    'type_business' =>  $purifier->purify($this->_arrPost['type_business']),
                    'name'          => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['name'])),
                    'alias'         => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['alias'])),
                    'address'       => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['address'])),
                    'city'          => $purifier->purify($this->_arrPost['city']),
                    'district'      => $purifier->purify($this->_arrPost['district']),
                    'ward'          => $purifier->purify($this->_arrPost['ward']),
                    'phone'         => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['phone'])),
                    'fax'           => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['fax'])),
                    'website'       => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['website'])),
                    'intro'         => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['intro'])),
                    'contact'       => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['contact'])),
                    'department'    => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['department'])),
                );

                $this->getTable()->saveItem($data,array('task'=>'edit'));
                $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được lưu thành công');
                $this->redirect()->toUrl('/user/business/');
            }
        }


        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'myForm'            =>  $businessForm,
            'item'              =>  $item,
            'itemsTypeBusinesss'=>  $itemsTypeBusinesss,
            'itemsCity'         =>  $itemsCity,
            'error'             =>  $error,
        ));
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
                    $fileName = $upload->uploadFile('image', UPLOAD_PATH .'/logo-business/', array('task' => 'rename'), 'batdongsan_');
                    //Thực hiện xóa ảnh cũ
                    
                    $upload->removeFile(UPLOAD_PATH .'/logo-business/'.$this->_arrPost['image_hidden']);
                        
                    //update database
                    $arrParam = array(
                        'id'    =>  $this->_arrPost['id'],
                        'logo'=>  $fileName,
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
    
}
