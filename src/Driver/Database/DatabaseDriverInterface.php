<?php
namespace Gungnir\DataSource\Driver\Database;

use Gungnir\Core\Config;
use Gungnir\DataSource\Driver\Database\Query\QueryObject;
use Gungnir\DataSource\Factory\ConnectionFactory;

interface DatabaseDriverInterface 
{
    /**
     * DatabaseDriverInterface constructor.
     *
     * @param Config $config
     * @param ConnectionFactory $connectionFactory
     */
	public function __construct(Config $config, ConnectionFactory $connectionFactory);

    /**
     * Get or set the database configuration
     *
     * @param Config|null $config
     *
     * @return mixed
     */
	public function config(Config $config = null);

    /**
     * Executes a query towards the database
     *
     * @param QueryObject $query
     *
     * @return mixed
     */
	public function execute(QueryObject $query);

    /**
     * Executes a query towards the database
     *
     * @param QueryObject $query
     *
     * @return mixed
     */
	public function query(QueryObject $query);

}