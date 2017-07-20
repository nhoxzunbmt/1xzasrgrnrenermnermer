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
class AccountController extends ActionController
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
    protected $_getuserTable;
    protected $_userGroupTable;

    public function getTable(){
        if(empty($this->_userTable)){
            $this->_userTable = $this->getServiceLocator()->get('User\Model\AccountTable');
        }
        return $this->_userTable;
    }
    public function getUserGroupTable(){
        if(empty($this->_userGroupTable)){
            $this->_userGroupTable = $this->getServiceLocator()->get('Admin\Model\UserGroupTable');
        }
        return $this->_userGroupTable;
    }
    public function getUserTable(){
        if(empty($this->getuserTable)){
            $this->_getuserTable = $this->getServiceLocator()->get('Home\Model\UserTable');
        }
        return $this->_getuserTable;
    }
    public function init()
    {
       
        $controller = $this;
        
           
        //Mảng tham số Router nhận được ở mỗi Action
        $this->_arrParam    = $this->params()->fromRoute();

        //Mảng tham số Post nhận được ở mỗi Action
        $this->_arrPost     = $this->params()->fromPost();

        //Đối tượng view Helper
        $this->_viewHelper  = $this->getServiceLocator()->get('Zend\View\Renderer\PhpRenderer');

        //Đường dẫn của Controller
        $paramController               = $this->_arrParam['controller'];
        $tmp                           = explode("\\", $paramController);
        $this->_arrParam['module']     = strtolower($tmp[0]);//get module name
        $this->_arrParam['controller'] = strtolower($tmp[2]);//get controller name

        $this->_currentController   = '/' . $this->_arrParam['module'] 
                                    . '/' . $this->_arrParam['controller'];


    
        //Đường dẫn của Action chính        
        $this->_actionMain          = '/' . $this->_arrParam['module'] 
                                    . '/' . $this->_arrParam['controller']  . '/' . $this->_arrParam['action']; 
        
        //---------Dat ten SESSION-----------------------------------------
        $this->_namespace                           = $this->_arrParam['module'] . '_' . $this->_arrParam['controller'] ;
        $ssFilter                                   = new Container($this->_namespace);

        if(empty($ssFilter->col)){
            $ssFilter->keywords     = '';
            $ssFilter->col          = 'id';
            $ssFilter->order        = 'DESC';
        }
        if(empty($ssFilter->record)){
            $ssFilter->record   = 10;
        }
        $this->_arrParam['ssFilter']['keywords']    = $ssFilter->keywords;
        $this->_arrParam['ssFilter']['sort']        = $ssFilter->sort;
        $this->_arrParam['ssFilter']['col']         = $ssFilter->col;
        $this->_arrParam['ssFilter']['order']       = $ssFilter->order;
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
        $title      =  'Thông tin tài khoản';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
       
        //$itemsCity          = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-city'));
       // $itemsGroup         = $this->getUserGroupTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-group'));

        /*if(!empty($this->identity()->id)){
            $permissionTable = $this->getServiceLocator()->get('Home\Model\PermissionTable');
            $userID                     =   $this->identity()->id;
            $groupID                    =   $this->identity()->group_id; 
            $data['user']               =   $this->getuserTable()->getItem(array('id'=>$userID));
            $data['group']              =   $this->getuserTable()->getItem(array('id'=>$groupID),array('task'=>'store-group-info'));
            $data['permission']['role']         =   $data['group']['group_name'];
            $data['permission']['privileges']   =   $permissionTable->getItem($data['group'],array('task'=>'store-permission-info'));
           
            $infoUser       = new \ZendVN\System\Info();
            $infoUser->storeInfo($data);
        }*/
       
        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
        ));
        
    }
    public function staffAction()
    {
        //Tiêu đề
        $title      =  'Danh sách nhân viên';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
       
        //$itemsCity          = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-city'));
       // $itemsGroup         = $this->getUserGroupTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-group'));

        //Thành viên có parent khác 0(tức là nhân viên của thành viên khac) không thể xem danh sách nhân viên
        if($this->identity()->parent != 0){
            $this->redirect()->toUrl('/user/account/');
        }
       
        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
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
                
               
            }
            $this->_arrParam['parent'] = $this->identity()->id;
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

    public function addAction(){
        //Tiêu đề
        $title      =  'Tài khoản cá nhân > Thêm nhân viên mới';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        
        //Thành viên có parent khác 0(tức là nhân viên của thành viên khac) không thể thêm nhân viên
        if($this->identity()->parent != 0){
            $this->redirect()->toUrl('/user/account/');
        }

        $userForm   = $this->serviceLocator->get('FormElementManager')->get('accountForm');

        $itemsGroup     = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-group'));
        $itemsGroup     = array_slice ($itemsGroup,1,count($itemsGroup) - 1);
        
        $itemsCity      = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-city'));
        $itemsCity      = array_slice ($itemsCity,1,count($itemsCity) - 1);
        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
            $userForm->setData($data);
            if($userForm->isValid()){
                $upload = new \ZendVN\File\Upload();
                $upload->addValidator('Extension', true, array('png','jpg'), 'image' );
                $upload->addValidator ('Size', false, array('min' => '10kb','max' => '500kb'), 'image' );
                if($upload->isValid('image')){
                    //upload ảnh mới
                    $fileName = $upload->uploadFile('image', UPLOAD_PATH .'/avatar/', array('task' => 'rename'), 'batdongsan_');
                    //Chống tấn công XSS
                    $purifier   = new \HTMLPurifier_HTMLPurifier();
                    $data    =  array(
                        'username'  => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['username'])),
                        'password'  => md5($this->_arrPost['password']),
                        'email'     => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['email'])),
                        'avatar'    => $fileName,
                        'fullname'  => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['fullname'])),
                        'city_id'   => $purifier->purify($this->_arrPost['city_id']),
                        'phone'     => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['phone'])),
                        'group_id'  => $purifier->purify($this->_arrPost['group_id']),
                        'diachi'    => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['diachi'])),
                        'introduced'=> $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['introduced'])), 
                        'parent'    => $this->identity()->id, 
                    );
                    $this->getTable()->saveItem($data,array('task'=>'add'));
                    $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được lưu thành công');
                    $this->redirect()->toUrl('/user/account/staff/');
                }else{
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


        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'myForm'            =>  $userForm,
            'itemsGroup'        =>  $itemsGroup,
            'itemsCity'         =>  $itemsCity,
        ));
    }
    public function editAction(){
        //Tiêu đề
        $title          =  'Thông tin tài khoản > Chỉnh sửa';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        
        $itemsGroup     = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-group'));
        $itemsGroup     = array_slice ($itemsGroup,1,count($itemsGroup) - 1);
        
        $itemsCity      = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-city'));
        $itemsCity      = array_slice ($itemsCity,1,count($itemsCity) - 1);
        if(empty($this->_arrParam['id'])){
            $this->_arrParam['id'] = $this->identity()->id;
        }    
        $item           = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));
        
       
        $userForm       = $this->serviceLocator->get('FormElementManager')->get('accountForm');
        $userForm->setInputFilter(new \User\Form\AccountFilter(array('task'=>'edit', 'id'=>$this->_arrParam['id'])));
        $userForm->bind($item);
        if($this->getRequest()->isPost()){
            $data   = $this->getRequest()->getPost();
            $userForm->setData($data);
            if($userForm->isValid()){
              
                
               
                //Chống tấn công XSS
                $purifier   = new \HTMLPurifier_HTMLPurifier();
                $data    =  array(
                    'id'        => $purifier->purify($this->_arrPost['id']), 
                    'fullname'  => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['fullname'])),
                    'email'     => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['email'])), 
                    'city_id'   => $purifier->purify($this->_arrPost['city_id']),
                    'website'   => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['website'])),
                    'phone'     => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['phone'])),
                    'group_id'  => $purifier->purify($this->_arrPost['group_id']),
                    'diachi'    => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['diachi'])),
                    'introduced'=> $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['introduced'])), 
                );

                $this->getTable()->saveItem($data,array('task'=>'edit'));
                $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được lưu thành công');
                $this->redirect()->toUrl('/home/user/logout');
            }else{
               // echo '<pre>';
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
        ));
    }

    public function changePasswordAction(){
        $error          = array();
        //Tiêu đề
        $title          =  'Thông tin tài khoản > Đổi mật khẩu';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
      
        $this->_arrParam['id'] = $this->identity()->id;
        $item           = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));
        

        $changePasswordForm       = $this->serviceLocator->get('FormElementManager')->get('changePasswordForm');
        
        
        if($this->getRequest()->isPost()){
            $data   = $this->getRequest()->getPost();
            $changePasswordForm->setData($data);
            $oldPassword    = $item->password;
            $password_old   = md5($this->_arrPost['password_old']);
            if($oldPassword != $password_old){
                $error[]    = 'Mật khẩu không đúng. Bạn vui lòng thử lại';
            }
            if($changePasswordForm->isValid() && empty($error)){
              
               
                //Chống tấn công XSS
                $purifier   = new \HTMLPurifier_HTMLPurifier();
                $data    =  array(
                    'id'        => $item->id, 
                    'password'  => $purifier->purify(md5($this->_arrPost['password'])),  
                );

                $this->getTable()->saveItem($data,array('task'=>'edit'));
                $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được lưu thành công');
                $this->redirect()->toUrl('/home/user/logout');
            }else{
               // echo '<pre>';
                //print_r($userForm->getMessages());
                //echo '</pre>';
            }
        }


        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'myForm'            =>  $changePasswordForm,
            'item'              =>  $item,
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
                $upload->addValidator ('Size', false, array('min' => '10kb','max' => '500kb'), 'image' );
                if($upload->isValid('image')){
                    //upload ảnh mới
                    $fileName = $upload->uploadFile('image', UPLOAD_PATH .'/avatar/', array('task' => 'rename'), 'batdongsan_');
                    //Thực hiện xóa ảnh cũ
                    if($this->_arrPost['image_hidden'] != 'NoImage.jpg'){
                        $upload->removeFile(UPLOAD_PATH .'/avatar/'.$this->_arrPost['image_hidden']);
                    }    
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
        $this->redirect()->toUrl('/user/account/staff/');
        return $this->getResponse();    
    }
    public function statusAction(){
        if(!empty($this->_arrParam['id'])){
            $filter     = new \Zend\Filter\Digits();
            $id         = $filter->filter($this->_arrParam['id']);
            $arrParam   = array('status'=>$this->_arrParam['status'],'id'=>$id);
            $this->getTable()->saveItem($arrParam,array('task'=>'edit'));
        }
        $this->redirect()->toUrl('/user/account/staff/');    
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
                
                
            }if($this->_arrParam['col'] == 'null' && $this->_arrParam['by'] == 'null' && $this->_arrParam['key'] == 0){
                $ssFilter->getManager()->getStorage()->clear($this->_namespace);
            }
        }

        if($this->_arrParam['type'] == 'order' && $this->_arrParam['col'] != 'null' && $this->_arrParam['by'] != 'null'){
            $ssFilter->col      = $this->_arrParam['col'];
            $ssFilter->order    = $this->_arrParam['by'];
        }
        if($this->_arrParam['type'] == 'record'){
            $ssFilter->record   = $this->params()->fromPost('record');

        }
        
        $this->redirect()->toUrl('/user/account/staff/');
        return $this->getResponse();   
    }
   
    
    
}
