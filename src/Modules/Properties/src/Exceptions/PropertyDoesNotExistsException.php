<?php

namespace Unite\UnisysApi\Modules\Properties\Exceptions;

use InvalidArgumentException;

class PropertyDoesNotExistsException extends InvalidArgumentException
{
    public function __construct($message = "Property does not exists.")
    {
        parent::__construct($message);
    }

    public static function named(string $name = '')
    {
        return new static("Property named `{$name}` does not exists.");
    }
}

