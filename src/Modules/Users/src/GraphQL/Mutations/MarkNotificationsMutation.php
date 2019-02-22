<?php

namespace Unite\UnisysApi\Modules\Users\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Unite\UnisysApi\GraphQL\Mutations\UpdateMutation as BaseUpdateMutation;
use Unite\UnisysApi\Models\Model;
use Unite\UnisysApi\Modules\Users\UserRepository;

class MarkNotificationsMutation extends BaseUpdateMutation
{
    protected $attributes = [
        'name' => 'updateUser',
    ];

    public function repositoryClass()
    : string
    {
        return UserRepository::class;
    }

    public function type()
    {
        return Type::boolean();
    }

    public function args()
    {
        return array_merge(parent::args(), [
            'name'     => [
                'type' => Type::string(),
                'rules' => 'string|min:3|max:100',
            ],
            'surname'  => [
                'type' => Type::string(),
                'rules' => 'string|max:100',
            ],
            'email'    => [
                'type' => Type::string(),
                'rules' => 'email|unique:users,email,'.$this->id,
            ],
            'username' => [
                'type' => Type::string(),
                'rules' => 'regex:/^\S*$/u|min:4|max:20|unique:users,username,'.$this->id,
            ],
            'password' => [
                'type' => Type::string(),
                'rules' => 'string|confirmed|min:6|max:30',
            ],
            'password_confirmation' => [
                'type' => Type::string(),
                'rules' => 'required_with:password|string|min:6|max:30',
            ],
            'role_ids' => [
                'type' => Type::listOf(Type::int()),
                'rules' => 'required|array',
            ],
        ]);
    }

    protected function afterUpdate(Model $model, $root, $args)
    {
        /** @var \Unite\UnisysApi\Modules\Users\User $object */
        $object = Auth::user();
        $object->unreadNotifications->markAsRead();
    }

    public function markAsRead($uid)
    {
        if(!$object = $this->model->find($uid)) {
            abort(404);
        }

        $this->authorize('update', $object);

        $object->markAsRead();

        \Cache::tags('response')->flush();

        return $this->successJsonResponse();
    }

    /**
     * Mark as unread
     *
     * @param $uid
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsUnread($uid)
    {
        if(!$object = $this->model->find($uid)) {
            abort(404);
        }

        $this->authorize('update', $object);

        if (!is_null($object->read_at)) {
            $object->forceFill(['read_at' => null])->save();
        }

        \Cache::tags('response')->flush();

        return $this->successJsonResponse();
    }
}
