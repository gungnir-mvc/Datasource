<?php
namespace Gungnir\DataSource\Adapter;

interface DataSourceAdapterInterface 
{
	/**
	 * Set the driver for this adapter
	 * 
	 * @param DataSourceAdapterDriverInterface $driver
	 */
	public function setDataSourceAdapterDriver(DataSourceAdapterDriverInterface $driver);

	/**
	 * Get the driver for this adapter
	 * 
	 * @return DataSourceAdapterDriverInterface
	 */
	public function getDataSourceAdapterDriver() : DataSourceAdapterDriverInterface;

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