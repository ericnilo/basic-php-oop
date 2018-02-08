<?php

namespace DbDriver\Drivers\Mysqli;

use DbDriver\AbstractDriverHelper;
use DbDriver\ConnectionSchema;
use DbDriver\DriverInterface;
use DbDriver\Exception\ConnectionErrorException;
use DbDriver\Exception\QueryException;

class Driver extends AbstractDriverHelper implements DriverInterface
{
    protected $mysqlTypes = [
        'string' => 's',
        'double' => 'd',
        'integer' => 'i',
        'blob' => 'b'
    ];

    /**
     * @var \mysqli
     */
    private $connection;

    public function __construct(ConnectionSchema $connectionSchema)
    {
        $connection = new \mysqli(
            $connectionSchema->getHost(),
            $connectionSchema->getUserName(),
            $connectionSchema->getPassword(),
            $connectionSchema->getDatabase()
        );

        if ($connection->connect_errno) {
            throw new ConnectionErrorException($connection->connect_error);
        }

        $this->connection = $connection;
    }

    public function select($query)
    {
        $statement = $this->prepare($query);
        $result    = $statement->get_result();
        $response  = $result->fetch_all(MYSQLI_ASSOC);

        $statement->close();

        return $response;
    }

    public function insert($tableName, $insertData)
    {
        list($insertStatement, $value, $type) = $this->createInsertStatement($tableName, $insertData);
    }

    private function prepare($query)
    {
        if (!($statement = $this->connection->prepare($query))) {
            throw new QueryException($this->connection->error);
        }

        $statement->execute();

        return $statement;
    }
}
