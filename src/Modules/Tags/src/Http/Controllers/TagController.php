<?php

namespace Unite\UnisysApi\Modules\Tags\Http\Controllers;

use Unite\UnisysApi\Modules\Tags\Http\Resources\TagResource;
use Unite\UnisysApi\Modules\Tags\Tag;
use Unite\UnisysApi\Http\Controllers\UnisysController;

/**
 * @resource Tags
 *
 * Tag handler
 */
class TagController extends UnisysController
{
    use HasCrud;

    protected function modelClass()
    : string
    {
        return Tag::class;
    }

    protected function resourceClass()
    : string
    {
        return TagResource::class;
    }
}