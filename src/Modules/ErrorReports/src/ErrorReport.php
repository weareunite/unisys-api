<?php

namespace Unite\UnisysApi\Modules\ErrorReports;

use Unite\UnisysApi\Models\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class ErrorReport extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $fillable = [
        'content',
    ];
}
