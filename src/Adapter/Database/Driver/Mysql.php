<?php
namespace Gungnir\DataSource\Adapter\Database\Driver;

use Gungnir\Core\Config as Config;

class Mysql extends AbstractDriver 
{
	private $config = null;
	private $connection = null;

	public function __construct(Config $config)
	{
		$dsn = 'mysql:host=' . $config->hostname . ';dbname=' . $config->database . ';port=' . $config->port . ';charset=UTF8';
		$driver = new \PDO($dsn, $config->username, $config->password, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
		$this->connection = $driver;
		$this->config = $config;
	}

	public function execute(String $query)
	{
		return $this->query($query);	
	}

	public function query(String $query)
	{
		$sth = $this->connection->prepare($query);
		$sth->execute();
		return $sth;
	}

	public function config(Config $config = null)
	{
		if ($config) {
			$this->config = $config;
			return $this;
		}

		return $this->config;
	}

	public function getLastInsertedId()
	{
		return $this->connection->lastInsertId();
	}
}
