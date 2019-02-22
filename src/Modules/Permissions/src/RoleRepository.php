<?php

namespace Unite\UnisysApi\Modules\Permissions;

use Unite\UnisysApi\Repositories\Repository;

class RoleRepository extends Repository
{
    protected $modelClass = Role::class;
}