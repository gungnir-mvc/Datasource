<?php
namespace Gungnir\DataSource;

use \Gungnir\DataSource\Adapter\DataSourceAdapterInterface;
use \Gungnir\DataSource\Operation\DataSourceOperationInterface;

/**
 * Interface for any kind of data source.
 * This will help to abstract knowledge on where
 * the data comes from. Be it a database or an api
 */
interface DataSourceInterface 
{
	/**
	 * Set the DataSourceAdapter for this DataSource
	 * 
	 * @param DataSourceAdapterInterface $adapter
	 */
	public function setDataSourceAdapter(DataSourceAdapterInterface $adapter);

	/**
	 * Get the DataSourceDriver for this DataSource
	 * 
	 * @return DataSourceAdapterInterface
	 */
	public function getDataSourceAdapter() : DataSourceAdapterInterface;

    /**
     * Returns a select statement object
     *
     * @param string      $select
     * @param string|null $from
     *
     * @return DataSourceOperationInterface
     */
	public function select(string $select, string $from = null);

	/**
	 * Returns an insert statement object
	 * 
	 * @return DataSourceOperationInterface
	 */
	public function insert();

	/**
	 * Returns an update statement object
	 * 
	 * @return DataSourceOperationInterface
	 */
	public function update();

	/**
	 * Returns a delete statement object
	 * 
	 * @return DataSourceOperationInterface
	 */
	public function delete();
}