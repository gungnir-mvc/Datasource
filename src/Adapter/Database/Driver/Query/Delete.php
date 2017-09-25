<?php
namespace Gungnir\DataSource\Adapter\Database\Driver\Query;

use Gungnir\DataSource\Operation\DataSourceDeleteOperationInterface;

class Delete extends Common  implements DataSourceDeleteOperationInterface
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