@extends('layouts.appp')
@push('custom-css')

@endpush
@section('content')
<div id="appvc">
    <div class="container-fluid mt-2">
        <div class="card" style=" font-family:Century Gothic;">
            <div class="card-header text-center" style="font-family:Century Gothic; background-color:#007bff; color:white; font-weigth:bold;">
               Listado de libranzas
            </div>
             <div class="container-fluid text-center">
                 <div class="row">
                     <div class="col-lg-4 col-md-4 col-12 col-xs-12">
                         <i class="fas fa-dollar-sign" style="color:#007bff; font-size:3em !important"></i> <strong style="color:#007bff; font-size:3em !important" v-html="new Intl.NumberFormat().format(montoTotalLibranzas)"></strong> <small>Monto total</small>
                     </div>
                     <div class="col-lg-4 col-md-4 col-12 col-xs-12">
                         <i class="fas fa-dollar-sign" style="color:#70e101; font-size:3em !important"></i> <strong style="color:#70e101; font-size:3em !important" v-html="new Intl.NumberFormat().format(montoTotalPagado)"></strong> <small>Monto total Pagados</small>
                     </div>
                      <div class="col-lg-4 col-md-4 col-12 col-xs-12">
                         <i class="fas fa-dollar-sign" style="color:#ff0000; font-size:3em !important"></i> <strong style="color:#ff0000; font-size:3em !important" v-html="new Intl.NumberFormat().format(montoTotalDeuda)"></strong> <small>Monto total Deudas</small>
                     </div>
                 </div>
                   </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tablaOrdenes" style="width:105%;" class="table">
                        <thead>
                            <tr>
                              <th scope="col">Codigo</th>
                              <th scope="col">Fecha</th>
                              <th scope="col">Documento</th>
                              <th scope="col">Empleado</th>
                              <th scope="col">Empresa</th>
                              <th scope="col">Tienda</th>
                              <th scope="col">Monto</th>
                              <th scope="col">Cuotas</th>
                              <th scope="col">Cuotas Pagas</th>
                              <th scope="col">Valor Cuota</th>
                              <th scope="col">Saldo Abonado</th>
                              <th scope="col">Deuda</th>
                              <th scope="col">Estado</th>
                            </tr>
                      </thead>
                        <tbody>
                            <tr v-for="libranza in libranzas">
                                <td v-html="libranza.codigo"></td>
                                <td v-html="libranza.fecha"></td>
                                <td v-html="libranza.documento"></td>
                                <td v-html="libranza.empleado"></td>
                                <td v-html="libranza.empresa"></td>
                                <td v-html="libranza.tienda"></td>
                                <td><span class="badge badge-info" v-html="libranza.monto"></span></td>
                                <td v-html="libranza.cuotas"></td>
                                <td v-html="libranza.pagas+' de '+libranza.cuotas"></td>
                                <td v-html="libranza.valorCuota"></td>
                                <td><span class="badge badge-success" v-html="libranza.pagado"></span></td>
                                <td><span class="badge badge-danger" v-html="libranza.deuda"></span></td>
                                <td v-html="libranza.estado"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts-custom')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://unpkg.com/axios@0.27.2/dist/axios.min.js"></script>
<script src="https://unpkg.com/vue@next"></script>
    
<script>
    const AttributeBinding = {
        mounted(){},
        data() {
            return {
               libranzas:[],
               montoTotalLibranzas: 0,
               montoTotalPagado: 0,
               montoTotalDeuda:0,
            }
        },
        methods:{
            getLibranzas(){
                 axios.get('getAllLibranzas')
                .then(response => {
                    this.libranzas = response.data[0].data
                    this.montoTotalLibranzas = response.data[0].montoTotalLibranzas
                    this.montoTotalPagado = response.data[0].montoTotalPagado
                    this.montoTotalDeuda = response.data[0].montoTotalDeuda
                    $('#tablaOrdenes').DataTable().destroy();
                    this.initDatatable();
                })
            },
            initDatatable(){
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth() + 1; //January is 0!
                var yyyy = today.getFullYear();
                
                today = mm + '/' + dd + '/' + yyyy;
                
                
                this.$nextTick(() => {
                    $('#tablaOrdenes').DataTable({
                          dom: 'Bftrip',
                          buttons: [
                            {
                              extend: 'excelHtml5',
                              text: '<i class="fa fa-file-excel"></i>',
                              filename: 'Siver - Libranzas',
                              sheetName : 'Libranza por Empleados',
                              title: 'SIVER SOFTWARE ORG BLESS | Libranza por Empleados',
                              footer: 'Reporte generado desde Siver Software, producto desarrollado por ORGANIZACION BLESS. Developer Watsson.'
                            },
                            {
                                  extend: 'pdfHtml5',
                                  text: '<i class="fa fa-file-pdf"></i>',
                                  filename: 'Siver - Libranzas',
                                  footer: 'Reporte generado desde Siver Software, producto desarrollado por ORGANIZACION BLESS. Developer Watsson.',
                                  title: 'SIVER SOFTWARE ORG BLESS | Libranza por Empleados ',
                                  messageTop: 'Libranzas  a fecha de hoy '+today+' ',
                            }
                          ]
                    });
                });
              },
            
        },
        mounted(){
           this.getLibranzas();
        }
    }
        var example2=Vue.createApp(AttributeBinding).mount('#appvc')

    </script>
@endpush