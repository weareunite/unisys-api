<?php

namespace Unite\UnisysApi\QueryBuilder;

use Illuminate\Support\ServiceProvider;

class QueryBuilderServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton(QueryBuilder::class, QueryBuilder::class);
    }
}
