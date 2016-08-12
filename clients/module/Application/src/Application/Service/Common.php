<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/** 
 * Description of Common
 *
 * @author CES-USER04
 */ 

namespace Application\Service;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Predicate\Predicate;
use Zend\Mail\Message;
use Zend\Mail;
use Zend\Mail\Transport\Sendmail as SendmailTransport;
use Zend\Mime\Part as MimePart;
use Zend\Mime\Message as MimeMessage;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
class Common extends Base {

    //put your code here

    CONST TEMPLATE_VARIABLES_URL = "{URL}";
    CONST TEMPLATE_VARIABLES_LOGO = "{LOGO}";
    CONST TEMPLATE_VARIABLES_FIRSTNAME = "{FIRSTNAME}";
    CONST TEMPLATE_VARIABLES_LASTNAME = "{LASTNAME}";
    CONST TEMPLATE_VARIABLES_EMAIL = "{EMAIL}";
    CONST TEMPLATE_VARIABLES_SUBJECT = "{SUBJECT}";
    CONST TEMPLATE_VARIABLES_MESSAGE = "{MESSAGE}";

    public function getTemplateVariable() {
        return array("Logo" => self::TEMPLATE_VARIABLES_LOGO,
            "Firstname" => self::TEMPLATE_VARIABLES_FIRSTNAME,
            "Lastname" => self::TEMPLATE_VARIABLES_LASTNAME,
            "Email" => self::TEMPLATE_VARIABLES_EMAIL,
            "Subject" => self::TEMPLATE_VARIABLES_SUBJECT,
            "Message" => self::TEMPLATE_VARIABLES_MESSAGE);
    }

    public function sendMail($param = array()) {
        try {
            //print_r($config['APPLICATION_PATH']);die;
            $mail = new Mail\Message();

            // From
            //echo "<pre>"; print_r($param); die;
            $mail->setFrom($param['from'], $param['fromname']);

            // To
            $user = array();
            if (isset($param['user_id']) && $param['user_id'] > 0) {
                $mail->to = $param['to'];
                $mail->addTo($mail->to, $mail->to);
            } else {
                $mail->to = $param['to'];
                $mail->addTo($mail->to, $mail->to);
            }

            if (isset($param['cc']) && !empty($param['cc'])) {
                $mail->setCc($param['cc'], $param['cc']);
            }

            // Subject
            $mail->subject = $param['subject'];
            $mail->setSubject($mail->subject);

            $message = $param['template'];
            $html = new MimePart($message);
            $html->type = "text/html";
            $html->charset = 'UTF-8';
            $html->disposition = \Zend\Mime\Mime::DISPOSITION_INLINE;


            $mimeMessage = new MimeMessage();
            $mimeMessage->setParts(array($html));

            $mail->setBody($mimeMessage);

			//////////////// Set Options for SMTP////////////////////////
			
			
			 $options = new Mail\Transport\SmtpOptions(array(
				'name' => 'gmail.com',    // Enter SMPT Host Name
				'host' => 'smtp.gmail.com',  // Enter SMPT Host
				'port' => 465,     // Enter SMPT Port No.   
				'connection_class' => 'login', 
				'connection_config' => array(  
					'username' => 'info@toi.co.il', // Enter email of your account
					'password' => '!nfo@123', // Enter password of your account
					'ssl'=> 'ssl',
				),
			));

$transport = new Mail\Transport\Smtp($options);
$transport->send($mail);
        } catch (Exception $e) {
            return false;
        }
    }

}
