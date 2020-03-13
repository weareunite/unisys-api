<?php

namespace Unite\UnisysApi\Modules\GraphQL\GraphQL;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Database\Eloquent\Builder;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;
use GraphQL\Type\Definition\Type;
use Unite\UnisysApi\Http\Controllers\HasModel;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\Inputs\PaginationInput;

abstract class PaginateQuery extends Query
{
    use HasModel;

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

    protected function buildQuery()
    : Builder
    {
        return $this->newQuery();
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        /** @var SelectFields $fields */
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $limit = PaginationInput::handleLimit($args['paging']['limit'] ?? null);
        $page = PaginationInput::handlePage($args['paging']['page'] ?? null);

        $query = $this->buildQuery()
            ->with($with)
            ->select($select);

        if (isset($args['filter']) ) {
            $query = $query->filter($args['filter']);
        }

        return $query->paginate($limit, $select, config('query-filter.page_name'), $page);
    }
}
