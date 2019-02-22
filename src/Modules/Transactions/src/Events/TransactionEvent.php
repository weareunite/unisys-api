<?php

namespace Unite\UnisysApi\Modules\Transactions\Events;

use Illuminate\Queue\SerializesModels;
use Unite\UnisysApi\Modules\Transactions\Models\Transaction;

abstract class TransactionEvent
{
    use SerializesModels;

    public $transaction;

    /**
     * Create a new event instance.
     *
     * @param  Transaction $transaction
     * @return void
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }
}