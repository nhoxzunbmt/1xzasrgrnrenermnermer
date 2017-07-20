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
class BusinessController extends ActionController
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

    protected $_businessTable;
    

    public function getTable(){
        if(empty($this->_businessTable)){
            $this->_businessTable = $this->getServiceLocator()->get('Home\Model\BusinessTable');
        }
        return $this->_businessTable;
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

    public function businessAction()
    {
        
        $view               = new ViewModel();
    
        //Tiêu đề
        $title              =  'Doanh nghiệp Bất động sản';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
        $totalItem          = $this->getTable()->countItem();

        //List Loại doanh nghiêp
        $itemsTypeBusiness  = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-type-business')); 
        
        
        $itemsCategory      = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-item-type-business')); 
        //Thành phố
        $itemsCity          = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-city')); 
        $listCity           = array_slice($itemsCity,1,count($itemsCity) - 1);
        
        //Doanh nghiệp nổi bật
        $itemBusinessHighlight      = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-items-business-highlight')); 
        
        $statisticsBusiness         = $this->getTable()->listItem($this->_arrParam,array('task'=>'statistics-type-business')); 
        
        //list
        $router         = $this->getEvent()->getRouter();
        $xhtml          = '';
        foreach ($statisticsBusiness as $key => $item) {
            
            $urlCategory       = $router->assemble(
                array(
                    'action'=>'category',
                    'name'=>\ZendVN\Url\FriendlyLink::filter($item['name']),
                    'page'=>1,'id'=>$item['id']
                ),
                array('name' => 'CategoryBusinessRoute')
            );
 
            $xhtml          .= ' <li><h2><span>'.$item['name'].'</span><a href="'.$urlCategory.'" title="Xem thêm các sàn giao dịch bất động sản">('.$item['count'].') Doanh nghiệp</a></h2>';
            $business       = $this->getTable()->listItem($item,array('task'=>'list-items-business')); 
            foreach ($business as  $val) {
                $logo       = (!empty($val['logo']))  ? UPLOAD_URL .'/logo-business/'.$val['logo'] :  TEMPLATE_URL .'/admin/images/NoImage.jpg';
                
                
                $linkIntro  = $router->assemble(array('action'=>'detail','alias'=>$val['alias']), array('name' => 'IntroBusinessRoute'));

               
                $xhtml      .= ' <div class="content">
                                    <div class="infoGroup" onmouseover="javascript:$(\'#div_enb0000027\').show();" onmouseout="javascript:$(\'#div_enb0000027\').hide();">
                                            <a href="'.$linkIntro.'" title="'.$val['name'].'" class="avatar">
                                            <img src="'.$logo.'" width="95" alt="'.$val['name'].'" title="'.$val['name'].'">
                                            </a>
                                            <div class="text">
                                            <h3>
                                              <a href="'.$linkIntro.'" title="'.$val['name'].'">'.$val['name'].'</a>
                                              <span>'.$val['address'].'</span>
                                              <span>ĐT: '.$val['phone'].' &nbsp;&nbsp;|&nbsp;&nbsp; Fax: '.$val['fax'].'</span>
                                            </h3>
                                            <p>
                                             '.\ZendVN\Filter\ReadMore::create($val['intro'],0,300).'<a href="'.$val['website'].'" title="'.$val['website'].'">'.$val['website'].'</a>
                                            </p>
                                            </div>
                                    </div>

                                </div>';
               
            }
            $xhtml .'</li>' ;   
        }


        //nested
        $view->setTemplate('home/business/business');
        $formSearchBusiness   = new ViewModel(array(
            'totalItem'         =>  $totalItem,
            'itemsTypeBusiness' =>  $itemsTypeBusiness,
            'itemsCity'         =>  $itemsCity,
            'itemsCategory'     =>  $itemsCategory,
        ));
        $formSearchBusiness->setTemplate('home/business/nested-form-search-business');

       

        $view->addChild($formSearchBusiness, 'formSearchBusiness');
            
        //end nested


        $view->setVariables(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'listCity'          =>  $listCity,
            'itemBusinessHighlight'   =>  $itemBusinessHighlight,
            'xhtmlBusiness'=>  $xhtml,
        ));
        return $view;
        
    }
    public function searchAction()
    {
        $view               = new ViewModel();
        //Tiêu đề
        $title              =  'Danh mục doanh nghiệp Bất động sản';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
        $totalItem          = $this->getTable()->countItem();

        //List Loại doanh nghiêp
        $itemsTypeBusiness  = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-type-business')); 
        
        
        $itemsCategory      = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-item-type-business')); 
        //Thành phố
        $itemsCity          = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-city')); 
        $listCity           = array_slice($itemsCity,1,count($itemsCity) - 1);


        //nested
        $view->setTemplate('home/business/search');
        $formSearchBusiness   = new ViewModel(array(
            'totalItem'         =>  $totalItem,
            'itemsTypeBusiness' =>  $itemsTypeBusiness,
            'itemsCity'         =>  $itemsCity,
            'itemsCategory'     =>  $itemsCategory,
        ));
        $formSearchBusiness->setTemplate('home/business/nested-form-search-business');

       

        $view->addChild($formSearchBusiness, 'formSearchBusiness');
             
        //end nested
        $this->_arrParam['q'] = $this->params()->fromQuery('q');
        $this->_arrParam['type'] = $this->params()->fromQuery('type');
        $this->_arrParam['city'] = $this->params()->fromQuery('city');
        $this->_arrParam['district'] = $this->params()->fromQuery('district');
        $this->_arrParam['page'] = $this->params()->fromQuery('page');

        $view->setVariables(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'totalItem'         =>  $totalItem,
            'itemsTypeBusiness' =>  $itemsTypeBusiness,
            'itemsCity'         =>  $itemsCity,
            'itemsCategory'     =>  $itemsCategory,
            'listCity'          =>  $listCity,
            
        ));
        return $view;
        
    }
    //Ajax load indexAction
    public function searchAjaxAction(){
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

                $this->_arrParam['id'] = $this->params()->fromQuery('type');
                $this->_arrParam['cityid'] = $this->params()->fromQuery('city');
                $this->_arrParam['iddistrict'] = $this->params()->fromQuery('district');
                $this->_arrParam['q'] = $this->params()->fromQuery('q');
                $this->_arrParam['page'] = $this->params()->fromQuery('page');
                $this->_paginatorParams['currentPageNumber']= $this->params()->fromQuery('page',1);
                $this->_arrParam['paginator']               = $this->_paginatorParams;
            }
            
            //get info loại doanh nghiệp
            //$itemType_Business  = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item-type-business')); 

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
    public function categoryAction()
    {
        
        $view               = new ViewModel();
        //Tiêu đề
        $title              =  'Danh mục doanh nghiệp Bất động sản';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
        $totalItem          = $this->getTable()->countItem();

        //List Loại doanh nghiêp
        $itemsTypeBusiness  = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-type-business')); 
        
        
        $itemsCategory      = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-item-type-business')); 
        //Thành phố
        $itemsCity          = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-city')); 
        $listCity           = array_slice($itemsCity,1,count($itemsCity) - 1);


        //nested
        $view->setTemplate('home/business/category');
        $formSearchBusiness   = new ViewModel(array(
            'totalItem'         =>  $totalItem,
            'itemsTypeBusiness' =>  $itemsTypeBusiness,
            'itemsCity'         =>  $itemsCity,
            'itemsCategory'     =>  $itemsCategory,
        ));
        $formSearchBusiness->setTemplate('home/business/nested-form-search-business');

       

        $view->addChild($formSearchBusiness, 'formSearchBusiness');
             
        //end nested

        

        $view->setVariables(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'totalItem'         =>  $totalItem,
            'itemsTypeBusiness' =>  $itemsTypeBusiness,
            'itemsCity'         =>  $itemsCity,
            'itemsCategory'     =>  $itemsCategory,
            'listCity'          =>  $listCity,
            
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
                $this->_arrParam['id']                      = $this->params()->fromQuery('id');
                $this->_arrParam['name']                    = $this->params()->fromQuery('nameUrl');
                $this->_paginatorParams['currentPageNumber']= $this->params()->fromQuery('page',1);
                $this->_arrParam['paginator']               = $this->_paginatorParams;
            }
            
            //get info loại doanh nghiệp
            $itemType_Business  = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item-type-business')); 

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
            'itemType_Business' =>  $itemType_Business,
        ));
        $view->setTerminal(true);
        return $view;


    }
    //Doanh nghiệp theo thành phố
    public function cityAction()
    {
        
        $view               = new ViewModel();
        //Tiêu đề
        $title              =  'Thành Phố doanh nghiệp Bất động sản';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
        $totalItem          = $this->getTable()->countItem();

        //List Loại doanh nghiêp
        $itemsTypeBusiness  = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-type-business')); 
        
        
        $itemsCategory      = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-item-type-business')); 
        //Thành phố
        $itemsCity          = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-city')); 
        
        //get info Thành phố
        $itemInfoCity       = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item-city')); 

        //Quận huyện
        $itemsDistrict          = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-item-district')); 
        
        //nested
        $view->setTemplate('home/business/city');
        $formSearchBusiness   = new ViewModel(array(
            'totalItem'         =>  $totalItem,
            'itemsTypeBusiness' =>  $itemsTypeBusiness,
            'itemsCity'         =>  $itemsCity,
            'itemsCategory'     =>  $itemsCategory,
        ));
        $formSearchBusiness->setTemplate('home/business/nested-form-search-business');

      


        $view->addChild($formSearchBusiness, 'formSearchBusiness');
             
        //end nested
        
        $view->setVariables(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'totalItem'         =>  $totalItem,
            'itemsTypeBusiness' =>  $itemsTypeBusiness,
            'itemsCity'         =>  $itemsCity,
            'itemsCategory'     =>  $itemsCategory,
            'itemsDistrict'     => $itemsDistrict,
            'itemInfoCity'     =>  $itemInfoCity,
        ));
        return $view;
        
    }

    //Ajax load indexAction
    public function cityAjaxAction(){
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
            
            //get info thành phố
            $itemCity       = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item-city')); 
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
            'itemCity'          =>  $itemCity,
        ));
        $view->setTerminal(true);
        return $view;


    }

    //Doanh nghiệp theo Quận huyện
    public function districtAction()
    {
        
        $view               = new ViewModel();
        //Tiêu đề
        $title              =  'Quận huyện doanh nghiệp Bất động sản';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
        $totalItem          = $this->getTable()->countItem();

        //List Loại doanh nghiêp
        $itemsTypeBusiness  = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-type-business')); 
        
        
        $itemsCategory      = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-item-type-business')); 
        //Thành phố
        $itemsCity          = $this->getTable()->itemInselectBox($this->_arrParam,array('task'=>'list-item-city')); 
        
        //get info Thành phố
        $itemInfoCity       = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item-city')); 

        //Quận huyện
        $itemsDistrict      = $this->getTable()->listItem($this->_arrParam,array('task'=>'list-item-district')); 
        

         //nested
        $view->setTemplate('home/business/district');
        $formSearchBusiness   = new ViewModel(array(
            'totalItem'         =>  $totalItem,
            'itemsTypeBusiness' =>  $itemsTypeBusiness,
            'itemsCity'         =>  $itemsCity,
            'itemsCategory'     =>  $itemsCategory,
        ));
        $formSearchBusiness->setTemplate('home/business/nested-form-search-business');

       


        $view->addChild($formSearchBusiness, 'formSearchBusiness');
        
        //end nested
        
        $view->setVariables(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'totalItem'         =>  $totalItem,
            'itemsTypeBusiness' =>  $itemsTypeBusiness,
            'itemsCity'         =>  $itemsCity,
            'itemsCategory'     =>  $itemsCategory,
            'itemsDistrict'     => $itemsDistrict,
            'itemInfoCity'     =>  $itemInfoCity,
        ));
        return $view;
        
    }

    //Ajax load indexAction
    public function districtAjaxAction(){
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
                $this->_arrParam['districtname']            = $this->params()->fromQuery('districtname');
                $this->_arrParam['iddistrict']              = $this->params()->fromQuery('iddistrict');
                $this->_paginatorParams['currentPageNumber']= $this->params()->fromQuery('page',1);
                $this->_arrParam['paginator']               = $this->_paginatorParams;
            }
            
            //get info thành phố
            $itemCity       = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item-city')); 
            $itemDistrict   = $this->getTable()->getItem($this->_arrParam,array('task'=>'get-item-district')); 


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
            'itemCity'          =>  $itemCity,
            'itemDistrict'     =>  $itemDistrict,
        ));
        $view->setTerminal(true);
        return $view;


    }
    public function detailAction()
    {
        
        $view               = new ViewModel();
        
        
        //Chi tiết
        $item               = $this->getTable()->getItem($this->_arrParam); 

        //Info User
        $infoUser                    = $this->getTable()->getItem($this->_arrParam,array('task'=>'info-user')); 
        //Tìm nhân viên
        $staffs                       = $this->getTable()->getItem($infoUser,array('task'=>'staff')); 
        $staff = '';
        $i = 1;
        if(!empty($staffs)){
            foreach($staffs as $value){
                
                if($i == 1){
                    $staff .= $value['id'];
                }else{
                    $staff .= ','.$value['id'];
                }
                $i++;
            }
        }

        $this->_arrParam['staff'] = $staff;
        //Tiêu đề
        $title              =  $item['name'];   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");


        //dự án Liên quan
        $listItemLienQuan            = $this->getTable()->listItem($this->_arrParam,array('task'=>'du-an-lien-quan')); 
        
        //Bất động sản của doanh nghiệp
        $listItemBdsBusiness         = $this->getTable()->listItem($this->_arrParam,array('task'=>'bat-dong-san-moi-nhat-cua-doanh-nghiep')); 
        
        //Count nhà đất bán của doanh nghiệp
        $countLandSale               = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-nha-dat-ban-cua-doanh-nghiep')); 
        
        //Count nhà đất cho thuê của doanh nghiệp
        $countLandForRent            = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-nha-dat-cho-thue-cua-doanh-nghiep')); 
        
        //Count dự án chủ đầu tư của doanh nghiệp
        $countInvestors              = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-chu-dau-tu')); 
        
        //Count dự án thi công của doanh nghiệp
        $countConstruction           = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-thi-cong')); 
        
        //Count dự án quản lý của doanh nghiệp
        $countManagement             = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-quan-ly')); 
        
        //Count dự án thiết kế của doanh nghiệp
        $countDesign                 = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-thiet-ke')); 
        
        //Count dự án phân phối của doanh nghiệp
        $countDistributors           = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-phan-phoi')); 
        
        $view->setVariables(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'item'              =>  $item,
            'listItemLienQuan'      =>  $listItemLienQuan,
            'listItemBdsBusiness'  =>  $listItemBdsBusiness,
            'countLandSale'     =>  $countLandSale,
            'countLandForRent'  =>  $countLandForRent,
            'countInvestors'    =>  $countInvestors,
            'countConstruction' =>  $countConstruction,
            'countManagement'   =>  $countManagement,
            'countDesign'       =>  $countDesign,
            'countDistributors' =>  $countDistributors,
            'staff'             =>  $staff,
        ));
        return $view;
        
    }
    public function landsaleAction()
    {
        
        $view               = new ViewModel();
        
        //Info User
        $infoUser                    = $this->getTable()->getItem($this->_arrParam,array('task'=>'info-user')); 
        //Tìm nhân viên
        $staffs                       = $this->getTable()->getItem($infoUser,array('task'=>'staff')); 
        $staff = '';
        $i = 1;
        if(!empty($staffs)){
            foreach($staffs as $value){
                
                if($i == 1){
                    $staff .= $value['id'];
                }else{
                    $staff .= ','.$value['id'];
                }
                $i++;
            }
        }

        $this->_arrParam['staff'] = $staff;
        
        //Chi tiết
        $item               = $this->getTable()->getItem($this->_arrParam); 

        //Tiêu đề
        $title              =  $item['name'] . ' - Nhà đất bán';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");


        //dự án Liên quan
        $listItemLienQuan            = $this->getTable()->listItem($this->_arrParam,array('task'=>'du-an-lien-quan')); 
        
        //Bất động sản của doanh nghiệp
        $listItemBdsBusiness         = $this->getTable()->listItem($this->_arrParam,array('task'=>'bat-dong-san-moi-nhat-cua-doanh-nghiep')); 
        
         //Count nhà đất bán của doanh nghiệp
        $countLandSale               = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-nha-dat-ban-cua-doanh-nghiep')); 
        
        //Count nhà đất cho thuê của doanh nghiệp
        $countLandForRent            = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-nha-dat-cho-thue-cua-doanh-nghiep')); 
        
        //Count dự án chủ đầu tư của doanh nghiệp
        $countInvestors              = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-chu-dau-tu')); 
        
        //Count dự án thi công của doanh nghiệp
        $countConstruction           = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-thi-cong')); 
        
        //Count dự án quản lý của doanh nghiệp
        $countManagement             = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-quan-ly')); 
        
        //Count dự án thiết kế của doanh nghiệp
        $countDesign                 = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-thiet-ke')); 
        
        //Count dự án phân phối của doanh nghiệp
        $countDistributors           = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-phan-phoi')); 
        


        $view->setVariables(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'item'              =>  $item,
            'listItemLienQuan'      =>  $listItemLienQuan,
            'listItemBdsBusiness'  =>  $listItemBdsBusiness,
            'countLandSale'     =>  $countLandSale,
            'countLandForRent'  =>  $countLandForRent,
            'countInvestors'    =>  $countInvestors,
            'countConstruction' =>  $countConstruction,
            'countManagement'   =>  $countManagement,
            'countDesign'       =>  $countDesign,
            'countDistributors' =>  $countDistributors,
            'infoUser'         =>   $infoUser,
            'staff'            =>  $staff,
        ));
        return $view;
        
    }

    public function landforrentAction()
    {
        
        $view               = new ViewModel();
        
        //Info User
        $infoUser                    = $this->getTable()->getItem($this->_arrParam,array('task'=>'info-user')); 
        //Tìm nhân viên
        $staffs                       = $this->getTable()->getItem($infoUser,array('task'=>'staff')); 
        
        $staff = '';
        $i = 1;
        if(!empty($staffs)){
            foreach($staffs as $value){
                
                if($i == 1){
                    $staff .= $value['id'];
                }else{
                    $staff .= ','.$value['id'];
                }
                $i++;
            }
        }

        $this->_arrParam['staff'] = $staff;
        //Chi tiết
        $item               = $this->getTable()->getItem($this->_arrParam); 

        //Tiêu đề
        $title              =  $item['name'] . ' - Nhà đất cho thuê';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");


        //dự án Liên quan
        $listItemLienQuan            = $this->getTable()->listItem($this->_arrParam,array('task'=>'du-an-lien-quan')); 
        
        //Bất động sản của doanh nghiệp
        $listItemBdsBusiness         = $this->getTable()->listItem($this->_arrParam,array('task'=>'bat-dong-san-moi-nhat-cua-doanh-nghiep')); 
        
         //Count nhà đất bán của doanh nghiệp
        $countLandSale               = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-nha-dat-ban-cua-doanh-nghiep')); 
        
        //Count nhà đất cho thuê của doanh nghiệp
        $countLandForRent            = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-nha-dat-cho-thue-cua-doanh-nghiep')); 
        
        //Count dự án chủ đầu tư của doanh nghiệp
        $countInvestors              = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-chu-dau-tu')); 
        
        //Count dự án thi công của doanh nghiệp
        $countConstruction           = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-thi-cong')); 
        
        //Count dự án quản lý của doanh nghiệp
        $countManagement             = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-quan-ly')); 
        
        //Count dự án thiết kế của doanh nghiệp
        $countDesign                 = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-thiet-ke')); 
        
        //Count dự án phân phối của doanh nghiệp
        $countDistributors           = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-phan-phoi')); 
        
        
        $view->setVariables(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'item'              =>  $item,
            'listItemLienQuan'      =>  $listItemLienQuan,
            'listItemBdsBusiness'  =>  $listItemBdsBusiness,
            'countLandSale'     =>  $countLandSale,
            'countLandForRent'  =>  $countLandForRent,
            'countInvestors'    =>  $countInvestors,
            'countConstruction' =>  $countConstruction,
            'countManagement'   =>  $countManagement,
            'countDesign'       =>  $countDesign,
            'countDistributors' =>  $countDistributors,
            'infoUser'         =>  $infoUser,
            'staff'            =>  $staff,
        ));
        return $view;
        
    }

    public function investorsAction()
    {
        
        $view               = new ViewModel();
        
        
        //Chi tiết
        $item               = $this->getTable()->getItem($this->_arrParam); 

        //Info User
        $infoUser                    = $this->getTable()->getItem($this->_arrParam,array('task'=>'info-user')); 
        //Tìm nhân viên
        $staffs                       = $this->getTable()->getItem($infoUser,array('task'=>'staff')); 
        $staff = '';
        $i = 1;
        if(!empty($staffs)){
            foreach($staffs as $value){
                
                if($i == 1){
                    $staff .= $value['id'];
                }else{
                    $staff .= ','.$value['id'];
                }
                $i++;
            }
        }

        $this->_arrParam['staff'] = $staff;
        //Tiêu đề
        $title              =  $item['name'] . ' - Dự án chủ đầu tư';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");


        //dự án Liên quan
        $listItemLienQuan            = $this->getTable()->listItem($this->_arrParam,array('task'=>'du-an-lien-quan')); 
        
        //Bất động sản của doanh nghiệp
        $listItemBdsBusiness         = $this->getTable()->listItem($this->_arrParam,array('task'=>'bat-dong-san-moi-nhat-cua-doanh-nghiep')); 
        
         //Count nhà đất bán của doanh nghiệp
        $countLandSale               = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-nha-dat-ban-cua-doanh-nghiep')); 
        
        //Count nhà đất cho thuê của doanh nghiệp
        $countLandForRent            = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-nha-dat-cho-thue-cua-doanh-nghiep')); 
        
        //Count dự án chủ đầu tư của doanh nghiệp
        $countInvestors              = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-chu-dau-tu')); 
        
        //Count dự án thi công của doanh nghiệp
        $countConstruction           = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-thi-cong')); 
        
        //Count dự án quản lý của doanh nghiệp
        $countManagement             = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-quan-ly')); 
        
        //Count dự án thiết kế của doanh nghiệp
        $countDesign                 = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-thiet-ke')); 
        
        //Count dự án phân phối của doanh nghiệp
        $countDistributors           = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-phan-phoi')); 
        
        //Info User
        $infoUser                    = $this->getTable()->getItem($this->_arrParam,array('task'=>'info-user')); 
        
        $view->setVariables(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'item'              =>  $item,
            'listItemLienQuan'      =>  $listItemLienQuan,
            'listItemBdsBusiness'  =>  $listItemBdsBusiness,
            'countLandSale'     =>  $countLandSale,
            'countLandForRent'  =>  $countLandForRent,
            'countInvestors'    =>  $countInvestors,
            'countConstruction' =>  $countConstruction,
            'countManagement'   =>  $countManagement,
            'countDesign'       =>  $countDesign,
            'countDistributors' =>  $countDistributors,
            'infoUser'         =>  $infoUser,
        ));
        return $view;
        
    }

    public function constructionAction()
    {
        
        $view               = new ViewModel();
        
        
        //Chi tiết
        $item               = $this->getTable()->getItem($this->_arrParam); 

        //Info User
        $infoUser                    = $this->getTable()->getItem($this->_arrParam,array('task'=>'info-user')); 
        //Tìm nhân viên
        $staffs                       = $this->getTable()->getItem($infoUser,array('task'=>'staff')); 
        $staff = '';
        $i = 1;
        if(!empty($staffs)){
            foreach($staffs as $value){
                
                if($i == 1){
                    $staff .= $value['id'];
                }else{
                    $staff .= ','.$value['id'];
                }
                $i++;
            }
        }

        $this->_arrParam['staff'] = $staff;
        //Tiêu đề
        $title              =  $item['name'] . ' - Dự án Thi công';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");


        //dự án Liên quan
        $listItemLienQuan            = $this->getTable()->listItem($this->_arrParam,array('task'=>'du-an-lien-quan')); 
        
        //Bất động sản của doanh nghiệp
        $listItemBdsBusiness         = $this->getTable()->listItem($this->_arrParam,array('task'=>'bat-dong-san-moi-nhat-cua-doanh-nghiep')); 
        
         //Count nhà đất bán của doanh nghiệp
        $countLandSale               = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-nha-dat-ban-cua-doanh-nghiep')); 
        
        //Count nhà đất cho thuê của doanh nghiệp
        $countLandForRent            = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-nha-dat-cho-thue-cua-doanh-nghiep')); 
        
        //Count dự án chủ đầu tư của doanh nghiệp
        $countInvestors              = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-chu-dau-tu')); 
        
        //Count dự án thi công của doanh nghiệp
        $countConstruction           = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-thi-cong')); 
        
        //Count dự án quản lý của doanh nghiệp
        $countManagement             = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-quan-ly')); 
        
        //Count dự án thiết kế của doanh nghiệp
        $countDesign                 = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-thiet-ke')); 
        
        //Count dự án phân phối của doanh nghiệp
        $countDistributors           = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-phan-phoi')); 
        
        //Info User
        $infoUser                    = $this->getTable()->getItem($this->_arrParam,array('task'=>'info-user')); 
        
        $view->setVariables(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'item'              =>  $item,
            'listItemLienQuan'      =>  $listItemLienQuan,
            'listItemBdsBusiness'  =>  $listItemBdsBusiness,
            'countLandSale'     =>  $countLandSale,
            'countLandForRent'  =>  $countLandForRent,
            'countInvestors'    =>  $countInvestors,
            'countConstruction' =>  $countConstruction,
            'countManagement'   =>  $countManagement,
            'countDesign'       =>  $countDesign,
            'countDistributors' =>  $countDistributors,
            'infoUser'         =>  $infoUser,
        ));
        return $view;
        
    }

    public function managementAction()
    {
        
        $view               = new ViewModel();
        
        
        //Chi tiết
        $item               = $this->getTable()->getItem($this->_arrParam); 

        //Info User
        $infoUser                    = $this->getTable()->getItem($this->_arrParam,array('task'=>'info-user')); 
        //Tìm nhân viên
        $staffs                       = $this->getTable()->getItem($infoUser,array('task'=>'staff')); 
        $staff = '';
        $i = 1;
        if(!empty($staffs)){
            foreach($staffs as $value){
                
                if($i == 1){
                    $staff .= $value['id'];
                }else{
                    $staff .= ','.$value['id'];
                }
                $i++;
            }
        }

        $this->_arrParam['staff'] = $staff;
        //Tiêu đề
        $title              =  $item['name'] . ' - Dự án Quản lý';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");


        //dự án Liên quan
        $listItemLienQuan            = $this->getTable()->listItem($this->_arrParam,array('task'=>'du-an-lien-quan')); 
        
        //Bất động sản của doanh nghiệp
        $listItemBdsBusiness         = $this->getTable()->listItem($this->_arrParam,array('task'=>'bat-dong-san-moi-nhat-cua-doanh-nghiep')); 
        
         //Count nhà đất bán của doanh nghiệp
        $countLandSale               = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-nha-dat-ban-cua-doanh-nghiep')); 
        
        //Count nhà đất cho thuê của doanh nghiệp
        $countLandForRent            = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-nha-dat-cho-thue-cua-doanh-nghiep')); 
        
        //Count dự án chủ đầu tư của doanh nghiệp
        $countInvestors              = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-chu-dau-tu')); 
        
        //Count dự án thi công của doanh nghiệp
        $countConstruction           = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-thi-cong')); 
        
        //Count dự án quản lý của doanh nghiệp
        $countManagement             = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-quan-ly')); 
        
        //Count dự án thiết kế của doanh nghiệp
        $countDesign                 = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-thiet-ke')); 
        
        //Count dự án phân phối của doanh nghiệp
        $countDistributors           = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-phan-phoi')); 
        
        //Info User
        $infoUser                    = $this->getTable()->getItem($this->_arrParam,array('task'=>'info-user')); 
        
        $view->setVariables(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'item'              =>  $item,
            'listItemLienQuan'      =>  $listItemLienQuan,
            'listItemBdsBusiness'  =>  $listItemBdsBusiness,
            'countLandSale'     =>  $countLandSale,
            'countLandForRent'  =>  $countLandForRent,
            'countInvestors'    =>  $countInvestors,
            'countConstruction' =>  $countConstruction,
            'countManagement'   =>  $countManagement,
            'countDesign'       =>  $countDesign,
            'countDistributors' =>  $countDistributors,
            'infoUser'         =>  $infoUser,
        ));
        return $view;
        
    }
    public function designAction()
    {
        
        $view               = new ViewModel();
        
        
        //Chi tiết
        $item               = $this->getTable()->getItem($this->_arrParam); 

        //Info User
        $infoUser                    = $this->getTable()->getItem($this->_arrParam,array('task'=>'info-user')); 
        //Tìm nhân viên
        $staffs                       = $this->getTable()->getItem($infoUser,array('task'=>'staff')); 
        $staff = '';
        $i = 1;
        if(!empty($staffs)){
            foreach($staffs as $value){
                
                if($i == 1){
                    $staff .= $value['id'];
                }else{
                    $staff .= ','.$value['id'];
                }
                $i++;
            }
        }

        $this->_arrParam['staff'] = $staff;
        //Tiêu đề
        $title              =  $item['name'] . ' - Dự án Thiết kế';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");



        //dự án Liên quan
        $listItemLienQuan            = $this->getTable()->listItem($this->_arrParam,array('task'=>'du-an-lien-quan')); 
        
        //Bất động sản của doanh nghiệp
        $listItemBdsBusiness         = $this->getTable()->listItem($this->_arrParam,array('task'=>'bat-dong-san-moi-nhat-cua-doanh-nghiep')); 
        
         //Count nhà đất bán của doanh nghiệp
        $countLandSale               = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-nha-dat-ban-cua-doanh-nghiep')); 
        
        //Count nhà đất cho thuê của doanh nghiệp
        $countLandForRent            = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-nha-dat-cho-thue-cua-doanh-nghiep')); 
        
        //Count dự án chủ đầu tư của doanh nghiệp
        $countInvestors              = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-chu-dau-tu')); 
        
        //Count dự án thi công của doanh nghiệp
        $countConstruction           = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-thi-cong')); 
        
        //Count dự án quản lý của doanh nghiệp
        $countManagement             = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-quan-ly')); 
        
        //Count dự án thiết kế của doanh nghiệp
        $countDesign                 = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-thiet-ke')); 
        
        //Count dự án phân phối của doanh nghiệp
        $countDistributors           = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-phan-phoi')); 
        
        //Info User
        $infoUser                    = $this->getTable()->getItem($this->_arrParam,array('task'=>'info-user')); 
        
        $view->setVariables(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'item'              =>  $item,
            'listItemLienQuan'      =>  $listItemLienQuan,
            'listItemBdsBusiness'  =>  $listItemBdsBusiness,
            'countLandSale'     =>  $countLandSale,
            'countLandForRent'  =>  $countLandForRent,
            'countInvestors'    =>  $countInvestors,
            'countConstruction' =>  $countConstruction,
            'countManagement'   =>  $countManagement,
            'countDesign'       =>  $countDesign,
            'countDistributors' =>  $countDistributors,
            'infoUser'         =>  $infoUser,
        ));
        return $view;
        
    }

    public function distributorsAction()
    {
        
        $view               = new ViewModel();
        
        
        //Chi tiết
        $item               = $this->getTable()->getItem($this->_arrParam); 

        //Info User
        $infoUser                    = $this->getTable()->getItem($this->_arrParam,array('task'=>'info-user')); 
        //Tìm nhân viên
        $staffs                       = $this->getTable()->getItem($infoUser,array('task'=>'staff')); 
        $staff = '';
        $i = 1;
        if(!empty($staffs)){
            foreach($staffs as $value){
                
                if($i == 1){
                    $staff .= $value['id'];
                }else{
                    $staff .= ','.$value['id'];
                }
                $i++;
            }
        }

        $this->_arrParam['staff'] = $staff;
        //Tiêu đề
        $title              =  $item['name'] . ' - Dự án Phân phối';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");


        //dự án Liên quan
        $listItemLienQuan            = $this->getTable()->listItem($this->_arrParam,array('task'=>'du-an-lien-quan')); 
        
        //Bất động sản của doanh nghiệp
        $listItemBdsBusiness         = $this->getTable()->listItem($this->_arrParam,array('task'=>'bat-dong-san-moi-nhat-cua-doanh-nghiep')); 
        
         //Count nhà đất bán của doanh nghiệp
        $countLandSale               = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-nha-dat-ban-cua-doanh-nghiep')); 
        
        //Count nhà đất cho thuê của doanh nghiệp
        $countLandForRent            = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-nha-dat-cho-thue-cua-doanh-nghiep')); 
        
        //Count dự án chủ đầu tư của doanh nghiệp
        $countInvestors              = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-chu-dau-tu')); 
        
        //Count dự án thi công của doanh nghiệp
        $countConstruction           = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-thi-cong')); 
        
        //Count dự án quản lý của doanh nghiệp
        $countManagement             = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-quan-ly')); 
        
        //Count dự án thiết kế của doanh nghiệp
        $countDesign                 = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-thiet-ke')); 
        
        //Count dự án phân phối của doanh nghiệp
        $countDistributors           = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-phan-phoi')); 
        
        //Info User
        $infoUser                    = $this->getTable()->getItem($this->_arrParam,array('task'=>'info-user')); 
        
        $view->setVariables(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'item'              =>  $item,
            'listItemLienQuan'      =>  $listItemLienQuan,
            'listItemBdsBusiness'  =>  $listItemBdsBusiness,
            'countLandSale'     =>  $countLandSale,
            'countLandForRent'  =>  $countLandForRent,
            'countInvestors'    =>  $countInvestors,
            'countConstruction' =>  $countConstruction,
            'countManagement'   =>  $countManagement,
            'countDesign'       =>  $countDesign,
            'countDistributors' =>  $countDistributors,
            'infoUser'         =>  $infoUser,
        ));
        return $view;
        
    }
    public function contactAction()
    {
        
        $view               = new ViewModel();
        
        
        //Chi tiết
        $item               = $this->getTable()->getItem($this->_arrParam); 
        $itemInfoUser       = $this->getTable()->getItem($this->_arrParam,array('task'=>'info-user'));
        
        //Info User
        $infoUser                    = $this->getTable()->getItem($this->_arrParam,array('task'=>'info-user')); 
        //Tìm nhân viên
        $staffs                       = $this->getTable()->getItem($infoUser,array('task'=>'staff')); 
        $staff = '';
        $i = 1;
        if(!empty($staffs)){
            foreach($staffs as $value){
                
                if($i == 1){
                    $staff .= $value['id'];
                }else{
                    $staff .= ','.$value['id'];
                }
                $i++;
            }
        }

        $this->_arrParam['staff'] = $staff;
        //Tin tương tự
        //$itemsTuongTu       = $this->getTable()->listItem($this->_arrParam,array('task'=>'tin-tuong-tu')); 
       
        //Tiêu đề
        $title              =  $item['name'];   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");

         
        //Bất động sản của doanh nghiệp
        $listItemBdsBusiness         = $this->getTable()->listItem($this->_arrParam,array('task'=>'bat-dong-san-moi-nhat-cua-doanh-nghiep')); 
        
        //Count nhà đất bán của doanh nghiệp
        $countLandSale               = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-nha-dat-ban-cua-doanh-nghiep')); 
        
        //Count nhà đất cho thuê của doanh nghiệp
        $countLandForRent            = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-nha-dat-cho-thue-cua-doanh-nghiep')); 
        
        //Count dự án chủ đầu tư của doanh nghiệp
        $countInvestors              = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-chu-dau-tu')); 
        
        //Count dự án thi công của doanh nghiệp
        $countConstruction           = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-thi-cong')); 
        
        //Count dự án quản lý của doanh nghiệp
        $countManagement             = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-quan-ly')); 
        
        //Count dự án thiết kế của doanh nghiệp
        $countDesign                 = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-thiet-ke')); 
        
        //Count dự án phân phối của doanh nghiệp
        $countDistributors           = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-phan-phoi')); 
        

         //Form liên hệ
        $contactMeForm      = $this->serviceLocator->get('FormElementManager')->get('contactMeForm');
        //Bind
        $object = new ArrayObject(array(
                'contact-me-user-id'            => $itemInfoUser['id'],                
                                         
        ));
        $contactMeForm->bind($object);


        $view->setVariables(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'contactMeForm'     =>  $contactMeForm,
            'item'              =>  $item,
            'countLandSale'     =>  $countLandSale,
            'countLandForRent'  =>  $countLandForRent,
            'countInvestors'    =>  $countInvestors,
            'countConstruction' =>  $countConstruction,
            'countManagement'   =>  $countManagement,
            'countDesign'       =>  $countDesign,
            'countDistributors' =>  $countDistributors,
            
        ));
        return $view;
        
    }
    public function departmentAction()
    {
        
        $view               = new ViewModel();
        
        //Info User
        $infoUser                    = $this->getTable()->getItem($this->_arrParam,array('task'=>'info-user')); 
        //Tìm nhân viên
        $staffs                       = $this->getTable()->getItem($infoUser,array('task'=>'staff')); 
        $staff = '';
        $i = 1;
        if(!empty($staffs)){
            foreach($staffs as $value){
                
                if($i == 1){
                    $staff .= $value['id'];
                }else{
                    $staff .= ','.$value['id'];
                }
                $i++;
            }
        }

        $this->_arrParam['staff'] = $staff;
        
        //Chi tiết
        $item               = $this->getTable()->getItem($this->_arrParam); 

        //Tin tương tự
        //$itemsTuongTu       = $this->getTable()->listItem($this->_arrParam,array('task'=>'tin-tuong-tu')); 
       
        //Tiêu đề
        $title              =  $item['name'];   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");


         //Count nhà đất bán của doanh nghiệp
        $countLandSale               = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-nha-dat-ban-cua-doanh-nghiep')); 
        
        //Count nhà đất cho thuê của doanh nghiệp
        $countLandForRent            = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-nha-dat-cho-thue-cua-doanh-nghiep')); 
        
        //Count dự án chủ đầu tư của doanh nghiệp
        $countInvestors              = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-chu-dau-tu')); 
        
        //Count dự án thi công của doanh nghiệp
        $countConstruction           = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-thi-cong')); 
        
        //Count dự án quản lý của doanh nghiệp
        $countManagement             = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-quan-ly')); 
        
        //Count dự án thiết kế của doanh nghiệp
        $countDesign                 = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-thiet-ke')); 
        
        //Count dự án phân phối của doanh nghiệp
        $countDistributors           = $this->getTable()->countItem($this->_arrParam,array('task'=>'count-du-an-phan-phoi')); 
        

        $view->setVariables(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'item'              =>  $item,
            'countLandSale'     =>  $countLandSale,
            'countLandForRent'  =>  $countLandForRent,
            'countInvestors'    =>  $countInvestors,
            'countConstruction' =>  $countConstruction,
            'countManagement'   =>  $countManagement,
            'countDesign'       =>  $countDesign,
            'countDistributors' =>  $countDistributors,
            
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
                $data   =   array(
                    'user_id'           =>  $this->_arrPost['contact-me-user-id'],
                    'fullname'          =>  $this->_arrPost['contact-me-fullname'],
                    'phone'             =>  $this->_arrPost['contact-me-phone'],
                    'email'             =>  $this->_arrPost['contact-me-email'],
                    'content'           =>  $this->_arrPost['contact-me-content'],
                    'date_time'         =>  date('d/m/y h:i:s'),
                );

                $item   = $this->getTable()->saveItem($data,array('task'=>'contact-business'));  
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
    public function nestedFormSearchBusinessAction(){
       
    }

    public function nestedContentRightColumnAction(){

    }

   

    
}
