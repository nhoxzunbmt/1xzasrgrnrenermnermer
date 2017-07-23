<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Home;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Admin\Model\User;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
class Module
{
    public function onBootstrap(MvcEvent $e)
    {
       
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $eventManager->attach('dispatch',array($this,'loadConfig'));
    }
    public function getFormElementConfig(){
        return array(
            'factories' =>  array(
                'loginForm'  =>  function($sm){
                    $myForm = new \Home\Form\Login();
                    $myForm->setInputFilter(new \Home\Form\LoginFilter());
                    return $myForm;
                },
                'contactMeForm'  =>  function($sm){
                    $myForm = new \Home\Form\ContactMe();
                    $myForm->setInputFilter(new \Home\Form\ContactMeFilter());
                    return $myForm;
                },
                'fengshuiForm'  =>  function($sm){
                    $myForm = new \Home\Form\FengShui();
                    $myForm->setInputFilter(new \Home\Form\FengShuiFilter());
                    return $myForm;
                },
                'emailNewsLetterForm'  =>  function($sm){
                    $myForm = new \Home\Form\EmailNewsLetter();
                    $myForm->setInputFilter(new \Home\Form\EmailNewsLetterFilter());
                    return $myForm;
                },
                'registerHomeForm'  =>  function($sm){
                    $myForm = new \Home\Form\Register();
                    $myForm->setInputFilter(new \Home\Form\RegisterFilter());
                    return $myForm;
                },
                'forgotPasswordHomeForm'  =>  function($sm){
                    $myForm = new \Home\Form\ForgotPassword();
                    $myForm->setInputFilter(new \Home\Form\ForgotPasswordFilter());
                    return $myForm;
                },
                'restorePasswordHomeForm'  =>  function($sm){
                    $myForm = new \Home\Form\RestorePassword();
                    $myForm->setInputFilter(new \Home\Form\RestorePasswordFilter());
                    return $myForm;
                }
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig(){
        
        return array(
            'factories' =>  array(
                'AuthenticateService'   =>  function($sm){
                    $dbTableAdapter   = new \Zend\Authentication\Adapter\DbTable($sm->get('dbBatDongSan'),'users','email','password','MD5(?)');
                    $dbTableAdapter->getDbSelect()->where->equalTo('status',1);
                    $authenticateServiceObj = new \Zend\Authentication\AuthenticationService(null,$dbTableAdapter);
                    return $authenticateServiceObj;
                },
                'Authenticate'   =>  function($sm){
                    return new \ZendVN\System\Authenticate($sm->get('AuthenticateService'));

                },
                'RealEstateTableGateway'  =>  function($sm){
                    $adapter     = $sm->get('dbBatDongSan');
                    $resultSetProtype    = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Home\Model\Entity\RealEstate());
                    return new TableGateway('category',$adapter,null,$resultSetProtype);
                },
                'Home\Model\RealEstateTable' =>  function($sm){
                    $tableGateway = $sm->get('RealEstateTableGateway');
                    return new \Home\Model\RealEstateTable($tableGateway);
                },
                'BusinessTableGateway'  =>  function($sm){
                    $adapter     = $sm->get('dbBatDongSan');
                    $resultSetProtype    = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Home\Model\Entity\Business());
                    return new TableGateway('business',$adapter,null,$resultSetProtype);
                },
                'Home\Model\BusinessTable' =>  function($sm){
                    $tableGateway = $sm->get('BusinessTableGateway');
                    return new \Home\Model\BusinessTable($tableGateway);
                },
                'AgencyTableGateway'  =>  function($sm){
                    $adapter     = $sm->get('dbBatDongSan');
                    $resultSetProtype    = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Home\Model\Entity\Agency());
                    return new TableGateway('users',$adapter,null,$resultSetProtype);
                },
                'Home\Model\AgencyTable' =>  function($sm){
                    $tableGateway = $sm->get('AgencyTableGateway');
                    return new \Home\Model\AgencyTable($tableGateway);
                },
                'NewsTableGateway'  =>  function($sm){
                    $adapter     = $sm->get('dbBatDongSan');
                    $resultSetProtype    = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Home\Model\Entity\News());
                    return new TableGateway('category',$adapter,null,$resultSetProtype);
                },
                'Home\Model\NewsTable' =>  function($sm){
                    $tableGateway = $sm->get('NewsTableGateway');
                    return new \Home\Model\NewsTable($tableGateway);
                },
                'FengshuiTableGateway'  =>  function($sm){
                    $adapter     = $sm->get('dbBatDongSan');
                    $resultSetProtype    = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Home\Model\Entity\Fengshui());
                    return new TableGateway('category',$adapter,null,$resultSetProtype);
                },
                'Home\Model\FengshuiTable' =>  function($sm){
                    $tableGateway = $sm->get('FengshuiTableGateway');
                    return new \Home\Model\FengshuiTable($tableGateway);
                },
                'LegalHousingTableGateway'  =>  function($sm){
                    $adapter     = $sm->get('dbBatDongSan');
                    $resultSetProtype    = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Home\Model\Entity\LegalHousing());
                    return new TableGateway('category',$adapter,null,$resultSetProtype);
                },
                'Home\Model\LegalHousingTable' =>  function($sm){
                    $tableGateway = $sm->get('LegalHousingTableGateway');
                    return new \Home\Model\LegalHousingTable($tableGateway);
                },
                'LegislationHousingTableGateway'  =>  function($sm){
                    $adapter     = $sm->get('dbBatDongSan');
                    $resultSetProtype    = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Home\Model\Entity\LegislationHousing());
                    return new TableGateway('category',$adapter,null,$resultSetProtype);
                },
                'Home\Model\LegislationHousingTable' =>  function($sm){
                    $tableGateway = $sm->get('LegislationHousingTableGateway');
                    return new \Home\Model\LegislationHousingTable($tableGateway);
                },
                'ContractFormTableGateway'  =>  function($sm){
                    $adapter     = $sm->get('dbBatDongSan');
                    $resultSetProtype    = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Home\Model\Entity\ContractForm());
                    return new TableGateway('category',$adapter,null,$resultSetProtype);
                },
                'Home\Model\ContractFormTable' =>  function($sm){
                    $tableGateway = $sm->get('ContractFormTableGateway');
                    return new \Home\Model\ContractFormTable($tableGateway);
                },
                'NiceHouseTableGateway'  =>  function($sm){
                    $adapter     = $sm->get('dbBatDongSan');
                    $resultSetProtype    = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Home\Model\Entity\NiceHouse());
                    return new TableGateway('category',$adapter,null,$resultSetProtype);
                },
                'Home\Model\NiceHouseTable' =>  function($sm){
                    $tableGateway = $sm->get('NiceHouseTableGateway');
                    return new \Home\Model\NiceHouseTable($tableGateway);
                },
                'ProjectTableGateway'  =>  function($sm){
                    $adapter     = $sm->get('dbBatDongSan');
                    $resultSetProtype    = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Home\Model\Entity\Project());
                    return new TableGateway('category',$adapter,null,$resultSetProtype);
                },
                'Home\Model\ProjectTable' =>  function($sm){
                    $tableGateway = $sm->get('ProjectTableGateway');
                    return new \Home\Model\ProjectTable($tableGateway);
                },
                'MarketTableGateway'  =>  function($sm){
                    $adapter     = $sm->get('dbBatDongSan');
                    $resultSetProtype    = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Home\Model\Entity\Market());
                    return new TableGateway('category',$adapter,null,$resultSetProtype);
                },
                'Home\Model\MarketTable' =>  function($sm){
                    $tableGateway = $sm->get('MarketTableGateway');
                    return new \Home\Model\MarketTable($tableGateway);
                },
                'UserTableGateway'  =>  function($sm){
                    $adapter     = $sm->get('dbBatDongSan');
                    $resultSetProtype    = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Home\Model\Entity\User());
                    return new TableGateway('users',$adapter,null,$resultSetProtype);
                },
                'Home\Model\UserTable' =>  function($sm){
                    $tableGateway = $sm->get('UserTableGateway');
                    return new \Home\Model\UserTable($tableGateway);
                },
                'PermissionTableGateway'  =>  function($sm){
                    $adapter     = $sm->get('dbBatDongSan');
                    $resultSetProtype    = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Home\Model\Entity\Permission());
                    return new TableGateway('permission',$adapter,null,$resultSetProtype);
                },
                'Home\Model\PermissionTable' =>  function($sm){
                    $tableGateway = $sm->get('PermissionTableGateway');
                    return new \Home\Model\PermissionTable($tableGateway);
                },
            ),
        );
    }


   

    public function loadConfig(MvcEvent $e){

        $routeMatch                         = $e->getRouteMatch();
        $controllerArray                    = explode('\\', $routeMatch->getParam('controller'));
        $controllerArray[0];

        //Business Table
        $businessTable                      = $e->getApplication()->getServiceManager()->get('Home\Model\BusinessTable');
        $itemsCategory                      = $businessTable->listItem('',array('task'=>'list-item-type-business')); 
        $itemsCity                          = $businessTable->itemInselectBox('',array('task'=>'list-item-city')); 
        $listCity                           = array_slice($itemsCity,1,count($itemsCity) - 1);
        //News Table
        $newsTable                          = $e->getApplication()->getServiceManager()->get('Home\Model\NewsTable');
        $itemsNewsCategory                  = $newsTable->listItem('',array('task'=>'list-category'));
       
        //Fengshui Table
        $fengshuiTable                      = $e->getApplication()->getServiceManager()->get('Home\Model\FengshuiTable');
        $itemsFengshuiCategory              = $fengshuiTable->listItem('',array('task'=>'list-category'));
        
        //Legal Housing Table
        $legalHousingTable                  = $e->getApplication()->getServiceManager()->get('Home\Model\LegalHousingTable');
        $itemsLegalHousingCategory          = $legalHousingTable->listItem('',array('task'=>'list-category'));

         //Legal Housing Table
        $legislationHousingTable            = $e->getApplication()->getServiceManager()->get('Home\Model\LegislationHousingTable');
        $itemsLegislationHousingCategory    = $legislationHousingTable->listItem('',array('task'=>'list-category'));

         //Contract Form Table
        $contractFormTable                  = $e->getApplication()->getServiceManager()->get('Home\Model\ContractFormTable');
        $itemsContractFormCategory          = $contractFormTable->listItem('',array('task'=>'list-category'));

        //nice house Table
        $niceHouseTable                     = $e->getApplication()->getServiceManager()->get('Home\Model\NiceHouseTable');
        $listCategoryNiceHouse              = $niceHouseTable->listItem('',array('task'=>'list-category')); 
    
        //Project Table
        $projectTable                       = $e->getApplication()->getServiceManager()->get('Home\Model\ProjectTable');
        $listCategoryProject                = $projectTable->itemInselectBox('',array('task'=>'list-item-project-category')); 
        $listItemCategoryProject            = array_slice($listCategoryProject,1,count($listCategoryProject) - 1);

        //Skin
        $skinTable                          = $e->getApplication()->getServiceManager()->get('Admin\Model\SkinTable');
        $itemSkin                           = $skinTable->getItem(array('id'=>1),array('task'=>'get-item'));

        //NavFooter
        $navFooterTable                     = $e->getApplication()->getServiceManager()->get('Admin\Model\NavFooterTable');
        $itemNavFooter                      = $navFooterTable->listItem(null,array('task'=>'list-item'));

        //Support
        $supportTable                       = $e->getApplication()->getServiceManager()->get('Admin\Model\SupportTable');
        $itemSupport                        = $supportTable->listItem(null,array('task'=>'block-support'));
        
        //Real Estate Table
        $realEstateTable                    = $e->getApplication()->getServiceManager()->get('Home\Model\RealEstateTable');
        $itemTypeRealEstate                 = $realEstateTable->listItem(null,array('task'=>'list-item-type-real-estate'));
        
        //notifi
        $notifiTable                        = $e->getApplication()->getServiceManager()->get('Admin\Model\NotifiTable');
        $itemNotifi                         = $notifiTable->getItem(array('id'=>2),array('task'=>'get-item'));
        
        //Truyền ra view
        $viewModel                          = $e->getApplication()->getMvcEvent()->getViewModel();
        $viewModel->arrParams   = array(
            'module'                            =>  strtolower($controllerArray[0]),
            'controller'                        =>  strtolower($controllerArray[2]),
            'action'                            =>  $routeMatch->getParam('action'),
            'itemsCategory'                     =>  $itemsCategory,
            'listCity'                          =>  $listCity,
            'itemsNewsCategory'                 =>  $itemsNewsCategory,
            'itemsFengshuiCategory'             =>  $itemsFengshuiCategory,
            'itemsLegalHousingCategory'         =>  $itemsLegalHousingCategory,
            'itemsLegislationHousingCategory'   =>  $itemsLegislationHousingCategory,
            'itemsContractFormCategory'         =>  $itemsContractFormCategory,
            'listCategoryNiceHouse'             =>  $listCategoryNiceHouse,
            'listItemCategoryProject'           =>  $listItemCategoryProject,
            'itemSkin'                          =>  $itemSkin,
            'itemNavFooter'                     =>  $itemNavFooter,
            'itemTypeRealEstate'                =>  $itemTypeRealEstate,
            'itemSupport'                       =>  $itemSupport,
            'itemNotifi'                        =>  $itemNotifi,
        );
       
        //Thống kê truy cập
        $Statistics = new \ZendVN\Statistics\Access();  
    }

    public function getViewHelperConfig(){
        //$router         = $e->getEvent()->getRouter();
        return array(
            'invokables'    =>  array(
                //'blkCafeLuat'   =>  '\Block\BlkCafeLuat',
            ),
            'factories' =>  array(
                'blkCafeLuat'   =>  function($sm){
                    $helper = new \Block\BlkCafeLuat();
                    $helper->setData($sm->getServiceLocator()->get('Home\Model\LegalHousingTable'));
                    return $helper;
                },
                'blkAgency'   =>  function($sm){
                    $helper = new \Block\BlkAgency();
                    $helper->setData($sm->getServiceLocator()->get('Home\Model\AgencyTable'));
                    return $helper;
                },
                'blkBangGiaDuAn'   =>  function($sm){
                    $helper = new \Block\BlkBangGiaDuAn();
                    $helper->setData($sm->getServiceLocator()->get('Home\Model\MarketTable'));
                    return $helper;
                },
                'blkFengShui'   =>  function($sm){
                    $helper = new \Block\BlkFengShui();
                    $helper->setData($sm->getServiceLocator()->get('Home\Model\FengshuiTable'));
                    return $helper;
                },
                'blkRegisterEmail'   =>  function($sm){
                    $helper = new \Block\BlkRegisterEmail();
                    $helper->setData($sm->getServiceLocator()->get('Home\Model\FengshuiTable'));
                    return $helper;
                },
                'blkNhanXet'   =>  function($sm){
                    $helper = new \Block\BlkNhanXet();
                    $helper->setData($sm->getServiceLocator()->get('Home\Model\AgencyTable'));
                    return $helper;
                },
                'blkLienKet'   =>  function($sm){
                    $helper = new \Block\BlkLienKet();
                    $helper->setData($sm->getServiceLocator()->get('Home\Model\NewsTable'));
                    return $helper;
                },
                'blkAdsColumnRight'   =>  function($sm){
                    $helper = new \Block\BlkAdsColumnRight();
                    $helper->setData($sm->getServiceLocator()->get('Admin\Model\AdsTable'));
                    return $helper;
                },
                'blkAdsBottom'   =>  function($sm){
                    $helper = new \Block\BlkAdsBottom();
                    $helper->setData($sm->getServiceLocator()->get('Admin\Model\AdsTable'));
                    return $helper;
                },
                'blkAdsTop'   =>  function($sm){
                    $helper = new \Block\BlkAdsTop();
                    $helper->setData($sm->getServiceLocator()->get('Admin\Model\AdsTable'));
                    return $helper;
                },
                'blkSlideNiceHouse'   =>  function($sm){
                    $helper = new \Block\BlkSlideNiceHouse();
                    $helper->setData($sm->getServiceLocator()->get('Home\Model\NiceHouseTable'));
                    return $helper;
                },
                'blkSlideFengShui'   =>  function($sm){
                    $helper = new \Block\BlkSlideFengShui();
                    $helper->setData($sm->getServiceLocator()->get('Home\Model\FengshuiTable'));
                    return $helper;
                },
                'blkSlideNews'   =>  function($sm){
                    $helper = new \Block\BlkSlideNews();
                    $helper->setData($sm->getServiceLocator()->get('Home\Model\NewsTable'));
                    return $helper;
                },
                'blkAccountGroup'   =>  function($sm){
                    $helper = new \Block\BlkAccountGroup();
                    $helper->setData($sm->getServiceLocator()->get('Home\Model\NewsTable'));
                    return $helper;
                },
                
                
                
                'sidebarAds'   =>  function($sm){
                    $helper = new \Sidebar\SidebarAds();
                    $helper->setTable($sm->getServiceLocator()->get('Admin\Model\AdsTable'));
                    return $helper;
                },
                'sidebarReal'   =>  function($sm){
                    $helper = new \Sidebar\SidebarReal();
                    $helper->setTable($sm->getServiceLocator()->get('Home\Model\RealEstateTable'));
                    return $helper;
                },
                'blkRelated'   =>  function($sm){
                    $helper = new \Block\BlkRelated();
                    $helper->setTable($sm->getServiceLocator()->get('Admin\Model\AdsTable'));
                    return $helper;
                }
            ),
        );
    }
}
