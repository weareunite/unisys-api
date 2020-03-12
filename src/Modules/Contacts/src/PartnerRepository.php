<?php

namespace Unite\UnisysApi\Modules\Contacts;

use Unite\UnisysApi\Modules\Contacts\Models\Partner;
use Unite\UnisysApi\Repositories\Repository;

class PartnerRepository extends Repository
{
    protected $modelClass = Partner::class;
}