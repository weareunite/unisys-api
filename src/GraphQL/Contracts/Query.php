<?php

namespace Unite\UnisysApi\GraphQL\Contracts;

use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;

interface Query
{
    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info);
}
