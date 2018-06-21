<?php

namespace Unite\UnisysApi\Http\Controllers;

use Unite\UnisysApi\Http\Resources\RoleResource;
use Unite\UnisysApi\Repositories\UserRepository;
use Auth;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

/**
 * @resource Role
 *
 * Role handler
 */
class RoleController extends Controller
{
    protected $repository;
    protected $model;

    public function __construct(UserRepository $repository, Role $model)
    {
        $this->repository = $repository;
        $this->model = $model;
    }

    /**
     * List Roles
     * 
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function list()
    {
        $this->authorize('hasPermission', $this->prefix('update'));

        return RoleResource::collection($this->model->all());
    }
}
