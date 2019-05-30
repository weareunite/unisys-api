<?php

namespace Unite\UnisysApi\Modules\Contacts;

use Unite\UnisysApi\Modules\Contacts\Models\Partner;
use Unite\UnisysApi\Repositories\Repository;

/**
 * @method Partner getQueryBuilder()
 */
class PartnerRepository extends Repository
{
    protected $modelClass = Partner::class;

    public function create(array $attributes = [])
    {
        if(!$companyProfile = companyProfile()) {
            throw new \Exception('Company Profile is not exists. Create company profile first');
        }

        $contact = parent::create( $attributes );

        $contact->subject_type = get_class($companyProfile);
        $contact->subject_id = $companyProfile->id;
        $contact->type = Partner::TYPE_PARTNER;
        $contact->save();

        return $contact;
    }
}