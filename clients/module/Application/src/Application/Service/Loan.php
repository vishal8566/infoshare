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

/*
  use Zend\Db\Adapter\StatementContainerInterface;
  use Zend\Db\Adapter\AdapterInterface;
  use Zend\Db\Sql\PreparableSqlInterface; */

class Loan extends Base {

    protected $dbAdapter;

//put your code here
    public function __construct(Adapter $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
        $this->sql = new Sql($dbAdapter);
    }

    public function loanSave($data, $loginUser) {

//insert here
        $insert = $this->sql->insert("tbl_candidate");
        $candidateData['candidate_name'] = $data['candidate_name'];
        $candidateData['candidate_id_LLC'] = $data['candidate_id_LLC'];
        $candidateData['candidate_createBy'] = $loginUser['user_id'];
        $candidateData['candidate_updateBy'] = $loginUser['user_id'];
        $insert->values($candidateData);
        $selectString = $this->sql->getSqlStringForSqlObject($insert);
        $results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
        $last_inserted_id = $this->dbAdapter->getDriver()->getLastGeneratedValue();


        if ($last_inserted_id > 0) {
            $insert1 = $this->sql->insert("tbl_deal");
            $candidateData1['candidate_id'] = $last_inserted_id;
            $candidateData1['candidate_LLC_number'] = $data['candidate_id_LLC'];
            $candidateData1['candidate_LLC_number_integer'] = intval($data['candidate_id_LLC']);
            $candidateData1['deal_type'] = $data['deal_type'];
            $candidateData1['deal_due_date'] = $data['deal_due_date'];
            $candidateData1['deal_start_date'] = $data['deal_start_date'];
            $candidateData1['deal_phone'] = $data['deal_phone'];
            $candidateData1['deal_amount'] = $data['deal_amount'];
            $candidateData1['deal_comments'] = $data['deal_comments'];
            $candidateData1['deal_guarantor_1'] = $data['deal_guarantor_1'];
            $candidateData1['deal_guarantor_1_name'] = $data['deal_guarantor_1_name'];
            $candidateData1['deal_guarantor_2'] = $data['deal_guarantor_2'];
            $candidateData1['deal_guarantor_2_name'] = $data['deal_guarantor_2_name'];
            $candidateData1['deal_createBy'] = $loginUser['user_id'];
            $candidateData1['deal_updateBy'] = $loginUser['user_id'];
            $insert1->values($candidateData1);
            $selectString1 = $this->sql->getSqlStringForSqlObject($insert1);
            $results1 = $this->dbAdapter->query($selectString1, Adapter::QUERY_MODE_EXECUTE);
        }

        return true;
    }

    public function userSave($data, $loginUser) {
//insert here

        $userLogin = $this->checkUser($data['user_email']);
        if ($userLogin && isset($userLogin['user_id']) > 0) {
            return array("msg" => 0);
        } else {
            $insert = $this->sql->insert("tbl_user");
            $candidateData['user_fullname'] = $data['user_fullname'];
            $candidateData['user_email'] = $data['user_email'];
            $candidateData['user_password'] = $data['user_password'];
            $insert->values($candidateData);
            $selectString = $this->sql->getSqlStringForSqlObject($insert);
            $results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
            $last_inserted_id = $this->dbAdapter->getDriver()->getLastGeneratedValue();
            return array("msg" => 1);
        }
    }

    public function userDelete($data) {
        $userLogin = $this->checkUser($data['user_email']);
        if ($userLogin && isset($userLogin['user_id']) > 0) {
            $delete = $this->sql->delete();
            $delete->from("tbl_user");
            $delete->where(array('user_email' => $data['user_email']));
            $statement = $this->sql->prepareStatementForSqlObject($delete);
            $results = $statement->execute();
            return array("msg" => 1);
        } else {
            return array("msg" => 0);
        }
    }

