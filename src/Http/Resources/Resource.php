<?php

namespace Unite\UnisysApi\Http\Resources;

use Illuminate\Http\Resources\Json\Resource as BaseResource;

abstract class Resource extends BaseResource
{
    abstract public static function modelClass();

    public static function eagerLoads()
    {
        return collect();
    }

    public static function tableTrough()
    {
        return collect();
    }

    public static function virtualFields()
    {
        return collect();
    }

    public static function resourceMap()
    {
        return collect();
    }
}

