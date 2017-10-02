<?php
namespace Gungnir\DataSource\Adapter;

use Gungnir\Core\Config;

interface DataSourceAdapterDriverInterface
{
    /**
     * @param Config|null $config
     *
     * @return Config
     */
    public function config(Config $config = null): ?Config;
}