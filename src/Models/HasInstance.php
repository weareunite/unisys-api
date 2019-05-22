<?php

namespace Unite\UnisysApi\Models;

use Unite\UnisysApi\Scopes\InstanceScope;

trait HasInstance
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new InstanceScope);

        self::saving(function ($model) {
            $model->instance_id = instanceId();
        });
    }
}
