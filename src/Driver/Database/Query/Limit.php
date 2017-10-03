<?php
namespace Gungnir\DataSource\Driver\Database\Query;

class Limit
{
    const STRING_KEY = 'LIMIT';

    private $start = null;
    private $limit = null;

    public function __construct(int $limit, int $start = null)
    {
        $this->limit = $limit;

        if ($start) {
            $this->start = $start;
        }
    }

    public function __toString()
    {
        return $this->getLimitString();
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
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Set the value of End
     *
     * @param mixed end
     *
     * @return self
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    public function getLimitString() : String
    {
        $string  = self::STRING_KEY . ' ';

        if ($this->getStart()) {
            $string .= $this->getStart() . ',';
        }

        $string .= $this->getLimit();
        
        return $string;

    }

}
