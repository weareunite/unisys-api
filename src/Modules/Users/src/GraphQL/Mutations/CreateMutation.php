<?php

namespace Unite\UnisysApi\Modules\Users\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Unite\UnisysApi\GraphQL\Mutations\CreateMutation as BaseCreateMutation;
use Illuminate\Database\Eloquent\Model;
use Unite\UnisysApi\Modules\Users\User;
use Unite\UnisysApi\Modules\Users\UserRepository;
use GraphQL;

class CreateMutation extends BaseCreateMutation
{
    protected $attributes = [
        'name' => 'createUser',
    ];

    public function repositoryClass()
    : string
    {
        return UserRepository::class;
    }

    public function type()
    {
        return GraphQL::type('User');
    }

    public function args()
    {
        return [
            'name'                  => [
                'type'  => Type::string(),
                'rules' => 'required|string|min:3|max:100',
            ],
            'surname'               => [
                'type'  => Type::string(),
                'rules' => 'string|max:100',
            ],
            'email'                 => [
                'type'  => Type::string(),
                'rules' => 'required|email|unique:users,email',
            ],
            'username'              => [
                'type'  => Type::string(),
                'rules' => 'required|regex:/^\S*$/u|min:4|max:20|unique:users',
            ],
            'password'              => [
                'type'  => Type::string(),
                'rules' => 'required|string|confirmed|min:6|max:30',
            ],
            'password_confirmation' => [
                'type'  => Type::string(),
                'rules' => 'required|string|min:6|max:30',
            ],
            'active'                => [
                'type'  => Type::boolean(),
                'rules' => [
                    'boolean',
                ],
            ],
            'roles_ids'             => [
                'type'  => Type::listOf(Type::int()),
                'rules' => 'array',
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $this->beforeCreate($root, $args);

        $users = $this->repository->getQueryBuilder()
            ->where('users.username', '=', $args['username'])
            ->orWhere('users.email', '=', $args['email'])
            ->get(['users.id']);

        if(!$users) {
            $object = $this->repository->create($args);
        } elseif ($users->count() === 1) {
            /** @var User $object */
            $object = $users->first();
        } else {
            throw new \Exception('Cannot create record with this combination username and email');
        }

        if(!$object->instances->contains(instanceId())) {
            $object->instances()->attach(instanceId());
        }

        if (isset($args['roles_ids'])) {
            $object->roles()->sync($args['roles_ids'] ?: []);
        }

        return $object;
    }
}
