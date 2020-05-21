<?php

namespace Unite\UnisysApi\Modules\GraphQL\GraphQL\Queries;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Database\Eloquent\Builder;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;
use GraphQL\Type\Definition\Type;
use Unite\UnisysApi\Http\Controllers\HasModel;
use Unite\UnisysApi\QueryFilter\QueryFilter;

abstract class PaginateQuery extends Query
{
    use HasModel;

    public function type()
    : Type
    {
        return GraphQL::paginate($this->type ?: $this->name);
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

    /**
     * @param array $args
     * @return Builder
     */
    protected function buildQuery(array $args)
    {
        return $this->newQuery();
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        /** @var SelectFields $fields */
        $fields = $getSelectFields();
        $select = $fields->getSelect();
        $with = $fields->getRelations();

        $limit = QueryFilter::handleLimit($args['paging']['limit'] ?? null);
        $page = QueryFilter::handlePage($args['paging']['page'] ?? null);

        $query = $this->buildQuery($args)
            ->with($with)
            ->addSelect($select);

        if (isset($args['filter']) && method_exists($this->modelClass(), 'scopeFilter')) {
            $query = $query->filter($args['filter']);
        }

        return $query->paginate($limit, $query->getQuery()->columns, config('unisys.query-filter.page_name'), $page);
    }
}
