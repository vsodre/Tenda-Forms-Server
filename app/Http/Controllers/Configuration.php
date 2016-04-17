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
        if($r->hasFile('image')){
            $c = Config::find("Camera");
            list($h, $v) = getimagesize($_FILES['image']['tmp_name']);
            if($h !== 1052 || $v !== 744){
                return response()->json(['ok'=>0, 'reason' => 'Arquivo fora das dimensões.']);
            }
            $r->file('image')->move(storage_path('app'), 'frame.png');
            $c->frame_path = storage_path('app/frame.png');
            $c->save();
            return response()->json(['ok'=>1]);
        } else {
        	return response()->json(['ok'=>0, 'inputs' => $r->all(), 'reason' => 'Arquivo não detectado na requisição.']);
        }
    }

    public function postJsonAbertura(Request $r){
        if($r->hasFile('image')){
            $c = Config::find("Questionario");
            $config = $c->config;
            $r->file('image')->move(storage_path('app'), 'opening.png');
            $config['opening_url'] = 'storage/opening.png';
            $c->config = $config;
            $c->save();
            return response()->json(['ok'=>1]);
        } else {
        	return response()->json(['ok'=>0, 'inputs' => $r->all(), 'reason' => 'Arquivo não detectado na requisição.']);
        }
    }
}
