<?php
namespace Gungnir\DataSource\Adapter;

use Gungnir\Core\Config;
use Gungnir\DataSource\Operation\{
    DataSourceSelectOperationInterface,
    DataSourceInsertOperationInterface,
    DataSourceUpdateOperationInterface,
    DataSourceDeleteOperationInterface
};

interface DataSourceAdapterDriverInterface
{
    /**
     * @param Config|null $config
     *
     * @return Config
     */
    public function config(Config $config = null): ?Config;

    /**
     * Returns a select statement object
     *
     * @param string      $select
     * @param string|null $from
     *
     * @return DataSourceSelectOperationInterface
     */
    public function select(string $select, string $from = null);

    /**
     * Returns an insert statement object
     *
     * @return DataSourceInsertOperationInterface
     */
    public function insert();

    /**
     * Returns an update statement object
     *
     * @return DataSourceUpdateOperationInterface
     */
    public function update();

    /**
     * Returns a delete statement object
     *
     * @return DataSourceDeleteOperationInterface
     */
    public function delete();
}