<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cao_usuario;
use App\Cao_fatura;

class AgenceController extends Controller
{
    public function desempenho($data = ''){
        $users      = Cao_usuario::List();
        return View('reports.desempenho',compact('users'));
    }

    public function apiDesempenho(Request $request){
        $users      = $request->users;
        $date       = explode(' - ',$request->date);
        
        if(count($users) > 0 && count($date)){
            $desempenho = Cao_fatura::desempenho($users,$date);
            
            if(count($desempenho)){
                return View('reports.relatorio',compact('desempenho'))->render();
            }else{
                return '';
            }
        }
    }

    public function apiGrafico(Request $request){
        $users      = $request->users;
        $date       = explode(' - ',$request->date);
        
        if(count($users) > 0 && count($date)){
            $desempenho = Cao_fatura::Gananciausuario($users,$date);
            
            if(count($desempenho)){
                return View('reports.grafico',compact('desempenho'))->render();
            }else{
                return '';
            }
        }
    }

    public function apiPizza(Request $request){
        $users      = $request->users;
        $date       = explode(' - ',$request->date);
        
        if(count($users) > 0 && count($date)){
            $desempenho = Cao_fatura::Gananciausuario($users,$date);
            
            if(count($desempenho)){
                return View('reports.pizza',compact('desempenho'))->render();
            }else{
                return '';
            }
        }
    }
}
