<?php
namespace Gungnir\DataSource\Test\Driver\Database\Query;

use Gungnir\DataSource\Driver\Database\Query\Delete;
use PHPUnit\Framework\TestCase;

class DeleteTest extends TestCase
{
    /**
     * @test
     */
    public function testItCanGenerateQueryString()
    {
        $expectedQuery = "DELETE FROM table WHERE id = 1";
        $operation = new Delete();
        $operation
            ->from('table')
            ->where('id', 1);

        $this->assertEquals($expectedQuery, (string) $operation->getQuery());
    }
}