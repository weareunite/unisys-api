<?php

namespace Unite\UnisysApi\Modules\Users\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\Inputs\Input;

class UserInput extends Input
{
    public function fields()
    : array
    {
        return [
            'name'                  => [
                'type'  => Type::string(),
                'rules' => [
                    $this->isUpdate ? '' : 'required',
                    'string',
                    'min:3',
                    'max:100',
                ],
            ],
            'surname'               => [
                'type'  => Type::string(),
                'rules' => 'string|max:100',
            ],
            'email'                 => [
                'type'  => Type::string(),
                'rules' => [
                    $this->isUpdate ? '' : 'required',
                    'email',
                    'unique:users,email',
                ],
            ],
            'username'              => [
                'type'  => Type::string(),
                'rules' => [
                    $this->isUpdate ? '' : 'required',
                    'regex:/^\S*$/u',
                    'min:4',
                    'max:20',
                    'unique:users',
                ],
            ],
            'password'              => [
                'type'  => Type::string(),
                'rules' => [
                    $this->isUpdate ? '' : 'required',
                    'string',
                    'confirmed',
                    'min:6',
                    'max:30',
                ],
            ],
            'password_confirmation' => [
                'type'  => Type::string(),
                'rules' => [
                    $this->isUpdate ? '' : 'required',
                    'string',
                    'min:6',
                    'max:30',
                ],
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
}