<?php

namespace Unite\UnisysApi\Models;

use Illuminate\Database\Eloquent\Model;

class InstalledModule extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];
}
