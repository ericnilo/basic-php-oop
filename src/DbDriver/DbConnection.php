<?php

namespace DbDriver;

class DbConnection
{
    /**
     * @var
     */
    private $connection;

    public function __construct(ConnectionSchema $connectionSchema)
    {
        /** @var DriverInterface $driverClass */
        $driverClass = $connectionSchema->getDriver();

        $this->connection = new $driverClass($connectionSchema);
    }

    /**
     * @return DriverInterface
     */
    public function get()
    {
        return $this->connection;
    }
}
