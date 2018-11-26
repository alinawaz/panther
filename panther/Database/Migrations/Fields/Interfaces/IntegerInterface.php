<?php
namespace Panther\Database\Migrations\Fields\Interfaces;

interface IntegerInterface
{

	public function get();

	public function default($value);

	public function optional();

	public function required();

}