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
use Zend\Mvc\Controller\Plugin\FlashMessenger;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Session\Container;
use Zend\Json\Json;

class HistoryController extends BaseController {

    public function onDispatch(\Zend\Mvc\MvcEvent $e) {
        parent::onDispatch($e);
    }

    public function indexAction() {
         setcookie('user_route', 'history', time() + 3600, "/");
        if ($this->getRequest()->getQuery()) {
            $post = $this->getRequest()->getQuery();
            $loginUser = $this->getServiceLocator()->get('Application\Service\Base')->getUser();
            $getSearchData = $this->getServiceLocator()->get('Application\Service\Search')->historyData($post,$loginUser);			
			$dealtype = $this->getServiceLocator()->get('Application\Service\Search')->dealType();
			
			
            return new ViewModel(array("searchData" => $getSearchData,'dealtype' => $dealtype));
			
			
        }
    }

}
