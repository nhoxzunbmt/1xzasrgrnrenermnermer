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
class FengshuiController extends ActionController
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

    protected $_newsTable;
    protected $_userGroupTable;

    public function getTable(){
        if(empty($this->_newsTable)){
            $this->_newsTable = $this->getServiceLocator()->get('Home\Model\FengshuiTable');
        }
        return $this->_newsTable;
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
    public function indexAction(){
        $view                   = new ViewModel();
    
        //Tiêu đề
        $title                  =  'Phong thủy';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
       
    
       
        //Danh mục
        $listItemsCategory      = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-items-category')); 

        
       

        $view->setVariables(array(
            'title'                     =>  $title,
            'arrParam'                  =>  $this->_arrParam,
            'currentController'         =>  $this->_currentController,
            'listItemsCategory'         =>  $listItemsCategory,
        ));
        return $view;
        
    
    }
    public function fengshuiappAction(){
        $view                   = new ViewModel();
    
        //Tiêu đề
        $title                  =  'Tra cứu Phong thủy';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
       
    
        //Phong thủy mới nhất
        $listItemsFengshuiNewsMoiNhat   = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-items-fengshui-news-moi-nhat')); 
        
        //Danh mục
        $listItemsCategory      = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-items-category')); 



       
        //Form tra cứu phong thủy
        $fengshuiForm   = $this->serviceLocator->get('FormElementManager')->get('fengshuiForm');


        $view->setVariables(array(
            'title'                     =>  $title,
            'arrParam'                  =>  $this->_arrParam,
            'currentController'         =>  $this->_currentController,
            'listItemsCategory'         =>  $listItemsCategory,
            'fengshuiForm'              =>  $fengshuiForm,
        ));
        return $view;
        
    
    }
    
    
    public function categoryAction()
    {
        
        $view                   = new ViewModel();
    
        //Tiêu đề
        $title                  =  'Danh mục phong thủy';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
       
        
       
        //Danh mục
        $listItemsCategory      = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-items-category')); 

        //category info
        $categoryInfo           = $this->getTable()->getItem($this->_arrParam,array('task'=>'category-frontend')); 
        
        //breadcrumb
        $breadcrumb             = $this->getTable()->listItem($categoryInfo,array('task'=>'list-breadcrumb')); 
        
       

        $view->setVariables(array(
            'title'                     =>  $title,
            'arrParam'                  =>  $this->_arrParam,
            'currentController'         =>  $this->_currentController,
            'breadcrumb'                =>  $breadcrumb,
            'listItemsCategory'         =>  $listItemsCategory,
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
                
                $this->_paginatorParams['currentPageNumber']= $this->params()->fromQuery('page',1);
                $this->_arrParam['paginator']               = $this->_paginatorParams;
 
            }
            //Danh mục
            $listCategory      = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-category')); 

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
            'listCategory'      =>  $listCategory,
            
        ));
        $view->setTerminal(true);
        return $view;



    }

    //Ajax load indexAction
    public function categoryAjaxAction(){
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
                $this->_arrParam['cat_id']                  = $this->params()->fromQuery('catid');
                $this->_arrParam['name']                    = $this->params()->fromQuery('name');
                $this->_paginatorParams['currentPageNumber']= $this->params()->fromQuery('page',1);
                $this->_arrParam['paginator']               = $this->_paginatorParams;
 
            }
            //Danh mục
            $listCategory      = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-category')); 

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
            'listCategory'      =>  $listCategory,
            
        ));
        $view->setTerminal(true);
        return $view;



    }


    
    
    public function detailAction()
    {
        
        $view               = new ViewModel();
        
        
        //Chi tiết
        $item               = $this->getTable()->getItem($this->_arrParam); 

        //Tin tương tự
        $itemsTuongTu       = $this->getTable()->listItem($this->_arrParam,array('task'=>'tin-tuong-tu')); 
        
        //category info
        $this->_arrParam['id']  = $this->_arrParam['cid'];
        $categoryInfo           = $this->getTable()->getItem($this->_arrParam,array('task'=>'category-frontend')); 
        //breadcrumb
        $breadcrumb             = $this->getTable()->listItem($categoryInfo,array('task'=>'list-breadcrumb')); 
        

        //Tiêu đề
        $title              =  $item['title'];   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");

        $view->setVariables(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'item'              =>  $item,
            'itemsTuongTu'      =>  $itemsTuongTu,
            'breadcrumb'        =>  $breadcrumb,
        ));
        return $view;
        
    }

    public function printAction()
    {
        
        $view               = new ViewModel();
        
        //Chi tiết
        $item               = $this->getTable()->getItem($this->_arrParam); 


        //Tiêu đề
        $title              =  $item['title'];   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");

        $view->setVariables(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'item'              =>  $item,
            
          
        ));
        $view->setTerminal(true);
        return $view;
        
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

   

    
}
