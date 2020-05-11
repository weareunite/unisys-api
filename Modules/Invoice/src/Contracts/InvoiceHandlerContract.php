<?php

namespace Unite\UnisysApi\Modules\Invoice\Contracts;

use Unite\UnisysApi\Modules\Invoice\Classes\Buyer;
use Unite\UnisysApi\Modules\Invoice\Classes\InvoiceItem;

interface InvoiceHandlerContract
{
    public function getFilename()
    : string;

    public function getBuyer()
    : Buyer;

    public function getItems()
    : array;

    public function addItem(InvoiceItem $item);

    public function handle()
    : self;
}
