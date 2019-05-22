<?php

namespace Unite\UnisysApi\Models;

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

