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
                    'route'    => '/user',
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
            
            

            'MVC_UserRouter' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/user',
                    'defaults' => array(
                        '__NAMESPACE__' => 'User\Controller',
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
            'User\Controller\Index'         => 'User\Controller\IndexController',
            'User\Controller\RealEstate'    => 'User\Controller\RealEstateController',
            'User\Controller\Account'       => 'User\Controller\AccountController',
            'User\Controller\Business'      => 'User\Controller\BusinessController',
            'User\Controller\Statistic'     => 'User\Controller\StatisticController',
            'User\Controller\RegisterEmail' => 'User\Controller\RegisterEmailController',
            'User\Controller\Service'       => 'User\Controller\ServiceController',
            'User\Controller\Message'       => 'User\Controller\MessageController',
            'User\Controller\Contact'       => 'User\Controller\ContactController',
            'User\Controller\ContactRealestate'       => 'User\Controller\ContactRealestateController',
            'User\Controller\ContactAgency'       => 'User\Controller\ContactAgencyController',
            'User\Controller\ContactBusiness'       => 'User\Controller\ContactBusinessController',
            'User\Controller\Comment'       => 'User\Controller\CommentController',
        ),
    ),
    'view_manager' => array(   
        'display_not_found_reason' => false,
        'display_exceptions'       => false,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',    
        'template_map' => array(
            'layout/layout'             => __DIR__ . '/../view/layout/layout.phtml',
            'layout/user'               => TEMPLATE_PATH . '/user/index.phtml',
            //'error/404'                 => __DIR__ . '/../view/error/404.phtml',
            //'error/index'               => __DIR__ . '/../view/error/index.phtml',
            'user/block/menuLeft'            => __DIR__ . '/../view/block/menu-left.phtml',
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
            'cmsReplaceString'  => '\ZendVN\View\Helper\CmsReplaceString', 
            'elementError'      => '\ZendVN\View\Helper\ElementError',
            'elementErrors'     => '\ZendVN\View\Helper\ElementErrors',
            'elementErrorsModuleUser'   =>  '\ZendVN\View\Helper\ElementErrorsModuleUser',
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
