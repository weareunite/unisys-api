<?php

namespace Unite\UnisysApi\Modules\Tags\GraphQL\Mutations;

use Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations\DeleteMutation as BaseDeleteMutation;
use Unite\UnisysApi\Modules\Tags\Tag;

class DeleteMutation extends BaseDeleteMutation
{
    protected function modelClass()
    : string
    {
        return Tag::class;
    }
}
