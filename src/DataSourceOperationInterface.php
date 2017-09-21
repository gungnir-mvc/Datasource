<?php
namespace Gungnir\DataSource;

interface DataSourceOperationInterface 
{
    /**
     * Retrieve one entity from data source
     *
     * @return DataSourceEntityInterface|null
     */
    public function fetch(): ?DataSourceEntityInterface;

    /**
     * Retrieve all valid entities from data source
     *
     * @return DataSourceEntityInterface[]
     */
    public function fetchAll();

	/**
	 * Runs the operation and returns the result
	 * 
	 * @return mixed
	 */
	public function execute();
}