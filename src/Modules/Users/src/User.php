<?php

namespace Unite\UnisysApi\Modules\Users;

use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Permission\Traits\HasRoles;
use Unite\UnisysApi\Modules\Contacts\Models\HasContacts;

class User extends AuthModel
{
    use HasRoles;
    use HasApiTokens;
    use Notifiable;
    use CausesActivity;
    use HasContacts;

    const ADMIN_ROLE_NAME   = 'admin';

    protected $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'email', 'username', 'password', 'active', 'selected_instance_id'
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
        'active' => 'boolean'
    ];

    public function instances()
    {
        return $this->belongsToMany(Instance::class, 'user_instance');
    }

    public function selected_instance()
    {
        return $this->belongsTo(Instance::class, 'selected_instance_id');
    }

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
        if(trim($this->surname) === '' || !$this->surname) {
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

    public function selectedInstanceId()
    {
        return $this->selected_instance_id;
    }
}
