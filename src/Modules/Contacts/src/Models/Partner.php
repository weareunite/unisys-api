<?php

namespace Unite\UnisysApi\Modules\Contacts\Models;

use Illuminate\Database\Eloquent\Builder;

class Partner extends Contact
{
    const TYPE_PARTNER = 'partner';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('onlyPartners', function (Builder $builder) {
            $builder->where('type', '=', self::TYPE_PARTNER);
        });
    }
}
