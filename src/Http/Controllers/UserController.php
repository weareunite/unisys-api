<?php

namespace Unite\UnisysApi\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Unite\UnisysApi\Http\Requests\User\StoreUserRequest;
use Unite\UnisysApi\Http\Requests\User\UpdateUserRequest;
use Unite\UnisysApi\Http\Resources\DatabaseNotificationResource;
use Unite\UnisysApi\Http\Resources\UserResource;
use Unite\UnisysApi\Repositories\UserRepository;
use Unite\UnisysApi\Models\User;

/**
 * @resource User
 *
 * User handler
 */
class UserController extends Controller
{
    protected $repository;
    protected $model;

    public function __construct(UserRepository $repository, User $model)
    {
        $this->repository = $repository;
        $this->model = $model;
    }

    public function list()
    {
        $this->authorize('hasPermission', $this->prefix('read'));

        return UserResource::collection($this->model->all());
    }

    /**
     * Profile
     *
     * @return UserResource
     */
    public function profile()
    {
        /** @var \Unite\UnisysApi\Models\User $object */
        if(!$object = Auth::user()) {
            abort(404);
        }

        return new UserResource($object);
    }

    /**
     * Show
     *
     * @param $id
     * @return UserResource
     */
    public function show($id)
    {
        if(!$object = $this->model->find($id)) {
            abort(404);
        }

        $this->authorize('view', $object);

        return new UserResource($object);
    }

    /**
     * Create
     *
     * @param StoreUserRequest $request
     * @return UserResource
     */
    public function create(StoreUserRequest $request)
    {
        $this->authorize('hasPermission', $this->prefix(__FUNCTION__));

        $data = $request->all();

        $object = $this->model->create($data);
        $object->roles()->sync( $request->get('roles') ?: [] );

        return new UserResource($object);
    }

    /**
     * Update
     *
     * @param $id
     * @param UpdateUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateUserRequest $request)
    {
        /** @var \Unite\UnisysApi\Models\User $object */
        if(!$object = $this->model->find($id)) {
            abort(404);
        }

        $this->authorize('update', $object);

        $data = $request->all();

        $object->update($data);
        $object->roles()->sync( $request->get('roles') ?: [] );

        return $this->successJsonResponse();
    }

    /**
     * List Notifications for User
     *
     * @param $id
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function notifications($id)
    {
        return $this->getNotifications($id);
    }

    /**
     * List unread notifications for User
     *
     * @param $id
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function unreadNotifications($id)
    {
        return $this->getNotifications($id, 'unreadNotifications');
    }

    /**
     * List self Notifications
     *
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function selfNotifications()
    {
        return $this->getNotifications(Auth::id());
    }

    /**
     * List self unread notifications
     *
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function selfUnreadNotifications()
    {
        return $this->getNotifications(Auth::id(), 'unreadNotifications');
    }

    /**
     * Mark all as read
     *
     * Mark all users unread notifications as read
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAllNotificationsAsRead()
    {
        /** @var \Unite\UnisysApi\Models\User $object */
        $object = Auth::user();
        $object->unreadNotifications->markAsRead();

        return $this->successJsonResponse();
    }

    protected function getNotifications($id, $type = 'notifications')
    {
        if(!$object = $this->model->find($id)) {
            abort(404);
        }

        $this->authorize('view', $object);

        return DatabaseNotificationResource::collection($object->$type);
    }
}
