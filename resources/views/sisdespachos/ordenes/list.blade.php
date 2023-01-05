@extends('layouts.appp')

@section('content')
<div id="appvue">
    <section >
        <div class="container-fluid">
            <div class="card m-2">
                <div class="card-header" style="background-color:#007bff !important; color:white; text-align:center;">
                    <h3>Listado Ordenes de Despacho <strong v-if="fechaOrdenes != ''" v-html="'DIA'+fechaOrdenes"></strong> <strong v-if="fechaOrdenes == ''" v-html="'DIA'+fechaActual"></strong></h3>
                </div>
                <div class="card-body">
                    
            <div class="row mb-4">
                <div class="col-sm-4">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#cargarMasivoModal">
                Cargar Masivo
            </button>
                </div>
                <div class="col-sm-4">
                    <input type="date" @change="cargarOdenesPorFecha" v-model="fechaOrdenes" class="form-control" >
                </div>
            </div>
                    <div class="table-responsive">
                        <table id="tablaOrdenes" style="width:105%;" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Consecutivo</th>
                                    <th style="width:4%;">Cliente</th>
                                    <th>Nit</th>
                                    <th>Prioridad</th>
                                    <th style="width:3%;">Ciudad</th>
                                    <th>Direccion</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="orden in ordenesD">
                                    <td v-html="orden.consecutivo"></td>
                                    <td v-html="orden.cliente"></td>
                                    <td v-html="orden.nit"></td>
                                     <td v-html="orden.prioridad"></td>
                                    <td v-html="orden.ciudad"></td>
                                    <td v-html="orden.direccion"></td>
                                    <td><span v-if="orden.estado == 1" class="badge badge-danger" style="background-color:#083aab !important;">Cargado</span>
                                    <span v-if="orden.estado == 2" class="badge badge-warning">En Alistamiento</span>
                                    <span v-if="orden.estado == 3" class="badge badge-warning" style="background-color:#ef6f08 !important">Alistado</span>
                                    <span v-if="orden.estado == 4" class="badge badge-info">Empacando</span>
                                    <span v-if="orden.estado == 5" class="badge badge-success" style="background-color:#ef6f08 !important">Empacado</span>
                                    <span v-if="orden.estado == 6" class="badge badge-danger">Espera Verificacion</span>
                                    <span v-if="orden.estado == 7" class="badge badge-danger">Rechazado</span>
                                    <span v-if="orden.estado == 8" class="badge badge-success">Despachado</span>
                                    <span v-if="orden.estado == 9" class="badge badge-warning">Alistamiento Abandonado</span>
                                    <span v-if="orden.estado == 10" class="badge badge-danger">Empacado Abandonado</span>
                                    <span v-if="orden.estado == 11" class="badge badge-success">Facturado para Despachar</span>
                                    <span v-if="orden.estado == 12" class="badge badge-black" style="background-color:black !important; color:white !important;" v-html="'Despachado'+orden.fdespacho"></span>
                                    </td>
                                    <td>
                                        <a class="badge badge-danger" v-if="orden.estado != 8" style="color:white; cursor:pointer;" v-on:click="rechazaOrden(orden.consecutivo)">
                                            <i class="fas fa-times"></i>
                                        </a>
                                        <a v-on:click="quitarOperarioEmpacado(orden.consecutivo)" v-if="orden.estado == 4" href="#" class="badge badge-info" style="cursor:pointer;">
                                            Desbloquear
                                        </a>
                                        <a style="cursor:pointer" v-on:click="getFacturacion(orden.consecutivo)" v-if="orden.estado == 11 || orden.estado == 8" class="badge badge-success" style="cursor:pointer;">
                                            <i class="fa fa-file-invoice-dollar"></i>
                                        </a>
                                        <a v-bind:href="'view-curva/'+orden.consecutivo" style="cursor:pointer;">
                                            <i class="fa fa-bezier-curve"></i>
                                        </a>
                                        <a v-bind:href="'view-proceso/consecutivo/'+orden.consecutivo"  style="margin-left:9px; cursor:pointer;">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--Modal-->
                <div class="modal fade" id="cargarMasivoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Carga Masiva de despachos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <div style="">
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                         <a href="../../../public/Formato_subida_masiva_ordenes_despacho_siver.xlsx"><span class="btn btn-info w-100" style="cursor:pointer;">Descargar formato</span></a>
                                    </div>
                                   </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="file" id="file" ref="file"  class="form-control" v-on:change="handleFileUpload()">
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-success" v-if="disablebutton == false" v-on:click="CargarOrdenes()">Cargar</button>
                                        <label v-if="disablebutton == true">Cargando...</label>
                                    </div>
                                </div>
                                <input class="m-2 form-control" v-model="file.name" disabled>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <b>ADVERTENCIA: Espere porfavor que la pantalla se desaparezca sola.</b>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        
        <div id="modalRazonRechaza" class="modal fade" role="dialog">
          <div class="modal-dialog">
        
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Confirmación Orden Despacho</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <p>¿Cual es la razón por la que rechaza la orden de despacho?</p>
                <textarea class="form-control" v-model="razonRechazaOrden"></textarea>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <a style="cursor:pointer; color:white !important;" class="btn btn-success" v-on:click="rechazarOrdenAhora()" data-dismiss="modal">Rechazar la Orden Ahora</a>
              </div>
            </div>
        
          </div>
        </div>
        
    </section>
