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
            ->filterByRequest( $request->all() );

        return $this->resource::collection($object);
    }

    /**
     * Stream
     *
     * @param Media $mediaItem
     * @return mixed
     */
    public function stream(Media $mediaItem)
    {
        return response()->stream($mediaItem->getPath());
    }

    /**
     * Download
     *
     * @param Media $mediaItem
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(Media $mediaItem)
    {
        return response()->download($mediaItem->getPath(), $mediaItem->name);
    }
}
