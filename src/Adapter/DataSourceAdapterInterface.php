<?php
namespace Gungnir\DataSource\Adapter;

use Gungnir\DataSource\Operation\{
    DataSourceDeleteOperationInterface,
    DataSourceInsertOperationInterface,
    DataSourceSelectOperationInterface,
    DataSourceUpdateOperationInterface
};

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
     * @param string      $select
     * @param string|null $from
     *
     * @return DataSourceSelectOperationInterface
     */
	public function select(string $select, string $from = null);

	/**
	 * Returns an insert statement object
	 * 
	 * @return DataSourceInsertOperationInterface
	 */
	public function insert();

	/**
	 * Returns an update statement object
	 * 
	 * @return DataSourceUpdateOperationInterface
	 */
	public function update();

	/**
	 * Returns a delete statement object
	 * 
	 * @return DataSourceDeleteOperationInterface
	 */
	public function delete();
}