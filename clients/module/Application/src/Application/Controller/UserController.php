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

class UserController extends BaseController {

    public function onDispatch(\Zend\Mvc\MvcEvent $e) {
        parent::onDispatch($e);
		
	   $lang = $e->getApplication()->getServiceManager()->get('translator')->getLocale();
       $this->getServiceLocator()->get('Application\Service\Base')->setLanguage($lang);
    }

    public function indexAction() {
        return new ViewModel();
    }

    public function userpostAction() {
        if ($this->getRequest()->isPost()) {
		    $lang = $this->getServiceLocator()->get('Application\Service\Base')->getLang();
            $postData = $this->getRequest()->getPost()->toArray();
            $loginUser = $this->getServiceLocator()->get('Application\Service\Base')->getUser();
            $candiateData = $this->getServiceLocator()->get('Application\Service\Loan')->userSave($postData, $loginUser);
            if ($candiateData["msg"] == 0) {
			   
			    if($lang == 'he_IL'){
				$this->flashMessenger()->addErrorMessage(array('error' => 'כתובת האימייל כבר קיימת במערכת'), array('alert', 'alert-danger'));
				}else{
				$this->flashMessenger()->addErrorMessage(array('error' => 'Email already exists in system.'), array('alert', 'alert-danger'));
				}
			
                
                return $this->redirect()->toRoute("user");
            } else {
			  
			     if($lang == 'he_IL'){
				 $this->flashMessenger()->addSuccessMessage(array('success' => 'משתמש חדש נוצר'), array('alert', 'alert-success'));
				}else{
				 $this->flashMessenger()->addSuccessMessage(array('success' => 'New User has been saved successfully.'), array('alert', 'alert-success'));
				}
                return $this->redirect()->toRoute("user");
            }
        }
    }

    public function userDeleteAction() {
        return new ViewModel();
    }

    public function deletepostAction() {
        if ($this->getRequest()->isPost()) {
		    $lang = $this->getServiceLocator()->get('Application\Service\Base')->getLang();
            $postData = $this->getRequest()->getPost()->toArray();
            $loginUser = $this->getServiceLocator()->get('Application\Service\Base')->getUser();
            $candiateData = $this->getServiceLocator()->get('Application\Service\Loan')->userDelete($postData);
            if ($candiateData["msg"] == 0) {
			    
				 if($lang =='he_IL'){
				$this->flashMessenger()->addErrorMessage(array('error' => 'כתובת האימייל אינה קיימת במערכת'), array('alert', 'alert-danger'));
				}else{
				$this->flashMessenger()->addErrorMessage(array('error' => 'Email not exists in system.'), array('alert', 'alert-danger'));
				}				
                
                return $this->redirect()->toRoute('user', array('action' => 'userDelete'));
            } else {
			     
				  if($lang == 'he_IL'){
				 $this->flashMessenger()->addSuccessMessage(array('success' => 'המשתמש נמחק בהצלחה'), array('alert', 'alert-success'));
				}else{
				 $this->flashMessenger()->addSuccessMessage(array('success' => 'User has been deleted successfully.'), array('alert', 'alert-success'));
				}			
               
                return $this->redirect()->toRoute('user', array('action' => 'userDelete'));
            }
        }
    }

}
