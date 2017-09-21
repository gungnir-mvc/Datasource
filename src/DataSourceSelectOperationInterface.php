<?php
namespace Gungnir\DataSource;


interface DataSourceSelectOperationInterface extends DataSourceOperationInterface
{
    /**
     * @param String $select
     *
     * @return DataSourceSelectOperationInterface
     */
    public function select(String $select): DataSourceSelectOperationInterface;

    /**
     * Retrieval will map data to instances of given class name.
     *
     * @param String $className
     *
     * @return DataSourceSelectOperationInterface
     */
    public function fetchClass(string $className): DataSourceSelectOperationInterface;

    /**
     * Retrieves data as anonymous objects
     *
     * @return DataSourceSelectOperationInterface
     */
    public function fetchObject(): DataSourceSelectOperationInterface;

    /**
     * Sets the retrieval to be of associative type
     *
     * @return $this
     */
    public function fetchAssoc(): DataSourceSelectOperationInterface;
}