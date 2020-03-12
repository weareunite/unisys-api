<?php

namespace Unite\UnisysApi\Modules\Media\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Unite\UnisysApi\Http\Controllers\HasModel;
use Unite\UnisysApi\Modules\Media\Http\Requests\UploadRequest;
use Unite\UnisysApi\Modules\Media\Http\Resources\MediaResource;
use Illuminate\Http\Request;

trait HandleUploads
{
    use HasModel;

    /**
     * @param int $id
     * @return HasMedia|Model
     */
    protected function getModel(int $id)
    : HasMedia
    {
        return $this->newQuery()->findOrFail($id);
    }

    /**
     * @param int $id
     * @param UploadRequest $request
     * @return MediaResource
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    public function uploadFile(int $id, UploadRequest $request)
    {
        /** @var InteractsWithMedia $object */
        $object = $this->getModel($id);

        $media = $object->addMediaFromRequest('file')
            ->withCustomProperties([])
            ->toMediaCollection('default');

        return new MediaResource($media);
    }

    /**
     * Upload raw file
     *
     * @param int $id
     * @param Request $request
     * @return MediaResource
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\InvalidBase64Data
     */
    public function uploadRawFile(int $id, Request $request)
    {
        /** @var InteractsWithMedia $object */
        $object = $this->getModel($id);

        $base64data = $request->input('file');

        $media = $object->addMediaFromBase64($base64data)
            ->withCustomProperties([])
            ->toMediaCollection('default');

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
        $media = $this->getModel($id)->getMedia();

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
        $mediaItem = $this->getModel($id)->getMedia()->last();

        return MediaResource::collection($mediaItem);
    }

    /**
     * Get latest files
     *
     * @param int $id
     * @param int $media_id
     */
    public function removeFile(int $id, int $media_id)
    {
        $object = $this->getModel($id);

        if ($media = $object->getMedia()->firstWhere('id', $media_id)) {
            $media->deleteMedia();
        }

        return successJsonResponse();
    }
}