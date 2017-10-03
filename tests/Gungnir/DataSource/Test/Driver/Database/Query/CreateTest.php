<?php
namespace Gungnir\DataSource\Test\Driver\Database\Query;

use Gungnir\DataSource\Driver\Database\Query\Create;
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