<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace User;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

use Admin\Model\UserTable;
use Admin\Model\User;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $adapter = $e->getApplication()->getServiceManager()->get('dbBatDongSan');
        GlobalAdapterFeature::setStaticAdapter($adapter);
    }

    public function getFormElementConfig(){
        return array(
            'factories' =>  array(
                'RealEstateForm'  =>  function($sm){
                    $myForm = new \User\Form\RealEstate();
                    $myForm->setInputFilter(new \User\Form\RealEstateFilter());
                    return $myForm;
                },
                'accountForm'  =>  function($sm){
                    $myForm = new \User\Form\Account();
                    $myForm->setInputFilter(new \User\Form\AccountFilter());
                    return $myForm;
                },
                'changePasswordForm'  =>  function($sm){
                    $myForm = new \User\Form\ChangePassword();
                    $myForm->setInputFilter(new \User\Form\ChangePasswordFilter());
                    return $myForm;
                },
                'businessUserForm'  =>  function($sm){
                    $myForm = new \User\Form\Business();
                    $myForm->setInputFilter(new \User\Form\BusinessFilter());
                    return $myForm;
                },
                'registerEmailUserForm'  =>  function($sm){
                    $myForm = new \User\Form\RegisterEmail();
                    $myForm->setInputFilter(new \User\Form\RegisterEmailFilter());
                    return $myForm;
                },
                'serviceAccountUserForm'  =>  function($sm){
                    $myForm = new \User\Form\ServiceAccount();
                    $myForm->setInputFilter(new \User\Form\ServiceAccountFilter());
                    return $myForm;
                },
                'messageUserForm'  =>  function($sm){
                    $myForm = new \User\Form\Message();
                    $myForm->setInputFilter(new \User\Form\MessageFilter());
                    return $myForm;
                },
                'contactUserForm'  =>  function($sm){
                    $myForm = new \User\Form\Contact();
                    $myForm->setInputFilter(new \User\Form\ContactFilter());
                    return $myForm;
                },
                'commentUserForm'  =>  function($sm){
                    $myForm = new \User\Form\Comment();
                    $myForm->setInputFilter(new \User\Form\CommentFilter());
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
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'RealEstateUserTableGateway'  =>  function($sm){
                    $adapter     = $sm->get('dbBatDongSan');
                    $resultSetProtype    = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \User\Model\Entity\RealEstate());
                    return new TableGateway('real_estate',$adapter,null,$resultSetProtype);
                },
                'User\Model\RealEstateTable' =>  function($sm){
                    $tableGateway = $sm->get('RealEstateUserTableGateway');
                    return new \User\Model\RealEstateTable($tableGateway);
                },
                'AccountTableGateway'  =>  function($sm){
                    $adapter     = $sm->get('dbBatDongSan');
                    $resultSetProtype    = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \User\Model\Entity\Account());
                    return new TableGateway('users',$adapter,null,$resultSetProtype);
                },
                'User\Model\AccountTable' =>  function($sm){
                    $tableGateway = $sm->get('AccountTableGateway');
                    return new \User\Model\AccountTable($tableGateway);
                },
                'BusinessTableGateway'  =>  function($sm){
                    $adapter     = $sm->get('dbBatDongSan');
                    $resultSetProtype    = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \User\Model\Entity\Business());
                    return new TableGateway('business',$adapter,null,$resultSetProtype);
                },
                'User\Model\BusinessTable' =>  function($sm){
                    $tableGateway = $sm->get('BusinessTableGateway');
                    return new \User\Model\BusinessTable($tableGateway);
                },
                'StatisticTableGateway'  =>  function($sm){
                    $adapter     = $sm->get('dbBatDongSan');
                    $resultSetProtype    = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \User\Model\Entity\Statistic());
                    return new TableGateway('real_estate',$adapter,null,$resultSetProtype);
                },
                'User\Model\StatisticTable' =>  function($sm){
                    $tableGateway = $sm->get('StatisticTableGateway');
                    return new \User\Model\StatisticTable($tableGateway);
                },
                'RegisterEmailTableGateway'  =>  function($sm){
                    $adapter     = $sm->get('dbBatDongSan');
                    $resultSetProtype    = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \User\Model\Entity\RegisterEmail());
                    return new TableGateway('register_email',$adapter,null,$resultSetProtype);
                },
                'User\Model\RegisterEmailTable' =>  function($sm){
                    $tableGateway = $sm->get('RegisterEmailTableGateway');
                    return new \User\Model\RegisterEmailTable($tableGateway);
                },
                'ServiceTableGateway'  =>  function($sm){
                    $adapter     = $sm->get('dbBatDongSan');
                    $resultSetProtype    = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \User\Model\Entity\Service());
                    return new TableGateway('service_account',$adapter,null,$resultSetProtype);
                },
                'User\Model\ServiceTable' =>  function($sm){
                    $tableGateway = $sm->get('ServiceTableGateway');
                    return new \User\Model\ServiceTable($tableGateway);
                },
                'MessageTableGateway'  =>  function($sm){
                    $adapter     = $sm->get('dbBatDongSan');
                    $resultSetProtype    = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \User\Model\Entity\Message());
                    return new TableGateway('message_send',$adapter,null,$resultSetProtype);
                },
                'User\Model\MessageTable' =>  function($sm){
                    $tableGateway = $sm->get('MessageTableGateway');
                    return new \User\Model\MessageTable($tableGateway);
                },
                'ContactTableGateway'  =>  function($sm){
                    $adapter     = $sm->get('dbBatDongSan');
                    $resultSetProtype    = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \User\Model\Entity\Contact());
                    return new TableGateway('contact',$adapter,null,$resultSetProtype);
                },
                'User\Model\ContactTable' =>  function($sm){
                    $tableGateway = $sm->get('ContactTableGateway');
                    return new \User\Model\ContactTable($tableGateway);
                },
                'ContactRealEstateTableGateway'  =>  function($sm){
                    $adapter     = $sm->get('dbBatDongSan');
                    $resultSetProtype    = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \User\Model\Entity\ContactRealEstate());
                    return new TableGateway('contact_real_estate',$adapter,null,$resultSetProtype);
                },
                'User\Model\ContactRealEstateTable' =>  function($sm){
                    $tableGateway = $sm->get('ContactRealEstateTableGateway');
                    return new \User\Model\ContactRealEstateTable($tableGateway);
                },
                'ContactAgencyTableGateway'  =>  function($sm){
                    $adapter     = $sm->get('dbBatDongSan');
                    $resultSetProtype    = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \User\Model\Entity\ContactAgency());
                    return new TableGateway('contact_agency',$adapter,null,$resultSetProtype);
                },
                'User\Model\ContactAgencyTable' =>  function($sm){
                    $tableGateway = $sm->get('ContactAgencyTableGateway');
                    return new \User\Model\ContactAgencyTable($tableGateway);
                },
                'ContactBusinessTableGateway'  =>  function($sm){
                    $adapter     = $sm->get('dbBatDongSan');
                    $resultSetProtype    = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \User\Model\Entity\ContactBusiness());
                    return new TableGateway('contact_business',$adapter,null,$resultSetProtype);
                },
                'User\Model\ContactBusinessTable' =>  function($sm){
                    $tableGateway = $sm->get('ContactBusinessTableGateway');
                    return new \User\Model\ContactBusinessTable($tableGateway);
                },
                'CommentTableGateway'  =>  function($sm){
                    $adapter     = $sm->get('dbBatDongSan');
                    $resultSetProtype    = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \User\Model\Entity\Comment());
                    return new TableGateway('comment',$adapter,null,$resultSetProtype);
                },
                'User\Model\CommentTable' =>  function($sm){
                    $tableGateway = $sm->get('CommentTableGateway');
                    return new \User\Model\CommentTable($tableGateway);
                },
            ),
        );
    }

    
}
