<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class cao_fatura extends Model
{
    protected $table = "cao_fatura";

    /* ------------------- Query ------------------*/

    /* Listado de factura por mes y usuario */
    public function scopeMesusuario($query,$usuario){
        return $query->select(DB::raw('YEAR(cao_fatura.data_emissao) year, MONTH(cao_fatura.data_emissao) month'))
                    ->join('cao_os','cao_fatura.co_os', '=', 'cao_os.co_os')
                    ->join('cao_usuario','cao_os.co_usuario','=','cao_usuario.co_usuario')
                    ->groupby('year','month', 'cao_usuario.co_usuario')
                    ->get();
    }

    /* Desempenho */
    public function scopeDesempenho($query,$users,$date){
        return DB::table('cao_usuario')
                        ->select(
                                'cao_usuario.co_usuario', 
                                'cao_usuario.no_usuario', 
                                DB::raw('YEAR(cao_fatura.data_emissao) year, MONTH(cao_fatura.data_emissao) month'),
                                DB::raw('SUM(( valor - ( valor * cao_fatura.total_imp_inc ) / 100 )) ganancia_neta'),
                                DB::raw('YEAR(cao_fatura.data_emissao) year, MONTH(cao_fatura.data_emissao) month'),
                                DB::raw('brut_salario costo_fijo'),
                                DB::raw('SUM(((valor - ((valor * cao_fatura.total_imp_inc ) / 100)) * comissao_cn) / 100) comision'),
                                DB::raw('SUM((( valor - ( valor * cao_fatura.total_imp_inc ) / 100 ) - (brut_salario + (((valor - ((valor * cao_fatura.total_imp_inc ) / 100)) * comissao_cn) / 100)))) beneficio')
                        )
                        ->join('permissao_sistema','cao_usuario.co_usuario','=', 'permissao_sistema.co_usuario')
                        ->join('cao_os', 'cao_usuario.co_usuario','=','cao_os.co_usuario')
                        ->join('cao_fatura', 'cao_os.co_os','=','cao_fatura.co_os')
                        ->join('cao_salario', 'cao_usuario.co_usuario', '=', 'cao_salario.co_usuario')
                        ->groupby('year','month', 'cao_usuario.co_usuario')
                        ->WhereIn('cao_usuario.co_usuario',$users)
                        ->whereBetween('data_emissao', [$date[0], $date[1]])
                        ->orderBy('co_usuario','asc')
                        ->orderBy('year','asc')
                        ->orderBy('month','asc')
                        ->get();
    }

    /* Desempenho */
    public function scopeGananciausuario($query,$users,$date){
        return DB::table('cao_usuario')
                        ->select(
                                'cao_usuario.co_usuario', 
                                'cao_usuario.no_usuario', 
                                DB::raw('SUM(( valor - ( valor * cao_fatura.total_imp_inc ) / 100 )) ganancia_neta'),
                                DB::raw('SUM(brut_salario) costo_fijo'),
                        )
                        ->join('permissao_sistema','cao_usuario.co_usuario','=', 'permissao_sistema.co_usuario')
                        ->join('cao_os', 'cao_usuario.co_usuario','=','cao_os.co_usuario')
                        ->join('cao_fatura', 'cao_os.co_os','=','cao_fatura.co_os')
                        ->join('cao_salario', 'cao_usuario.co_usuario', '=', 'cao_salario.co_usuario')
                        ->groupby('cao_usuario.co_usuario')
                        ->WhereIn('cao_usuario.co_usuario',$users)
                        ->whereBetween('data_emissao', [$date[0], $date[1]])
                        ->orderBy('co_usuario','asc')
                        ->get(['co_nombre']);
                        
    }
}
