<?php

namespace Unite\UnisysApi\Modules\Media\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Unite\UnisysApi\GraphQL\Mutations\UpdateMutation as BaseUpdateMutation;
use Unite\UnisysApi\Modules\Media\MediaRepository;

class UpdateMutation extends BaseUpdateMutation
{
    protected $attributes = [
        'name' => 'updateMedia',
    ];

    public function repositoryClass()
    : string
    {
        return MediaRepository::class;
    }

    public function args()
    {
        return array_merge(parent::args(), [
            'name' => [
                'type'        => Type::string(),
                'rules' => [
                    'string',
                ],
            ],
            'custom_properties' => [
                'type'        => Type::string(),
                'rules' => [
                    'string',
                ],
            ],
        ]);
    }
}
