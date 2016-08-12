<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;

class BaseController extends AbstractActionController {

    CONST LOGIN_SESSION_TIME = 60; //in minute
    CONST SESSION_CONTAINER = "AUDIT_FRONT"; //in minute

    public function onDispatch(\Zend\Mvc\MvcEvent $e) {
        $controller = explode("\\", $this->params('controller'));
        $controllerName = array_pop($controller);
        $userData = $this->getServiceLocator()->get('Application\Service\Base')->getApplicationUser();
        $this->layout()->setVariable('loggedInApplicationUser', $userData);
        $this->layout()->setVariable('controllerName', strtolower($controllerName));
        $loggedIn = $this->getServiceLocator()->get('Application\Service\Base')->checkApplicationUserLoggedIn();
        if ($loggedIn == false) {
            return $this->redirect()->toRoute('loginfront');
        }
        parent::onDispatch($e);
    }

    public function getBaseUrl() {
        $basePath = $this->getRequest()->getBasePath();
        $uri = new \Zend\Uri\Uri($this->getRequest()->getUri());
        $uri->setPath($basePath);
        $uri->setQuery(array());
        $uri->setFragment('');
        $baseUrl = $uri->getScheme() . '://' . $uri->getHost() . '/' . $uri->getPath();
        return $baseUrl;
    }

    public function _getService($service) {
        return $this->getServiceLocator()->get('Application\Service\\' . $service);
    }

}