</div>
@endsection

@push('scripts-custom')
<script src="https://unpkg.com/axios@0.27.2/dist/axios.min.js"></script>
<script src="https://unpkg.com/vue@next"></script>
<script>
const AttributeBinding={mounted(){this.cargarOrdenes(),this.getFechaActual()},data:()=>({file:"",disablebutton:!1,ordenesD:[],fechaOrdenes:"",fechaActual:"",razonRechazaOrden:"",consecutivoParaRechazar:""}),methods:{rechazarOrdenAhora(){if(""!=this.razonRechazaOrden){let e={razon:this.razonRechazaOrden,consecutivo:this.consecutivoParaRechazar,_token:document.querySelector('meta[name="csrf-token"]').content};axios.post("rechazaOrdenDespacho",e).then(e=>{swal("Informativo",e.data.message,"info").then(e=>{e&&this.cargarOdenesPorFecha()})})}else alert("Debe especificar una raz\xf3n v\xe1lida.")},rechazaOrden(e){$("#modalRazonRechaza").modal("show"),this.consecutivoParaRechazar=e},quitarOperarioEmpacado(e){let a={consecutivoOrden:e,_token:document.querySelector('meta[name="csrf-token"]').content};axios.post("../quitarOperarioDelaOrden",a).then(e=>{this.cargarOdenesPorFecha()})},handleFileUpload(){this.file=this.$refs.file.files[0]},cargarOdenesPorFecha(){let e={date:this.fechaOrdenes,_token:document.querySelector('meta[name="csrf-token"]').content};axios.post("getForFecha",e).then(e=>{this.ordenesD=e.data,this.initDatatable()})},getFacturacion(e){window.open("../facturacionPDF/generar/"+e,"_blank").print()},CargarOrdenes(){if(""!=this.file){let e={headers:{"content-type":"multipart/form-data",_token:document.querySelector('meta[name="csrf-token"]').content}};this.disablebutton=!0;let a=new FormData;a.append("file",this.file),axios.post("submitordenes",a,e).then(e=>{swal("Aviso",e.data.message,"success").then(e=>{e&&($("#cargarMasivoModal").modal("hide"),axios.get("getordenes").then(e=>{this.ordenesD=e.data,this.initDatatable()}).catch(e=>{swal("Algo ha ocurrido mal.",e,"warning")}),this.getFechaActual())})})}else swal("AVISO","No hay archivo seleccionado","info")},cargarOrdenes(){axios.get("getordenes").then(e=>{this.ordenesD=e.data,this.initDatatable()}).catch(e=>{swal("Algo ha ocurrido mal.",e,"warning")})},initDatatable(){$("#tablaOrdenes").DataTable().destroy(),this.$nextTick(()=>{$("#tablaOrdenes").DataTable({dom:"<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"})})},getFechaActual(){var e=new Date;this.fechaActual=e.getDate()+" de "+["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"][e.getMonth()]+" de "+e.getFullYear()}}};var example2=Vue.createApp(AttributeBinding).mount("#appvue");
</script>
@endpush

