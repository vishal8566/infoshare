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
 
class SearchController extends BaseController {

    public function onDispatch(\Zend\Mvc\MvcEvent $e) {
        parent::onDispatch($e);
    }

    public function indexAction() {
        setcookie('user_route', 'search', time() + 3600, "/");
        if ($this->getRequest()->getQuery()) {
            $post = $this->getRequest()->getQuery();
            $loginUser = $this->getServiceLocator()->get('Application\Service\Base')->getUser();
			//echo count($post);
			//echo "<pre>"; print_r($post); die;
            if (count($post) > 0) {
                $getSearchData = $this->getServiceLocator()->get('Application\Service\Search')->searchData1($post, $loginUser);
            } else {
                $getSearchData = "";
            }
            $getAmount = $this->getServiceLocator()->get('Application\Service\Search')->getAmount($post);
            $getUser = $this->getServiceLocator()->get('Application\Service\Search')->getCountUser($post);
            $getcomment = $this->getServiceLocator()->get('Application\Service\Search')->getReportComment($post);
            //$userByDate = $this->getServiceLocator()->get('Application\Service\Search')->getCountUserByDate($post);

            $thirtydayCount = $this->getServiceLocator()->get('Application\Service\Search')->DayssearchCount($post, '30', $loginUser['user_id']);

            $sevendayCount = $this->getServiceLocator()->get('Application\Service\Search')->DayssearchCount($post, '7', $loginUser['user_id']);

            return new ViewModel(array("searchData" => $getSearchData, "amount" => $getAmount, "comment" => $getcomment, "user_count" => $getUser, "sevendayCount" => $sevendayCount, 'thirtydayCount' => $thirtydayCount));



            //if ($userByDate < 5) {
            //    return new ViewModel(array("searchData" => $getSearchData, "amount" => $getAmount, "comment" => $getcomment, "user_count" => $getUser, "userByDate" => $userByDate));
            //} else if ($userByDate >= 5) {
            //    return new ViewModel(array("searchData" => $getSearchData, "amount" => $getAmount, "comment" => $getcomment, "user_count" => $getUser, "userByDate" => $userByDate));
            // }
        } else {
            return new ViewModel(array("searchData" => "", "amount" => "", "comment" => "", "user_count" => "", "userByDate" => 0));
        }
    }

    public function printDataAction() {

        $config = $this->getServiceLocator()->get('config');
        $loginUser = $this->getServiceLocator()->get('Application\Service\Base')->getUser();
        include $config['APPLICATION_FOLDER_PATH'] . "tcpdf/tcpdf.php";
        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $filename = $loginUser['user_id'] . "_" . date("Y_m_d_H_i_s") . ".pdf";

        $post = $this->getRequest()->getQuery();
        $getAmount = $this->getServiceLocator()->get('Application\Service\Search')->getAmount($post);
        $getUser = $this->getServiceLocator()->get('Application\Service\Search')->getCountUser($post);
        $getcomment = $this->getServiceLocator()->get('Application\Service\Search')->getReportComment($post);
        $loginUser = $this->getServiceLocator()->get('Application\Service\Base')->getUser();
        $getSearchData = $this->getServiceLocator()->get('Application\Service\Search')->searchData1($post,$loginUser);
		//echo "<pre>"; print_r($getSearchData); die;
        $html = '<table width="100%"><tr><td width="20%" align="right" bgcolor="#10a7c3"><font color="#FFFFFF"><h3>Guarantor 2</h3></font/></td><td width="20%" align="right" bgcolor="#10a7c3"><font color="#FFFFFF"><h3>Guarantor 1</h3></font/></td><td width="10%" align="right" bgcolor="#10a7c3"><font color="#FFFFFF"><h3>Comments</h3></font/></td><td align="right" width="10%" bgcolor="#10a7c3"><font color="#FFFFFF"><h3>Due Date</h3></font></td><td align="right" width="10%" bgcolor="#10a7c3"><font color="#FFFFFF"><h3>Amount</h3></font></td><td align="right" width="10%" bgcolor="#10a7c3"><font color="#FFFFFF"><h3>Inserted Date</h3></font></td><td align="right" width="10%" bgcolor="#10a7c3"><font color="#FFFFFF"><h3>LLC Number</h3></font></td><td align="right" width="10%" bgcolor="#10a7c3"><font color="#FFFFFF"><h3>Type</h3></font></td></tr></table>';
	
        foreach ($getSearchData as $data) {
			if(!empty($data["deal_guarantor_2"])){
				$str1 = $data["deal_guarantor_2"];
			}else{
				$str1 = "None";
			}
			if(!empty($data["deal_guarantor_2_name"])){
				$str2 = $data["deal_guarantor_2_name"];
			}else{
				$str2 = "None";
			}
			if(!empty($data["deal_guarantor_1"])){
				$str3 = $data["deal_guarantor_1"];
			}else{
				$str3 = "None";
			}
			if(!empty($data["deal_guarantor_1_name"])){
				$str4 = $data["deal_guarantor_1_name"];
			}else{
				$str4 = "None";
			}
			
			
            $html.='<table width="100%" style=" padding-bottom:5px;"><table width="100%" style="border-bottom:1px dashed #10a7c3;padding-top:0px;">'
                    . '<tr>'
                    . '<td width="20%" align="right"><font color="#777777"><h3>(' . $str1 . ')-'.$str2.' </h3></font/></td>'
                    . '<td width="20%" align="right"><font color="#777777"><h3>(' . $str3 . ')-'.$str4.'</h3></font/> </td>'
                    . '<td width="10%" align="right"><font color="#777777"><h3>' . $data["deal_comments"] . '</h3></font/></td>'
                    . '<td width="10%" align="right"><font color="#777777"><h3>' . $data["deal_due_date"] . '</h3></font/></td>'
                    . '<td width="10%" align="right"><font color="#777777"><h3>' . $data["deal_amount"] . '</h3></font/></td>'
                    . '<td width="10%" align="right"><font color="#777777"><h3>' . $data["deal_start_date"] . '</h3></font/> </td>'
                    . '<td width="10%" align="right"><font color="#777777"><h3>' . $data["candidate_LLC_number"] . '</h3></font/> </td>'
                    . '<td width="10%" align="right"><font color="#777777"><h3>' . $data["deal_type_eng_name"] . '</h3></font/> </td>'
                    . '</tr></table>';
            $html.= "</table><br/><br/>";
        }

        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH);
// set document information
        $pdf->SetCreator(PDF_CREATOR);


// set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);


// set font
        //$pdf->SetFont('helvetica', '', 9);
$pdf->SetFont('aealarabiya', '', 8);
// add a page
        $pdf->AddPage();

// output the HTML content
        //$pdf->writeHTML($html, true, 0, true, 0);
        $pdf->writeHTML($html, true, false, true, false, 'R');
		
// reset pointer to the last page
        //$pdf->lastPage();
// ---------------------------------------------------------
//Close and output PDF document
        $pdf->Output($filename, 'D');
    }

}
