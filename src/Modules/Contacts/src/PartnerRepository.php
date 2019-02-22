<?php

namespace Unite\UnisysApi\Modules\Contacts;

use Unite\UnisysApi\Models\Setting;
use Unite\UnisysApi\Modules\Contacts\Models\Partner;
use Unite\UnisysApi\Repositories\Repository;
use Unite\UnisysApi\Repositories\SettingRepository;

/**
 * @method Partner getQueryBuilder()
 */
class PartnerRepository extends Repository
{
    protected $modelClass = Partner::class;

    public function create(array $attributes = [])
    {
        $companyProfile = companyProfile();

        $contact = parent::create( $attributes );

        $contact->subject_type = get_class($companyProfile);
        $contact->subject_id = $companyProfile->id;
        $contact->type = Partner::TYPE_PARTNER;
        $contact->save();

        return $contact;
    }
}