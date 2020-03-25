<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => '\Unite\UnisysApi\Modules\Permissions\Http\Controllers',
    'as' => 'api.'
], function ()
{
    Route::group([ 'as' => 'role.', 'prefix' => 'role' ], function ()
    {
        Route::post('synchronizeFrontendPermissions',   ['as' => 'synchronizeFrontendPermissions',  'uses' => 'RoleController@synchronizeFrontendPermissions']);
    });

    Route::group(['as' => 'role.', 'prefix' => 'role'], function ()
    {
        Route::get('/',                             ['as' => 'list',                    'uses' => 'RoleController@list']);
    });
});