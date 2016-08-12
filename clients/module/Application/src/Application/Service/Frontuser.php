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

class Frontuser extends Base {

    protected $dbAdapter;

    //put your code here
    public function __construct(Adapter $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
        $this->sql = new Sql($dbAdapter);
    }

    public function getUserFromEmailPassword($postData) {
        $select = $this->sql->select("tbl_user");
        $select->where(array("user_email='" . $postData['user_email'] . "'", "user_password = '" . md5($postData['user_password']) . "'"));
        $statement = $this->sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        $row = $results->current();
        $resultSet = new ResultSet();
        $resultSet->initialize($results);
        $result = $resultSet->toArray();
        return $row;
    }

}
