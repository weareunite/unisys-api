<?php

namespace Unite\UnisysApi\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Unite\UnisysApi\Http\Resources\RoleResource;
use Unite\UnisysApi\QueryBuilder\QueryBuilder;
use Unite\UnisysApi\QueryBuilder\QueryBuilderRequest;
use Unite\UnisysApi\Repositories\RoleRepository;

/**
 * @resource Roles
 *
 * Role handler
 */
class RoleController extends Controller
{
    protected $repository;

    public function __construct(RoleRepository $repository)
    {
        $this->repository = $repository;

        $this->setResourceClass(RoleResource::class);

        $this->setResponse();

        $this->middleware('cache')->only(['list']);
    }

    /**
     * List
     *
     * @param QueryBuilderRequest $request
     * @return AnonymousResourceCollection|RoleResource[]
     */
    public function list(QueryBuilderRequest $request)
    {
        $object = QueryBuilder::for($this->resource, $request)->paginate();

        return $this->response->collection($object);
    }
}
