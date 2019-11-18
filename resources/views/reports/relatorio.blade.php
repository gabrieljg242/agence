@php
    function money_format_pizza($number){
        if(!empty($number)){
            return number_format($number,2,',','.');
        }else{
            return 0;
        }
    }
@endphp
<div class="col-md-12">
    <h2>RELATORIO</h2>
</div>
<div class="col-md-12">
    @php
        $user           = '';
        $last           = '';
        $ganancia_neta  = 0;
        $costo_fijo     = 0;
        $comision       = 0;
        $beneficio      = 0;
    @endphp
    @foreach ($desempenho as $item)

        @if ($user != $item->co_usuario && !empty($user))
                    <tr class="table-success">
                        <th scope="col" class="text-right">Totales</th>
                        <th scope="col" class="text-right">{{ money_format_pizza($ganancia_neta) }}</th>
                        <th scope="col" class="text-right">{{ money_format_pizza($costo_fijo) }}</th>
                        <th scope="col" class="text-right">{{ money_format_pizza($comision) }}</th>
                        <th scope="col" class="text-right">{{ money_format_pizza($beneficio) }}</th>
                    </tr>
                </tbody>
            </table>
            
            @php
                $ganancia_neta  = 0;
                $costo_fijo     = 0;
                $comision       = 0;
                $beneficio      = 0;
            @endphp
        @endif

        @if ($user != $item->co_usuario)
            @php
                $user =  $item->co_usuario;
            @endphp
            <table class="table table-bordered table-hover table-responsive-sm">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" colspan="5">{{ $item->no_usuario }}</th>
                    </tr>
                </thead>
                <thead class="thead-light">
                    <tr>
                        <th scope="col" class="text-right">PERIODO</th>
                        <th scope="col" class="text-right">GANANCIA NETA</th>
                        <th scope="col" class="text-right">COSTO FIJO</th>
                        <th scope="col" class="text-right">COMISIÓN</th>
                        <th scope="col" class="text-right">BENEFICIO</th>
                    </tr>
                </thead>
                <tbody>  
        @endif
                <tr>
                    <th scope="row" class="text-right">{{ $item->year }} - {{ $item->month }}</th>
                    <td class="text-right">{{ money_format_pizza($item->ganancia_neta) }}</td>
                    <td class="text-right">{{ money_format_pizza($item->costo_fijo) }}</td>
                    <td class="text-right">{{ money_format_pizza($item->comision) }}</td>
                    <td class="text-right">{{ money_format_pizza($item->beneficio) }}</td>
                </tr>

                @php
                    $ganancia_neta  += $item->ganancia_neta;
                    $costo_fijo     += $item->costo_fijo;
                    $comision       += $item->comision;
                    $beneficio      += $item->beneficio;
                @endphp

        @if ($loop->last)
                    <tr class="table-success">
                        <th scope="col" class="text-right">Totales</th>
                        <th scope="col" class="text-right">{{ money_format_pizza($ganancia_neta) }}</th>
                        <th scope="col" class="text-right">{{ money_format_pizza($costo_fijo) }}</th>
                        <th scope="col" class="text-right">{{ money_format_pizza($comision) }}</th>
                        <th scope="col" class="text-right">{{ money_format_pizza($beneficio) }}</th>
                    </tr>
                </tbody>
            </table>
        @endif
    @endforeach
</div>