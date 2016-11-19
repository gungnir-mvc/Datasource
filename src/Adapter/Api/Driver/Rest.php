<?php
namespace Gungnir\DataSource\Adapter\Api\Driver;

use \Gungnir\DataSource\Adapter\DataSourceAdapterDriverInterface;
use \Gungnir\DataSource\Adapter\Api\Driver\Operation\{Get,Put,Post,Delete};

class Rest implements DataSourceAdapterDriverInterface 
{
	public function select(String $what, String $from = null)
	{
		return new Get();
	}
}