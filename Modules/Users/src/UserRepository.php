<?php

namespace Unite\UnisysApi\Modules\Users;

use Unite\UnisysApi\Repositories\Repository;

class UserRepository extends Repository
{
    protected $modelClass = User::class;
}