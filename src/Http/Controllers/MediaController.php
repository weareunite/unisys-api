<?php

namespace Unite\UnisysApi\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\MediaLibrary\Models\Media;
use Unite\UnisysApi\Http\Requests\QueryRequest;
use Unite\UnisysApi\Http\Resources\MediaResource;
use Unite\UnisysApi\Repositories\MediaRepository;

/**
 * @resource Media
 *
 * Media handler
 */
class MediaController extends Controller
{
    protected $repository;

    public function __construct(MediaRepository $repository)
    {
        $this->repository = $repository;

        $this->setResourceClass(MediaResource::class);
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

        $object = $this->repository
            ->with($this->repository->getResourceRelations())
            ->filterByRequest($request->all());

        return $this->resource::collection($object);
    }

    /**
     * Stream
     *
     * @param Media $model
     * @return mixed
     */
    public function stream(Media $model)
    {
        return response()->stream($model->getPath());
    }

    /**
     * Download
     *
     * @param Media $model
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(Media $model)
    {
        return response()->download($model->getPath(), $model->name);
    }

    /**
     * Show
     *
     * @param Media $model
     *
     * @return MediaResource
     */
    public function show(Media $model)
    {
        return new MediaResource($model);
    }

    /**
     * Delete
     *
     * @param Media $model
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Media $model)
    {
        try {
            $model->delete();
        } catch (\Exception $e) {
            abort(409, 'Cannot delete record');
        }

        return $this->successJsonResponse();
    }
}
