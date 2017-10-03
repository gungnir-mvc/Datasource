<?php
namespace Gungnir\DataSource\Driver\Database\Query;

interface QueryInterface 
{
    /**
     * Compiles the query which will be executed against
     * the database.
     *
     * @param QueryObject|null $query
     *
     * @return QueryObject The compiled query
     */
	public function getQuery(QueryObject $query = null) : QueryObject;
}