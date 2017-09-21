<?php
namespace Gungnir\DataSource\Test;

use Gungnir\Core\Config;
use Gungnir\DataSource\DataSourceFactory;
use Gungnir\DataSource\DataSourceInterface;
use PHPUnit\Framework\TestCase;

class DataSourceFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function testItCanCreateApiDataSource()
    {
        $factory = new DataSourceFactory();
        $config = new Config();
        $dataSource = $factory->makeApiDataSource($config);
        $this->assertInstanceOf(DataSourceInterface::class, $dataSource);
    }

    /**
     * @test
     */
    public function testItCanCreateDataSourceFromConfig()
    {
        $factory = new DataSourceFactory();
        $config = new Config(['type' => 'api']);
        $dataSource = $factory->makeDataSource($config);
        $this->assertInstanceOf(DataSourceInterface::class, $dataSource);
    }
}