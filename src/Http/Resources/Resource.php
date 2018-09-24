<?php

namespace Unite\UnisysApi\Http\Resources;

use Illuminate\Http\Resources\Json\Resource as BaseResource;

class Resource extends BaseResource
{
    protected static $virtualFields = [];

    protected static function setVirtualFields(array $virtualFields)
    {
        return collect($virtualFields);
    }

    public static function virtualFields()
    {
        return self::setVirtualFields([]);
    }
}

