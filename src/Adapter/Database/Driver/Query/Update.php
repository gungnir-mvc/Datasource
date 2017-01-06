<?php
namespace Gungnir\DataSource\Adapter\Database\Driver\Query;

class Update extends Common 
{

	private $set = [];

	public function getQuery() : QueryObject
	{
		$query = new QueryObject;
		$query->concat('UPDATE ' . $this->table());
		$this->addSet($query);
		parent::getQuery($query);
		return $query;
	}

	public function set(String  $key, $value)
	{
		if (is_string($value)) {
			$value = trim($value, "'");
		}
		$this->set[$key] = $value;
		return $this;
	}

	private function addSet(QueryObject $query)
	{
		$counter = 0;
		foreach ($this->set AS $columnIndex => $columnValue) {
			$columnAlias = ':' . $columnIndex;
			$query->addParameter($columnAlias, $columnValue);
			if ($counter == 0) {
				$query->concat('SET ' . $columnIndex . '=' . $columnAlias);
			} else {
				$query->concat(', ' . $columnIndex . '=' . $columnAlias);
			}
			$counter++;
		}
	}

}