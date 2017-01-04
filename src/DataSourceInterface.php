<?php
namespace Gungnir\DataSource;

use \Gungnir\DataSource\Adapter\DataSourceAdapterInterface;

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
	 * @return DataSourceOperation
	 */
	public function select(String $select, String $from = null);

	/**
	 * Returns an insert statement object
	 * 
	 * @return DataSourceOperation
	 */
	public function insert();

	/**
	 * Returns an update statement object
	 * 
	 * @return DataSourceOperation
	 */
	public function update();

	/**
	 * Returns a delete statement object
	 * 
	 * @return DataSourceOperation
	 */
	public function delete();
}