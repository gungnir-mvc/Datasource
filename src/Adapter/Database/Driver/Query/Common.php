<?php
namespace Gungnir\DataSource\Adapter\Database\Driver\Query;
class Common extends AbstractQuery
{
	private $joins = [];
	private $where = [];
	private $or    = [];
	private $order = [];
    private $between = null;

	public function join(String $table)
	{
		$this->joins[] = $table;
		return $this;
	}

	public function from(String $table)
	{
		return $this->table($table);
	}

	public function where(String $column, $value, String $operator = '=')
	{
		$value = (is_string($value)) ? "'" . $value . "'" : $value;
		$this->where[] = [$column, $operator, $value];
		return $this;
	}

    public function between(Int $start, Int $end, String $column = null)
    {
        $column = $column ?? rtrim($this->table(), 's') . '_id';
        $this->between = new Between($start, $end, $column);
        return $this;
    }

	public function or(String $key, $value, String $column = null, String $operator = '=')
	{
		$column  = $column ?? $key;
		$value = (is_string($value)) ? "'" . $value . "'" : $value;
		$this->or[$column] = [$column, $operator, $value];
		return $this;
	}

	public function orderBy(String $column, String $type = 'DESC')
	{
		$this->order[] = [$column, $type];
		return $this;
	}

	public function getQuery(QueryObject $query = null) : QueryObject
	{
		$query = $query ?? new QueryObject;
		$this->addJoins($query)->addBetween($query)->addWhere($query)->addOrder($query);
		return $query;
	}

	public function run()
	{
		return $this->execute($this->getQuery());
	}

    public function addBetween(QueryObject $query)
    {
        if ($this->between) {
            $query->concat($this->between->getQueryPartString());
        }

        return $this;
    }

	private function addJoins(QueryObject $query)
	{
		foreach ($this->joins as $key => $table) {
			if (strpos($table, 'ON')) {
				$query->concat('JOIN ' . $table);
			} else {
				$str = "JOIN " . $table .
			  	" ON " . $this->table() . "." . $this->table()->key() . " = " . $table . "." . $this->table()->key();
				$query->concat($str);
			}
		}

		return $this;
	}

	private function addWhere(QueryObject $query)
	{
		foreach ($this->where as $key => $where) {
			if ($key > 0 || $this->between) {
				$query->concat("AND " . implode(" ", $where));
			} else {
				$query->concat("WHERE " . implode(" ", $where));
			}

			if (in_array($where[0], array_keys($this->or))) {
				$query->concat("OR " . implode(" ", $this->or[$where[0]]));
			}
		}

		return $this;
	}

	private function addOrder(QueryObject $query)
	{
		if (empty($this->order) === false) {
			$query->concat('ORDER BY');
			$queryPart = "";
			foreach ($this->order as $key => $order) {
				$queryPart .= implode(' ', $order) . ', ';
				if ($key == (count($this->order) - 1)) {
					$queryPart = rtrim($queryPart, ', ');
				}
			}
			$query->concat($queryPart);
		}

		return $this;
	}
}
