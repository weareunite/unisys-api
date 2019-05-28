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
    'namespace' => '\Unite\UnisysApi\Modules\Contacts\Http\Controllers',
    'middleware' => ['api', 'auth:api', 'authorize'],
    'as' => 'api.'
], function ()
{
    Route::group(['as' => 'contact.', 'prefix' => 'contact'], function ()
    {
        Route::get('/',                             ['as' => 'list',                    'uses' => 'ContactController@list']);
        Route::put('{model}',                       ['as' => 'update',                  'uses' => 'ContactController@update']);
        Route::delete('{model}',                    ['as' => 'delete',                  'uses' => 'ContactController@delete']);
    });

    Route::group(['as' => 'country.', 'prefix' => 'country'], function ()
    {
        Route::get('/',                             ['as' => 'list',                    'uses' => 'CountryController@list']);
        Route::get('listForSelect',                 ['as' => 'listForSelect',           'uses' => 'CountryController@listForSelect']);
        Route::get('{model}',                       ['as' => 'show',                    'uses' => 'CountryController@show']);
    });
});