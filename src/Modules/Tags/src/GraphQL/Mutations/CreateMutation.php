<?php

namespace Unite\UnisysApi\Modules\Tags\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use GraphQL;
use Unite\UnisysApi\GraphQL\Mutations\CreateMutation as BaseCreateMutation;
use Unite\UnisysApi\Modules\Tags\TagRepository;

class CreateMutation extends BaseCreateMutation
{
    protected $attributes = [
        'name' => 'createTag',
    ];

    public function repositoryClass()
    : string
    {
        return TagRepository::class;
    }

    public function type()
    {
        return GraphQL::type('Tag');
    }

    public function args()
    {
        return [
            'name'     => [
                'type' => Type::string(),
                'rules'=> 'required|string',
            ],
            'type'  => [
                'type' => Type::string(),
                'rules'=> 'nullable|array',

            ],
            'custom_properties' => [
                'type' => Type::listOf(Type::int()),
                'rules'=> 'nullable|array',
            ],
        ];
    }
}
