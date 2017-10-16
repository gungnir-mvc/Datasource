<?php
namespace Gungnir\DataSource\Test\Driver\Database;

use Gungnir\Core\Config;
use Gungnir\DataSource\Driver\Database\Query\QueryObject;
use Gungnir\DataSource\Driver\Database\Sqlite;
use Gungnir\DataSource\Factory\ConnectionFactory;
use PHPUnit\Framework\TestCase;

class SqliteTest extends TestCase
{
    /**
     * @test
     */
    public function testItCanBeInstantiated()
    {
        $dsn      = 'sqlite:test_database.db';

        $config = new Config([
            'database' => 'test_database'
        ]);

        $connectionFactory = $this->getMockBuilder(ConnectionFactory::class)
            ->setMethods(['makePdoConnection'])
            ->getMock();

        $pdo = $this->getMockBuilder(\PDO::class)
            ->disableOriginalConstructor()
            ->setMethodsExcept()
            ->getMock();

        $connectionFactory->expects($this->atLeastOnce())
            ->method('makePdoConnection')
            ->with($dsn)
            ->will($this->returnValue($pdo));

        /** @var ConnectionFactory $connectionFactory */

        // Just create one to run assertions
        new Sqlite($config, $connectionFactory);
    }

    /**
     * @test
     */
    public function testItIsPossibleToQuery()
    {

        $config = new Config([
            'database' => 'test_database'
        ]);

        $connectionFactory = $this->getMockBuilder(ConnectionFactory::class)
            ->setMethods(['makePdoConnection'])
            ->getMock();

        $sth = $this->getMockBuilder(\PDOStatement::class)
            ->setMethods(['execute', 'bindValue'])
            ->getMock();

        $sth->expects($this->atLeastOnce())
            ->method('execute');

        $sth->expects($this->exactly(2))
            ->method('bindValue');

        $pdo = $this->getMockBuilder(\PDO::class)
            ->disableOriginalConstructor()
            ->setMethods(['prepare'])
            ->getMock();

        $pdo->expects($this->atLeastOnce())
            ->method('prepare')
            ->with('SELECT * FROM test_table WHERE id=? AND uuid=:uuid')
            ->will($this->returnValue($sth));

        $connectionFactory->expects($this->atLeastOnce())
            ->method('makePdoConnection')
            ->will($this->returnValue($pdo));

        /** @var ConnectionFactory $connectionFactory */

        // Just create one to run assertions
        $driver = new Sqlite($config, $connectionFactory);

        $queryObject = new QueryObject();
        $queryObject->concat('SELECT * FROM test_table WHERE id=? AND uuid=:uuid');
        $queryObject->addParameter('?', '1');
        $queryObject->addParameter(':uuid', 'asd-asd-asd');

        $driver->execute($queryObject);
    }
}