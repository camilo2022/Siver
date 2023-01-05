@extends('layouts.appp')

@section('content')
   <div id="appvuerrt">
      <div class="panel-header bg-primary-gradient">
      <div class="page-inner py-5">
        <div
          class="
            d-flex
            align-items-left align-items-md-center
            flex-column flex-md-row
          "
        >
          <div>
            <h2 class="text-white fw-bold">Sincronizador de PRODUCTOS SIESA PARA SISTEMA DE TIENDAS</h2>
            <h5 class="text-white">SISTEMA DE TIENDAS BLESS</h5>
          </div>
        </div>
      </div>
    </div>
    
<div class="panel panel-body page-inner mt--5">
      <div class="row mt--2">
        <div class="col-md-12 col-12 col-xs-12">
          <div class="card full-height">
            <div class="card-body">
              <div  class="container">
                  <input type="file" id="file" ref="file" class="form-control mb-2" accept=".xlsx,.xls" v-on:change="handleFileUpload()">
                <button v-if="displayButton == true" class="btn btn-success w-100" @click="sincronizarProductos()"><i class="fa fa-sync"></i> Sincronizar PRODUCTOS SIESA</button>
                <img v-if="displayButton == false"src="https://siversoftware.zarethpremium.com/img/cargando.gif">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    </div>
@endsection

@push('scripts-custom')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://unpkg.com/vue@next"></script>
    
    <script>
        const AttributeBinding = {
            mounted(){
                
            },
            data() {
                return {
                   file:'',
                   displayButton:true,
                }
            },
            methods:{
                handleFileUpload(){
                      this.file = this.$refs.file.files[0];
                },
                sincronizarProductos(){
                  if(this.file != ''){
                      this.displayButton = false
                      const config = {
                            headers: {
                            'content-type': 'multipart/form-data',
                            '_token': document.querySelector('meta[name="csrf-token"]').content,
                            }
                      }
                      let formData = new FormData();
                      formData.append('file',this.file);
                      /*Se hace la peticion */
                       axios.post('submitproductosSiesa_Manual',formData,config)
                       .then(response => {
                           this.displayButton=false
                           swal('Aviso',response.data.message,'success');
                       })
                  }else{
                    swal("AVISO","No hay archivo seleccionado","info");
                  }
                
              },
                
            }
        }
        var example2=Vue.createApp(AttributeBinding).mount('#appvuerrt')

    </script>
@endpush