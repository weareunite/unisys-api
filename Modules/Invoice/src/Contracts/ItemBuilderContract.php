<?php

namespace Domain\Invoices\Contracts;

use Unite\UnisysApi\Modules\Invoice\Classes\InvoiceItem;

interface ItemBuilderContract
{
    public function build()
    : InvoiceItem;
}
