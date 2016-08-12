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
use Zend\Feed\Reader\Reader;

class LoanController extends BaseController {

    public function onDispatch(\Zend\Mvc\MvcEvent $e) {
        parent::onDispatch($e);

        $lang = $e->getApplication()->getServiceManager()->get('translator')->getLocale();
        $this->getServiceLocator()->get('Application\Service\Base')->setLanguage($lang);
    }

    public function indexAction() {
        setcookie('user_route', 'loan', time() + 3600, "/");

        if ($this->getRequest()->getQuery()) {
            $post = $this->getRequest()->getQuery();
            $loginUser = $this->getServiceLocator()->get('Application\Service\Base')->getUser();
            $data = $this->getServiceLocator()->get('Application\Service\Loan')->getLoanUser($post);
            return new ViewModel(array("candidateData" => "", "data" => $data));
        } else {
            $candidateData = $this->getServiceLocator()->get('Application\Service\Loan')->getCandidate();
            return new ViewModel(array("candidateData" => $candidateData, "data" => ""));
        }
    }

    public function loanpostAction() {

        if ($this->getRequest()->isPost()) {
            $lang = $this->getServiceLocator()->get('Application\Service\Base')->getLang();
            $postData = $this->getRequest()->getPost()->toArray();
            $loginUser = $this->getServiceLocator()->get('Application\Service\Base')->getUser();
            $candiateData = $this->getServiceLocator()->get('Application\Service\Loan')->loanSave($postData, $loginUser);

            if ($lang == 'he_IL') {
                $this->flashMessenger()->addSuccessMessage(array('success' => 'ההלוואה נשמרה בהצלחה'), array('alert', 'alert-success'));
            } else {
                $this->flashMessenger()->addSuccessMessage(array('success' => 'New Loan has been submitted successfully for approval.'), array('alert', 'alert-success'));
            }
            return $this->redirect()->toRoute("loan");
        }
    }

    public function getNameAction() {
        if ($this->getRequest()->isPost()) {
            $postData = $this->getRequest()->getPost()->toArray();
            $candiateData = $this->getServiceLocator()->get('Application\Service\Loan')->getCandidateName($postData['candidate_id_LLC']);
            return $this->getResponse()->setContent(Json::encode(array('message' => $candiateData['message'], "name" => $candiateData['name'])));
        }
    }

}
