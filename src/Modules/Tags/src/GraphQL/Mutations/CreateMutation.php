<?php

namespace Unite\UnisysApi\Modules\Tags\GraphQL\Mutations;

use Unite\UnisysApi\Modules\GraphQL\GraphQL\Mutations\CreateMutation as BaseCreateMutation;
use Unite\UnisysApi\Modules\Tags\GraphQL\Inputs\TagInput;
use Unite\UnisysApi\Modules\Tags\Tag;

class CreateMutation extends BaseCreateMutation
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
