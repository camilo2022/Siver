@extends('layouts.appp')
@push('custom-css')
<style>
        /* spacing */

    table {
      table-layout: fixed;
      width: 100%;
      border-collapse: collapse;
    }
    td{
        font-family: Courier, "Lucida Console", monospace !important;
    }
    thead{
        background-color:#0079fc;
        color:white;
    }
    thead th:nth-child(1) {
      width: 2%;
    }
    
    thead th:nth-child(2) {
      width: 2%;
    }
    
    thead th:nth-child(3) {
      width: 2%;
    }
    
    .totales{
        background-color:#0079fc;
        color:white;
    }
    
    textarea{
        border:none;
    }
    footer{
        position:fixed !important;
    }
    .btn-flotante {
    font-size: 16px; /* Cambiar el tama単o de la tipografia */
    text-transform: uppercase; /* Texto en mayusculas */
    font-weight: bold; /* Fuente en negrita o bold */
    color: #ffffff; /* Color del texto */
    border-radius: 5px; /* Borde del boton */
    letter-spacing: 2px; /* Espacio entre letras */
    background-color: #E91E63; /* Color de fondo */
    padding: 18px 30px; /* Relleno del boton */
    position: fixed;
    bottom: 40px;
    right: 40px;
    transition: all 300ms ease 0ms;
    box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
    z-index: 99;
    }
    .btn-flotante:hover {
    background-color: #2c2fa5; /* Color de fondo al pasar el cursor */
    box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.3);
    transform: translateY(-7px);
    }
    @media only screen and (max-width: 600px) {
    .btn-flotante {
    font-size: 14px;
    padding: 12px 20px;
    bottom: 20px;
    right: 20px;
    }
}
</style>
@endpush
@section('content')
<div id="app"></div>
<div id="appvue">
   <section >
        <div class="container-fluid">
            <div class="card m-4">
                <div class="card-header" style="background-color:#007bff !important; color:white; text-align:center;">
                    <h3><strong v-if="displayLista == false" v-html="'Alistamiento # '+idOrdenAlistamiento"></strong><strong v-if="displayLista == true">Ordenes Pendientes Por Alistar</strong></h3>
                </div>
                <div v-if="displayLista == true" class="card-body">
                <div class="row">
                    <div class="table-responsive">
                        <table id="tablaOrdenes" style="width:100%;" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Consecutivo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="orden in ordenesD">
                                    <td v-html="new Date(orden.created_at).toLocaleDateString('es-CO')"></td>
                                    <td v-html="orden.consecutivo"></td>
                                    <td><a @click="comenzarAlistamiento(orden.consecutivo)" style="margin-left:9px; cursor:pointer; background-color:green; border-radius:20px; color:white; padding:8px;"><i class="fa fa-paper-plane"></i></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>    
                    
                </div>
                <div v-if="displayLista == false" class="card-body">
                    <div class="row m-2">
                        <div class="col-12">
                            <div class="card w-100">
                                <div class="card-header" style="background-color:#008afb; color:white;">
                                    Informacion orden de despacho
                                </div>
                                <div class="card-body" style="text-align: center;">
                                    <strong><h1><span v-html="'CONSECUTIVO: '+consecutivoDespacho"></span></h1></strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                        
                            <button type="button" @click="cancelarAlistamiento()" class="mb-2 w-100 btn btn-info">Cancelar Alistamiento</button>
                        </div>
                        <div class="col-12">
                            <button @click="marcarCompletado()" v-if="totalEstados == curveAlistam.length" type="button" class="w-100 btn btn-success">Marcar Completado</button>
                            <button @click="mandarARevision()"  v-if="totalEstadosCantidades > 0 && totalEstados != curveAlistam.length" type="button" class="w-100 btn btn-danger">Mandar a Revision</button>
                        </div>
                    </div>
                   <input id="iref" type="text" class="form-control" v-model="lecturaInput" @change="readReference()" style="border: 1px solid black !important;">
                    <div class="table-responsive">
                    <div class="m-2">
                        Abreviaturas: 
                        <p>CP -> Cantidad en Picking
                            <br> CD -> Cantidad que se debe despachar</p>
                    </div>
                <div v-for="(curva,indice) in curvaDespacho">
                    <button  type="button" class="mb-2 btn w-100" style="background-color:#23282e; color:white;" data-toggle="collapse"  :data-target="'#collapseExample' + indice" aria-expanded="false" :aria-controls="'#collapseExample' + indice">
                   <b> <span v-html="curva.referencia"></span> <span class="badge badge-light" v-html="curveAlistam[indice].total"></span> de <span class="badge badge-warning" v-html="curva.total"></span> <span v-if="curveAlistam[indice].estado == 2" class="badge badge-success">Completado</span> <span v-if="curveAlistam[indice].estado == 1" class="badge badge-danger">hace falta</span></b>
                    </button>
                    <div class="collapse table-responsive" :id="'collapseExample' + indice">
                        <table class="table"> 
                            <thead>
                                <tr>
                                    <th>Talla</th>
                                    <th>CP</th>
                                    <th>CD</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="curva.t4 !=0 ">
                                    <td>T4</td>
                                    <td v-html="curveAlistam[indice].t4"></td>
                                    <td v-html="curva.t4"></td>
                                </tr>
                                <tr v-if="curva.t6 !=0 ">
                                    <td>T6</td>
                                     <td v-html="curveAlistam[indice].t6"></td>
                                    <td v-html="curva.t6"></td>
                                </tr>
                                <tr v-if="curva.t8 !=0 ">
                                    <td>T8</td>
                                    <td v-html="curveAlistam[indice].t8"></td>
                                    <td v-html="curva.t8"></td>
                                </tr>
                                <tr v-if="curva.t10 !=0 ">
                                    <td>T10</td>
                                    <td v-html="curveAlistam[indice].t10"></td>
                                    <td v-html="curva.t10"></td>
                                </tr>
                                <tr v-if="curva.t12 !=0 ">
                                    <td>T12</td>
                                    <td v-html="curveAlistam[indice].t12"></td>
                                    <td v-html="curva.t12"></td>
                                </tr>
                                <tr v-if="curva.t14 !=0 ">
                                    <td>T14</td>
                                    <td v-html="curveAlistam[indice].t14"></td>
                                    <td v-html="curva.t14"></td>
                                </tr>
                                <tr v-if="curva.t16 !=0 ">
                                    <td>T16</td>
                                    <td v-html="curveAlistam[indice].t16"></td>
                                    <td v-html="curva.t16"></td>
                                </tr>
                                <tr v-if="curva.t18 !=0 ">
                                    <td>T18</td>
                                    <td v-html="curveAlistam[indice].t18"></td>
                                    <td v-html="curva.t18"></td>
                                </tr>
                                <tr v-if="curva.t20 !=0 ">
                                    <td>T20</td>
                                    <td v-html="curveAlistam[indice].t20"></td>
                                    <td v-html="curva.t20"></td>
                                </tr>
                                <tr v-if="curva.t22 !=0 ">
                                    <td>T22</td>
                                    <td v-html="curveAlistam[indice].t22"></td>
                                    <td v-html="curva.t22"></td>
                                </tr>
                                <tr v-if="curva.t24 !=0 ">
                                    <td>T24</td>
                                    <td v-html="curveAlistam[indice].t24"></td>
                                    <td v-html="curva.t24"></td>
                                </tr>
                                <tr v-if="curva.t26 !=0 ">
                                    <td>T26</td>
                                    <td v-html="curveAlistam[indice].t26"></td>
                                    <td v-html="curva.t26"></td>
                                </tr>
                                <tr v-if="curva.t28 !=0 ">
                                    <td>T28</td>
                                    <td v-html="curveAlistam[indice].t28"></td>
                                    <td v-html="curva.t28"></td>
                                </tr>
                                <tr v-if="curva.t30 !=0 ">
                                    <td>T30</td>
                                    <td v-html="curveAlistam[indice].t30"></td>
                                    <td v-html="curva.t30"></td>
                                </tr>
                                <tr v-if="curva.t32 !=0 ">
                                    <td>T32</td>
                                    <td v-html="curveAlistam[indice].t32"></td>
                                    <td v-html="curva.t32"></td>
                                </tr>
                                <tr v-if="curva.t34 !=0 ">
                                    <td>T34</td>
                                    <td v-html="curveAlistam[indice].t34"></td>
                                    <td v-html="curva.t34"></td>
                                </tr>
                                <tr v-if="curva.t36 !=0 ">
                                    <td>T36</td>
                                    <td v-html="curveAlistam[indice].t36"></td>
                                    <td v-html="curva.t36"></td>
                                </tr>
                                <tr v-if="curva.t38 !=0 ">
                                    <td>T38</td>
                                    <td v-html="curveAlistam[indice].t38"></td>
                                    <td v-html="curva.t38"></td>
                                </tr>
                                <tr v-if="curva.s !=0 ">
                                    <td>S</td>
                                    <td v-html="curveAlistam[indice].s"></td>
                                    <td v-html="curva.s"></td>
                                </tr>
                                <tr v-if="curva.m !=0 ">
                                    <td>M</td>
                                    <td v-html="curveAlistam[indice].m"></td>
                                    <td v-html="curva.m"></td>
                                </tr>
                                <tr v-if="curva.l !=0 ">
                                    <td>L</td>
                                    <td v-html="curveAlistam[indice].l"></td>
                                    <td v-html="curva.l"></td>
                                </tr>
                                <tr v-if="curva.xl !=0 ">
                                    <td>XL</td>
                                    <td v-html="curveAlistam[indice].xl"></td>
                                    <td  v-html="curva.xl"></td>
                                </tr>
                            </tbody>
                        </table>
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
                <p>¿Cual es la razón por la que manda a revisar esta orden?</p>
                <select class="form-control" v-model="razonrevisarOrden" >
                    <option value="Indisponibilidad de totalidad de prendas">Indisponibilidad de totalidad de prendas</option>
                    <option value="Sin total de prendas en totalidad de talla especifica">Sin total de prendas en totalidad de talla especifica</option>
                </select>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <a style="cursor:pointer; color:white !important;" class="btn btn-success" v-on:click="confirmarRevision()" data-dismiss="modal">Mandar a Revisar Ahora</a>
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
        const AttributeBinding = {
            mounted(){
                this.ValidaUserNoTerminoOrdenAlistamiento();
                this.cargarOrdenes();
                this.startInterval();
            },
            data () {
                return {
                    disablebutton:false,
                    ordenesD:[],
                    displayLista: true,
                    idOrdenAlistamiento:'',
                    curvaDespacho:[],
                    curveAlistam:[],
                    lecturaInput:'',
                    btnMarcarCompletadoDisplay:false,
                    totalEstados:0,
                    totalEstadosCantidades:0,
                    runInterval:'',
                    consecutivoDespacho:'',
                    razonrevisarOrden:'Indisponibilidad de totalidad de prendas'
                }
              },
            methods:{
                startInterval() {
                          setInterval(() => {
                            this.cargarOrdenes();
                        }, 9000);
                    },
                mandarRevisarAhora(){
                    
                  },
                limpia(){
                      $('#iref').val('');
                  },
                comenzarAlistamiento(consecutivo){
                      this.consecutivoDespacho = consecutivo
                      axios.get('getOrdenAlistamiento/'+consecutivo)
                      .then(response => {
                          if(response.data == 'No hay operario en la orden'){
                              swal({
                                title: "Estas seguro?",
                                text: "Si aceptas, comenzarás a alistar la orden, una vez iniciada, procura finalizarla.",
                                icon: "warning",
                                buttons: true,
                                dangerMode: true,
                                }).then((willDelete) => {
                                    if (willDelete) {
                                        this.displayLista = false
                                        this.enviaPeticion(consecutivo)
                                    }
                                });
                          }else swal('Picking Informa: ','Ya existe un operario alistando esta orden.','warning');
                      })
                  },
                cancelarAlistamiento(){
                      swal({
                            title: "Estas seguro que quieres de dejar de Alistar esta Orden?",
                            text: "Una vez aceptes, se eliminara el registro de alistamiento y la orden de despacho quedará libre para otro operario.",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                            })
                            .then((willDelete) => {
                            if (willDelete) {
                                axios.post('deleteAlistamiento',{ordenalistamiento:this.idOrdenAlistamiento})
                                .then(response => {
                                    window.location.href='pendienteAlistar';
                                })
                            }
                        });
                  },
                marcarCompletado(){
                     axios.post('marcarCompletada',{iorden:this.idOrdenAlistamiento,arrayOperario:this.curveAlistam})
                      .then(response => {
                          swal('Información de Picking',response.data.message,'success').then((accion) => {
                              if(accion){
                                  var min = window.open("viewCurvaPDF/"+this.idOrdenAlistamiento,'_blank');
                                    min.print();
                                  window.location.href='pendienteAlistar';
                              }
                          });
                      })
                  },
                mandarARevision(){
                      $('#modalRazonRechaza').modal('show');
                  },
                confirmarRevision(){
                      if(this.razonrevisarOrden != ''){
                          axios.post('mandarARevisar',{iorden:this.idOrdenAlistamiento,arrayOperario:this.curveAlistam,razonMandaRevision:this.razonrevisarOrden})
                          .then(response => {
                              swal('Información de Picking',response.data.message,'success').then((accion) => {
                                  if(accion){
                                      window.location.href='pendienteAlistar';
                                  }
                              });
                              
                          })
                      }else{
                          swal('Informacion','No ha especificado un razon por la que manda a revisar.');
                      }
                      
                  },
                ValidaUserNoTerminoOrdenAlistamiento(){
                      axios.post('validaSiTieneOrden')
                      .then(response => {
                          this.idOrdenAlistamiento = response.data[0];
                          let consecutivo = response.data[1];
                          if(consecutivo != null){
                              swal('Alerta Alistamiento','Has abandonado una orden de alistamiento , porfavor terminala o cierrala.','warning');
                                this.displayLista = false
                                this.consecutivoDespacho = consecutivo
                                this.cargaCurvaDespacho(consecutivo)
                                this.cargaCurvaAlistamiento(this.idOrdenAlistamiento)
                          }
                      })
                  },
                enviaPeticion(consecutivo){
                      let data ={consecutivo: consecutivo, '_token': document.querySelector('meta[name="csrf-token"]').content};
                      axios.post('createAlistamiento',data)
                      .then(response => {
                        this.idOrdenAlistamiento = response.data.id
                        this.cargaCurvaDespacho(consecutivo)
                        this.cargaCurvaAlistamiento(response.data.id)
                      }).catch(error => {
                          swal('El sistema informa:',error.data.message,'info');
                      })
                  },
                cargaCurvaDespacho(consecutivo){
                      axios.get('getCurvaDespacho/'+consecutivo)
                      .then(response => {
                         this.curvaDespacho = response.data
                      })
                  },
                cargaCurvaAlistamiento(ordenid){
                     axios.post('getCurvaAlistamiento',{alistamientoid:ordenid})
                     .then(response => {
                       console.log(response.data)
                       this.curveAlistam = response.data
                       this.validaEstados();
                     })
                  },
                cargarOrdenes(){
                    axios.get('getDataPendienteAlistar')
                    .then(response => {
                        this.ordenesD=response.data
                        this.initDatatable();
                    })
                  },
                initDatatable(){
                    $('#tablaOrdenes').DataTable().destroy();
                    this.$nextTick(() => {
                        $('#tablaOrdenes').DataTable({
                            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                                "<'row'<'col-sm-12'tr>>" +
                                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>", 
                            });
                        });
                  },
                readReference(){
                        let lc = this.lecturaInput.toUpperCase();
                        let data = lc.split('-');
                        let ref = null;
                        let talla = null;
                        if(data.length == 5){
                            //REF-TONO-TRANSFORMACION-TALLA-COLOR
                            ref = data[0]+"-"+data[1]+"-"+data[2];
                            talla = data[3];
                        }else if(data.length == 4){
                            //REF-TONO-TALLA-COLOR
                            ref = data[0]+"-"+data[1];
                            talla = data[2];
                        }else{
                            ref = data[0];
                            //REF-TALLA-COLOR
                            talla = data[1];
                        }
                        
                        let posArray = this.buscaReferencia(ref,talla)
                        if(posArray != null){
                            this.agregaTallaReferenciaArray(ref,talla,posArray)
                        }else swal('Alerta Picking','El PICKING para esta referencia ya esta completo ó estas intentado pasar una referencia o talla, que no se encuentra en la curva de despacho.','warning');
                        this.lecturaInput=''
                    },
                validaEstados(){
                        let total = 0;
                        for (let index = 0; index < this.curveAlistam.length; index++) {
                            if(this.curveAlistam[index].total == this.curvaDespacho[index].total){
                                total ++;
                                this.curveAlistam[index].estado = 2;
                            }
                        }
                         this.totalEstados = total;
                        this.validaCantidades();
                    },
                validaCantidades(){
                        let total = 0;
                        for (let index = 0; index < this.curveAlistam.length; index++) {
                            total++;
                        }
                         this.totalEstadosCantidades = total;
                    },
                buscaReferencia(referencia,talla){
                        for (let index = 0; index < this.curveAlistam.length; index++) {
                            if(this.curveAlistam[index].referencia == referencia && this.curveAlistam[index].total < this.curvaDespacho[index].total){
                                if(talla == '04'){
                                    if(this.curvaDespacho[index].t4 > 0) return index;
                                }else if(talla == '06'){
                                    if(this.curvaDespacho[index].t6 > 0) return index;
                                }else if(talla == '08'){
                                    if(this.curvaDespacho[index].t8 > 0) return index;
                                }else if(talla == '10'){
                                    if(this.curvaDespacho[index].t10 > 0) return index;
                                }else if(talla == '12'){
                                    if(this.curvaDespacho[index].t12 > 0) return index;
                                }else if(talla == '14'){
                                    if(this.curvaDespacho[index].t14 > 0) return index;
                                }else if(talla == '16'){
                                    if(this.curvaDespacho[index].t16 > 0) return index;
                                }else if(talla == '18'){
                                    if(this.curvaDespacho[index].t18 > 0) return index;
                                }else if(talla == '20'){
                                    if(this.curvaDespacho[index].t20 > 0) return index;
                                }else if(talla == '22'){
                                    if(this.curvaDespacho[index].t22 > 0) return index;
                                }else if(talla == '24'){
                                    if(this.curvaDespacho[index].t24 > 0) return index;
                                }else if(talla == '26'){
                                    if(this.curvaDespacho[index].t26 > 0) return index;
                                }else if(talla == '28'){
                                    if(this.curvaDespacho[index].t28 > 0) return index;
                                }else if(talla == '30'){
                                    if(this.curvaDespacho[index].t30 > 0) return index;
                                }else if(talla == '32'){
                                    if(this.curvaDespacho[index].t32 > 0) return index;
                                }else if(talla == '34'){
                                    if(this.curvaDespacho[index].t34 > 0) return index;
                                }else if(talla == '36'){
                                    if(this.curvaDespacho[index].t36 > 0) return index;
                                }else if(talla == '38'){
                                    if(this.curvaDespacho[index].t38 > 0) return index;
                                }else if(talla == 's'){
                                    if(this.curvaDespacho[index].s > 0) return index;
                                }else if(talla == 'm'){
                                    if(this.curvaDespacho[index].tm > 0) return index;
                                }else if(talla == 'l'){
                                    if(this.curvaDespacho[index].l > 0) return index;
                                }else if(talla == 'xl'){
                                    if(this.curvaDespacho[index].xl > 0) return index;
                                }
                            }
                        }
                        return null;
                    },
                agregaTallaReferenciaArray(ref,talla,posArray){
                        if(talla == '04'){
                            if(this.curveAlistam[posArray].t4 < this.curvaDespacho[posArray].t4){
                                this.curveAlistam[posArray].t4++;
                                this.curveAlistam[posArray].total++;
                                if(this.curveAlistam[posArray].total == this.curvaDespacho[posArray].total) this.curveAlistam[posArray].estado = 2;
                                this.validaEstados()
                            }else swal('Alerta Picking','No se puede superar la cantidad pedida de la referencia '+ref+' para la talla '+talla+', [CANTIDAD PEDIDA]: '+this.curvaDespacho[posArray].t4,'warning');
                        }else if(talla == '06'){
                            if(this.curveAlistam[posArray].t6 < this.curvaDespacho[posArray].t6){
                                this.curveAlistam[posArray].t6++;
                                this.curveAlistam[posArray].total++;
                                if(this.curveAlistam[posArray].total == this.curvaDespacho[posArray].total) this.curveAlistam[posArray].estado = 2;
                                this.validaEstados()
                            }else swal('Alerta Picking','No se puede superar la cantidad pedida de la referencia '+ref+' para la talla '+talla+', [CANTIDAD PEDIDA]: '+this.curvaDespacho[posArray].t6,'warning');
                        }else if(talla == '08'){
                            if(this.curveAlistam[posArray].t8 < this.curvaDespacho[posArray].t8){
                                this.curveAlistam[posArray].t8++;
                                this.curveAlistam[posArray].total++;
                                if(this.curveAlistam[posArray].total == this.curvaDespacho[posArray].total) this.curveAlistam[posArray].estado = 2;
                            this.validaEstados()
                            }else swal('Alerta Picking','No se puede superar la cantidad pedida de la referencia '+ref+' para la talla '+talla+', [CANTIDAD PEDIDA]: '+this.curvaDespacho[posArray].t8,'warning');
                        }else if(talla == '10'){
                            if(this.curveAlistam[posArray].t10 < this.curvaDespacho[posArray].t10){
                                this.curveAlistam[posArray].t10++;
                                this.curveAlistam[posArray].total++;
                                if(this.curveAlistam[posArray].total == this.curvaDespacho[posArray].total) this.curveAlistam[posArray].estado = 2;
                            this.validaEstados()
                            }else swal('Alerta Picking','No se puede superar la cantidad pedida de la referencia '+ref+' para la talla '+talla+', [CANTIDAD PEDIDA]: '+this.curvaDespacho[posArray].t10,'warning');
                        }else if(talla == '12'){
                            if(this.curveAlistam[posArray].t12 < this.curvaDespacho[posArray].t12){
                                this.curveAlistam[posArray].t12++;
                                this.curveAlistam[posArray].total++;
                                if(this.curveAlistam[posArray].total == this.curvaDespacho[posArray].total) this.curveAlistam[posArray].estado = 2;
                                this.validaEstados()
                            }else swal('Alerta Picking','No se puede superar la cantidad pedida de la referencia '+ref+' para la talla '+talla+', [CANTIDAD PEDIDA]: '+this.curvaDespacho[posArray].t12,'warning');
                        }else if(talla == '14'){
                            if(this.curveAlistam[posArray].t14 < this.curvaDespacho[posArray].t14){
                                this.curveAlistam[posArray].t14++;
                                this.curveAlistam[posArray].total++;
                                if(this.curveAlistam[posArray].total == this.curvaDespacho[posArray].total) this.curveAlistam[posArray].estado = 2;
                                this.validaEstados()
                            }else swal('Alerta Picking','No se puede superar la cantidad pedida de la referencia '+ref+' para la talla '+talla+', [CANTIDAD PEDIDA]: '+this.curvaDespacho[posArray].t14,'warning');
                        }else if(talla == '16'){
                            if(this.curveAlistam[posArray].t16 < this.curvaDespacho[posArray].t16){
                                this.curveAlistam[posArray].t16++;
                                this.curveAlistam[posArray].total++;
                                if(this.curveAlistam[posArray].total == this.curvaDespacho[posArray].total) this.curveAlistam[posArray].estado = 2;
                                this.validaEstados()
                            }else swal('Alerta Picking','No se puede superar la cantidad pedida de la referencia '+ref+' para la talla '+talla+', [CANTIDAD PEDIDA]: '+this.curvaDespacho[posArray].t16,'warning');
                        }else if(talla == '18'){
                            if(this.curveAlistam[posArray].t18 < this.curvaDespacho[posArray].t18){
                                this.curveAlistam[posArray].t18++;
                                this.curveAlistam[posArray].total++;
                                if(this.curveAlistam[posArray].total == this.curvaDespacho[posArray].total) this.curveAlistam[posArray].estado = 2;
                                this.validaEstados()
                            }else swal('Alerta Picking','No se puede superar la cantidad pedida de la referencia '+ref+' para la talla '+talla+', [CANTIDAD PEDIDA]: '+this.curvaDespacho[posArray].t18,'warning');
                        }else if(talla == '20'){
                            if(this.curveAlistam[posArray].t20 < this.curvaDespacho[posArray].t20){
                                this.curveAlistam[posArray].t20++;
                                this.curveAlistam[posArray].total++;
                                if(this.curveAlistam[posArray].total == this.curvaDespacho[posArray].total) this.curveAlistam[posArray].estado = 2;
                                this.validaEstados()
                            }else swal('Alerta Picking','No se puede superar la cantidad pedida de la referencia '+ref+' para la talla '+talla+', [CANTIDAD PEDIDA]: '+this.curvaDespacho[posArray].t20,'warning');
                        }else if(talla == '22'){
                            if(this.curveAlistam[posArray].t22 < this.curvaDespacho[posArray].t22){
                                this.curveAlistam[posArray].t22++;
                                this.curveAlistam[posArray].total++;
                                if(this.curveAlistam[posArray].total == this.curvaDespacho[posArray].total) this.curveAlistam[posArray].estado = 2;
                                this.validaEstados()
                            }else swal('Alerta Picking','No se puede superar la cantidad pedida de la referencia '+ref+' para la talla '+talla+', [CANTIDAD PEDIDA]: '+this.curvaDespacho[posArray].t22,'warning');
                        }else if(talla == '24'){
                            if(this.curveAlistam[posArray].t24 < this.curvaDespacho[posArray].t24){
                                this.curveAlistam[posArray].t24++;
                                this.curveAlistam[posArray].total++;
                                if(this.curveAlistam[posArray].total == this.curvaDespacho[posArray].total) this.curveAlistam[posArray].estado = 2;
                                this.validaEstados()
                            }else swal('Alerta Picking','No se puede superar la cantidad pedida de la referencia '+ref+' para la talla '+talla+', [CANTIDAD PEDIDA]: '+this.curvaDespacho[posArray].t24,'warning');
                        }else if(talla == '26'){
                            if(this.curveAlistam[posArray].t26 < this.curvaDespacho[posArray].t26){
                                this.curveAlistam[posArray].t26++;
                                this.curveAlistam[posArray].total++;
                                if(this.curveAlistam[posArray].total == this.curvaDespacho[posArray].total) this.curveAlistam[posArray].estado = 2;
                                this.validaEstados()
                            }else swal('Alerta Picking','No se puede superar la cantidad pedida de la referencia '+ref+' para la talla '+talla+', [CANTIDAD PEDIDA]: '+this.curvaDespacho[posArray].t26,'warning');
                        }else if(talla == '28'){
                            if(this.curveAlistam[posArray].t28 < this.curvaDespacho[posArray].t28){
                                this.curveAlistam[posArray].t28++;
                                this.curveAlistam[posArray].total++;
                                if(this.curveAlistam[posArray].total == this.curvaDespacho[posArray].total) this.curveAlistam[posArray].estado = 2;
                                this.validaEstados()
                            }else swal('Alerta Picking','No se puede superar la cantidad pedida de la referencia '+ref+' para la talla '+talla+', [CANTIDAD PEDIDA]: '+this.curvaDespacho[posArray].t28,'warning');
                        }else if(talla == '30'){
                            if(this.curveAlistam[posArray].t30 < this.curvaDespacho[posArray].t30){
                                this.curveAlistam[posArray].t30++;
                                this.curveAlistam[posArray].total++;
                                if(this.curveAlistam[posArray].total == this.curvaDespacho[posArray].total) this.curveAlistam[posArray].estado = 2;
                                this.validaEstados()
                            }else swal('Alerta Picking','No se puede superar la cantidad pedida de la referencia '+ref+' para la talla '+talla+', [CANTIDAD PEDIDA]: '+this.curvaDespacho[posArray].t30,'warning');
                        }else if(talla == '32'){
                            if(this.curveAlistam[posArray].t32 < this.curvaDespacho[posArray].t32){
                                this.curveAlistam[posArray].t32++;
                                this.curveAlistam[posArray].total++;
                                if(this.curveAlistam[posArray].total == this.curvaDespacho[posArray].total) this.curveAlistam[posArray].estado = 2;
                                this.validaEstados()
                            }else swal('Alerta Picking','No se puede superar la cantidad pedida de la referencia '+ref+' para la talla '+talla+', [CANTIDAD PEDIDA]: '+this.curvaDespacho[posArray].t32,'warning');
                        }else if(talla == '34'){
                            if(this.curveAlistam[posArray].t34 < this.curvaDespacho[posArray].t34){
                                this.curveAlistam[posArray].t34++;
                                this.curveAlistam[posArray].total++;
                                if(this.curveAlistam[posArray].total == this.curvaDespacho[posArray].total) this.curveAlistam[posArray].estado = 2;
                                this.validaEstados()
                            }else swal('Alerta Picking','No se puede superar la cantidad pedida de la referencia '+ref+' para la talla '+talla+', [CANTIDAD PEDIDA]: '+this.curvaDespacho[posArray].t34,'warning');
                        }else if(talla == '36'){
                            if(this.curveAlistam[posArray].t36 < this.curvaDespacho[posArray].t36){
                                this.curveAlistam[posArray].t36++;
                                this.curveAlistam[posArray].total++;
                                if(this.curveAlistam[posArray].total == this.curvaDespacho[posArray].total) this.curveAlistam[posArray].estado = 2;
                                this.validaEstados()
                            }else swal('Alerta Picking','No se puede superar la cantidad pedida de la referencia '+ref+' para la talla '+talla+', [CANTIDAD PEDIDA]: '+this.curvaDespacho[posArray].t36,'warning');
                        }else if(talla == '38'){
                            if(this.curveAlistam[posArray].t38 < this.curvaDespacho[posArray].t38){
                                this.curveAlistam[posArray].t38++;
                                this.curveAlistam[posArray].total++;
                                if(this.curveAlistam[posArray].total == this.curvaDespacho[posArray].total) this.curveAlistam[posArray].estado = 2;
                                this.validaEstados()
                            }else swal('Alerta Picking','No se puede superar la cantidad pedida de la referencia '+ref+' para la talla '+talla+', [CANTIDAD PEDIDA]: '+this.curvaDespacho[posArray].t38,'warning');
                        }else if(talla == 's'){
                            if(this.curveAlistam[posArray].s < this.curvaDespacho[posArray].s){
                                this.curveAlistam[posArray].s++;
                                this.curveAlistam[posArray].total++;
                                if(this.curveAlistam[posArray].total == this.curvaDespacho[posArray].total) this.curveAlistam[posArray].estado = 2;
                                this.validaEstados()
                            }else swal('Alerta Picking','No se puede superar la cantidad pedida de la referencia '+ref+' para la talla '+talla+', [CANTIDAD PEDIDA]: '+this.curvaDespacho[posArray].s,'warning');
                        }else if(talla == 'm'){
                            if(this.curveAlistam[posArray].m < this.curvaDespacho[posArray].m){
                                this.curveAlistam[posArray].m++;
                                this.curveAlistam[posArray].total++;
                                if(this.curveAlistam[posArray].total == this.curvaDespacho[posArray].total) this.curveAlistam[posArray].estado = 2;
                                this.validaEstados()
                            }else swal('Alerta Picking','No se puede superar la cantidad pedida de la referencia '+ref+' para la talla '+talla+', [CANTIDAD PEDIDA]: '+this.curvaDespacho[posArray].m,'warning');
                        }else if(talla == 'l'){
                            if(this.curveAlistam[posArray].l < this.curvaDespacho[posArray].l){
                                this.curveAlistam[posArray].l++;
                                this.curveAlistam[posArray].total++;
                                if(this.curveAlistam[posArray].total == this.curvaDespacho[posArray].total) this.curveAlistam[posArray].estado = 2;
                                this.validaEstados()
                            }else swal('Alerta Picking','No se puede superar la cantidad pedida de la referencia '+ref+' para la talla '+talla+', [CANTIDAD PEDIDA]: '+this.curvaDespacho[posArray].l,'warning');
                        }else if(talla == 'xl'){
                            if(this.curveAlistam[posArray].xl < this.curvaDespacho[posArray].xl){
                                this.curveAlistam[posArray].xl++;
                                this.curveAlistam[posArray].total++;
                                if(this.curveAlistam[posArray].total == this.curvaDespacho[posArray].total) this.curveAlistam[posArray].estado = 2;
                                this.validaEstados()
                            }else swal('Alerta Picking','No se puede superar la cantidad pedida de la referencia '+ref+' para la talla '+talla+', [CANTIDAD PEDIDA]: '+this.curvaDespacho[posArray].xl,'warning');
                        }
                    }
            }
        }
        var example2=Vue.createApp(AttributeBinding).mount('#appvue')
</script>
@endpush