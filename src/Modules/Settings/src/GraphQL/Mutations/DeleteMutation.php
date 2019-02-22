<?php

namespace Unite\UnisysApi\Modules\Settings\GraphQL\Mutations;

use Unite\UnisysApi\GraphQL\Mutations\DeleteMutation as BaseDeleteMutation;
use Unite\UnisysApi\Modules\Settings\SettingRepository;

class DeleteMutation extends BaseDeleteMutation
{
    protected $attributes = [
        'name' => 'deleteSetting',
    ];

    public function repositoryClass()
    : string
    {
        return SettingRepository::class;
    }
}
