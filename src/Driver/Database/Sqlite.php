<?php
namespace Gungnir\DataSource\Driver\Database;

use Gungnir\Core\Config;
use Gungnir\DataSource\Driver\Database\Query\QueryObject;
use Gungnir\DataSource\Factory\ConnectionFactory;

class Sqlite extends AbstractDriver
{
	/** @var Config */
	private $config = null;

	/** @var \PDO */
	private $connection = null;

    /**
     * Sqlite constructor.
     *
     * @param Config $config
     * @param ConnectionFactory $connectionFactory
     */
	public function __construct(Config $config, ConnectionFactory $connectionFactory)
	{
		$this->connection = $connectionFactory->makePdoConnection('sqlite:' . $config->get("database") . '.db');
		$this->config = $config;
	}

    /**
     * @param QueryObject $query
     * @return mixed|\PDOStatement
     */
	public function execute(QueryObject $query)
	{
		return $this->query($query);
	}

    /**
     * @param QueryObject $query
     * @return \PDOStatement
     */
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
