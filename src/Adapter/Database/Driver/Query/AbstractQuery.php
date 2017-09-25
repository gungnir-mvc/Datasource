<?php
namespace Gungnir\DataSource\Adapter\Database\Driver\Query;

use Gungnir\DataSource\Adapter\Database\Table;
use Gungnir\DataSource\Adapter\DataSourceAdapterDriverInterface;

abstract class AbstractQuery implements QueryInterface
{
	/** @var DataSourceAdapterDriverInterface The adapter which is used to communicate with database */
	private $driver = null;

	/** @var Table Main table this operation targets */
	private $table  = null;

	/** @var Int Any limit which would be applied to the query */
	private $limit  = null;

	public function driver($driver)
	{
		$this->driver = $driver;
	}

	/**
	 * Get or set the table which this operation affect
	 * 
	 * @param  String|null $table Table name
	 * @param  String|null $key   Possible table primary key
	 * 
	 * @return self|Table
	 */
	public function table(String $table = null, String $key = null)
	{
		if ($table) {
			$this->table = new Table($table, $key);
			return $this;
		}
		return $this->table;
	}

	/**
	 * Executes this operation trough driver and returns
	 * result
	 * 
	 * @return Mixed
	 */
	public function execute()
	{
		$query = $this->getQuery();

		if (strpos($query->getString(), 'LIMIT') === false && is_null($this->limit) === false) {
			$query->concat($this->limit);
		}
		return $this->driver->query($query);
	}

	/**
	 * Set a limit to how many entries can be retrieved
	 * or affected by this operation
	 * 
	 * @param  Int      $limit [description]
	 * @param  Int|null $start [description]
	 * 
	 * @return self
	 */
	public function limit(Int $limit, Int $start = null)
	{
		$this->limit = new Limit($limit, $start);
		return $this;
	}
}
