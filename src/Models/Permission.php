<?php

namespace Unite\UnisysApi\Models;

use Spatie\Permission\Models\Permission as BasePermission;

class Permission extends BasePermission
{
    const USER_READ_ALL             = 'global.user.readAll';
    const USER_UPDATE_ALL           = 'global.user.updateAll';
    const NOTIFICATION_READ_ALL     = 'global.notification.readAll';
    const NOTIFICATION_UPDATE_ALL   = 'global.notification.updateAll';

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
