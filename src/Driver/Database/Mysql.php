<?php
namespace Gungnir\DataSource\Driver\Database;

use Gungnir\Core\Config as Config;
use Gungnir\DataSource\Driver\Database\Query\QueryObject;
use Gungnir\DataSource\Factory\ConnectionFactory;

class Mysql extends AbstractDriver 
{
    const CONNECTION_STRING = "mysql:host=%s;dbname=%s;port=%s;charset=UTF8";

    /** @var Config */
	private $config = null;

	/** @var \PDO  */
	private $connection = null;

    /**
     * Mysql constructor.
     *
     * @param Config $config
     * @param ConnectionFactory $connectionFactory
     */
	public function __construct(Config $config, ConnectionFactory $connectionFactory)
	{
		$dsn = sprintf(self::CONNECTION_STRING,
            $config->get('hostname'),
            $config->get('database'),
            $config->get('port')
        );

		$this->connection = $connectionFactory->makePdoConnection(
		    $dsn,
            $config->get('username'),
            $config->get('password'),
            [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            ]
        );

		$this->config = $config;
	}

    /**
     * @param QueryObject $query
     *
     * @return \PDOStatement
     */
	public function execute(QueryObject $query)
	{
		return $this->query($query);	
	}

    /**
     * @param QueryObject $query
     *
     * @return \PDOStatement
     */
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

    /**
     * @param Config|null $config
     *
     * @return $this|Config|null
     */
	public function config(Config $config = null)
	{
		if ($config) {
			$this->config = $config;
			return $this;
		}

		return $this->config;
	}

    /**
     * @return int
     */
	public function getLastInsertedId()
	{
		return (int) $this->connection->lastInsertId();
	}
}