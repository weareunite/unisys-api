<?php

namespace Unite\UnisysApi\Services;

use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\Models\Media;
use Storage;
use Spatie\MediaLibrary\HasMedia\HasMedia;

class UploadService extends AbstractService
{
    /**
     * @var \Illuminate\Http\UploadedFile
     */
    protected $uploadedFile;

    /**
     * @var string
     */
    protected $tmpFilePath;

    /**
     * @var \Spatie\MediaLibrary\HasMedia\HasMedia
     */
    protected $model;

    /**
     * @var \Spatie\MediaLibrary\Models\Media
     */
    protected $media;

    public function upload(HasMedia $model, UploadedFile $uploadedFile): Media
    {
        $this->uploadedFile = $uploadedFile;

        $this->model = $model;

        $this->storeTmpFile();

        $this->attachFileToModel();

        $this->removeTmpFile();

        return $this->media;
    }

    protected function storeTmpFile()
    {
        $this->tmpFilePath = $this->uploadedFile->store(storage_path('tmp'));
    }

    protected function attachFileToModel(string $collectionName = 'file', array $custom_properties = [])
    {
        $this->media = $this->model
            ->addMedia(storage_path('app/'.$this->tmpFilePath))
            ->preservingOriginal()
            ->setName($this->uploadedFile->getClientOriginalName())
            ->withCustomProperties($custom_properties)
            ->toMediaCollection($collectionName);
    }

    protected function removeTmpFile()
    {
        Storage::delete(storage_path('tmp/'.$this->tmpFilePath));

        return $this;
    }
}
