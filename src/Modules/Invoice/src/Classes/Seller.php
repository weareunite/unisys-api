<?php

namespace Unite\UnisysApi\Modules\Invoice\Classes;

use Unite\UnisysApi\Modules\Invoice\Contracts\PartyContract;

/**
 * Class Seller
 * @package Domain\Invoice\Classes
 */
class Seller implements PartyContract
{
    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    public $name;

    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    public $address;

    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    public $code;

    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    public $vat;

    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    public $phone;

    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    public $custom_fields;

    /**
     * Seller constructor.
     */
    public function __construct()
    {
        $this->name          = config('invoices.seller.attributes.name');
        $this->address       = config('invoices.seller.attributes.address');
        $this->code          = config('invoices.seller.attributes.code');
        $this->vat           = config('invoices.seller.attributes.vat');
        $this->phone         = config('invoices.seller.attributes.phone');
        $this->custom_fields = config('invoices.seller.attributes.custom_fields');
    }
}
