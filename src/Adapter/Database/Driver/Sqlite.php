<?php
namespace Gungnir\DataSource\Adapter\Database\Driver;

use Gungnir\Core\Config;

class Sqlite extends AbstractDriver
{
	/** @var Config */
	private $config = null;

	/** @var \PDO */
	private $connection = null;

	public function __construct(Config $config)
	{
		$this->connection = new \PDO('sqlite:' . $config->database . '.db');
		$this->config = $config;
	}

	public function execute(String $query)
	{
		return $this->connection->exec($query);
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
