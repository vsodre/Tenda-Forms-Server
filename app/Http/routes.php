<?php

use Illuminate\Http\Request;

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
$app->get('/', function() {
    return view('client');
});

$app->group(['prefix' => 'admin'], function($app){

    $app->get('questionario.html', 'App\Http\Controllers\Questionario@getHtmlShow');
    $app->get('questionario.json', 'App\Http\Controllers\Questionario@getJsonShow');

    $app->post('questionario.save', 'App\Http\Controllers\Questionario@postJsonSave');
});

$app->post('/print-photo', 'App\Http\Controllers\Photo@postPrintPhoto');
$app->post('/resposta', 'App\Http\Controllers\Questionario@postJsonResposta');
