<?php
namespace Gungnir\DataSource\Test\Driver\Database;


use Gungnir\DataSource\Driver\Database\Table;
use PHPUnit\Framework\TestCase;

class TableTest extends TestCase
{
    /**
     * @param $tableName
     * @param $expectedPrimaryKey
     * @param null $definedPrimaryKey
     *
     * @test
     * @dataProvider tableNameProvider
     */
    public function testItGuessesThePrimaryKeyName($tableName, $expectedPrimaryKey, $definedPrimaryKey = null)
    {
        $table = new Table($tableName, $definedPrimaryKey);
        $this->assertEquals($expectedPrimaryKey, (string) $table->key());
    }

    /**
     * @return array
     */
    public function tableNameProvider()
    {
        return [
            ['users', 'user_id'],
            ['usersssss', 'user_id'],
            ['users', 'uuid', 'uuid']
        ];
    }
}