<?php

namespace Unite\UnisysApi\Modules\ErrorReports\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Unite\UnisysApi\Http\Controllers\UnisysController;
use Unite\UnisysApi\Modules\ErrorReports\ErrorReport;
use Unite\UnisysApi\Modules\Media\Http\Controllers\HandleUploads;
use Unite\UnisysApi\QueryFilter\QueryFilter;
use Unite\UnisysApi\QueryFilter\QueryFilterRequest;

class ErrorReportController extends UnisysController
{
    use HandleUploads;

    protected function modelClass()
    : string
    {
        return ErrorReport::class;
    }

    public function list(QueryFilterRequest $request)
    {
        $args = $request->all();

        $limit = QueryFilter::handleLimit($args);
        $page = QueryFilter::handlePage($args);

        $query = $this->newQuery()->orderBy('created_at', 'desc');

        return new ResourceCollection($query->paginate($limit, [ '*' ], config('unisys.query-filter.page_name'), $page));
    }

    public function show(int $id)
    {
        return $this->newQuery()->findOrFail($id);
    }

    public function create(Request $request)
    {
        $request->validate([
            'content' => 'required',
        ]);

        return $this->newQuery()->create([
            'content' => $request->get('content'),
        ]);
    }
}
