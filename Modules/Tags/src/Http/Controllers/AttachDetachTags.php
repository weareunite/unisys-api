<?php

namespace Unite\UnisysApi\Modules\Tags\Http\Controllers;

use Unite\UnisysApi\Http\Controllers\HasModel;
use Unite\UnisysApi\Modules\Tags\Contracts\HasTags;
use Unite\UnisysApi\Modules\Tags\Http\Requests\AttachRequest;
use Unite\UnisysApi\Modules\Tags\Http\Requests\DetachRequest;
use Unite\UnisysApi\Modules\Tags\Http\Requests\MassAttachRequest;

trait AttachDetachTags
{
    use HasModel;

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
        $object = $this->newQuery()->findOrFail($id);

        if ($object instanceof HasTags) {
            abort(400, 'Object is not instance of HasTags');
        }

        $data = $request->only([ 'tag_names' ]);

        $object->attachTags($data['tag_names']);

        return successJsonResponse();
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
        $data = $request->only([ 'ids', 'tag_names' ]);

        /** @var HasTags[] $objects */
        $objects = $this->newQuery()->whereIn('id', $data['ids'])->get();

        if (!isset($objects[0]) || !$objects[0] instanceof HasTags) {
            abort(400, 'Object is not instance of HasTags');
        }

        foreach ($objects as $object) {
            $object->attachTags($data['tag_names']);
        }

        return successJsonResponse();
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
        $object = $this->newQuery()->findOrFail($id);

        if ($object instanceof HasTags) {
            abort(400, 'Object is not instance of HasTags');
        }

        $data = $request->only('tag_names');

        $object->detachTags($data['tag_names']);

        return successJsonResponse();
    }
}
