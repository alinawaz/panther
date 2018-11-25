<?php

namespace Panther\Database;

use Panther\Database\MysqlQuery as DB;
use Panther\Database\Interfaces\MysqlTableInterface;

class MysqlTable Implements MysqlTableInterface {

    private $tableName = '';
    private $queryBuilderString = '';
    private $queryBuilderWhere = '';
    private $queryBuilderAfterWhere = '';
    private $lastQuery = '';
    private $joinTable = '';

    function __construct($tableNameString) {
        $this->tableName = $tableNameString;
        $this->queryBuilderString .= "SELECT * FROM ".$this->tableName;
        return $this;
    }

    public function getLastQuery() {
      return $this->lastQuery;
    }

    public function getQuery(){
      return $this->queryBuilderString.' '.$this->queryBuilderWhere . ' ' . $this->queryBuilderAfterWhere;
    }

    public function resetQueryBuilder(){
      $this->lastQuery = $this->queryBuilderString.' '.$this->queryBuilderWhere . ' ' . $this->queryBuilderAfterWhere;
      $this->queryBuilderString='';
      $this->queryBuilderWhere='';
      $this->queryBuilderAfterWhere='';
    }

    public function with($table,$joinType=''){
        $this->queryBuilderWhere .= " ".$joinType." JOIN ".$table." ON ".$table.".".$this->tableName."_id=".$this->tableName.".id ";
        return $this;
    }

    public function join($table,$joinType=''){
        $this->joinTable = $table;
        $this->queryBuilderWhere .= " ".$joinType." JOIN ".$table." ";
        return $this;
    }

    public function on($arrayOrColumnName, $columnValue=NULL, $conditionType = 'AND'){
      if(is_array($arrayOrColumnName)){
        $whereString = '';
        if ($arrayOrColumnName != null) {
            foreach ($arrayOrColumnName as $key => $value) {
                if ($whereString == "") {
                    $whereString = $whereString . " " . $this->joinTable . "." . $key . "=" . $this->tableName . "." . $value . " ";
                } else {
                    $whereString = $whereString . " ".$conditionType." " .$this->joinTable . "." . $key . "=" .$this->tableName . "." . $value . " ";
                }
            }
            $this->queryBuilderWhere .= " ON ". $whereString;
        }
      }else{
        $this->queryBuilderWhere .= ' ON '. $this->joinTable . "." . $arrayOrColumnName . "=" . $this->tableName . "." . $columnValue . " ";
      }
      return $this;
    }

    public function select($queryString){
      $this->queryBuilderString = "SELECT ".$queryString." FROM ".$this->tableName;
      return $this;
    }

    public function orWhere($arrayOrColumnName, $columnValue=NULL){
      if(is_array($arrayOrColumnName)){
        $whereString = '';
        if ($arrayOrColumnName != null) {
            foreach ($arrayOrColumnName as $key => $value) {
                if ($whereString == "") {
                    $whereString = $whereString . " " . $key . "='" . $value . "' ";
                } else {
                    $whereString = $whereString . " OR " . $key . "='" . $value . "' ";
                }
            }
            $this->queryBuilderWhere .= ($this->queryBuilderWhere==''?' WHERE ':' OR ') . $whereString;
        }
      }else{
        $this->queryBuilderWhere .= ($this->queryBuilderWhere==''?' WHERE ':' OR ') . $arrayOrColumnName." = '".$columnValue."' ";
      }
      return $this;
    }

    public function andWhere($arrayOrColumnName, $columnValue=NULL){
      if(is_array($arrayOrColumnName)){
        $whereString = '';
        if ($arrayOrColumnName != null) {
            foreach ($arrayOrColumnName as $key => $value) {
                if ($whereString == "") {
                    $whereString = $whereString . " " . $key . "='" . $value . "' ";
                } else {
                    $whereString = $whereString . " AND " . $key . "='" . $value . "' ";
                }
            }
            $this->queryBuilderWhere .= ($this->queryBuilderWhere==''?' WHERE ':' AND ') . $whereString;
        }
      }else{
        $this->queryBuilderWhere .= ($this->queryBuilderWhere==''?' WHERE ':' AND ') . $arrayOrColumnName." = '".$columnValue."' ";
      }
      return $this;
    }

    public function where($arrayOrColumnName, $columnValue=NULL, $conditionType = 'AND'){
      if(is_array($arrayOrColumnName)){
        $whereString = '';
        if ($arrayOrColumnName != null) {
            foreach ($arrayOrColumnName as $key => $value) {
                if ($whereString == "") {
                    $whereString = $whereString . " " . $key . "='" . $value . "' ";
                } else {
                    $whereString = $whereString . " ".$conditionType." " . $key . "='" . $value . "' ";
                }
            }
            $this->queryBuilderWhere .= ($this->queryBuilderWhere==''?' WHERE ':' '.$conditionType.' ') . $whereString;
        }
      }else{
        $this->queryBuilderWhere .= ($this->queryBuilderWhere==''?' WHERE ':' '.$conditionType.' ') . $arrayOrColumnName." = '".$columnValue."' ";
      }
      return $this;
    }

    public function whereRaw($arrayOrColumnName, $columnValue=NULL, $conditionType = 'AND'){
      if(is_array($arrayOrColumnName)){
        $whereString = '';
        if ($arrayOrColumnName != null) {
            foreach ($arrayOrColumnName as $key => $value) {
                if ($whereString == "") {
                    $whereString = $whereString . " " . $key . " " . $value . " ";
                } else {
                    $whereString = $whereString . " ".$conditionType." " . $key . " " . $value . " ";
                }
            }
            $this->queryBuilderWhere .= ($this->queryBuilderWhere==''?' WHERE ':' '.$conditionType.' ') . $whereString;
        }
      }else{
        $this->queryBuilderWhere .= ($this->queryBuilderWhere==''?' WHERE ':' '.$conditionType.' ') . $arrayOrColumnName." ".$columnValue;
      }
      return $this;
    }

