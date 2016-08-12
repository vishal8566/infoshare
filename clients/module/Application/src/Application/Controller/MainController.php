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

class MainController extends BaseController {

    public function onDispatch(\Zend\Mvc\MvcEvent $e) {
        parent::onDispatch($e);
    }

    public function indexAction() {
        setcookie('user_route', 'main', time() + 3600, "/");

        $feed = new Reader();

        /////////////////////////////////////// RSS FEED 1 /////////////////////////////////////////////////////

        $feedData = $feed->import('http://www.globes.co.il/webservice/rss/rssfeeder.asmx/FeederNode?iID=821');
        // echo "<pre>"; print_r($feedData); die;
        $data = array(
            'title' => $feedData->getTitle(),
            'link' => $feedData->getLink(),
            'description' => $feedData->getDescription(),
            'language' => $feedData->getLanguage(),
            'entries' => array(),
        );

        foreach ($feedData as $entry) {
            $edata = array(
                'title' => $entry->getTitle(),
                'description' => $entry->getDescription(),
                'dateModified' => $entry->getDateModified(),
                'authors' => $entry->getAuthors(),
                'link' => $entry->getLink(),
                'content' => $entry->getContent()
            );
            $data['entries'][] = $edata;
        }

        /////////////////////////////////////// RSS FEED 2 /////////////////////////////////////////////////////

        $feedData1 = $feed->import('http://www.globes.co.il/webservice/rss/rssfeeder.asmx/FeederNode?iID=829');
        // echo "<pre>"; print_r($feedData); die;
        $data1 = array(
            'title' => $feedData1->getTitle(),
            'link' => $feedData1->getLink(),
            'description' => $feedData1->getDescription(),
            'language' => $feedData1->getLanguage(),
            'entries' => array(),
        );

        foreach ($feedData1 as $entry) {
            $edata = array(
                'title' => $entry->getTitle(),
                'description' => $entry->getDescription(),
                'dateModified' => $entry->getDateModified(),
                'authors' => $entry->getAuthors(),
                'link' => $entry->getLink(),
                'content' => $entry->getContent()
            );
            $data1['entries'][] = $edata;
        }
        
        /////////////////////////////////////// RSS FEED 3 /////////////////////////////////////////////////////

        $feedData2 = $feed->import('http://www.globes.co.il/webservice/rss/rssfeeder.asmx/FeederNode?iID=1225');
        // echo "<pre>"; print_r($feedData); die;
        $data2 = array(
            'title' => $feedData2->getTitle(),
            'link' => $feedData2->getLink(),
            'description' => $feedData2->getDescription(),
            'language' => $feedData2->getLanguage(),
            'entries' => array(),
        );

        foreach ($feedData2 as $entry) {
            $edata = array(
                'title' => $entry->getTitle(),
                'description' => $entry->getDescription(),
                'dateModified' => $entry->getDateModified(),
                'authors' => $entry->getAuthors(),
                'link' => $entry->getLink(),
                'content' => $entry->getContent()
            );
            $data2['entries'][] = $edata;
        }
        $loginUser = $this->getServiceLocator()->get('Application\Service\Base')->getUser();
        return new ViewModel(array("rssData1" => $data, "rssData2" => $data1, "rssData3" => $data2, 'userData' => $loginUser));
    }

}
