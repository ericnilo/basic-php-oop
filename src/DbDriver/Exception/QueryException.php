<?php

namespace DbDriver\Exception;

class QueryException extends \Exception
{
    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        if (empty($message)) {
            $message = 'There\'s something wrong in your query';
        }

        parent::__construct($message, $code, $previous);
    }
}
