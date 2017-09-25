<?php
namespace Gungnir\DataSource\Adapter\Database\Driver;

use Gungnir\Core\Config;
use Gungnir\DataSource\Adapter\Database\Driver\Query\QueryObject;

interface DatabaseDriverInterface 
{
    /**
     * DatabaseDriverInterface constructor.
     *
     * @param Config $config
     */
	public function __construct(Config $config);

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