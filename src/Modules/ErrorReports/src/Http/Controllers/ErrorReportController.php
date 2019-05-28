<?php

namespace Unite\UnisysApi\Modules\ErrorReports\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Unite\UnisysApi\GraphQL\PaginationInput;
use Unite\UnisysApi\Http\Controllers\Controller;
use Unite\UnisysApi\Modules\ErrorReports\ErrorReport;
use Unite\UnisysApi\QueryBuilder\QueryBuilderRequest;

class ErrorReportController extends Controller
{
    public function list(QueryBuilderRequest $request)
    {
        $args = $request->all();

        $limit = PaginationInput::handleLimit($args);
        $page = PaginationInput::handlePage($args);

        $query = ErrorReport::query()->orderBy('created_at', 'desc');

        return new ResourceCollection($query->paginate($limit, ['*'], config('query-filter.page_name'), $page));
    }

    public function show(int $id)
    {
        return ErrorReport::findOrFail($id);
    }

    public function create(Request $request)
    {
        $request->validate([
            'content' => 'required',
        ]);

        return ErrorReport::create([
            'content' => $request->get('content')
        ]);
    }
}
