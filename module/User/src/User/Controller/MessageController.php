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
        'itemCountPerPage'  =>  5,
        'pageRange'         =>  4,

    );

    protected $_messageTable;
   

    public function getTable(){
        if(empty($this->_messageTable)){
            $this->_messageTable = $this->getServiceLocator()->get('User\Model\MessageTable');
        }
        return $this->_messageTable;
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


            //Load templates
           	$this->layout('layout/user');


       
    }
    public function viewSendAction()
    {
        
        //Tiêu đề
        $title      =  'Đọc tin';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
        
        //Nested Menu Left
        $view       = new ViewModel();
        
       
        $item          = $this->getTable()->getItem($this->_arrParam,array('task'=>'view-send'));
           
       
        $view->setVariables(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'item'              =>  $item,
            
        ));
        return $view;
        
    }

     public function viewReceiveAction()
    {
        
        //Tiêu đề
        $title      =  'Đọc tin';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
        
        //Nested Menu Left
        $view       = new ViewModel();
        
       
        $item          = $this->getTable()->getItem($this->_arrParam,array('task'=>'view-receive'));
           
       
        $view->setVariables(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'item'              =>  $item,
            
        ));
        return $view;
        
    }
    
    public function sendAction()
    {
        
        //Tiêu đề
        $title      =  'Hộp thư đi';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
        
        //Nested Menu Left
        $view       = new ViewModel();
        
        $this->_arrParam['idUser'] = $this->identity()->id;
        
        $totalItem      = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-hop-thu-di'));
        $items          = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-item-hop-thu-di'));
        $dataItems      = $items;
        $dataPaginator  = \ZendVN\Paginator\Paginator::createPaginator($totalItem,$this->_paginatorParams);    
       
        $view->setVariables(array(
            'title'                     =>  $title,
            'items'             =>  $dataItems,
            'paginator'         =>  $dataPaginator,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'totalItem'         =>  $totalItem,
            
        ));
        return $view;
        
    }

    public function receiveAction()
    {
        
        //Tiêu đề
        $title      =  'Hộp thư đến';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
        
        //Nested Menu Left
        $view       = new ViewModel();
       
       
       
        $this->_arrParam['idUser'] = $this->identity()->id;
        
        $totalItem      = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-hop-thu-den'));
        $items          = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-item-hop-thu-den'));
        $dataItems      = $items;
        $dataPaginator  = \ZendVN\Paginator\Paginator::createPaginator($totalItem,$this->_paginatorParams);    
       
        $view->setVariables(array(
            'title'                     =>  $title,
            'items'             =>  $dataItems,
            'paginator'         =>  $dataPaginator,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'totalItem'         =>  $totalItem,
            
        ));
        return $view;
        
    }
    
    public function addAction()
    {
        $error      = array();
        //Tiêu đề
        $title      =  'Gửi tin nhắn';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
        
        //Nested Menu Left
        $view       = new ViewModel();
    

        //Form
        $messageUserForm         = $this->serviceLocator->get('FormElementManager')->get('messageUserForm');

       

        
        if($this->getRequest()->isPost()){
            
            $data   = $this->getRequest()->getPost();
            $messageUserForm->setData($data);
            
            $result  = $this->getTable()->getItem($this->_arrPost['username'],array('task'=>'check-username'));
            
           
            if(empty($result)){
                $error[] = 'Thành viên này không tồn tại';
            }else{
                $idUser = $result[0]['id'];
                if($idUser == $this->identity()->id){
                    $error[] = 'Bạn không thể gửi tin cho chính mình';
                }
            }

            if($messageUserForm->isValid() && empty($error)){
               

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

                $this->redirect()->toUrl('/user/message/send/');
            
            }
        }

        $view->setVariables(array(
            'title'                     =>  $title,
            'arrParam'                  =>  $this->_arrParam,
            'currentController'         =>  $this->_currentController,
            
            'myForm'                    =>  $messageUserForm,
            'error'                     =>  $error,
           
            
        ));
        return $view;
        
    }

    public function multiDeleteSendAction(){
        if(!empty($this->_arrParam['id'])){
            $arrParam = explode(",", $this->_arrParam['id']);
               
            $this->getTable()->deleteItem($arrParam,array('task'=>'multi-delete-item-message-send'));
            $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được xóa thành công');
            
        }
        $this->redirect()->toUrl('/user/message/send/');
        return $this->getResponse();    
    }
    public function multiDeleteReceiveAction(){
        if(!empty($this->_arrParam['id'])){
            $arrParam = explode(",", $this->_arrParam['id']);
               
            $this->getTable()->deleteItem($arrParam,array('task'=>'multi-delete-item-message-receive'));
            $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được xóa thành công');
            
        }
        $this->redirect()->toUrl('/user/message/receive/');
        return $this->getResponse();    
    }
    
}
