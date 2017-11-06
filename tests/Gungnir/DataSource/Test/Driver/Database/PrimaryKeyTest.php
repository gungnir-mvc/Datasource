<?php
namespace Gungnir\DataSource\Test\Driver\Database;

use Gungnir\DataSource\Driver\Database\PrimaryKey;
use PHPUnit\Framework\TestCase;

class PrimaryKeyTest extends TestCase
{
    /**
     * @test
     */
    public function testItCanBeCastedToString()
    {
        $PK = new PrimaryKey('some primary key');
        $this->assertEquals($PK->getName(), (string) $PK);
    }
}