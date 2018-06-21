<?php

namespace Unite\UnisysApi\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Permission\Traits\HasRoles;

/**
 * Unite\UnisysApi\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\Unite\UnisysApi\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Unite\UnisysApi\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Unite\UnisysApi\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Unite\UnisysApi\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Unite\UnisysApi\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Unite\UnisysApi\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Unite\UnisysApi\Models\User whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @method static \Illuminate\Database\Eloquent\Builder|\Unite\UnisysApi\Models\User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\Unite\UnisysApi\Models\User role($roles)
 * @property string|null $username
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activity
 * @property-read \Illuminate\Database\Eloquent\Collection|\Illuminate\Notifications\DatabaseNotification $unreadNotifications
 * @method static \Illuminate\Database\Eloquent\Builder|\Unite\UnisysApi\Models\User whereUsername($value)
 */
class User extends Authenticatable
{
    use HasRoles;
    use HasApiTokens;
    use Notifiable;
    use CausesActivity;

    const ADMIN_ROLE_NAME   = 'admin';

    protected $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    //  =================================================================================================
    //
    //  Setters
    //
    //  =================================================================================================

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }


    //  =================================================================================================
    //
    //  Getters
    //
    //  =================================================================================================

    public function isAdmin()
    {
        if ($this->hasRole(self::ADMIN_ROLE_NAME)) {
            return true;
        }

        return false;
    }

    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }
}
