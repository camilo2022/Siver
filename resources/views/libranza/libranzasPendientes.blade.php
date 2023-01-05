@extends('layouts.appp')
@push('custom-css')

@endpush
@section('content')
<div id="appvc">
    <div class="container-fluid mt-2">
        <div class="card" style=" font-family:Century Gothic;">
            <div class="card-header text-center" style="font-family:Century Gothic; background-color:#007bff; color:white; font-weigth:bold;">
               Gestion Libranzas Pendientes de PAGO
            </div>
             <div class="container-fluid text-center">
                   <i class="fas fa-dollar-sign" style="color:#70e101; font-size:3em !important"></i> <strong style="color:#70e101; font-size:3em !important" v-html="new Intl.NumberFormat().format(total)"></strong> <small>Total de libranzas pendientes de pago</small>
                </div>
                <div  class="container p-3">
                   <p> Carga masiva de descuento de libranzas pendientes CODIGOLIBRANZAID | MontoDescontar, archivo .xlsx</p>
                  <input type="file" id="file" ref="file" class="form-control mb-2" accept=".xlsx,.xls" v-on:change="handleFileUpload()">
                <button v-if="displayButton == true" class="btn btn-success w-100" @click="subirDescuentos()"><i class="fa fa-sync"></i> Subir descuentos de libranza</button>
                <img v-if="displayButton == false"src="https://siversoftware.zarethpremium.com/img/cargando.gif">
              </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tablaOrdenes" style="width:105%;" class="table">
                        <thead>
                            <tr>
                              <th scope="col">Codigo</th>
                              <th scope="col">Fecha</th>
                              <th scope="col">Empleado</th>
                              <th scope="col">Tienda</th>
                              <th scope="col">Monto</th>
                              <th scope="col">Cuotas</th>
                              <th scope="col">Cuotas Pagas</th>
                              <th scope="col">Valor Cuota</th>
                              <th scope="col">COD SMS</th>
                              <th scope="col">Acciones</th>
                            </tr>
                      </thead>
                        <tbody>
                            <tr v-for="libranza in libranzas">
                                <td v-html="libranza.codigo"></td>
                                <td v-html="libranza.fecha"></td>
                                <td v-html="libranza.empleado"></td>
                                <td v-html="libranza.tienda"></td>
                                <td><span class="badge badge-success" v-html="'$'+new Intl.NumberFormat().format(libranza.monto)"></span></td>
                                <td v-html="libranza.cuotas"></td>
                                <td v-html="libranza.pagas+' de '+libranza.cuotas"></td>
                                <td v-html="libranza.valorCuota"></td>
                                <td v-html="libranza.codsms"></td>
                                <td><a style="cursor:pointer;" v-on:click="disminuirCantidad(libranza.codigo)"><span class="badge badge-warning"><i class="fas fa-hand-holding-usd"></i></span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="modalDisminuir" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background-color:#0058ff; color:white;">
            <h5 class="modal-title" id="exampleModalLongTitle">Disminuir Saldo Libranza COD</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
             <div class="container text-center">
                Informacion general de la libranza
                <div class="row">
                    <div class="col-12 col-xs-12 col-md-12 col-lg-6" id="infoDeuda">
                        Deuda actual: <span class="badge badge-success" v-html="'$'+new Intl.NumberFormat().format(libranzaSeleccionada.monto)"></span>
                        <br>
                        Nuevo monto de deuda: <span class="badge badge-danger" v-html="'$'+new Intl.NumberFormat().format(nuevoTotal)"></span>
                        <br>
                        Monto Pago a fecha de hoy: <span class="badge badge-danger" v-html="'$'+new Intl.NumberFormat().format(libranzaSeleccionada.pagado)"></span>
                    </div>
                    <div class="col-12 col-xs-12 col-md-12 col-lg-6">
                       Monto descontar: <input type="number" v-model="cantidadDisminuir" v-on:input="calcularTotalDisminuido()" class="form-control">
                    </div>
                </div>
             </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn"   style="background-color:#0058ff; color:white;" data-dismiss="modal">Close</button>
            <button type="button" class="btn"   style="background-color:#08c933; color:white;" v-on:click="descontarDeuda()">Descontar Deuda</button>
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
               total:0,
               cantidadDisminuir:'',
               nuevoTotal:'0',
               libranzaSeleccionada:[],
               file:'',
               displayButton:true
            }
        },
        methods:{
            subirDescuentos(){
                  if(this.file != ''){
                      this.displayButton=false
                      const config = {
                            headers: {
                            'content-type': 'multipart/form-data',
                            '_token': document.querySelector('meta[name="csrf-token"]').content,
                            }
                      }
                      let formData = new FormData();
                      formData.append('file',this.file);
                      /*Se hace la peticion */
                       axios.post('subirDescuentosLibranzaManual',formData,config)
                       .then(response => {
                           this.displayButton=true
                           this.getLibranzasEmpleadosPendientes();
                           swal('Aviso',response.data.message,'success');
                       })
                  }else{
                    swal("AVISO","No hay archivo seleccionado","info");
                  }
                
              },
            handleFileUpload(){
                      this.file = this.$refs.file.files[0];
            },
            calcularTotalDisminuido(){
                if(this.cantidadDisminuir <= this.libranzaSeleccionada.pagado){
                    this.nuevoTotal = this.libranzaSeleccionada.pagado-this.cantidadDisminuir;
                }else{
                    alert('No puedes sobrepasar la cantidad a disminuir de la deuda actual')
                    this.cantidadDisminuir=''
                    this.nuevoTotal = ''
                }
              
            },
            getLibranzasEmpleadosPendientes(){
                 axios.get('listado_pendientes')
                .then(response => {
                    this.libranzas = response.data[0].data
                    this.total = response.data[0].montoTotal
                    $('#tablaOrdenes').DataTable().destroy();
                    this.initDatatable();
                })
            },
            descontarDeuda(){
                swal({
                    title: "Es correcta la informacion aqui suministrada?",
                    text: "Se le descontara a "+this.libranzaSeleccionada.empleado+" un saldo de $"+new Intl.NumberFormat().format(this.cantidadDisminuir)+" a su deuda de: $"+new Intl.NumberFormat().format(this.libranzaSeleccionada.monto),
                    buttons: {
                                cancel: "Cancelar",
                                send: {
                                text: "Si es correcto, descontar",
                                value: "send",
                            },
                        },
                    })
                .then((value) => {
                    this.mandarPeticionDescontar();
                });
            },
            mandarPeticionDescontar(){
                const form_data = new FormData();
                form_data.append('codigo', this.libranzaSeleccionada.codigo);
                form_data.append('monto', this.cantidadDisminuir);

                axios.post('descuentaLibranzaContabilidad',form_data)
                .then(response => {
                    swal({
                        title: "Siver Informa: ",
                        text: response.data.data,
                        icon: "info",
                    });
                     $('#modalDisminuir').modal('hide');
                     this.limpiarCampos();
                });  
            },
            limpiarCampos(){
                this.cantidadDisminuir = ''
                this.nuevoTotal = 0
                this.libranzaSeleccionada = ''
                this.getLibranzasEmpleadosPendientes();
            },
            disminuirCantidad(codigo){
                this.getSeleccionadaLibranza(codigo);
                $('#modalDisminuir').modal('show');
            },
            getSeleccionadaLibranza(codigo){
                for (var i = 0; i < this.libranzas.length; i+=1) {
                  if(this.libranzas[i].codigo == codigo){
                      this.libranzaSeleccionada = this.libranzas[i];
                  }
                }
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
                              filename: 'Reporte libranzas Pendientes de pago',
                              sheetName : 'Libranza por Empleados',
                              title: 'SIVER SOFTWARE ORG BLESS | Libranza por Empleados',
                              footer: 'Reporte generado desde Siver Software, producto desarrollado por ORGANIZACION BLESS. Developer Watsson.'
                            },
                            {
                                  extend: 'pdfHtml5',
                                  text: '<i class="fa fa-file-pdf"></i>',
                                  filename: 'Libranzas Pendiente Pago',
                                  footer: 'Reporte generado desde Siver Software, producto desarrollado por ORGANIZACION BLESS. Developer Watsson.',
                                  title: 'SIVER SOFTWARE ORG BLESS | Libranza por Empleados ',
                                  messageTop: 'En el actual archivo, contendrá la información de todas las libranzas que estan pendientes de pago hoy'+today+' ',
                            }
                          ]
                    });
                });
              },
            
        },
        mounted(){
           this.getLibranzasEmpleadosPendientes();
        }
    }
        var example2=Vue.createApp(AttributeBinding).mount('#appvc')

    </script>
@endpush