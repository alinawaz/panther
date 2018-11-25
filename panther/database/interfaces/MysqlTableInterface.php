<?php

namespace Panther\Database\Interfaces;

interface MysqlTableInterface {

	public function getLastQuery();

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

    public function exists();

    public function result($mode);

    public function get();

    public function first();

    public function insert($dataArray);

    public function update($dataArray, $matchArray);

    public function delete($matchArray);

    public function getPK();

    public function truncate();
	
}