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
class SeoController extends ActionController
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

    protected $_options = array(
        'tableName' =>  'Admin\Model\CategoryTable',
        'formName'  =>  'seoAdminForm',
    );

 

    public function init(){
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
            $ssFilter->col          = 'left';
            $ssFilter->order        = 'ASC';
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
        $this->_arrParam['ssFilter']['level']       = $ssFilter->level;
        $this->_arrParam['ssFilter']['group']       = $ssFilter->group;
        $this->_arrParam['ssFilter']['city']        = $ssFilter->city;

        $this->_paginatorParams['itemCountPerPage'] = (int) $ssFilter->record;
        $this->_paginatorParams['currentPageNumber']= $this->params()->fromRoute('page',1);
        $this->_arrParam['paginator']               = $this->_paginatorParams;

        
        //Load templates
        $this->layout('layout/list');
    }

   
   
    /*public function setEventManager(EventManagerInterface $events)
    {
        parent::setEventManager($events);

        


        }, 100); // execute before executing action logic
    }*/
    public function indexAction()
    {
        
        //Tiêu đề
        $title      =  'SEO danh mục nhà đẹp';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        $ssFilter   = new Container($this->_namespace);
        $ssFilter->url = '/admin/seo/index';

        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
           
            
            'currentController' =>  $this->_currentController,
        ));
 
        
    }
    //Ajax load indexAction
    public function indexAjaxAction(){
        $view               = new ViewModel();
        $dataItems          = null;
        $dataPaginator      = null;
        $isXmlHttpRequest   = false;

        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;
            $this->_arrParam['type_category']           = 'category_nicehouse';
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

    public function nicehouseCategoryAction()
    {
        
        //Tiêu đề
        $title      =  'SEO danh mục nhà đẹp';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        $ssFilter   = new Container($this->_namespace);
        $ssFilter->url = '/admin/seo/nicehouse-category';

        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
           
            
            'currentController' =>  $this->_currentController,
        ));
 
        
    }
    //Ajax load indexAction
    public function nicehouseCategoryAjaxAction(){
        $view               = new ViewModel();
        $dataItems          = null;
        $dataPaginator      = null;
        $isXmlHttpRequest   = false;

        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;
            $this->_arrParam['type_category']           = 'category_nicehouse';
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

    public function newsCategoryAction()
    {
        //Tiêu đề
        $title      =  'SEO danh mục tin tức';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        $ssFilter   = new Container($this->_namespace);
        $ssFilter->url = '/admin/seo/news-category';

        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
           
            
            'currentController' =>  $this->_currentController,
        ));
 
        
    }
    //Ajax load indexAction
    public function newsCategoryAjaxAction(){
        $view               = new ViewModel();
        $dataItems          = null;
        $dataPaginator      = null;
        $isXmlHttpRequest   = false;

        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;
            $this->_arrParam['type_category']           = 'category_news';
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

    public function projectCategoryAction()
    {
        //Tiêu đề
        $title      =  'SEO danh mục dự án';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        $ssFilter   = new Container($this->_namespace);
        $ssFilter->url = '/admin/seo/project-category';

        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
           
            
            'currentController' =>  $this->_currentController,
        ));
 
        
    }
    //Ajax load indexAction
    public function projectCategoryAjaxAction(){
        $view               = new ViewModel();
        $dataItems          = null;
        $dataPaginator      = null;
        $isXmlHttpRequest   = false;

        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;
            $this->_arrParam['type_category']           = 'category_project';
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

    public function realestateCategoryAction()
    {
        //Tiêu đề
        $title      =  'SEO danh mục bất động sản';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        $ssFilter   = new Container($this->_namespace);
        $ssFilter->url = '/admin/seo/realestate-category';

        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
           
            
            'currentController' =>  $this->_currentController,
        ));
 
        
    }
    //Ajax load indexAction
    public function realestateCategoryAjaxAction(){
        $view               = new ViewModel();
        $dataItems          = null;
        $dataPaginator      = null;
        $isXmlHttpRequest   = false;

        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;
            $this->_arrParam['type_category']           = 'category_realestate';
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

    public function businessCategoryAction()
    {
        //Tiêu đề
        $title      =  'SEO danh mục doanh nghiệp';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        $ssFilter   = new Container($this->_namespace);
        $ssFilter->url = '/admin/seo/business-category';

        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
           
            
            'currentController' =>  $this->_currentController,
        ));
 
        
    }
    //Ajax load indexAction
    public function businessCategoryAjaxAction(){
        $view               = new ViewModel();
        $dataItems          = null;
        $dataPaginator      = null;
        $isXmlHttpRequest   = false;

        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;
            $this->_arrParam['type_category']           = 'category_business';
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

    public function legalhousingCategoryAction()
    {
        //Tiêu đề
        $title      =  'SEO danh mục pháp lý nhà đất';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        $ssFilter   = new Container($this->_namespace);
        $ssFilter->url = '/admin/seo/legalhousing-category';

        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
           
            
            'currentController' =>  $this->_currentController,
        ));
 
        
    }
    //Ajax load indexAction
    public function legalhousingCategoryAjaxAction(){
        $view               = new ViewModel();
        $dataItems          = null;
        $dataPaginator      = null;
        $isXmlHttpRequest   = false;

        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;
            $this->_arrParam['type_category']           = 'category_legalhousing';
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

    public function legislationhousingCategoryAction()
    {
        //Tiêu đề
        $title      =  'SEO danh mục văn bản luật';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        $ssFilter   = new Container($this->_namespace);
        $ssFilter->url = '/admin/seo/legislationhousing-category';

        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
           
            
            'currentController' =>  $this->_currentController,
        ));
 
        
    }
    //Ajax load indexAction
    public function legislationhousingCategoryAjaxAction(){
        $view               = new ViewModel();
        $dataItems          = null;
        $dataPaginator      = null;
        $isXmlHttpRequest   = false;

        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;
            $this->_arrParam['type_category']           = 'category_legislationhousing';
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

    public function contractformCategoryAction()
    {
        //Tiêu đề
        $title      =  'SEO danh mục biểu mẫu hợp đồng';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        $ssFilter   = new Container($this->_namespace);
        $ssFilter->url = '/admin/seo/contractform-category';

        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
           
            
            'currentController' =>  $this->_currentController,
        ));
 
        
    }
    //Ajax load indexAction
    public function contractformCategoryAjaxAction(){
        $view               = new ViewModel();
        $dataItems          = null;
        $dataPaginator      = null;
        $isXmlHttpRequest   = false;

        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;
            $this->_arrParam['type_category']           = 'category_contractform';
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

    public function fengshuiCategoryAction()
    {
        //Tiêu đề
        $title      =  'SEO danh mục biểu mẫu hợp đồng';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        $ssFilter   = new Container($this->_namespace);
        $ssFilter->url = '/admin/seo/fengshui-category';

        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
           
            
            'currentController' =>  $this->_currentController,
        ));
 
        
    }
    //Ajax load indexAction
    public function fengshuiCategoryAjaxAction(){
        $view               = new ViewModel();
        $dataItems          = null;
        $dataPaginator      = null;
        $isXmlHttpRequest   = false;

        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true){
            $isXmlHttpRequest = true;
            $this->_arrParam['type_category']           = 'category_fengshui';
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
    public function editAction(){
        $error          = array();
        //Tiêu đề
        $title          =  'SEO danh mục nhà đẹp > Chỉnh sửa';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");
        $ssFilter   = new Container($this->_namespace);
        

        $item           = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item'));
       
        
        $seoAdminForm   = $this->getForm();
        
        $seoAdminForm ->setInputFilter(new \Admin\Form\SeoFilter(array('task'=>'edit', 'id'=>$this->_arrParam['id'])));
        $seoAdminForm ->bind($item);
        if($this->getRequest()->isPost()){
            $data   = $this->getRequest()->getPost();
            $seoAdminForm ->setData($data);

            if($seoAdminForm->isValid() && empty($error)){
                
                //Chống tấn công XSS
                $purifier   = new \HTMLPurifier_HTMLPurifier();
                $data    =  array(
                    'id'                => $purifier->purify($this->_arrPost['id']), 
                    'seo_title'         => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['name'])),
                    'seo_keyword'       => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['seo_keyword'])),
                    'seo_description'   => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['seo_description'])),
                );

                $this->getTable()->saveItem($data,array('task'=>'update-seo'));
                $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được lưu thành công');
                $this->redirect()->toUrl($ssFilter->url);
            }else{
                //echo '<pre>';
                //print_r($niceHouseCategoryAdminForm->getMessages());
                //echo '</pre>';
            }
        }


        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'myForm'            =>  $seoAdminForm,
            'item'              =>  $item,
            'error'             =>  $error,
            
        ));
    }
    
    
    public function previewAction(){
        $view = new ViewModel();
        $item = $this->getTable()->getItem($this->_arrParam);
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
        $this->redirect()->toUrl('/admin/nicehouse-category/');
        return $this->getResponse();    
    }
    public function statusAction(){
        if(!empty($this->_arrParam['id'])){
            $filter     = new \Zend\Filter\Digits();
            $id         = $filter->filter($this->_arrParam['id']);
            $arrParam   = array('status'=>$this->_arrParam['status'],'id'=>$id);
            $this->getTable()->saveItem($arrParam,array('task'=>'edit'));
        }
        $this->redirect()->toUrl('/admin/nicehouse-category/');
        return $this->getResponse();
    }
    public function moveupAction(){
        if(!empty($this->_arrParam['id'])){
            $filter     = new \Zend\Filter\Digits();
            $id         = $filter->filter($this->_arrParam['id']);
            $arrParam   = array('id'=>$id);
            $this->getTable()->moveItem($arrParam,array('task'=>'up'));
        }
        $this->flashMessenger()->addSuccessMessage('Thứ tự của Dữ liệu đã được cập nhật thành công');
        $this->redirect()->toUrl('/admin/nicehouse-category/');
        return $this->getResponse();
    }
    public function movedownAction(){
        if(!empty($this->_arrParam['id'])){
            $filter     = new \Zend\Filter\Digits();
            $id         = $filter->filter($this->_arrParam['id']);
            $arrParam   = array('id'=>$id);
            $this->getTable()->moveItem($arrParam,array('task'=>'down'));
        }
        $this->flashMessenger()->addSuccessMessage('Thứ tự của Dữ liệu đã được cập nhật thành công');
        $this->redirect()->toUrl('/admin/nicehouse-category/');
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
        $this->redirect()->toUrl('/admin/usergroup/');
        return $this->getResponse();    
    }
    public function multiDeleteAction(){
        if(!empty($this->_arrParam['id'])){
            $arrParam = explode(",", $this->_arrParam['id']);
             
            $this->getTable()->deleteItem($arrParam,array('task'=>'multi-delete-item'));
            $this->flashMessenger()->addSuccessMessage('Dữ liệu đã được xóa thành công');
            
        }
        $this->redirect()->toUrl('/admin/nicehouse-category/');
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
                $ssFilter->level    = $this->params()->fromPost('level');
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
        
        $this->redirect()->toUrl('/admin/nicehouse-category/');
        return $this->getResponse();   
    }

    
    
}
