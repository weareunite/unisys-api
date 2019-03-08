<?php

namespace Unite\UnisysApi\Modules\Settings\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Unite\UnisysApi\Modules\Settings\Setting;
use Unite\UnisysApi\GraphQL\Mutations\CreateMutation as BaseCreateMutation;
use Unite\UnisysApi\Modules\Settings\SettingRepository;
use GraphQL;

class CreateMutation extends BaseCreateMutation
{
    protected $attributes = [
        'name' => 'createSetting',
    ];

    public function repositoryClass()
    : string
    {
        return SettingRepository::class;
    }

    public function type()
    {
        return GraphQL::type('Setting');
    }

    public function args()
    {
        return [
            'key'           => [
                'type'  => Type::string(),
                'rules' => 'required|string|max:100|unique:settings',
            ],
            'value'           => [
                'type'  => Type::string(),
                'rules' => [
                    'nullable',
                ],
            ],
            'type'           => [
                'type'  => Type::string(),
                'rules' => 'nullable|in:'.implode(',', Setting::getTypes()),
            ],
        ];
    }
}
