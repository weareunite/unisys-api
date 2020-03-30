<?php

namespace Unite\UnisysApi\Modules\Users\Http;

use Illuminate\Support\Facades\Auth;
use Unite\UnisysApi\Http\Controllers\HasModel;
use Unite\UnisysApi\Http\Controllers\UnisysController;
use Unite\UnisysApi\Modules\Users\Http\Requests\StoreRequest;
use Unite\UnisysApi\Modules\Users\Http\Requests\UpdateRequest;
use Unite\UnisysApi\Modules\Users\User;
use Unite\UnisysApi\QueryFilter\QueryFilter;
use Unite\UnisysApi\QueryFilter\QueryFilterRequest;

/**
 * @resource User
 *
 * User handler
 */
class UserController extends UnisysController
{
    use HasModel;

    protected function modelClass()
    : string
    {
        return config('unisys.user');
    }

    public function list(QueryFilterRequest $request)
    {
        $list = QueryFilter::paginate($request, $this->newQuery());

        return UserResource::collection($list);
    }

    /**
     * Profile
     *
     * @return UserResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function profile()
    {
        return $this->show(Auth::id());
    }

    /**
     * Show
     *
     * @param $id
     * @return UserResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($id)
    {
        $object = $this->newQuery()->findOrFail($id);

        $this->authorize('view', $object);

        return new UserResource($object);
    }

    /**
     * Create
     *
     * @param StoreRequest $request
     * @return UserResource
     */
    public function create(StoreRequest $request)
    {
        $this->authorize('create');

        $data = $request->all();

        /** @var User $object */
        $object = $this->newQuery()->create($data);
        $object->roles()->sync($request->get('roles') ?: []);

        return new UserResource($object);
    }

    /**
     * Update
     *
     * @param $id
     * @param UpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateRequest $request)
    {
        $object = $this->newQuery()->findOrFail($id);

        $this->authorize('update', $object);

        $data = $request->all();

        $object->update($data);
        $object->roles()->sync($request->get('roles') ?: []);

        return successJsonResponse();
    }
}
