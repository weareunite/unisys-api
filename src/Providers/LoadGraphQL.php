<?php

namespace Unite\UnisysApi\Providers;

use Rebing\GraphQL\Support\Facades\GraphQL;

trait LoadGraphQL
{
    public function loadTypes(array $types)
    {
        GraphQL::addTypes($types);
    }

    protected function loadSchemas(array $schemas)
    {
        $allSchemas = GraphQL::getSchemas();

        foreach ($schemas as $type => $schema) {
            if(isset($allSchemas[$type])) {
                $allSchemas[$type]['query'] = array_merge($allSchemas[$type]['query'], $schema['query']);
                $allSchemas[$type]['mutation'] = array_merge($allSchemas[$type]['mutation'], $schema['mutation']);

                GraphQL::addSchema($type, $allSchemas[$type]);

            }
        }
    }
}
