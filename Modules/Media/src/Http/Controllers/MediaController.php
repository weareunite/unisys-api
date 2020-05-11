<?php

namespace Unite\UnisysApi\Modules\Media\Http\Controllers;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Unite\UnisysApi\Http\Controllers\UnisysController;

class MediaController extends UnisysController
{
    /**
     * Stream
     *
     * @param Media $model
     * @return mixed
     */
    public function stream(Media $model)
    {
        return response()->stream(function() use ($model) {
            $stream = $model->stream();

            fpassthru($stream);

            if (is_resource($stream)) {
                fclose($stream);
            }
        });
    }

    /**
     * Download
     *
     * @param Media $model
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(Media $model)
    {
        return response()->download($model->getPath(), $model->file_name);
    }
}
