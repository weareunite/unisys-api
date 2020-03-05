<?php

namespace Unite\UnisysApi\Http\Controllers;

/**
 * @resource Home
 *
 * Home handler
 */
class HomeController extends UnisysController
{
    /**
     * About
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json([
            'name' => env('APP_NAME'),
            'url' => env('APP_URL'),
            'env' => env('APP_ENV'),
            'version' => env('APP_VERSION', null),
            'database' => env('DB_DATABASE').'@'.env('DB_HOST'),
        ]);
    }
}
