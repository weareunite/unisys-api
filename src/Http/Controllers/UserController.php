<?php

namespace Unite\UnisysApi\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Unite\UnisysApi\Http\Requests\QueryRequest;
use Unite\UnisysApi\Http\Requests\User\StoreUserRequest;
use Unite\UnisysApi\Http\Requests\User\UpdateUserRequest;
use Unite\UnisysApi\Http\Resources\DatabaseNotificationResource;
use Unite\UnisysApi\Http\Resources\UserResource;
use Unite\UnisysApi\Repositories\UserRepository;

/**
 * @resource User
 *
 * User handler
 */
class UserController extends Controller
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * List
     *
     * @return AnonymousResourceCollection|UserResource[]
     */
    public function list(QueryRequest $request)
    {
        $object = $this->repository->with(UserResource::getRelations())->filterByRequest( $request->all() );

        return UserResource::collection($object);
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
     *
     * @return UserResource
     */
    public function show($id)
    {
        if(!$object = $this->repository->find($id)) {
            abort(404);
        }

        $this->authorize('view', $object);

        return new UserResource($object);
    }

    /**
     * Create
     *
     * @param StoreUserRequest $request
     *
     * @return UserResource
     */
    public function create(StoreUserRequest $request)
    {
        $data = $request->all();

        /** @var \Unite\UnisysApi\Models\User $object */
        $object = $this->repository->create($data);
        $object->roles()->sync( $request->get('roles_id') ?: [] );

        return new UserResource($object);
    }

    /**
     * Update
     *
     * @param $id
     * @param UpdateUserRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateUserRequest $request)
    {
        /** @var \Unite\UnisysApi\Models\User $object */
        if(!$object = $this->repository->find($id)) {
            abort(404);
        }

        $this->authorize('update', $object);

        $data = $request->all();

        $object->update($data);
        $object->roles()->sync( $request->get('roles_id') ?: [] );

        return $this->successJsonResponse();
    }

    /**
     * List Notifications for User
     *
     * @param $id
     *
     * @return AnonymousResourceCollection|DatabaseNotificationResource[]
     */
    public function notifications($id)
    {
        return $this->getNotifications($id);
    }

    /**
     * List unread notifications for User
     *
     * @param $id
     *
     * @return AnonymousResourceCollection|DatabaseNotificationResource[]
     */
    public function unreadNotifications($id)
    {
        return $this->getNotifications($id, 'unreadNotifications');
    }

    /**
     * List self Notifications
     *
     * @return AnonymousResourceCollection|DatabaseNotificationResource[]
     */
    public function selfNotifications()
    {
        return $this->getNotifications(Auth::id());
    }

    /**
     * List self unread notifications
     *
     * @return AnonymousResourceCollection|DatabaseNotificationResource[]
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
        if(!$object = $this->repository->find($id)) {
            abort(404);
        }

        $this->authorize('view', $object);

        return DatabaseNotificationResource::collection($object->$type);
    }
}
