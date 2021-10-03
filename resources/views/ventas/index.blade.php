@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
          <div class="card shadow-md">
              <div class="card-header">
                    <h3 class="card-title-custom">Ventas</h3>
                    <div class="card-tools">
                        <a href="{{ route('ventas.create') }}" class="btn btn-primary btn-sm btn-flat" style="float:right; color:#fff">Nuevo registro</a>
                    </div>
              </div>
              <div class="card-body">
                 <table id="listar" class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <th style="width:10%; text-align: center">No.</th>
                          <th>Cliente</th>
                          <th>Factura</th>
                          <th>Monto</th>
                          <th>Tipo pago</th>
                          <th>Fecha</th>
                          <th>Acción</th>
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
          listar();
      });
    var  listar = function(){
        var table = $("#listar").DataTable({
            "processing": true,
            "serverSide": true,
            "destroy":true,
            "ajax":{
            'url': '/ventas/show',
            'type': 'GET'
          },

          "columns":[
              {'data': 'id'},
              {'data': 'cliente'},
              {'data': 'no_factura'},
              {'data': 'monto',"render":function(data, type, row, meta){
                    return '<span>Q. '+ row.monto +'</span>'
                }
              },
              {'data': 'tipo_pago'},
              {'data': 'fecha',"orderable":false},
              {'defaultContent':'<a href="" class="detalle btn btn-primary btn-sm btn-flat"  data-toggle="tooltip" data-placement="top" title="Detalle del registro"><i class="fas fa-clipboard-list"></i> Detalle</a>', "orderable":false}
          ],
          "language": language_spanish,
          "order": [[ 0, "desc" ]]
        });
        obtener_data_editar("#listar tbody",table);
    }
    var obtener_data_editar = function(tbody,table){
         $(tbody).on("click","a.detalle",function(e){
             e.preventDefault();

             var data = table.fnGetData($(this).parents("tr"));

            var id = data.id;
            window.location.href = "/ventas/" + id + "/detalle";
          });
      }
</script>
@endsection
