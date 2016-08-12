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

class LoginfrontController extends AbstractActionController {

    public function onDispatch(\Zend\Mvc\MvcEvent $e) {
        parent::onDispatch($e);
        $lang = $e->getApplication()->getServiceManager()->get('translator')->getLocale();
        $this->getServiceLocator()->get('Application\Service\Base')->setLanguage($lang);
    }

    public function indexAction() {
        $this->layout('layout/login');
        return new ViewModel();
    }

    public function loginpostAction() {
        if ($this->getRequest()->isPost()) {
            $postData = $this->getRequest()->getPost()->toArray();
            $userAuth = $this->getServiceLocator()->get('Application\Service\Frontuser')->getUserFromEmailPassword($postData);

            $userAuth['remember_me'] = isset($postData['remember_me']) ? $postData['remember_me'] : "no";
            if (count($userAuth) > 0 && isset($userAuth['admin_id']) && $userAuth['admin_id'] > 0) {
                $this->getServiceLocator()->get('Application\Service\Base')->setApplicationLoggedIn($userAuth);
                if (isset($userAuth['remember_me']) && $userAuth['remember_me'] == 'on') {
                    $cookies = $this->getServiceLocator()->get('Application\Service\Base')->setCookies($userAuth, " ");
                } else {
                    $cookies = $this->getServiceLocator()->get('Application\Service\Base')->resetCookies($userAuth, " ");
                }
                return $this->redirect()->toRoute('application');
            } else {
                return $this->redirect()->toRoute('loginfront');
            }
        } else {
            return $this->redirect()->toRoute('loginfront');
        }
    }

    public function logoutAction() {
        if ($this->getRequest()->isPost()) {
            $this->getServiceLocator()->get('Application\Service\Base')->clearApplicationLoggedIn();
        } else {
            $this->getServiceLocator()->get('Application\Service\Base')->clearApplicationLoggedIn();
        }
        return $this->redirect()->toRoute('loginfront');
    }

}
