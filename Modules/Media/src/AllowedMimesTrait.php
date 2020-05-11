<?php

namespace Unite\UnisysApi\Modules\Media;

trait AllowedMimesTrait
{
    protected static $allowedMimes = ['pdf', 'jpeg', 'jpg', 'png', 'xsl', 'xslx', 'doc', 'docx'];

    public static function getAllowedMimes():? array
    {
        return static::$allowedMimes;
    }
}