@extends('layouts.appp')
@push('custom-css')

@endpush
@section('content')
<div id="appvc">
    <div class="container-fluid mt-2">
        <div class="card" style=" font-family:Century Gothic;">
            <div class="card-header text-center" style="font-family:Century Gothic; background-color:#007bff; color:white; font-weigth:bold;">
               GESTION DE CUENTA EMPLEADOS DE LIBRANZA
            </div>
            
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tablaOrdenes" style="width:105%;" class="table">
                        <thead>
                            <tr>
                                <th scope="col">Empresa</th>
                              <th scope="col">Documento</th>
                              <th scope="col">Nombres</th>
                              <th scope="col">Telefono</th>
                              <th scope="col">Ultima Libranza</th>
                              <th scope="col">Total Libranzas</th>
                              <th scope="col">Cupo Libranza</th>
                              <th scope="col">Deuda Libranza</th>
                              <th scope="col">Cupo Disponible</th>
                              <th scope="col">Acciones</th>
                            </tr>
                      </thead>
                        <tbody>
                            
                            <tr v-for="empleado in empleados">
                                <td v-html="empleado.empresa"></td>
                                <td v-html="empleado.documento"></td>
                                <td v-html="empleado.nombres"></td>
                                <td v-html="empleado.telefono"></td>
                                <td v-html="empleado.fechaUltimaLibranza"></td>
                                <td> <span class="badge badge-info" v-html="empleado.totalLibranzas"></span></td>
                                <td><span class="badge badge-info" v-html="'$'+new Intl.NumberFormat().format(empleado.cupo)"></span></td>
                                <td><span class="badge badge-danger" v-html="'$'+new Intl.NumberFormat().format(empleado.deuda)"></span></td>
                                <td><span class="badge badge-success" v-html="'$'+new Intl.NumberFormat().format(empleado.cupoDisponible)"></span></td>
                                <td><a style="cursor:pointer;" v-on:click="verLibranzas(empleado.documento)"><span class="badge badge-info"><i class="fas fa-eye"></i></span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="modalMovimientos" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#0058ff; color:white;">
        <h5 class="modal-title" id="exampleModalLongTitle">Movimientos Libranza del Empleado.</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="table-responsive">
            <table id="tblInfoMovimientos" style="width:105%;">
                <thead style="padding:250px !important;">
                    <tr>
                        <th>Fecha</th>
                        <th>COD Libranza</th>
                        <th>Fecha Libranza</th>
                        <th>Movimiento</th>
                        <th>Monto</th>
                        <th style="width=210px;">Tienda</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="movimiento in dataMovimientos">
                        <td v-html="movimiento.fecha"></td>
                        <td v-html="movimiento.libranzaID"></td>
                        <td v-html="movimiento.fechaLibranza"></td>
                        <td v-html="movimiento.movimiento"></td>
                        <td v-html="'$'+new Intl.NumberFormat().format(movimiento.monto)"></td>
                        <td v-html="movimiento.tienda"></td>
                        <td v-html="movimiento.estado"></td>
                    </tr>
                </tbody>
            </table>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn"   style="background-color:#0058ff; color:white;" data-dismiss="modal">Close</button>
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
                empleados:[],
                dataMovimientos:[],
            }
        },
        methods:{
            getEmpleadosLibranza(){
                 axios.get('../getLibranzasEmpleados')
                .then(response => {
                    this.empleados = response.data;
                    console.log(this.empleados);
                    $('#tablaOrdenes').DataTable().destroy();
                    this.initDatatable();
                })
            },
            verLibranzas(documento){
                const form_data = new FormData();
                form_data.append('documento', documento);
                axios.post('../getHistorialMovsLibEmp', form_data)
                .then(response => {
                     let responde = response.data;
                        if(responde.respuesta == 500){
                            swal(responde.info, {
                                icon: "warning",
                            });
                        }else{
                          $('#modalMovimientos').modal('show');
                          this.dataMovimientos = responde.info;
                          this.cargarMovimientosTabla();
                            
                        }
                });
            },
            cargarMovimientosTabla(){
              $('#tblInfoMovimientos').DataTable().destroy();
                this.$nextTick(() => {
                        $('#tblInfoMovimientos').DataTable({
                        "dom": 'T<"clear">lfrtip',
                    });
                });  
            },
            initDatatable(){
                this.$nextTick(() => {
                    $('#tablaOrdenes').DataTable({
                        dom: 'Bftrip',
                        ordering: false,
                        buttons: [
                            {
                              extend: 'excelHtml5',
                              text: '<i class="fa fa-file-excel"></i>',
                              filename: 'Cuenta Libranzas Empleados',
                              sheetName : 'Empleados Libranza',
                              title: 'SIVER SOFTWARE ORG BLESS | Cuentas Empleados Libranza',
                              footer: 'Reporte generado desde Siver Software, producto desarrollado por ORGANIZACION BLESS. Developer Watsson.'
                            },
                            {
                                  extend: 'pdfHtml5',
                                  text: '<i class="fa fa-file-pdf"></i>',
                                  filename: 'Cuentas Libranza Empleados',
                                  footer: 'Reporte generado desde Siver Software, producto desarrollado por ORGANIZACION BLESS. Developer Watsson.',
                                  title: 'SIVER SOFTWARE ORG BLESS | Cuentas Empleados Libranza ',
                                  messageTop: 'Reporte generado desde Siver Software, producto desarrollado por ORGANIZACION BLESS. Developer Watsson.',
                            }
                          ]
                    });
                });
              },
            
        },
        mounted(){
           this.getEmpleadosLibranza();
        }
    }
        var example2=Vue.createApp(AttributeBinding).mount('#appvc')

    </script>
@endpush