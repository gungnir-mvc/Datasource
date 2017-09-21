<?php
namespace Gungnir\DataSource;

class DataSourceEntity implements DataSourceEntityInterface
{
    /** @var array */
    private $data = [];

    /**
     * DataSourceEntity constructor. Can be array or object
     *
     * @param mixed $data
     */
    public function __construct($data = [])
    {
        $this->data = $data;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        if (is_object($this->data)) {
            return isset($this->data->$offset);
        }
        return isset($this->data[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            if (is_object($this->data)) {
                return $this->data->$offset;
            }
            return $this->data[$offset];
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        if (is_object($this->data)) {
            $this->data->$offset = $value;
         return;
        }
        $this->data[$offset] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            if (is_object($this->data)) {
                unset($this->data->$offset);
                return;
            }
            unset($this->data[$offset]);
        }
    }
}