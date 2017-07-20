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
class MessageController extends ActionController
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
            $this->_modelTable = $this->getServiceLocator()->get('Admin\Model\MessageTable');
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
        	$this->_arrParam['ssFilter']['keywords_receive'] 	= $ssFilter->keywords_receive;
            $this->_arrParam['ssFilter']['keywords_send']    = $ssFilter->keywords_send;
            $this->_arrParam['ssFilter']['keywords_user_send']    = $ssFilter->keywords_user_send;
            $this->_arrParam['ssFilter']['keywords_user_receive']    = $ssFilter->keywords_user_receive;
        	$this->_arrParam['ssFilter']['sort'] 		= $ssFilter->sort;
   	    	$this->_arrParam['ssFilter']['col'] 		= $ssFilter->col;
        	$this->_arrParam['ssFilter']['order'] 		= $ssFilter->order;
            $this->_arrParam['ssFilter']['record']      = $ssFilter->record;
            $this->_arrParam['ssFilter']['field_receive']       = $ssFilter->field_receive ;
            $this->_arrParam['ssFilter']['field_send']       = $ssFilter->field ;
            $this->_arrParam['ssFilter']['field_user_send']       = $ssFilter->field_user_send ;
            $this->_arrParam['ssFilter']['field_user_receive']       = $ssFilter->field_user_receive ;
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
    	$title      =  'Hộp thư đi';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
       
        $redirect   = new Container($this->_namespace.'_redirect');
        $redirect->curentUrl = '/admin/message/';
       
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
        
            $this->_arrParam['idUser'] = $this->identity()->id;
        
            $totalItem      = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-hop-thu-di'));
            $items          = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-item-hop-thu-di'));
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

    public function receiveAction()
    {
        //Tiêu đề
        $title      =  'Hộp thư đến';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
       
        $redirect   = new Container($this->_namespace.'_redirect');
        $redirect->curentUrl = '/admin/message/receive';
       
        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
        ));
        
    }
    //Ajax load indexAction
    public function receiveAjaxAction(){
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
        
            $this->_arrParam['idUser'] = $this->identity()->id;
        
            $totalItem      = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-hop-thu-den'));
            $items          = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-item-hop-thu-den'));
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

    public function userReceiveAction()
    {
        //Tiêu đề
        $title      =  'Lưu trữ tin nhắn đến';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
       
        $redirect   = new Container($this->_namespace.'_redirect');
        $redirect->curentUrl = '/admin/message/user-receive';
        
        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
        ));
        
    }
    //Ajax load indexAction
    public function userReceiveAjaxAction(){
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
        
            
            $totalItem      = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-hop-thu-den-user-message'));
            $items          = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-item-hop-thu-den-user-message'));
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

    public function userSendAction()
    {
        //Tiêu đề
        $title      =  'Lưu trữ tin nhắn đi';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
       
        $redirect   = new Container($this->_namespace.'_redirect');
        $redirect->curentUrl = '/admin/message/user-send';
        
        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
        ));
        
    }
    //Ajax load indexAction
    public function userSendAjaxAction(){
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
        
            
            $totalItem      = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-hop-thu-di-user-message'));
            $items          = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-item-hop-thu-di-user-message'));
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
        $title          =  'Tin nhắn > gửi';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        
        
        $messageAdminForm       = $this->serviceLocator->get('FormElementManager')->get('messageAdminForm');
        
        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
            $messageAdminForm->setData($data);

            $result  = $this->getTable()->getItem($this->_arrPost['username'],array('task'=>'check-username'));
            
           
            if(empty($result)){
                $error[] = 'Thành viên này không tồn tại';
            }else{
                $idUser = $result[0]['id'];
                if($idUser == $this->identity()->id){
                    $error[] = 'Bạn không thể gửi tin cho chính mình';
                }
            }

            if($messageAdminForm->isValid() && empty($error)){
               
                    //Chống tấn công XSS
                    $purifier   = new \HTMLPurifier_HTMLPurifier();
                    $data       =  array(
                        'user_id_send'  =>$this->identity()->id,
                        'user_id_nhan'  =>$idUser,
                        'name'          =>$purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['name'])),
                        'content'       =>$purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['content'])),
                        'date_time'     =>date('d/m/y h:i:s'),
                        
                    );

                    //người gửi
                    $this->getTable()->saveItem($data,array('task'=>'user_send'));
                    
                    //người nhận
                    $this->getTable()->saveItem($data,array('task'=>'user_receive'));

                    $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được lưu thành công');
                    $this->redirect()->toUrl('/admin/message/');
            }else{
                //echo '<pre>';
                //print_r($legislationHousingForm->getMessages());
                //echo '</pre>';
            }
        }


        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'myForm'            =>  $messageAdminForm,
           
            
            'error'             =>  $error,
        ));
    }
    
   
    public function viewSendAction(){
        $view           = new ViewModel();
        $item           = $this->getTable()->getItem($this->_arrParam,array('task'=>'view-send'));
        $view->setVariables(array(
            'item'             => $item,
        ));
        $view->setTerminal(true);
        return $view; 
    }
    public function viewReceiveAction(){
        $view           = new ViewModel();
        $item          = $this->getTable()->getItem($this->_arrParam,array('task'=>'view-receive'));
        $view->setVariables(array(
            'item'             => $item,
        ));
        $view->setTerminal(true);
        return $view; 
    }

    public function viewUserReceiveAction(){
        $view           = new ViewModel();
        $item          = $this->getTable()->getItem($this->_arrParam,array('task'=>'view-receive-user-message'));
        $view->setVariables(array(
            'item'             => $item,
        ));
        $view->setTerminal(true);
        return $view; 
    }
    
    
    public function multiDeleteSendAction(){
        if(!empty($this->_arrParam['id'])){
            $arrParam = explode(",", $this->_arrParam['id']);
               
            $this->getTable()->deleteItem($arrParam,array('task'=>'multi-delete-item-message-send'));
            $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được xóa thành công');
            
        }
        $redirect   = new Container($this->_namespace.'_redirect');
        $this->redirect()->toUrl($redirect->curentUrl);
        return $this->getResponse();    
    }
    public function multiDeleteReceiveAction(){
        if(!empty($this->_arrParam['id'])){
            $arrParam = explode(",", $this->_arrParam['id']);
               
            $this->getTable()->deleteItem($arrParam,array('task'=>'multi-delete-item-message-receive'));
            $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được xóa thành công');
            
        }
        $redirect   = new Container($this->_namespace.'_redirect');
        $this->redirect()->toUrl($redirect->curentUrl);
        return $this->getResponse();    
    }
    public function filterAction(){
        $ssFilter   = new Container($this->_namespace);
        $purifier   = new \HTMLPurifier_HTMLPurifier();
        if($this->_arrParam['type'] == 'search'){
            if($this->_arrParam['col'] == 'null' && $this->_arrParam['by'] == 'null' && $this->_arrParam['key'] == 1){
                if($this->params()->fromPost('keywords_send') != ''){
                    $ssFilter->keywords_send = $purifier->purify(trim($this->params()->fromPost('keywords_send')));
                    $ssFilter->field_send    = $this->params()->fromPost('field_send');
                }
                if($this->params()->fromPost('keywords_receive') != ''){
                    $ssFilter->keywords_receive = $purifier->purify(trim($this->params()->fromPost('keywords_receive')));
                    $ssFilter->field_receive    = $this->params()->fromPost('field_receive');
                }
                if($this->params()->fromPost('keywords_user_send') != ''){
                    $ssFilter->keywords_user_send = $purifier->purify(trim($this->params()->fromPost('keywords_user_send')));
                    $ssFilter->field_user_send    = $this->params()->fromPost('field_user_send');
                }
                if($this->params()->fromPost('keywords_user_receive') != ''){
                    $ssFilter->keywords_user_receive = $purifier->purify(trim($this->params()->fromPost('keywords_user_receive')));
                    $ssFilter->field_user_receive    = $this->params()->fromPost('field_user_receive');
                }
                $ssFilter->status   = $this->params()->fromPost('status');
                $ssFilter->city     = $this->params()->fromPost('city_id');
                $ssFilter->group    = $this->params()->fromPost('group_id');
                
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
        
        $redirect   = new Container($this->_namespace.'_redirect');
        $this->redirect()->toUrl($redirect->curentUrl);
        return $this->getResponse();   
    }

    
    
}
