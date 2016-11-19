<?php
namespace Gungnir\DataSource\Adapter\Database\Driver;

use Gungnir\Core\Config as Config;

interface DatabaseDriverInterface 
{
	public function __construct(Config $config);

	public function execute(String $query);

	public function query(String $query);

}