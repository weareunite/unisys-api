<?php

namespace Unite\UnisysApi\Providers;

use Illuminate\Support\ServiceProvider;

class GraphQLServiceProvider extends ServiceProvider
{
    use LoadGraphQL;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTypes(require __DIR__ . '/../GraphQL/types.php');
        $this->loadSchemas(require __DIR__ . '/../GraphQL/schemas.php');
    }
}
