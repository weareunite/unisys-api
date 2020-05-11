<?php

namespace Unite\UnisysApi\Modules\Contacts\Http\Controllers;

use Exception;
use Unite\UnisysApi\Http\Controllers\HasModel;
use Unite\UnisysApi\Modules\Contacts\Http\Resources\ContactResource;
use Unite\UnisysApi\Modules\Contacts\Models\Contact;
use Unite\UnisysApi\Http\Controllers\UnisysController;
use Unite\UnisysApi\Modules\Contacts\Http\Requests\UpdateRequest;
use Unite\UnisysApi\QueryFilter\QueryFilter;
use Unite\UnisysApi\QueryFilter\QueryFilterRequest;

/**
 * @resource Contact
 *
 * Contacts handler
 */
class ContactController extends UnisysController
{
    use HasModel;

    protected function modelClass()
    : string
    {
        return Contact::class;
    }

    public function list(QueryFilterRequest $request)
    {
        $query = $this->newQuery();

        $list = QueryFilter::paginate($request, $query);

        return ContactResource::collection($list);
    }

    /**
     * Update
     *
     * @param Contact $model
     * @param \Unite\UnisysApi\Modules\Contacts\Http\Requests\UpdateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Contact $model, UpdateRequest $request)
    {
        $model->update($request->all());

        return successJsonResponse();
    }

    /**
     * @param Contact $model
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function delete(Contact $model)
    {
        $model->delete();

        return successJsonResponse();
    }
}
