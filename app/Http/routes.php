<?php

use App\Resposta;

/*
 * |--------------------------------------------------------------------------
 * | Application Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register all of the routes for an application.
 * | It's a breeze. Simply tell Laravel the URIs it should respond to
 * | and give it the controller to call when that URI is requested.
 * |
 */
Route::get('/admin', function () {
    return redirect('/admin/questionario.html');
});
Route::get('/', function () {
    return view('client');
});
Route::group([
        'prefix' => 'admin',
], function () {
    Route::get('dados.html', [
            'as' => 'admin.dados',
            'uses' => 'Respostas@getHtmlShow',
    ]);
    Route::get('questionario.html', [
            'as' => 'admin.questionario',
            'uses' => 'Questionario@getHtmlShow',
    ]);
    Route::get('configuracao.html', [
            'as' => 'admin.config',
            'uses' => 'Configuration@getHtmlShow',
    ]);
    Route::get('dados.json', 'Respostas@getAllDates');
    Route::get('questionario.json', 'Questionario@getJsonShow');
    Route::get('camera-conf.json', 'Configuration@getJsonCameraConf');
    Route::post('questionario.save', 'Questionario@postJsonSave');
    Route::post('camera-conf.save', 'Configuration@postJsonCameraConf');
    Route::post('moldura.save', 'Configuration@postJsonMoldura');
    Route::post('abertura.save', 'Configuration@postJsonAbertura');
    Route::post('camera-conf.preview', 'Photo@postPreviewPhoto');
    Route::get('dados/{dates}', 'Respostas@getExcel')->where('dates', '(\d\d\d\d-\d\d-\d\d)(,\d\d\d\d-\d\d-\d\d)*');
});
Route::post('/print-photo', 'Photo@postPrintPhoto');
Route::post('/resposta', 'Questionario@postJsonResposta');
Route::get('/photo', 'Photo@postPrintPhoto');
Route::get('/storage/{file}', function ($file) {
    return response()->download(storage_path('app/'.$file));
});
