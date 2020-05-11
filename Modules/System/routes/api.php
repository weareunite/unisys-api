<?php

use Illuminate\Support\Facades\Route;
use Unite\UnisysApi\Modules\Settings\Settings;

Route::group([
    'namespace'  => '\Unite\UnisysApi\Modules\System\Http\Controllers',
    'middleware' => [ 'api', 'auth:api' ],
    'as'         => 'module.system.',
    'prefix'     => 'system',
], function () {
    Route::group([], Settings::PATH_TO_ROUTES);
});