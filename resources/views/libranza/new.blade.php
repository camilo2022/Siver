@extends('layouts.appp')

@section('content')
    <div id="appvue">
        <div class="container mt-2">
            <div class="card" style=" font-family:Century Gothic;">
                <div class="card-header text-center" style="font-family:Century Gothic; background-color:#007bff; color:white; font-weigth:bold;">
                    LIBRANZA DE EMPLEADOS
                </div>
                <div class="card-body">
                Ingrese numero de identificacion:
                <br>
                <br>
                   <input id="identificacion" type="number" v-model="empleado.documento" class="form-control" placeholder="00000000" v-on:keyup.enter="buscarEmpleado">
                   <br>
                   <br>
                   <div class="p-4 container" v-if="tef==false && hayempleado==true">
                       <button v-on:click="showInfo" class="btn btn-success w-100">Mostrar Informacion empleado</button>
                   </div>
                 
                   <div class="card" v-if="tef==true">
                       <div class="card-header" style="background-color:#007bff; color:white; font-weigth:bold;">
                           Informacion del empleado
                       </div>
                       <div class="card-body">
                           <div class="row">
                               <div class="col-sm-6">
                                  Nombre: <h4 v-html="empleado.nombres"></h4>
                               </div>
                               <div class="col-sm-6">
                                   Cargo: <h4 v-html="empleado.cargo"></h4>
                                   
                               </div>
                               <div class="col-sm-6">
                                   <div v-if="editTelefono==false">
                                       Telefono: <h4 v-html="empleado.telefono"></h4> <a style="cursor:pointer" v-on:click="editarNumero"><i class="fa fa-edit"></i></a>
                                   </div>
                                    <div v-if="editTelefono==true">
                                        Telefono: 
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <input v-model="empleado.telefono" class="form-control" type="number">
                                            </div>
                                            <div class="col-sm-2">
                                               <a style="cursor:pointer" v-on:click="saveNumero"> <i class="fa fa-check"></i></a>
                                            </div>
                                            <div class="col-sm-2">
                                                <a style="cursor:pointer" v-on:click="closeNumero"><i class="fa fa-times"></i></a>
                                            </div>
                                        </div>
                                    </div>
                               </div>
                               <div class="col-sm-6">
                                   Cupo gastado:  <h4 v-html="empleado.cupogastado"></h4>
                               </div>
                               <div class="p-4 col-sm-12">
                                  <div class="card text-center">
                                      <div class="card-body">
                                           <h2 v-html="empleado.cupoDispo"></h2>
                                      </div>
                                  </div>
                               </div>
                               <div class="col-sm-12">
                                   <button v-on:click="agregarGasto" v-if="desbloqueado == false"class="btn btn-success w-100">Agregar Gasto Libranza</button>
                               </div>
                           </div>
                       </div>
                   </div>
                   <div class="card p-4" v-if="tef==false && hayempleado==true || desbloqueado == true">
                       <div class="card-header" style="background-color:#0083ff; color:white;">
                           AGREGAR GASTO LIBRANZA
                       </div>
                       <div class="card-body">
                           <div class="row">
                              <div class="col-sm-6">
                                  Numero de Factura:
                                  
                                  <input v-if="desbloqueado == false" class="form-control" v-model="numfactura">
                                  <input v-if="desbloqueado == true" disabled class="form-control" v-model="numfactura">
                              </div>
                              <div class="col-sm-6">
                                  Ingrese el monto de la compra
                                  <div class="row">
                                      <div class="col-sm-6 col-12 col-xs-12">
                                            <input class="form-control" v-if="desbloqueado == false" v-on:input="generarProyeccionDePago()" type="number" v-model="valormonto">
                                            <input class="form-control" v-if="desbloqueado == true" disabled type="number" v-model="valormonto">  
                                      </div>
                                      <div class="col-sm-6 col-12 col-xs-12">
                                          <h4 v-html="'$'+new Intl.NumberFormat().format(valormonto)"></h4>
                                      </div>
                                  </div>
                                 
                              </div>
                              <div class="col-sm-6">
                                  Seleccione el numero de cuotas
                                  <select class="form-control" v-model="cuotas" v-if="desbloqueado == false" >
                                      <option value="0">Seleccione un monto de cuotas</option>
                                      <option value="1">1 Pago</option>
                                      <option value="2">2 Pagos</option>
                                  </select>
                                  <select class="form-control" v-model="cuotas"   v-if="desbloqueado == true" disabled >
                                      <option value="1">1 Pago</option>
                                      <option value="2">2 Pagos</option>
                                  </select>
                              </div>
                               <div class="col-sm-6">
                                   Proyección de pago:
                                   <div id="proyeccionpago" style="border: 1px solid #6861ce; padding: 6px; text-align: justify; border-radius: 15px; margin: 6px;"></div>
                                </div>
                              <div class="col-sm-12">
                                  Responsable de documento de libranza: <h4><strong>{{Auth()->user()->names}} {{Auth()->user()->apellidos}} - {{Auth()->user()->tiendacargo}}</strong></h4> 
                              </div>
                              <div class="col-sm-12">
                                  <button class="w-100 btn btn-info" v-if="desbloqueado==false || habilitarreenviar==true" v-on:click="enviarCodigoSMS">Enviar codigo autorización</button>
                              </div>
                           </div>
                       </div>
                   </div>
                   <div class="card p-4" v-if="desbloqueado==true">
                       Pide el codigo de verificación que le ha llegado al cliente al numero telefonico y digitalo para finalizar la firma digital del contrato de libranza.
                       <div class="p-4 row">
                           <div class="col-sm-6">
                               <input class="form-control" minlength="6" v-model="codigo" maxlength="6">
                           </div>
                       </div>
                       <div class="container">
                           <p>¿No ha recibido el codigo? puedes volver a enviar uno dentro de 3  minutos <br> <strong>NO CIERRE LA PESTAÑA SIN INGRESAR EL CODIGO.  Si la cierra, perderá la libranza digitada.</strong></p>
                           <button v-on:click="validarCodigo" class="btn btn-warning w-100">Validar Codigo</button>
                       </div>
                       
                   </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-custom')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://unpkg.com/axios@0.27.2/dist/axios.min.js"></script>
