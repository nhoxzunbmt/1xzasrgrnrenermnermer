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
        'itemCountPerPage'  =>  10,
        'pageRange'         =>  4,

    );

    protected $_userTable;
    protected $_userGroupTable;

    public function getTable(){
        if(empty($this->_userTable)){
            $this->_userTable = $this->getServiceLocator()->get('Admin\Model\IndexTable');
        }
        return $this->_userTable;
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
            $this->layout('layout/list');


        
    }

    public function indexAction()
    {
        //Tiêu đề
        $title      =  'Admin Control Panel';   
        $this->headTitle($title)->setSeparator(" - ")->append("Hệ thống quản trị website");

        $this->_arrParam['count_realestate_new']    = $this->getTable()->countItem(null,array('task'=>'realestate-new'));
        $this->_arrParam['count_realestate']    = $this->getTable()->countItem(null,array('task'=>'realestate'));
        $this->_arrParam['count_project']       = $this->getTable()->countItem(null,array('task'=>'project'));
        $this->_arrParam['count_business']      = $this->getTable()->countItem(null,array('task'=>'business'));
        $this->_arrParam['count_user']          = $this->getTable()->countItem(null,array('task'=>'user'));
        $this->_arrParam['count_contact']       = $this->getTable()->countItem(null,array('task'=>'contact'));
        $this->_arrParam['count_contact_new']   = $this->getTable()->countItem(null,array('task'=>'contact-new'));
        $this->_arrParam['count_emailmaketing'] = $this->getTable()->countItem(null,array('task'=>'emailmaketing'));

        $this->_arrParam['listItemRealEstate']  = $this->getTable()->listItem(null,array('task'=>'list-items-realestate-moi-nhat'));
        $this->_arrParam['listItemUserNew']  = $this->getTable()->listItem(null,array('task'=>'list-items-user-new'));
        $this->_arrParam['listItemEmailRegisterNew']  = $this->getTable()->listItem(null,array('task'=>'list-items-email-register-new'));
        $this->_arrParam['ChartStatisticsAccess']  = $this->getTable()->listItem(null,array('task'=>'ChartStatisticsAccess'));

        
        
        return new ViewModel(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
        ));
        
    }
    
    
    
}
