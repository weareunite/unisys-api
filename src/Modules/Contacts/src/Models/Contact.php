<?php

namespace Unite\UnisysApi\Modules\Contacts\Models;

use Domain\Charging\QueryFilters\ChargingSessionFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Unite\UnisysApi\Modules\Contacts\QueryFilters\ContactFilter;
use Unite\UnisysApi\QueryFilter\HasQueryFilter;
use Unite\UnisysApi\QueryFilter\HasQueryFilterInterface;
use Unite\UnisysApi\QueryFilter\QueryFilterInterface;

class Contact extends Model implements HasQueryFilterInterface
{
    use LogsActivity;
    use HasQueryFilter;

    protected $table = 'contacts';

    const TYPE_DEFAULT = 'default';

    protected $fillable = [
        'type', 'name', 'surname', 'company', 'street', 'zip', 'city', 'country_id', 'reg_no', 'tax_no', 'vat_no',
        'web', 'email', 'telephone', 'description',
    ];

    protected $casts = [
    ];

    protected static $logAttributes = [
        'type', 'name', 'surname', 'company', 'street', 'zip', 'city', 'country_id', 'reg_no', 'tax_no', 'vat_no',
        'web', 'email', 'telephone', 'description',
    ];

    public function newQueryFilter($query)
    : QueryFilterInterface
    {
        return new ContactFilter($query);
    }

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
        if(!$company = companyProfile()) {
            return null;
        }

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
            if(!$company = companyProfile()) {
                $company_country_id = null;
            } else {
                $company_country_id = companyProfile()->country_id;
            }
        }

        return 'CASE WHEN contacts.country_id = ' . $company_country_id . ' THEN false ELSE true END';
    }
}
