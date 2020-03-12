<?php

namespace Unite\UnisysApi\Modules\Company\GraphQL\Mutations;

use Illuminate\Support\Facades\Cache;
use Unite\UnisysApi\Modules\Company\Company;
use Unite\UnisysApi\Modules\Company\CompanyService;
use Unite\UnisysApi\Modules\Company\GraphQL\Inputs\CompanyInput;
use Unite\UnisysApi\Modules\Contacts\Contracts\HasContactProfile;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations\UpdateMutation as BaseUpdateMutation;

/**
 * @property HasContactProfile $model
 */
class UpdateMutation extends BaseUpdateMutation
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

    protected function update(array $data)
    {
        app(CompanyService::class)->update($this->model, $data);
    }
}
