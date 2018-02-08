<?php

namespace DbDriver\Exception;

class DriverNotFoundException extends \Exception
{
    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        if (empty($message)) {
            $message = 'DbDriver cannot be found.';
        }

        parent::__construct($message, $code, $previous);
    }
}
