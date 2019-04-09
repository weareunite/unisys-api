<?php

namespace Unite\UnisysApi\Providers;

use GraphQL;

trait LoadGraphQL
{
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
