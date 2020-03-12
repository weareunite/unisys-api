<?php

namespace Unite\UnisysApi\Modules\GraphQL\GraphQL;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;
use GraphQL\Type\Definition\Type;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\Inputs\PaginationInput;

abstract class ListQuery extends Query
{
    use AutomaticField;

    protected $pluralizedName = true;

    public function attributes(): array
    {
        return [
            'name' => $this->name,
        ];
    }

    public function type()
    : Type
    {
        return GraphQL::paginate($this->name);
    }

    public function args()
    : array
    {
        return [
            'paging' => [
                'type' => GraphQL::type('PaginationInput'),
            ],
            'filter' => [
                'type' => GraphQL::type('QueryFilterInput'),
            ],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        /** @var SelectFields $fields */
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $limit = PaginationInput::handleLimit($args['paging']['limit'] ?? null);
        $page = PaginationInput::handlePage($args['paging']['page'] ?? null);

        $query = $this->newQuery()
            ->with($with)
            ->select($select);

        if (isset($args['filter'])) {
            $query = $query->filter($args['filter']);
        }

        return $query->paginate($limit, $select, config('query-filter.page_name'), $page);
    }
}
