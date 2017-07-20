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
class SurveyController extends ActionController
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
            $this->_modelTable = $this->getServiceLocator()->get('Admin\Model\SurveyTable');
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


        
    }

    public function indexAction()
    {
    	//Tiêu đề
    	$title      =  'Thăm dò ý kiến';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
       
        
       
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
        
            $totalItem      = $this->getTable()->countItem();
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
        $error          = array();
        //Tiêu đề
        $title          =  'Thăm dò ý kiến > Thêm mới';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        
        
        $surveyAdminForm       = $this->serviceLocator->get('FormElementManager')->get('surveyAdminForm');
        
        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
            $surveyAdminForm->setData($data);


            if($surveyAdminForm->isValid() && empty($error)){
               
                    //Chống tấn công XSS
                    $purifier   = new \HTMLPurifier_HTMLPurifier();
                    $data    =  array(
                        'name'          => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['name'])),
                        'date_time'     => date('d/m/y h:i:s'),
                    );
                    $survey_id = $this->getTable()->saveItem($data,array('task'=>'add'));

                    $data_answer = array(
                        'survey_id' => $survey_id,
                        'options'   => $this->_arrPost['options'] 
                    );
                    $this->getTable()->saveItem($data_answer,array('task'=>'add-answer'));

                    $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được lưu thành công');
                    $this->redirect()->toUrl('/admin/survey/');
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
            'myForm'            =>  $surveyAdminForm,
           
            
            'error'             =>  $error,
        ));
    }
    public function editAction(){
        $error          = array();
        //Tiêu đề
        $title          =  'Thăm dò ý kiến > Chỉnh sửa';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        

        $item           = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));
       
        $item_answer    = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-item-answer'));

        $surveyAdminForm       = $this->serviceLocator->get('FormElementManager')->get('surveyAdminForm');
        
        $surveyAdminForm->setInputFilter(new \Admin\Form\SurveyFilter(array('task'=>'edit', 'id'=>$this->_arrParam['id'])));
        $surveyAdminForm->bind($item);
        if($this->getRequest()->isPost()){
            $data   = $this->getRequest()->getPost();
            $surveyAdminForm->setData($data);

            
            if($surveyAdminForm->isValid() && empty($error)){
               
                //Chống tấn công XSS
                $purifier   = new \HTMLPurifier_HTMLPurifier();
                $data    =  array(
                    'id'            => $purifier->purify($this->_arrPost['id']), 
                    'name'          => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['name'])),
                );

                $this->getTable()->saveItem($data,array('task'=>'edit'));

                $data_answer = array(
                        'survey_id' => $this->_arrPost['id'],
                        'options'   => $this->_arrPost['options'] 
                );
                $this->getTable()->saveItem($data_answer,array('task'=>'edit-answer'));
                $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được lưu thành công');
                $this->redirect()->toUrl('/admin/survey/');
            }else{
                //echo '<pre>';
                //print_r($newsForm->getMessages());
                //echo '</pre>';
            }
        }


        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'myForm'            =>  $surveyAdminForm,
            'item'              =>  $item,
            'item_answer'       =>  $item_answer,
            'error'             =>  $error,
        ));
    }
   
    public function previewAction(){
        $view           = new ViewModel();
        $item           = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));
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
        $this->redirect()->toUrl('/admin/survey/');
        return $this->getResponse();    
    }
    public function statusAction(){
        if(!empty($this->_arrParam['id'])){
            $filter     = new \Zend\Filter\Digits();
            $id         = $filter->filter($this->_arrParam['id']);
            $arrParam   = array('status'=>$this->_arrParam['status'],'id'=>$id);
            $this->getTable()->saveItem($arrParam,array('task'=>'edit'));
        }
        $this->redirect()->toUrl('/admin/survey/');  
        return $this->getResponse();
    }
    public function deleteAction(){
        if(!empty($this->_arrParam['id'])){
            $filter   = new \Zend\Filter\Digits();
            $id       = $filter->filter($this->_arrParam['id']);
            $arrParam = array('id'=>$id);
            
            $this->getTable()->deleteItem($arrParam,array('task'=>'delete-item'));
            
            $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được xóa thành công');
            
        }
        $this->redirect()->toUrl('/admin/survey/');
        return $this->getResponse();    
    }
    public function multiDeleteAction(){
        if(!empty($this->_arrParam['id'])){
            $arrParam = explode(",", $this->_arrParam['id']);
            /*$items = $this->getTable()->deleteItem($arrParam,array('task'=>'list-images'));
            if(!empty($items)){
                foreach($items as $item){
                    $upload = new \ZendVN\File\Upload();
                    $upload->removeFile(UPLOAD_PATH .'/news/'.$item->images);  
                }    
            } */       
            $this->getTable()->deleteItem($arrParam,array('task'=>'multi-delete-item'));
            $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được xóa thành công');
            
        }
        $this->redirect()->toUrl('/admin/survey/');
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
        
       $this->redirect()->toUrl('/admin/survey/');
        return $this->getResponse();   
    }

    public function formOptionAction(){
        $view               = new ViewModel();
        $isXmlHttpRequest   = false;
        $data               = null;
        $currentDistrict    = null;
        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;
            
           
            $number = $this->params()->fromQuery('number');
            
        }    
        $view->setVariables(array(
            'isXmlHttpRequest'  =>  $isXmlHttpRequest,
            'data'              =>  $data,
            'currentDistrict'   =>  $currentDistrict,
            'number'            => $number 
        ));
        $view->setTerminal(true);
        return $view;
    }

    
    
}
