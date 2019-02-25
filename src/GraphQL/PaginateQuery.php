<?php
declare(strict_types=1);

namespace Unite\UnisysApi\GraphQL;

use App\GraphQL\Helpers\ResolveContext;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Traits\ShouldValidate;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

abstract class PaginateQuery extends Query
{
    use ShouldValidate;

    public function type()
    : ObjectType
    {
        return GraphQL::pagination(GraphQL::type('SomeType'));
    }

    public function resolve(array $root, ?array $data, ResolveContext $context, ResolveInfo $resolveInfo)
    : LengthAwarePaginator
    {
        $this->prepareRelations($resolveInfo);
        if ($this->prepareQuery($data)) {
            return $this->paginateData($context);
        } else {
            return new \Illuminate\Pagination\LengthAwarePaginator([], 0, $this->perPage);
        }
    }
}