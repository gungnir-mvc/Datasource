<?php
namespace Gungnir\DataSource\Adapter\Database\Driver\Query;
class QueryObject 
{
	private $queryString = "";

	public function __toString()
	{
		return $this->getString();
	}

	public function getString()
	{
		return $this->queryString;
	}

	public function concat(String $string) 
	{
		$this->queryString .= " " . trim($string, " ") . " ";
		return $this;
	}
}