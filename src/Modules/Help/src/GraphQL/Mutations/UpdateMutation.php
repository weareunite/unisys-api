<?php

namespace Unite\UnisysApi\Modules\Help\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Unite\UnisysApi\GraphQL\Mutations\UpdateMutation as BaseUpdateMutation;
use Unite\UnisysApi\Modules\Help\HelpRepository;

class UpdateMutation extends BaseUpdateMutation
{
    protected $attributes = [
        'name' => 'updateHelp',
    ];

    public function repositoryClass()
    : string
    {
        return HelpRepository::class;
    }

    public function args()
    {
        return array_merge(parent::args(), [
            'key'  => [
                'type' => Type::string(),
            ],
            'name' => [
                'type'  => Type::string(),
                'rules' => 'nullable|string|max:250',
            ],
            'body' => [
                'type'  => Type::string(),
                'rules' => 'required|string',
            ],
        ]);
    }

    public function rules(array $args = [])
    {
        return [
            'key' => [
                'string',
                'unique:help,key,' . $args['id'],
            ],
        ];
    }
}
