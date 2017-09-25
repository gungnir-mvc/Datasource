<?php
namespace Gungnir\DataSource;

use \Gungnir\Core\Config;
use \Gungnir\DataSource\Adapter\Api\Driver\Rest;
use \Gungnir\DataSource\Adapter\{Database, Api};
use \Gungnir\DataSource\Adapter\Database\DatabaseDriverFactory;

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
	 * Creates a instance of datasource which uses api
	 * as adapter which get driver based on passed config.
	 * 	
	 * @param  Config $config Configuration to build data source from
	 * 
	 * @wip
	 * 
	 * @return DataSourceInterface
	 */
	public function makeApiDataSource(Config $config) : DataSourceInterface 
	{
		$driver = new Rest;
		return new DataSource(new Api($driver));
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
		switch ($config->get('type')) {
			case 'api':
				$dataSource = $this->makeApiDataSource($config);
				break;
			default:
				$dataSource = $this->makeDatabaseDataSource($config);
				break;
		}

		return $dataSource;
	}
}