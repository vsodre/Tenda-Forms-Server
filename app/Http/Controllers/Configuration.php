<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Config;

class Configuration extends Controller
{
    public function getHtmlShow(){
        return view('admin', ['page'=>'config']);
    }

    public function getJsonCameraConf(){
        return response()->json(Config::find('Camera'));
    }

    public function postJsonCameraConf(Request $r){
        $camera = Config::find('Camera');
        $camera->_id = 'Camera';
        $camera->rfactor = $r->input('rfactor');
        $camera->vpad = $r->input('vpad');
        $camera->hpad = $r->input('hpad');
        $camera->save();
        return response()->json(Config::find('Camera'));
    }

    public function postJsonMoldura(Request $r){
        // if(true){
        if($r->hasFile('moldura')){
            list($h, $v) = getimagesize($_FILES['moldura']['tmp_name']);
            if($h !== 1052 || $v !== 744){
                return response()->json(['ok'=>0]);
            }
            $r->file('moldura')->move(getcwd() . '/img', 'frame.png');
            return response()->json(['ok'=>1]);
        }
        return response()->json(['ok'=>0, 'inputs' => $r->all()]);
    }
}
