<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */



return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/admin',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            
            

            'MVC_AdminRouter' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/admin',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[/:controller[/:action]][/]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                    'action' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[/:controller[/:action[/:id[/:status]]]][/]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'         => '[0-9,]*',
                                'status'     => '[0-9]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                    
                    'filter' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[/:controller[/:action[/:type[/:col[/:by[/:key]]]]]][/]',
                            'constraints' => array(
                                'controller'    => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'        => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'type'          => '[a-zA-Z-]*',
                                'col'           => '[a-zA-Z-]*',
                                'by'            => '[a-zA-Z-]*',
                                'key'           => '[0-9]*',
                                
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                    'pagination' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[/:controller[/:action]]/page[/:page][/]',
                            'constraints' => array(
                                'controller'    => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'        => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'page'          => '[0-9]*', 
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                    'paginationTwo' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[/:controller[/:action[/:id]]]/page[/:page][/]',
                            'constraints' => array(
                                'controller'    => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'        => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'            => '[0-9]*', 
                                'page'          => '[0-9]*', 
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                    'multiStatus' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[/:controller[/:action[/:id[/:type]]]][/]',
                            'constraints' => array(
                                'controller'    => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'        => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'            => '[0-9,]*',
                                'type'          => '[a-zA-Z-]*',

                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                    
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Index'        => 'Admin\Controller\IndexController',
            'Admin\Controller\User'         => 'Admin\Controller\UserController',
            'Admin\Controller\Business'     => 'Admin\Controller\BusinessController',
            'Admin\Controller\News'         => 'Admin\Controller\NewsController',
            'Admin\Controller\Fengshuinews' => 'Admin\Controller\FengshuinewsController',
            'Admin\Controller\Legalhousing' => 'Admin\Controller\LegalhousingController',
            'Admin\Controller\Legislationhousing'  => 'Admin\Controller\LegislationhousingController',
            'Admin\Controller\Contractform' => 'Admin\Controller\ContractformController',
            'Admin\Controller\Nicehouse'    => 'Admin\Controller\NicehouseController',
            'Admin\Controller\Project'      => 'Admin\Controller\ProjectController',
            'Admin\Controller\Tv'           => 'Admin\Controller\TvController',
            'Admin\Controller\BusinessType' => 'Admin\Controller\BusinessTypeController',
            'Admin\Controller\UserGroup' => 'Admin\Controller\UserGroupController',
            'Admin\Controller\NicehouseCategory' => 'Admin\Controller\NicehouseCategoryController',
            'Admin\Controller\NewsCategory' => 'Admin\Controller\NewsCategoryController',
            'Admin\Controller\FengshuiCategory' => 'Admin\Controller\FengshuiCategoryController',
            'Admin\Controller\LegalhousingCategory' => 'Admin\Controller\LegalhousingCategoryController',
            'Admin\Controller\LegislationhousingCategory' => 'Admin\Controller\LegislationhousingCategoryController',
            'Admin\Controller\ContractformCategory' => 'Admin\Controller\ContractformCategoryController',
            'Admin\Controller\ProjectCategory' => 'Admin\Controller\ProjectCategoryController',
            'Admin\Controller\Fengshuiapp' => 'Admin\Controller\FengshuiappController',
            'Admin\Controller\EmailNewsletter' => 'Admin\Controller\EmailNewsletterController',
            'Admin\Controller\Contact' => 'Admin\Controller\ContactController',
            'Admin\Controller\WebsiteAds' => 'Admin\Controller\WebsiteAdsController',
            'Admin\Controller\Skin' => 'Admin\Controller\SkinController',
            'Admin\Controller\NavFooter' => 'Admin\Controller\NavFooterController',
            'Admin\Controller\Notificationtemplate' => 'Admin\Controller\NotificationtemplateController',
            'Admin\Controller\Realestate' => 'Admin\Controller\RealestateController',
            'Admin\Controller\RealestateCategory' => 'Admin\Controller\RealestateCategoryController',
            'Admin\Controller\Service' => 'Admin\Controller\ServiceController',
            'Admin\Controller\ServiceRegister' => 'Admin\Controller\ServiceRegisterController',
            'Admin\Controller\Seo' => 'Admin\Controller\SeoController',
            'Admin\Controller\Config' => 'Admin\Controller\ConfigController',
            'Admin\Controller\Support' => 'Admin\Controller\SupportController',
            'Admin\Controller\Emailtemplate' => 'Admin\Controller\EmailtemplateController',
            'Admin\Controller\Emailmarketing' => 'Admin\Controller\EmailmarketingController',
            'Admin\Controller\Ads' => 'Admin\Controller\AdsController',
            'Admin\Controller\Filemanager' => 'Admin\Controller\FilemanagerController',
            'Admin\Controller\Gallery' => 'Admin\Controller\GalleryController',
            'Admin\Controller\Survey' => 'Admin\Controller\SurveyController',
            'Admin\Controller\Slide' => 'Admin\Controller\SlideController',
            'Admin\Controller\Message' => 'Admin\Controller\MessageController',
            'Admin\Controller\ContactRealestate' => 'Admin\Controller\ContactRealestateController',
            'Admin\Controller\ContactAgency' => 'Admin\Controller\ContactAgencyController',
            'Admin\Controller\ContactBusiness' => 'Admin\Controller\ContactBusinessController',
            'Admin\Controller\Comment' => 'Admin\Controller\CommentController',
            'Admin\Controller\Sites' => 'Admin\Controller\SitesController',
            'Admin\Controller\Permission' => 'Admin\Controller\PermissionController',
            'Admin\Controller\Notifi' => 'Admin\Controller\NotifiController',
        ),
    ),
    'view_manager' => array(   
        'display_not_found_reason' => false,
        'display_exceptions'       => false,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',    
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'layout/admin'        => TEMPLATE_PATH . '/admin/index.phtml',
            'layout/list'        => TEMPLATE_PATH . '/admin/list.phtml',
            //'error/404'               => TEMPLATE_PATH . '/default/404.phtml',
            //'error/index'             => __DIR__ . '/../view/error/index.phtml',
            
        ),
         'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
         
    ),
    
    
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
    'view_helpers'    => array(
        'invokables'  => array(
            'cmsIconButton'     => '\ZendVN\View\Helper\CmsIconButton',
            'cmsButton'         => '\ZendVN\View\Helper\CmsButton',
            'cmsLinkSort'       => '\ZendVN\View\Helper\CmsLinkSort',
            'cmsSelect'         => '\ZendVN\View\Helper\CmsSelect',
            'cmsInput'          => '\ZendVN\View\Helper\CmsInput',
            'cmsBreadcrumb'     => '\ZendVN\View\Helper\CmsBreadcrumb',
            'cmsReplaceString'  => '\ZendVN\View\Helper\CmsReplaceString', 
            'elementError'      => '\ZendVN\View\Helper\ElementError',
            'elementErrors'     => '\ZendVN\View\Helper\ElementErrors',
            'errorMessages'     => '\ZendVN\View\Helper\ErrorMessages',
            'cmsSelectPermission'     => '\ZendVN\View\Helper\CmsSelectPermission',
        ),
    ),
    /*'view_helper_config' => array(
        'flashmessenger' => array(
            'message_open_format'      => '<div class="success message"><h4>',
            'message_close_string'     => '</h4></div>',
            'message_separator_string' => '</h4><h4>'
        ),
    ),*/
);
