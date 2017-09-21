<?php
namespace Gungnir\DataSource;

interface DataSourceEntityCollectionInterface extends \Countable, \IteratorAggregate
{
    /**
     * @param DataSourceEntityInterface $entity
     *
     * @return void
     */
    public function push(DataSourceEntityInterface $entity);

    /**
     * @param string $key
     * @param DataSourceEntityInterface $entity
     *
     * @return void
     */
    public function set(string $key, DataSourceEntityInterface $entity);

    /**
     * @param string $key
     *
     * @return DataSourceEntityInterface|null
     */
    public function entity(string $key): ?DataSourceEntityInterface;

    /**
     * @return array
     */
    public function entities(): array;
}