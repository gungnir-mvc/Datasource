<?php
namespace Gungnir\DataSource\Test\Adapter;

use Gungnir\Core\Config;
use Gungnir\DataSource\Adapter\Database;
use Gungnir\DataSource\Adapter\DataSourceAdapterDriverInterface;
use Gungnir\DataSource\Driver\Database\Query\Create;
use Gungnir\DataSource\Driver\Database\Query\Delete;
use Gungnir\DataSource\Driver\Database\Query\Select;
use Gungnir\DataSource\Driver\Database\Query\Update;
use Gungnir\DataSource\Operation\DataSourceSelectOperationInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;

class DatabaseTest extends TestCase
{
    /**
     * @test
     */
    public function testItCanStoreAndRetrieveInstances()
    {
        $database = new Database($this->makeMockDatabaseAdapterDriver());
        $this->assertEquals($database, Database::instance('default'));
    }

    /**
     * @test
     */
    public function testItReturnsSelectOperation()
    {
        $driver = $this->makeMockDatabaseAdapterDriver();

        $selectString = '*';
        $selectTable = 'test_table';

        $select = new Select($selectString);
        $select->table($selectTable);

        /**
         * @var DataSourceSelectOperationInterface $select
         */

        /** @var PHPUnit_Framework_MockObject_MockObject $driver */
        $driver->expects($this->once())
            ->method('select')
            ->will($this->returnValue($select));

        /** @var DataSourceAdapterDriverInterface $driver */

        $database = new Database($driver);

        $this->assertEquals($select, $database->select($selectString));
    }

    /**
     * @test
     */
    public function testItReturnsUpdateOperation()
    {
        $driver = $this->makeMockDatabaseAdapterDriver();


        $update = new Update();

        /**
         * @var DataSourceSelectOperationInterface $select
         */

        /** @var PHPUnit_Framework_MockObject_MockObject $driver */
        $driver->expects($this->once())
            ->method('update')
            ->will($this->returnValue($update));

        /** @var DataSourceAdapterDriverInterface $driver */

        $database = new Database($driver);

        $this->assertEquals($update, $database->update());
    }

    /**
     * @test
     */
    public function testItReturnsDeleteOperation()
    {
        $driver = $this->makeMockDatabaseAdapterDriver();


        $delete = new Delete();

        /**
         * @var DataSourceSelectOperationInterface $select
         */

        /** @var PHPUnit_Framework_MockObject_MockObject $driver */
        $driver->expects($this->once())
            ->method('delete')
            ->will($this->returnValue($delete));

        /** @var DataSourceAdapterDriverInterface $driver */

        $database = new Database($driver);

        $this->assertEquals($delete, $database->delete());
    }

    /**
     * @test
     */
    public function testItReturnsCreateOperation()
    {
        $driver = $this->makeMockDatabaseAdapterDriver();


        $create = new Create();

        /**
         * @var DataSourceSelectOperationInterface $select
         */

        /** @var PHPUnit_Framework_MockObject_MockObject $driver */
        $driver->expects($this->once())
            ->method('insert')
            ->will($this->returnValue($create));

        /** @var DataSourceAdapterDriverInterface $driver */

        $database = new Database($driver);

        $this->assertEquals($create, $database->insert());
    }


    /**
     * @return DataSourceAdapterDriverInterface
     */
    private function makeMockDatabaseAdapterDriver(): DataSourceAdapterDriverInterface
    {
        $config = new Config([
            'parent' => 'default'
        ]);

        $mockDriver = $this->getMockBuilder(DataSourceAdapterDriverInterface::class)
            ->setMethodsExcept()
            ->getMock();

        $mockDriver->expects($this->any())
            ->method('config')
            ->will($this->returnValue($config));

        /** @var DataSourceAdapterDriverInterface $mockDriver */
        return $mockDriver;
    }
}