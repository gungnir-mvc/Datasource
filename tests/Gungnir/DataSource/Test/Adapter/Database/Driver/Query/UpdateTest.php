<?php
namespace Gungnir\DataSource\Test\Adapter\Database\Driver\Query;

use Gungnir\DataSource\Adapter\Database\Driver\Query\Update;
use PHPUnit\Framework\TestCase;

class UpdateTest extends TestCase
{
    /**
     * @test
     */
    public function testItCanGenerateQueryString()
    {
        $expectedQuery = "UPDATE table SET value=:value WHERE id = 1 AND name = 'test' OR name = 'test1'";
        $operation = new Update();

        $operation
            ->set('value', 1)
            ->where('id', 1)
            ->where('name', 'test')
            ->or('name', 'test1')
            ->table('table');

        $this->assertEquals($expectedQuery, (string) $operation->getQuery());
    }
}