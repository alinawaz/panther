<?php

namespace Panther\Database;

use Panther\Database\MysqlQuery as DB;
use Panther\Database\Interfaces\MysqlTableInterface;

class MysqlTable Implements MysqlTableInterface {

    private static $tableName = '';
    private static $queryBuilderString = '';
    private static $queryBuilderWhere = '';
    private static $queryBuilderAfterWhere = '';
    private static $lastQuery = '';
    private static $joinTable = '';

    function __construct($tableNameString) {
        MysqlTable::$tableName = $tableNameString;
        MysqlTable::$queryBuilderString .= "SELECT * FROM ".MysqlTable::$tableName;
        return $this;
    }

    public static function getLastQuery() {
      return MysqlTable::$lastQuery;
    }

    private static function getQuery(){
      return MysqlTable::$queryBuilderString.' '.MysqlTable::$queryBuilderWhere . ' ' . MysqlTable::$queryBuilderAfterWhere;
    }

    private static function resetQueryBuilder(){
      MysqlTable::$lastQuery = MysqlTable::$queryBuilderString.' '.MysqlTable::$queryBuilderWhere . ' ' . MysqlTable::$queryBuilderAfterWhere;
      MysqlTable::$queryBuilderString='';
      MysqlTable::$queryBuilderWhere='';
      MysqlTable::$queryBuilderAfterWhere='';
    }

    public function with($table,$joinType=''){
        MysqlTable::$queryBuilderWhere .= " ".$joinType." ".$joinType." JOIN ".$table." ON ".$table.".".MysqlTable::$tableName."_id=".MysqlTable::$tableName.".id ";
        return $this;
    }

    public function join($table,$joinType=''){
        MysqlTable::$joinTable = $table;
        MysqlTable::$queryBuilderWhere .= " ".$joinType." JOIN ".$table." ";
        return $this;
    }

    public function on($arrayOrColumnName, $columnValue=NULL, $conditionType = 'AND'){
      if(is_array($arrayOrColumnName)){
        $whereString = '';
        if ($arrayOrColumnName != null) {
            foreach ($arrayOrColumnName as $key => $value) {
                if ($whereString == "") {
                    $whereString = $whereString . " " . MysqlTable::$joinTable . "." . $key . "=" . MysqlTable::$tableName . "." . $value . " ";
                } else {
                    $whereString = $whereString . " ".$conditionType." " .MysqlTable::$joinTable . "." . $key . "=" .MysqlTable::$tableName . "." . $value . " ";
                }
            }
            MysqlTable::$queryBuilderWhere .= " ON ". $whereString;
        }
      }else{
        MysqlTable::$queryBuilderWhere .= ' ON '. MysqlTable::$joinTable . "." . $arrayOrColumnName . "=" . MysqlTable::$tableName . "." . $columnValue . " ";
      }
      return $this;
    }

    public function select($queryString){
      MysqlTable::$queryBuilderString = "SELECT ".$queryString." FROM ".MysqlTable::$tableName;
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
            MysqlTable::$queryBuilderWhere .= (MysqlTable::$queryBuilderWhere==''?' WHERE ':' OR ') . $whereString;
        }
      }else{
        MysqlTable::$queryBuilderWhere .= (MysqlTable::$queryBuilderWhere==''?' WHERE ':' OR ') . $arrayOrColumnName." = '".$columnValue."' ";
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
            MysqlTable::$queryBuilderWhere .= (MysqlTable::$queryBuilderWhere==''?' WHERE ':' AND ') . $whereString;
        }
      }else{
        MysqlTable::$queryBuilderWhere .= (MysqlTable::$queryBuilderWhere==''?' WHERE ':' AND ') . $arrayOrColumnName." = '".$columnValue."' ";
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
            MysqlTable::$queryBuilderWhere .= (MysqlTable::$queryBuilderWhere==''?' WHERE ':' '.$conditionType.' ') . $whereString;
        }
      }else{
        MysqlTable::$queryBuilderWhere .= (MysqlTable::$queryBuilderWhere==''?' WHERE ':' '.$conditionType.' ') . $arrayOrColumnName." = '".$columnValue."' ";
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
            MysqlTable::$queryBuilderWhere .= (MysqlTable::$queryBuilderWhere==''?' WHERE ':' '.$conditionType.' ') . $whereString;
        }
      }else{
        MysqlTable::$queryBuilderWhere .= (MysqlTable::$queryBuilderWhere==''?' WHERE ':' '.$conditionType.' ') . $arrayOrColumnName." ".$columnValue;
      }
      return $this;
    }

    public function orderBy($columns,$order = 'ASC'){
        if(is_array($columns)){
            $orders = '';
            for ($i=0; $i < count($columns); $i++) { 
                $orders .= ($orders==''?$columns[$i]:','.$columns[$i]);
            }
            MysqlTable::$queryBuilderWhere .= ' ORDER BY ' . $orders;
        }else{
            MysqlTable::$queryBuilderWhere .= ' ORDER BY ' . $columns . ' ' .$order;
        }
        return $this;
    }

    public function groupBy($columns){
        if(is_array($columns)){
            $groups = '';
            for ($i=0; $i < count($columns); $i++) { 
                $groups .= ($groups==''?$columns[$i]:','.$columns[$i]);
            }
            MysqlTable::$queryBuilderWhere .= ' GROUP BY ' . $groups;
        }else{
            MysqlTable::$queryBuilderWhere .= ' GROUP BY ' . $columns;
        }
        return $this;
    }

    public function limit($start,$length=NULL){
        MysqlTable::$queryBuilderWhere .= ' LIMIT '.($length!=NULL?$start.",".$length:$start);
        return $this;
    }

    public static function exists() {
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

    public static function result($mode='rows'){
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

    public static function get(){
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

    public static function first(){
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

    public static function insert($dataArray) {
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
            DB::Query("insert into `" . MysqlTable::$tableName . "` (" . $columns . ") values (" . $values . ");");
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

    public static function update($dataArray, $matchArray) {
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
            $tempQuery = "update `" . MysqlTable::$tableName . "` set " . $updates . " where " . $matches;
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

    public static function delete($matchArray) {
        $matches = '';
        if ($matchArray) {
            foreach ($matchArray as $key => $value) {
                if ($matches == '') {
                    $matches = $matches . $key . "='" . $value . "'";
                } else {
                    $matches = $matches . " and " . $key . "='" . $value . "'";
                }
            }
            $queryString = "delete from `" . MysqlTable::$tableName . "` where " . $matches;
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

    public static function getPK(){
        $key = '';
        $pkQuery = DB::Query("SHOW KEYS FROM entries WHERE Key_name = 'PRIMARY'");
        if($pkQuery){
            while ($data = mysqli_fetch_assoc($pkQuery)) {
                $key = $data['Column_name'];
                break;
            }
        }
        self::resetQueryBuilder();
        return $key;
    }

    public static function truncate() {
        DB::Query("truncate table `" . MysqlTable::$tableName . "`");
        self::resetQueryBuilder();
        return true;
    }

}