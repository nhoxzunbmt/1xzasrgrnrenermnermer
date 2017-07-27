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

class RealestateController extends ActionController
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
        'itemCountPerPage' => 10,
        'pageRange' => 4,

    );

    protected $_userTable;
    protected $_userGroupTable;

    public function getTable()
    {
        if (empty($this->_userTable)) {
            $this->_userTable = $this->getServiceLocator()->get('Home\Model\RealEstateTable');
        }
        return $this->_userTable;
    }

    public function init()
    {
        //Mảng tham số Router nhận được ở mỗi Action
        $this->_arrParam = $this->params()->fromRoute();

        //Mảng tham số Post nhận được ở mỗi Action
        $this->_arrPost = $this->params()->fromPost();

        //Đối tượng view Helper
        $this->_viewHelper = $this->getServiceLocator()->get('Zend\View\Renderer\PhpRenderer');

        //Đường dẫn của Controller
        $paramController = $this->_arrParam['controller'];
        $tmp = explode("\\", $paramController);
        $this->_arrParam['module'] = strtolower($tmp[0]);//get module name
        $this->_arrParam['controller'] = strtolower($tmp[2]);//get controller name


        $this->_currentController = '/' . $this->_arrParam['module']
            . '/' . $this->_arrParam['controller'];


        //Đường dẫn của Action chính
        $this->_actionMain = '/' . $this->_arrParam['module']
            . '/' . $this->_arrParam['controller'] . '/' . $this->_arrParam['action'];

        //---------Dat ten SESSION-----------------------------------------
        $this->_namespace = $this->_arrParam['module'] . '_' . $this->_arrParam['controller'];
        $ssFilter = new Container($this->_namespace);

        if (empty($ssFilter->col)) {
            $ssFilter->keywords = '';
            $ssFilter->col = 'id';
            $ssFilter->order = 'DESC';
        }
        if (empty($ssFilter->record)) {
            $ssFilter->record = 10;
        }
        $this->_arrParam['ssFilter']['keywords'] = $ssFilter->keywords;
        $this->_arrParam['ssFilter']['sort'] = $ssFilter->sort;
        $this->_arrParam['ssFilter']['col'] = $ssFilter->col;
        $this->_arrParam['ssFilter']['order'] = $ssFilter->order;
        $this->_arrParam['ssFilter']['record'] = $ssFilter->record;
        $this->_arrParam['ssFilter']['field'] = $ssFilter->field;
        $this->_arrParam['ssFilter']['status'] = $ssFilter->status;
        $this->_arrParam['ssFilter']['group'] = $ssFilter->group;
        $this->_arrParam['ssFilter']['city'] = $ssFilter->city;


        $this->_paginatorParams['itemCountPerPage'] = (int)$ssFilter->record;
        $this->_paginatorParams['currentPageNumber'] = $this->params()->fromRoute('page', 1);

        $this->_arrParam['paginator'] = $this->_paginatorParams;



        //Load templates
        $this->layout('layout/home_v2');
    }

    public function indexAction()
    {
        $view = new ViewModel();

        //Tiêu đề
        $title = 'Bất động sản';
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");


        //Bất động nổi bật
        $itemRealestateHighlight = $this->getTable()->listItem($this->_arrParam, array('task' => 'list-items-realestate-highlight'));


        //Bất động sản chính chủ
        $itemRealestateChinhChu = $this->getTable()->listItem($this->_arrParam, array('task' => 'list-items-realestate-chinh-chu'));

        //Bất động sản Mới nhất
        $itemRealestateMoiNhat = $this->getTable()->listItem($this->_arrParam, array('task' => 'list-items-realestate-moi-nhat'));

        //Item select box
        $itemsTypeRealEstate = $this->getTable()->itemInselectBox($this->_arrParam, array('task' => 'list-item-type-real-estate'));

        //Dự án
        $itemsProject = $this->getTable()->itemInselectBox($this->_arrParam, array('task' => 'list-item-project'));

        $itemsProjectCategory = $this->getTable()->itemInselectBox($this->_arrParam, array('task' => 'list-item-project-category'));

        //Bất động sản tỉnh thành
        //Thành phố
        $itemsCity = $this->getTable()->itemInselectBox($this->_arrParam, array('task' => 'list-item-city'));
        $listCity = array_slice($itemsCity, 1, count($itemsCity) - 1);


        //nested
        $view->setTemplate('home_v2/realestate/index');

        $contentRightColumn = new ViewModel(array(
            'itemsTypeRealEstate' => $itemsTypeRealEstate,
            'itemsCity' => $itemsCity,
            'itemsProject' => $itemsProject,
            'itemsProjectCategory' => $itemsProjectCategory,
        ));
        $contentRightColumn->setTemplate('home_v2/realestate/nested-content-right-column');

        $view->addChild($contentRightColumn, 'contentRightColumn');

        //end nested

        $view->setVariables(array(
            'title' => $title,
            'arrParam' => $this->_arrParam,
            'currentController' => $this->_currentController,
            'itemRealestateChinhChu' => $itemRealestateChinhChu,
            'itemRealestateHighlight' => $itemRealestateHighlight,
            'itemRealestateMoiNhat' => $itemRealestateMoiNhat,
            'listCity' => $listCity,
        ));

        return $view;


    }

    public function searchAction()
    {
        $view = new ViewModel();

        //Tiêu đề
        $title = 'Tìm kiếm bất động sản';
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");


        //Bất động nổi bật
        $itemRealestateHighlight = $this->getTable()->listItem($this->_arrParam, array('task' => 'list-items-realestate-highlight'));

        //Bất động sản chính chủ
        $itemRealestateChinhChu = $this->getTable()->listItem($this->_arrParam, array('task' => 'list-items-realestate-chinh-chu'));

        //Bất động sản Mới nhất
        $itemRealestateMoiNhat = $this->getTable()->listItem($this->_arrParam, array('task' => 'list-items-realestate-moi-nhat'));

        //Item select box
        $itemsTypeRealEstate = $this->getTable()->itemInselectBox($this->_arrParam, array('task' => 'list-item-type-real-estate'));

        //Dự án
        $itemsProject = $this->getTable()->itemInselectBox($this->_arrParam, array('task' => 'list-item-project'));

        $itemsProjectCategory = $this->getTable()->itemInselectBox($this->_arrParam, array('task' => 'list-item-project-category'));


        //Bất động sản tỉnh thành
        //Thành phố
        $itemsCity = $this->getTable()->itemInselectBox($this->_arrParam, array('task' => 'list-item-city'));
        $listCity = array_slice($itemsCity, 1, count($itemsCity) - 1);


        //nested
        $view->setTemplate('home/realestate/search');
        $contentRightColumn = new ViewModel(array(
            'itemsTypeRealEstate' => $itemsTypeRealEstate,
            'itemsCity' => $itemsCity,
            'itemsProject' => $itemsProject,
            'itemsProjectCategory' => $itemsProjectCategory,
        ));
        $contentRightColumn->setTemplate('home/realestate/nested-content-right-column');
        $view->addChild($contentRightColumn, 'contentRightColumn');
        //end nested

        $this->_arrParam['cat'] = $this->params()->fromQuery('cat');
        $this->_arrParam['city'] = $this->params()->fromQuery('city');
        $this->_arrParam['district'] = $this->params()->fromQuery('district');
        $this->_arrParam['price'] = $this->params()->fromQuery('price');
        $this->_arrParam['area'] = $this->params()->fromQuery('area');
        $this->_arrParam['page'] = $this->params()->fromQuery('page');
        $this->_arrParam['transaction'] = $this->params()->fromQuery('transaction');


        $view->setVariables(array(
            'title' => $title,
            'arrParam' => $this->_arrParam,
            'currentController' => $this->_currentController,
            'itemRealestateChinhChu' => $itemRealestateChinhChu,
            'itemRealestateHighlight' => $itemRealestateHighlight,
            'itemRealestateMoiNhat' => $itemRealestateMoiNhat,
            'listCity' => $listCity,
        ));
        return $view;
    }

    //Ajax load indexAction
    public function searchAjaxAction()
    {
        $view = new ViewModel();
        $dataItems = null;
        $dataPaginator = null;
        $isXmlHttpRequest = false;
        $identityId = (!empty($this->identity()->id)) ? $this->identity()->id : '';
        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true) {
            $isXmlHttpRequest = true;

            if ($this->params()->fromQuery() == true) {
                $option = $this->params()->fromQuery('option');
                if ($option == 'save-real-estate-favorite') {
                    $id = $this->params()->fromQuery('value');
                    $arrParam = array(
                        'real_estate_id' => $id,
                        'user_id' => $this->identity()->id,
                        'date_time' => date('d/b/y h:i:s'),
                    );
                    $this->getTable()->saveItem($arrParam, array('task' => 'save-real-estate-favorite'));
                }
                if ($option == 'delete-real-estate-favorite') {
                    $id = $this->params()->fromQuery('value');
                    $arrParam = array(
                        'id' => $id,
                    );
                    $this->getTable()->deleteItem($arrParam, array('task' => 'delete-real-estate-favorite'));
                }
                //Lọc tin

                $this->_arrParam['transaction'] = $this->params()->fromQuery('transaction');
                $this->_arrParam['cat'] = $this->params()->fromQuery('cat');
                $this->_arrParam['idcity'] = $this->params()->fromQuery('city');
                $this->_arrParam['iddistrict'] = $this->params()->fromQuery('district');
                $this->_arrParam['price'] = $this->params()->fromQuery('price');
                $this->_arrParam['area'] = $this->params()->fromQuery('area');
                $this->_paginatorParams['currentPageNumber'] = $this->params()->fromQuery('page', 1);

                $this->_arrParam['paginator'] = $this->_paginatorParams;
            }


            $totalItem = $this->getTable()->countItem($this->_arrParam);
            $items = $this->getTable()->listItem($this->_arrParam, array('task' => 'list-items-paginator'));
            $dataItems = $items;
            $dataPaginator = \ZendVN\Paginator\Paginator::createPaginator($totalItem, $this->_paginatorParams);


        }

        $view->setVariables(array(
            'isXmlHttpRequest' => $isXmlHttpRequest,
            'items' => $dataItems,
            'paginator' => $dataPaginator,
            'arrParam' => $this->_arrParam,
            'currentController' => $this->_currentController,
            'totalItem' => $totalItem,

        ));
        $view->setTerminal(true);
        return $view;


    }

    public function categoryAction()
    {
        $view = new ViewModel();

        //find list child of parent type real estate
        $this->_arrParam['arrChildId'] = $this->getTable()->recusive($this->_arrParam['id'], array('task' => 'list-child-of-parent-type-real-estate'));

        $totalItem = $this->getTable()->countItem($this->_arrParam);

        //Tổng tin có hình
        $totalItemIsImage = $this->getTable()->countItem($this->_arrParam, array('task' => 'isImage'));
        //Tổng tin chính chủ
        $totalItemChinhChu = $this->getTable()->countItem($this->_arrParam, array('task' => 'chinh-chu'));
        //Item select box
        $itemsTypeRealEstate = $this->getTable()->itemInselectBox($this->_arrParam, array('task' => 'list-item-type-real-estate'));


        //Thành phố
        $itemsCity = $this->getTable()->itemInselectBox($this->_arrParam, array('task' => 'list-item-city'));
        $listCity = array_slice($itemsCity, 1, count($itemsCity) - 1);

        $itemsProjectCategory = $this->getTable()->itemInselectBox($this->_arrParam, array('task' => 'list-item-project-category'));
        $listItemCategory = array_slice($itemsProjectCategory, 1, count($itemsProjectCategory) - 1);

        //category info
        $categoryInfo = $this->getTable()->getItem($this->_arrParam, array('task' => 'category-frontend'));
        //breadcrumb
        $breadcrumb = $this->getTable()->listItem($categoryInfo, array('task' => 'list-breadcrumb'));

        //Tiêu đề
        $title = $categoryInfo->name;
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");


        //nested
        $view->setTemplate('home/realestate/category');
        $contentRightColumn = new ViewModel(array(
            'itemsTypeRealEstate' => $itemsTypeRealEstate,
            'itemsCity' => $itemsCity,
            'itemsProjectCategory' => $itemsProjectCategory,
        ));
        $contentRightColumn->setTemplate('home/realestate/nested-content-right-column');
        $view->addChild($contentRightColumn, 'contentRightColumn');
        //end nested



        $itemRealestateHighlight = $this->getRealEstateTable()->listItem($this->_arrParam, array('task' => 'list-items-realestate-highlight'));

        $view->setVariables(array(
            'title' => $title,
            'arrParam' => $this->_arrParam,
            'currentController' => $this->_currentController,
            'totalItem' => $totalItem,
            'totalItemIsImage' => $totalItemIsImage[0]['count'],
            'totalItemChinhChu' => $totalItemChinhChu[0]['count'],
            'listCity' => $listCity,
            'breadcrumb' => $breadcrumb,

            'itemRealestateHighlight' => $itemRealestateHighlight,

        ));
        return $view;

    }
    public function getRealEstateTable()
    {
        if (empty($this->_realEstateTable)) {
            $this->_realEstateTable = $this->getServiceLocator()->get('Home\Model\RealEstateTable');

        }
        return $this->_realEstateTable;
    }
    //Ajax load indexAction
    public function listAction()
    {
        $view = new ViewModel();
        $dataItems = null;
        $dataPaginator = null;
        $isXmlHttpRequest = false;
        $identityId = (!empty($this->identity()->id)) ? $this->identity()->id : '';
        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true) {
            $isXmlHttpRequest = true;

            if ($this->params()->fromQuery() == true) {
                $option = $this->params()->fromQuery('option');
                if ($option == 'save-real-estate-favorite') {
                    $id = $this->params()->fromQuery('value');
                    $arrParam = array(
                        'real_estate_id' => $id,
                        'user_id' => $this->identity()->id,
                        'date_time' => date('d/b/y h:i:s'),
                    );
                    $this->getTable()->saveItem($arrParam, array('task' => 'save-real-estate-favorite'));
                }
                if ($option == 'delete-real-estate-favorite') {
                    $id = $this->params()->fromQuery('value');
                    $arrParam = array(
                        'id' => $id,
                    );
                    $this->getTable()->deleteItem($arrParam, array('task' => 'delete-real-estate-favorite'));
                }
                //Lọc tin
                $type = $this->params()->fromQuery('type');
                $this->_arrParam['type'] = $type;
                $this->_arrParam['id'] = $this->params()->fromQuery('id');
                $this->_arrParam['name'] = $this->params()->fromQuery('name');
                $this->_arrParam['transaction'] = $this->params()->fromQuery('transaction');
                $this->_paginatorParams['currentPageNumber'] = $this->params()->fromQuery('page', 1);

                $this->_arrParam['paginator'] = $this->_paginatorParams;

                //find list child of parent type real estate
                $this->_arrParam['arrChildId'] = $this->getTable()->recusive($this->_arrParam['id'], array('task' => 'list-child-of-parent-type-real-estate'));

            }


            $totalItem = $this->getTable()->countItem($this->_arrParam);
            $items = $this->getTable()->listItem($this->_arrParam, array('task' => 'list-items-paginator'));
            $dataItems = $items;
            $dataPaginator = \ZendVN\Paginator\Paginator::createPaginator($totalItem, $this->_paginatorParams);


        }

        $view->setVariables(array(
            'isXmlHttpRequest' => $isXmlHttpRequest,
            'items' => $dataItems,
            'paginator' => $dataPaginator,
            'arrParam' => $this->_arrParam,
            'currentController' => $this->_currentController,
            'totalItem' => $totalItem,

        ));
        $view->setTerminal(true);
        return $view;


    }

    public function cityAction()
    {

        $view = new ViewModel();
        //Tiêu đề
        $title = 'Thành phố';
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
        //find list child of parent type real estate

        $totalItem = $this->getTable()->countItem($this->_arrParam);

        //Tổng tin có hình
        $totalItemIsImage = $this->getTable()->countItem($this->_arrParam, array('task' => 'isImage'));
        //Tổng tin chính chủ
        $totalItemChinhChu = $this->getTable()->countItem($this->_arrParam, array('task' => 'chinh-chu'));

        //get info Thành phố
        $itemInfoCity = $this->getTable()->getItem($this->_arrParam, array('task' => 'get-item-city'));

        //Quận huyện của thành phố hiện tại
        $itemsDistrictofCurrenCity = $this->getTable()->listItem($this->_arrParam, array('task' => 'list-item-district-of-current-city'));

        //Item select box
        $itemsTypeRealEstate = $this->getTable()->itemInselectBox($this->_arrParam, array('task' => 'list-item-type-real-estate'));

        //Thành phố
        $itemsCity = $this->getTable()->itemInselectBox($this->_arrParam, array('task' => 'list-item-city'));
        $listCity = array_slice($itemsCity, 1, count($itemsCity) - 1);

        $itemsProjectCategory = $this->getTable()->itemInselectBox($this->_arrParam, array('task' => 'list-item-project-category'));

        //nested
        $view->setTemplate('home/realestate/city');
        $contentRightColumn = new ViewModel(array(
            'itemsTypeRealEstate' => $itemsTypeRealEstate,
            'itemsCity' => $itemsCity,
            'itemsProjectCategory' => $itemsProjectCategory,
        ));
        $contentRightColumn->setTemplate('home/realestate/nested-content-right-column');
        $view->addChild($contentRightColumn, 'contentRightColumn');
        //end nested

        $view->setVariables(array(
            'title' => $title,
            'arrParam' => $this->_arrParam,
            'currentController' => $this->_currentController,
            'totalItem' => $totalItem,
            'totalItemIsImage' => $totalItemIsImage[0]['count'],
            'totalItemChinhChu' => $totalItemChinhChu[0]['count'],
            'itemsDistrictofCurrenCity' => $itemsDistrictofCurrenCity,
            'itemInfoCity' => $itemInfoCity,

        ));
        return $view;

    }

    //Ajax load indexAction
    public function cityAjaxAction()
    {
        $view = new ViewModel();
        $dataItems = null;
        $dataPaginator = null;
        $isXmlHttpRequest = false;
        $identityId = (!empty($this->identity()->id)) ? $this->identity()->id : '';
        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true) {
            $isXmlHttpRequest = true;

            if ($this->params()->fromQuery() == true) {
                $option = $this->params()->fromQuery('option');
                if ($option == 'save-real-estate-favorite') {
                    $id = $this->params()->fromQuery('value');
                    $arrParam = array(
                        'real_estate_id' => $id,
                        'user_id' => $this->identity()->id,
                        'date_time' => date('d/b/y h:i:s'),
                    );
                    $this->getTable()->saveItem($arrParam, array('task' => 'save-real-estate-favorite'));
                }
                if ($option == 'delete-real-estate-favorite') {
                    $id = $this->params()->fromQuery('value');
                    $arrParam = array(
                        'id' => $id,
                    );
                    $this->getTable()->deleteItem($arrParam, array('task' => 'delete-real-estate-favorite'));
                }
                //Lọc tin


                $type = $this->params()->fromQuery('type');
                $this->_arrParam['type'] = $type;
                $this->_arrParam['idcity'] = $this->params()->fromQuery('idcity');
                $this->_arrParam['cityname'] = $this->params()->fromQuery('cityname');
                $this->_paginatorParams['currentPageNumber'] = $this->params()->fromQuery('page', 1);
                $this->_arrParam['paginator'] = $this->_paginatorParams;


            }


            $totalItem = $this->getTable()->countItem($this->_arrParam);
            $items = $this->getTable()->listItem($this->_arrParam, array('task' => 'list-items-paginator'));
            $dataItems = $items;
            $dataPaginator = \ZendVN\Paginator\Paginator::createPaginator($totalItem, $this->_paginatorParams);


        }

        $view->setVariables(array(
            'isXmlHttpRequest' => $isXmlHttpRequest,
            'items' => $dataItems,
            'paginator' => $dataPaginator,
            'arrParam' => $this->_arrParam,
            'currentController' => $this->_currentController,
            'totalItem' => $totalItem,

        ));
        $view->setTerminal(true);
        return $view;


    }

    public function districtAction()
    {

        $view = new ViewModel();
        //Tiêu đề
        $title = 'Quận huyện';
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
        //find list child of parent type real estate

        $totalItem = $this->getTable()->countItem($this->_arrParam);

        //Tổng tin có hình
        $totalItemIsImage = $this->getTable()->countItem($this->_arrParam, array('task' => 'isImage'));
        //Tổng tin chính chủ
        $totalItemChinhChu = $this->getTable()->countItem($this->_arrParam, array('task' => 'chinh-chu'));

        //get info Thành phố
        $itemInfoCity = $this->getTable()->getItem($this->_arrParam, array('task' => 'get-item-city'));

        //Quận huyện của thành phố hiện tại
        $itemsDistrictofCurrenCity = $this->getTable()->listItem($this->_arrParam, array('task' => 'list-item-district-of-current-city'));

        //Item select box
        $itemsTypeRealEstate = $this->getTable()->itemInselectBox($this->_arrParam, array('task' => 'list-item-type-real-estate'));

        //Thành phố
        $itemsCity = $this->getTable()->itemInselectBox($this->_arrParam, array('task' => 'list-item-city'));
        $listCity = array_slice($itemsCity, 1, count($itemsCity) - 1);

        $itemsProjectCategory = $this->getTable()->itemInselectBox($this->_arrParam, array('task' => 'list-item-project-category'));

        //nested
        $view->setTemplate('home/realestate/district');
        $contentRightColumn = new ViewModel(array(
            'itemsTypeRealEstate' => $itemsTypeRealEstate,
            'itemsCity' => $itemsCity,
            'itemsProjectCategory' => $itemsProjectCategory,
        ));
        $contentRightColumn->setTemplate('home/realestate/nested-content-right-column');
        $view->addChild($contentRightColumn, 'contentRightColumn');
        //end

        $view->setVariables(array(
            'title' => $title,
            'arrParam' => $this->_arrParam,
            'currentController' => $this->_currentController,
            'totalItem' => $totalItem,
            'totalItemIsImage' => $totalItemIsImage[0]['count'],
            'totalItemChinhChu' => $totalItemChinhChu[0]['count'],
            'itemsDistrictofCurrenCity' => $itemsDistrictofCurrenCity,
            'itemInfoCity' => $itemInfoCity,

        ));
        return $view;

    }

    //Ajax load indexAction
    public function districtAjaxAction()
    {
        $view = new ViewModel();
        $dataItems = null;
        $dataPaginator = null;
        $isXmlHttpRequest = false;
        $identityId = (!empty($this->identity()->id)) ? $this->identity()->id : '';
        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true) {
            $isXmlHttpRequest = true;

            if ($this->params()->fromQuery() == true) {
                $option = $this->params()->fromQuery('option');
                if ($option == 'save-real-estate-favorite') {
                    $id = $this->params()->fromQuery('value');
                    $arrParam = array(
                        'real_estate_id' => $id,
                        'user_id' => $this->identity()->id,
                        'date_time' => date('d/b/y h:i:s'),
                    );
                    $this->getTable()->saveItem($arrParam, array('task' => 'save-real-estate-favorite'));
                }
                if ($option == 'delete-real-estate-favorite') {
                    $id = $this->params()->fromQuery('value');
                    $arrParam = array(
                        'id' => $id,
                    );
                    $this->getTable()->deleteItem($arrParam, array('task' => 'delete-real-estate-favorite'));
                }
                //Lọc tin


                //Lọc tin
                $type = $this->params()->fromQuery('type');
                $this->_arrParam['type'] = $type;
                $this->_arrParam['idcity'] = $this->params()->fromQuery('cityid');
                $this->_arrParam['cityname'] = $this->params()->fromQuery('cityname');
                $this->_arrParam['districtname'] = $this->params()->fromQuery('districtname');
                $this->_arrParam['iddistrict'] = $this->params()->fromQuery('iddistrict');
                $this->_paginatorParams['currentPageNumber'] = $this->params()->fromQuery('page', 1);
                $this->_arrParam['paginator'] = $this->_paginatorParams;


            }


            $totalItem = $this->getTable()->countItem($this->_arrParam);
            $items = $this->getTable()->listItem($this->_arrParam, array('task' => 'list-items-paginator'));
            $dataItems = $items;
            $dataPaginator = \ZendVN\Paginator\Paginator::createPaginator($totalItem, $this->_paginatorParams);


        }

        $view->setVariables(array(
            'isXmlHttpRequest' => $isXmlHttpRequest,
            'items' => $dataItems,
            'paginator' => $dataPaginator,
            'arrParam' => $this->_arrParam,
            'currentController' => $this->_currentController,
            'totalItem' => $totalItem,

        ));
        $view->setTerminal(true);
        return $view;


    }

    //Ajax load indexAction
    public function realestateOfAgencyAction()
    {
        $view = new ViewModel();
        $dataItems = null;
        $dataPaginator = null;
        $isXmlHttpRequest = false;
        $identityId = (!empty($this->identity()->id)) ? $this->identity()->id : '';
        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true) {
            $isXmlHttpRequest = true;

            if ($this->params()->fromQuery() == true) {
                $option = $this->params()->fromQuery('option');
                if ($option == 'save-real-estate-favorite') {
                    $id = $this->params()->fromQuery('value');
                    $arrParam = array(
                        'real_estate_id' => $id,
                        'user_id' => $this->identity()->id,
                        'date_time' => date('d/b/y h:i:s'),
                    );
                    $this->getTable()->saveItem($arrParam, array('task' => 'save-real-estate-favorite'));
                }
                if ($option == 'delete-real-estate-favorite') {
                    $id = $this->params()->fromQuery('value');
                    $arrParam = array(
                        'id' => $id,
                    );
                    $this->getTable()->deleteItem($arrParam, array('task' => 'delete-real-estate-favorite'));
                }
                //Lọc tin

                $this->_arrParam['idUser'] = $this->params()->fromQuery('idUser');
                $this->_arrParam['name'] = $this->params()->fromQuery('name');
                $this->_paginatorParams['currentPageNumber'] = $this->params()->fromQuery('page', 1);
                $this->_arrParam['paginator'] = $this->_paginatorParams;
            }


            $totalItem = $this->getTable()->countItem($this->_arrParam);
            $items = $this->getTable()->listItem($this->_arrParam, array('task' => 'list-items-paginator'));
            $dataItems = $items;
            $dataPaginator = \ZendVN\Paginator\Paginator::createPaginator($totalItem, $this->_paginatorParams);


        }

        $view->setVariables(array(
            'isXmlHttpRequest' => $isXmlHttpRequest,
            'items' => $dataItems,
            'paginator' => $dataPaginator,
            'arrParam' => $this->_arrParam,
            'currentController' => $this->_currentController,
            'totalItem' => $totalItem,

        ));
        $view->setTerminal(true);
        return $view;


    }

    //Ajax load indexAction
    public function realestateOfBusinessAction()
    {
        $view = new ViewModel();
        $dataItems = null;
        $dataPaginator = null;
        $isXmlHttpRequest = false;
        $identityId = (!empty($this->identity()->id)) ? $this->identity()->id : '';
        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true) {
            $isXmlHttpRequest = true;

            if ($this->params()->fromQuery() == true) {
                $option = $this->params()->fromQuery('option');
                if ($option == 'save-real-estate-favorite') {
                    $id = $this->params()->fromQuery('value');
                    $arrParam = array(
                        'real_estate_id' => $id,
                        'user_id' => $this->identity()->id,
                        'date_time' => date('d/b/y h:i:s'),
                    );
                    $this->getTable()->saveItem($arrParam, array('task' => 'save-real-estate-favorite'));
                }
                if ($option == 'delete-real-estate-favorite') {
                    $id = $this->params()->fromQuery('value');
                    $arrParam = array(
                        'id' => $id,
                    );
                    $this->getTable()->deleteItem($arrParam, array('task' => 'delete-real-estate-favorite'));
                }
                //Lọc tin
                $this->_arrParam['staff'] = $this->params()->fromQuery('staff');
                $this->_arrParam['idUser'] = $this->params()->fromQuery('idUser');
                $this->_arrParam['alias'] = $this->params()->fromQuery('alias');
                $this->_arrParam['transaction'] = $this->params()->fromQuery('transaction');
                $this->_paginatorParams['currentPageNumber'] = $this->params()->fromQuery('page', 1);
                $this->_arrParam['paginator'] = $this->_paginatorParams;
            }


            $totalItem = $this->getTable()->countItem($this->_arrParam);
            $items = $this->getTable()->listItem($this->_arrParam, array('task' => 'list-items-paginator'));
            $dataItems = $items;
            $dataPaginator = \ZendVN\Paginator\Paginator::createPaginator($totalItem, $this->_paginatorParams);


        }

        $view->setVariables(array(
            'isXmlHttpRequest' => $isXmlHttpRequest,
            'items' => $dataItems,
            'paginator' => $dataPaginator,
            'arrParam' => $this->_arrParam,
            'currentController' => $this->_currentController,
            'totalItem' => $totalItem,

        ));
        $view->setTerminal(true);
        return $view;


    }

    //Ajax load indexAction
    public function realestateOfProjectAction()
    {
        $view = new ViewModel();
        $dataItems = null;
        $dataPaginator = null;
        $isXmlHttpRequest = false;
        $identityId = (!empty($this->identity()->id)) ? $this->identity()->id : '';
        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true) {
            $isXmlHttpRequest = true;

            if ($this->params()->fromQuery() == true) {
                $option = $this->params()->fromQuery('option');
                if ($option == 'save-real-estate-favorite') {
                    $id = $this->params()->fromQuery('value');
                    $arrParam = array(
                        'real_estate_id' => $id,
                        'user_id' => $this->identity()->id,
                        'date_time' => date('d/b/y h:i:s'),
                    );
                    $this->getTable()->saveItem($arrParam, array('task' => 'save-real-estate-favorite'));
                }
                if ($option == 'delete-real-estate-favorite') {
                    $id = $this->params()->fromQuery('value');
                    $arrParam = array(
                        'id' => $id,
                    );
                    $this->getTable()->deleteItem($arrParam, array('task' => 'delete-real-estate-favorite'));
                }
                //Lọc tin

                $this->_arrParam['project'] = $this->params()->fromQuery('project');
                $this->_paginatorParams['currentPageNumber'] = $this->params()->fromQuery('page', 1);
                $this->_arrParam['paginator'] = $this->_paginatorParams;
            }


            $totalItem = $this->getTable()->countItem($this->_arrParam);
            $items = $this->getTable()->listItem($this->_arrParam, array('task' => 'list-items-paginator'));
            $dataItems = $items;
            $dataPaginator = \ZendVN\Paginator\Paginator::createPaginator($totalItem, $this->_paginatorParams);


        }

        $view->setVariables(array(
            'isXmlHttpRequest' => $isXmlHttpRequest,
            'items' => $dataItems,
            'paginator' => $dataPaginator,
            'arrParam' => $this->_arrParam,
            'currentController' => $this->_currentController,
            'totalItem' => $totalItem,

        ));
        $view->setTerminal(true);
        return $view;


    }

    public function detailAction()
    {

        $view = new ViewModel();


        //Chi tiết
        $item = $this->getTable()->getItem($this->_arrParam);
        $this->_arrParam['transaction'] = $item['transaction'];
        //Tin tương tự
        $itemsTuongTu = $this->getTable()->listItem($this->_arrParam, array('task' => 'tin-tuong-tu'));
        //Form liên hệ
        $contactMeForm = $this->serviceLocator->get('FormElementManager')->get('contactMeForm');
        //Bind
        $object = new ArrayObject(array(
            'contact-me-user-id' => $item['user_id'],
            'contact-me-realestate-id' => $item['id'],
        ));
        $contactMeForm->bind($object);

        //Form liên hệ
        $fengshuiForm = $this->serviceLocator->get('FormElementManager')->get('fengshuiForm');


        //Item select box
        $itemsTypeRealEstate = $this->getTable()->itemInselectBox($this->_arrParam, array('task' => 'list-item-type-real-estate'));

        //Dự án
        $itemsProject = $this->getTable()->itemInselectBox($this->_arrParam, array('task' => 'list-item-project'));


        //Bất động sản tỉnh thành
        //Thành phố
        $itemsCity = $this->getTable()->itemInselectBox($this->_arrParam, array('task' => 'list-item-city'));
        $listCity = array_slice($itemsCity, 1, count($itemsCity) - 1);

        //category info
        $this->_arrParam['id'] = $this->_arrParam['cid'];
        $categoryInfo = $this->getTable()->getItem($this->_arrParam, array('task' => 'category-frontend'));
        //breadcrumb
        $breadcrumb = $this->getTable()->listItem($categoryInfo, array('task' => 'list-breadcrumb'));

        $itemsProjectCategory = $this->getTable()->itemInselectBox($this->_arrParam, array('task' => 'list-item-project-category'));

        //nested
        $view->setTemplate('home_v2/realestate/detail');
        $contentRightColumn = new ViewModel(array(
            'itemsTypeRealEstate' => $itemsTypeRealEstate,
            'itemsCity' => $itemsCity,
            'itemsProject' => $itemsProject,
            'itemsProjectCategory' => $itemsProjectCategory,
        ));
        $contentRightColumn->setTemplate('home_v2/realestate/nested-content-right-column');

        $view->addChild($contentRightColumn, 'contentRightColumn');

        //end nested

        //====Lượt xem=====
        $date = date('d/m/Y');
        $this->_arrParam['date_time'] = $date;

        $viewBds = $this->getTable()->getItem($this->_arrParam, array('task' => 'view-bds'));
        //Chưa có lượt xem nào thì tiến hành insert
        if (empty($viewBds)) {
            $addView = 1;
            $data = array(
                'real_estate_id' => $item['id'],
                'date_time' => $this->_arrParam['date_time'],
                'view' => $addView,
            );

            $this->getTable()->saveItem($data, array('task' => 'add-view-bds'));
        } else {
            //có lượt xem thì tiến hành Update
            $viewed = $viewBds['view'];
            $addView = $viewed + 1;

            $data = array(
                'id' => $viewBds['id'],
                'real_estate_id' => $item['id'],
                'view' => $addView,
            );

            $this->getTable()->saveItem($data, array('task' => 'update-view-bds'));

        }

        //Tiêu đề
        $title = $item['title'];
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");

        $view->setVariables(array(
            'title' => $title,
            'arrParam' => $this->_arrParam,
            'currentController' => $this->_currentController,
            'item' => $item,
            'itemsTuongTu' => $itemsTuongTu,
            'contactMeForm' => $contactMeForm,
            'fengshuiForm' => $fengshuiForm,
            'breadcrumb' => $breadcrumb,
        ));
        return $view;

    }

    //Gửi liên hệ
    public function contactMeAction()
    {
        $contactMeForm = $this->serviceLocator->get('FormElementManager')->get('contactMeForm');
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $contactMeForm->setData($data);
            if ($contactMeForm->isValid()) {
                //insert db
                //Chống tấn công XSS
                $purifier = new \HTMLPurifier_HTMLPurifier();
                $data = array(
                    'real_estate_id' => $this->_arrPost['contact-me-realestate-id'],
                    'user_id' => $this->_arrPost['contact-me-user-id'],
                    'fullname' => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['contact-me-fullname'])),
                    'phone' => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['contact-me-phone'])),
                    'email' => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['contact-me-email'])),
                    'content' => $purifier->purify($this->_arrPost['contact-me-content']),
                    'date_time' => date('d/m/y h:i:s'),
                );

                $item = $this->getTable()->saveItem($data, array('task' => 'contact-me'));
                $result['status'] = 'success';
                $result['messages']['success'] = 'Gửi liên hệ thành công';
            } else {
                $result['status'] = 'error';
                $result['messages']['fullname'] = current($contactMeForm->getMessages('contact-me-fullname'));
                $result['messages']['phone'] = current($contactMeForm->getMessages('contact-me-phone'));
                $result['messages']['email'] = current($contactMeForm->getMessages('contact-me-email'));
                $result['messages']['content'] = current($contactMeForm->getMessages('contact-me-content'));
            }
        }
        echo \Zend\Json\Json::encode($result);
        return $this->getResponse();
    }

    //Xem phong thủy
    public function fengshuiAction()
    {
        $fengshuiForm = $this->serviceLocator->get('FormElementManager')->get('fengshuiForm');
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $fengshuiForm->setData($data);
            if ($fengshuiForm->isValid()) {
                $item = $this->getTable()->getItem($this->_arrPost, array('task' => 'get-item-fengshui'));
                $result['status'] = 'success';
                $result['messages']['success'] = $item['content'];
            } else {
                $result['status'] = 'error';
                $result['messages']['birth'] = current($fengshuiForm->getMessages('feng-shui-birth'));
            }
        }
        echo \Zend\Json\Json::encode($result);
        return $this->getResponse();
    }

    public function filterAction()
    {
        $ssFilter = new Container($this->_namespace);
        $purifier = new \HTMLPurifier_HTMLPurifier();
        if ($this->_arrParam['type'] == 'search') {
            if ($this->_arrParam['col'] == 'null' && $this->_arrParam['by'] == 'null' && $this->_arrParam['key'] == 1) {
                if ($this->params()->fromPost('keywords') != '') {
                    $ssFilter->keywords = $this->params()->fromPost('keywords');
                }
                $ssFilter->status = $this->params()->fromPost('status');
                $ssFilter->city = $this->params()->fromPost('city');
                $ssFilter->district = $this->params()->fromPost('district');
                $ssFilter->type_news = $this->params()->fromPost('type_news');
                $ssFilter->type_transaction = $this->params()->fromPost('type_transaction');
                $ssFilter->type_real_estate = $this->params()->fromPost('type_real_estate');
                $ssFilter->date_start = $this->params()->fromPost('date_start');
                $ssFilter->date_end = $this->params()->fromPost('date_end');

            }
            if ($this->_arrParam['col'] == 'null' && $this->_arrParam['by'] == 'null' && $this->_arrParam['key'] == 0) {
                $ssFilter->getManager()->getStorage()->clear($this->_namespace);
            }
        }

        if ($this->_arrParam['type'] == 'order' && $this->_arrParam['col'] != 'null' && $this->_arrParam['by'] != 'null') {
            $ssFilter->col = $this->_arrParam['col'];
            $ssFilter->order = $this->_arrParam['by'];
        }

        if ($this->_arrParam['type'] == 'record') {
            $ssFilter->record = $this->params()->fromPost('record');

        }

        $this->redirect()->toUrl('/bat-dong-san/nha-dat-ban-123.html');
        return $this->getResponse();
    }

    public function loadSelectTypeRealEstateAction()
    {
        $view = new ViewModel();
        $isXmlHttpRequest = false;
        $data = null;
        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true) {
            $isXmlHttpRequest = true;
            $itemsRealEstateChild = $this->getTable()->listItem($this->_arrParam, array('task' => 'list-item-type-real-estate-child'));
            $tyleLand = $this->params()->fromQuery('type');
            foreach ($itemsRealEstateChild as $key => $value) {
                if ($value['parent'] == $tyleLand) $data[] = $value;
            }
        }
        $view->setVariables(array(
            'isXmlHttpRequest' => $isXmlHttpRequest,
            'data' => $data,
        ));
        $view->setTerminal(true);
        return $view;
    }


    public function loadSelectDistrictAction()
    {
        $view = new ViewModel();
        $isXmlHttpRequest = false;
        $data = null;
        $currentDistrict = null;
        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true) {
            $isXmlHttpRequest = true;

            $itemsDistrict = $this->getTable()->listItem($this->_arrParam, array('task' => 'list-item-district'));
            $city = $this->params()->fromQuery('city');
            foreach ($itemsDistrict as $key => $value) {
                if ($value['city_id'] == $city) $data[] = $value;
            }
            if ($this->params()->fromQuery('currentDistrict') != '') {
                $currentDistrict = $this->params()->fromQuery('currentDistrict');
            }
        }
        $view->setVariables(array(
            'isXmlHttpRequest' => $isXmlHttpRequest,
            'data' => $data,
            'currentDistrict' => $currentDistrict,
        ));
        $view->setTerminal(true);
        return $view;
    }

    public function loadSelectProjectAction()
    {
        $view = new ViewModel();
        $isXmlHttpRequest = false;
        $data = null;
        $currentProject = null;
        //Disable Layout
        if ($this->getRequest()->isXmlHttpRequest() == true) {
            $isXmlHttpRequest = true;
            $itemsProject = $this->getTable()->listItem($this->_arrParam, array('task' => 'list-item-project'));
            $district = $this->params()->fromQuery('district');
            foreach ($itemsProject as $key => $value) {
                if ($value['district_id'] == $district) $data[] = $value;
            }
            if ($this->params()->fromQuery('currentProject') != '') {
                $currentProject = $this->params()->fromQuery('currentProject');
            }
        }
        $view->setVariables(array(
            'isXmlHttpRequest' => $isXmlHttpRequest,
            'data' => $data,
            'currentProject' => $currentProject,
        ));
        $view->setTerminal(true);
        return $view;

    }

    public function luceneAction()
    {
        // Create index
        $index = Zend\Search\Lucene::create(PUBLIC_PATH . '/lucene/realestate');

        $doc = new Zend\Search\Lucene\Document();

        // Store document URL to identify it in the search results
        $doc->addField(Zend\Search\Lucene\Field::Text('url', 'xin chào'));

        // Index document contents
        $doc->addField(Zend\Search\Lucene\Field::UnStored('contents', 'hhi chán quá'));

        // Add document to the index
        $index->addDocument($doc);
        return $this->getResponse();
    }


}
