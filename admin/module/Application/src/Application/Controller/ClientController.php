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

class ClientController extends BaseController {

    public function onDispatch(\Zend\Mvc\MvcEvent $e) {
        parent::onDispatch($e);

        $lang = $e->getApplication()->getServiceManager()->get('translator')->getLocale();

        $this->getServiceLocator()->get('Application\Service\Base')->setLanguage($lang);
    }

    public function indexAction() {
        $id = $this->getRequest()->getQuery();
        $data = array();
        if (isset($id['id']) && !empty($id['id'])) {
            $data = $this->getServiceLocator()->get('Application\Service\Client')->getById($id['id']);
        }
        //print_r($data); die;
        return new ViewModel(array('client' => $data));
    }

    public function updateAction() {
        if ($this->getRequest()->isPost()) {
            $lang = $this->getServiceLocator()->get('Application\Service\Base')->getLang();
            $post = $_POST;

            $get_record = $this->getServiceLocator()->get('Application\Service\Client')->checkEmail($post);

            if ($get_record) {
                if ($lang == 'en_US') {
                    $this->flashMessenger()->addErrorMessage(array('error' => 'Email already exists in system.'), array('alert', 'alert-danger'));
                } else {
                    $this->flashMessenger()->addErrorMessage(array('error' => 'כתובת האימייל כבר קיימת במערכת'), array('alert', 'alert-danger'));
                }

                return $this->redirect()->toRoute('application');
            } else {

                $data = $this->getServiceLocator()->get('Application\Service\Client')->saveClient($post);

                if ($data) {

                    if ($lang == 'en_US') {
                        $this->flashMessenger()->addSuccessMessage(array('success' => 'Client saved successfully.'), array('alert', 'alert-success'));
                    } else {
                        $this->flashMessenger()->addSuccessMessage(array('success' => 'הלקוח נשמר בהצלחה'), array('alert', 'alert-success'));
                    }

                    return $this->redirect()->toRoute('application');
                } else {
                    // Redirect to list of cms

                    if ($lang == 'en_US') {
                        $this->flashMessenger()->addErrorMessage(array('error' => 'please try after some time.'), array('alert', 'alert-danger'));
                    } else {
                        $this->flashMessenger()->addErrorMessage(array('error' => 'אנא נסה שוב במועד אחר'), array('alert', 'alert-danger'));
                    }
                    return $this->redirect()->toRoute('application');
                }
            }
        }
    }

}
