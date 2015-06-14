<?php namespace App\Http\Controllers;

use App\Config;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Questionario extends Controller {

    public function getJsonShow(){
        return response()->json(Config::find('Questionario'));
    }

    public function getHtmlShow(){
        return view('questionario');
    }

    public function postJsonSave(Request $r){
        $c = Config::find("Questionario");
        if(!$c){
            $c = new Config;
            $c->_id = "Questionario";
        }
        $c->fields = $r->input('fields');
        $c->save();
        return response()->json($c);
    }
}
