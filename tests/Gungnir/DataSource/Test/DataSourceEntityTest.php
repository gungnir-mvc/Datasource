<?php
namespace Gungnir\DataSource\Test;

use Gungnir\DataSource\DataSourceEntity;
use PHPUnit\Framework\TestCase;

class DataSourceEntityTest extends TestCase
{
    /**
     * @test
     */
    public function testDataCanBeAccessedArrayStyle()
    {
        $entity = new DataSourceEntity([
            'id' => 1
        ]);

        $entity['id2'] = 2;

        $this->assertEquals(1, $entity['id']);
        $this->assertEquals(2, $entity['id2']);
    }

    /**
     * @test
     */
    public function testDataCanBeAnObject()
    {
        $object = new \StdClass();
        $object->one = '123';
        $entity = new DataSourceEntity($object);

        $this->assertTrue(isset($entity['one']));
        unset($entity['one']);
        $this->assertFalse(isset($entity['one']));
        $this->assertFalse(isset($entity['two']));
        $entity['two'] = '123';
        $this->assertTrue(isset($entity['two']));
    }
}