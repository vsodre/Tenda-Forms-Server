<?php namespace App\Http\Controllers;

use App\Config;
use App\Http\Controllers\Controller;

class Questionario extends Controller {

    public function getJsonShow(){
        return response()->json(Config::find('Questionario'));
    }

}
