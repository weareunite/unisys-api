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

    protected $resourceClass = TagResource::class;

    protected $storeRequestClass = StoreRequest::class;

    protected $updateRequestClass = UpdateRequest::class;

    /*
     * List
     */
    public function list(QueryFilterRequest $request)
    {
        $list = QueryFilter::paginate($request, $this->newQuery());

        return forward_static_call_array([ $this->resourceClass, 'collection' ], [ $list ]);
    }

    /*
     * Show
     */
    public function show(int $id)
    {
        $object = $this->newQuery()->findOrFail($id);

        $class = $this->resourceClass;

        return (new $class)($object);
    }

    /*
     * Create
     */
    public function create()
    {
        $request = app($this->storeRequestClass);

        /** @var Tag $object */
        $object = $this->newQuery()->create($request->all());

        foreach ($request->get('properties') as $property) {
            $object->addProperty($property['key'], $property['value']);
        }

        $class = $this->resourceClass;

        return (new $class)($object);
    }

    /*
     * Update
     */
    public function update(int $id)
    {
        $request = app($this->updateRequestClass);

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