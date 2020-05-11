<?php

namespace Unite\UnisysApi\Modules\Invoice\Contracts;

interface HasInvoiceHandler
{
    public function invoiceHandler()
    : InvoiceHandlerContract;
}
