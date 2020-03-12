<?php

namespace Unite\UnisysApi\Modules\Tags\GraphQL\Mutations;

use Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations\UpdateMutation as BaseUpdateMutation;
use Unite\UnisysApi\Modules\Tags\GraphQL\Inputs\TagInput;
use Unite\UnisysApi\Modules\Tags\Tag;

class UpdateMutation extends BaseUpdateMutation
{
    protected function inputClass()
    : string
    {
        return TagInput::class;
    }

    protected function modelClass()
    : string
    {
        return Tag::class;
    }
}
