@php
    function money_format($number){
        if(!empty($number)){
            return number_format($number,2,'.','');
        }else{
            return 0;
        }
    }
    function lisUsers($desempenho){
        $arreglo                = [];
        $users                  = '';
        $ganancia_neta          = 0;
        $ganancia_neta_total    = 0;
        $ganancia_neta_porcentaje = '';

        foreach ($desempenho as $key => $item){
            $ganancia_neta_total += $item->ganancia_neta;
        }

        foreach ($desempenho as $key => $item){
            $users                      .= '"' . $item->no_usuario . '"';
            $ganancia_neta              .= $item->ganancia_neta;
            $ganancia_neta_porcentaje   .= '"' . money_format(($item->ganancia_neta * 100 ) / $ganancia_neta_total) . '"';  
            if($key + 1 != count($desempenho)){
                $users                      .= ',';
                $ganancia_neta              .= ',';
                $ganancia_neta_porcentaje   .= ',';
            }
        }
        array_push($arreglo, $users);
        array_push($arreglo, $ganancia_neta);
        array_push($arreglo, $ganancia_neta_porcentaje);
        array_push($arreglo, $ganancia_neta_total);
        return $arreglo;
    }
@endphp

<div class="col-md-12">

    <h2>PIZZA</h2>
</div>
<div class="col">
    <canvas id="myChart" style="position: relative; height:400px; width:100%"></canvas>
</div>

<script>
    $(document).ready(function(){

        var oilCanvas = document.getElementById("myChart");

        Chart.defaults.global.defaultFontFamily = "Lato";
        Chart.defaults.global.defaultFontSize = 18;

        var oilData = {
            labels: [<?php echo lisUsers($desempenho)[0] ?>],
            datasets: [
                {
                    data: [<?php echo lisUsers($desempenho)[2] ?>],
                    backgroundColor: ['#a4c400','#00aba9','#0050ef','#6a00ff','#f472d0','#825a2c','#e3c800']
                }],
        };

        var pieChart = new Chart(oilCanvas, {
        type: 'pie',
        data: oilData,
        responsive: true,
        barValueSpacing: 2,
        options: {
            title: {
                display: true,
                text: 'Porcentaje de Gannancias Netas por cada consultor'
            }
        }
        });
    })
</script>