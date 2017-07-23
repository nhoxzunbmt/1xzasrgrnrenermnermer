<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $adapter = $e->getApplication()->getServiceManager()->get('dbBatDongSan');
        GlobalAdapterFeature::setStaticAdapter($adapter);
    }

    public function getFormElementConfig()
    {
        return array(
            'factories' => array(
                'findForm' => function ($sm) {
                    $myForm = new \Admin\Form\Find();
                    $myForm->setInputFilter(new \Admin\Form\FindFilter());
                    return $myForm;
                },
                'userForm' => function ($sm) {
                    $myForm = new \Admin\Form\User();
                    $myForm->setInputFilter(new \Admin\Form\UserFilter());
                    return $myForm;
                },
                'businessForm' => function ($sm) {
                    $myForm = new \Admin\Form\Business();
                    $myForm->setInputFilter(new \Admin\Form\BusinessFilter());
                    return $myForm;
                },
                'newsForm' => function ($sm) {
                    $myForm = new \Admin\Form\News();
                    $myForm->setInputFilter(new \Admin\Form\NewsFilter());
                    return $myForm;
                },
                'fengshuiNewsForm' => function ($sm) {
                    $myForm = new \Admin\Form\FengshuiNews();
                    $myForm->setInputFilter(new \Admin\Form\FengshuiNewsFilter());
                    return $myForm;
                },
                'legalhousingForm' => function ($sm) {
                    $myForm = new \Admin\Form\LegalHousing();
                    $myForm->setInputFilter(new \Admin\Form\LegalHousingFilter());
                    return $myForm;
                },
                'legislationHousingForm' => function ($sm) {
                    $myForm = new \Admin\Form\LegislationHousing();
                    $myForm->setInputFilter(new \Admin\Form\LegislationHousingFilter());
                    return $myForm;
                },
                'contractFormForm' => function ($sm) {
                    $myForm = new \Admin\Form\ContractForm();
                    $myForm->setInputFilter(new \Admin\Form\ContractFormFilter());
                    return $myForm;
                },
                'niceHouseForm' => function ($sm) {
                    $myForm = new \Admin\Form\NiceHouse();
                    $myForm->setInputFilter(new \Admin\Form\NiceHouseFilter());
                    return $myForm;
                },
                'projectForm' => function ($sm) {
                    $myForm = new \Admin\Form\Project();
                    $myForm->setInputFilter(new \Admin\Form\ProjectFilter());
                    return $myForm;
                },
                'tvForm' => function ($sm) {
                    $myForm = new \Admin\Form\Tv();
                    $myForm->setInputFilter(new \Admin\Form\TvFilter());
                    return $myForm;
                },
                'businessTypeAdminForm' => function ($sm) {
                    $myForm = new \Admin\Form\BusinessType();
                    $myForm->setInputFilter(new \Admin\Form\BusinessTypeFilter());
                    return $myForm;
                },
                'userGroupAdminForm' => function ($sm) {
                    $myForm = new \Admin\Form\UserGroup();
                    $myForm->setInputFilter(new \Admin\Form\UserGroupFilter());
                    return $myForm;
                },
                'niceHouseCategoryAdminForm' => function ($sm) {
                    $myForm = new \Admin\Form\NiceHouseCategory();
                    $myForm->setInputFilter(new \Admin\Form\NiceHouseCategoryFilter());
                    return $myForm;
                },
                'fengshuiAppAdminForm' => function ($sm) {
                    $myForm = new \Admin\Form\FengshuiApp();
                    $myForm->setInputFilter(new \Admin\Form\FengshuiAppFilter());
                    return $myForm;
                },
                'websiteAdsAdminForm' => function ($sm) {
                    $myForm = new \Admin\Form\WebsiteAds();
                    $myForm->setInputFilter(new \Admin\Form\WebsiteAdsFilter());
                    return $myForm;
                },
                'logoAdminForm' => function ($sm) {
                    $myForm = new \Admin\Form\Logo();
                    $myForm->setInputFilter(new \Admin\Form\LogoFilter());
                    return $myForm;
                },
                'footerAdminForm' => function ($sm) {
                    $myForm = new \Admin\Form\Footer();
                    $myForm->setInputFilter(new \Admin\Form\FooterFilter());
                    return $myForm;
                },
                'navFooterAdminForm' => function ($sm) {
                    $myForm = new \Admin\Form\NavFooter();
                    $myForm->setInputFilter(new \Admin\Form\NavFooterFilter());
                    return $myForm;
                },
                'bannerAdminForm' => function ($sm) {
                    $myForm = new \Admin\Form\Banner();
                    $myForm->setInputFilter(new \Admin\Form\BannerFilter());
                    return $myForm;
                },
                'notificationtemplateAdminForm' => function ($sm) {
                    $myForm = new \Admin\Form\NotificationTemplate();
                    $myForm->setInputFilter(new \Admin\Form\NotificationTemplateFilter());
                    return $myForm;
                },
                'realEstateAdminForm' => function ($sm) {
                    $myForm = new \Admin\Form\RealEstate();
                    $myForm->setInputFilter(new \Admin\Form\RealEstateFilter());
                    return $myForm;
                },
                'serviceAdminForm' => function ($sm) {
                    $myForm = new \Admin\Form\Service();
                    $myForm->setInputFilter(new \Admin\Form\ServiceFilter());
                    return $myForm;
                },
                'seoAdminForm' => function ($sm) {
                    $myForm = new \Admin\Form\Seo();
                    $myForm->setInputFilter(new \Admin\Form\SeoFilter());
                    return $myForm;
                },
                'configWebsiteAdminForm' => function ($sm) {
                    $myForm = new \Admin\Form\ConfigWebsite();
                    $myForm->setInputFilter(new \Admin\Form\ConfigWebsiteFilter());
                    return $myForm;
                },
                'configCompanyAdminForm' => function ($sm) {
                    $myForm = new \Admin\Form\ConfigCompany();
                    $myForm->setInputFilter(new \Admin\Form\ConfigCompanyFilter());
                    return $myForm;
                },
                'configEmailAdminForm' => function ($sm) {
                    $myForm = new \Admin\Form\ConfigEmail();
                    $myForm->setInputFilter(new \Admin\Form\ConfigEmailFilter());
                    return $myForm;
                },
                'configAdvanceAdminForm' => function ($sm) {
                    $myForm = new \Admin\Form\ConfigAdvance();
                    $myForm->setInputFilter(new \Admin\Form\ConfigAdvanceFilter());
                    return $myForm;
                },
                'configDisplayAdminForm' => function ($sm) {
                    $myForm = new \Admin\Form\ConfigDisplay();
                    $myForm->setInputFilter(new \Admin\Form\ConfigDisplayFilter());
                    return $myForm;
                },
                'configMaintenanceAdminForm' => function ($sm) {
                    $myForm = new \Admin\Form\ConfigMaintenance();
                    $myForm->setInputFilter(new \Admin\Form\ConfigMaintenanceFilter());
                    return $myForm;
                },
                'supportAdminForm' => function ($sm) {
                    $myForm = new \Admin\Form\Support();
                    $myForm->setInputFilter(new \Admin\Form\SupportFilter());
                    return $myForm;
                },
                'emailTemplateAdminForm' => function ($sm) {
                    $myForm = new \Admin\Form\EmailTemplate();
                    $myForm->setInputFilter(new \Admin\Form\EmailTemplateFilter());
                    return $myForm;
                },
                'emailMarketingAdminForm' => function ($sm) {
                    $myForm = new \Admin\Form\EmailMarketing();
                    $myForm->setInputFilter(new \Admin\Form\EmailMarketingFilter());
                    return $myForm;
                },
                'adsAdminForm' => function ($sm) {
                    $myForm = new \Admin\Form\Ads();
                    $myForm->setInputFilter(new \Admin\Form\AdsFilter());
                    return $myForm;
                },
                'fileManagerAdminForm' => function ($sm) {
                    $myForm = new \Admin\Form\FileManager();
                    $myForm->setInputFilter(new \Admin\Form\FileManagerFilter());
                    return $myForm;
                },
                'surveyAdminForm' => function ($sm) {
                    $myForm = new \Admin\Form\Survey();
                    $myForm->setInputFilter(new \Admin\Form\SurveyFilter());
                    return $myForm;
                },
                'slideAdminForm' => function ($sm) {
                    $myForm = new \Admin\Form\Slide();
                    $myForm->setInputFilter(new \Admin\Form\SlideFilter());
                    return $myForm;
                },
                'messageAdminForm' => function ($sm) {
                    $myForm = new \Admin\Form\Message();
                    $myForm->setInputFilter(new \Admin\Form\MessageFilter());
                    return $myForm;
                },
                'sitesAdminForm' => function ($sm) {
                    $myForm = new \Admin\Form\sites();
                    $myForm->setInputFilter(new \Admin\Form\sitesFilter());
                    return $myForm;
                },
                'banAdminForm' => function ($sm) {
                    $myForm = new \Admin\Form\Ban();
                    $myForm->setInputFilter(new \Admin\Form\BanFilter());
                    return $myForm;
                },
                'notifiAdminForm' => function ($sm) {
                    $myForm = new \Admin\Form\Notifi();
                    $myForm->setInputFilter(new \Admin\Form\NotifiFilter());
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
                'UserTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\User());
                    return new TableGateway('users', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\UserTable' => function ($sm) {
                    $tableGateway = $sm->get('UserTableGateway');
                    return new \Admin\Model\UserTable($tableGateway);
                },

                'UserGroupTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\UserGroup());
                    return new TableGateway('user_group', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\UserGroupTable' => function ($sm) {
                    $tableGateway = $sm->get('UserGroupTableGateway');
                    return new \Admin\Model\UserGroupTable($tableGateway);
                },
                'BusinessTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\Business());
                    return new TableGateway('business', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\BusinessTable' => function ($sm) {
                    $tableGateway = $sm->get('BusinessTableGateway');
                    return new \Admin\Model\BusinessTable($tableGateway);
                },
                'NewsAdminTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\News());
                    return new TableGateway('news', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\NewsTable' => function ($sm) {
                    $tableGateway = $sm->get('NewsAdminTableGateway');
                    return new \Admin\Model\NewsTable($tableGateway);
                },
                'FengshuiNewsAdminTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\FengshuiNews());
                    return new TableGateway('fengshui_news', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\FengshuiNewsTable' => function ($sm) {
                    $tableGateway = $sm->get('FengshuiNewsAdminTableGateway');
                    return new \Admin\Model\FengshuiNewsTable($tableGateway);
                },
                'LegalHousingTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\LegalHousing());
                    return new TableGateway('legal_housing', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\LegalHousingTable' => function ($sm) {
                    $tableGateway = $sm->get('LegalHousingTableGateway');
                    return new \Admin\Model\LegalHousingTable($tableGateway);
                },
                'LegislationHousingTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\LegislationHousing());
                    return new TableGateway('legislation_housing', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\LegislationHousingTable' => function ($sm) {
                    $tableGateway = $sm->get('LegislationHousingTableGateway');
                    return new \Admin\Model\LegislationHousingTable($tableGateway);
                },
                'ContractFormAdminTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\ContractForm());
                    return new TableGateway('contract_forms', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\ContractFormTable' => function ($sm) {
                    $tableGateway = $sm->get('ContractFormAdminTableGateway');
                    return new \Admin\Model\ContractFormTable($tableGateway);
                },
                'NiceHouseAdminTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\NiceHouse());
                    return new TableGateway('nice_house', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\NiceHouseTable' => function ($sm) {
                    $tableGateway = $sm->get('NiceHouseAdminTableGateway');
                    return new \Admin\Model\NiceHouseTable($tableGateway);
                },
                'ProjectAdminTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\Project());
                    return new TableGateway('project', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\ProjectTable' => function ($sm) {
                    $tableGateway = $sm->get('ProjectAdminTableGateway');
                    return new \Admin\Model\ProjectTable($tableGateway);
                },
                'TvTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\Tv());
                    return new TableGateway('batdongsan_tv', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\TvTable' => function ($sm) {
                    $tableGateway = $sm->get('TvTableGateway');
                    return new \Admin\Model\TvTable($tableGateway);
                },
                'BusinessTypeTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\BusinessType());
                    return new TableGateway('type_business', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\BusinessTypeTable' => function ($sm) {
                    $tableGateway = $sm->get('BusinessTypeTableGateway');
                    return new \Admin\Model\BusinessTypeTable($tableGateway);
                },
                'UserGroupTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\UserGroup());
                    return new TableGateway('user_group', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\UserGroupTable' => function ($sm) {
                    $tableGateway = $sm->get('UserGroupTableGateway');
                    return new \Admin\Model\UserGroupTable($tableGateway);
                },
                'CategoryTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\Category());
                    return new TableGateway('category', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\CategoryTable' => function ($sm) {
                    $tableGateway = $sm->get('CategoryTableGateway');
                    return new \Admin\Model\CategoryTable($tableGateway);
                },
                'NestedTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\Nested());
                    return new TableGateway('category', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\NestedTable' => function ($sm) {
                    $tableGateway = $sm->get('NestedTableGateway');
                    return new \Admin\Model\NestedTable($tableGateway);
                },
                'FengshuiAppTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\FengshuiApp());
                    return new TableGateway('fengshui', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\FengshuiAppTable' => function ($sm) {
                    $tableGateway = $sm->get('FengshuiAppTableGateway');
                    return new \Admin\Model\FengshuiAppTable($tableGateway);
                },
                'EmailNewsletterTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\EmailNewsletter());
                    return new TableGateway('email_newsletter', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\EmailNewsletterTable' => function ($sm) {
                    $tableGateway = $sm->get('EmailNewsletterTableGateway');
                    return new \Admin\Model\EmailNewsletterTable($tableGateway);
                },
                'ContactTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\Contact());
                    return new TableGateway('contact', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\ContactTable' => function ($sm) {
                    $tableGateway = $sm->get('ContactTableGateway');
                    return new \Admin\Model\ContactTable($tableGateway);
                },
                'WebsiteAdsTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\WebsiteAds());
                    return new TableGateway('website_ads', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\WebsiteAdsTable' => function ($sm) {
                    $tableGateway = $sm->get('WebsiteAdsTableGateway');
                    return new \Admin\Model\WebsiteAdsTable($tableGateway);
                },
                'SkinTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\Skin());
                    return new TableGateway('skin', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\SkinTable' => function ($sm) {
                    $tableGateway = $sm->get('SkinTableGateway');
                    return new \Admin\Model\SkinTable($tableGateway);
                },
                'NavFooterTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\NavFooter());
                    return new TableGateway('nav_footer', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\NavFooterTable' => function ($sm) {
                    $tableGateway = $sm->get('NavFooterTableGateway');
                    return new \Admin\Model\NavFooterTable($tableGateway);
                },
                'NotificationTemplateTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\NotificationTemplate());
                    return new TableGateway('notificationtemplate', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\NotificationTemplateTable' => function ($sm) {
                    $tableGateway = $sm->get('NotificationTemplateTableGateway');
                    return new \Admin\Model\NotificationTemplateTable($tableGateway);
                },
                'RealEstateAdminTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\RealEstate());
                    return new TableGateway('real_estate', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\RealEstateTable' => function ($sm) {
                    $tableGateway = $sm->get('RealEstateAdminTableGateway');
                    return new \Admin\Model\RealEstateTable($tableGateway);
                },
                //MR.LOI
                'CityAdminTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Home\Model\Entity\City());
                    return new TableGateway('city', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\CityTable' => function ($sm) {
                    $tableGateway = $sm->get('CityAdminTableGateway');
                    return new \Admin\Model\CityTable($tableGateway);
                },
                //MR.LOI
                'DistrictAdminTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Home\Model\Entity\District());
                    return new TableGateway('city_district', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\DistrictTable' => function ($sm) {
                    $tableGateway = $sm->get('DistrictAdminTableGateway');
                    return new \Admin\Model\DistrictTable($tableGateway);
                },
                //MR.LOI
                'WardAdminTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Home\Model\Entity\Ward());
                    return new TableGateway('city_district_ward', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\WardTable' => function ($sm) {
                    $tableGateway = $sm->get('WardAdminTableGateway');
                    return new \Admin\Model\DistrictTable($tableGateway);
                },
                'ServiceAccountTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\Service());
                    return new TableGateway('service_account', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\ServiceTable' => function ($sm) {
                    $tableGateway = $sm->get('ServiceAccountTableGateway');
                    return new \Admin\Model\ServiceTable($tableGateway);
                },
                'ServiceRegisterAccountTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\ServiceRegister());
                    return new TableGateway('service_account_register', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\ServiceRegisterTable' => function ($sm) {
                    $tableGateway = $sm->get('ServiceRegisterAccountTableGateway');
                    return new \Admin\Model\ServiceRegisterTable($tableGateway);
                },
                'ConfigTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\Config());
                    return new TableGateway('config', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\ConfigTable' => function ($sm) {
                    $tableGateway = $sm->get('ConfigTableGateway');
                    return new \Admin\Model\ConfigTable($tableGateway);
                },
                'SupportTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\Support());
                    return new TableGateway('support', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\SupportTable' => function ($sm) {
                    $tableGateway = $sm->get('SupportTableGateway');
                    return new \Admin\Model\SupportTable($tableGateway);
                },
                'EmailTemplateTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\EmailTemplate());
                    return new TableGateway('email_marketing_template', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\EmailTemplateTable' => function ($sm) {
                    $tableGateway = $sm->get('EmailTemplateTableGateway');
                    return new \Admin\Model\EmailTemplateTable($tableGateway);
                },
                'EmailMarketingTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\EmailMarketing());
                    return new TableGateway('email_marketing', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\EmailMarketingTable' => function ($sm) {
                    $tableGateway = $sm->get('EmailMarketingTableGateway');
                    return new \Admin\Model\EmailMarketingTable($tableGateway);
                },
                'AdsAdminTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\Ads());
                    return new TableGateway('ads', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\AdsTable' => function ($sm) {
                    $tableGateway = $sm->get('AdsAdminTableGateway');
                    return new \Admin\Model\AdsTable($tableGateway);
                },
                'IndexAdminTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\Index());
                    return new TableGateway('nice_house', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\IndexTable' => function ($sm) {
                    $tableGateway = $sm->get('IndexAdminTableGateway');
                    return new \Admin\Model\IndexTable($tableGateway);
                },
                'FileManagerAdminTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\FileManager());
                    return new TableGateway('manager_folder', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\FileManagerTable' => function ($sm) {
                    $tableGateway = $sm->get('FileManagerAdminTableGateway');
                    return new \Admin\Model\FileManagerTable($tableGateway);
                },
                'GalleryAdminTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\Gallery());
                    return new TableGateway('gallery', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\GalleryTable' => function ($sm) {
                    $tableGateway = $sm->get('GalleryAdminTableGateway');
                    return new \Admin\Model\GalleryTable($tableGateway);
                },
                'SurveyAdminTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\Survey());
                    return new TableGateway('survey', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\SurveyTable' => function ($sm) {
                    $tableGateway = $sm->get('SurveyAdminTableGateway');
                    return new \Admin\Model\SurveyTable($tableGateway);
                },
                'SlideAdminTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\Slide());
                    return new TableGateway('slide', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\SlideTable' => function ($sm) {
                    $tableGateway = $sm->get('SlideAdminTableGateway');
                    return new \Admin\Model\SlideTable($tableGateway);
                },
                'MessageAdminTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\Message());
                    return new TableGateway('message_send', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\MessageTable' => function ($sm) {
                    $tableGateway = $sm->get('MessageAdminTableGateway');
                    return new \Admin\Model\MessageTable($tableGateway);
                },
                'ContactRealEstateAdminTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\ContactRealEstate());
                    return new TableGateway('contact_real_estate', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\ContactRealEstateTable' => function ($sm) {
                    $tableGateway = $sm->get('ContactRealEstateAdminTableGateway');
                    return new \Admin\Model\ContactRealEstateTable($tableGateway);
                },
                'ContactAgencyAdminTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\ContactAgency());
                    return new TableGateway('contact_agency', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\ContactAgencyTable' => function ($sm) {
                    $tableGateway = $sm->get('ContactAgencyAdminTableGateway');
                    return new \Admin\Model\ContactAgencyTable($tableGateway);
                },
                'ContactBusinessAdminTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\ContactBusiness());
                    return new TableGateway('contact_business', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\ContactBusinessTable' => function ($sm) {
                    $tableGateway = $sm->get('ContactBusinessAdminTableGateway');
                    return new \Admin\Model\ContactBusinessTable($tableGateway);
                },
                'CommentAdminTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\Comment());
                    return new TableGateway('comment', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\CommentTable' => function ($sm) {
                    $tableGateway = $sm->get('CommentAdminTableGateway');
                    return new \Admin\Model\CommentTable($tableGateway);
                },
                'SitesAdminTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\Sites());
                    return new TableGateway('city', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\SitesTable' => function ($sm) {
                    $tableGateway = $sm->get('SitesAdminTableGateway');
                    return new \Admin\Model\SitesTable($tableGateway);
                },
                'PermissionAdminTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\Permission());
                    return new TableGateway('user_group', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\PermissionTable' => function ($sm) {
                    $tableGateway = $sm->get('PermissionAdminTableGateway');
                    return new \Admin\Model\PermissionTable($tableGateway);
                },
                'NotifiAdminTableGateway' => function ($sm) {
                    $adapter = $sm->get('dbBatDongSan');
                    $resultSetProtype = new ResultSet();
                    $resultSetProtype->setArrayObjectPrototype(new \Admin\Model\Entity\Notifi());
                    return new TableGateway('notify', $adapter, null, $resultSetProtype);
                },
                'Admin\Model\NotifiTable' => function ($sm) {
                    $tableGateway = $sm->get('NotifiAdminTableGateway');
                    return new \Admin\Model\NotifiTable($tableGateway);
                },
            ),
        );
    }


}
