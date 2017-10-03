<?php
namespace Gungnir\DataSource\Driver\Database\Query;

use Gungnir\DataSource\Operation\DataSourceInsertOperationInterface;

class Create extends Common implements DataSourceInsertOperationInterface
{
    /** @var string[] */
	private $columns = array();

	/** @var mixed[] */
	private $values  = array();

    /**
     * {@inheritdoc}
     */
	public function into(string $target)
	{
		$this->table($target);
		return $this;
	}

    /**
     * {@inheritdoc}
     */
	public function columns(Array $columns)
	{
		foreach ($columns as $key => $column) {
			if (is_string($column)) {
					$columns[$key] = trim($column,"'`");
			}
		}
		$this->columns = $columns;
		return $this;
	}

    /**
     * {@inheritdoc}
     */
	public function values(Array $values)
	{
		foreach ($values as $key => $value) {
			if (is_string($value)) {
					$values[$key] = trim($value,"'");
			}
		}

		$this->values = $values;
		return $this;
	}

    /**
     * {@inheritdoc}
     */
	public function data(Array $data)
	{	
		$keys = array_keys($data);
		if (is_string(array_shift($keys))) {
			$this->columns(array_keys($data));
			$this->values(array_values($data));
		} else {
			$this->values($data);
		}

		return $this;
	}

    /**
     * {@inheritdoc}
     */
	public function getQuery(QueryObject $query = null) : QueryObject
	{
		$query = $query ? $query : new QueryObject;
		$query->concat('INSERT INTO '.$this->table());
		
		if (empty($this->columns) === false) {
			$query->concat('(');
			$columns = '';
			foreach($this->columns AS $column) {

				$columns .= ',`' . $column . '`';
			}
			$query->concat(trim($columns, ','));
			$query->concat(')');
		}
		$query->concat('VALUES(');
		$values = '';
		foreach ($this->values AS $columnIndex => $columnValue) {
			$columnAlias = isset($this->columns[$columnIndex]) ? ':' . $this->columns[$columnIndex] : '?';
			$query->addParameter($columnAlias, $columnValue);
			$values .= ',' . $columnAlias;
		}
		$query->concat(trim($values, ','));
		$query->concat(')');
		parent::getQuery($query);
		return $query;
	}

    /**
     * @return mixed
     */
	public function run()
	{
		return $this->execute();
	}
}