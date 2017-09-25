<?php
namespace Gungnir\DataSource\Adapter\Database\Driver\Query;

interface QueryPartInterface
{
    public function getQueryPartString() : String;
}
