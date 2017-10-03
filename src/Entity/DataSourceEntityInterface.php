<?php
namespace Gungnir\DataSource\Entity;

/**
 * Interface DataSourceEntityInterface represents one successfully fetched
 * entity from data source
 *
 * @package Gungnir\DataSource
 */
interface DataSourceEntityInterface extends \ArrayAccess
{
    /**
     * Returns underlying data
     *
     * @return mixed
     */
    public function expose();
}