<?php
/** @noinspection PhpUnusedPrivateFieldInspection */

namespace Unite\UnisysApi\Modules\GraphQL\Enums;

use MyCLabs\Enum\Enum;

/**
 * @method static self DESC()
 * @method static self ASC()
 */
class OrderByDirection extends Enum
{
    private const DESC = 'desc';
    private const ASC = 'asc';
}
