@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
          <div class="card shadow-md">
              <div class="card-header">
                    <h3 class="card-title-custom">Detalle de producto: <b>{{ $producto->nombre }}</b></h3>
                    <div class="card-tools">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb-custom">
                                <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
                                <li class="breadcrumb-item"><a href="/inventario">Inventario</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Detalle</li>
                            </ol>
                        </nav>
                    </div>
              </div>
              <input type="hidden" name="registro" id="registro" value="{{ $producto->id }}">
              <div class="card-body">
                 <table id="listar" class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <th style="width:10%; text-align: center">No.</th>
                          <th  style="text-align:center">Tipo operación</th>
                          <th  style="text-align:center">Precio compra</th>
                          <th style="text-align:center">Cantidad adquirida</th>
                          <th  style="text-align:center">Precio promedio</th>
                          <th  style="text-align:center">Fecha de registro</th>
                        </tr>
                      </thead>
                  </table>
              </div>
          </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        var registro = $('#registro').val();

        if(registro > 0 && !isNaN(registro))
        {
            var data = {registro:registro};
            var params = new Array();
            params.push(data);
            listar(params);
        }
      });
    var  listar = function(params){
        var table = $("#listar").DataTable({
            "processing": true,
            "serverSide": true,
            "destroy":true,
            "ajax":{
            'url': '/inventario-detalle-producto/show',
            'type': 'GET',
            'data': {
                'buscar': params
            }
        },
        "dom":"<'row'<'col-sm-12'tr>><'row'<'col-sm-6'i><'col-sm-6'p>>",
          "columns":[
              {'data': 'id',"visible":false},
              {'data': 'nombre',"orderable":false,"searchable":false},
              {'data': 'precio',"orderable":false,"searchable":false,"render":function(data, type, row, meta){
                    return '<span>Q. '+ row.precio +'</span>'
                }
              },
              {'data': 'cantidad',"orderable":false,"searchable":false,"class":'text-center'},
              {'data': 'precio_promedio',"orderable":false,"searchable":false,"render":function(data, type, row, meta){
                    return '<span>Q. '+ row.precio_promedio +'</span>'
                }
              },
              {'data': 'fecha',"orderable":false,"searchable":false,"class":'text-center'},
          ],
          "language": language_spanish,
          "order": [[ 0, "desc" ]]
        });
        obtener_data_editar("#listar tbody",table);
    }
    var obtener_data_editar = function(tbody,table){
         $(tbody).on("click","a.editar",function(e){
             e.preventDefault();

             var data = table.fnGetData($(this).parents("tr"));

            var id = data.id;
             window.location.href = "/inventario/" + id + "/edit";
          });
      }
</script>
@endsection
