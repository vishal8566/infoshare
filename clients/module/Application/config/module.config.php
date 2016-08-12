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
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
            'search' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/search[[/:action][/:param1]]',
                    'constraints' => [ 'action' => '[a-zA-Z][a-zA-Z0-9_-]*', 'param1' => '[a-zA-Z][a-zA-Z0-9_-]*'],
                ),
            ),
            'map' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/map[[/:action][/:param1]]',
                    'constraints' => [ 'action' => '[a-zA-Z][a-zA-Z0-9_-]*', 'param1' => '[a-zA-Z][a-zA-Z0-9_-]*'],
                ),
            ),
            'loan' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/loan[[/:action][/:param1]]',
                    'constraints' => [ 'action' => '[a-zA-Z][a-zA-Z0-9_-]*', 'param1' => '[a-zA-Z][a-zA-Z0-9_-]*'],
                ),
            ),
            'main' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/main[[/:action][/:param1]]',
                    'constraints' => [ 'action' => '[a-zA-Z][a-zA-Z0-9_-]*', 'param1' => '[a-zA-Z][a-zA-Z0-9_-]*'],
                ),
            ),
            'search' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/search[[/:action][/:param1]]',
                    'constraints' => [ 'action' => '[a-zA-Z][a-zA-Z0-9_-]*', 'param1' => '[a-zA-Z][a-zA-Z0-9_-]*'],
                ),
            ),
            'support' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/support[[/:action][/:param1]]',
                    'constraints' => [ 'action' => '[a-zA-Z][a-zA-Z0-9_-]*', 'param1' => '[a-zA-Z][a-zA-Z0-9_-]*'],
                ),
            ),
            'report' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/report[[/:action][/:param1]]',
                    'constraints' => [ 'action' => '[a-zA-Z][a-zA-Z0-9_-]*', 'param1' => '[a-zA-Z][a-zA-Z0-9_-]*'],
                ),
            ),
            'history' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/history[[/:action][/:param1]]',
                    'constraints' => [ 'action' => '[a-zA-Z][a-zA-Z0-9_-]*', 'param1' => '[a-zA-Z][a-zA-Z0-9_-]*'],
                ),
            ),
            'discounting' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/discounting[[/:action][/:param1]]',
                    'constraints' => [ 'action' => '[a-zA-Z][a-zA-Z0-9_-]*', 'param1' => '[a-zA-Z][a-zA-Z0-9_-]*'],
                ),
            ),
            'user' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/user[[/:action][/:param1]]',
                    'constraints' => [ 'action' => '[a-zA-Z][a-zA-Z0-9_-]*', 'param1' => '[a-zA-Z][a-zA-Z0-9_-]*'],
                ),
            ),
            'loginfront' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/loginfront[[/:action][/:param1]]',
                    'constraints' => [ 'action' => '[a-zA-Z][a-zA-Z0-9_-]*', 'param1' => '[a-zA-Z][a-zA-Z0-9_-]*'],
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '[/:controller[/:action][/:param1]]',
                    'constraints' => [ 'controller' => '[a-zA-Z][a-zA-Z0-9_-]*', 'action' => '[a-zA-Z][a-zA-Z0-9_-]*', 'param1' => '[a-zA-Z][a-zA-Z0-9_-]*'],
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
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
    /* 'invokables' => array(
      'Application\Service\Cms' => 'Application\Service\Cms',
      ), */
    ),
    'translator' => array(
        'locale' => 'he_IL',
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController',
            'Application\Controller\Main' => 'Application\Controller\MainController',
            'Application\Controller\Loan' => 'Application\Controller\LoanController',
            'Application\Controller\Search' => 'Application\Controller\SearchController',
            'Application\Controller\Support' => 'Application\Controller\SupportController',
            'Application\Controller\Report' => 'Application\Controller\ReportController',
            'Application\Controller\History' => 'Application\Controller\HistoryController',
            'Application\Controller\Discounting' => 'Application\Controller\DiscountingController',
            'Application\Controller\User' => 'Application\Controller\UserController',
            'Application\Controller\Loginfront' => 'Application\Controller\LoginfrontController',
            'Application\Controller\Map' => 'Application\Controller\MapController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
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
);
