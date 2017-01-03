<?php
namespace Gungnir\DataSource\Adapter\Database\Driver;

use Gungnir\Core\Config as Config;
use Gungnir\DataSource\Adapter\Database\Driver\Query\QueryObject;

interface DatabaseDriverInterface 
{
	public function __construct(Config $config);

	public function execute(QueryObject $query);

	public function query(QueryObject $query);

}