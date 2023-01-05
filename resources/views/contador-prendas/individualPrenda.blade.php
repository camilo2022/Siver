@extends('layouts.appp')

@section('content')
    <div id="appvue" class="container-fluid mt-4">
        <div class="card">
            <div class="card-header text-center" style="background-color:black; color:white; font-weight:bold">
                CONTADOR DE LOTES DE PRENDAS
            </div>
            
            <div class="card-body">
                <p>Ingrese el numero de translado u transferencia a buscar</p>    
                <div class="row">
                    <div class="col-sm-6">
                        <input type="text" v-model="numtranslado" class="form-control" style="border: black 1px solid;">
                    </div>
                    <div class="col-sm-6">
                        <button class="btn" style="background-color:black; color:white;" v-on:click="enviar()">Visualizar Conteo</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-custom')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://unpkg.com/vue@next"></script>
    
<script>
    const AttributeBinding = {
        mounted(){
            
        },
        data() {
            return {
                numtranslado:'',
            }
        },
        methods:{
            enviar(){
                let url = "https://siversoftware.zarethpremium.com/contador-prendas/individual/"+this.numtranslado;
                location.href = url;
            }
        }
    }
        var example2=Vue.createApp(AttributeBinding).mount('#appvue')

    </script>
@endpush