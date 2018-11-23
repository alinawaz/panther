<?php

namespace Panther\Database\Interfaces;

interface MysqlTableInterface {

	public static function getLastQuery();

    public function with($table,$joinType);

    public function join($table,$joinType);

    public function on($arrayOrColumnName, $columnValue, $conditionType);

    public function select($queryString);

    public function orWhere($arrayOrColumnName, $columnValue);

    public function andWhere($arrayOrColumnName, $columnValue);

    public function where($arrayOrColumnName, $columnValue, $conditionType);

    public function whereRaw($arrayOrColumnName, $columnValue, $conditionType);

    public function orderBy($columns,$order);

    public function groupBy($columns);

    public function limit($start,$length);

    public static function exists();

    public static function result($mode);

    public static function get();

    public static function first();

    public static function insert($dataArray);

    public static function update($dataArray, $matchArray);

    public static function delete($matchArray);

    public static function getPK();

    public static function truncate();
	
}