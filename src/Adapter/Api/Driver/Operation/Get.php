<?php
namespace Gungnir\DataSource\Adapter\Api\Driver\Operation;

use Gungnir\DataSource\DataSourceEntityCollection;
use Gungnir\DataSource\DataSourceEntityCollectionInterface;
use Gungnir\DataSource\DataSourceEntityInterface;
use \Gungnir\DataSource\DataSourceOperationInterface;

class Get implements DataSourceOperationInterface 
{
	/** @var String */
	private $endpoint = null;

	private $handle = null;

	/**
	 * Set the endpoint that the get request will target
	 * 
	 * @param  String $where
	 * 
	 * @return DataSourceOperationInterface
	 */
	public function from(String $where)
	{
		$this->from = $where;
		return $this;
	}

    /**
     * {@inheritdoc}
     */
    public function fetch(): ?DataSourceEntityInterface
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
	public function fetchAll(): DataSourceEntityCollectionInterface
	{
        return new DataSourceEntityCollection();
	}

	public function execute()
	{
		$this->handle = curl_init();

        if (!extension_loaded('curl')) {
            throw new \Exception('cURL library is not loaded');
        }

        return [];
	}
}