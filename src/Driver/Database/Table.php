<?php
namespace Gungnir\DataSource\Driver\Database;

class Table 
{
	/** @var PrimaryKey */
	private $primaryKey = null;

	/** @var String Table name */
	private $name = null;

	public function __construct(String $name, String $primaryKey = null)
	{
		$primaryKey = $primaryKey ?? rtrim($name, 's') . '_id';
		$this->name($name);
		$this->key(new PrimaryKey($primaryKey));
	}

	/**
	 * Returns a string representation of this object
	 * 
	 * @return string Table name
	 */
	public function __toString()
	{
		return $this->name();
	}

	/**
	 * Get or set the primary key of this table
	 * 
	 * @param  PrimaryKey|null $primaryKey
	 * 
	 * @return PrimaryKey|Table
	 */
	public function key(PrimaryKey $primaryKey = null)
	{
		if ($primaryKey) {
			$this->primaryKey = $primaryKey;
			return $this;
		}
		return $this->primaryKey;
	}

	/**
	 * Get or set the name of this table
	 * 
	 * @param  String|null $name
	 * 
	 * @return String|Table
	 */
	public function name(String $name = null)
	{
		if ($name) {
			$this->name = $name;
			return $this;
		}

		return $this->name;
	}

}