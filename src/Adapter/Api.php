<?php
namespace Gungnir\DataSource\Adapter;

class Api implements DataSourceAdapterInterface 
{
	private $driver = null;

	/**
	 * Constructor
	 * 
	 * @param DataSourceAdapterDriverInterface $driver The driver to use
	 */
	public function __construct(DataSourceAdapterDriverInterface $driver)
	{
		$this->setDataSourceAdapterDriver($driver);
	}

	/**
	 * Set the driver for this adapter
	 * 
	 * @param DataSourceAdapterDriverInterface $driver
	 */
	public function setDataSourceAdapterDriver(DataSourceAdapterDriverInterface $driver)
	{
		$this->driver = $driver;
	}

	/**
	 * Get the driver for this adapter
	 * 
	 * @return DataSourceAdapterDriverInterface
	 */
	public function getDataSourceAdapterDriver() : DataSourceAdapterDriverInterface
	{
		return $this->driver;
	}


	public function execute(String $query)
	{

	}

	public function query(String $query)
	{

	}

	public function select(String $string, String $table = null)
	{
		return $this->getDataSourceAdapterDriver()->select($string, $table);
	}

	public function insert()
	{
		// POST
	}

	public function delete()
	{
		// DELETE / POST
	}

	public function update()
	{
		// PUT / POST
	}
}