<?php

namespace Unite\UnisysApi\Modules\Invoice\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Invoice
 * @package Domain\Invoice\Facades
 */
class Invoice extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'invoice';
    }
}
