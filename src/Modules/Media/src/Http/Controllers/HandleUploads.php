<?php

namespace Unite\UnisysApi\Modules\Media\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Unite\UnisysApi\Modules\Media\Http\Requests\UploadRequest;
use Unite\UnisysApi\Modules\Media\Http\Resources\MediaResource;
use Unite\UnisysApi\Modules\Media\Services\UploadService;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesser;

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
        if (!$object = $this->repository->find($id)) {
            abort(404);
        }

        $file = $request->file('file');

        $media = $uploadService->upload($object, $file);

        \Cache::tags('response')->flush();

        return new MediaResource($media);
    }

    /**
     * Upload raw file
     *
     * @param int $id
     * @param UploadRequest $request
     * @param UploadService $uploadService
     * @return MediaResource
     */
    public function uploadRawFile(int $id, Request $request, UploadService $uploadService)
    {
        if (!$object = $this->repository->find($id)) {
            abort(404);
        }

        $base64data = $request->input('file');

        // strip out data uri scheme information (see RFC 2397)
        if (strpos($base64data, ';base64') !== false) {
            list(, $base64data) = explode(';', $base64data);
            list(, $base64data) = explode(',', $base64data);
        }

        // strict mode filters for non-base64 alphabet characters
        if (base64_decode($base64data, true) === false) {
            return false;
        }

        // decoding and then reeconding should not change the data
        if (base64_encode(base64_decode($base64data)) !== $base64data) {
            return false;
        }

        $binaryData = base64_decode($base64data);

        // temporarily store the decoded data on the filesystem to be able to pass it to the fileAdder
        $tmpFile = tempnam(sys_get_temp_dir(), 'medialibrary');
        file_put_contents($tmpFile, $binaryData);

        // Check the MimeTypes
        $validation = \Illuminate\Support\Facades\Validator::make(
            ['file' => new \Illuminate\Http\File($tmpFile)],
            ['file' => 'mimes:' . implode(',', $this->repository->getModelClass()::getAllowedMimes())]
        );

        if($validation->fails()) {
            return false;
        }

        $mimeType = finfo_buffer(finfo_open(), $binaryData, FILEINFO_MIME_TYPE);
        $extension = ExtensionGuesser::getInstance()->guess($mimeType);

        $file = app(UploadedFile::class, [
            'path' => $tmpFile,
            'originalName' => uniqid('decoded_').'.'.$extension,
            'mimeType' => $mimeType,
            'error' => null,
            'test' => true
        ]);

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
        if (!$object = $this->repository->find($id)) {
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
        if (!$object = $this->repository->find($id)) {
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
        if (!$object = $this->repository->find($id)) {
            abort(404);
        }

        if ($media = $object->getMedia()->firstWhere('id', $media_id)) {
            $media->delete();
        }

        return $this->successJsonResponse();
    }
}