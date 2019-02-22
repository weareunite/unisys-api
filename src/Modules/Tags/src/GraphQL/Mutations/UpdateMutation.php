<?php

namespace Unite\UnisysApi\Modules\Tags\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Unite\UnisysApi\GraphQL\Mutations\UpdateMutation as BaseUpdateMutation;
use Unite\UnisysApi\Modules\Tags\TagRepository;

class UpdateMutation extends BaseUpdateMutation
{
    protected $attributes = [
        'name' => 'updateTag',
    ];

    public function repositoryClass(): string
    {
        return TagRepository::class;
    }

    public function args()
    {
        return array_merge(
            parent::args(),
            [
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
            ]);
    }
}
