<?php

namespace Unite\UnisysApi\Modules\Permissions\Http\Controllers;

use Illuminate\Http\Request;
use Unite\UnisysApi\Http\Controllers\UnisysController;
use Unite\UnisysApi\Modules\Permissions\Permission;

/**
 * @resource Role
 *
 * Roles handler
 */
class RoleController extends UnisysController
{
    public function synchronizeFrontendPermissions(Request $request)
    {
        $this->validate($request, [
            'names.*' => 'required|string',
            'secret'  => 'required|string|regex:/nYtF8FrYNGERrffd/',
        ]);

        $permissionNames = collect($request->get('names'));

        Permission::where('guard_name', '=', 'frontend')->get()->each(function (Permission $permission) use ($permissionNames) {
            if (!$permissionNames->contains($permission->name)) {
                $permission->delete();
            }
        });

        $permissionNames->each(function ($name) {
            Permission::findOrCreate($name, 'frontend');
        });

        return $this->successJsonResponse();
    }
}
