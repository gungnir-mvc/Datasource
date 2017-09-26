<?php
namespace Gungnir\DataSource\Adapter\Database\Driver\Query;

use Gungnir\DataSource\DataSourceEntity;
use Gungnir\DataSource\DataSourceEntityCollection;
use Gungnir\DataSource\DataSourceEntityCollectionInterface;
use Gungnir\DataSource\DataSourceEntityInterface;
use Gungnir\DataSource\Operation\DataSourceSelectOperationInterface;

class Select extends Common implements DataSourceSelectOperationInterface
{
    /** @var string */
	private $fetchMode = null;

	/** @var string */
	private $fetchClassName = 'stdClass';

	/** @var string[] */
	private $select = [];

    /**
     * Select constructor.
     *
     * @param String $select
     */
	public function __construct(String $select)
	{
		$this->select($select);
	}

    /**
     * {@inheritdoc}
     */
	public function select(String $select): DataSourceSelectOperationInterface
	{
		$this->select[] = $select;
		return $this;
	}

    /**
     * {@inheritdoc}
     */
	public function fetch(): ?DataSourceEntityInterface
	{
		$queryResult = $this->execute();
		if (in_array($this->fetchMode, ['class'])) {
			$queryResult->setFetchMode($this->getFetchMode(), $this->fetchClassName);
			return (!is_null($queryResult)) ? new DataSourceEntity($queryResult->fetch()) : null;
		}
		$data = (!is_null($queryResult)) ? $queryResult->fetch($this->getFetchMode()) : null;
		return ($data) ? new DataSourceEntity($data) : $data;
	}

    /**
     * {@inheritdoc}
     */
	public function fetchAll(): DataSourceEntityCollectionInterface
	{
		$queryResult = $this->execute();
		if (in_array($this->fetchMode, ['class'])) {
			$queryResult->setFetchMode($this->getFetchMode(), $this->fetchClassName);
			$collection = new DataSourceEntityCollection();
			if ($queryResult) {
			    foreach ($queryResult->fetchAll() as $row) {
			        $collection->push(new DataSourceEntity($row));
                }
            }
			return $collection;
		}
        $queryData = ($queryResult) ? $queryResult->fetchAll($this->getFetchMode()) : [];
		$result = new DataSourceEntityCollection();
        foreach ($queryData AS $data) $result->push(new DataSourceEntity($data));
        return $result;
	}

    /**
     * {@inheritdoc}
     */
	public function getQuery(QueryObject $query = null): QueryObject
	{
		$query  = $query ? $query : new QueryObject();
		$query->concat(
		    "SELECT " . implode(', ', $this->select) . " FROM ".$this->table()
        );
		parent::getQuery($query);
		return $query;
	}

    /**
     * {@inheritdoc}
     */
	public function fetchClass(string $className): DataSourceSelectOperationInterface
	{
		$this->fetchMode = 'class';
		$this->fetchClassName = $className;
		return $this;
	}

    /**
     * {@inheritdoc}
     */
	public function fetchObject(): DataSourceSelectOperationInterface
	{
		$this->fetchMode = 'object';
		return $this;
	}

    /**
     * {@inheritdoc}
     */
	public function fetchAssoc(): DataSourceSelectOperationInterface
	{
		$this->fetchMode = 'assoc';
		return $this;
	}

    /**
     * Translates string representation of fetching modes and returns
     * the PDO integer representation of it.
     *
     * By default data will be fetched in assoc mode
     *
     * @return int
     */
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
