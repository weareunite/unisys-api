<?php

namespace Domain\Invoices\ItemBuilders;

use Domain\Credits\CreditOrder;
use Unite\UnisysApi\Modules\Invoice\Classes\InvoiceItem;

class CreditOrderItemBuilder extends ItemBuilder
{
    protected $creditOrder;

    public function __construct(CreditOrder $creditOrder)
    {
        $this->creditOrder = $creditOrder;
    }

    public function build()
    : InvoiceItem
    {
        return (new InvoiceItem())
            ->title('Add Credits to account')
            ->quantity($this->creditOrder->value)
            ->units('credits')
            ->pricePerUnit(config('credit_settings.default_price_per_credit'));
    }
}
