<?php
namespace Gungnir\DataSource\Driver\Database\Query;

use Gungnir\DataSource\Operation\DataSourceUpdateOperationInterface;

class Update extends Common implements DataSourceUpdateOperationInterface
{
	private $set = [];

    /**
     * {@inheritdoc}
     */
	public function set(String  $key, $value)
	{
		if (is_string($value)) {
			$value = trim($value, "'");
		}
		$this->set[$key] = $value;
		return $this;
	}

    /**
     * {@inheritdoc}
     */
    public function getQuery(QueryObject $query = null) : QueryObject
    {
        $query = $query ? $query : new QueryObject;
        $query->concat('UPDATE ' . $this->table());
        $this->addSet($query);
        parent::getQuery($query);
        return $query;
    }

    /**
     * Adds set parts to the query object
     *
     * @param QueryObject $query
     */
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