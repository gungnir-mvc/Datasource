<?php
namespace Gungnir\DataSource\Adapter\Database\Driver;

use Gungnir\DataSource\Adapter\DataSourceAdapterDriverInterface;
use Gungnir\DataSource\Adapter\Database\Driver\Query\{Create, Select, Update, Delete};

abstract class AbstractDriver implements DatabaseDriverInterface, DataSourceAdapterDriverInterface 
{
    /**
     * If a table name is passed as a second parameter then that table will
     * be added to the query
     *
     * @param String $select
     * @param String|null $table
     *
     * @return Select
     */
	public function select(String $select, String $table = null): Select
	{
		$select = new Select($select);
		$select->driver($this);
		if ($table) {
			$select = $select->from($table) ?? $select;
		}
		return $select;
	}

    /**
     * @return Delete
     */
	public function delete(): Delete
	{
		$delete = new Delete;
		$delete->driver($this);
		return $delete;
	}

    /**
     * @return Update
     */
	public function update(): Update
	{
		$update = new Update;
		$update->driver($this);
		return $update;
	}

    /**
     * @return Create
     */
	public function insert(): Create
	{
		$insert = new Create;
		$insert->driver($this);
		return $insert;
	}
}
