<?php

namespace Unite\UnisysApi\Modules\System\GraphQL\Queries;

use Unite\UnisysApi\Modules\GraphQL\GraphQL\Queries\ListQuery as BaseListQuery;
use Unite\UnisysApi\Modules\System\SystemSetting;

class ListQuery extends BaseListQuery
{
    protected $type = 'Setting';

    protected function modelClass()
    : string
    {
        return SystemSetting::class;
    }
}
