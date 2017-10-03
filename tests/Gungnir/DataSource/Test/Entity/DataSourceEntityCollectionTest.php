<?php
namespace Gungnir\DataSource\Test\Entity;

use Gungnir\DataSource\Entity\DataSourceEntity;
use Gungnir\DataSource\Entity\DataSourceEntityCollection;
use Gungnir\DataSource\Entity\DataSourceEntityInterface;
use PHPUnit\Framework\TestCase;

class DataSourceEntityCollectionTest extends TestCase
{
    /**
     * @test
     */
    public function testItCanWorkWithEntities()
    {
        $collection = new DataSourceEntityCollection();
        $collection->push(new DataSourceEntity([]));

        $this->assertEquals(1, $collection->count());
    }

    public function testItCanBeIterated()
    {
        $collection = new DataSourceEntityCollection();
        $collection->push(new DataSourceEntity([
            'id' => 1
        ]));
        $collection->push(new DataSourceEntity([
            'id' => 2
        ]));
        $collection->push(new DataSourceEntity([
            'id' => 3
        ]));

        $counter = 0;
        foreach ($collection AS $entity) {
            $counter++;
            $this->assertInstanceOf(DataSourceEntityInterface::class, $entity);
            $this->assertEquals($counter, $entity['id']);
        }
        $this->assertEquals($collection->count(), $counter);
    }
}