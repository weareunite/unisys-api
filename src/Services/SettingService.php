<?php

namespace Unite\UnisysApi\Services;

use Unite\UnisysApi\Models\Setting;
use Unite\UnisysApi\Repositories\SettingRepository;

class SettingService extends AbstractService
{
    protected $repository;

    public function __construct(SettingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __get($key)
    {
        if($key === Setting::COMPANY_PROFILE_KEY) {
            return $this->companyProfile();
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

    public function companyProfile()
    {
        if(!$setting = $this->repository->getSettingByKey(Setting::COMPANY_PROFILE_KEY, ['id'])) {
            return null;
        }

        return $setting->contacts()->first();
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
        } else {
            $setting->contacts()->create($data);
        }
    }
}