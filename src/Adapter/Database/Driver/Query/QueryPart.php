<?php
namespace Gungnir\DataSource\Adapter\Database\Driver\Query;

interface QueryPart
{
    public function getQueryPartString() : String;
}
