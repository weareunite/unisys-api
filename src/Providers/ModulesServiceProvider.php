<?php

namespace Unite\UnisysApi\Providers;

use Illuminate\Support\ServiceProvider;
use Unite\UnisysApi\Modules\ActivityLogs\ActivityLogServiceProvider;
use Unite\UnisysApi\Modules\Contacts\ContactsServiceProvider;
use Unite\UnisysApi\Modules\ErrorReports\ErrorReportsServiceProvider;
use Unite\UnisysApi\Modules\Help\HelpServiceProvider;
use Unite\UnisysApi\Modules\Media\MediaServiceProvider;
use Unite\UnisysApi\Modules\Permissions\PermissionsServiceProvider;
use Unite\UnisysApi\Modules\Settings\SettingsServiceProvider;
use Unite\UnisysApi\Modules\Tags\TagsServiceProvider;
use Unite\UnisysApi\Modules\Transactions\TransactionsServiceProvider;
use Unite\UnisysApi\Modules\Users\UserServiceProvider;
use Storage;

class ModulesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $directories = Storage::directories(app_path('vendors/weareunite/unisys-api/src/Modules'));

        foreach ($directories as $directory) {
            $this->app->register('Unite\UnisysApi\Modules\\' . $directory . '\src\\'. $directory .'ServiceProvider');
        }
    }
}
