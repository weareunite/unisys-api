<?php

namespace Unite\UnisysApi\Http\Controllers;

use Unite\UnisysApi\Http\Requests\MassDeleteRequest;

/**
 * @property-read \Unite\UnisysApi\Repositories\Repository $repository
 */
trait MassDelete
{
    /**
     * Mass Delete
     *
     * Mass delete many models byt ids
     *
     * @param $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function massDelete(MassDeleteRequest $request)
    {
        $data = $request->only('ids');

        $this->repository->massDelete($data['ids']);

        \Cache::tags('response')->flush();

        return $this->successJsonResponse();
    }
}
