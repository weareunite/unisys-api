<?php

Route::group([
    'namespace' => '\Unite\UnisysApi\Modules\ErrorReports\Http\Controllers',
    'middleware' => ['api', 'auth:api', 'authorize'],
    'as' => 'api.'
], function ()
{
    Route::group([ 'as' => 'errorReports.', 'prefix' => 'errorReports' ], function ()
    {
        Route::get('/',             ['as' => 'list',              'uses' => 'ErrorReportController@list']);
        Route::post('/',            ['as' => 'create',            'uses' => 'ErrorReportController@create']);
        Route::get('{id}',          ['as' => 'show',              'uses' => 'ErrorReportController@show']);
    });
});