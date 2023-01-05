@extends('layouts.appp')

@section('content')
    <div id="appvue">
        <div class="container mt-2">
            <div class="card" style=" font-family:Century Gothic;">
                <div class="card-header text-center" style="font-family:Century Gothic; background-color:#007bff; color:white; font-weigth:bold;">
                    LIBRANZA DE EMPLEADOS
                </div>
                <div class="card-body" v-if="displayD==true">
                    <div class="row text-center">
                        <div class="col-lg-3 col-sm-3">
                            Documento de identidad:
                        </div>
                        <div class="col-lg-3 col-sm-3">
                           <input type="number" v-model="documentoidentidad" class="form-control">
                        </div>
                        <div class="col-lg-3 col-sm-3">
                            Número de factura:
                        </div>
                        <div class="col-lg-3 col-sm-3">
                            <input type="text" v-model="numFactura" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="card-body" v-if="displayD == false">
                    El codigo para la aprobacion de libranza es: <strong v-html="codigo"></strong> con un estado: <strong v-html="estadoName"></strong>
                    <br>        
                </div>
                <div class="container" v-if="displayD == true">
                    <a href="#" class="btn btn-success w-100" v-on:click="consultaCodigo()">Consultar codigo</a>
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
            
        },
        data() {
            return {
                documentoidentidad:0,
                numFactura:'',
                displayD:true,
                codigo:'SHJYJH',
                estadoName:'',
            }
        },
        methods:{
            consultaCodigo(){
                const form_data = new FormData();
                form_data.append('documento', this.documentoidentidad);
                form_data.append('factura', this.numFactura);
                axios.post('validaCodigo',form_data)
                .then(response => {
                    if(response.data.cod == 2){
                        swal(response.data.message)
                    }else{
                        this.estadoName=response.data.estadoName
                        this.codigo=response.data.codigoSMS
                        this.displayD=false
                    }
                });
            }
        }
    }
        var example2=Vue.createApp(AttributeBinding).mount('#appvue')

    </script>
@endpush