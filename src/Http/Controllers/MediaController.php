<?php

namespace Unite\UnisysApi\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Unite\UnisysApi\Http\Requests\QueryRequest;
use Unite\UnisysApi\Http\Resources\MediaResource;
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
     * List
     *
     * @param QueryRequest $request
     * @return AnonymousResourceCollection|MediaResource[]
     */
    public function list(QueryRequest $request)
    {
        $this->authorize('hasPermission', $this->prefix('update'));

        $object = $this->repository->filterByRequest($request);

        return MediaResource::collection($object);
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
