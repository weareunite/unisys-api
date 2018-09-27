<?php

namespace Unite\UnisysApi\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Auth;
use Unite\UnisysApi\Http\Requests\User\StoreUserRequest;
use Unite\UnisysApi\Http\Requests\User\UpdateUserRequest;
use Unite\UnisysApi\Http\Resources\DatabaseNotificationResource;
use Unite\UnisysApi\Http\Resources\UserResource;
use Unite\UnisysApi\QueryBuilder\QueryBuilder;
use Unite\UnisysApi\QueryBuilder\QueryBuilderRequest;
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

        $this->setResourceClass(UserResource::class);

        $this->setResponse();

        $this->middleware('cache')->only([
            'list', 'profile', 'show',
            'notifications', 'unreadNotifications', 'selfNotifications', 'selfUnreadNotifications'
        ]);
    }

    /**
     * List
     *
     * @param QueryBuilderRequest $request
     * @return AnonymousResourceCollection|UserResource[]
     */
    public function list(QueryBuilderRequest $request)
    {
        $object = QueryBuilder::for($this->resource, $request)->paginate();

        return $this->response->collection($object);
    }

    /**
     * Profile
     *
     * @return Resource|UserResource
     */
    public function profile()
    {
        /** @var \Unite\UnisysApi\Models\User $object */
        if(!$object = Auth::user()) {
            abort(404);
        }

        return $this->response->resource($object);
    }

    /**
     * Show
     *
     * @param $id
     *
     * @return Resource|UserResource
     */
    public function show($id)
    {
        if(!$object = $this->repository->find($id)) {
            abort(404);
        }

        $this->authorize('view', $object);

        return $this->response->resource($object);
    }

    /**
     * Create
     *
     * @param StoreUserRequest $request
     *
     * @return Resource|UserResource
     */
    public function create(StoreUserRequest $request)
    {
        $data = $request->all();

        /** @var \Unite\UnisysApi\Models\User $object */
        $object = $this->repository->create($data);
        $object->roles()->sync( $request->get('roles_id') ?: [] );

        \Cache::tags('response')->flush();

        return $this->response->resource($object);
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

        \Cache::tags('response')->flush();

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

        \Cache::tags('response')->flush();

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
