<?php

namespace Unite\UnisysApi\Modules\ErrorReports;

use Unite\UnisysApi\Models\Model;

class ErrorReport extends Model
{
    protected $fillable = [
        'content',
    ];
}
