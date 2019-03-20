<?php

namespace Unite\UnisysApi\Modules\Help;

use Spatie\Activitylog\Traits\CausesActivity;
use Unite\UnisysApi\Models\Model;

class Help extends Model
{
    use CausesActivity;

    protected $table = 'help';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key', 'name', 'body',
    ];
}
