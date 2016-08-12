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
        $my_cookie_array = array();
        $my_cookie_array['user_data'] = $this->getRequest()->getCookie();
        return new ViewModel(array('my_cookie_array' => $my_cookie_array));
    }

    public function loginpostAction() {

        if ($this->getRequest()->isPost()) {
			$lang = $this->getServiceLocator()->get('Application\Service\Base')->getLang();
			
            $postData = $this->getRequest()->getPost()->toArray();

            $userAuth = $this->getServiceLocator()->get('Application\Service\Frontuser')->getUserFromEmailPassword($postData);
            $userAuth['remember_me'] = isset($postData['remember_me']) ? $postData['remember_me'] : "no";
            if (count($userAuth) > 0 && isset($userAuth['user_id']) && $userAuth['user_id'] > 0) {
			
			       if($userAuth['status']=='1'){
				   $this->getServiceLocator()->get('Application\Service\Base')->setLoggedIn($userAuth);

                if (isset($userAuth['remember_me']) && $userAuth['remember_me'] == 'on') {
                    $cookies = $this->getServiceLocator()->get('Application\Service\Base')->setCookies($userAuth, " ");
                } else {
                    $cookies = $this->getServiceLocator()->get('Application\Service\Base')->resetCookies($userAuth, " ");
                }
                return $this->redirect()->toRoute("search");
				
				}else{
				if($lang == 'en_US'){
				$this->flashMessenger()->addErrorMessage(array('error' => 'Inactive user by admin.'), array('alert', 'alert-danger'));				
				}else{
				$this->flashMessenger()->addErrorMessage(array('error' => 'משתמש לא פעיל על ידי admin.'), array('alert', 'alert-danger'));
				} 
				
                return $this->redirect()->toRoute('loginfront');
				
				}  
            } else {
			     
			 if($lang == 'en_US'){				
				$this->flashMessenger()->addErrorMessage(array('error' => 'User email / Password is not valid.'), array('alert', 'alert-danger'));
				}else{
				$this->flashMessenger()->addErrorMessage(array('error' => 'שם משתמש או סיסמא אינו מתאים'), array('alert', 'alert-danger'));				
				}
				
                return $this->redirect()->toRoute('loginfront');
            }
        } else {
            return $this->redirect()->toRoute('loginfront');
        }
    }

    public function logoutAction() {
        if ($this->getRequest()->isPost()) {
            $this->getServiceLocator()->get('Application\Service\Base')->clearLoggedIn();
        } else {
            $this->getServiceLocator()->get('Application\Service\Base')->clearLoggedIn();
        }
        return $this->redirect()->toRoute('loginfront');
    }

}
