<?php

namespace Unite\UnisysApi\Modules\Users;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Permission\Traits\HasRoles;
use Unite\UnisysApi\Modules\Contacts\Models\HasContacts;
use Unite\UnisysApi\QueryFilter\HasQueryFilter;
use Unite\UnisysApi\QueryFilter\HasQueryFilterInterface;

class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract,
    HasQueryFilterInterface
{
    use Authenticatable, Authorizable, CanResetPassword;

    use HasRoles;
    use HasApiTokens;
    use Notifiable;
    use CausesActivity;
    use HasContacts;
    use HasQueryFilter;

    const ADMIN_ROLE_NAME = 'admin';

    protected $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'email', 'username', 'password', 'active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function getFrontendPermissions()
    {
        return $this->getAllPermissions()->where('guard_name', '=', 'frontend');
    }

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

    public function getFullName()
    {
        if (trim($this->surname) === '' || !$this->surname) {
            return $this->name;
        }

        return $this->name . ' ' . $this->surname;
    }

    public function findForPassport($username)
    {
        return $this->where('username', $username)->where('active', 1)->first();
    }

    public function isActive()
    {
        return $this->active;
    }
}
