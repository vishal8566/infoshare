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
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\StatementContainerInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\PreparableSqlInterface;

class Client extends Base {

    protected $dbAdapter;

//put your code here
    public function __construct(Adapter $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
        $this->sql = new Sql($dbAdapter);
    }

    public function getCandidate() {
        $select = $this->sql->select("tbl_user");
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $resultSet = new ResultSet();
        $resultSet->initialize($results);
        $result = $resultSet->toArray();
        return $result;
    }

    public function checkEmail($post) {

        $select = $this->sql->select("tbl_user");

        if ($post['user_id']) {

            $select->where(array('user_email' => $post['user_email']));
            $select->where('`user_id`  != ' . $post['user_id']);
        } else {

            $select->where(array('user_email' => $post['user_email']));
        }

        //echo $statement = $this->sql->getSqlStringForSqlObject($select); exit;
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $row = $results->current();
        return $row;
    }

    public function saveClient($post) {
        $id = isset($post['user_id']) ? $post['user_id'] : "";
        $return = array();
        if ($id > 0) {
            try {
                //update here
                $update = $this->sql->update();
                $update->table("tbl_user");
                $client['user_fullname'] = $post['user_office_name'];
                $client['user_office_name'] = $post['user_office_name'];
                $client['user_id_LLC'] = $post['user_id_LLC'];
                $client['user_phone'] = $post['user_phone'];
                $client['user_address'] = $post['user_address'];
                $client['user_contact_name'] = $post['user_contact_name'];
                $client['user_email'] = $post['user_email'];
                $client['user_password'] = md5($post['user_password']);
                $client['user_createDate'] = date("Y-m-d H:m:s");
                $client['user_updateDate'] = date("Y-m-d H:m:s");
                $client['status'] = $post['status'];
                $update->set($client);
                $update->where(array('user_id' => $id));
                $statement = $this->sql->prepareStatementForSqlObject($update);
                $result = $statement->execute();
                return true;
            } catch (\Exception $e) {
                return false;
            }
        } else {
            try {
                //insert here
                $insert = $this->sql->insert("tbl_user");
                $client['user_fullname'] = $post['user_office_name'];
                $client['user_office_name'] = $post['user_office_name'];
                $client['user_id_LLC'] = $post['user_id_LLC'];
                $client['user_phone'] = $post['user_phone'];
                $client['user_address'] = $post['user_address'];
                $client['user_contact_name'] = $post['user_contact_name'];
                $client['user_email'] = $post['user_email'];
                $client['user_password'] = md5($post['user_password']);
                $client['user_createDate'] = date("Y-m-d H:m:s");
                $client['user_updateDate'] = date("Y-m-d H:m:s");
                $client['status'] = $post['status'];

                $insert->values($client);
                $selectString = $this->sql->getSqlStringForSqlObject($insert);
                $results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
                //send mail function for user registration
                return true;
            } catch (\ErrorException $e) {
                return false;
            }
        }
    }

    public function getById($id) {
        $select = $this->sql->select("tbl_user");
        $select->where(array('user_id' => $id));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $row = $results->current();
        return $row;
    }

    public function getCountLoan($id, $search_form, $search_to) {
        $select = $this->sql->select("tbl_deal");
      //  $where = $select->where->nest;
      //  $where->greaterThanOrEqualTo("deal_start_date", $search_form);
      //  $where->lessThanOrEqualTo("deal_start_date", $search_to);
        $select->where("STR_TO_DATE(deal_start_date,'%d/%m/%Y') >= STR_TO_DATE('$search_form','%d/%m/%Y')");
        $select->where("STR_TO_DATE(deal_start_date,'%d/%m/%Y') <= STR_TO_DATE('$search_to','%d/%m/%Y')");
        $select->where(array('deal_createBy' => $id));
        $select->where(array('deal_type' => "1"));
        $select->columns(array(new \Zend\Db\Sql\Expression('COUNT(candidate_LLC_number) as total_loan')));
     //   echo $statement = $this->sql->getSqlStringForSqlObject($select);
    //    exit;
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $resultSet = new ResultSet();
        $resultSet->initialize($results);
        $result = $resultSet->toArray();
        return $result[0]['total_loan'];
    }

    public function getName($id) {
        $select = $this->sql->select("tbl_candidate");
        $select->where(array('candidate_id' => $id));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $resultSet = new ResultSet();
        $resultSet->initialize($results);
        $result = $resultSet->toArray();
        return $result[0]['candidate_name'];
    }

    public function getOfficeName($id) {
        $select = $this->sql->select("tbl_user");
        $select->where(array('user_id' => $id));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $resultSet = new ResultSet();
        $resultSet->initialize($results);
        $result = $resultSet->toArray();
        return $result[0]['user_office_name'];
    }

