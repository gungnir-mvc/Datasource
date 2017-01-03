<?php
namespace Gungnir\DataSource\Adapter\Database\Driver;

use Gungnir\DataSource\Adapter\DataSourceAdapterDriverInterface;
use Gungnir\DataSource\Adapter\Database\Driver\Query\{Insert, Select, Update, Delete, QueryObject};

abstract class AbstractDriver implements DatabaseDriverInterface, DataSourceAdapterDriverInterface 
{
	public function select(String $select, String $table = null)
	{
		$select = new Select($select);
		$select->driver($this);
		if ($table) {
			$select = $select->from($table) ?? $select;
		}
		return $select;
	}

	public function delete()
	{
		$delete = new Delete;
		$delete->driver($this);
		return $delete;
	}

	public function update()
	{
		$update = new Update;
		$update->driver($this);
		return $update;
	}

	public function insert()
	{
		$insert = new Insert;
		$insert->driver($this);
		return $insert;
	}
}