    public function orderBy($columns,$order = 'ASC'){
        if(is_array($columns)){
            $orders = '';
            for ($i=0; $i < count($columns); $i++) { 
                $orders .= ($orders==''?$columns[$i]:','.$columns[$i]);
            }
            $this->queryBuilderWhere .= ' ORDER BY ' . $orders;
        }else{
            $this->queryBuilderWhere .= ' ORDER BY ' . $columns . ' ' .$order;
        }
        return $this;
    }

    public function groupBy($columns){
        if(is_array($columns)){
            $groups = '';
            for ($i=0; $i < count($columns); $i++) { 
                $groups .= ($groups==''?$columns[$i]:','.$columns[$i]);
            }
            $this->queryBuilderWhere .= ' GROUP BY ' . $groups;
        }else{
            $this->queryBuilderWhere .= ' GROUP BY ' . $columns;
        }
        return $this;
    }

    public function limit($start,$length=NULL){
        $this->queryBuilderWhere .= ' LIMIT '.($length!=NULL?$start.",".$length:$start);
        return $this;
    }

    public function exists() {
        $sql = DB::Query(MysqlTable::getQuery());
        if(!$sql){
            MysqlTable::resetQueryBuilder();
            return FALSE;
        }
        if ($res = mysqli_fetch_array($sql)){
            MysqlTable::resetQueryBuilder();
            return true;
        }
        MysqlTable::resetQueryBuilder();
        return false;
    }

    public function result($mode='rows'){
        $sql = DB::Query(MysqlTable::getQuery());
        $record = array();
        if($sql)
            if($mode=='rows'){
                while ($data = mysqli_fetch_assoc($sql)) {
                    $record[] = $data;
                }
            }elseif ($mode=='row'){
                if ($data = mysqli_fetch_assoc($sql)) {
                    $record = $data;
                }
            }
        MysqlTable::resetQueryBuilder();
        return $record;
    }

    public function get(){
      $sql = DB::Query(MysqlTable::getQuery());
      $record = array();
      if($sql)
        while ($data = mysqli_fetch_assoc($sql)) {
            $record[] = (object) $data;
        }
      MysqlTable::resetQueryBuilder();
      if($record)
        return $record;
      return FALSE;
    }

    public function first(){
      $sql = DB::Query(MysqlTable::getQuery());
      $record = array();
      if($sql)
        if ($data = mysqli_fetch_assoc($sql)) {
            $record = $data;
        }
      MysqlTable::resetQueryBuilder();
      if($record)
        return (object) $record;
      return FALSE;
    }

    public function insert($dataArray) {
        $columns = '';
        $values = '';
        if ($dataArray) {
            foreach ($dataArray as $key => $value) {
                if ($columns == '') {
                    $columns = $columns . $key;
                } else {
                    $columns = $columns . "," . $key;
                }
                if ($values == '') {
                    $values = $values . "'" . $value . "'";
                } else {
                    $values = $values . ",'" . $value . "'";
                }
            }
            DB::Query("insert into `" . $this->tableName . "` (" . $columns . ") values (" . $values . ");");
            $id = @mysqli_insert_id();
            self::resetQueryBuilder();
            return $id;
        } else {
            self::resetQueryBuilder();
            return false;
        }
        self::resetQueryBuilder();
        return false;
    }

    public function update($dataArray, $matchArray) {
        $updates = '';
        $matches = '';
        if ($dataArray && $matchArray) {
            foreach ($dataArray as $key => $value) {
                if ($updates == '') {
                    $updates = $updates . $key . "='" . $value . "'";
                } else {
                    $updates = $updates . "," . $key . "='" . $value . "'";
                }
            }
            foreach ($matchArray as $key => $value) {
                if ($matches == '') {
                    $matches = $matches . $key . "='" . $value . "'";
                } else {
                    $matches = $matches . " and " . $key . "='" . $value . "'";
                }
            }
            $tempQuery = "update `" . $this->tableName . "` set " . $updates . " where " . $matches;
            $response = DB::Query($tempQuery);
            self::resetQueryBuilder();
            return $response;
        } else {
            self::resetQueryBuilder();
            return false;
        }
        self::resetQueryBuilder();
        return false;
    }

    public function delete($matchArray) {
        $matches = '';
        if ($matchArray) {
            foreach ($matchArray as $key => $value) {
                if ($matches == '') {
                    $matches = $matches . $key . "='" . $value . "'";
                } else {
                    $matches = $matches . " and " . $key . "='" . $value . "'";
                }
            }
            $queryString = "delete from `" . $this->tableName . "` where " . $matches;
            $response = DB::Query($queryString);
            self::resetQueryBuilder();
            return $response;
        } else {
            self::resetQueryBuilder();
            return false;
        }
        self::resetQueryBuilder();
        return false;
    }

    public function getPK(){
        $key = '';
        $pkQuery = DB::Query("SHOW KEYS FROM ".$this->tableName." WHERE Key_name = 'PRIMARY'");
        if($pkQuery){
            while ($data = mysqli_fetch_assoc($pkQuery)) {
                $key = $data['Column_name'];
                break;
            }
        }
        self::resetQueryBuilder();
        return $key;
    }

    public function truncate() {
        DB::Query("truncate table `" . $this->tableName . "`");
        self::resetQueryBuilder();
        return true;
    }

}