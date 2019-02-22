<?php

namespace Unite\UnisysApi\Modules\Transactions;

use Unite\UnisysApi\Repositories\Repository;
use Unite\UnisysApi\Modules\Transactions\Models\Transaction;

class TransactionRepository extends Repository
{
    protected $modelClass = Transaction::class;
}