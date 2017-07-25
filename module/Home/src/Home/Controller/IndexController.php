<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Home\Controller;

use Zend\Cache\PatternFactory;
use Zend\EventManager\EventManagerInterface;
use ZendVN\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container as Container;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Validator\Db\RecordExists;
use Zend\Validator\Db\NoRecordExists;
use Zend\Stdlib\ArrayObject;

class IndexController extends ActionController
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

    protected $_projectTable;
    protected $_realEstateTable;
    protected $_businessTable;
    protected $_newsTable;
    protected $_configTable;
    protected $_contactTable;

    public function getTable()
    {

        if (empty($this->_projectTable)) {
            $this->_projectTable = $this->getServiceLocator()->get('Home\Model\ProjectTable');
        }


        return $this->_projectTable;
    }

    public function getRealEstateTable()
    {
        if (empty($this->_realEstateTable)) {
            $this->_realEstateTable = $this->getServiceLocator()->get('Home\Model\RealEstateTable');

        }
        return $this->_realEstateTable;
    }

    public function getBusinessTable()
    {
        if (empty($this->_businessTable)) {
            $this->_businessTable = $this->getServiceLocator()->get('Home\Model\BusinessTable');

        }
        return $this->_businessTable;
    }

    public function getNewsTable()
    {
        if (empty($this->_newsTable)) {
            $this->_newsTable = $this->getServiceLocator()->get('Home\Model\NewsTable');

        }
        return $this->_newsTable;
    }

    public function getConfigTable()
    {
        if (empty($this->_configTable)) {
            $this->_configTable = $this->getServiceLocator()->get('Admin\Model\ConfigTable');

        }
        return $this->_configTable;
    }

    public function getContactTable()
    {
        if (empty($this->_contactTable)) {
            $this->_contactTable = $this->getServiceLocator()->get('Admin\Model\ContactTable');

        }
        return $this->_contactTable;
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




        if(isset($this->_arrParam['latitude']) && $this->_arrParam['latitude'] == 'v1')
        {
            $this->layout('layout/home');
        }
        else
        {
            $this->layout('layout/home_v2');
        }

    }

    public function indexAction()
    {
        $view = new ViewModel();
        //Tiêu đề
        $title = 'Mua bán nhà, mua bán đất, mua bán nhà đất, dự án, chung cư, căn hộ, biệt thự';
        $this->headTitle($title);

        $listItemHighlight = $this->getTable()->listItem($this->_arrParam, array('task' => 'list-items-hightlight'));

        //loại dự án
        $itemsProjectCat = $this->getTable()->itemInselectBox($this->_arrParam, array('task' => 'list-item-project-category'));
        //Bất động nổi bật
        $itemRealestateHighlight = $this->getRealEstateTable()->listItem($this->_arrParam, array('task' => 'list-items-realestate-highlight'));

        //Bất động sản chính chủ
        //$itemRealestateChinhChu       = $this->getRealEstateTable()->listItem($this->_arrParam,array('task'=>'list-items-realestate-chinh-chu')); 

        //Bất động sản Mới nhất
        $itemRealestateMoiNhat = $this->getRealEstateTable()->listItem($this->_arrParam, array('task' => 'list-items-realestate-moi-nhat'));

        //Doanh nghiệp nổi bật
        $itemBusinessHighlight = $this->getBusinessTable()->listItem($this->_arrParam, array('task' => 'list-items-business-highlight'));

        //Thành phố
        $itemsCity = $this->getBusinessTable()->itemInselectBox($this->_arrParam, array('task' => 'list-item-city'));

        $listCity = array_slice($itemsCity, 1, count($itemsCity) - 1);

        //Item select box
        $itemsTypeRealEstate = $this->getRealEstateTable()->itemInselectBox($this->_arrParam, array('task' => 'list-item-type-real-estate'));

        //Dự án
        $itemsProject = $this->getRealEstateTable()->itemInselectBox($this->_arrParam, array('task' => 'list-item-project'));


        //nested
        if(isset($this->_arrParam['latitude']) && $this->_arrParam['latitude'] == 'v1')
        {
            $view->setTemplate('home/index/index');
        }
        else
        {
            $view->setTemplate('home_v2/index/index');
        }


        $formSearch = new ViewModel(array(
            'itemsTypeRealEstate' => $itemsTypeRealEstate,
            'itemsCity' => $itemsCity,
            'itemsProject' => $itemsProject,
            'itemsProjectCat' => $itemsProjectCat,
        ));
        $formSearch->setTemplate('home/index/nested-form-search');

        $view->addChild($formSearch, 'formSearch');

        //end nested

        $view->setVariables(array(
            'title' => $title,
            'arrParam' => $this->_arrParam,
            'currentController' => $this->_currentController,
            'listItemHighlight' => $listItemHighlight,
            'itemRealestateHighlight' => $itemRealestateHighlight,
            //'itemRealestateChinhChu'    =>  $itemRealestateChinhChu,
            'itemBusinessHighlight' => $itemBusinessHighlight,
            'itemRealestateMoiNhat' => $itemRealestateMoiNhat,
        ));
        return $view;

    }

    public function testAction()
    {


        //$developerKey = 'AI39si6Jo4JaiNjb5ocqdac1z1sJl_IuNjJyGnJ0uEt10GBJNxE0zpski0aP58TmriRIG9tUBS5oYE65SeAhE5iW2mEAtd_eeQ';

        $yt = new \ZendGData\YouTube();


        $query = $yt->newVideoQuery();
        $query->videoQuery = 'cat';
        $query->startIndex = 10;
        $query->maxResults = 20;


        $query->queryUrl . "\n";
        $videoFeed = $yt->getVideoFeed($query);

        foreach ($videoFeed as $videoEntry) {
            echo "---------VIDEO----------\n";
            echo "Title: " . $videoEntry->getVideoTitle() . "\n";
            echo "\nDescription:\n";
            echo $videoEntry->getVideoDescription();
            echo "\n\n\n";
        }
        return $this->getResponse();
    }


    //Gửi liên hệ
    public function emailNewsletterAction()
    {
        $view = new ViewModel();

        //Tiêu đề
        $title = 'Đăng kí nhận bản tin';
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");

        $emailNewsLetterForm = $this->serviceLocator->get('FormElementManager')->get('emailNewsLetterForm');

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $emailNewsLetterForm->setData($data);
            if ($emailNewsLetterForm->isValid()) {

                //Chống tấn công XSS
                $purifier = new \HTMLPurifier_HTMLPurifier();
                $data = array(
                    'fullname' => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['fullname'])),
                    'email' => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['email'])),
                    'date_time' => date('d/m/y h:i:s'),
                );
                $this->getNewsTable()->saveItem($data, array('task' => 'email-newsLetter'));
                $this->flashMessenger()->addSuccessMessage('Bạn đã đăng kí email thành công');
                $this->redirect()->toUrl('/home/index/email-newsletter');

            }
        }


        $view->setVariables(array(
            'title' => $title,
            'arrParam' => $this->_arrParam,
            'currentController' => $this->_currentController,
            'myForm' => $emailNewsLetterForm,
        ));
        return $view;

    }

    //Gửi liên hệ
    public function supportAction()
    {
        $view = new ViewModel();

        //Tiêu đề
        $title = 'Trao đổi liên hệ';
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
        $this->_arrParam['id'] = 1;
        $item = $this->getConfigTable()->getItem($this->_arrParam, array('task' => 'get-item'));


        $contactMeForm = $this->serviceLocator->get('FormElementManager')->get('contactMeForm');

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $contactMeForm->setData($data);
            if ($contactMeForm->isValid()) {

                //Chống tấn công XSS
                $purifier = new \HTMLPurifier_HTMLPurifier();
                $data = array(
                    'fullname' => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['contact-me-fullname'])),
                    'email' => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['contact-me-email'])),
                    'phone' => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['contact-me-phone'])),
                    'title' => 'Chưa có tiêu đề',
                    'content' => $purifier->purify($this->_viewHelper->cmsReplaceString($this->_arrPost['contact-me-content'])),
                    'date_time' => date('d/m/y h:i:s'),
                );
                $this->getContactTable()->saveItem($data, array('task' => 'add'));
                $this->flashMessenger()->addSuccessMessage('Bạn đã đăng kí email thành công');
                $this->redirect()->toUrl('/home/index/support');

            }
        }


        $view->setVariables(array(
            'title' => $title,
            'arrParam' => $this->_arrParam,
            'currentController' => $this->_currentController,
            'myForm' => $contactMeForm,
            'item' => $item,
        ));
        return $view;

    }

}
