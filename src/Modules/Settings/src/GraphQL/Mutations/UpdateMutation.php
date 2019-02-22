<?php

namespace Unite\UnisysApi\Modules\Settings\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Unite\UnisysApi\GraphQL\Mutations\UpdateMutation as BaseUpdateMutation;
use Unite\UnisysApi\Modules\Settings\Setting;
use Unite\UnisysApi\Modules\Settings\SettingRepository;

class UpdateMutation extends BaseUpdateMutation
{
    protected $attributes = [
        'name' => 'updateSetting',
    ];

    public function repositoryClass()
    : string
    {
        return SettingRepository::class;
    }

    public function args()
    {
        return array_merge(parent::args(), [
            'key'   => [
                'type'  => Type::string(),
                'rules' => 'required|string|max:100|unique:settings',
            ],
            'value' => [
                'type'  => Type::string(),
                'rules' => [
                    'nullable',
                ],
            ],
            'type'  => [
                'type'  => Type::string(),
                'rules' => 'nullable|in:' . implode(',', Setting::getTypes()),
            ],
        ]);
    }

    public function resolve($root, $args)
    {
        $object = $this->repository->getSettingByKey($args['key']);

        $object->update($args);

        return true;
    }
}
