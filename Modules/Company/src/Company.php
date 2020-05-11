<?php

namespace Unite\UnisysApi\Modules\Company;

use Illuminate\Database\Eloquent\Model;
use Unite\UnisysApi\Modules\Contacts\Contracts\HasContactProfile;
use Unite\UnisysApi\Modules\Contacts\Models\HasOneContactProfile;

class Company extends Model implements HasContactProfile
{
    use HasOneContactProfile;

    const CACHE_NAME = 'companyProfile';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
