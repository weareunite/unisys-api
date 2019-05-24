<?php

namespace Unite\UnisysApi\Modules\Users;

use Unite\UnisysApi\Models\Model;

class UserInstance extends Model
{
    protected $table = 'user_instance';

    public function instance()
    {
        return $this->belongsTo(Instance::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

