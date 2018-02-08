<?php

namespace DbDriver;

interface DriverInterface
{
    public function __construct(ConnectionSchema $connectionSchema);

    /**
     * @param $query
     *
     * @return array
     */
    public function select($query);

    public function insert($tableName, $insertData);
}
