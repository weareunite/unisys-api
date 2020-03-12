<?php

namespace Unite\UnisysApi\Http\Controllers;

use Exception;
use Unite\UnisysApi\Modules\Tags\Http\Requests\StoreRequest;
use Unite\UnisysApi\Modules\Tags\Http\Requests\UpdateRequest;
use Unite\UnisysApi\QueryFilter\HasQueryFilterInterface;
use Unite\UnisysApi\QueryFilter\QueryFilterRequest;

trait HasCrud
{
    use HasModel;

    abstract protected function resourceClass()
    : string;

    /*
     * List
     */
    public function list(QueryFilterRequest $request)
    {
        $query = $this->newQuery();

        if ($query instanceof HasQueryFilterInterface) {
            $query = $query->filter($request->get('filter'));
        }

        $object = $query->paginate();

        return call_user_func_array([ $this->resourceClass(), 'collection' ], [ $object ]);
    }

    /*
     * Show
     */
    public function show(int $id)
    {
        $object = $this->newQuery()->findOrFail($id);

        return new ($this->resourceClass())($object);
    }

    /*
     * Create
     */
    public function create(StoreRequest $request)
    {
        $object = $this->newQuery()->create($request->all());

        return new ($this->resourceClass())($object);
    }

    /*
     * Update
     */
    public function update(int $id, UpdateRequest $request)
    {
        $object = $this->newQuery()->findOrFail($id);
        $object->update($request->all());

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