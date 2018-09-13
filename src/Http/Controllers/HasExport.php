<?php

namespace Unite\UnisysApi\Http\Controllers;

use Unite\UnisysApi\Export\Export;
use Unite\UnisysApi\Export\ExportRequest;

/**
 * @property-read \Unite\UnisysApi\Repositories\Repository $repository
 * @property-read \Unite\UnisysApi\Http\Resources\Resource $resource
 */
trait HasExport
{
    /**
     * Export resource
     *
     * @param ExportRequest $request
     * @param Export $export
     */
    public function export(ExportRequest $request, Export $export)
    {
        $export
            ->setRepository($this->repository)
            ->setRequest($request)
            ->export();
    }
}
