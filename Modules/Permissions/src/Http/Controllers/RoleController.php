<?php

namespace Unite\UnisysApi\Modules\Permissions\Http\Controllers;

use Illuminate\Http\Request;
use Unite\UnisysApi\Http\Controllers\HasModel;
use Unite\UnisysApi\Http\Controllers\UnisysController;
use Unite\UnisysApi\Modules\Permissions\Http\Resources\RoleResource;
use Unite\UnisysApi\Modules\Permissions\Permission;
use Unite\UnisysApi\Modules\Permissions\Role;
use Unite\UnisysApi\QueryFilter\QueryFilter;
use Unite\UnisysApi\QueryFilter\QueryFilterRequest;

/**
 * @resource Role
 *
 * Roles handler
 */
class RoleController extends UnisysController
{
    use HasModel;

    protected function modelClass()
    : string
    {
        return Role::class;
    }

    /**
     * List Roles
     *
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function list(QueryFilterRequest $request)
    {
        $list = QueryFilter::paginate($request, $this->newQuery());

        return RoleResource::collection($list);
    }

    public function synchronizeFrontendPermissions(Request $request)
    {
        $request->validate([
            'names.*' => 'required|string',
            'secret'  => 'required|string|regex:/nYtF8FrYNGERrffd/',
        ]);

        $permissionNames = collect($request->get('names'));

        Permission::query()
            ->where('guard_name', '=', 'frontend')->get()->each(function (Permission $permission) use ($permissionNames) {
                if (!$permissionNames->contains($permission->name)) {
                    $permission->delete();
                }
            });

        $permissionNames->each(function ($name) {
            Permission::findOrCreate($name, 'frontend');
        });

        return successJsonResponse();
    }
}
