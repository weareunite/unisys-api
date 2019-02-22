<?php

namespace Unite\UnisysApi\Modules\Transactions;

use Unite\UnisysApi\Repositories\Repository;
use Unite\UnisysApi\Modules\Transactions\Models\Source;

class SourceRepository extends Repository
{
    protected $modelClass = Source::class;
}