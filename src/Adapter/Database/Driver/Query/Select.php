<?php
namespace Gungnir\DataSource\Adapter\Database\Driver\Query;

use Gungnir\DataSource\DataSourceEntity;
use Gungnir\DataSource\DataSourceEntityCollection;
use Gungnir\DataSource\DataSourceEntityCollectionInterface;
use Gungnir\DataSource\DataSourceEntityInterface;

class Select extends Common
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
     * @param String $select
     *
     * @return $this
     */
	public function select(String $select)
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
			return ($queryResult) ? $queryResult->fetch() : null;
		}
		$data = ($queryResult) ? $queryResult->fetch($this->getFetchMode()) : null;
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
			return ($queryResult) ? $queryResult->fetchAll() : [];
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
     * Retrieval will map data to instances of given class name.
     *
     * @param String $className
     *
     * @return $this
     */
	public function fetchClass(string $className)
	{
		$this->fetchMode = 'class';
		$this->fetchClassName = $className;
		return $this;
	}

    /**
     * Retrieves data as anonymous objects
     *
     * @return $this
     */
	public function fetchObject()
	{
		$this->fetchMode = 'object';
		return $this;
	}

    /**
     * Sets the retrieval to be of associative type
     *
     * @return $this
     */
	public function fetchAssoc()
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
