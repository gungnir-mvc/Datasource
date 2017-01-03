<?php
namespace Gungnir\DataSource\Adapter\Database\Driver;

use Gungnir\Core\Config as Config;
use Gungnir\DataSource\Adapter\Database\Driver\Query\QueryObject;

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

	public function execute(QueryObject $query)
	{
		return $this->query($query);	
	}

	public function query(QueryObject $query)
	{
		$sth = $this->connection->prepare($query->getString());
		foreach ($query->getParameters() AS $key => $value) {
			if ($key == '?') {
				$sth->bindValue(str_repeat('s', count($value)), $value);
			} else {
				$sth->bindValue($key, $value, \PDO::PARAM_STR);
			}
		}
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