<?php

namespace Toyrone\SmsApi\Exceptions;

use Exception;
class IsEmpty extends Exception
{
    public static function create($message)
    {
        return new static("{$message}");
    }
}