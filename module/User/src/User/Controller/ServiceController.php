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


class ServiceController extends ActionController
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

    protected $_serviceTable;
   

    public function getTable(){
        if(empty($this->_serviceTable)){
            $this->_serviceTable = $this->getServiceLocator()->get('User\Model\ServiceTable');
        }
        return $this->_serviceTable;
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

    
    public function indexAction()
    {
        
        //Tiêu đề
        $title      =  'Dịch vụ tài khoản cao cấp';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
        
        //Nested Menu Left
        $view       = new ViewModel();
       
        $array = array('service_account_id'=>1,'nomal'=>10,'vip'=>10,'hot'=>10,'free'=>10,'chinhchu'=>10,'date_start'=>'21-12-2014','date_end'=>'unlimited');
        $infoServiceAccount = \Zend\Json\Json::encode($array);
        
        $listItems              = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-items'));
        $itemThoiHanSuDung      = $this->getTable()->getItem($this->identity()->id,array('task'=>'get-item-thoi-han-su-dung'));

       
        $view->setVariables(array(
            'title'                     =>  $title,
            'arrParam'                  =>  $this->_arrParam,
            'currentController'         =>  $this->_currentController,
            'listItems'                 =>  $listItems,
            'itemThoiHanSuDung'         =>  $itemThoiHanSuDung,
            
        ));
        return $view;
        
    }
    
    public function payAction()
    {
        $error      = array();
        //Tiêu đề
        $title      =  'Thanh toán Dịch vụ tài khoản cao cấp';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
        
        //Nested Menu Left
        $view       = new ViewModel();
        
        //Kiểm tra có chọn dịch vụ không
        if(empty($this->_arrParam['id'])){
            $this->redirect()->toUrl('/user/service/index/');
        }

        $item       = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));
        
        $itemThoiHanSuDung          = $this->getTable()->getItem($this->identity()->id,array('task'=>'get-item-thoi-han-su-dung'));



        //Form
        $serviceAccountForm         = $this->serviceLocator->get('FormElementManager')->get('serviceAccountUserForm');

        //Bind
        $object = new ArrayObject(array(
            'fullname'  => $this->identity()->fullname,                
            'name'      =>  $item->name,
            'email'     =>  $this->identity()->email              
        ));
        $serviceAccountForm->bind($object);

        
        if($this->getRequest()->isPost()){
            
            $data = $this->getRequest()->getPost();
            $serviceAccountForm->setData($data);
            
            //Kiểm tra chọn select box
            if(empty($this->_arrPost['payment'])){
                $error[]    = 'Bạn phải chọn Hình thức thanh toán!';
            }
                
           
                    
            if($serviceAccountForm->isValid() && empty($error)){
                //Lấy ngày hiện tại
                $thoihan   = 182;//6 tháng
                $time       = date('d-m-Y');//ngày đăng kí
                $hansudung  = strtotime(date("d-m-Y", strtotime($time)) . " +$thoihan day");
                $hansudung  = strftime("%d-%m-%Y",$hansudung); 
                
                

                //Chống tấn công XSS
                $purifier   = new \HTMLPurifier_HTMLPurifier();
                $data       =  array(
                    'user_id'               => $this->identity()->id,
                    'date_start'            => $time,
                    'date_end'              => $hansudung,  
                    'total_price'           => $purifier->purify($this->_arrPost['total_price']),
                    'note'                  => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['note'])),
                    'service_account_id'    => $item->id,
                    'hinhthuc_thanhtoan'    => $purifier->purify($this->_arrPost['payment']),
                    'payment_status'        => 0,
                    'status'                => 0,
                    
                );

                
                $id = $this->getTable()->saveItem($data,array('task'=>'add'));
                
                $this->redirect()->toUrl('/user/account/index/');
            
            }
        }

        $view->setVariables(array(
            'title'                     =>  $title,
            'arrParam'                  =>  $this->_arrParam,
            'currentController'         =>  $this->_currentController,
            'itemThoiHanSuDung'         =>  $itemThoiHanSuDung,
            'myForm'                    =>  $serviceAccountForm,
            'error'                     =>  $error,
            'item'                      =>  $item,
            
        ));
        return $view;
        
    }
    
    
}
