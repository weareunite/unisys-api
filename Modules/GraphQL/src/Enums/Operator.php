<?php
/** @noinspection PhpUnusedPrivateFieldInspection */

namespace Unite\UnisysApi\Modules\GraphQL\Enums;

use MyCLabs\Enum\Enum;

/**
 * @method static self AND()
 * @method static self OR()
 * @method static self BETWEEN()
 * @method static self NOT()
 */
class Operator extends Enum
{
    private const AND = 'and';
    private const OR = 'or';
    private const BETWEEN = 'between';
    private const NOT = 'not';
}
