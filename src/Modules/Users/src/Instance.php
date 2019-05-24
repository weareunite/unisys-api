<?php

namespace Unite\UnisysApi\Modules\Users;

use Unite\UnisysApi\Models\Model;

class Instance extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'url',
    ];
}

