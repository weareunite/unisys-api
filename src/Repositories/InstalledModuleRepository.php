<?php

namespace Unite\UnisysApi\Repositories;

use Unite\UnisysApi\Models\InstalledModule;

class InstalledModuleRepository extends Repository
{
    protected $modelClass = InstalledModule::class;

    public function isModuleInstalled(string $name): bool
    {
        return $this
            ->getQueryBuilder()
            ->where('name', '=', $name)
            ->exists();
    }
}