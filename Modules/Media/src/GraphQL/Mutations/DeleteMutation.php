<?php

namespace Unite\UnisysApi\Modules\Media\GraphQL\Mutations;

use Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations\DeleteMutation as BaseDeleteMutation;
use Unite\UnisysApi\Modules\Media\Models\Media;

class DeleteMutation extends BaseDeleteMutation
{
    protected function modelClass()
    : string
    {
        return Media::class;
    }
}
