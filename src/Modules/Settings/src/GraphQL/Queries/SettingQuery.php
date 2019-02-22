<?php

namespace Unite\UnisysApi\Modules\Settings\GraphQL\Queries;

use Rebing\GraphQL\Support\Query;
use Unite\UnisysApi\Modules\Settings\Services\SettingService;
use GraphQL\Type\Definition\Type;

class SettingQuery extends Query
{
    protected $attributes = [
        'name' => 'setting',
    ];

    public function type()
    {
        return Type::string();
    }

    public function args()
    {
        return [
            'key'       => [
                'name' => 'key',
                'type' => Type::string(),
                'rules' => [
                    'required'
                ]
            ]
        ];
    }

    public function resolve($root, $args)
    {
        return app(SettingService::class)->{$args['key']};
    }
}
