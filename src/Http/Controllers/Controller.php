<?php

namespace Unite\UnisysApi\Http\Controllers;

use Unite\UnisysApi\Helpers\Prefix\HasPrefixTrait;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Unite\UnisysApi\Repositories\Repository;
use Unite\UnisysApi\Response\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, HasPrefixTrait;

    /** @var \Unite\UnisysApi\Http\Resources\Resource */
    protected $resource;

    /** @var \Unite\UnisysApi\Repositories\Repository */
    protected $repository;

    /** @var Response */
    protected $response;

    protected function successJsonResponse()
    {
        return response()->json([
            'data' => ['success' => true]
        ]);
    }

    protected function jsonResponse($data, $status = 200)
    {
        return response()->json([
            'data' => $data
        ], $status);
    }

    protected function setResourceClass(string $resource)
    {
        $this->resource = $resource;

        return $this;
    }

    protected function setRepository(Repository $repo)
    {
        $this->repository = $repo;

        return $this;
    }

    protected function setResponse()
    {
        $this->response = new Response($this->repository, $this->resource);

        return $this;
    }
}
