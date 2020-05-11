<?php

namespace Unite\UnisysApi\Modules\Invoice\Classes;

use Unite\UnisysApi\Modules\Invoice\Contracts\PartyContract;

/**
 * Class Party
 * @package Domain\Invoice\Classes
 */
class Party implements PartyContract
{
    public $custom_fields;

    /**
     * Party constructor.
     * @param $properties
     */
    public function __construct($properties)
    {
        $this->custom_fields = [];

        foreach ($properties as $property => $value) {
            $this->{$property} = $value;
        }
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function __get($key)
    {
        return $this->{$key} ?? null;
    }
}
