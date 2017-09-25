<?php
namespace Gungnir\DataSource\Adapter\Database\Driver\Query;

class Between implements QueryPartInterface
{
    const STRING_KEY = 'BETWEEN';

    private $start = null;
    private $end = null;
    private $column = null;

    public function __construct(Int $start, Int $end, String $column)
    {
        $this->start = $start;
        $this->end = $end;
        $this->column = $column;
    }

    public function __toString()
    {
        return $this->getQueryPartString();
    }

    /**
     * Get the value of Start
     *
     * @return mixed
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set the value of Start
     *
     * @param mixed start
     *
     * @return self
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get the value of End
     *
     * @return mixed
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set the value of End
     *
     * @param mixed end
     *
     * @return self
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    public function getQueryPartString() : String
    {
        $string  = ' WHERE ' . $this->column . ' ' . self::STRING_KEY . ' ' . $this->getStart();
        $string .= ($this->getEnd()) ? ' AND ' . $this->getEnd() : '';
        return $string;
    }


    /**
     * Get the value of Column
     *
     * @return mixed
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * Set the value of Column
     *
     * @param mixed column
     *
     * @return self
     */
    public function setColumn($column)
    {
        $this->column = $column;

        return $this;
    }

}
