<?php

namespace Unite\UnisysApi\Modules\Contacts;

use Illuminate\Support\ServiceProvider;
use Unite\UnisysApi\Modules\Contacts\Console\Commands\Install;
use Unite\UnisysApi\Modules\GraphQL\LoadGraphQL;

class ContactsServiceProvider extends ServiceProvider
{
    use LoadGraphQL;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Install::class,
            ]);

            if (!class_exists('CreateContactsTables')) {
                $timestamp = date('Y_m_d_His', time());

                $this->publishes([
                    __DIR__ . '/../database/migrations/create_contacts_tables.php.stub' => database_path("migrations/{$timestamp}_create_contacts_tables.php"),
                ], 'migrations');
            }
        }

        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

        $this->loadTypes(require __DIR__ . '/GraphQL/types.php');
        $this->loadSchemas(require __DIR__ . '/GraphQL/schemas.php');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->register(\Webpatser\Countries\CountriesServiceProvider::class);

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Countries', \Webpatser\Countries\CountriesFacade::class);
    }
}
