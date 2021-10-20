/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

window.$.fn.DataTable = require( 'datatables.net' );
window.$.fn.DataTable = require( 'datatables.net-bs4' );

window.Swal = require('sweetalert2');
window.Toastr = require('toastr');

require('./utils');

window.events = new Vue();

window.abs_path = '';

/* VeeValidate */
import VeeValidate from 'vee-validate';

const VueValidationEs = require('vee-validate/dist/locale/es');

const config = {
  locale: 'es',
  validity: true,
  dictionary: {
    es: VueValidationEs
  },
  fieldsBagName: 'campos',
  errorBagName: 'errors', // change if property conflicts
};

Vue.use(VeeValidate, config);
/* End VeeValidate */

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('error-form', require('./components/shared/ErrorComponent').default);

Vue.component('compra-component', require('./components/CompraComponent.vue').default);
Vue.component('venta-component', require('./components/VentaComponent.vue').default);
Vue.component('cliente-component', require('./components/ClienteComponent.vue').default);

Vue.component('grafico-compra-categoria', require('./components/reporte-grafico/GraficoCompraCategoria').default);
Vue.component('grafico-venta-categoria', require('./components/reporte-grafico/GraficoVentaCategoria').default);
Vue.component('grafico-existencia-inventario', require('./components/reporte-grafico/GraficoExistenciaInventario').default);
Vue.component('grafico-venta-mes', require('./components/reporte-grafico/GraficoVentaMes').default);

Vue.component('documento-compra', require('./components/reporte-documento/ReporteCompra').default);
Vue.component('documento-venta', require('./components/reporte-documento/ReporteVenta').default);
Vue.component('documento-inventario', require('./components/reporte-documento/ReporteInventario').default);
Vue.component('documento-venta-mes', require('./components/reporte-documento/ReporteVentaMes').default);

import VueApexCharts from 'vue-apexcharts'
Vue.use(VueApexCharts)

Vue.component('apexchart', VueApexCharts)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
