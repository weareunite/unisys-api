<?php

namespace Unite\UnisysApi\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\MediaLibrary\Models\Media;
use Unite\UnisysApi\Http\Resources\MediaResource;
use Unite\UnisysApi\QueryBuilder\QueryBuilder;
use Unite\UnisysApi\QueryBuilder\QueryBuilderRequest;
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

        $this->setResponse();

        $this->middleware('cache')->only(['list', 'show']);
    }

    /**
     * List
     *
     * @param QueryBuilderRequest $request
     * @return AnonymousResourceCollection|MediaResource[]
     */
    public function list(QueryBuilderRequest $request)
    {
        $this->authorize('hasPermission', $this->prefix('update'));

        $object = QueryBuilder::for($this->repository, $request)->paginate();

        return $this->response->collection($object);
    }

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
        return response()->download($model->getPath(), $model->name);
    }

    /**
     * Show
     *
     * @param Media $model
     *
     * @return Resource|MediaResource
     */
    public function show(Media $model)
    {
        return $this->response->resource($model);
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

        \Cache::tags('response')->flush();

        return $this->successJsonResponse();
    }
}
