<?php

namespace Unite\UnisysApi\Modules\Contacts\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Unite\UnisysApi\Modules\Contacts\CountryRepository;
use Unite\UnisysApi\Modules\Contacts\Http\Resources\CountryForSelectResource;
use Unite\UnisysApi\Modules\Contacts\Http\Resources\CountryResource;
use Unite\UnisysApi\Modules\Contacts\Models\Country;
use Unite\UnisysApi\Http\Controllers\UnisysController;
use Unite\UnisysApi\QueryBuilder\QueryBuilder;
use Unite\UnisysApi\QueryFilter\QueryFilterRequest;

/**
 * @resource Country
 *
 * Country handler
 */
class CountryController extends UnisysController
{
    protected $repository;

    public function __construct(CountryRepository $repository)
    {
        $this->repository = $repository;

        $this->setResourceClass(CountryResource::class);

        $this->setResponse();

        $this->middleware('cache')->only(['list', 'show', 'listForSelect']);
    }

    /**
     * List
     *
     * @param QueryFilterRequest $request
     * @return AnonymousResourceCollection|Resource[]
     */
    public function list(QueryFilterRequest $request)
    {
        $object = QueryBuilder::for($this->resource, $request)->paginate();

        return $this->response->collection($object);
    }

    /**
     * Show
     *
     * @param Country $model
     *
     * @return Resource
     */
    public function show(Country $model)
    {
        return $this->response->resource($model);
    }

    /**
     * List for select
     *
     * @return AnonymousResourceCollection|CountryForSelectResource[]
     */
    public function listForSelect()
    {
        $object = Country::orderBy('name', 'asc')
            ->get(['id', 'name']);

        return $this->response->collection($object, CountryForSelectResource::class);
    }
}
