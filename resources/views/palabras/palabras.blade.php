@extends('layouts.admin.principal')

@section('css')
    <style>
        td, th {
            text-align: center;
        }
        .btgrid {
            padding: 2px 12px;
            margin-bottom: 2px;
            margin-right: 2px;
        }
        .lista{
            padding-top: 6px;
            padding-bottom: 6px;
        }
        .icon{
            padding-left: 0px;
            padding-top: 2px;
        }
    </style>
@endsection

@section('content')
    <div class="page-title">
        <div class="title_left">
            <h3>
                Registro de palabras
            </h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title"></h3>
            <a href="{!!route('crearPalabra')!!}" class="btn btn-success" data-modal="">Registrar nueva palabra</a>
        </div>
        <div class="panel-body">
            <table id="palabras" class="table table-striped table-bordered no-footer" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>id</th>
                    <th>idEspanol</th>
                    <th>Palabra</th>
                    <th>Traduccion</th>
                    <th>Tiempo</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">

    $(function(){
        $('#palabras').on('init.dt', function ( ) {
            handleAjaxModal();
        });

        table[0] = $('#palabras').DataTable({
            "language": {
                "url": "{!!route('espanol')!!}"
            },
            ajax: {
                url: "{!!route('getPalabras')!!}",
                "type": "POST"
            },
            columns: [  { data: 'id' },
            { data: 'idEspanol'},
            { data: 'español' },
            { data: 'traduccion' },
            { data: 'tiempo'}],
            "columnDefs": [
                {
                "targets": [0],
                "visible": false,
                "searchable": false
                },
                {
                    "targets": [1],
                    "visible": false,
                    "searchable": false
                },
                {
                "targets": [5],
                "data": null,
                "defaultContent": "<a href={!!route('editarPalabra')!!} data-modal='' data-id='id' table='0'; class='btn btn-primary'>Editar</a>"
                },
                {
                "targets": [6],
                "data": null,
                "defaultContent":  "<button class='btn btn-danger' onclick='eliminar(event)'>Eliminar</button>"
                }
            ],
            "scrollX": true
        });
    });

    function eliminar(event){
        var element = event.target;
        $.msgbox("Esta accion eliminara el contenido seleccionado, ¿Desea continuar?", { type: 'confirm' }, function(result){
            if(result == 'Aceptar') {
                var data = table[0].row($(element).parents('tr')).data();
                $.ajax({
                    type:"POST",
                    context: document.body,
                    url: '{{route('deletePal')}}',
                    data:{ 'id' : data['id'], 'idEsp' : data['idEspanol']},
                    success: function(data){
                        table[0].row($(element).parents('tr')).remove().draw(false);
                        $.msgbox("Registro eliminado con exito.", { type: 'success'});
                    },
                    error: function(data){
                        var respuesta =JSON.parse(data.responseText);
                        var arr = Object.keys(respuesta).map(function(k) { return respuesta[k] });
                        var mensaje="";
                        for (var i=0; i<arr.length; i++)
                            mensaje += arr[i][0]+"\n";
                        nombre.val("");
                        $.msgbox(mensaje, { type: 'error'});
                    }
                });


            }
        });

    }


    </script>
@endsection