<?php

namespace Unite\UnisysApi\Modules\Permissions;

use Unite\UnisysApi\Repositories\Repository;

class PermissionRepository extends Repository
{
    protected $modelClass = Permission::class;
}