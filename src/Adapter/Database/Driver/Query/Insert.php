<?php
namespace Gungnir\DataSource\Adapter\Database\Driver\Query;
class Insert extends Common 
{
	private $columns = array();
	private $values  = array();

	public function into(String $table)
	{
		$this->table($table);
		return $this;
	}

	public function columns(Array $columns)
	{
		foreach ($columns as $key => $column) {
			if (is_string($column)) {
					$columns[$key] = "`".trim($column,"'`")."`";
			}
		}
		$this->columns = $columns;
		return $this;
	}

	public function values(Array $values)
	{
		foreach ($values as $key => $value) {
			if (is_string($value)) {
					$values[$key] = "'".trim($value,"'")."'";
			}
		}

		$this->values = $values;
		return $this;
	}

	public function data(Array $data)
	{
		if (is_string(array_shift(array_keys($data)))) {
			$this->columns(array_keys($data));
			$this->values(array_values($data));
		} else {
			$this->values($data);
		}

		return $this;
	}

	public function getQuery() : String
	{
		$query = new QueryObject;
		$query->concat('INSERT INTO '.$this->table());
		
		if (empty($this->columns) === false) {
			$query->concat('('.implode(', ', $this->columns).')');
		}

		$query->concat('VALUES('.implode(', ', $this->values).')');
		
		parent::getQuery($query);
		return $query;
	}

	public function run()
	{
		return parent::execute($this->getQuery());
	}
}