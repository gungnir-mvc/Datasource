<?php
namespace Gungnir\DataSource;

class DataSourceEntityCollection implements DataSourceEntityCollectionInterface
{
    /** @var DataSourceEntityInterface[] */
    private $entities = [];

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->entities());
    }

    /**
     * @param DataSourceEntityInterface $entity
     *
     * @return void
     */
    public function push(DataSourceEntityInterface $entity)
    {
        $this->entities[] = $entity;
    }

    /**
     * @param string $key
     * @param DataSourceEntityInterface $entity
     *
     * @return void
     */
    public function set(string $key, DataSourceEntityInterface $entity)
    {
        $this->entities[$key] = $entity;
    }

    /**
     * @param string $key
     *
     * @return DataSourceEntityInterface|null
     */
    public function entity(string $key): ?DataSourceEntityInterface
    {
        if (isset($this->entities[$key])) {
            return $this->entities[$key];
        }
        return null;
    }

    /**
     * @return array
     */
    public function entities(): array
    {
        return $this->entities;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->entities);
    }
}