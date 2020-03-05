<?php

namespace Unite\UnisysApi\Http\Controllers;

use Unite\UnisysApi\Helpers\Prefix\HasPrefixTrait;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UnisysController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, HasPrefixTrait;

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
}
