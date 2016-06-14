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
            <a href="{!!route('registrarmodulo')!!}" class="btn btn-success" data-modal="">Registrar nueva palabra</a>
        </div>
        <div class="panel-body">
            <table id="palabras" class="table table-striped table-bordered no-footer" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Palabra</th>
                    <th>traduccion</th>
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

        table[0] = $('#palabras').DataTable( {
        "language": {
        "url": "{!!route('espanol')!!}"
        },
        ajax: {
        url: "{!!route('gridmodulosRFID')!!}",
        "type": "POST"
        },
        columns: [  { data: 'id' },
        { data: 'palabra' },
        { data: 'traduccion' }],
        "columnDefs": [
        {
        "targets": [0],
        "visible": false,
        "searchable": false
        },
        {
        "targets": [3],
        "data": null,
        "defaultContent": "<a href={!!route('editarmodulo')!!} data-modal='' data-id='id' table='0'; class='btn btn-primary'>Editar</a>"
        },
        {
        "targets": [4],
        "data": null,
        "defaultContent":  "<button class='btn btn-danger' onclick='eliminar(event)'>Eliminar</button>"
        }
        ],
        "scrollX": true
        } );

        });
    </script>
@endsection