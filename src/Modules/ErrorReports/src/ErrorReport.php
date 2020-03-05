<?php

namespace Unite\UnisysApi\Modules\ErrorReports;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Unite\UnisysApi\Modules\Media\AllowedMimesTrait;
use Unite\UnisysApi\Modules\Media\Contracts\AllowedMimes;
use Unite\UnisysApi\QueryFilter\HasQueryFilter;
use Unite\UnisysApi\QueryFilter\HasQueryFilterInterface;

class ErrorReport extends Model implements HasMedia, AllowedMimes, HasQueryFilterInterface
{
    use HasMediaTrait;
    use AllowedMimesTrait;
    use HasQueryFilter;

    protected $fillable = [
        'content',
    ];

    public static function getAllowedMimes(): array
    {
        return ['jpeg', 'jpg', 'png'];
    }
}
