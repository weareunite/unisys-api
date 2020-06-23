<?php

namespace Unite\UnisysApi\Modules\Settings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
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
        'key',
        'value',
        'encrypted',
    ];

    protected $casts = [
        'encrypted' => 'bool',
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

    public function isEncrypted()
    : bool
    {
        return $this->encrypted;
    }

    public function getDecrypted()
    : ?string
    {
        if($this->isEncrypted()) {
            return Crypt::decryptString($this->value);
        }

        return $this->value;
    }

    public function set(?string $value, bool $encrypt = false)
    : string
    {
        if($encrypt) {
            $value = Crypt::encryptString($value);

            $this->encrypted = true;
        }

        $this->value = $value;

        return $this;
    }
}
