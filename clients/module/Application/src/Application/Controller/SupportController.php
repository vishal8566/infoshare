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

class SupportController extends BaseController {

    public function onDispatch(\Zend\Mvc\MvcEvent $e) {
        parent::onDispatch($e);

        $lang = $e->getApplication()->getServiceManager()->get('translator')->getLocale();
        $this->getServiceLocator()->get('Application\Service\Base')->setLanguage($lang);
    }

    public function indexAction() {
        setcookie('user_route', 'support', time() + 3600, "/");
        $cookie_array['user_route'] = $this->getRequest()->getCookie();
        $route = $cookie_array['user_route']->user_route;

        $loginUser = $this->getServiceLocator()->get('Application\Service\Base')->getUser();
        return new ViewModel();
    }

    public function sendAction() {
        if ($this->getRequest()->isPost()) {
            $lang = $this->getServiceLocator()->get('Application\Service\Base')->getLang();
            $postData = $this->getRequest()->getPost()->toArray();
            $loginUser = $this->getServiceLocator()->get('Application\Service\Base')->getUser();
           // print_r($postData);
			//print_r($loginUser); die;
			$common = $this->getServiceLocator()->get('Application\Service\Common');
            $templateData = file_get_contents("public/mail.template.conf");
            $templateData = str_replace("{MAIL_TITLE}", "Test Data", $templateData);
            $message = $postData['message'];
            $templateData = str_replace("{MESSAGE}", nl2br($message), $templateData);
            $common->sendMail(array(
                "from" => $loginUser['user_email'],
                "fromname" => $loginUser['user_fullname'],
                "to" => "developer.loyallead@gmail.com",  // Receiver Email Address
                "cc" => $loginUser['user_email'],
                "user_id" => "",
                "subject" => $postData['subject'],
                "template" => $templateData
                    )
            );

            if ($lang == 'he_IL') {
                $this->flashMessenger()->addSuccessMessage(array('success' => 'ההודעה נשלחה בהצלחה'), array('alert', 'alert-success'));
            } else {
                $this->flashMessenger()->addSuccessMessage(array('success' => 'Message has been send successfully.'), array('alert', 'alert-success'));
            }

            return $this->redirect()->toRoute("support");
        }
    }

}
