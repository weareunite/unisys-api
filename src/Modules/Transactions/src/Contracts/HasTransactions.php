<?php

namespace Unite\UnisysApi\Modules\Transactions\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface HasTransactions
{
    public function transactions(): MorphMany;

    public function addTransaction(array $data = []);

    public function removeTransaction(int $id);

    public function existTransactions(): bool;

    public function transactionsCount(): int;

    public function getLatestTransactions(int $limit = null);
}
