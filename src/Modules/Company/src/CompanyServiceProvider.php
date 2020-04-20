<?php

namespace Unite\UnisysApi\Modules\Company;

use Illuminate\Support\ServiceProvider;
use Unite\UnisysApi\Modules\Company\Console\Commands\Install;
use Unite\UnisysApi\Modules\GraphQL\LoadGraphQL;

class CompanyServiceProvider extends ServiceProvider
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

            $timestamp = date('Y_m_d_His', time());

            if (!class_exists('CreateCompaniesTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_companies_table.php.stub' => database_path("/migrations/{$timestamp}_create_companies_table.php"),
                ], 'migrations');
            }
        }

        $this->loadGraphQLFrom(__DIR__ . '/GraphQL/types.php', __DIR__ . '/GraphQL/schemas.php');

        $this->app->singleton(CompanyService::class, CompanyService::class);

        $this->app->singleton('companyProfile', function () {
            return app(CompanyService::class)->getProfile();
        });
    }
}
