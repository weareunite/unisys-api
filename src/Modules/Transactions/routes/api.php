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

Route::group([
    'namespace' => '\Unite\UnisysApi\Modules\Transactions\Http\Controllers',
    'middleware' => ['api', 'auth:api', 'authorize'],
    'as' => 'api.'
], function ()
{
    Route::group(['as' => 'transaction.', 'prefix' => 'transaction'], function ()
    {
        Route::get('/',                             ['as' => 'list',                    'uses' => 'TransactionController@list']);
        Route::get('{model}',                       ['as' => 'show',                    'uses' => 'TransactionController@show']);
        Route::delete('{model}',                    ['as' => 'delete',                  'uses' => 'TransactionController@delete']);
        Route::post('{model}/cancel',               ['as' => 'cancel',                  'uses' => 'TransactionController@cancel']);

        Route::get('export',                        ['as' => 'export',                  'uses' => 'TransactionController@export']);
    });

    Route::group(['as' => 'transactionSource.', 'prefix' => 'transactionSource'], function ()
    {
        Route::get('/',                             ['as' => 'list',                    'uses' => 'SourceController@list']);
        Route::get('{model}',                       ['as' => 'show',                    'uses' => 'SourceController@show']);
        Route::post('/',                            ['as' => 'create',                  'uses' => 'SourceController@create']);
        Route::put('{model}',                       ['as' => 'update',                  'uses' => 'SourceController@update']);
        Route::delete('{model}',                    ['as' => 'delete',                  'uses' => 'SourceController@delete']);
    });
});