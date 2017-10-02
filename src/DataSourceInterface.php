<?php
namespace Gungnir\DataSource;

use \Gungnir\DataSource\Adapter\DataSourceAdapterInterface;
use Gungnir\DataSource\Operation\DataSourceDeleteOperationInterface;
use Gungnir\DataSource\Operation\DataSourceInsertOperationInterface;
use Gungnir\DataSource\Operation\DataSourceSelectOperationInterface;
use Gungnir\DataSource\Operation\DataSourceUpdateOperationInterface;

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