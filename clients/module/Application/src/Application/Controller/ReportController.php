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

class ReportController extends BaseController {

    public function onDispatch(\Zend\Mvc\MvcEvent $e) {
        parent::onDispatch($e);
		
	    $lang = $e->getApplication()->getServiceManager()->get('translator')->getLocale();
        $this->getServiceLocator()->get('Application\Service\Base')->setLanguage($lang);
    }

    public function indexAction() {
        setcookie('user_route', 'report', time() + 3600, "/");
        if ($this->getRequest()->getQuery()) {
            $post = $this->getRequest()->getQuery();
            $loginUser = $this->getServiceLocator()->get('Application\Service\Base')->getUser();
            $data = $this->getServiceLocator()->get('Application\Service\Loan')->getLoanUser($post);

            $loanData = $this->getServiceLocator()->get('Application\Service\Loan')->getLoanComment();
            $discountData = $this->getServiceLocator()->get('Application\Service\Loan')->getDiscountComment();
			$dealtype = $this->getServiceLocator()->get('Application\Service\Search')->dealType();

            return new ViewModel(array("candidateData" => "", "data" => $data, "loanData" => $loanData, "discountData" => $discountData ,'dealtype' => $dealtype));
        } else {
            $candidateData = $this->getServiceLocator()->get('Application\Service\Loan')->getCandidate();

            return new ViewModel(array("candidateData" => $candidateData, "data" => ""));
        }
    }

    public function reportpostAction() {
	
        if ($this->getRequest()->isPost()) {
		    $lang = $this->getServiceLocator()->get('Application\Service\Base')->getLang();
            $postData = $this->getRequest()->getPost()->toArray();
            $loginUser = $this->getServiceLocator()->get('Application\Service\Base')->getUser();
            $candiateData = $this->getServiceLocator()->get('Application\Service\Loan')->reportSave($postData, $loginUser);
			
			if($lang == 'he_IL'){
				 $this->flashMessenger()->addSuccessMessage(array('success' => 'דיווח נשמר בהצלחה'), array('alert', 'alert-success'));
				}else{
				 $this->flashMessenger()->addSuccessMessage(array('success' => 'Report has been saved successfully.'), array('alert', 'alert-success'));
				}
           
            return $this->redirect()->toRoute("report");
        }
    }

}
