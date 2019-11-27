<?php

namespace Unite\UnisysApi\Http\Controllers;

use Unite\UnisysApi\Modules\Export\Export;
use Unite\UnisysApi\Modules\Export\ExportRequest;

/**
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
            ->setResource($this->resource)
            ->setRequest($request)
            ->export();
    }
}
