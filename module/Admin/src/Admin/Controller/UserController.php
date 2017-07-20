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
class UserController extends ActionController
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

    protected $_userTable;
    protected $_userGroupTable;

    public function getTable(){
        if(empty($this->_userTable)){
            $this->_userTable = $this->getServiceLocator()->get('Admin\Model\UserTable');
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
        
      
    }

    public function indexAction()
    {
    	//Tiêu đề
    	$title      =  'Danh sách thành viên';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
       
        $itemsCity          = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-city'));
        $itemsGroup         = $this->getUserGroupTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-group'));

        
       
        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'itemsCity'         =>  $itemsCity,
            'itemsGroup'        =>  $itemsGroup,
            'currentController' =>  $this->_currentController,
        ));
    	
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
                
               
            }
            $userTable      = $this->getTable();
            $totalItem      = $userTable->countItem();
            $items          = $userTable->listItem($this->_arrParam,array('task'=>'list-items-paginator'));
    
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

    public function addAction(){
        $error          = array();
        //Tiêu đề
        $title          =  'Quản lý thành viên > Thêm mới';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        
        $itemsUserGroup = $this->getUserGroupTable()->listItem($this->_arrParam,array('task'=>'list-items'));
        $userForm       = $this->serviceLocator->get('FormElementManager')->get('userForm');

        $itemsGroup     = $this->getUserGroupTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-group'));
        //$itemsGroup     = array_slice ($itemsGroup,1,count($itemsGroup) - 1);
        
        $itemsCity      = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-city'));
        //$itemsCity      = array_slice ($itemsCity,1,count($itemsCity) - 1);
        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
            $userForm->setData($data);


            //Kiểm tra chọn select box
            if(empty($this->_arrPost['group_id'])){
                $error[]    = 'Bạn phải chọn thông tin Nhóm của khách hàng! ';
            }if(empty($this->_arrPost['city_id'])){
                $error[]    = 'Bạn phải chọn thông tin Thành phố của khách hàng!';
            }

            //Upload 
            $avatar     = '';
            $upload     = new \ZendVN\File\Upload();
            $fileName   = $upload->getFileName();
            if(!empty($fileName)){
                $upload->addValidator('Extension', true, array('png','jpg'), 'image' );
                $upload->addValidator ('Size', false, array('min' => '10kb','max' => '500kb'), 'image' );
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
                    $avatar = $upload->uploadFile('image', UPLOAD_PATH .'/avatar/', array('task' => 'rename'), 'batdongsan_');
                }
            } 

            if($userForm->isValid() && empty($error)){
               
                    
                    //Chống tấn công XSS
                    $purifier   = new \HTMLPurifier_HTMLPurifier();
                    $data    =  array(
                        'username'  => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['username'])),
                        'password'  => md5($this->_arrPost['password']),
                        'email'     => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['email'])),
                        'avatar'    => $avatar,
                        'fullname'  => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['fullname'])),
                        'city_id'   => $purifier->purify($this->_arrPost['city_id']),
                        'website'     => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['website'])),
                        'phone'     => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['phone'])),
                        'group_id'  => $purifier->purify($this->_arrPost['group_id']),
                        'diachi'    => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['diachi'])),
                        'introduced'=> $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['introduced'])),
                    );
                    $this->getTable()->saveItem($data,array('task'=>'add'));
                    $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được lưu thành công');
                    $this->redirect()->toUrl('/admin/user/');
            }
        }


        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'myForm'            =>  $userForm,
            'itemsGroup'        =>  $itemsGroup,
            'itemsCity'         =>  $itemsCity,
            'error'             =>  $error,
        ));
    }
    public function editAction(){
        $error          = array();
        //Tiêu đề
        $title          =  'Quản lý thành viên > Chỉnh sửa';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        
        $itemsGroup     = $this->getUserGroupTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-group'));
        //$itemsGroup     = array_slice ($itemsGroup,1,count($itemsGroup) - 1);
        
        $itemsCity      = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-city'));
        //$itemsCity      = array_slice ($itemsCity,1,count($itemsCity) - 1);

        $item           = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));
        $curentPassword = $item->password;


        $userForm       = $this->serviceLocator->get('FormElementManager')->get('userForm');
        $userForm->setInputFilter(new \Admin\Form\UserFilter(array('task'=>'edit', 'id'=>$this->_arrParam['id'])));
        $userForm->bind($item);
        if($this->getRequest()->isPost()){
            $data   = $this->getRequest()->getPost();
            $userForm->setData($data);

             //Kiểm tra chọn select box
            if(empty($this->_arrPost['group_id'])){
                $error[]    = 'Bạn phải chọn thông tin Nhóm của khách hàng! ';
            }if(empty($this->_arrPost['city_id'])){
                $error[]    = 'Bạn phải chọn thông tin Thành phố của khách hàng!';
            }

            if($userForm->isValid() && empty($error)){
                //Trường hợp không thay đổi password nghĩa là không nhập vào input password
                
                if(empty($userForm->getData()->password)){
                    $this->_arrPost['password']  = $curentPassword;
                }
                //Chống tấn công XSS
                $purifier   = new \HTMLPurifier_HTMLPurifier();
                $data    =  array(
                    'id'        => $purifier->purify($this->_arrPost['id']), 
                    'username'  => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['username'])),
                    'password'  => md5($this->_arrPost['password']),
                    'email'     => $purifier->purify($this->_arrPost['email']),
                    'fullname'  => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['fullname'])),
                    'city_id'   => $purifier->purify($this->_arrPost['city_id']),
                    'website'   => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['website'])),
                    'phone'     => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['phone'])),
                    'group_id'  => $purifier->purify($this->_arrPost['group_id']),
                    'diachi'    => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['diachi'])),
                    'introduced'=> $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['introduced'])),
                );

                $this->getTable()->saveItem($data,array('task'=>'edit'));
                $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được lưu thành công');
                $this->redirect()->toUrl('/admin/user/');
            }else{
                //echo '<pre>';
                //print_r($userForm->getMessages());
                //echo '</pre>';
            }
        }


        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'myForm'            =>  $userForm,
            'item'              =>  $item,
            'itemsGroup'        =>  $itemsGroup,
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
                    $fileName = $upload->uploadFile('image', UPLOAD_PATH .'/avatar/', array('task' => 'rename'), 'batdongsan_');
                    //Thực hiện xóa ảnh cũ
                    
                    $upload->removeFile(UPLOAD_PATH .'/avatar/'.$this->_arrPost['image_hidden']);
                        
                    //update database
                    $arrParam = array(
                        'id'    =>  $this->_arrPost['id'],
                        'avatar'=>  $fileName,
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

    public function banAction(){
        $error          = array();
        //Tiêu đề
        $title          =  'Quản lý thành viên > Cấm thành viên';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        $item           = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));
        $banAdminForm       = $this->serviceLocator->get('FormElementManager')->get('banAdminForm');
        $banAdminForm->bind($item);
        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
            $banAdminForm->setData($data);
            
            if($banAdminForm->isValid() && empty($error)){
               
                    
                    //Chống tấn công XSS
                    $purifier   = new \HTMLPurifier_HTMLPurifier();
                    $data    =  array(
                        'user_id'  => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrParam['id'])),
                        'ip'     => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['register_ip'])),
                        'nguyennhan'=> $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['nguyennhan'])),
                        'banned'    =>  'true',
                    );
                    $this->getTable()->saveItem($data,array('task'=>'ban'));
                    $this->flashMessenger()->addSuccessMessage('Cấm thành viên thành công');
                    $this->redirect()->toUrl('/admin/user/');
            }
        }


        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'myForm'            =>  $banAdminForm,
            'error'             =>  $error,
        ));
    }
    public function unBanAction(){
        if(!empty($this->_arrParam['id'])){
            $filter     = new \Zend\Filter\Digits();
            $id         = $filter->filter($this->_arrParam['id']);
            $this->getTable()->deleteItem(array('id'=>$id),array('task'=>'un-ban'));
            $this->getTable()->saveItem(array('id'=>$id),array('task'=>'un-ban'));
        }
        $this->redirect()->toUrl('/admin/user/');    
        return $this->getResponse();
    }
    public function previewAction(){
        $view = new ViewModel();
        $item = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));
        $view->setVariables(array(
            'item'             => $item,
        ));
        $view->setTerminal(true);
        return $view; 
    }
    public function multiStatusAction(){
        if(!empty($this->_arrParam['id'])){
            $arrParam['id']     = explode(",", $this->_arrParam['id']);
            $arrParam['type']   = $this->_arrParam['type'];
            $this->getTable()->saveItem($arrParam,array('task'=>'multi-status'));
            $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được cập nhật thành công'); 
        }
        $this->redirect()->toUrl('/admin/user/');
        return $this->getResponse();    
    }
    public function statusAction(){
        if(!empty($this->_arrParam['id'])){
            $filter     = new \Zend\Filter\Digits();
            $id         = $filter->filter($this->_arrParam['id']);
            $arrParam   = array('status'=>$this->_arrParam['status'],'id'=>$id);
            $this->getTable()->saveItem($arrParam,array('task'=>'edit'));
        }
        $this->redirect()->toUrl('/admin/user/');    
        return $this->getResponse();
    }
    public function deleteAction(){
        if(!empty($this->_arrParam['id'])){
            $filter   = new \Zend\Filter\Digits();
            $id       = $filter->filter($this->_arrParam['id']);
            $arrParam = array('id'=>$id);
            $item = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));
            
            //không thể xóa tài khoản admin
            if($item->group_id != 1){
               
                $upload = new \ZendVN\File\Upload();
                $upload->removeFile(UPLOAD_PATH .'/avatar/'.$item->avatar);
                
                $this->getTable()->deleteItem($arrParam,array('task'=>'delete-item'));
            }
           $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được xóa thành công');
            
        }
        $this->redirect()->toUrl('/admin/user/');
        return $this->getResponse();    
    }
    public function multiDeleteAction(){
        if(!empty($this->_arrParam['id'])){
            $arrParam = explode(",", $this->_arrParam['id']);
            $items = $this->getTable()->deleteItem($arrParam,array('task'=>'list-images'));
            if(!empty($items)){
                foreach($items as $item){
                    $upload = new \ZendVN\File\Upload();
                    $upload->removeFile(UPLOAD_PATH .'/avatar/'.$item->avatar);  
                }    
            }        
            $this->getTable()->deleteItem($arrParam,array('task'=>'multi-delete-item'));
            $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được xóa thành công');
            
        }
        $this->redirect()->toUrl('/admin/user/');
        return $this->getResponse();    
    }
    public function filterAction(){
        $ssFilter   = new Container($this->_namespace);
        $purifier   = new \HTMLPurifier_HTMLPurifier();
        if($this->_arrParam['type'] == 'search'){
            if($this->_arrParam['col'] == 'null' && $this->_arrParam['by'] == 'null' && $this->_arrParam['key'] == 1){
                if($this->params()->fromPost('keywords') != ''){
                    $ssFilter->keywords = $purifier->purify(trim($this->params()->fromPost('keywords')));
                    $ssFilter->field    = $this->params()->fromPost('field');
                }
                $ssFilter->status   = $this->params()->fromPost('status');
                $ssFilter->city     = $this->params()->fromPost('city_id');
                $ssFilter->group    = $this->params()->fromPost('group_id');
                
            }if($this->_arrParam['col'] == 'null' && $this->_arrParam['by'] == 'null' && $this->_arrParam['key'] == 0){
                $ssFilter->getManager()->getStorage()->clear();
            }
        }

        if($this->_arrParam['type'] == 'order' && $this->_arrParam['col'] != 'null' && $this->_arrParam['by'] != 'null'){
            $ssFilter->col      = $this->_arrParam['col'];
            $ssFilter->order    = $this->_arrParam['by'];
        }
        if($this->_arrParam['type'] == 'record'){
            $ssFilter->record   = $this->params()->fromPost('record');

        }
        
        $this->redirect()->toUrl('/admin/user/');
        return $this->getResponse();   
    }
    
}
