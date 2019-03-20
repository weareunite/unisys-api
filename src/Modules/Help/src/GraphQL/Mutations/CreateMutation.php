<?php

namespace Unite\UnisysApi\Modules\Help\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Unite\UnisysApi\GraphQL\Mutations\CreateMutation as BaseCreateMutation;
use Unite\UnisysApi\Modules\Help\HelpRepository;
use GraphQL;

class CreateMutation extends BaseCreateMutation
{
    protected $attributes = [
        'name' => 'createHelp',
    ];

    public function repositoryClass()
    : string
    {
        return HelpRepository::class;
    }

    public function type()
    {
        return GraphQL::type('Help');
    }

    public function args()
    {
        return [
            'key'  => [
                'type'  => Type::string(),
                'rules' => 'required|string|max:250|unique:help,key',
            ],
            'name' => [
                'type'  => Type::string(),
                'rules' => 'nullable|string|max:250',
            ],
            'body' => [
                'type'  => Type::string(),
                'rules' => 'required|string',
            ],
        ];
    }
}
