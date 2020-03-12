<?php

namespace Unite\UnisysApi\Modules\Settings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\CausesActivity;

abstract class AbstractSetting extends Model
{
    use CausesActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key', 'value',
    ];

    protected $primaryKey = 'key';

    public $timestamps = false;

    public function setKeyAttribute($value)
    {
        $this->attributes['key'] = Str::slug($value);
    }

    public function getShortValueAttribute()
    {
        return Str::limit($this->value);
    }
}
