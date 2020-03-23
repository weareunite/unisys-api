<?php

namespace Unite\UnisysApi\Modules\MediaModel\Http\Controllers;

use Spatie\MediaLibrary\MediaCollections\Models\Media as MediaModel;
use Unite\UnisysApi\Http\Controllers\UnisysController;

/**
 * @resource MediaModel
 *
 * MediaModel handler
 */
class MediaModelController extends UnisysController
{
    /**
     * Stream
     *
     * @param MediaModel $model
     * @return mixed
     */
    public function stream(MediaModel $model)
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
     * @param MediaModel $model
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(MediaModel $model)
    {
        return response()->download($model->getPath(), $model->file_name);
    }
}
