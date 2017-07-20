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
class AgencyController extends ActionController
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

    protected $_agencyTable;
    

    public function getTable(){
        if(empty($this->_agencyTable)){
            $this->_agencyTable = $this->getServiceLocator()->get('Home\Model\AgencyTable');
        }
        return $this->_agencyTable;
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
            $this->layout('layout/home');


        
    }

    
    public function searchAction()
    {
        $dataItems          = null;
        $dataPaginator      = null;
        $view               = new ViewModel();
    
        //Tiêu đề
        $title              =  'Tìm kiếm môi giới Bất động sản';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
        $totalItem          = $this->getTable()->countItem();

        //List Loại doanh nghiêp
        $itemsTypeBusiness  = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-type-business')); 
        
        
        $itemsCategory      = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-item-type-business')); 
        //Thành phố
        $itemsCity          = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-city')); 
        $listCity           = array_slice($itemsCity,1,count($itemsCity) - 1);
        
    
        //nested
        $view->setTemplate('home/agency/search');
        $formSearchAgency   = new ViewModel(array(
            'totalItem'         =>  $totalItem,
            'itemsTypeBusiness' =>  $itemsTypeBusiness,
            'itemsCity'         =>  $itemsCity,
            'itemsCategory'     =>  $itemsCategory,
        ));
        $formSearchAgency->setTemplate('home/agency/nested-form-search-agency');

      

        $view->addChild($formSearchAgency, 'formSearchAgency');
             
        //end nested
        
         
        
        $currentPage = (!empty($this->_arrParam['page'])) ? $this->_arrParam['page'] : '1';
        $this->_paginatorParams['currentPageNumber']= $currentPage;
            
        if($this->params()->fromQuery() == true){
               
            //Lọc tin
            $this->_arrParam['q']           = $this->params()->fromQuery('q');
            $this->_arrParam['cityid']      = $this->params()->fromQuery('city');
            $this->_arrParam['iddistrict']  = $this->params()->fromQuery('district');
            
            $this->_paginatorParams['currentPageNumber']= $this->params()->fromQuery('page',1);
            $this->_arrParam['paginator']               = $this->_paginatorParams;

            
            $totalItem      = $this->getTable()->countItem($this->_arrParam);
            $items          = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-items-paginator'));
            $dataItems      = $items;
            $dataPaginator  = \ZendVN\Paginator\Paginator::createPaginator($totalItem,$this->_paginatorParams);
            
        }     

        $view->setVariables(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'listCity'          =>  $listCity,
            'items'             =>  $dataItems,
            'paginator'         =>  $dataPaginator,
            'totalItem'         =>  $totalItem,
            
        ));
        return $view;
        
    }
    public function categoryAction()
    {
        
        $view               = new ViewModel();
        //Tiêu đề
        $title              =  'Môi giới Bất động sản';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
        $totalItem          = $this->getTable()->countItem();

        //List Loại doanh nghiêp
        $itemsTypeBusiness  = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-type-business')); 
        
        
        $itemsCategory      = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-item-type-business')); 
        //Thành phố
        $itemsCity          = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-city')); 
        $listCity           = array_slice($itemsCity,1,count($itemsCity) - 1);


        //nested
        $view->setTemplate('home/agency/category');
        $formSearchAgency   = new ViewModel(array(
            'totalItem'         =>  $totalItem,
            'itemsTypeBusiness' =>  $itemsTypeBusiness,
            'itemsCity'         =>  $itemsCity,
            'itemsCategory'     =>  $itemsCategory,
        ));
        $formSearchAgency->setTemplate('home/agency/nested-form-search-agency');

       


        $view->addChild($formSearchAgency, 'formSearchAgency');
             
        //end nested
        
       
        $items          = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-items-hightlight'));
          

        $view->setVariables(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'totalItem'         =>  $totalItem,
            'itemsTypeBusiness' =>  $itemsTypeBusiness,
            'itemsCity'         =>  $itemsCity,
            'itemsCategory'     =>  $itemsCategory,
            'listCity'          =>  $listCity,
            'items'            =>  $items,
        ));
        return $view;
        
    }
    //Ajax load indexAction
    public function listAction(){
        $view               = new ViewModel();
        $dataItems          = null;
        $dataPaginator      = null;
        $isXmlHttpRequest   = false;
        $identityId         = (!empty($this->identity()->id)) ? $this->identity()->id : '';
        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;

            if($this->params()->fromQuery() == true){
               
                //Lọc tin
                $this->_arrParam['cityid']                  = $this->params()->fromQuery('cityid');
                $this->_arrParam['cityname']                = $this->params()->fromQuery('cityname');
                $this->_paginatorParams['currentPageNumber']= $this->params()->fromQuery('page',1);
                $this->_arrParam['paginator']               = $this->_paginatorParams;
            }
            
            
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
    
    public function detailAction()
    {
        
        $view               = new ViewModel();
        //Chi tiết
        $item               = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item')); 
        //Đang môi giới
        $itemsDangMoigioi      = $this->getTable()->listItem($this->_arrParam,array('task'=>'dang-moi-gioi')); 
       
        //Tiêu đề
        $title              =  $item->fullname;   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");

       

        //Form liên hệ
        $contactMeForm      = $this->serviceLocator->get('FormElementManager')->get('contactMeForm');
        //Bind
        $object = new ArrayObject(array(
                'contact-me-user-id'            => $item->id                
                                          
        ));
        $contactMeForm->bind($object);


        $view->setVariables(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'item'              =>  $item,
            'itemsDangMoigioi'  =>  $itemsDangMoigioi,
            'contactMeForm'     =>  $contactMeForm,
            
        ));
        return $view;
        
    }

    
    //Gửi liên hệ
    public function contactMeAction(){
        $contactMeForm   = $this->serviceLocator->get('FormElementManager')->get('contactMeForm');
        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost();
            $contactMeForm->setData($data);
            if($contactMeForm->isValid()){
                //insert db
                //Chống tấn công XSS
                $purifier   = new \HTMLPurifier_HTMLPurifier();
                $data   =   array(
                    'user_id'           =>  $this->_arrPost['contact-me-user-id'],
                    'fullname'          =>  $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['contact-me-fullname'])),
                    'phone'             =>  $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['contact-me-phone'])),
                    'email'             =>  $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['contact-me-email'])),
                    'content'           =>  $purifier->purify($this->_arrPost['contact-me-content']),
                    'date_time'         =>  date('d/m/y h:i:s'),
                );

                $item   = $this->getTable()->saveItem($data,array('task'=>'contact-me'));  
                $result['status']               =  'success';
                $result['messages']['success']  =  'Gửi liên hệ thành công';
            }else{
                $result['status']               =  'error';
                $result['messages']['fullname'] =  current($contactMeForm->getMessages('contact-me-fullname'));
                $result['messages']['phone']    =  current($contactMeForm->getMessages('contact-me-phone'));
                $result['messages']['email']    =  current($contactMeForm->getMessages('contact-me-email'));
                $result['messages']['content']  =  current($contactMeForm->getMessages('contact-me-content'));
            }
        } 
        echo \Zend\Json\Json::encode($result);     
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
                $ssFilter->status           = $this->params()->fromPost('status');
                $ssFilter->city             = $this->params()->fromPost('city');
                $ssFilter->district         = $this->params()->fromPost('district');
                $ssFilter->type_news        = $this->params()->fromPost('type_news');
                $ssFilter->type_transaction = $this->params()->fromPost('type_transaction');
                $ssFilter->type_real_estate = $this->params()->fromPost('type_real_estate');
                $ssFilter->date_start       = $this->params()->fromPost('date_start');
                $ssFilter->date_end         = $this->params()->fromPost('date_end');
                
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
        
        $this->redirect()->toUrl('/bat-dong-san/nha-dat-ban-123.html');
        return $this->getResponse();   
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

    //===action nested====
    public function nestedFormSearchAgencyAction(){
       
    }

    public function nestedContentRightColumnAction(){

    }

   

    
}
