<?php
namespace Gungnir\DataSource\Adapter\Database\Driver\Query;
class QueryObject 
{
	private $queryString = "";
	private $parameters  = [];

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

	public function addParameter(String $parameterKey, $parameterValue)
	{
		if ($parameterKey === '?') {
			$this->parameters['?'] = (isset($this->parameters['?'])) ? array_merge($this->parameters['?'], [$parameterValue]) : [$parameterValue];
		} else {
			$this->parameters[$parameterKey] = $parameterValue;
		}
		
		return $this;
	}

	public function getParameters()
	{
		return $this->parameters;
	}
}