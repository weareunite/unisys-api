<?php

namespace Unite\UnisysApi\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Notifications\DatabaseNotification;
use Unite\UnisysApi\Models\Permission;
use Unite\UnisysApi\Models\User;

class UserNotificationPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the user.
     *
     * @param  \Unite\UnisysApi\Models\User  $user
     * @param  \Illuminate\Notifications\DatabaseNotification  $notification
     * @return mixed
     */
    public function view(User $user, DatabaseNotification $notification)
    {
        if ($user->hasPermissionTo(Permission::NOTIFICATION_READ_ALL)) {
            return true;
        }

        return $user->id === $notification->notifiable_id;
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  \Unite\UnisysApi\Models\User  $user
     * @param  \Illuminate\Notifications\DatabaseNotification  $notification
     * @return mixed
     */
    public function update(User $user, DatabaseNotification $notification)
    {
        if ($user->hasPermissionTo(Permission::NOTIFICATION_UPDATE_ALL)) {
            return true;
        }

        return $user->id === $notification->notifiable_id;
    }
}
