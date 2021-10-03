@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
          <div class="card shadow-md">
              <div class="card-header">
                    <h3 class="card-title-custom">Compras</h3>
                    <div class="card-tools">
                        <a href="{{ route('compras.create') }}" class="btn btn-primary btn-sm btn-flat" style="float:right; color:#fff">Nuevo registro</a>
                    </div>
              </div>
              <div class="card-body">
                 <table id="listar" class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <th style="width:10%; text-align: center">No.</th>
                          <th>Monto</th>
                          <th>Tipo pago</th>
                          <th>Proveedor</th>
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
            'url': '/compras/show',
            'type': 'GET'
          },

          "columns":[
              {'data': 'id'},
              {'data': 'monto',"render":function(data, type, row, meta){
                    return '<span>Q. '+ row.monto +'</span>'
                }
              },
              {'data': 'tipo_pago'},
              {'data': 'proveedor'},
              {'data': 'fecha',"orderable":false},
              {'defaultContent':'<a href="" class="detalle btn btn-primary btn-sm btn-flat"  data-toggle="tooltip" data-placement="top" title="Detalle del registro"><i class="fas fa-clipboard-list"></i> Detalle</a>', "orderable":false}
          ],
          "language": language_spanish,
          "order": [[ 0, "asc" ]]
        });
        obtener_data_editar("#listar tbody",table);
    }
    var obtener_data_editar = function(tbody,table){
         $(tbody).on("click","a.detalle",function(e){
             e.preventDefault();

             var data = table.fnGetData($(this).parents("tr"));

            var id = data.id;
             window.location.href = "/compras/" + id + "/detalle";
          });

         $(tbody).on("click","a.borrar",function(e){
             e.preventDefault();
             var data = table.fnGetData($(this).parents("tr"));

            var id = data.id;
             Swal.fire({
                  title: '¿Está seguro de eliminar este registro?',
                  //text: 'Confirmar',
                  type: 'question',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar'
                }).then((result) => {
                   if (result.value) {
                      axios.delete('/compras/'+id)
                          .then(response => {
                              Toastr.success(response.data.data,'Mensaje')
                              table._fnAjaxUpdate() //actualizar datatable

                          })
                          .catch(error => {
                              if (error.response) {
                                  Toastr.error(error.response.data.error,'');
                              }else{
                                  Toastr.error('Ocurrió un error: ' + error,'Error');
                              }
                          });
                   }

                });

          });
      }
</script>
@endsection