    public function checkUser($email) {
        $select = $this->sql->select("tbl_user");
        $select->where(array('user_email' => $email));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $row = $results->current();
        return $row;
    }

    public function reportSave($data, $loginUser) {


        $select = $this->sql->select("tbl_report");
        $select->where(array('rprt_id' => $data['deal_comments']));
        //echo $statement = $this->sql->getSqlStringForSqlObject($select); exit;
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $row = $results->current();


//insert here
        $insert = $this->sql->insert("tbl_candidate");
        $candidateData['candidate_name'] = $data['candidate_name'];
        $candidateData['candidate_id_LLC'] = $data['candidate_id_LLC'];
        $candidateData['candidate_createBy'] = $loginUser['user_id'];
        $candidateData['candidate_updateBy'] = $loginUser['user_id'];
        $insert->values($candidateData);
        $selectString = $this->sql->getSqlStringForSqlObject($insert);
        $results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
        $last_inserted_id = $this->dbAdapter->getDriver()->getLastGeneratedValue();

        if ($last_inserted_id > 0) {
            $insert1 = $this->sql->insert("tbl_deal");
            $candidateData1['candidate_id'] = $last_inserted_id;
            $candidateData1['candidate_LLC_number'] = $data['candidate_id_LLC'];
            $candidateData1['candidate_LLC_number_integer'] = intval($data['candidate_id_LLC']);
            $candidateData1['deal_type'] = $data['deal_type'];
            $candidateData1['deal_due_date'] = date("d/m/Y");
            $candidateData1['deal_start_date'] = date("d/m/Y");
            $candidateData1['deal_amount'] = "";
            // $candidateData1['deal_paymentCount'] = "";
            $candidateData1['deal_report_comment_id'] = $data['deal_comments'];
            $candidateData1['deal_comments'] = $row['rprt_comment'];
            $candidateData1['deal_guarantor_1'] = "";
            $candidateData1['deal_guarantor_2'] = "";
            $candidateData1['deal_guarantor_3'] = "";
            $candidateData1['deal_createBy'] = $loginUser['user_id'];
            $candidateData1['deal_updateBy'] = $loginUser['user_id'];
            $insert1->values($candidateData1);
            $selectString1 = $this->sql->getSqlStringForSqlObject($insert1);
            $results1 = $this->dbAdapter->query($selectString1, Adapter::QUERY_MODE_EXECUTE);
        }

        return true;
    }

    public function discountSave($data, $loginUser) {

//insert here
        $insert = $this->sql->insert("tbl_candidate");
        $candidateData['candidate_name'] = $data['candidate_name'];
        $candidateData['candidate_id_LLC'] = $data['candidate_id_LLC'];
        $candidateData['candidate_createBy'] = $loginUser['user_id'];
        $candidateData['candidate_updateBy'] = $loginUser['user_id'];
        $insert->values($candidateData);
        $selectString = $this->sql->getSqlStringForSqlObject($insert);
        $results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
        $last_inserted_id = $this->dbAdapter->getDriver()->getLastGeneratedValue();
        $last_comment_id = array();
        if ($last_inserted_id > 0) {
            $i = 0;
            foreach ($data['deal_comments'] as $comment) {
                $insert1 = $this->sql->insert("tbl_deal");
                $candidateData1['candidate_id'] = $last_inserted_id;
                $candidateData1['candidate_LLC_number'] = $data['candidate_id_LLC'];
                $candidateData1['candidate_LLC_number_integer'] = intval($data['candidate_id_LLC']);
                $candidateData1['deal_type'] = $data['deal_type'];
                $candidateData1['deal_start_date'] = date('d/m/Y');
                // $candidateData1['deal_paymentCount'] = ""; 
                $candidateData1['deal_comments'] = $comment;
                $candidateData1['deal_guarantor_1'] = "";
                $candidateData1['deal_guarantor_2'] = "";
                $candidateData1['deal_guarantor_3'] = "";
                $candidateData1['deal_createBy'] = $loginUser['user_id'];
                $candidateData1['deal_updateBy'] = $loginUser['user_id'];
                $insert1->values($candidateData1);
                $selectString = $this->sql->getSqlStringForSqlObject($insert1);
                $results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
                $last_comment_id[$i] = $this->dbAdapter->getDriver()->getLastGeneratedValue();
                $i++;
            }


            $j = 0;
            foreach ($data['deal_amount'] as $k => $v) {
                $update = $this->sql->update();
                $update->table("tbl_deal");
                $candidateData2['deal_amount'] = $data['deal_amount'][$k];
                $update->set($candidateData2);
                $update->where(array('deal_id' => $last_comment_id[$j]));
                $statement = $this->sql->prepareStatementForSqlObject($update);
                $result = $statement->execute();
                $j++;
            }
            $j = 0;
            foreach ($data['deal_due_date'] as $k => $v) {
                $update = $this->sql->update();
                $update->table("tbl_deal");
                $candidateData3['deal_due_date'] = $data['deal_due_date'][$k];
                $candidateData3['deal_start_date'] = $data['deal_start_date'][$k];
                $update->set($candidateData3);
                $update->where(array('deal_id' => $last_comment_id[$j]));
                $statement = $this->sql->prepareStatementForSqlObject($update);
                $result = $statement->execute();
                $j++;
            }
        }

        return true;
    }

