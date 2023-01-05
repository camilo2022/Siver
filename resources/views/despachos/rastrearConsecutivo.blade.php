@extends('layouts.appp')

@section('content')
    <div id="appvue">
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
                  <h2 class="text-white fw-bold">Rastrear Orden Despacho</h2>
                  <h5 class="text-white">Ey {{Auth()->user()->names.' '.Auth()->user()->apellidos}} <b>{{Auth()->user()->rol->descripcion}}</b> digita el numero de consecutivo que desees rastrear.
                  </h5>
                </div>
              </div>
            </div>
          </div>
          <div class="panel panel-body page-inner mt--5">
          <div class="card full-height">
              <div class="card-body">
                 <input id="txtQr" style="border: 1px solid #0095ff ;" v-model="consecutivo" type="text" class="form-control">
                 </br>
                 <a  v-on:click="redireccionaRastreo()" class="mt-02"> <span style="width:100%" class="btn btn-success">Rastrear Orden</span></a>
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
                    consecutivo:''
                }
            },
            methods:{
                redireccionaRastreo()
                {
                    window.location = "https://siversoftware.zarethpremium.com/sisdespachos/ordenes-despacho/view-proceso/consecutivo/"+this.consecutivo;
                }
            }
        }
        var example2=Vue.createApp(AttributeBinding).mount('#appvue')

    </script>
@endpush