<?php

namespace Unite\UnisysApi\Exceptions;

use Exception;

class MissingInstanceException extends Exception
{
    /**
     * Create a new authentication exception.
     *
     * @param  string  $message
     * @param  array  $guards
     * @return void
     */
    public function __construct($message = 'Missing attached Instances.', array $guards = [])
    {
        parent::__construct($message);
    }

}
