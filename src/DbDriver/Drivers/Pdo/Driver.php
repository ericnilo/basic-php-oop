<?php

namespace DbDriver\Drivers\Pdo;

use DbDriver\AbstractDriverHelper;
use DbDriver\ConnectionSchema;
use DbDriver\DriverInterface;
use DbDriver\Exception\ConnectionErrorException;
use \PDO;

class Driver extends AbstractDriverHelper implements DriverInterface
{
    const DEFAULT_CHAR_SET = 'utf8mb4';

    protected $mysqlTypes = [
        'string' => PDO::PARAM_STR,
        'double' => PDO::PARAM_STR,
        'float' => PDO::PARAM_STR,
        'integer' => PDO::PARAM_INT,
        'bool' => PDO::PARAM_BOOL,
        'boolean' => PDO::PARAM_BOOL,
    ];


    /**
     * @var PDO
     */
    private $connection;

    public function __construct(ConnectionSchema $connectionSchema)
    {
        $dsn = "mysql:host={$connectionSchema->getHost()};
        dbname={$connectionSchema->getDatabase()};
        charset=" . self::DEFAULT_CHAR_SET;

        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $connection = new PDO($dsn, $connectionSchema->getUserName(), $connectionSchema->getPassword(), $opt);
        } catch (\PDOException $ex) {
            throw new ConnectionErrorException($ex->getMessage());
        }

        $this->connection = $connection;
    }

    public function select($query)
    {
        $statement = $this->prepare($query);

        return $statement->fetchAll();
    }

    public function insert($tableName, $insertData)
    {
        list($insertStatement, $value, $type) = $this->createInsertStatement($tableName, $insertData);

        $this->prepare($insertStatement, $value, $type);

        return $this->connection->lastInsertId();
    }

    private function prepare($query, $values = [], $type = [])
    {
        if (!($statement = $this->connection->prepare($query))) {
            throw new QueryException();
        }

        if (!empty($values)) {
            foreach ($values as $i => $value) {
                $statement->bindValue($i+1, $value, $type[$i]);
            }
        }

        $statement->execute();

        return $statement;
    }
}
