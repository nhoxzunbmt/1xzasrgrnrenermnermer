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
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container as Container;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Validator\Db\RecordExists;
use Zend\Validator\Db\NoRecordExists;
use Zend\Stdlib\ArrayObject;
class ToolController extends AbstractActionController
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
            $this->_userTable = $this->getServiceLocator()->get('Admin\Model\CityTable');
        }
        return $this->_userTable;
    }

    public function setEventManager(EventManagerInterface $events)
    {
        parent::setEventManager($events);

        $controller = $this;
        $events->attach('dispatch', function ($e) use ($controller) {
           
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


        }, 100); // execute before executing action logic
    }

    public function init()
    {




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

        $this->adapter = GlobalAdapterFeature::getStaticAdapter();

        //Load templates
        $this->layout('layout/home');



    }


    public function indexAction()
    {

        die('123');

    }
    private function convert_utf8($text)
    {
        return $text;
        //return iconv(mb_detect_encoding($text, mb_detect_order(), true), "UTF-8", $text);
    }
    public function insertCityAction()
    {
        $cityTable = $this->getServiceLocator()->get('Admin\Model\CityTable');
        $this->_arrPost['name'] = $this->convert_utf8($this->_arrPost['name']);
        $this->_arrPost['is_active'] = 1;

        if($cityTable->getItem($this->_arrPost,array('task'=>'get-item')))
        {
            $this->_arrPost['updated_at'] = date('Y-m-d H:i:s');
            $arrOptions = array('task'=>'edit');
        }
        else
        {
            $arrOptions = array('task'=>'add');
        }

        $lastInsertId = $cityTable->saveItem($this->_arrPost,$arrOptions);

        $result = array('id' => $lastInsertId);
        echo \Zend\Json\Json::encode($result);
        return $this->getResponse();

    }
    public function insertDistrictAction()
    {
        $districtTable = $this->getServiceLocator()->get('Admin\Model\DistrictTable');
        $this->_arrPost['name'] = $this->convert_utf8($this->_arrPost['name']);
        $this->_arrPost['is_active'] = 1;

        if($districtTable->getItem($this->_arrPost,array('task'=>'get-item')))
        {
            $this->_arrPost['updated_at'] = date('Y-m-d H:i:s');
            $arrOptions = array('task'=>'edit');
        }
        else
        {
            $arrOptions = array('task'=>'add');
        }

        $lastInsertId = $districtTable->saveItem($this->_arrPost,$arrOptions);

        $result = array('id' => $lastInsertId);
        echo \Zend\Json\Json::encode($result);
        return $this->getResponse();
    }
    public function updateAction()
    {
        $cityTable = $this->getServiceLocator()->get('Admin\Model\CityTable');
        $arrCity = $cityTable->listItem();
        foreach ($arrCity as $item) {
            echo $item->name.'<br>';
        }
        die(__FUNCTION__);
    }

    public function insertWardAction()
    {
        set_time_limit(0);
        ini_set("memory_limit", "-1");
        $wardTable = $this->getServiceLocator()->get('Admin\Model\WardTable');

        $districtTable = $this->getServiceLocator()->get('Admin\Model\DistrictTable');
        $arrDistrict = $districtTable->listItem();
        $iCountUpdate = 0;
        foreach ($arrDistrict as $item) {
            $json = $this->getWard($item->id);
            $arrWards = json_decode($json,1);
            if($arrWards['Status'])
            {
                foreach ($arrWards['Data'] as $ward) {
                    $arrDataWard = [
                        'id' => $ward['CityId'],
                        'city_id' => $ward['ParentId'],
                        'district_id' => $item->id,
                        'name' => $ward['Name'],
                        'alias' => $ward['CodeUrl']
                    ];
                    if($wardTable->getItem($arrDataWard,array('task'=>'get-item')))
                    {
                        $this->_arrPost['updated_at'] = date('Y-m-d H:i:s');
                        $arrOptions = array('task'=>'edit');
                    }
                    else
                    {
                        $arrOptions = array('task'=>'add');
                    }
                    $wardTable->saveItem($arrDataWard,$arrOptions);
                    $iCountUpdate++;
                }
            }
        }
        $arrResult['iCountUpdate'] = $iCountUpdate;
        echo \Zend\Json\Json::encode($arrResult);
        return $this->getResponse();
    }

    private function getWard($district_id)
    {
        $url = 'https://muaban.net/Classified/GetWards';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_NOBODY, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POST, 1);

        $postinfo = 'districtId='.$district_id;
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postinfo);
        $jSon =curl_exec($ch);
        return $jSon;
    }

    public function layoutAction()
    {

        $this->layout('layout/layout_v3');

        return $this;
    }
}
