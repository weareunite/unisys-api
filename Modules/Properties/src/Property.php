<?php

namespace Unite\UnisysApi\Modules\Properties;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Carbon\Carbon;
use Unite\UnisysApi\QueryFilter\HasQueryFilter;
use Unite\UnisysApi\QueryFilter\HasQueryFilterInterface;

class Property extends Model implements HasQueryFilterInterface
{
    use LogsActivity;
    use HasQueryFilter;

    protected $table = 'properties';

    protected $fillable = [
        'key', 'value',
    ];

    protected static $logAttributes = [
        'key', 'value',
    ];

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    public function getValueAttribute()
    {
        return $this->attributes['value'];
    }

    protected function detectValueType(bool $strict = false)
    {
        $value = $strict ? $this->getStrictValue() : $this->value;

        if($this->isInteger($value)) {
            return (int) $value;
        } elseif ($this->isFloat($value)) {
            return (float) $value;
        } elseif ($this->isBool($value)) {
            return (bool) $value;
        } elseif ($this->isDateTime($value)) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $value);
        } elseif ($this->isJson($value)) {
            return json_decode($value);
        }

        return $value;
    }

    protected function getStrictValue()
    {
        return trim(strtolower($this->value));
    }

    public function isJson(string $value)
    {
        json_decode($value);

        return (json_last_error() == JSON_ERROR_NONE);
    }

    public function isNumber(string $value)
    {
        return is_numeric($value);
    }

    public function isInteger(string $value)
    {
        return ($this->isNumber($value) && !$this->isFloat($value));
    }

    public function isFloat(string $value)
    {
        $floatVal = floatval($value);

        return ($floatVal && intval($floatVal) != $floatVal);
    }

    public function isBool(string $value)
    {
        return (in_array($value, ["true", "false"], true));
    }

    public function isDateTime(string $value)
    {
        return (DateTime::createFromFormat('Y-m-d H:i:s', $value) !== FALSE);
    }
}
