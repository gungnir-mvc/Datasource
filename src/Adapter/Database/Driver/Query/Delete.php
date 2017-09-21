<?php
namespace Gungnir\DataSource\Adapter\Database\Driver\Query;

class Delete extends Common 
{
    /**
     * {@inheritdoc}
     */
	public function getQuery(QueryObject $query = null) : QueryObject
	{
		$query = $query ? $query : new QueryObject;
		$query->concat('DELETE FROM '.$this->table());
		parent::getQuery($query);
		return $query;
	}

}