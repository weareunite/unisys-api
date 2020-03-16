<?php

namespace Unite\UnisysApi\Modules\GraphQL\GraphQL;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\SelectFields;
use Unite\UnisysApi\Http\Controllers\HasModel;

abstract class DetailQuery extends Query
{
    use HasModel;

    public function attributes()
    : array
    {
        return [
            'name'        => lcfirst($this->name),
            'description' => $this->type ?: $this->name . ' details',
        ];
    }

    public function type()
    : Type
    {
        return GraphQL::type($this->type ?: $this->name);
    }

    public function args()
    : array
    {
        return [
            'id' => [
                'type' => Type::int(),
            ],
        ];
    }

    protected function find(array $args, SelectFields $fields)
    {
        $this->model = $this->newQuery()->with($fields->getRelations())
            ->select($fields->getSelect())
            ->where('id', '=', $args['id'])
            ->firstOrFail();
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $this->find($args, $getSelectFields());

        return $this->model;
    }
}
