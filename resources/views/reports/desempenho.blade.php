@extends('layout.app')
@section('container')
    <div class="container">
        <form action="">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            USUARIOS
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <select id="list-users" multiple="multiple">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->co_usuario }}">{{ $user->no_usuario }}</option>
                                    @endforeach
                                </select>
                            </li>
                        </ul>
                        <div class="card-header">
                            PERIODO
                        </div>
                        <li class="list-group-item">
                            <input type="text" name="daterange" id="date" class="form-control text-center" value="2019-01-01 - 2019-01-31" />
                        </li>
                    </div>
                </div>
                <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                ACCIONES
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item text-center">
                                    <bottom id="btn-relatorio" class="btn btn-primary">Relatório</bottom>
                                    <bottom id="btn-grafico" class="btn btn-success">Gráfico</bottom>
                                    <bottom id="btn-pizza" class="btn btn-warning">Pizza</bottom>
                                </li>
                            </ul>
                        </div>
                </div>
            </div>
        </form>
        <div class="row mt-5" id="container">
            <div class="col">
               <div class="alert alert-primary">
                   <p class="text-center">
                       Seleccione minimo un suario y un rango de fechas
                   </p>
               </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.css">
    @endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script>
        $(document).ready(function() {

            $('#list-users').multiselect({
                includeSelectAllOption: true,
                numberDisplayed: 2,
                buttonWidth: '100%',
            });
            $('input[name="daterange"]').daterangepicker({
                opens: 'left',
                showDropdowns: true,
                locale: {
                    format: 'YYYY-MM-DD',
                }
            }, function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-M id="btn-relatorio"M-DD'));
            });
            /*  AJAX  */
            var alert_sin_datos = '<div class="col"><div class="alert alert-warning"><p class="text-center">Sin datos para mostrar</p></div></div>';
            var vacio_error = '<div class="col"><div class="alert alert-warning"><p class="text-center">Debe seleccionar minimo un usuario y un rango de fecha</p></div></div>';
            var alert_error = '<div class="col"><div class="alert alert-danger"><p class="text-center">Error al mostrar los datos</p></div></div>';

            $("#btn-relatorio").click(function() {
                var users = $('#list-users').val();
                var date  = $('#date').val();
                var url = '{{ route("apiDesempenho") }}';

                if(users.length > 0 && date != ''){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type:'POST',
                        url: url,
                        data: {
                            users: users,
                            date: date
                        },
                        success:function(data){
                            if(data != ''){
                                $('#container').html(data);
                            }else{
                                $('#container').html(alert_sin_datos);
                            }
                        },
                        error:function(){
                            $('#container').html(alert_error);
                        }
                    });
                }else{
                    $('#container').html(vacio_error);
                }
                
            });

            $("#btn-grafico").click(function() {
                var users = $('#list-users').val();
                var date  = $('#date').val();
                var url   = '{{ route("apiGrafico") }}'; 

                if(users.length > 0 && date != ''){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type:'POST',
                        url: url,
                        data: {
                            users: users,
                            date: date
                        },
                        success:function(data){
                            if(data != ''){
                                $('#container').html(data);
                            }else{
                                $('#container').html(alert_sin_datos);
                            }
                        },
                        error:function(){
                            $('#container').html(alert_error);
                        }
                    });
                }else{
                    $('#container').html(vacio_error);
                }
            });

            $("#btn-pizza").click(function() {
                var users = $('#list-users').val();
                var date  = $('#date').val();
                var url   = '{{ route("apiPizza") }}'; 

                if(users.length > 0 && date != ''){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type:'POST',
                        url: url,
                        data: {
                            users: users,
                            date: date
                        },
                        success:function(data){
                            if(data != ''){
                                $('#container').html(data);
                            }else{
                                $('#container').html(alert_sin_datos);
                            }
                        },
                        error:function(){
                            $('#container').html(alert_error);
                        }
                    });
                }else{
                    $('#container').html(vacio_error);
                }
            });
        });
    </script>
@endpush