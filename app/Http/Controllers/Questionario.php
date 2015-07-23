<?php

namespace App\Http\Controllers;

use App\Config;
use App\Resposta;
use Illuminate\Http\Request;

class Questionario extends Controller
{
    public function getJsonShow()
    {
        return response()->json(Config::find('Questionario'));
    }

    public function getHtmlShow()
    {
        return view('admin', ['page' => 'questionario']);
    }

    public function postJsonSave(Request $r)
    {
        $c = Config::find('Questionario');
        if (!$c) {
            $c = new Config();
            $c->_id = 'Questionario';
        }
        $c->fields = $r->input('fields');
        $c->config = $r->input('config');
        $c->save();

        return response()->json($c);
    }

    public function postJsonResposta(Request $r)
    {
        $resposta = new Resposta();
        foreach ($r->all() as $k => $v) {
            $resposta->{$k} = $v;
        }
        $resposta->save();

        return response()->json(['error' => 0]);
    }
}
