<?php
namespace Gungnir\DataSource\Adapter\Database;

class PrimaryKey 
{	
	/** @var String Name of primary key */
	private $name = null;

	public function __construct(String $name)
	{
		$this->name = $name;
	}

	public function __toString()
	{
		return $this->getName();
	}

	/**
	 * Returns the registered name
	 * 	
	 * @return String
	 */
	public function getName() : String
	{
		return $this->name;
	}
}