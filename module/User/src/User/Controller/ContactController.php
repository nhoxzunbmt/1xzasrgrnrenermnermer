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


class ContactController extends ActionController
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

    protected $_contactTable;
   

    public function getTable(){
        if(empty($this->_contactTable)){
            $this->_contactTable = $this->getServiceLocator()->get('User\Model\ContactTable');
        }
        return $this->_contactTable;
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

    
    
    public function addAction()
    {
        $error      = array();
        //Tiêu đề
        $title      =  'Hỗ trợ/ góp ý';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
        
        //Nested Menu Left
        $view       = new ViewModel();
        
    

        //Form
        $contactForm         = $this->serviceLocator->get('FormElementManager')->get('contactUserForm');

        //Bind
        $object = new ArrayObject(array(
            'fullname'  => $this->identity()->fullname,                
            'email'     =>  $this->identity()->email              
        ));
        $contactForm->bind($object);

        
        if($this->getRequest()->isPost()){
            
            $data = $this->getRequest()->getPost();
            $contactForm->setData($data);
            
            
                    
            if($contactForm->isValid() && empty($error)){
              
                $time       = date('d-m-Y');//ngày đăng kí
               
                

                //Chống tấn công XSS
                $purifier   = new \HTMLPurifier_HTMLPurifier();
                $data       =  array(
                    'fullname'              => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['fullname'])),
                    'email'                 => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['email'])),
                    'phone'                 => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['phone'])),
                    'title'                 => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['title'])),
                    'content'               => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['content'])),
                    'date_time'             => date('d/m/y h:i:s'),
                );

                
                $id = $this->getTable()->saveItem($data,array('task'=>'add'));
                
                $this->redirect()->toUrl('/user/account/index/');
            
            }
        }

        $view->setVariables(array(
            'title'                     =>  $title,
            'arrParam'                  =>  $this->_arrParam,
            'currentController'         =>  $this->_currentController,
            
            'myForm'                    =>  $contactForm,
            'error'                     =>  $error,
           
            
        ));
        return $view;
        
    }
    
    
}
