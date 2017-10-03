<?php
namespace Gungnir\DataSource\Factory;

use \Gungnir\Core\Config;
use \Gungnir\DataSource\Adapter\DataSourceAdapterDriverInterface;
use \Gungnir\DataSource\Driver\Database\{Sqlite, Mysql};

class DatabaseDriverFactory
{

	/**
	 * Determine type of driver and builds it based
	 * on passed configuration.
	 * 
	 * @param  Config $config The config
	 * 
	 * @return DataSourceAdapterDriverInterface
	 */
	public function getDriverByConfig(Config $config)
	{
		$driver = null;
		switch ($config->get('driver')) {
			case 'mysql':
				$driver = $this->makeMysqlDriver($config);
				break;
			default:
				$driver = $this->makeSqliteDriver($config);
				break;
		}
		return $driver;
	}

	/**
	 * Creates an Sqlite driver by config and returns
	 * it.
	 * 
	 * @param  Config $config The config to use
	 * 
	 * @return DataSourceAdapterDriverInterface
	 */
	public function makeSqliteDriver(Config $config)
	{
		return new Sqlite($config);
	}

	/**
	 * Creates an Mysql driver by config and returns
	 * it.
	 * 
	 * @param  Config $config The config to use
	 * 
	 * @return DataSourceAdapterDriverInterface
	 */
	public function makeMysqlDriver(Config $config)
	{
		return new Mysql($config);
	}
}
