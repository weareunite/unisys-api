<?php

namespace Unite\UnisysApi\Modules\Tags\Http\Controllers;

use Unite\UnisysApi\Modules\Tags\Http\Requests\AttachRequest;
use Unite\UnisysApi\Modules\Tags\Http\Requests\DetachRequest;
use Unite\UnisysApi\Modules\Tags\Http\Requests\MassAttachRequest;

/**
 * @property-read \Unite\UnisysApi\Repositories\Repository $repository
 */
trait AttachDetachTags
{
    /**
     * Attach Tags
     *
     * Attach array of tags to given model find by model primary id
     *
     * @param int $id
     * @param AttachRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function attachTags(int $id, AttachRequest $request)
    {
        /** @var \Unite\UnisysApi\Modules\Tags\Contracts\HasTags $object */
        if(!$object = $this->repository->find($id)) {
            abort(404);
        }

        $data = $request->only(['tag_names']);

        $object->attachTags($data['tag_names']);

        \Cache::tags('response')->flush();

        return $this->successJsonResponse();
    }

    /**
     * Mass Attach Tags
     *
     * Attach array of tags to many models by given array of models id
     *
     * @param MassAttachRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function massAttachTags(MassAttachRequest $request)
    {
        $data = $request->only(['ids', 'tag_names']);

        foreach ($data['ids'] as $model_id) {
            /** @var \Unite\UnisysApi\Modules\Tags\Contracts\HasTags $object */
            if($object = $this->repository->find($model_id)) {
                $object->attachTags($data['tag_names']);
            }
        }

        \Cache::tags('response')->flush();

        return $this->successJsonResponse();
    }

    /**
     * Detach tags
     *
     * Detach array of tags from given model find by model primary id
     *
     * @param int $id
     * @param DetachRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function detachTags(int $id, DetachRequest $request)
    {
        /** @var \Unite\UnisysApi\Modules\Tags\Contracts\HasTags $object */
        if(!$object = $this->repository->find($id)) {
            abort(404);
        }

        $data = $request->only('tag_names');

        $object->detachTags($data['tag_names']);

        \Cache::tags('response')->flush();

        return $this->successJsonResponse();
    }
}
