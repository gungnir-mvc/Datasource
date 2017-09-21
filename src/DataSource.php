<?php
namespace Gungnir\DataSource;

use \Gungnir\DataSource\Adapter\DataSourceAdapterInterface;

/**
 * @package Gungnir\DataSource
 */
class DataSource implements DataSourceInterface
{
	/** @var DataSourceAdapterInterface */
	private $adapter = null;

    /**
     * {@inheritdoc}
     */
	public function __construct(DataSourceAdapterInterface $adapter)
	{
		$this->setDataSourceAdapter($adapter);
	}

    /**
     * {@inheritdoc}
     */
	public function setDataSourceAdapter(DataSourceAdapterInterface $adapter)
	{
		$this->adapter = $adapter;
	}

    /**
     * {@inheritdoc}
     */
	public function getDataSourceAdapter() : DataSourceAdapterInterface
	{
		return $this->adapter;
	}

    /**
     * {@inheritdoc}
     */
	public function select(string $select, string $from = null)
	{
		return $this->getDataSourceAdapter()->select($select, $from);
	}

    /**
     * {@inheritdoc}
     */
	public function insert()
	{
		return $this->getDataSourceAdapter()->insert();
	}

    /**
     * {@inheritdoc}
     */
	public function update()
	{
		return $this->getDataSourceAdapter()->update();
	}

    /**
     * {@inheritdoc}
     */
	public function delete()
	{
		return $this->getDataSourceAdapter()->delete();
	}
}