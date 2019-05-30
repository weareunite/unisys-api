<?php

namespace Unite\UnisysApi\Modules\Transactions;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Unite\UnisysApi\Modules\Transactions\Console\Commands\Install;
use Unite\UnisysApi\Providers\LoadGraphQL;

class TransactionsServiceProvider extends ServiceProvider
{
    use LoadGraphQL;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->commands([
            Install::class,
        ]);

        if (! class_exists('CreateTransactionsTable')) {
            $timestamp = date('Y_m_d_His', time());

            $this->publishes([
                __DIR__.'/../database/migrations/create_transactions_tables.php.stub' => database_path("/migrations/{$timestamp}_create_transactions_tables.php"),
            ], 'migrations');
        }

        Event::subscribe(TransactionSubscriber::class);

        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

        $this->loadTypes(require __DIR__ . '/GraphQL/types.php');
        $this->loadSchemas(require __DIR__ . '/GraphQL/schemas.php');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
    }
}
