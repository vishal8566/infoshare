<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\SessionManager;
use Zend\Session\Config\SessionConfig;
use Zend\Session\Container;

class Module {

    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $local = explode(",", $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        $local = str_replace("-", "_", $local[0]);
        //echo $local; die;
        //echo $e->getApplication()->getServiceManager()->get('translator')->getLocale(); die;
        $e->getApplication()->getServiceManager()->get('translator')->setLocale("he_IL");
       // $e->getApplication()->getServiceManager()->get('translator')->setLocale("en_US");
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'Application\Service\Base' => function($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $table = new \Application\Service\Base($dbAdapter);
            return $table;
        },
                'Application\Service\Frontuser' => function($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $table = new \Application\Service\Frontuser($dbAdapter);
            return $table;
        },
                'Application\Service\Client' => function($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $table = new \Application\Service\Client($dbAdapter);
            return $table;
        },
                'Application\Service\Loanadmin' => function($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $table = new \Application\Service\Loanadmin($dbAdapter);
            return $table;
        },
                'Application\Service\Common' => function($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $table = new \Application\Service\Common($dbAdapter);
            return $table;
        },
            )
        );
    }

}
