<template>
    <div class="container-fluid">
        <div class="block-loading" v-if="loading"></div>
        <form method="POST" autocomplete="off" data-vv-scope="proveedor">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="" class="label-control">Proveedor</label>
                        <select data-vv-name="proveedor" v-model="proveedor" class="form-control form-control-sm" v-validate="'required'">
                            <template v-for="item in proveedores">
                                <option :value="item.id">{{ item.nombre }}</option>
                            </template>
                        </select>
                        <error-form :attribute_name="'proveedor.proveedor'" :errors_form="errors"></error-form>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="" class="label-control">Tipo de pago</label>
                        <select data-vv-name="tipo_pago" v-model="tipo_pago" class="form-control form-control-sm" v-validate="'required'">
                            <template v-for="item in tipo_pagos">
                                <option :value="item.id">{{ item.nombre }}</option>
                            </template>
                        </select>
                        <error-form :attribute_name="'proveedor.tipo_pago'" :errors_form="errors"></error-form>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="" class="label-control">No. comprobante</label>
                        <input type="text" class="form-control form-control-sm" v-model="no_comprobante" data-vv-name="comprobante" v-validate="'required'">
                        <error-form :attribute_name="'proveedor.comprobante'" :errors_form="errors"></error-form>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="" class="label-control">Fecha del comprobante</label>
                        <input type="date" class="form-control form-control-sm" v-model="fecha_comprobante" data-vv-name="fecha" v-validate="'required'">
                        <error-form :attribute_name="'proveedor.fecha'" :errors_form="errors"></error-form>
                    </div>
                </div>
            </div>
        </form>
        <form method="POST" autocomplete="off" data-vv-scope="productos">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Producto</label>
                            <multiselect
                                    ref='producto'
                                    data-vv-name="producto"
                                    v-validate="'required'"
                                    v-model="producto"
                                    :options="productos"
                                    placeholder="Buscar"
                                    label="nombre"
                                    track-by="id"
                                    :searchable="true"
                                    :loading="isLoading"
                                    @search-change="buscar_producto"
                                    @select="fijar_precio"
                                    :show-labels="false">
                                    <span slot="noResult">No se encontraron registros</span>
                                    </multiselect>
                            <error-form :attribute_name="'productos.producto'" :errors_form="errors"></error-form>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                                <label for="" class="control-label">Precio</label>
                                <input type="text" class="form-control" v-validate="'required|decimal'" data-vv-name="precio" v-model="precio" ref="precio">
                                <error-form :attribute_name="'productos.precio'" :errors_form="errors"></error-form>
                            </div>
                        </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" class="control-label">Cantidad</label>
                            <input type="text" class="form-control" data-vv-name="cantidad" v-model="cantidad"  v-validate="'required|numeric'" ref="cantidad">
                            <error-form :attribute_name="'productos.cantidad'" :errors_form="errors"></error-form>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="" class="control-label">&nbsp;</label>
                            <button type="button" class="btn btn-primary btn-block btn-flat" style="display:block" @click.prevent="agregar('productos')">Agregar</button>
                        </div>
                    </div>
                </div>
            </form>
        <!-- detalle -->
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="text-align:center">#</th>
                            <th style="text-align:center">Nombre</th>
                            <th style="text-align:center">Precio</th>
                            <th style="text-align:center">Cantidad</th>
                            <th style="text-align:center">Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody v-if="lista.length < 1">
                        <tr class="text-center">
                            <td colspan="6">No hay productos agregados</td>
                        </tr>
                    </tbody>
                    <tbody>
                        <tr v-for="(item,index) in lista">
                            <td style="text-align:center">{{ index + 1 }}</td>
                            <td>{{ item.producto.nombre }}</td>
                            <td style="text-align:right">Q. {{ item.precio}}</td>
                            <td style="text-align:center">{{ item.cantidad }}</td>
                            <td style="text-align:right">Q. {{ item.subtotal }}</td>
                            <td style="text-align:center"><button class="btn btn-danger btn-sm" @click="quitar(index)"><i class="fas fa-trash-alt"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3 class="float-right">Total Q. <span v-text="formatPrice(total)"></span></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary btn-block btn-flat" @click.prevent="guardar('proveedor')">Registrar compra</button>
            </div>
        </div>
        <!--  -->
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'

    export default {
        components:{
            Multiselect
        },
        data(){
            return{
                isLoading: false, //multiselect
                loading: false,

                no_comprobante:'',
                fecha_comprobante:'',

                proveedor:'',
                proveedores:[],

                tipo_pago:'',
                tipo_pagos:[],

                productos:[],
                producto:null,
                precio:'',
                cantidad:'',

                lista:[],
                total:0.00,
            }
        },
        mounted() {
            this.config_error()
            this.obtener_registros()
        },
        methods:{
            guardar(scope){
                this.$validator.validateAll(scope).then((result) => {
                            if(result)
                            {
                                if(this.lista.length > 0)
                                {
                                    this.registrar_producto()
                                }
                                else
                                {
                                    Toastr.error('Debe agregar productos a la compra')
                                }
                            }
					});
            },
            registrar_producto(){
                this.loading = true

                let data = {
                    'lista':this.lista,
                    'proveedor':this.proveedor,
                    'tipo_pago':this.tipo_pago,
                    'no_comprobante':this.no_comprobante,
                    'fecha_comprobante':this.fecha_comprobante,
                    'total':this.total
                }

                axios.post(abs_path + '/compras',data)
                    .then(response =>{
                        Toastr.success(response.data.data,'Mensaje');
                        this.limpiar_vista()
                    })
                    .catch(error =>{
                        Toastr.error(error.response.data.error,'Error')
                    })
                    .finally(()=>{
                        this.loading = false
                    })
            },
            limpiar_vista(){
                this.tipo_pago=null
                this.producto=null
                this.precio=''
                this.cantidad=''
                this.proveedor=null
                this.fecha_comprobante=''
                this.no_comprobante=''

                this.lista=[]
                this.total=0.00

                this.$validator.reset();
            },
            fijar_precio(producto){
                this.$refs.precio.focus();
            },
            buscar_producto(query){
                if(query < 2){
                    this.productos = []
                }else{
                    this.isLoading = true
                    axios.get(abs_path + '/buscar-productos-nombre/'+query)
                        .then(response => {
                            this.productos = response.data.data
                            this.isLoading = false
                        }).
                        catch(error =>{
                            this.isLoading = false
                        });
                }
            },
            agregar(scope){
                this.$validator.validateAll(scope).then((result) => {
                            if(result)
                            {
                                if(this.precio == 0 || this.cantidad == 0)
                                {
                                    Toastr.error('Debe ingresar cantidades válidas','Error')
                                }
                                else
                                {
                                    this.agregar_lista()
                                }
                            }
					});
            },
            agregar_lista(){
                var subtotal = parseFloat(this.precio * this.cantidad).toFixed(2)
                this.total = parseFloat(this.total) + parseFloat(subtotal)

                let data = {
                    'producto':this.producto,
                    'precio':parseFloat(this.precio).toFixed(2),
                    'cantidad':this.cantidad,
                    'subtotal': parseFloat(subtotal).toFixed(2)
                }

                 this.lista.push(data)
                 this.precio = '';
                 this.cantidad = '';
                 this.producto = '';
                 this.productos = [];

                 this.$validator.reset();
            },
            formatPrice(value) {
                return  parseFloat(value).toFixed(2);
            },

            isNumeric(value){
                 return !isNaN(parseFloat(value)) && isFinite(value)
            },
            quitar(index){

                this.total = parseFloat(this.total) - parseFloat(this.lista[index].subtotal )
                this.lista.splice(index,1)
            },
            obtener_registros(){
                this.loading = true
                Promise.all([this.obtener_proveedores(), this.obtener_tipo_pago()])
                    .then(data =>{
                        this.loading = false
                    })
                    .catch(error =>{
                        this.loading = false
                    })
            },
            obtener_proveedores(){
                return new Promise((resolve,reject) =>{
                    axios.get(abs_path+'/obtener-proveedores')
                        .then(response =>{
                            this.proveedores = response.data.data
                            resolve()
                        })
                        .catch(error =>{
                            reject(error)
                        })
                })
            },
            obtener_tipo_pago(){
                return new Promise((resolve,reject) =>{
                    axios.get(abs_path+'/obtener-tipo-pago')
                        .then(response =>{
                            this.tipo_pagos = response.data.data
                            resolve()
                        })
                        .catch(error =>{
                            reject(error)
                        })
                })
            },
            config_error(){
            let self = this
               let dict = {
                custom:{
                  proveedor:{
                      required:'El nombre del proveedor es requerido'
                  },
                  tipo_pago:{
                      required:'El tipo de pago es requerido'
                  },
                  comprobante:{
                      required:'El número de comprobante es requerido'
                  },
                  fecha:{
                      required:'La fecha es requerida',
                      date_format:'La fecha debe tener un formato válido'
                  },
                  producto:{
                      required:'El nombre del producto es requerido'
                  },
                  precio:{
                      required:'El precio es requerido',
                      decimal:'El precio puede tener decimales'
                  },
                  cantidad:{
                      required:'La cantidad es requerida',
                      numeric:'La cantidad es un número'
                  }
                }
               }

              self.$validator.localize('es',dict);
          },
        }
    }
</script>
