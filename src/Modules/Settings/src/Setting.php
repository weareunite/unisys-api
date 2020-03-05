<?php

namespace Unite\UnisysApi\Modules\Settings;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\CausesActivity;
use Unite\UnisysApi\Modules\Contacts\Contracts\HasContacts as HasContactsContract;
use Unite\UnisysApi\Modules\Contacts\Models\HasContacts;
use Unite\UnisysApi\QueryFilter\HasQueryFilter;
use Unite\UnisysApi\QueryFilter\HasQueryFilterInterface;

class Setting extends Model implements HasContactsContract, HasQueryFilterInterface
{
    use CausesActivity;
    use HasContacts;
    use HasQueryFilter;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key', 'value', 'type',
    ];

    public $timestamps = false;

    const TYPE_INPUT    = 'input';
    const TYPE_TEXT     = 'text';
    const TYPE_CHECKBOX = 'checkbox';
    const TYPE_SELECT   = 'select';

    const DEFAULT_TYPE  = self::TYPE_INPUT;

    const COMPANY_PROFILE_KEY = 'company-profile';

    public function setKeyAttribute($value)
    {
        $this->attributes['key'] = str_slug($value);
    }

    public function setTypeAttribute($value)
    {
        if(!in_array($value, self::getTypes())) {
            $value = self::DEFAULT_TYPE;
        }

        $this->attributes['type'] = $value;
    }

    public function getShortValueAttribute()
    {
        return str_limit($this->value);
    }

    public static function getTypes()
    {
        return [
            self::TYPE_INPUT,
            self::TYPE_TEXT,
            self::TYPE_CHECKBOX,
            self::TYPE_SELECT,
        ];
    }
}

