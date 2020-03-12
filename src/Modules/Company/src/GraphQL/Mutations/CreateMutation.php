<?php

namespace Unite\UnisysApi\Modules\Company\GraphQL\Mutations;

use Unite\UnisysApi\Modules\Company\Company;
use Unite\UnisysApi\Modules\Company\CompanyService;
use Unite\UnisysApi\Modules\Company\GraphQL\Inputs\CompanyInput;
use Unite\UnisysApi\Modules\Contacts\Contracts\HasContactProfile;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations\CreateMutation as BaseCreateMutation;

/**
 * @property HasContactProfile $model
 */
class CreateMutation extends BaseCreateMutation
{
    protected function inputClass()
    : string
    {
        return CompanyInput::class;
    }

    protected function modelClass()
    : string
    {
        return Company::class;
    }

    public function resolve($root, $args)
    {
        return app(CompanyService::class)->create($args);
    }
}

