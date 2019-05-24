<?php

namespace Unite\UnisysApi\Modules\Users;

use Unite\UnisysApi\Modules\Users\Scopes\InstanceScope;

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
