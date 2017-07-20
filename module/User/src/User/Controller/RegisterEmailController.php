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


class RegisterEmailController extends ActionController
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

    protected $_registerEmailTable;
    

    public function getTable(){
        if(empty($this->_registerEmailTable)){
            $this->_registerEmailTable = $this->getServiceLocator()->get('User\Model\RegisterEmailTable');
        }
        return $this->_registerEmailTable;
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
            $headLink   = $render->headLink();
            $headLink->prependStylesheet(PUBLIC_URL   .'/scripts/uploadify-v3.1/css/uploadify.css');
            $headLink->prependStylesheet(TEMPLATE_URL .'/user/css/js-form.css');
            $headLink->prependStylesheet(TEMPLATE_URL .'/user/css/blocksui/osx.css');

            //headScript
            $headScript = $render->headScript();

            //$headScript->prependFile(TEMPLATE_URL .'/user/js/jquery.min.js', 'text/javascript');
            //$headScript->prependFile(TEMPLATE_URL .'/user/js/jquery.form.js', 'text/javascript');
            $headScript->prependFile(TEMPLATE_URL .'/user/js/blocksui/jquery.simplemodal.js', 'text/javascript');
            $headScript->prependFile(TEMPLATE_URL .'/user/js/blocksui/osx.js', 'text/javascript');
            //Load templates
           	$this->layout('layout/user');


       
    }

    public function indexAction()
    {
        
        //Tiêu đề
        $title      =  'Danh sách đăng kí tìm mua bất động sản';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
        
        //Nested Menu Left
        $view       = new ViewModel();
       
        
        $itemsCity              = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-city'));
        
        
        $view->setVariables(array(
            'title'                     =>  $title,
            'arrParam'                  =>  $this->_arrParam,
            'currentController'         =>  $this->_currentController,
            'itemsCity'                 =>  $itemsCity,
            
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
                

                $this->_arrParam['userId']  = $this->identity()->id;
               
               
            }

            $totalItem      = $this->getTable()->countItem($this->_arrParam,array('task'=>'count'));
            $items          = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-items-paginator'));
            $dataItems      = $items;
               

        }    
        
        $view->setVariables(array(
            'isXmlHttpRequest'  =>  $isXmlHttpRequest,
            'items'             =>  $dataItems,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'totalItem'         =>  $totalItem,
        ));
        $view->setTerminal(true);
        return $view;


    }
    
    public function addAction()
    {
        $error = array();
        //Tiêu đề
        $title      =  'Đăng ký để nhận email về BĐS mới nhất phù hợp';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
        
        //Nested Menu Left
        $view       = new ViewModel();
       
        
        //Item select box
        $itemsTypeRealEstate  = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-type-real-estate'));
        $itemsCity            = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-city'));
        
        //Form
        $registerEmailForm       = $this->serviceLocator->get('FormElementManager')->get('registerEmailUserForm');

        if($this->getRequest()->isPost()){
            
            $data = $this->getRequest()->getPost();
            $registerEmailForm->setData($data);
            
            //Kiểm tra chọn select box
            if(empty($this->_arrPost['type_real_estate'])){
                $error[]    = 'Bạn phải chọn loại Bất động sản!';
            }if(empty($this->_arrPost['city'])){
                $error[]    = 'Bạn phải chọn Thành phố!';
            }if(empty($this->_arrPost['district'])){
                $error[]    = 'Bạn phải chọn Quận huyện!';
            }
                
            if(!empty($this->_arrPost['pricefrom']) && !empty($this->_arrPost['priceto'])){
                if($this->_arrPost['pricefrom'] > $this->_arrPost['priceto']){
                    $error[]    = 'Giá từ phải nhỏ hơn giá tới';
                }
            } 
                    
            if($registerEmailForm->isValid() && empty($error)){
                //Lấy ngày hiện tại
                $date_time = date('d/m/Y');
                

                //Chống tấn công XSS
                $purifier   = new \HTMLPurifier_HTMLPurifier();
                $data       =  array(
                    
                    'name'          => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['name'])),
                    'email'         => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['email'])),
                    'transaction'   => $purifier->purify($this->_arrPost['type_transaction']),
                    'cat_id'        => $purifier->purify($this->_arrPost['type_real_estate_child']),
                    'city'          => $purifier->purify($this->_arrPost['city']),
                    'district'      => $purifier->purify($this->_arrPost['district']),
                    'pricefrom'     => $purifier->purify($this->_arrPost['pricefrom']),
                    'priceto'       => $purifier->purify($this->_arrPost['priceto']),
                    'area'          => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['area'])),
                    'road'          => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['road'])),
                    'direction'     => $purifier->purify($this->_arrPost['direction']),
                    'juridical'     => $purifier->purify($this->_arrPost['juridical']),
                    'date_time'     => $date_time,
                    'user_id'       => $this->identity()->id,
                );

                
                $id = $this->getTable()->saveItem($data,array('task'=>'add'));
                
                $this->redirect()->toUrl('/user/register-email/index/');
            
            }
        }

        $view->setVariables(array(
            'title'                     =>  $title,
            'arrParam'                  =>  $this->_arrParam,
            'currentController'         =>  $this->_currentController,
            'itemsCity'                 =>  $itemsCity,
            'itemsTypeRealEstate'       =>  $itemsTypeRealEstate,
            'myForm'                    =>  $registerEmailForm,
            'error'                     =>  $error,
        ));
        return $view;
        
    }
    //Tin sẽ xóa khỏi danh sách
    public function deleteAction(){
        if(!empty($this->_arrParam['id'])){
            $filter   = new \Zend\Filter\Digits();
            $id       = $filter->filter($this->_arrParam['id']);
            $arrParam = array('id'=>$id);
            $this->getTable()->deleteItem($arrParam,array('task'=>'delete-item'));
            $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được xóa thành công');
            
        }
        $this->redirect()->toUrl('/user/register-email/index/');
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
                $ssFilter->city             = $this->params()->fromPost('city');
                $ssFilter->district         = $this->params()->fromPost('district');
                $ssFilter->date_start       = $this->params()->fromPost('date_start');
                $ssFilter->date_end         = $this->params()->fromPost('date_end');
                
            }if($this->_arrParam['col'] == 'null' && $this->_arrParam['by'] == 'null' && $this->_arrParam['key'] == 0){
                $ssFilter->getManager()->getStorage()->clear($this->_namespace);
            }
        }

       
        if($this->_arrParam['type'] == 'record'){
            $ssFilter->record   = $this->params()->fromPost('record');

        }
        
        $this->redirect()->toUrl('/user/statistic/realestate/');
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
    
    
    
}
