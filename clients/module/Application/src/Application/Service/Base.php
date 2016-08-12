<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Base
 *
 * @author CES-USER04
 */

namespace Application\Service;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Predicate\Predicate;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Session\Container;
use Zend\Cecs\Common;

class Base extends Common {

    //put your code here
    public $serviceLocator;
    public $_table;

    CONST LOGIN_SESSION_TIME = 60; //in minute
    CONST SESSION_CONTAINER = "AUDIT_FRONT"; //in minute

    public function __construct(Adapter $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
        $this->sql = new Sql($dbAdapter);
        parent::__construct($dbAdapter);
        parent::setSessionName(self::SESSION_CONTAINER);
        parent::setSessionTime(self::LOGIN_SESSION_TIME);
    }

    public function getSession() {
        return new Container(self::SESSION_CONTAINER);
    }

    public function checkUserLoggedIn() {
        $session = new Container(self::SESSION_CONTAINER);
        $loggedIn = true;
        if ($session->offsetExists('isLoggedIn')) {
            $isLoggedIn = $session->offsetGet('isLoggedIn');
            if ($isLoggedIn == false) {
                $loggedIn = false;
            } else {
                $session->offsetSet('loginTime', time());
            }
        } else {
            $loggedIn = false;
        }
        return $loggedIn;
    }

    public function getUser() {
        $session = new Container(self::SESSION_CONTAINER);
        $loggedInUser = $session->offsetGet('loginUser');
        return $loggedInUser;
    }

    public function setLoggedIn($userAuth) {
        $session = new Container(self::SESSION_CONTAINER);
        $session->offsetSet('isLoggedIn', true);
        $session->offsetSet('loginTime', time());
        $session->offsetSet('loginUser', $userAuth);
    }

    public function setLanguage($lang) {
        $session = new Container(self::SESSION_CONTAINER);
        $session->offsetSet('language', $lang);
    }
  public function getLang() {
        $session = new Container(self::SESSION_CONTAINER);
        $loggedInUser = $session->offsetGet('language');
        return $loggedInUser;
    }
	
	public function clearLoggedIn() {
        $session = new Container(self::SESSION_CONTAINER);
        $session->offsetSet('isLoggedIn', false);
        $session->offsetSet('loginTime', time());
        $session->offsetSet('loginUser', array());
    }

    public function setCookies($userAuth, $filesoucreConfig) {
        if (isset($userAuth['remember_me']) && $userAuth['remember_me'] == 'on') {
            setcookie('user_email', $userAuth['user_email'], time() + 3600, "/");
            setcookie('user_password', $userAuth['user_password'], time() + 3600, "/");
            setcookie('remember_me', $userAuth['remember_me'], time() + 3600, "/");
        }
    }

    public function resetCookies($userAuth, $filesoucreConfig) {
        setcookie('user_email', null, -1, "/");
        setcookie('user_password', null, -1, "/");
        setcookie('remember_me', null, -1, "/");
    }

    public function _getService($service) {
        return $this->getServiceLocator()->get('Application\Service\\' . ucfirst($service));
    }

}
