<?php
namespace Gungnir\DataSource\Driver\Database\Query;

abstract class Common extends AbstractQuery
{
    private $joins        = [];
    private $where        = [];
    private $having       = [];
    private $matchAgainst = [];
    private $or           = [];
    private $order        = [];
    private $group        = [];

	/** @var Between */
    private $between = null;

    /**
     * Adds table to be join into query
     *
     * @param string $table
     *
     * @return self
     */
	public function join(string $table)
	{
		$this->joins[] = $table;
		return $this;
	}

    /**
     * Set the target table for primary usage in query
     *
     * @param String $table
     * @return self
     */
	public function from(String $table)
	{
		return $this->table($table);
	}

    /**
     * @param String $column
     * @return $this
     */
	public function groupBy(String $column)
	{
		$this->group[] = $column;
		return $this;
	}

    /**
     * @param string $column
     * @param $value
     * @param string|null $operator
     * @return $this
     */
    public function having(string $column, $value, string $operator = null)
    {
        $operator = $operator ?? '=';

        if (is_string($value)) {
            $value = "'" . $value . "'";
        } elseif (is_array($value)) {
            $value = "(" . implode(',', $value) . ")";
        }
        $this->having[] = [$column, $operator, $value];
        return $this;
    }

    /**
     * @param $columns
     * @param $values
     * @param String|null $operator
     * @param String|null $mode
     *
     * @return $this
     */
    public function matchAgainst($columns, $values, String $operator = NULL, String $mode = NULL)
    {
        $operator = $operator ?? 'AGAINST';

        if (is_string($columns)) {
            $columns = '(' . $columns . ')';
        } elseif (is_array($columns)) {
            $columns = '(' . implode(", ", $columns) . ')';
        }

        if (is_string($values)) {
            $values = "('" . $values . "' ";
            $values .= (string) $mode;
            $values .= ")";

        } elseif (is_array($values)) {
            $values = "('" . implode(" ", $values) . "' ";
            $values .= (string) $mode;
            $values .= ")";
        }

        $this->matchAgainst[] = [
            $columns,
            $operator,
            $values];
        return $this;
    }

    /**
     * @param String $column   Target column to compare value with
     * @param mixed  $value    The value to compare column with
     * @param String $operator Determines which kind of comparison will be made between the values
     *
     * @return $this
     */
	public function where(String $column, $value, String $operator = '=')
	{
		$value = (is_string($value)) ? "'" . $value . "'" : $value;
		$this->where[] = [$column, $operator, $value];
		return $this;
	}

    /**
     * @param Int $start
     * @param Int $end
     * @param String|null $column
     *
     * @return $this
     */
    public function between(Int $start, Int $end, String $column = null)
    {
        $column = $column ?? rtrim($this->table(), 's') . '_id';
        $this->between = new Between($start, $end, $column);
        return $this;
    }

    /**
     * @param String $key
     * @param $value
     * @param String|null $column
     * @param String $operator
     *
     * @return $this
     */
	public function or(String $key, $value, String $column = null, String $operator = '=')
	{
		$column  = $column ?? $key;
		$value = (is_string($value)) ? "'" . $value . "'" : $value;
		$this->or[$column] = [$column, $operator, $value];
		return $this;
	}

    /**
     * Sets the order of things in the universe
     *
     * @param String $column
     * @param String $type
     *
     * @return $this
     */
	public function orderBy(String $column, String $type = 'DESC')
	{
		$this->order[] = [$column, $type];
		return $this;
	}

    /**
     * {@inheritdoc}
     */
	public function getQuery(QueryObject $query = null) : QueryObject
	{
        $query = $query ?? new QueryObject;
        $this->addJoins($query)
            ->addBetween($query)
            ->addWhere($query)
            ->addGroup($query)
            ->addHaving($query)
            ->addOrder($query);

		return $query;
	}

    /**
     * @return mixed
     */
	public function run()
	{
		return $this->execute();
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

    /**
     * @param QueryObject $query
     * @return $this
     */
    private function addHaving(QueryObject $query)
    {
        foreach ($this->having as $key => $having) {
            if ($key > 0 || $this->between) {
                $query->concat("AND " . implode(" ", $having));
            } else {
                $query->concat("HAVING " . implode(" ", $having));
            }
        }

        return $this;
    }
    /**
    public function addMatchAgainst(QueryObject $query)
    {
        foreach($this->matchAgainst AS $key => $matchAgainst) {

        }
        return $this;
    }
**/
    /**
     * @param QueryObject $query
     * @return $this
     */
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

	private function addGroup(QueryObject $query)
	{
		if (empty($this->group) === false) {
			$query->concat('GROUP BY');
			$queryPart = "";
			foreach ($this->group as $key => $group) {
				$queryPart .= $group . ', ';
				if ($key == (count($this->group) - 1)) {
					$queryPart = rtrim($queryPart, ', ');
				}
			}
			$query->concat($queryPart);
		}

		return $this;
	}
}
