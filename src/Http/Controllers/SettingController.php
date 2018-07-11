<?php

namespace Unite\UnisysApi\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Unite\Contacts\Http\Resources\ContactResource;
use Unite\UnisysApi\Http\Requests\QueryRequest;
use Unite\UnisysApi\Http\Requests\Setting\UpdateRequest;
use Unite\UnisysApi\Http\Resources\SettingResource;
use Unite\UnisysApi\Repositories\SettingRepository;
use Unite\UnisysApi\Services\SettingService;

/**
 * @resource Settings
 *
 * Settings handler
 */
class SettingController extends Controller
{
    protected $repository;
    protected $service;

    public function __construct(SettingRepository $repository, SettingService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * List
     *
     * @param QueryRequest $request
     *
     * @return AnonymousResourceCollection|SettingResource[]
     */
    public function list(QueryRequest $request)
    {
        $object = $this->repository->filterByRequest($request);

        return SettingResource::collection($object);
    }

    /**
     * Get setting value
     *
     * @param string $key
     *
     * @return string|ContactResource
     */
    public function get(string $key)
    {
        return $this->service->{$key};
    }

    /**
     * All settings array
     *
     * @return array
     */
    public function all()
    {
        return $this->service->all();
    }

    /**
     * Company profile
     *
     * @return ContactResource
     */
    public function company()
    {
        $object = $this->service->companyProfile();

        return new ContactResource($object);
    }

    /**
     * Update Company profile
     *
     * @param \Unite\Contacts\Http\Requests\UpdateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCompany(\Unite\Contacts\Http\Requests\UpdateRequest $request)
    {
        $this->service->saveCompanyProfile( $request->all() );

        return $this->successJsonResponse();

    }

    /**
     * Update
     *
     * @param UpdateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request)
    {
        $data = $request->all();

        $model = $this->repository->getSettingByKey($data['key']);

        $model->update( $data );

        return $this->successJsonResponse();
    }
}
