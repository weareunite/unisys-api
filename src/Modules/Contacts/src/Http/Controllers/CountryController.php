<?php

namespace Unite\UnisysApi\Modules\Contacts\Http\Controllers;

use Unite\UnisysApi\Http\Controllers\HasModel;
use Unite\UnisysApi\Modules\Contacts\Http\Resources\ContactResource;
use Unite\UnisysApi\Modules\Contacts\Http\Resources\CountryForSelectResource;
use Unite\UnisysApi\Modules\Contacts\Models\Country;
use Unite\UnisysApi\Http\Controllers\UnisysController;
use Unite\UnisysApi\QueryFilter\QueryFilter;
use Unite\UnisysApi\QueryFilter\QueryFilterRequest;

/**
 * @resource Country
 *
 * Country handler
 */
class CountryController extends UnisysController
{
    use HasModel;

    protected function modelClass()
    : string
    {
        return Country::class;
    }

    public function list(QueryFilterRequest $request)
    {
        $query = $this->newQuery();

        $list = QueryFilter::paginate($request, $query);

        return ContactResource::collection($list);
    }

    public function show(Country $model)
    {
        return new ContactResource($model);
    }

    public function listForSelect()
    {
        $object = Country::query()
            ->orderBy('name', 'asc')
            ->get([ 'id', 'name' ]);

        return CountryForSelectResource::collection($object);
    }
}
