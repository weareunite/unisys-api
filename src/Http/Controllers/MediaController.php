<?php

namespace Unite\UnisysApi\Http\Controllers;

use Unite\UnisysApi\Repositories\MediaRepository;
use Spatie\MediaLibrary\Models\Media;

/**
 * @resource Media
 *
 * Media handler
 */
class MediaController extends Controller
{
    protected $repository;
    protected $model;

    public function __construct(MediaRepository $repository, Media $model)
    {
        $this->repository = $repository;
        $this->model = $model;
    }

    /**
     * Stream
     *
     * @param $id
     * @return mixed
     */
    public function stream($id)
    {
        $path = $this->getPathForObject($id);

        return response()->file($path);
    }

    /**
     * Download
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($id)
    {
        $path = $this->getPathForObject($id);

        return response()->download($path);
    }

    protected function getPathForObject($id)
    {
        if(!$object = $this->model->find($id)) {
            abort(404);
        }

        return $object->getPath();
    }
}
