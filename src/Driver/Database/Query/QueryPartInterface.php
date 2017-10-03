<?php
namespace Gungnir\DataSource\Driver\Database\Query;

interface QueryPartInterface
{
    public function getQueryPartString() : String;
}
