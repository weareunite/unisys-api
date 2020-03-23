<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'namespace' => '\Unite\UnisysApi\Modules\ErrorReports\Http\Controllers',
    'middleware' => ['api', 'auth:api', 'authorize'],
    'as' => 'api.'
], function ()
{
    Route::group([ 'as' => 'errorReports.', 'prefix' => 'errorReports' ], function ()
    {
        Route::get('/',                             ['as' => 'list',                    'uses' => 'ErrorReportController@list']);
        Route::post('/',                            ['as' => 'create',                  'uses' => 'ErrorReportController@create']);
        Route::get('{id}',                          ['as' => 'show',                    'uses' => 'ErrorReportController@show']);

        Route::post('{id}/addFile',                 ['as' => 'uploadFile',              'uses' => 'ErrorReportController@uploadFile']);
        Route::get('{id}/files',                    ['as' => 'getFiles',                'uses' => 'ErrorReportController@getFiles']);
        Route::get('{id}/latestFile',               ['as' => 'getLatestFile',           'uses' => 'ErrorReportController@getLatestFile']);
        Route::delete('{id}/removeFile/{media_id}', ['as' => 'removeFile',              'uses' => 'ErrorReportController@removeFile']);
        Route::post('{id}/uploadRawFile',           ['as' => 'uploadRawFile',           'uses' => 'ErrorReportController@uploadRawFile']);
    });
});