    public function getCountDiscount($id, $search_form, $search_to) {
        $select = $this->sql->select("tbl_deal");
       // $where = $select->where->nest;
       // $where->greaterThanOrEqualTo("deal_start_date", $search_form);
       // $where->lessThanOrEqualTo("deal_start_date", $search_to);
        
        $select->where("STR_TO_DATE(deal_start_date,'%d/%m/%Y') >= STR_TO_DATE('$search_form','%d/%m/%Y')");
        $select->where("STR_TO_DATE(deal_start_date,'%d/%m/%Y') <= STR_TO_DATE('$search_to','%d/%m/%Y')");

		$select->where(array('deal_createBy' => $id));
        $select->where(array('deal_type' => "3"));
        $select->columns(array(new \Zend\Db\Sql\Expression('COUNT(DISTINCT(candidate_LLC_number)) as total_discount')));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $resultSet = new ResultSet();
        $resultSet->initialize($results);
        $result = $resultSet->toArray();
        return $result[0]['total_discount'];
    }

    public function getCountSearch($id, $search_form, $search_to) {
        $select = $this->sql->select("tbl_search");
       // $where = $select->where->nest;
       // $where->greaterThanOrEqualTo("search_date", $search_form);
       // $where->lessThanOrEqualTo("search_date", $search_to);
	   
        $select->where("STR_TO_DATE(search_date,'%d/%m/%Y') >= STR_TO_DATE('$search_form','%d/%m/%Y')");
        $select->where("STR_TO_DATE(search_date,'%d/%m/%Y') <= STR_TO_DATE('$search_to','%d/%m/%Y')");

        $select->where(array('user_id' => $id));
        $select->columns(array(new \Zend\Db\Sql\Expression('COUNT(candidate_id_LLC) as total_search')));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $resultSet = new ResultSet();
        $resultSet->initialize($results);
        $result = $resultSet->toArray();
        return $result[0]['total_search'];
    }

    public function getClientData($params) {

        $select = $this->sql->select("tbl_user");
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $resultSet = new ResultSet();
        $resultSet->initialize($results);
        $result = $resultSet->toArray();
        $show_from = isset($params['show_from']) ? $params['show_from'] : "";
        $show_to = isset($params['show_to']) ? $params['show_to'] : "";

        if ($show_from == "") {
            $search_form = date('01/m/Y', strtotime(date('Y-m-d'))) . "<br>";
        } else {
            $search_form = $show_from;
        }
        if ($show_to == "") {
            $search_to = date('t/m/Y', strtotime(date('Y-m-d')));
        } else {
            $search_to = $show_to;
        }

        foreach ($result as $k => $v) {
            $result[$k]['total_loan'] = $this->getCountLoan($v['user_id'], $search_form, $search_to);
            $result[$k]['total_discount'] = $this->getCountDiscount($v['user_id'], $search_form, $search_to);
            $result[$k]['total_search'] = $this->getCountSearch($v['user_id'], $search_form, $search_to);
            $result[$k]['total'] = $result[$k]['total_loan'] + $result[$k]['total_discount'];
        }
        return $result;
    }

    public function getDealData($params) {
        $show_from = isset($params['show_from']) ? $params['show_from'] : "";
        $show_to = isset($params['show_to']) ? $params['show_to'] : "";

        if ($show_from == "") {
            $search_form = date('01/m/Y', strtotime(date('Y-m-d'))) . "<br>";
        } else {
            $search_form = $show_from;
        }
        if ($show_to == "") {
            $search_to = date('t/m/Y', strtotime(date('Y-m-d')));
        } else {
            $search_to = $show_to;
        }
        $select = $this->sql->select("tbl_deal");
        $select->join("deal_type_master", 'deal_type_master.deal_type_id = tbl_deal.deal_type', array('deal_type_eng_name'), $select::JOIN_LEFT);
        $select->where("STR_TO_DATE(deal_start_date,'%d/%m/%Y') >= STR_TO_DATE('$search_form','%d/%m/%Y')");
        $select->where("STR_TO_DATE(deal_start_date,'%d/%m/%Y') <= STR_TO_DATE('$search_to','%d/%m/%Y')");
        $where = $select->where->nest;
        //$where->greaterThanOrEqualTo("deal_start_date", $search_form);
        //$where->lessThanOrEqualTo("deal_start_date", $search_to);
        $where->and
                ->like("deal_type", "%1%")
                ->or
                ->like("deal_type", "%2%")
                ->or
                ->like("deal_type", "%3%");

        $statement = $this->sql->prepareStatementForSqlObject($select);
	  //  echo $statement = $this->sql->getSqlStringForSqlObject($select);
     //   exit;
        $results = $statement->execute();
        $resultSet = new ResultSet();
        $resultSet->initialize($results);
        $result = $resultSet->toArray();

        foreach ($result as $k => $v) {
            $result[$k]['candidate_name'] = $this->getName($v['candidate_id']);
            $result[$k]['office_name'] = $this->getOfficeName($v['deal_createBy']);
        }

        return $result;
    }

}
