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
class NoticeController extends ActionController
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
        'tableName' =>  '',
        'formName'  =>  '',
    );

 

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

    public function noAccessAction()
    {
        $view               = new ViewModel();
        //Tiêu đề
        $title      =  'Cấm truy cập';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
        
        $view->setVariables(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            
           
        ));
        return $view;
        
    }

    public function noticeAction()
    {
        $view               = new ViewModel();
        //Tiêu đề
        $title      =  'Thông báo';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
        
        $view->setVariables(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            
           
        ));
        return $view;
        
    }

    public function noViewAction()
    {
        
        $view               = new ViewModel();
        //Tiêu đề
        $title      =  'No view';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
        
        $view->setVariables(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            
           
        ));
        return $view;

    }

    public function notFoundPageBusinessAction()
    {
        
        $view               = new ViewModel();
        //Tiêu đề
        $title      =  'Không tìm thấy trang doanh nghiệp';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
        
        $view->setVariables(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            
           
        ));
        return $view;

    }

    public function maintenanceAction()
    {
        
        $view               = new ViewModel();
        //Tiêu đề
        $title      =  'Bảo trì website';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
        $config     = $this->getServiceLocator()->get('Admin\Model\ConfigTable');
        $item       = $config->getItem(array('id'=>1),array('task'=>'get-item'));      
        $arrConfig  = \Zend\Json\Json::decode($item->maintenance);
        $view->setVariables(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'notice'            =>  $arrConfig->notice,
           
        ));
        return $view;

    }

    public function bannedAction()
    {
        
        $view               = new ViewModel();
        //Tiêu đề
        $title      =  'Bạn bị cấm truy cập';   
        $this->headTitle($title)->setSeparator(" - ")->append("Website bất động sản");
        $noticeBan = '';
        //Trường hợp thành viên đăng nhập(cấm nick)
        if(!empty($this->identity()->id)){
            $userTable  = $this->getServiceLocator()->get('Admin\Model\UserTable');
            $itemBan    = $userTable->getItem(array('id'=>$this->identity()->id),array('task'=>'get-item-with-id'));
            if(!empty($itemBan)){
               $noticeBan =  $itemBan['nguyennhan'];
            }
        }else{
            //Trường hợp cấm IP
            $ip = $_SERVER['REMOTE_ADDR'];
            $validator = new \Zend\Validator\Ip();
            if($validator->isValid($ip)) {
                $userTable  = $this->getServiceLocator()->get('Admin\Model\UserTable');
                $itemBan    = $userTable->getItem(array('ip'=>$ip),array('task'=>'get-item-with-ip'));
                if(!empty($itemBan)){
                    $noticeBan =  $itemBan['nguyennhan'];
                }
            } 
        }

        
        $view->setVariables(array(
            'title'             =>  $title,
            'arrParam'          =>  $this->_arrParam,
            'currentController' =>  $this->_currentController,
            'notice'            =>  $noticeBan,
           
        ));
        return $view;

    }
   
    
}
