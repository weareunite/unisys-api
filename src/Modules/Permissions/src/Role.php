<?php

namespace Unite\UnisysApi\Modules\Permissions;

use Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole
{
    public function getAllPermissionsWithSelected()
    {
        $allPermissions = Permission::all([
            'id',
            'name',
            'guard_name',
        ]);

        $permissionsForRole = $this->permissions()->get([
            'id',
            'name',
            'guard_name',
        ]);

        return $allPermissions->transform(function (Permission $item) use ($permissionsForRole) {
            $selected = false;

            if ($permissionsForRole->contains('id', $item->id)) {
                $selected = true;
            }

            $item->selected = $selected;

            return $item;
        });
    }
}
