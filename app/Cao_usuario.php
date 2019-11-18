<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cao_usuario extends Model
{
    protected $table = "cao_usuario";

    /* ------------------- Query ------------------*/

    /* List Users */
    public function scopeList($query){
        return $query->Join('permissao_sistema', 'cao_usuario.co_usuario', '=', 'permissao_sistema.co_usuario')
                    ->Where('co_sistema',1)
                    ->Where('in_ativo','S')
                    ->WhereIn('co_tipo_usuario',[0, 1, 2])
                    ->get(['cao_usuario.co_usuario', 'no_usuario']);
    }
}
