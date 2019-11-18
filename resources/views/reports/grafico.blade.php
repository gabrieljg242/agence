@php
    function lisUsers($desempenho){
        $arreglo    = [];
        $users      = '';
        $costo_fijo = '';

        foreach ($desempenho as $key => $item){
            $users      .= '"' . $item->no_usuario . '"';
            $costo_fijo .= $item->costo_fijo;
            if($key + 1 != count($desempenho)){
                $users .= ',';
                $costo_fijo .= ',';
            }
        }
        array_push($arreglo, $users);
        array_push($arreglo, $costo_fijo);
        return $arreglo;
    }
    function costo_fijo_medio($desempenho){
        $costo_fijo_medio = 0;
        $users            = '';

        foreach ($desempenho as $key => $item){
            $costo_fijo_medio += $item->costo_fijo;
        }

        $costo_fijo_medio = $costo_fijo_medio / count($desempenho);

        foreach ($desempenho as $key => $item){
            $users .= $costo_fijo_medio;
            if($key + 1 != count($desempenho)){
                $users .= ',';
            }
        }

        return $users;
    }
@endphp

<div class="col-md-12">
    <h2>GRÁFICO</h2>
</div>
<div class="col">
    <canvas id="myChart" style="position: relative; height:400px; width:100%"></canvas>
</div>

<script>
    $(document).ready(function(){
        var ctx = document.getElementById('myChart').getContext('2d');

            var mixedChart = new Chart(ctx, {
                type: 'bar',
                responsive: true,
                data: {
                    datasets: [{
                        label: 'Costo medio fijo: ',
                        data: [<?php echo costo_fijo_medio($desempenho) ?>],
                        backgroundColor: [
                            "transparent",
                        ],
                        type: 'line'
                    },{
                        label: 'Usuarios',
                        data: [<?php echo lisUsers($desempenho)[1] ?>],
                        backgroundColor: [
                            "#f38b4a",
                            "#56d798",
                            "#ff8397",
                            "#6970d5" 
                        ]
                    } ],
                    labels: [<?php echo lisUsers($desempenho)[0] ?>]
                },
                options: {}
        });
    })
</script>