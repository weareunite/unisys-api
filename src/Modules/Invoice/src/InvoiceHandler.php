<?php

namespace Unite\UnisysApi\Modules\Invoice;

use Unite\UnisysApi\Modules\Invoice\Classes\Buyer;
use Unite\UnisysApi\Modules\Invoice\Classes\InvoiceItem;
use Unite\UnisysApi\Modules\Invoice\Contracts\InvoiceHandlerContract;

abstract class InvoiceHandler implements InvoiceHandlerContract
{
    /** @var */
    protected $subject;

    /** @var string */
    protected $filename;

    /** @var Buyer */
    protected $buyer;

    /** @var InvoiceItem[] */
    protected $items;

    public function __construct($subject)
    {
        $this->subject = $subject;
    }

    public function getFilename()
    : string
    {
        return $this->filename;
    }

    public function getBuyer()
    : Buyer
    {
        return $this->buyer;
    }

    public function getItems()
    : array
    {
        return $this->items;
    }

    public function addItem(InvoiceItem $item)
    {
        $this->items[] = $item;

        return $this;
    }

    abstract protected function generateFilename()
    : string;

    abstract protected function generateBuyer();

    abstract protected function generateItems();

    public function handle()
    : InvoiceHandlerContract
    {
        $this->filename = $this->generateFilename();
        $this->generateBuyer();
        $this->generateItems();

        return $this;
    }
}
