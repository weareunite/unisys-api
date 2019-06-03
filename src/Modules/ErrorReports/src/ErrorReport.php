<?php

namespace Unite\UnisysApi\Modules\ErrorReports;

use Unite\UnisysApi\Models\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Unite\UnisysApi\Modules\Media\AllowedMimesTrait;
use Unite\UnisysApi\Modules\Media\Contracts\AllowedMimes;

class ErrorReport extends Model implements HasMedia, AllowedMimes
{
    use HasMediaTrait;
    use AllowedMimesTrait;

    protected $fillable = [
        'content',
    ];

    public static function getAllowedMimes(): array
    {
        return ['jpeg', 'jpg', 'png'];
    }
}
