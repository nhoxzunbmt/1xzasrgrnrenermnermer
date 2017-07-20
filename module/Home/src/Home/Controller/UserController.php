<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Home\Controller;
use Zend\EventManager\EventManagerInterface;
use ZendVN\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container as Container;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Validator\Db\RecordExists;
use Zend\Validator\Db\NoRecordExists;
use Zend\Stdlib\ArrayObject;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
class UserController extends ActionController
{
    
    protected $adapter;
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
            $this->_userTable = $this->getServiceLocator()->get('Home\Model\UserTable');
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

            $this->adapter = GlobalAdapterFeature::getStaticAdapter();

            //Load templates
            $this->layout('layout/home');


        
    }

    public function loginAdminAction()
    {
        $this->layout('layout/login');
        if($this->identity()){
            //$this->redirect()->toUrl('/');
        }
        $error          = array();

        $view           = new ViewModel();
        //Tiêu đề
        $title          =  'Đăng nhập';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
        $loginForm      = $this->serviceLocator->get('FormElementManager')->get('loginForm');
        
        if($this->getRequest()->isPost()){

            $data = $this->getRequest()->getPost();
            $loginForm->setData($data);
            if($loginForm->isValid()){
                $authService = $this->getServiceLocator()->get('Authenticate');
                if($authService->login(array('email'=>$this->_arrPost['my-email'],'password'=>$this->_arrPost['my-password'])) == true){
                    $data  = array();
                    $permissionTable = $this->getServiceLocator()->get('Home\Model\PermissionTable');
                    $userID                     =   $this->identity()->id;
                    $groupID                    =   $this->identity()->group_id; 
                    $data['user']               =   $this->getTable()->getItem(array('id'=>$userID));
                    $data['group']              =   $this->getTable()->getItem(array('id'=>$groupID),array('task'=>'store-group-info'));
                    $data['permission']['role']         =   $data['group']['group_name'];
                    $data['permission']['privileges']   =   $permissionTable->getItem($data['group'],array('task'=>'store-permission-info'));
                   
                    $infoUser       = new \ZendVN\System\Info();
                    $infoUser->storeInfo($data);
                    $this->redirect()->toUrl('/admin/index/index');
                }else{
                   $error[] =   $authService->getError();
                }
                
            }else{
                $error[] =   'Email : '.current($loginForm->getMessages('my-email'));
                $error[] =   'Password : '.current($loginForm->getMessages('my-password'));
            }
        }         
        $view->setVariables(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'myForm'            =>  $loginForm,
            'error'             =>  $error,
        ));
        return $view;
        
    }

    public function loginAction()
    {
        if($this->identity()){
            $this->redirect()->toUrl('/');
        }
        $error          = array();

        $view           = new ViewModel();
        //Tiêu đề
        $title          =  'Đăng nhập';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
        $loginForm      = $this->serviceLocator->get('FormElementManager')->get('loginForm');
        
        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
            $loginForm->setData($data);
            if($loginForm->isValid()){
                $authService = $this->getServiceLocator()->get('Authenticate');
                if($authService->login(array('email'=>$this->_arrPost['my-email'],'password'=>$this->_arrPost['my-password'])) == true){
                    $data  = array();
                    $permissionTable = $this->getServiceLocator()->get('Home\Model\PermissionTable');
                    $userID                     =   $this->identity()->id;
                    $groupID                    =   $this->identity()->group_id; 
                    $data['user']               =   $this->getTable()->getItem(array('id'=>$userID));
                    $data['group']              =   $this->getTable()->getItem(array('id'=>$groupID),array('task'=>'store-group-info'));
                    $data['permission']['role']         =   $data['group']['group_name'];
                    $data['permission']['privileges']   =   $permissionTable->getItem($data['group'],array('task'=>'store-permission-info'));
                   
                    $infoUser       = new \ZendVN\System\Info();
                    $infoUser->storeInfo($data);
                    $this->redirect()->toUrl('/user/account/');
                }else{
                   $error[] =   $authService->getError();
                }
                
            }else{
                $error[] =   'Email : '.current($loginForm->getMessages('my-email'));
                $error[] =   'Password : '.current($loginForm->getMessages('my-password'));
            }
        }         
        $view->setVariables(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'myForm'            =>  $loginForm,
            'error'             =>  $error,
        ));
        return $view;
        
    }

    public function validateAction(){
        $loginForm   = $this->serviceLocator->get('FormElementManager')->get('loginForm');
        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
            $loginForm->setData($data);
            if($loginForm->isValid()){
                $authService = $this->getServiceLocator()->get('Authenticate');
                if($authService->login(array('email'=>$this->_arrPost['my-email'],'password'=>$this->_arrPost['my-password'])) == true){
                    /*$permissionTable = $this->getServiceLocator()->get('Home\Model\PermissionTable');
                    $userID                     =   $this->identity()->id;
                    $groupID                    =   $this->identity()->group_id; 
                    $data['user']               =   $this->getTable()->getItem(array('id'=>$userID));
                    $data['group']              =   $this->getTable()->getItem(array('id'=>$groupID),array('task'=>'store-group-info'));
                    $data['permission']['role']         =   $data['group']['group_name'];
                    $data['permission']['privileges']   =   $permissionTable->getItem($data['group'],array('task'=>'store-permission-info'));

                    $infoUser       = new \ZendVN\System\Info();
                    $infoUser->storeInfo($data);*/
                    $result['status']                   =   'success';
                    $result['messages']['redirect']     =   $this->url()->fromRoute('AuthRedirect', array('module'=>'user','controller'=>'index','action'=>'index'));
                }else{
                    $result['messages']['authenticate'] =   $authService->getError();
                }
                
            }else{
                $result['status']               =   'error';
                $result['messages']['email']    =  'Email : '.current($loginForm->getMessages('my-email'));
                $result['messages']['password'] =  'Password : '.current($loginForm->getMessages('my-password'));
            }
        } 
        echo \Zend\Json\Json::encode($result);     
        return $this->getResponse();   
    }

    public function logoutAction(){
        $authService = $this->getServiceLocator()->get('AuthenticateService');
        $authService->clearIdentity();
        $infoUser    = new \ZendVN\System\Info();
        $infoUser->destroyInfo();
        $this->redirect()->toUrl('/');
        return $this->getResponse(); 
    }

    public function registerAction(){
        if($this->identity()){
            $this->redirect()->toUrl('/');
        }

        $view               = new ViewModel();
        //Tiêu đề
        $title      =  'Tạo tài khoản';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
        

        $registerHomeForm   = $this->serviceLocator->get('FormElementManager')->get('registerHomeForm');


        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
            $registerHomeForm->setData($data);
            if($registerHomeForm->isValid()){
                echo 'thành công';
            }else{
                echo '<pre>';
                print_r($registerHomeForm->getMessages());
                echo '</pre>';
            }
        }         
        $view->setVariables(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'myForm'            =>  $registerHomeForm,
           
        ));
        return $view;
    }

    public function validateRegisterAction(){
        $registerHomeForm   = $this->serviceLocator->get('FormElementManager')->get('registerHomeForm');
        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
            $registerHomeForm->setData($data);
            if($registerHomeForm->isValid()){
                $arrInfoServiceAccount = array(
                    'service_account'   =>  'Tài khoản thường',
                    'normal'            =>  10,
                    'vip'               =>  10,
                    'hot'               =>  10,
                    'free'              =>  10,
                    'chinhchu'          =>  10,
                    'date_start'        =>  '21-12-2014',
                    'date_end'          =>  '21-12-2014',
                );
                $config = new \ZendVN\Config\Config();


                if($config->activeAccountEmail() == 1){
                    $active_code = mt_rand() .mt_rand() .mt_rand() .mt_rand() .mt_rand();//Kích hoạt qua email cẩn phải có mã kích hoạt
                    $status = 0;//Sau khi kích hoạt tài khoản mới hoạt động được
                }else{
                    //Nếu không phải kích hoạt qua email thì không cần mã kích hoạt
                    $active_code = '';
                    $status = 1;//tài khoản hoạt động được luôn
                }

                //Chống tấn công XSS
                $purifier   = new \HTMLPurifier_HTMLPurifier();
                $data       =  array(
                    'username'      =>  $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['username'])),
                    'password'      =>  md5($this->_arrPost['password']),
                    'email'         =>  $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['email'])),
                    'avatar'        =>  '',
                    'fullname'      =>  $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['fullname'])),
                    'city_id'       =>  1,
                    'website'       =>  '',
                    'phone'         =>  $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['phone'])),
                    'active_code'   =>  $active_code,
                    'status'        =>  $status,
                    'group_id'      =>  4,
                    'register_ip'   =>  $_SERVER['REMOTE_ADDR'],
                    'register_date' =>  date('d/m/y h:i:s'),
                    'diachi'        => '',
                    'info_service_account'  => \Zend\Json\Json::encode($arrInfoServiceAccount),
                    );
                $lastInsertId = $this->getTable()->saveItem($data,array('task'=>'add'));
                

                if($config->activeAccountEmail() == 1){
                    $AccountActiveLink  =  \ZendVN\Url\CurrentDomain::get().$this->url()->fromRoute('MVC_HomeRouter/active', array('module'=>'home','controller'=>'user','action'=>'active','id'=>$lastInsertId,'code'=>$active_code));
                    $this->sendMail($this->_arrPost['fullname'],'Bất động sản',$this->_arrPost['email'],$this->_arrPost['password'],$AccountActiveLink);
                    $result['messages']['success']          =  'Một email vừa được gửi tới '.$this->_arrPost['email'] .' Với một mã kích hoạt. Bạn vui lòng kiểm tra email để kích hoạt tài khoản';
                }else{
                    $result['messages']['success']          =  'Chúc mừng bạn đã đăng kí thành công';
                }
                

                
               
                $result['status']                       =  'success';
            }else{
                $result['status']                       =  'error';
                $result['messages']['fullname']         =  current($registerHomeForm->getMessages('fullname'));
                $result['messages']['username']         =  current($registerHomeForm->getMessages('username'));
                $result['messages']['password']         =  current($registerHomeForm->getMessages('password'));
                $result['messages']['confirmpassword']  =  current($registerHomeForm->getMessages('confirm-password'));
                $result['messages']['email']            =  current($registerHomeForm->getMessages('email'));
                $result['messages']['phone']            =  current($registerHomeForm->getMessages('phone'));
                $result['messages']['captcha']          =  '';
                if(current($registerHomeForm->getMessages('captcha')) != ''){
                    $result['messages']['captcha']          =    'Mã an toàn không chính xác';
                }
                
            }   

        } 
        echo \Zend\Json\Json::encode($result);     
        return $this->getResponse();   
    }

    protected function sendMail($FirstName,$Website,$Email,$Password,$AccountActiveLink){
        $notification = $this->getTable()->getItem(array('id'=>1),array('task'=>'get-item-notification-template')); 
        $content = str_replace("@@FirstName@@",$FirstName,$notification['content']);
        $content = str_replace("@@Website@@",$Website,$content);
        $content = str_replace("@@Email@@",$Email,$content);
        $content = str_replace("@@Password@@",$Password,$content);
        $content = str_replace("@@AccountActiveLink@@",$AccountActiveLink,$content);

        $mailService = $this->getServiceLocator()->get('AcMailer\Service\MailService');
        $mailService->setSubject('Kích hoạt tài khoản '. $Website)
                    ->setBody($content); // This can be a string, HTML or even a zend\Mime\Message or a Zend\Mime\Part
        
        $message = $mailService->getMessage();
        $message->addTo($Email);
                    
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
        return $messages;
    }

    

    public function testAction(){
       
        $mailService = $this->getServiceLocator()->get('AcMailer\Service\MailService');
        $mailService->setSubject('đánh nhau ko ')
                    ->setBody('Kích hoạt tài khoản '); // This can be a string, HTML or even a zend\Mime\Message or a Zend\Mime\Part
                    //->setTemplate('permission/mail/index',array('name'=>'Join','email'=>'phamvannam@gmail.com'));
                    //->addFrom('nobita_xuka_ccy@yahoo.com.vn')
                    //->addTo('phamvannam.44ct1.ccy@gmail.com');
        /*$mailService->addAttachments(array(
            'data/mail/file.zip',
            'data/mail/file.rar'
        ));*/ 

        $message = $mailService->getMessage();
        $message->addTo('nobita_xuka_ccy@yahoo.com.vn');
        


        $result = $mailService->send();
        if ($result->isValid()) {
            echo 'Message sent. Congratulations!';
        } else {
            if ($result->hasException()) {
                echo sprintf('An error occurred. Exception: \n %s', $result->getException()->getTraceAsString());
            } else {
                echo sprintf('An error occurred. Message: %s', $result->getMessage());
            }
        }
        return false;
    }

    public function activeAction(){
        
        $messages = array();
        if($this->identity()){
            $this->redirect()->toUrl('/');
        }

        $view               = new ViewModel();
        //Tiêu đề
        $title      =  'Kích hoạt tài khoản';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
        $check = $this->getTable()->getItem($this->_arrParam,array('task'=>'user-active'));
        if($check == 0){
            $urlLogin   = $this->url()->fromRoute('home', array('module'=>'home','controller'=>'index','action'=>'index'));
            $messages['message']    = 'Đường link kích hoạt không chính xác !  <a href="'.$urlLogin.'"> Trở về trang chủ</a>'; 
            $messages['status']     = 'error';
        }else{
            $urlLogin   = $this->url()->fromRoute('MVC_HomeRouter/action', array('module'=>'home','controller'=>'user','action'=>'login'));
            $this->getTable()->saveItem($this->_arrParam,array('task'=>'user-active'));
            $messages['message']   = 'Tài khoản của bạn đã được kích hoạt thành công! Kích vào <a href="'.$urlLogin.'"> Đăng nhập</a>'; 
            $messages['status']    = 'success';
        }
        
        $view->setVariables(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'messages'          =>  $messages,
        ));
        return $view;
    }

    public function captchaAction(){
        
        $captchaObj     = new \ZendVN\Captcha\Image(300,50,array(
            'wordlen'           =>  5,
            'suffix'            =>  '.jpg',
        ));
       
        if($this->getRequest()->isPost()){
            $txtCaptcha     = $this->getRequest()->getPost('captcha_code');
            $captchaHidden  = $this->getRequest()->getPost('captcha_hidden');
            
            $validator = new \ZendVN\Validator\Captcha($captchaHidden);
            if($validator->isValid($txtCaptcha)){
                echo 'ok';
            }else{
                $message = $validator->getMessages();
                echo $message['captchaNotEqual'];
            }
            
            $captchaObj->remove($captchaHidden);
        }
        return array(
           'imageUrl'   =>  $captchaObj->getImgUrl() .$captchaObj->getId().$captchaObj->getSuffix(),
           'captchaID'  =>  $captchaObj->getId(),
        );

    }

    public function refreshCaptchaAction(){
        $view = new ViewModel();
        $isXmlHttpRequest = false;
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;
            $captchaObj     = new \ZendVN\Captcha\Image(150,50,array(
                'wordlen'           =>  5,
                'fsize'             =>  25,
                'suffix'            =>  '.jpg',
            ));
            $captchaID = $this->getRequest()->getQuery('captchaID');
            $captchaObj->remove($captchaID);
        } 
        $view->setVariables(array(
            'isXmlHttpRequest'  =>  $isXmlHttpRequest, 
            'imageUrl'   =>  $captchaObj->getImgUrl() .$captchaObj->getId().$captchaObj->getSuffix(),
            'captchaID'  =>  $captchaObj->getId(),           
        ));       
        $view->setTerminal(true);
        return $view;
    }

    public function forgotPasswordAction(){
        if($this->identity()){
            $this->redirect()->toUrl('/');
        }

        $view               = new ViewModel();
        //Tiêu đề
        $title          =  'Quên mật khẩu';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
        $forgotPasswordHomeForm      = $this->serviceLocator->get('FormElementManager')->get('forgotPasswordHomeForm');
        
       
        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
            $forgotPasswordHomeForm->setData($data);
        }         
        $view->setVariables(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'myForm'            =>  $forgotPasswordHomeForm,
           
        ));
        return $view;
    }

    public function restorePassAction(){
        if($this->identity()){
            $this->redirect()->toUrl('/');
        }

        $this->_arrParam['code'] = $this->_arrParam['longitude'];
        $check = $this->getTable()->getItem($this->_arrParam,array('task'=>'restore-password'));
       
        if($check == 0){
            $this->redirect()->toUrl('/home/notice/notice');
        }

        $view               = new ViewModel();
        //Tiêu đề
        $title          =  'Phục hồi mật khẩu';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
        $restorePasswordHomeForm      = $this->serviceLocator->get('FormElementManager')->get('restorePasswordHomeForm');
        

       
        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
            $restorePasswordHomeForm->setData($data);
        }         
        $view->setVariables(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'myForm'            =>  $restorePasswordHomeForm,
           
        ));
        return $view;
    }

    public function validateRestorePasswordAction(){
        $restorePasswordHomeForm   = $this->serviceLocator->get('FormElementManager')->get('restorePasswordHomeForm');
        

        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
            $restorePasswordHomeForm->setData($data);
            if($restorePasswordHomeForm->isValid()){
                $check = $this->getTable()->getItem(array('code'=>$this->_arrPost['code']),array('task'=>'restore-password'));
       
                if($check == 0){
                    $result['status']                       =  'error';
                    $result['messages']['password']         =  'Mã phục hồi mật khẩu không chính xác';
                }else{
                    $arrParam = array(
                        'password'      =>  md5($this->_arrPost['password']),
                        'fpass_code'    =>  $this->_arrPost['code'],
                    );
                    $this->getTable()->saveItem($arrParam,array('task'=>'restore-password'));

                    $result['messages']['success']          =  'Mật khẩu của bạn đã phục hồi thành công';
                    $result['status']                       =  'success';
                }
                
                
            }else{
                $result['status']                       =  'error';
                $result['messages']['password']         =  current($restorePasswordHomeForm->getMessages('password'));
                $result['messages']['confirmpassword']  =  current($restorePasswordHomeForm->getMessages('confirm-password'));
            }
        } 
        echo \Zend\Json\Json::encode($result);     
        return $this->getResponse();   
    }

    public function validateForgotPasswordAction(){
        $forgotPasswordHomeForm   = $this->serviceLocator->get('FormElementManager')->get('forgotPasswordHomeForm');
        

        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
            $forgotPasswordHomeForm->setData($data);
            if($forgotPasswordHomeForm->isValid()){
                $validator = new \Zend\Validator\Db\NoRecordExists(array(
                    'table' => 'users',
                    'field' => 'email',
                    'adapter' => $this->adapter
                ));

                if($validator->isValid($this->_arrPost['my-email'])){
                    $result['status']               =  'error';
                    $result['messages']['email']    =  'Email không tồn tại trong hệ thống';
                }else{
                    $restorePassCode        = mt_rand() .mt_rand() .mt_rand() .mt_rand() .mt_rand();//Kích hoạt qua email cẩn phải có mã kích hoạt
                
                    $arrParam = array(
                        'email'         =>  $this->_arrPost['my-email'],
                        'fpass_code'    =>  $restorePassCode,
                    );
                    $this->getTable()->saveItem($arrParam,array('task'=>'forgot-password-code'));

                    $LinkRestorePass        =  \ZendVN\Url\CurrentDomain::get().$this->url()->fromRoute('MVC_HomeRouter/restorepass', array('module'=>'home','controller'=>'user','action'=>'restore-pass','code'=>$restorePassCode));
                    $this->sendMailForgotPassword($this->_arrPost['my-email'],$LinkRestorePass);
                    
                    $result['messages']['success']          =  'Gửi thành công, vui lòng kiểm tra lại Email để biết thông tin.<br>
                                                                Email của bạn: '.$this->_arrPost['my-email'];
                    $result['status']                       =  'success';
                }
                
            }else{
                $result['status']                   =  'error';
                 $result['messages']['email']    =  '';
                if(current($forgotPasswordHomeForm->getMessages('my-email')) != ''){
                    $result['messages']['email']    =  'Email : Bạn phải nhập đúng định dạng Email ';
                }
                
            }
        } 
        echo \Zend\Json\Json::encode($result);     
        return $this->getResponse();   
    }

    protected function sendMailForgotPassword($email,$LinkRestorePass){
        
        $notification = $this->getTable()->getItem(array('id'=>3),array('task'=>'get-item-notification-template')); 
        $content = str_replace("@@Email@@",$email,$notification['content']);
        $content = str_replace("@@LinkRestorePass@@",$LinkRestorePass,$content);
        $mailService = $this->getServiceLocator()->get('AcMailer\Service\MailService');
        $mailService->setSubject('Quên mật khẩu')
                    ->setBody($content); // This can be a string, HTML or even a zend\Mime\Message or a Zend\Mime\Part
        
        $message = $mailService->getMessage();
        $message->addTo($email);
                    
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
        return $messages;
    }

    
}
