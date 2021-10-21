<template>
    <div>
        <div class="block-loading-graficas" v-if="loading"></div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="" class="control-label">Desde</label>
                    <input type="date" class="form-control" v-model="valorFechaInicio">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="" class="control-label">Hasta</label>
                    <input type="date" class="form-control" v-model="valorFechaFin">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <button class="btn btn-primary btn-block btn-flat" @click.prevent="mostrar()">Mostrar</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <apexchart type="line" width="100%" height="350px" :options="chartOptions" :series="chartSeries"></apexchart>
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment'
export default {
        data(){
            return {
                loading:false,

                valorFechaInicio:null,
                valorFechaFin:null,
                chartSeries:[],
                etiquetas:[],
            }
        },
        mounted() {

        },
        created(){
            this.setear_fechas()
            this.mostrar()
        },
        computed:{
            chartOptions(){
                let option = {}
                 option = {
                        dataLabels: {
                            enabled: false
                        },
                        grid: {
                            row: {
                                colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                                opacity: 0.5
                            },
                        },
                        xaxis: {
                            categories: this.etiquetas
                        }
                    }
                return option
            }
        },
        methods:{
            setear_fechas()
            {
                this.valorFechaInicio = moment().subtract(6, 'months').format('YYYY-MM-DD');
                this.valorFechaFin = moment().add(1,'days').format('YYYY-MM-DD')
            },
            mostrar()
            {
                this.loading = true
                let datos = {
                    'desde': this.valorFechaInicio,
                    'hasta':this.valorFechaFin
                }

                axios.post('ventas-por-mes', datos)
                    .then((r) =>{
                        this.chartSeries = [{data: r.data.data.series}]
                        this.etiquetas = r.data.data.etiquetas
                    })
                    .catch((error) => {
                        if(error.response && error.response.status == 423)
                        {
                            Toastr.error(error.response.data.error,'Mensaje');
                        }
                        else
                        {
                            Toastr.error(error,'Mensaje');
                        }
                    })
                    .finally(()=>{
                        this.loading = false
                    })
            },
        }
    }
</script>
