<?php

namespace Unite\UnisysApi\Modules\Settings\GraphQL\Mutations;

use GraphQL\Type\Definition\Type;
use Unite\UnisysApi\GraphQL\Mutations\UpdateMutation as BaseUpdateMutation;
use Unite\UnisysApi\Modules\Contacts\GraphQL\Mutations\UpdateArguments;
use Unite\UnisysApi\Modules\Settings\Services\SettingService;
use Unite\UnisysApi\Modules\Settings\SettingRepository;

class UpdateCompanyMutation extends BaseUpdateMutation
{
    protected $attributes = [
        'name' => 'updateCompany',
    ];

    public function repositoryClass()
    : string
    {
        return SettingRepository::class;
    }

    public function type()
    {
        return Type::boolean();
    }

    public function args()
    {
        return UpdateArguments::arguments();
    }

    public function resolve($root, $args)
    {
        app(SettingService::class)->saveCompanyProfile( $args );

        return true;
    }
}
