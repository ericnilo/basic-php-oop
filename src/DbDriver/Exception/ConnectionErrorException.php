<?php

namespace DbDriver\Exception;

class ConnectionErrorException extends \Exception
{
    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        if (empty($message)) {
            $message = 'Error establishing a db connection';
        }

        parent::__construct($message, $code, $previous);
    }
}
