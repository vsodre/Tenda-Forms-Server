<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

$app->get('/admin', function() {
    return redirect('/admin/questionario.html');
});

$app->group(['prefix' => 'admin'], function($app){

    $app->get('questionario.html', 'App\Http\Controllers\Questionario@getHtmlShow');
    $app->get('questionario.json', 'App\Http\Controllers\Questionario@getJsonShow');

    $app->post('questionario.save', 'App\Http\Controllers\Questionario@postJsonSave');
});
