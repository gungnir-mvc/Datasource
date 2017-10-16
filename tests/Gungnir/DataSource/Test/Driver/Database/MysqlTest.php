<?php
namespace Gungnir\DataSource\Test\Driver\Database;

use Gungnir\Core\Config;
use Gungnir\DataSource\Driver\Database\Mysql;
use Gungnir\DataSource\Driver\Database\Query\QueryObject;
use Gungnir\DataSource\Factory\ConnectionFactory;
use PHPUnit\Framework\TestCase;

class MysqlTest extends TestCase
{
    /**
     * @test
     */
    public function testItCanBeInstantiated()
    {
        $dsn      = 'mysql:host=localhost;dbname=test_database;port=3606;charset=UTF8';
        $username = 'root';
        $password = 'root';
        $options  = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ];

        $config = new Config([
            'username' => $username,
            'password' => $password,
            'hostname' => 'localhost',
            'port'     => '3606',
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
            ->with($dsn, $username, $password, $options)
            ->will($this->returnValue($pdo));

        /** @var ConnectionFactory $connectionFactory */

        // Just create one to run assertions
        new Mysql($config, $connectionFactory);
    }

    /**
     * @test
     */
    public function testItIsPossibleToQuery()
    {

        $config = new Config([
            'username' => 'root',
            'password' => 'root',
            'hostname' => 'localhost',
            'port'     => '3606',
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
        $driver = new Mysql($config, $connectionFactory);

        $queryObject = new QueryObject();
        $queryObject->concat('SELECT * FROM test_table WHERE id=? AND uuid=:uuid');
        $queryObject->addParameter('?', '1');
        $queryObject->addParameter(':uuid', 'asd-asd-asd');

        $driver->execute($queryObject);
    }
}