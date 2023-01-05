@extends('layouts.appp')

@section('content')
<div id="appvc">
<section>
    <div class="panel-header bg-white">
      <div class="page-inner py-5">
          <div class="card">
             <div class="card-header" style="background-color:#0069ff; color:white;">
                 Exportar Listado por fecha
             </div>
             <div class="card-body">
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-3">
                        <input type="date" class="form-control" v-model="date1">
                        </div>
                    <div class="col-sm-3">
                        <input type="date" class="form-control" v-model="date2">
                        </div>
                    <div class="col-sm-3"></div>
                </div>
                <br>
                <button @click="BuscarFecha()" class="btn w-100" style="font-size:1.3em; background-color:#0069ff; color:white;">Exportar Ahora</button>
             </div>
             {{ $message ?? '' }}
          </div>
      </div>
    </div>
    
</section>
</div>
@endsection
@push('scripts-custom')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://unpkg.com/vue@next"></script>
    
<script>
    const AttributeBinding = {
        mounted(){
        },
        data() {
            return {
                date1:'',
                date2:'',
            }
        },
        methods:{
            BuscarFecha(){
                  if(this.date1 == '') return swal('Siver Informa:','Fecha 1 esta vacia','warning');
                  if(this.date2 == '') return swal('Siver Informa:','Fecha 2 esta vacia','warning');
                  let urle='exportarListadoPicking/'+this.date1+'/'+this.date2;
                  window.open(urle);
                  swal('Siver Informa: ','He descargado para ti, un informe de listado con fecha de inici: '+this.date1+ ' hasta '+this.date2);
              }
        }
    }
        var example2=Vue.createApp(AttributeBinding).mount('#appvc')

    </script>
@endpush