<?php
namespace Gungnir\DataSource\Operation;

interface DataSourceDeleteOperationInterface
{
    /**
     * Join another table into the operation
     *
     * @param string $table
     *
     * @return self
     */
    public function join(string $table);

    /**
     * Set the target table for primary usage in query
     *
     * @param string $table
     *
     * @return self
     */
    public function from(string $table);

    /**
     * @param string $column
     * @param $value
     * @param string|null $operator
     *
     * @return self
     */
    public function having(string $column, $value, string $operator = null);

    /**
     * @param $columns
     * @param $values
     * @param string|null $operator
     * @param string|null $mode
     *
     * @return self
     */
    public function matchAgainst($columns, $values, string $operator = null, string $mode = null);

    /**
     * @param string $column   Target column to compare value with
     * @param mixed  $value    The value to compare column with
     * @param string $operator Determines which kind of comparison will be made between the values
     *
     * @return self
     */
    public function where(string $column, $value, string $operator = '=');

    /**
     * @param Int $start
     * @param Int $end
     * @param string|null $column
     *
     * @return self
     */
    public function between(Int $start, Int $end, string $column = null);

    /**
     * @param string $key
     * @param $value
     * @param string|null $column
     * @param string $operator
     *
     * @return self
     */
    public function or(string $key, $value, string $column = null, string $operator = '=');

    /**
     * Runs the operation and returns the result
     *
     * @return mixed
     */
    public function execute();
}