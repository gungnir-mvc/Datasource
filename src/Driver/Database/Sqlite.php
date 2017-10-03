<?php
namespace Gungnir\DataSource\Driver\Database;

use Gungnir\Core\Config;
use Gungnir\DataSource\Driver\Database\Query\QueryObject;

class Sqlite extends AbstractDriver
{
	/** @var Config */
	private $config = null;

	/** @var \PDO */
	private $connection = null;

	public function __construct(Config $config)
	{
		$this->connection = new \PDO('sqlite:' . $config->get("database") . '.db');
		$this->config = $config;
	}

	public function execute(QueryObject $query)
	{
		return $this->connection->exec($query);
	}

	public function query(QueryObject $query)
	{
		$sth = $this->connection->prepare($query);
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
