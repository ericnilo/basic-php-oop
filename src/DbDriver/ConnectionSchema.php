<?php

namespace DbDriver;

use DbDriver\Exception\DriverNotFoundException;

class ConnectionSchema
{
    const AVAILABLE_DRIVER = [
        'mysqli' => Drivers\Mysqli\Driver::class,
        'pdo' => Drivers\Pdo\Driver::class
    ];

    /**
     * @var string
     */
    protected $host;

    /**
     * @var string
     */
    protected $userName;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $database;

    /**
     * @var string
     */
    protected $driver;

    public function __construct($driver, $host, $username, $password, $database)
    {
        if (!array_key_exists($driver, self::AVAILABLE_DRIVER)) {
            throw new DriverNotFoundException();
        }

        $this->driver = self::AVAILABLE_DRIVER[$driver];
        $this->host = $host;
        $this->userName = $username;
        $this->password = $password;
        $this->database = $database;
    }

    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getDatabase()
    {
        return $this->database;
    }
}
