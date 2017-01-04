<?php
namespace Gungnir\DataSource\Adapter\Database\Driver\Query;

class Select extends Common
{
	private $fetchMode = null;
	private $fetchClassName = 'stdClass';
	private $driver = null;
	private $select = [];

	public function __construct(String $select)
	{
		$this->select($select);
	}

	public function select(String $select)
	{
		$this->select[] = $select;
		return $this;
	}

	public function fetch()
	{
		$result = $this->execute();
		if (in_array($this->fetchMode, ['class'])) {
			$result->setFetchMode($this->getFetchMode(), $this->fetchClassName);
			return ($result) ? $result->fetch() : false;
		}
		return ($result) ? $result->fetch($this->getFetchMode()) : false;
	}

	public function fetchAll()
	{
		$result = $this->execute();
		if (in_array($this->fetchMode, ['class'])) {
			$result->setFetchMode($this->getFetchMode(), $this->fetchClassName);
			return ($result) ? $result->fetchAll() : false;
		}
		return ($result) ? $result->fetchAll($this->getFetchMode()) : false;
	}

	public function getQuery() : QueryObject
	{
		$query  = new QueryObject;
		$query->concat("SELECT " . implode(', ', $this->select));
		$query->concat("FROM ".$this->table());
		parent::getQuery($query);
		return $query;
	}

	public function fetchClass(String $classname)
	{
		$this->fetchMode = 'class';
		$this->fetchClassName = $classname;
		return $this;
	}

	public function fetchObject()
	{
		$this->fetchMode = 'object';
		return $this;
	}

	public function fetchAssoc()
	{
		$this->fetchMode = 'assoc';
		return $this;
	}

	private function getFetchMode()
	{
		switch ($this->fetchMode) {
			case 'named':
				$mode = \PDO::FETCH_NAMED;
				break;
			case 'object':
				$mode = \PDO::FETCH_OBJ;
				break;
			case 'class':
				$mode = \PDO::FETCH_CLASS;
				break;
			case 'array':
				$mode = \PDO::FETCH_NUM;
				break;
			case 'assoc':
			// Fall through to default
			default:
				$mode = \PDO::FETCH_ASSOC;
				break;
		}
		return $mode;
	}

}
