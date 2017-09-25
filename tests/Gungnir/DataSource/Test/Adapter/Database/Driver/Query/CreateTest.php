<?php
namespace Gungnir\DataSource\Test\Adapter\Database\Driver\Query;

use Gungnir\DataSource\Adapter\Database\Driver\Query\Create;
use PHPUnit\Framework\TestCase;

class CreateTest extends TestCase
{
    /**
     * @test
     */
    public function testItCanGenerateQueryString()
    {
        $expectedQuery = "INSERT INTO table ( `name`,`value` ) VALUES( :name,:value )";
        $operation = new Create();
        $operation->into('table')
            ->columns([
                'name',
                'value'
            ])
            ->values([
                'key',
                'value'
            ]);

        $this->assertEquals($expectedQuery, (string) $operation->getQuery());
    }
}