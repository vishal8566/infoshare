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
        $loginUser = $this->getServiceLocator()->get('Application\Service\Base')->getApplicationUser();
        if (isset($loginUser['admin_id']) > 0) {
            $clientData = $this->getServiceLocator()->get('Application\Service\Client')->getCandidate();
            return new ViewModel(array("clientData" => $clientData));
        } else {
            return $this->redirect()->toRoute('loginfront');
        }
    }

}
