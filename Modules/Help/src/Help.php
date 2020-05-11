<?php

namespace Unite\UnisysApi\Modules\Help;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\CausesActivity;
use Unite\UnisysApi\QueryFilter\HasQueryFilter;
use Unite\UnisysApi\QueryFilter\HasQueryFilterInterface;

class Help extends Model implements HasQueryFilterInterface
{
    use CausesActivity;
    use HasQueryFilter;

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
