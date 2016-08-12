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

class IndexController extends BaseController {

    public function onDispatch(\Zend\Mvc\MvcEvent $e) {
        parent::onDispatch($e);
    }

    public function indexAction() {
        $loginUser = $this->getServiceLocator()->get('Application\Service\Base')->getUser();
        if (isset($loginUser['user_id']) > 0) {
            $cookie_array = $_COOKIE;
            $route = isset($cookie_array['user_route']) ? $cookie_array['user_route'] : "";
            if ($route == "") {
                return $this->redirect()->toRoute("main");
            } else {
                return $this->redirect()->toRoute($route);
            }
        } else {
            return $this->redirect()->toRoute('loginfront');
        }
    }

}
