<?php
namespace Gungnir\DataSource\Operation;

interface DataSourceInsertOperationInterface extends DataSourceCommonOperationInterface
{
    /**
     * Determines which target to insert into
     *
     * @param string $target
     *
     * @return self
     */
    public function into(string $target);

    /**
     * Set the columns which will have values inserted
     *
     * @param array $columns
     *
     * @return self
     */
    public function columns(array $columns);

    /**
     * Set the values which will be inserted
     *
     * @param array $values
     *
     * @return self
     */
    public function values(array $values);

    /**
     * Set a map of columns and values to be inserted
     *
     * @param array $data
     *
     * @return self
     */
    public function data(array $data);
}