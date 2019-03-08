<?php

namespace Unite\UnisysApi\Modules\Users\GraphQL\Queries;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Unite\UnisysApi\GraphQL\User\UserType;
use Unite\UnisysApi\Modules\Users\User;

class NotificationsQuery extends Query
{
    protected $attributes = [
        'name' => 'users',
    ];

    public function type()
    {
        return GraphQL::pagination(GraphQL::type(UserType::class));
    }

    public function args()
    {
        return [
            'id'       => [
                'name' => 'id',
                'type' => Type::id(),
            ],
            'limit'  => [
                'name' => 'limit',
                'type' => Type::int(),
            ],
            'order'  => [
                'name' => 'order',
                'type' => Type::string(),
            ],
            'page'  => [
                'name' => 'page',
                'type' => Type::int(),
            ],
            'search'  => [
                'name' => 'search',
                'type' => Type::string(),
            ],
            'filter'  => [
                'name' => 'filter',
                'type' => Type::string(),
            ]
        ];
    }

    public function resolve($root, $args)
    {
        if (isset($args['id'])) {
            return User::where('id', $args['id'])->get();
        } else if (isset($args['email'])) {
            return User::where('email', $args['email'])->get();
        } else {
            return User::all();
        }
    }

    protected function getNotifications($id, $type = 'notifications')
    {
        if(!$object = $this->repository->find($id)) {
            abort(404);
        }

        $this->authorize('view', $object);

        return DatabaseNotificationResource::collection($object->$type);
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
}