    public function getCandidate() {
        $candiate = array();
        $select = $this->sql->select("tbl_candidate");
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $resultSet = new ResultSet();
        $resultSet->initialize($results);
        $result = $resultSet->toArray();

        foreach ($result as $k => $v) {
            $candiate[$k]['value'] = $v['candidate_name'];
            $candiate[$k]['label'] = $v['candidate_id_LLC'];
        }

//        /echo json_encode($kidName); die;
        return json_encode($candiate);
    }

    public function getLoanUser($data) {
        $select = $this->sql->select("tbl_deal");
        $select->join("tbl_candidate", 'tbl_deal.candidate_id =tbl_candidate.candidate_id', array('candidate_name'), $select::JOIN_LEFT);
        $select->where(array('deal_id' => $data['deal_id']));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $resultSet = new ResultSet();
        $resultSet->initialize($results);
        $result = $resultSet->toArray();
        return $result;
    }

    public function getDiscountUser($data) {
        $select = $this->sql->select("tbl_deal");
        $select->where(array('candidate_id' => $data['candidate_id']));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $resultSet = new ResultSet();
        $resultSet->initialize($results);
        $result = $resultSet->toArray();
        return $result;
    }

    public function getCandidateUser($data) {
        $select = $this->sql->select("tbl_deal");
        $select->join("tbl_candidate", 'tbl_deal.candidate_id =tbl_candidate.candidate_id', array('candidate_name'), $select::JOIN_LEFT);
        $select->where(array('deal_id' => $data['deal_id']));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $row = $results->current();
        return $row['candidate_name'];
    }

    public function getCandidateName($LLC) {
        $select = $this->sql->select("tbl_candidate");
        $select->where(array('candidate_id_LLC' => $LLC));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $row = $results->current();
        if ($row['candidate_id'] > 0) {
            return array("name" => $row['candidate_name'], "message" => "true");
        } else {
            //return array("name" => "", "message" => "There is no candidate with this LLC number");
            return array("name" => "", "message" => "");
        }
    }

    public function getLoanComment() {
        $select = $this->sql->select("tbl_report");
        $select->where(array('rprt_type' => "1"));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $resultSet = new ResultSet();
        $resultSet->initialize($results);
        $result = $resultSet->toArray();
        return $result;
    }

    public function getDiscountComment() {
        $select = $this->sql->select("tbl_report");
        $select->where(array('rprt_type' => "3"));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $resultSet = new ResultSet();
        $resultSet->initialize($results);
        $result = $resultSet->toArray();
        return $result;
    }

}
