<?php

namespace Unite\UnisysApi\Http\Resources;

use Illuminate\Http\Resources\Json\Resource as BaseResource;

class Resource extends BaseResource
{
    protected static $relations = [];

    public static function getRelations(): array
    {
        return self::$relations;
    }
}

