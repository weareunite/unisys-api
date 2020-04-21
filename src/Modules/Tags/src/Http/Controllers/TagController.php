<?php

namespace Unite\UnisysApi\Modules\Tags\Http\Controllers;

use Exception;
use Unite\UnisysApi\Http\Controllers\HasModel;
use Unite\UnisysApi\Modules\Tags\Http\Requests\StoreRequest;
use Unite\UnisysApi\Modules\Tags\Http\Requests\UpdateRequest;
use Unite\UnisysApi\Modules\Tags\Http\Resources\TagResource;
use Unite\UnisysApi\Modules\Tags\Tag;
use Unite\UnisysApi\Http\Controllers\UnisysController;
use Unite\UnisysApi\QueryFilter\QueryFilter;
use Unite\UnisysApi\QueryFilter\QueryFilterRequest;

/**
 * @resource Tags
 *
 * Tag handler
 */
class TagController extends UnisysController
{
    use HasModel;

    protected function modelClass()
    : string
    {
        return Tag::class;
    }

    /*
     * List
     */
    public function list(QueryFilterRequest $request)
    {
        $list = QueryFilter::paginate($request, $this->newQuery());

        return TagResource::collection($list);
    }

    /*
     * Show
     */
    public function show(int $id)
    {
        $object = $this->newQuery()->findOrFail($id);

        return new TagResource($object);
    }

    /*
     * Create
     */
    public function create(StoreRequest $request)
    {
        /** @var Tag $object */
        $object = $this->newQuery()->create($request->all());

        foreach ($request->get('properties') as $property) {
            $object->addProperty($property['key'], $property['value']);
        }

        return new TagResource($object);
    }

    /*
     * Update
     */
    public function update(int $id, UpdateRequest $request)
    {
        /** @var Tag $object */
        $object = $this->newQuery()->findOrFail($id);
        $object->update($request->all());

        $object->handleProperties($request->get('properties') ?? null);

        return successJsonResponse();
    }

    /*
     * Delete
     */
    public function delete(int $id)
    {
        $object = $this->newQuery()->findOrFail($id);

        try {
            $object->delete();
        } catch (Exception $exception) {
            abort(400, 'Object can not be deleted');
        }

        return successJsonResponse();
    }
}