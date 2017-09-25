<?php
namespace Gungnir\DataSource\Operation;

interface DataSourceUpdateOperationInterface extends DataSourceCommonOperationInterface
{
    /**
     * Set a key => value pair to be done in update
     *
     * @param String $key
     * @param $value
     *
     * @return mixed
     */
    public function set(string  $key, $value);
}