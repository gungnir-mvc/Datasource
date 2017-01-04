<?php
namespace Gungnir\DataSource\Adapter;

use Gungnir\DataSource\Adapter\Database\Driver\DatabaseDriverInterface;
use Gungnir\DataSource\DataSourceOperationInterface;

class Database implements DataSourceAdapterInterface
{
	/** @var DatabaseDriverInterface The current database driver used */
	private $driver = null;

	/** @var Database[] All instances of database connections existing currently */
	private static $instances = [];

	/**
	 * Constructor
	 * 
	 * @param DatabaseDriverInterface $driver The desired driver to use
	 */
	public function __construct(DatabaseDriverInterface $driver)
	{
		$this->setDataSourceAdapterDriver($driver);
		self::$instances[$driver->config()->parent] = $this;
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
	 * @return DataSourceOperationInterface
	 */
	public function select(String $string, String $table = null)
	{
		return $this->getDataSourceAdapterDriver()->select($string, $table);
	}

	/**
	 * Builds and returns an insert operation object
	 * 
	 * @return DataSourceOperationInterface
	 */
	public function insert()
	{
		return $this->getDataSourceAdapterDriver()->insert();
	}

	/**
	 * Builds and returns a delete operation object
	 * 
	 * @return DataSourceOperationInterface
	 */
	public function delete()
	{
		return $this->getDataSourceAdapterDriver()->delete();
	}

	/**
	 * Builds and returns an update operation object
	 * 
	 * @return DataSourceOperationInterface
	 */
	public function update()
	{
		return $this->getDataSourceAdapterDriver()->update();
	}
}