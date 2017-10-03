<?php
namespace Gungnir\DataSource\Adapter;

use Gungnir\DataSource\Operation\DataSourceDeleteOperationInterface;
use Gungnir\DataSource\Operation\DataSourceInsertOperationInterface;
use Gungnir\DataSource\Operation\DataSourceSelectOperationInterface;
use Gungnir\DataSource\Operation\DataSourceUpdateOperationInterface;

class Database implements DataSourceAdapterInterface
{
	/** @var DataSourceAdapterDriverInterface The current database driver used */
	private $driver = null;

	/** @var Database[] All instances of database connections existing currently */
	private static $instances = [];

	/**
	 * Constructor
	 * 
	 * @param DataSourceAdapterDriverInterface $driver The desired driver to use
	 */
	public function __construct(DataSourceAdapterDriverInterface $driver)
	{
		$this->setDataSourceAdapterDriver($driver);
		self::$instances[$driver->config()->get('parent')] = $this;
	}

	/**
	 * Set the driver for this adapter
	 * 
	 * @param DataSourceAdapterDriverInterface $driver
	 */
	public function setDataSourceAdapterDriver(DataSourceAdapterDriverInterface $driver)
	{
		$this->driver = $driver;
	}

	/**
	 * Get the driver for this adapter
	 * 
	 * @return DataSourceAdapterDriverInterface
	 */
	public function getDataSourceAdapterDriver() : DataSourceAdapterDriverInterface
	{
		return $this->driver;
	}

	/**
	 * Get a database instance based on name of connection
	 * 
	 * @param  String $source Name of connection
	 * 
	 * @return Database|Null
	 */
	public static function instance(String $source)
	{
		if (isset(static::$instances[$source])) {
			return static::$instances[$source];
		}

		return null;
	}

	/**
	 * Executes a raw query against the database
	 * 
	 * @param String $query The query to run
	 * 
	 * @return mixed
	 */
	public function execute(String $query)
	{
		return $this->getDataSourceAdapterDriver()->execute($query);
	}

	/**
	 * Executes a prepared query against the database
	 * 
	 * @param  String $query The query to run
	 * 
	 * @return mixed
	 */
	public function query(String $query)
	{
		return $this->getDataSourceAdapterDriver()->query($query);
	}

	/**
	 * Builds and returns a select operation object
	 * 
	 * @param  String      $string 
	 * @param  String|null $table  
	 * 
	 * @return DataSourceSelectOperationInterface
	 */
	public function select(String $string, String $table = null)
	{
		return $this->getDataSourceAdapterDriver()->select($string, $table);
	}

	/**
	 * Builds and returns an insert operation object
	 * 
	 * @return DataSourceInsertOperationInterface
	 */
	public function insert()
	{
		return $this->getDataSourceAdapterDriver()->insert();
	}

	/**
	 * Builds and returns a delete operation object
	 * 
	 * @return DataSourceDeleteOperationInterface
	 */
	public function delete()
	{
		return $this->getDataSourceAdapterDriver()->delete();
	}

	/**
	 * Builds and returns an update operation object
	 * 
	 * @return DataSourceUpdateOperationInterface
	 */
	public function update()
	{
		return $this->getDataSourceAdapterDriver()->update();
	}
}
