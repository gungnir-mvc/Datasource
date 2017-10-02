<?php
namespace Gungnir\DataSource\Adapter\Database\Driver\Query;

use Gungnir\DataSource\Operation\DataSourceDeleteOperationInterface;

class Delete extends Common implements DataSourceDeleteOperationInterface
{
    /**
     * {@inheritdoc}
     */
    public function join(string $table)
    {
        parent::join($table);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function from(string $table)
    {
        parent::from($table);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function having(string $column, $value, string $operator = null)
    {
        parent::having($column, $value, $operator);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function matchAgainst($columns, $values, string $operator = null, string $mode = null)
    {
        parent::matchAgainst($columns, $values, $operator, $mode);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function where(string $column, $value, string $operator = '=')
    {
        parent::where($column, $value, $operator);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function between(Int $start, Int $end, string $column = null)
    {
        parent::between($start, $end, $column);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function or (string $key, $value, string $column = null, string $operator = '=')
    {
        parent::or($key, $value, $column, $operator);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getQuery(QueryObject $query = null): QueryObject
    {
        $query  = $query ? $query : new QueryObject();
        $query->concat(
            "DELETE FROM ".$this->table()
        );
        parent::getQuery($query);
        return $query;
    }
}