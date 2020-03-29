<?php

namespace Unite\UnisysApi\Modules\GraphQL;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Rebing\GraphQL\Support\Facades\GraphQL;

trait LoadGraphQL
{
    protected function isGraphqlRequest()
    : bool
    {
        $routePrefix = Config::get('graphql.prefix');

        return Request::instance()->is($routePrefix, $routePrefix . '/*');
    }

    public function loadTypes(array $types)
    {
        GraphQL::addTypes($types);
    }

    protected function loadSchemas(array $schemas)
    {
        foreach ($schemas as $type => $schema) {
            GraphQL::addSchema($type, $schema);
        }
    }
}
