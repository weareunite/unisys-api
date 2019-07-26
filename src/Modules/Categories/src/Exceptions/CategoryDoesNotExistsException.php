<?php

namespace Unite\UnisysApi\Modules\Categories\Exceptions;

use InvalidArgumentException;

class CategoryDoesNotExistsException extends InvalidArgumentException
{
    public function __construct($message = "Category does not exists.")
    {
        parent::__construct($message);
    }

    public static function named(string $name = '')
    {
        return new static("Category named `{$name}` does not exists.");
    }
}

