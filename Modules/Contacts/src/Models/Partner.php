<?php

namespace Unite\UnisysApi\Modules\Contacts\Models;

use Illuminate\Database\Eloquent\Builder;

class Partner extends Contact
{
    const TYPE_PARTNER = 'partner';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('onlyPartners', function (Builder $builder) {
            $builder->where('type', '=', self::TYPE_PARTNER);
        });
    }

    public function create(array $attributes = [])
    {
        if(!$companyProfile = companyProfile()) {
            throw new \Exception('Company Profile is not exists. Create company profile first');
        }

        $contact = static::query()->create($attributes);

        $contact->subject_type = get_class($companyProfile);
        $contact->subject_id = $companyProfile->id;
        $contact->type = Partner::TYPE_PARTNER;
        $contact->save();

        return $contact;
    }
}
