<?php

namespace Unite\UnisysApi\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
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
        if(!$object = $this->repository->find($id)) {
            abort(404);
        }

        return $object->getPath();
    }
}
