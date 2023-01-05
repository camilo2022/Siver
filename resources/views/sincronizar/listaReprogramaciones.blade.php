@extends('layouts.appp')
@push('custom-css')

@endpush
@section('content')
<div id="appvc">
    <div class="container-fluid mt-2">
        <div class="card" style=" font-family:Century Gothic;">
            <div class="card-header text-center" style="font-family:Century Gothic; background-color:#007bff; color:white; font-weigth:bold;">
                Listado de Reprogramaciones
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tablaOrdenes" style="width:105%;">
                        <thead>
                            <tr>
                              <th scope="col">Reprogramacion</th>
                              <th scope="col">Categoria</th>
                              <th scope="col">Descripcion</th>
                              <th scope="col">Mes</th>
                              <th scope="col">UND - MES</th>
                              <th scope="col">UND - REF</th>
                              <th scope="col"># REF</th>
                              <th scope="col">Enviadas</th>
                              <th scope="col">Estado</th>
                              <th scope="col">Acciones</th>
                            </tr>
                      </thead>
                        <tbody>
                            <tr v-for="repro in reprogramaciones">
                                <td v-html="repro.reprogramacion"></td>
                                <td v-html="repro.categoria"></td>
                                <td v-html="repro.descripcionref"></td>
                                <td v-if="repro.mes == 1">ENERO</td>
                                <td v-if="repro.mes == 2">FEBRERO</td>
                                <td v-if="repro.mes == 3">MARZO</td>
                                <td v-if="repro.mes == 4">ABRIL</td>
                                <td v-if="repro.mes == 5">MAYOO</td>
                                <td v-if="repro.mes == 6">JUNIO</td>
                                <td v-if="repro.mes == 7">JULIO</td>
                                <td v-if="repro.mes == 8">AGOSTO</td>
                                <td v-if="repro.mes == 9">SEPTIEMBRE</td>
                                <td v-if="repro.mes == 10">OCTUBRE</td>
                                <td v-if="repro.mes == 11">NOVIEMBRE</td>
                                <td v-if="repro.mes == 12">DICIEMBRE</td>
                                <td v-html="repro.undxmes"></td>
                                <td v-html="repro.undxref"></td>
                                <td v-html="repro.nref"></td>
                                <td>0</td>
                                <td>En Espera</td>
                                <td><button v-on:click="viewReprogramacion(repro.id)" class="btn btn-xs btn-info"> <i class="fas fa-eye"></i></button> <button class="btn btn-xs btn-success"><i class="far fa-paper-plane"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts-custom')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://unpkg.com/vue@next"></script>
<script src="assets/js/plugin/datatables/datatables.min.js"></script>    
    
<script>
    const AttributeBinding = {
        mounted(){},
        data() {
            return {
                reprogramaciones:[]
            }
        },
        methods:{
            getLibranzas(){
                axios.get('getListadoReprogramaciones')
                .then(response => {
                    this.reprogramaciones = response.data.data;
                    $('#tablaOrdenes').DataTable().destroy();
                    this.initDatatable();
                })
            },
            initDatatable(){
                this.$nextTick(() => {
                    $('#tablaOrdenes').DataTable().destroy();
                    $('#tablaOrdenes').DataTable({
                        "dom": 'T<"clear">lfrtip',
                    });
                });
              },
              viewReprogramacion(id){
                  alert('ver reprogramacion id: '+id);
              }
        },
        mounted(){
            this.getLibranzas();
        }
    }
        var example2=Vue.createApp(AttributeBinding).mount('#appvc')

    </script>
@endpush