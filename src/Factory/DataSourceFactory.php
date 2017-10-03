<?php
namespace Gungnir\DataSource\Factory;

use \Gungnir\Core\Config;
use \Gungnir\DataSource\Adapter\{Database};
use Gungnir\DataSource\DataSource;
use Gungnir\DataSource\DataSourceInterface;

class DataSourceFactory
{
	/**
	 * Creates a instance of data source which uses database
	 * as adapter which get driver based on passed config.
	 * 	
	 * @param  Config $config Configuration to build data source from
	 * 
	 * @return DataSourceInterface
	 */
	public function makeDatabaseDataSource(Config $config) : DataSourceInterface
	{
		$driverFactory = new DatabaseDriverFactory;
		$driver 	   = $driverFactory->getDriverByConfig($config);
		$adapter 	   = new Database($driver);
		$dataSource    = new DataSource($adapter);

		return $dataSource;
	}

	/**
	 * Determine type of data source from config and then
	 * makes it.
	 * 
	 * @param  Config $config The Config
	 *                        
	 * @return DataSourceInterface
	 */
	public function makeDataSource(Config $config) : DataSourceInterface
	{
        return $this->makeDatabaseDataSource($config);
	}
}