<?php
namespace Gungnir\DataSource\Operation;

use Gungnir\DataSource\DataSourceEntityCollectionInterface;
use Gungnir\DataSource\DataSourceEntityInterface;

interface DataSourceSelectOperationInterface extends DataSourceCommonOperationInterface
{
    /**
     * @param string $select
     *
     * @return self
     */
    public function select(string $select);

    /**
     * Retrieval will map data to instances of given class name.
     *
     * @param string $className
     *
     * @return self
     */
    public function fetchClass(string $className);

    /**
     * Retrieves data as anonymous objects
     *
     * @return self
     */
    public function fetchObject();

    /**
     * Sets the retrieval to be of associative type
     *
     * @return $this
     */
    public function fetchAssoc();

    /**
     * @param string $column
     *
     * @return self
     */
    public function groupBy(string $column);

    /**
     * Sets the order of things in the universe
     *
     * @param string $column
     * @param string $type
     *
     * @return self
     */
    public function orderBy(string $column, string $type = 'DESC');

    /**
     * Retrieve one entity from data source
     *
     * @return DataSourceEntityInterface|null
     */
    public function fetch(): ?DataSourceEntityInterface;

    /**
     * Retrieve all valid entities from data source
     *
     * @return DataSourceEntityCollectionInterface
     */
    public function fetchAll(): DataSourceEntityCollectionInterface;
}