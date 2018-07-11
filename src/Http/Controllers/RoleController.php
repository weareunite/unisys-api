<?php

namespace Unite\UnisysApi\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Unite\UnisysApi\Http\Requests\QueryRequest;
use Unite\UnisysApi\Http\Resources\RoleResource;
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
    }

    /**
     * List
     *
     * @param QueryRequest $request
     * @return AnonymousResourceCollection|RoleResource[]
     */
    public function list(QueryRequest $request)
    {
        $object = $this->repository->filterByRequest($request);

        return RoleResource::collection($object);
    }
}
