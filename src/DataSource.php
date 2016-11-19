<?php
namespace Gungnir\DataSource;

use \Gungnir\DataSource\Adapter\DataSourceAdapterInterface;

/**
 * @package Gungnir\DataSource
 */
class DataSource implements DataSourceInterface
{
	/** @var DataSourceAdapter [description] */
	private $adapter = null;

	/**
	 * Constructor
	 * 
	 * @param DataSourceAdapterInterface $adapter
	 */
	public function __construct(DataSourceAdapterInterface $adapter)
	{
		$this->setDataSourceAdapter($adapter);
	}

	/**
	 * Set the DataSourceAdapter for this DataSource
	 * 
	 * @param DataSourceAdapterInterface $adapter
	 */
	public function setDataSourceAdapter(DataSourceAdapterInterface $adapter)
	{
		$this->adapter = $adapter;
	}

	/**
	 * Get the DataSourceDriver for this DataSource
	 * 
	 * @return DataSourceAdapterInterface
	 */
	public function getDataSourceAdapter() : DataSourceAdapterInterface
	{
		return $this->adapter;
	}

	/**
	 * Returns a select statement object
	 * 
	 * @return DataSourceOperation
	 */
	public function select(String $select, String $from = null)
	{
		return $this->getDataSourceAdapter()->select($select, $from);
	}

	/**
	 * Returns an insert statement object
	 * 
	 * @return DataSourceOperation
	 */
	public function insert()
	{
		return $this->getDataSourceAdapter()->insert();
	}

	/**
	 * Returns an update statement object
	 * 
	 * @return DataSourceOperation
	 */
	public function update()
	{
		return $this->getDataSourceAdapter()->update();
	}

	/**
	 * Returns a delete statement object
	 * 
	 * @return DataSourceOperation
	 */
	public function delete()
	{
		return $this->getDataSourceAdapter()->delete();
	}
}