<script src="https://unpkg.com/vue@next"></script>
    
<script>
    const AttributeBinding = {
        mounted(){
            this.generarProyeccionDePago();
        },
        data() {
            return {
                empleado:{
                    documento:'',
                    telefono:'',
                    cupoGastado:'',
                    email:'',
                    nombres:'',
                    cargo:'',
                    cupoDispo:'CUPO: $300000 COP',
                    cc: 'CC',
                    cupo:'CUPO: $300000 COP',
                    cupoValidate: 0,
                    cupogastado:0,
                    empresa:'',
                },
                codigo:'',
                cuotas:0,
                editTelefono:false,
                tef : false,
                hayempleado:false,
                numfactura: '',
                valormonto: '',
                desbloqueado:false,
                habilitarreenviar:false,
                proyeccionCuotas: '',
                deshabilitaSistema:1,
            }
        },
        methods:{
            changeSelectCuotas(){
                $('#proyeccionpago').html('');
               this.generarProyeccionDePago();
               $('#proyeccionpago').html(this.proyeccionCuotas);
               if(this.cuotas == 0){
                    $('#proyeccionpago').html('');
                }
            },
            generarProyeccionDePago(){
                let date = new Date();
                let output = String(date.getDate()).padStart(2, '0') + '/' + String(date.getMonth() + 2).padStart(2, '0') + '/' + date.getFullYear();
                let proyeccion = '';
                let valorPago = this.valormonto/this.cuotas;
                valorPago=new Intl.NumberFormat().format(valorPago);
                if(date.getDate() <= 15){
                    if(this.cuotas == 1){
                        proyeccion += 'Primera: 15/'+(date.getMonth() + 1)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                    }else if(this.cuotas == 2){
                        if(date.getMonth() == 1){
                            proyeccion += 'Primera: 15/'+(date.getMonth() + 1)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                            proyeccion += 'Primera: 28/'+(date.getMonth() + 1)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                        }else{
                            proyeccion += 'Primera: 15/'+(date.getMonth() + 1)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                            proyeccion += 'Primera: 30/'+(date.getMonth() + 1)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                        }
                    }else if(this.cuotas == 3){
                        if(date.getMonth() == 1){
                            proyeccion += 'Primera: 15/'+(date.getMonth() + 1)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                            proyeccion += 'Primera: 28/'+(date.getMonth() + 1)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                            proyeccion += 'Primera: 15/'+(date.getMonth() + 2)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                        }else{
                            proyeccion += 'Primera: 15/'+(date.getMonth() + 1)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                            proyeccion += 'Primera: 30/'+(date.getMonth() + 1)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                            proyeccion += 'Primera: 15/'+(date.getMonth() + 2)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                        }
                    }else{
                        if(date.getMonth() == 1){
                            proyeccion += 'Primera: 15/'+(date.getMonth() + 1)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                            proyeccion += 'Primera: 28/'+(date.getMonth() + 1)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                            proyeccion += 'Primera: 15/'+(date.getMonth() + 2)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                            proyeccion += 'Primera: 30/'+(date.getMonth() + 2)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                        }else{
                            proyeccion += 'Primera: 15/'+(date.getMonth() + 1)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                            proyeccion += 'Primera: 30/'+(date.getMonth() + 1)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                            proyeccion += 'Primera: 15/'+(date.getMonth() + 2)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                            proyeccion += 'Primera: 30/'+(date.getMonth() + 2)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                        }
                    }
                }else{
                    if(this.cuotas == 1){
                        if(date.getMonth() == 1){
                            proyeccion += 'Primera: 28/'+(date.getMonth()+1)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                        }else{
                             proyeccion += 'Primera: 30/'+(date.getMonth()+1)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                        }
                    }else if(this.cuotas == 2){
                        if(date.getMonth() == 1){
                            proyeccion += 'Primera: 28/'+(date.getMonth()+1)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                            proyeccion += '<br>Segunda: 15/'+(date.getMonth()+2)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                        }else{
                             proyeccion += 'Primera: 30/'+(date.getMonth()+1)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                             proyeccion += '<br>Segunda: 15/'+(date.getMonth()+2)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                        }
                    }else if(this.cuotas == 3){
                        if(date.getMonth() == 1){
                            proyeccion += 'Primera: 28/'+(date.getMonth()+1)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                            proyeccion += '<br>Segunda: 15/'+(date.getMonth()+2)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                            proyeccion += '<br>Tercera: 30/'+(date.getMonth()+2)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                        }else{
                             proyeccion += 'Primera: 30/'+(date.getMonth()+1)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                             proyeccion += '<br>Segunda: 15/'+(date.getMonth()+2)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                             proyeccion += '<br>Tercera: 30/'+(date.getMonth()+2)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                        }
                    }else{
                        if(date.getMonth() == 1){
                            proyeccion += 'Primera: 28/'+(date.getMonth()+1)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                            proyeccion += '<br>Segunda: 15/'+(date.getMonth()+2)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                            proyeccion += '<br>Tercera: 30/'+(date.getMonth()+2)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                            proyeccion += '<br>Cuarta: 15/'+(date.getMonth()+3)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                        }else{
                             proyeccion += 'Primera: 30/'+(date.getMonth()+1)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                             proyeccion += '<br>Segunda: 15/'+(date.getMonth()+2)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                             if((date.getMonth()+2) == 2){
                                 proyeccion += '<br>Tercera: 28/'+(date.getMonth()+2)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                             }else{
                                 proyeccion += '<br>Tercera: 30/'+(date.getMonth()+2)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                             }
                             proyeccion += '<br>Cuarta: 15/'+(date.getMonth()+3)+'/'+date.getFullYear()+ 'Monto: $'+valorPago;
                        }
                    }
                }
                this.proyeccionCuotas = proyeccion;
            },
            closeNumero(){
                this.editTelefono=false;
            },
            saveNumero(){
                const form_data = new FormData();
                form_data.append('documento', this.empleado.documento);
                form_data.append('telefono', this.empleado.telefono);
                axios.post('../saveTelefonoEmpleado',form_data)
                .then(response => {
                    swal({
                        title: "Siver Informa: ",
                        text: response.data.message,
                        icon: "info",
                    });
                    this.editTelefono=false;
                });
            },
            editarNumero(){
                this.editTelefono=true;
            },
            enviarCodigoSMS(){
                if(this.numfactura != ''){
                    if(this.valormonto != ''){
                        if(this.valormonto <= this.empleado.cupoValidate){
                            swal({
                                title: "Es correcta la informacion aqui suministrada?",
                                text: "Se le efectuará cobró de libranza de la factura "+this.numfactura+" por el monto de $"+new Intl.NumberFormat().format(this.valormonto)+" a "+this.empleado.nombres+".",
                                  buttons: {
                                    cancel: "Cancelar",
                                    send: {
                                      text: "Si es correcto, Enviar",
                                      value: "send",
                                    },
                                  },
                                })
                                .then((value) => {
                                  switch (value) {
                                    case "send":
                                      this.sendSMSCODE();
                                      break;
                                    default:
                                  }
                            });   
                        }else{
                            swal({
                                title: "Campos vacios",
                                text: "El valor de compra "+new Intl.NumberFormat().format(this.valormonto)+" excede el cupo del empleado."+this.empleado.cupoDispo,
                                icon: "error",
                            });
                        }
                        
                    }else{
                        swal({
                            title: "Campos vacios",
                            text: "El monto de libranza esta vacio.",
                            icon: "error",
                        });
                    }
                }else{
                    swal({
                        title: "Campos vacios",
                        text: "El numero de factura esta vacio.",
                        icon: "error",
                    });
                }
            },
            sendSMSCODE(){
                const form_data = new FormData();
                form_data.append('documento', this.empleado.documento);
                form_data.append('numfactura', this.numfactura);
                form_data.append('monto', this.valormonto);
                form_data.append('cuotas', this.cuotas);
                
                
                let munt = new Intl.NumberFormat().format(this.valormonto);
                
                form_data.append('montoFormat', munt);
                
                axios.post('../sendSMSEmpleadoLibranza',form_data)
                .then(response => {
                    swal({
                        title: "Siver Informa: ",
                        text: response.data.message,
                        icon: "info",
                    });
                    setTimeout(() => this.habilitarreenviar=true, 180000);
                    this.desbloqueado=true;
                });
            },
            agregarGasto(){
                 this.tef=false;
            },
            showInfo(){
                if(this.ref==true){
                    this.tef=false;
                    hayempleado==false;
                }else{
                    this.tef=true;
                    hayempleado==true;
                }
            },
            validarCodigo(){
                const form_data = new FormData();
                form_data.append('documento', this.empleado.documento);
                let cod = this.codigo;
                form_data.append('codigoverf', cod);
                form_data.append('monto', this.valormonto);
                form_data.append('numfactura', this.numfactura);
                
                axios.post('../validarCodigoSMS',form_data)
                .then(response => {
                   if(response.data.codigo == 500){
                       swal({
                              title: "Siver informa",
                              text: response.data.message,
                              icon: "error",
                            });
                   }else if(response.data.codigo == 200){
                       swal({
                              title: "Siver informa",
                              text: response.data.message,
                              icon: "success",
                            });
                           this.limpiaCampos();
                   }
                });
                
                
            },
            limpiaCampos(){
                this.empleado.documento=''
                this.empleado.telefono=''
                this.empleado.cupoGastado=''
                this.empleado.email=''
                this.empleado.nombres=''
                this.empleado.cargo=''
                this.empleado.cupoDispo='CUPO: $300000 COP'
                this.empleado.cc='CC'
                this.empleado.cupo='CUPO: $300000 COP'
                this.empleado.cupoValidate= 0
                this.empleado.cupogastado=0
                this.empleado.empresa=''
                this.codigo.pa1=''
                this.codigo.pa2=''
                this.codigo.pa3=''
                this.codigo.pa4=''
                this.codigo.pa5=''
                this.codigo.pa6=''
                this.tef = false
                this.hayempleado=false
                this.numfactura= ''
                this.valormonto= ''
                this.desbloqueado=false
               this.habilitarreenviar=false
            },
            buscarEmpleado(){
               const fecha = new Date();
                if(fecha.getDate() >= 21){
                   this.deshabilitaSistema = 1; 
                }else{
                    this.deshabilitaSistema = 0;
                }
                let userid = document.querySelector('meta[name="user-id"]').content;
                
                if(this.deshabilitaSistema==1 && userid != 95 && userid != 44 && this.empleado.documento!="1090383565"){
                    swal({
                            title: "SISTEMA DESHABILITADO",
                            text: "El sistema ha sido deshabilitado por la fecha de corte "+fecha.toLocaleDateString(),
                            icon: "info",
                    });
                }else{
                    axios.get('../empleado/'+this.empleado.documento)
                    .then(response => {
                        if(response.data == 1){
                            swal({
                              title: "NO ES EMPLEADO",
                              text: "El documento digitado no pertenece a ningun empleado activo en la empresa.",
                              icon: "error",
                            });
                            this.limpiarCampos();
                        }else{
                            this.hayempleado=true;
                            this.tef=true;
                            this.cc = "CC "+this.empleado.documento;
                            this.empleado.nombres= response.data[0].nombres+" "+response.data[0].apellidos;
                            this.empleado.cupo = '$'+new Intl.NumberFormat().format(response.data[0].cupo)+" COP";
                            let cupoDe=new Intl.NumberFormat().format(response.data[0].monto_libranza);
                            this.empleado.cupoDispo = "Cupo Disponible: $"+cupoDe+" COP";
                            this.empleado.cupoValidate =  response.data[0].monto_libranza;
                            this.empleado.telefono = response.data[0].telefono;
                            this.empleado.email = response.data[0].correo;
                            this.empleado.cargo = response.data[0].cargo;
                            this.empleado.empresa = 'Organización Bless'; 
                            if(response.data[0].entidad == 4){
                                this.empleado.empresa = 'Bless Manufacturing'; 
                            }
                            this.empleado.cupogastado = "$"+new Intl.NumberFormat().format(response.data[0].cupo - response.data[0].monto_libranza)+" COP";
                            swal({
                                  title: "Si es un empleado",
                                  text: " "+this.empleado.nombres+" hace parte de "+this.empleado.empresa,
                                  icon: "success",
                                });
                        }
                    })
                }
                
            }
        }
    }
        var example2=Vue.createApp(AttributeBinding).mount('#appvue')

    </script>
@endpush