<?php

namespace Unite\UnisysApi\Modules\Media\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Unite\UnisysApi\Modules\Media\Http\Requests\UploadRequest;
use Unite\UnisysApi\Modules\Media\Http\Resources\MediaResource;
use Unite\UnisysApi\Modules\Media\Services\UploadService;

/**
 * @property-read \Unite\UnisysApi\Repositories\Repository $repository
 */
trait HandleUploads
{
    /**
     * Upload file
     *
     * @param int $id
     * @param UploadRequest $request
     * @param UploadService $uploadService
     * @return MediaResource
     */
    public function uploadFile(int $id, UploadRequest $request, UploadService $uploadService)
    {
        if(!$object = $this->repository->find($id)) {
            abort(404);
        }

        $file = $request->file('file');

        $media = $uploadService->upload($object, $file);

        \Cache::tags('response')->flush();

        return new MediaResource($media);
    }

    /**
     * Get all Files
     *
     * @param int $id
     * @return AnonymousResourceCollection|MediaResource[]
     */
    public function getFiles(int $id)
    {
        if(!$object = $this->repository->find($id)) {
            abort(404);
        }

        $media = $object->getMedia();

        return MediaResource::collection($media);
    }

    /**
     * Get latest files
     *
     * @param int $id
     * @return AnonymousResourceCollection|MediaResource[]
     */
    public function getLatestFile(int $id)
    {
        if(!$object = $this->repository->find($id)) {
            abort(404);
        }

        $mediaItem = $object->getMedia()->last();

        return MediaResource::collection($mediaItem);
    }

    /**
     * Get latest files
     *
     * @param int $id
     * @param int $media_id
     * @return bool
     */
    public function removeFile(int $id, int $media_id)
    {
        if(!$object = $this->repository->find($id)) {
            abort(404);
        }

        if($media = $object->getMedia()->firstWhere('id', $media_id)) {
            $media->delete();
        }

        return $this->successJsonResponse();
    }
}