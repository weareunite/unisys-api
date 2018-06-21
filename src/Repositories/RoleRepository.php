<?php

namespace Unite\UnisysApi\Repositories;

use Spatie\Permission\Models\Role;

class RoleRepository extends Repository
{
    protected $modelClass = Role::class;
}