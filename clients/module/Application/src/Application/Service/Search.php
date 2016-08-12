<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cms
 *
 * @author CES-USER04
 */
 
namespace Application\Service;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet; /*
  use Zend\Db\Adapter\StatementContainerInterface;
  use Zend\Db\Adapter\AdapterInterface;
  use Zend\Db\Sql\PreparableSqlInterface; */

class Search extends Base {

    protected $dbAdapter;

    //put your code here
    public function __construct(Adapter $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
        $this->sql = new Sql($dbAdapter);
    }

    public function searchData($params) {

        $select = $this->sql->select("tbl_deal");
        $select->join("tbl_candidate", 'tbl_deal.candidate_id =tbl_candidate.candidate_id', array('candidate_name'), $select::JOIN_LEFT);
        $where = $select->where->nest;
        $where->or
                ->like("deal_type", "%Loan%")
                ->or
                ->like("deal_type", "%Discounting%");

        $select->where(array('candidate_LLC_number' => intval($params['candidate_id_LLC'])));
        $select->order('deal_id DESC');
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $resultSet = new ResultSet();
        $resultSet->initialize($results);
        $result = $resultSet->toArray();
        return $result;
    }

    public function searchData1($params, $user) {

        if (!empty($params['candidate_id_LLC'])) {
            $insert = $this->sql->insert("tbl_search");
            $candidateData['candidate_id_LLC'] = intval($params['candidate_id_LLC']);
            $candidateData['user_id'] = $user['user_id'];
            $candidateData['search_date'] = date('d/m/Y');

            $insert->values($candidateData);
            $selectString = $this->sql->getSqlStringForSqlObject($insert);
            $results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
        }
	
        $search_keyword = intval($params['candidate_id_LLC']);
		//echo $search_keyword; die;
        $select = $this->sql->select("tbl_deal");
        $select->join("tbl_candidate", 'tbl_deal.candidate_id =tbl_candidate.candidate_id', array('candidate_name'), $select::JOIN_LEFT);
        $select->join("deal_type_master", 'deal_type_master.deal_type_id = tbl_deal.deal_type', array('deal_type_eng_name'), $select::JOIN_LEFT);
        $select->where(array('loan_status' => '1'));
        $where = $select->where->nest;

        $where->or
                ->like("deal_type", "%1%")
                ->or
                ->like("deal_type", "%3%");


        // $where->greaterThanOrEqualTo("deal_due_date", date("d/m/Y"));
        // $select->where(array('candidate_LLC_number_integer' => $search_keyword));

        $select->where
                ->nest
                ->equalTo('candidate_LLC_number_integer', $search_keyword)
                ->or
                ->equalTo('deal_guarantor_1', $search_keyword)
                ->or
                ->equalTo('deal_guarantor_2', $search_keyword);

        $select->order('deal_id DESC');
        //echo $statement = $this->sql->getSqlStringForSqlObject($select); exit;
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $resultSet = new ResultSet();
        $resultSet->initialize($results);
        $result = $resultSet->toArray();

        return $result;
    }

    public function getAmount($params) {

        $search_keyword = intval($params['candidate_id_LLC']);
        $select = $this->sql->select("tbl_deal");
        $select->join("tbl_candidate", 'tbl_deal.candidate_id =tbl_candidate.candidate_id', array('candidate_name'), $select::JOIN_LEFT);
        $where = $select->where->nest;
        $where->or
                ->like("deal_type", "%1%")
                ->or
                ->like("deal_type", "%3%");
        // $select->where(array('candidate_LLC_number' => $params['candidate_id_LLC']));  
        $select->where(array('candidate_LLC_number_integer' => $search_keyword));
        $select->columns(array(new \Zend\Db\Sql\Expression('SUM(deal_amount) as total_amount')));
        //echo $statement = $this->sql->getSqlStringForSqlObject($select); exit;
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $resultSet = new ResultSet();
        $resultSet->initialize($results);
        $result = $resultSet->toArray();
        return $result;
    }

    // this function use for before days data from curent day date. 

