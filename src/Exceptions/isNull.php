<?php

namespace Toyrone\SmsApi\Exceptions;

use Exception;
class IsNull extends Exception
{
    public static function create($message)
    {
        return new static("{$message}");
    }
}