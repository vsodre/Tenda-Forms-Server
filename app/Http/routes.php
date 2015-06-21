<?php

use App\Resposta;

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
Route::get('/admin', function(){
    return redirect('/admin/questionario.html');
});
Route::get('/', function(){
    return view('client');
});
Route::group(['prefix' => 'admin'], function(){
    Route::get('dados.html', ['as' => 'admin.dados', function(){
        // Respost
        return view('admin', ['page'=>'dados']);
        }]);
    Route::get('questionario.html', ['as' => 'admin.questionario', 'uses'=>'Questionario@getHtmlShow']);
    Route::get('questionario.json', 'Questionario@getJsonShow');
    Route::post('questionario.save', 'Questionario@postJsonSave');
});
Route::post('/print-photo', 'Photo@postPrintPhoto');
Route::post('/resposta', 'Questionario@postJsonResposta');
