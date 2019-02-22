<?php

namespace Unite\UnisysApi\Providers;

use Illuminate\Support\ServiceProvider;
use Unite\UnisysApi\Modules\Contacts\ContactsServiceProvider;
use Unite\UnisysApi\Modules\Media\MediaServiceProvider;
use Unite\UnisysApi\Modules\Permissions\PermissionsServiceProvider;
use Unite\UnisysApi\Modules\Settings\SettingsServiceProvider;
use Unite\UnisysApi\Modules\Tags\TagsServiceProvider;
use Unite\UnisysApi\Modules\Transactions\TransactionsServiceProvider;
use Unite\UnisysApi\Modules\Users\UserServiceProvider;

class ModulesServiceProvider extends ServiceProvider
{
    protected $moduleProviders = [
        ContactsServiceProvider::class,
        MediaServiceProvider::class,
        PermissionsServiceProvider::class,
        SettingsServiceProvider::class,
        TagsServiceProvider::class,
        TransactionsServiceProvider::class,
        UserServiceProvider::class,
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        foreach ($this->moduleProviders as $moduleProvider) {
            $this->app->register($moduleProvider);
        }
    }
}
