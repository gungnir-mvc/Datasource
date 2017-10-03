<?php
namespace Gungnir\DataSource\Test\Driver\Database\Query;

use Gungnir\DataSource\Driver\Database\DatabaseDriverInterface;
use Gungnir\DataSource\Driver\Database\Query\Select;
use Gungnir\DataSource\Entity\DataSourceEntityCollectionInterface;
use Gungnir\DataSource\Entity\DataSourceEntityInterface;
use PHPUnit\Framework\TestCase;

class SelectTest extends TestCase
{
    /**
     * @test
     */
    public function testItCanGenerateQueryString()
    {
        $expectedQuery = 'SELECT * FROM test_table WHERE id = 1';
        $select = new Select('*');
        $select->from('test_table');
        $select->where('id', 1, '=');
        $query = $select->getQuery();

        $this->assertEquals($expectedQuery, $query->getString());
    }

    /**
     * @test
     */
    public function testItReturnsEntity()
    {
        $driver = $this->getMockBuilder(DatabaseDriverInterface::class)
            ->setMethodsExcept()
            ->getMock();

        $stMock = $this->getMockBuilder(\PDOStatement::class)
            ->setMethodsExcept()
            ->getMock();

        $stMock->expects($this->any())
            ->method('fetch')
            ->will($this->returnValue([
                'id' => 1
            ]));

        $driver->expects($this->any())
            ->method('query')
            ->will($this->returnValue($stMock));

        $select = new Select('*');
        $select->driver($driver);

        $result = $select->fetch();

        $this->assertInstanceOf(DataSourceEntityInterface::class, $result);
        $this->assertEquals(1, $result['id']);
    }

    /**
     * @test
     */
    public function testItReturnsEntities()
    {
        $driver = $this->getMockBuilder(DatabaseDriverInterface::class)
            ->setMethodsExcept()
            ->getMock();

        $stMock = $this->getMockBuilder(\PDOStatement::class)
            ->setMethodsExcept()
            ->getMock();

        $stMock->expects($this->any())
            ->method('fetchAll')
            ->will($this->returnValue([
                [
                    'id' => 1
                ],
                [
                    'id' => 2
                ]
            ]));

        $driver->expects($this->any())
            ->method('query')
            ->will($this->returnValue($stMock));

        $select = new Select('*');
        $select->driver($driver);

        $result = $select->fetchAll();

        $this->assertInstanceOf(DataSourceEntityCollectionInterface::class, $result);
        $this->assertEquals(2, count($result->entities()));

        $x = 1;
        foreach ($result->entities() AS $entity) {
            $this->assertEquals($x, $entity['id']);
            $x++;
        }
    }
}