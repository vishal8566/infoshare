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
            'client' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/client[[/:action][/:param1]]',
                    'constraints' => [ 'action' => '[a-zA-Z][a-zA-Z0-9_-]*', 'param1' => '[a-zA-Z][a-zA-Z0-9_-]*'],
                ),
            ),
            'statistics' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/statistics[[/:action][/:param1]]',
                    'constraints' => [ 'action' => '[a-zA-Z][a-zA-Z0-9_-]*', 'param1' => '[a-zA-Z][a-zA-Z0-9_-]*'],
                ),
            ),
            'deal' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/deal[[/:action][/:param1]]',
                    'constraints' => [ 'action' => '[a-zA-Z][a-zA-Z0-9_-]*', 'param1' => '[a-zA-Z][a-zA-Z0-9_-]*'],
                ),
            ),
            'loanadmin' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/loanadmin[[/:action][/:param1]]',
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
            'Application\Controller\Loginfront' => 'Application\Controller\LoginfrontController',
            'Application\Controller\Client' => 'Application\Controller\ClientController',
            'Application\Controller\Statistics' => 'Application\Controller\StatisticsController',
            'Application\Controller\Deal' => 'Application\Controller\DealController',
            'Application\Controller\Loanadmin' => 'Application\Controller\LoanadminController',
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
