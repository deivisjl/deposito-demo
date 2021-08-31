@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
          <div class="card shadow-md">
              <div class="card-header">
                    <h3 class="card-title-custom">Inventario de productos</h3>
              </div>
              <div class="card-body">
                 <table id="listar" class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <th style="width:10%; text-align: center">No.</th>
                          <th>Nombre</th>
                          <th>Categoría</th>
                          <th>Stock</th>
                          <th>Precio sugerido</th>
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
            'url': '/inventario-listar/show',
            'type': 'GET'
          },

          "columns":[
              {'data': 'id'},
              {'data': 'nombre'},
              {'data': 'categoria'},
              {'data': 'stock',"orderable":false,"searchable":false},
              {'data': 'precio',"orderable":false,"searchable":false},

              {'defaultContent':'<a href="" class="kardex btn btn-primary btn-sm btn-flat"  data-toggle="tooltip" data-placement="top" title="Detalle del registro"><i class="fas fa-clipboard-list"></i> Detalle</a>', "orderable":false}
          ],
          "language": language_spanish,
          "order": [[ 0, "asc" ]]
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
