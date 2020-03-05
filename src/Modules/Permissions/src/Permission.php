<?php

namespace Unite\UnisysApi\Modules\Permissions;

use Spatie\Permission\Models\Permission as BasePermission;
use Unite\UnisysApi\QueryFilter\HasQueryFilter;

class Permission extends BasePermission
{
    use HasQueryFilter;

    const USER_READ_ALL             = 'global.user.readAll';
    const USER_UPDATE_ALL           = 'global.user.updateAll';
    const NOTIFICATION_READ_ALL     = 'global.notification.readAll';
    const NOTIFICATION_UPDATE_ALL   = 'global.notification.updateAll';

    protected $fillable = [
        'name',
        'guard_name',
    ];

    public static function getGlobalPermissions()
    {
        return collect([
            self::USER_READ_ALL,
            self::USER_UPDATE_ALL,
            self::NOTIFICATION_READ_ALL,
            self::NOTIFICATION_UPDATE_ALL,
        ]);
    }
}
