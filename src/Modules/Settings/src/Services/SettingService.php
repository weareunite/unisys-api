<?php

namespace Unite\UnisysApi\Modules\Settings\Services;

use Unite\UnisysApi\Modules\Contacts\Models\Contact;
use Unite\UnisysApi\Modules\Settings\Setting;
use Unite\UnisysApi\Modules\Settings\SettingRepository;
use Unite\UnisysApi\Services\Service;
use Cache;

class SettingService extends Service
{
    protected $repository;

    public function __construct(SettingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __get($key)
    {
        if($key === Setting::COMPANY_PROFILE_KEY) {
            return companyProfile();
        }

        if(!$setting = $this->repository->getSettingByKey($key)) {
            return null;
        }

        return $setting->value;
    }

    public function all()
    {
        return $this->repository->getAllSettings()->pluck('value', 'key');
    }

    public function companyProfile($columns = ['*']): ?Contact
    {
        if(!$setting = $this->repository->getSettingByKey(Setting::COMPANY_PROFILE_KEY, ['id'])) {
            return null;
        }

        return $setting->contacts()->first($columns);
    }

    public function saveCompanyProfile(array $data)
    {
        /** @var Setting $setting */
        if(!$setting = $this->repository->getSettingByKey(Setting::COMPANY_PROFILE_KEY, ['id'])) {
            $setting = $this->repository->create([
                'key' => Setting::COMPANY_PROFILE_KEY
            ]);
        }

        if($profile = $setting->contacts()->first()) {
            $profile->update($data);
            Cache::forget('companyProfile');
        } else {
            $profile = $setting->contacts()->create($data);
        }

        return $profile;
    }
}