    public function DayssearchCount($params, $day, $user_id) {
        $select = $this->sql->select("tbl_search");
        $date = strtotime("-" . $day . "day");
        $date = date('d/m/Y', $date);

        $date1 = date("d/m/Y");
		//print_r(count($params)); die;
		if(count($params) > 0){
		$candidate_id_LLC = intval($params['candidate_id_LLC']);
		}else{
			$candidate_id_LLC = NULL;
		}
		
        $select->where(array('candidate_id_LLC' => $candidate_id_LLC));
        $select->where('user_id !=' . $user_id);
        $select->where("STR_TO_DATE(search_date,'%d/%m/%Y') >= STR_TO_DATE('$date','%d/%m/%Y')");
        $select->where("STR_TO_DATE(search_date,'%d/%m/%Y') <= STR_TO_DATE('$date1','%d/%m/%Y')");
        // $where = $select->where->nest;
        // $where->greaterThanOrEqualTo("STR_TO_DATE(search_date,'%d/%m/%Y)", $date);
        //$where->lessThanOrEqualTo("STR_TO_DATE(search_date,'%d/%m/%Y)", date("d/m/Y"));
        //$select->where(array($date . ' >= search_date <= ' . date("d/m/Y")));
        $select->columns(array(new \Zend\Db\Sql\Expression('COUNT(DISTINCT(user_id)) as total_user')));
      //  echo $statement = $this->sql->getSqlStringForSqlObject($select);
      //  exit;
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $resultSet = new ResultSet();
        $resultSet->initialize($results);
        $result = $resultSet->toArray();
        return $result[0]['total_user'];
    }

    public function getCountUser($params) {
        $search_keyword = intval($params['candidate_id_LLC']);
        $select = $this->sql->select("tbl_deal");
        $select->where(array('candidate_LLC_number_integer' => $search_keyword));
        //$select->where(array('candidate_LLC_number' => $params['candidate_id_LLC']));
        $select->where(array('deal_type' => "1"));
        $select->columns(array(new \Zend\Db\Sql\Expression('COUNT(DISTINCT(deal_createBy)) as total_user')));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $resultSet = new ResultSet();
        $resultSet->initialize($results);
        $result = $resultSet->toArray();
        return $result[0]['total_user'];
    }

    /* this function query does not work in fetch last 30 days count from current day date so use DayssearchCount function. 	
      public function getCountUserByDate($params) {
      $select = $this->sql->select("tbl_search");
      $date = strtotime("-7 day");
      $date = date('d/m/Y', $date);
      $where = $select->where->nest;
      $where->greaterThanOrEqualTo("search_date", $date);
      $where->lessThanOrEqualTo("search_date", date("d/m/Y"));
      $select->where(array('candidate_id_LLC' => $params['candidate_id_LLC']));
      $select->columns(array(new \Zend\Db\Sql\Expression('COUNT(DISTINCT(user_id)) as total_user')));
      $statement = $this->sql->prepareStatementForSqlObject($select);
      $results = $statement->execute();
      $resultSet = new ResultSet();
      $resultSet->initialize($results);
      $result = $resultSet->toArray();
      return $result[0]['total_user'];
      }
     */

    public function getReportComment($params) {

        $search_key = intval($params['candidate_id_LLC']);

        $select = $this->sql->select("tbl_deal");
        $select->join("tbl_user", 'tbl_user.user_id = tbl_deal.deal_createBy', array('user_office_name'), $select::JOIN_LEFT);
        $select->where(array('candidate_LLC_number_integer' => $search_key));
        $select->where(array('tbl_deal.deal_type' => "2"));
        $select->order('tbl_deal.deal_id DESC');
        $statement = $this->sql->prepareStatementForSqlObject($select);

        $results = $statement->execute();
        $resultSet = new ResultSet();
        $resultSet->initialize($results);
        $result = $resultSet->toArray();

        return $result;
    }

    public function historyData($params, $user) {
        $select = $this->sql->select("tbl_deal");
        $select->join("tbl_candidate", 'tbl_deal.candidate_id =tbl_candidate.candidate_id', array('candidate_name'), $select::JOIN_LEFT);
        $select->join("deal_type_master", 'deal_type_master.deal_type_id = tbl_deal.deal_type', array('deal_type_eng_name'), $select::JOIN_LEFT);
        if (isset($params['deal_type']) && !empty($params['deal_type'])) {
            if ($params['deal_type'] == "") {
                
            } else {
                $select->where(array('deal_type' => $params['deal_type']));
            }
        }
        $select->where(array('deal_createBy' => $user['user_id']));
        $select->order('deal_createDate DESC');
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $resultSet = new ResultSet();
        $resultSet->initialize($results);
        $result = $resultSet->toArray();
        return $result;
    }

    public function dealType() {
        $select = $this->sql->select("deal_type_master");
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $resultSet = new ResultSet();
        $resultSet->initialize($results);
        $result = $resultSet->toArray();
        return $result;
    }

}
