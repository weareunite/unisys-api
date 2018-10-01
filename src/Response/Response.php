<?php

namespace Unite\UnisysApi\Response;

use Illuminate\Database\Eloquent\Model;
use Unite\UnisysApi\Repositories\Repository;

class Response
{
    /** @var Repository */
    protected $repository;

    /** @var \Unite\UnisysApi\Http\Resources\Resource */
    protected $resourceClass;

    /** @var string */
    protected $cacheKey;

    public function __construct(Repository $repository, string $resourceClass = null)
    {
        $this->repository = $repository;
        $this->resourceClass = $resourceClass;
    }

    public function resource(Model $model, string $resourceClass = null)
    {
        /** @var \Unite\UnisysApi\Http\Resources\Resource $resourceClass */
        $resourceClass = $resourceClass ?: $this->resourceClass;

        $model->load( $resourceClass::getEagerLoads() );

        /** @var Resource $resource */
        $resource = (new $resourceClass($model));

        return $resource;
    }

    public function collection($collection, string $resourceClass = null)
    {
        /** @var \Unite\UnisysApi\Http\Resources\Resource $resourceClass */
        $resourceClass = $resourceClass ?: $this->resourceClass;

        return $resourceClass::collection($collection);
    }
}