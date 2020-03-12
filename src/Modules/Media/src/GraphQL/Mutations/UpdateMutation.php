<?php

namespace Unite\UnisysApi\Modules\Media\GraphQL\Mutations;

use Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations\UpdateMutation as BaseUpdateMutation;
use Unite\UnisysApi\Modules\Media\GraphQL\Inputs\MediaInput;
use Unite\UnisysApi\Modules\Media\Models\Media;

class UpdateMutation extends BaseUpdateMutation
{
    protected function modelClass()
    : string
    {
        return Media::class;
    }

    protected function inputClass()
    : string
    {
        return MediaInput::class;
    }
}
