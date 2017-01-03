<?php
namespace Gungnir\DataSource\Adapter\Database\Driver\Query;

interface QueryInterface 
{
	/**
	 * Compiles the query which will be executed against
	 * the database.
	 * 
	 * @return QueryObject The compiled query
	 */
	public function getQuery() : QueryObject;
}