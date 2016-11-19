<?php
namespace Gungnir\DataSource\Adapter\Database\Driver\Query;

class Delete extends Common 
{
	public function getQuery() : String
	{
		$query = new QueryObject;
		$query->concat('DELETE FROM '.$this->table());
		parent::getQuery($query);
		return $query;
	}

}