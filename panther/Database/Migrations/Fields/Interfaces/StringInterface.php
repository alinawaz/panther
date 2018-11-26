<?php
namespace Panther\Database\Migrations\Fields\Interfaces;

interface StringInterface
{

	public function get();

	public function default($value);

	public function optional();

	public function required();

}