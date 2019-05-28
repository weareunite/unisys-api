<?php

namespace Unite\UnisysApi\Modules\Transactions\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Unite\UnisysApi\Modules\Transactions\Http\Requests\Source\StoreRequest;
use Unite\UnisysApi\Modules\Transactions\Http\Requests\Source\UpdateRequest;
use Unite\UnisysApi\Modules\Transactions\Http\Resources\SourceResource;
use Unite\UnisysApi\Modules\Transactions\Models\Source;
use Unite\UnisysApi\Modules\Transactions\SourceRepository;
use Unite\UnisysApi\Http\Controllers\Controller;
use Unite\UnisysApi\QueryBuilder\QueryBuilder;
use Unite\UnisysApi\QueryBuilder\QueryBuilderRequest;

/**
 * @resource Transaction Sources
 *
 * Transaction Sources handler
 */
class SourceController extends Controller
{
    protected $repository;

    public function __construct(SourceRepository $repository)
    {
        $this->repository = $repository;

        $this->setResourceClass(SourceResource::class);

        $this->setResponse();

        $this->middleware('cache')->only(['list', 'show']);
    }

    /**
     * List
     *
     * @param QueryBuilderRequest $request
     * @return AnonymousResourceCollection|SourceResource[]
     */
    public function list(QueryBuilderRequest $request)
    {
        $object = QueryBuilder::for($this->resource, $request)->paginate();

        return $this->response->collection($object);
    }

    /**
     * Show
     *
     * @param Source $model
     * @return Resource|SourceResource
     */
    public function show(Source $model)
    {
        return $this->response->resource($model);
    }

    /**
     * Create
     *
     * @param StoreRequest $request
     * @return Resource|SourceResource
     */
    public function create(StoreRequest $request)
    {
        $data = $request->all();

        $object = $this->repository->create($data);

        \Cache::tags('response')->flush();

        return $this->response->resource($object);
    }

    /**
     * Update
     *
     * @param Source $model
     * @param UpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Source $model, UpdateRequest $request)
    {
        $data = $request->all();

        $model->update($data);

        \Cache::tags('response')->flush();

        return $this->successJsonResponse();
    }

    /**
     * Delete
     *
     * @param Source $model
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Source $model)
    {
        try {
            $model->delete();
        } catch(\Exception $e) {
            abort(409, 'Cannot delete record');
        }

        \Cache::tags('response')->flush();

        return $this->successJsonResponse();
    }
}
