<?php

namespace Unite\UnisysApi\Modules\Contacts\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Unite\UnisysApi\Helpers\CustomProperty\HasCustomProperty;
use Unite\UnisysApi\Helpers\CustomProperty\HasCustomPropertyTrait;
use Unite\UnisysApi\Models\Model;
use Unite\UnisysApi\Modules\Users\HasInstance;

class Contact extends Model implements HasCustomProperty
{
    use LogsActivity;
    use HasCustomPropertyTrait;
    use HasInstance;

    protected $table = 'contacts';

    const TYPE_DEFAULT = 'default';

    protected $fillable = [
        'type', 'name', 'surname', 'company', 'street', 'zip', 'city', 'country_id', 'reg_no', 'tax_no', 'vat_no',
        'web', 'email', 'telephone', 'description', 'custom_properties',
    ];

    protected $casts = [
        'custom_properties' => 'array',
    ];

    protected static $logAttributes = [
        'type', 'name', 'surname', 'company', 'street', 'zip', 'city', 'country_id', 'reg_no', 'tax_no', 'vat_no',
        'web', 'email', 'telephone', 'description',
    ];

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public static function getTypes()
    {
        return [
            self::TYPE_DEFAULT,
        ];
    }

    public static function getDefaultType(): string
    {
        return self::TYPE_DEFAULT;
    }

    public function getIsAbroadAttribute()
    {
        return $this->isAbroad();
    }

    public function isAbroad()
    {
        $company = companyProfile();

        return $this->country_id !== $company->country_id;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $value
     * @param int $company_country_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsAbroad($query, string $value, int $company_country_id = null)
    {
        $sql = $this->virtualIsAbroad($company_country_id) . ' = ' . $value;

        return $query->whereRaw($sql);
    }

    public function virtualIsAbroad(int $company_country_id = null): string
    {
        if(!$company_country_id) {
            $company_country_id = companyProfile()->country_id;
        }

        return 'CASE WHEN contacts.country_id = ' . $company_country_id . ' THEN false ELSE true END';
    }
}
