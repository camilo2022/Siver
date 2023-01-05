@extends('layouts.appp')
@push('custom-css')

@endpush
@section('content')
<div id="appvc">
    <div class="container-fluid mt-2">
        <div class="card">
           <div class="card-header text-center" style="font-family:Century Gothic; background-color:#007bff; color:white; font-weigth:bold;">
              Filtros
            </div>
             <div class="card-body">
                 <div class="row">
                     <div class="col-sm-3"></div>
                     <div class="col-sm-3 col-md-4 col-12 col-xs-12">
                        Filtre por fecha para descontar
                     </div>
                     <div class="col-sm-3 col-md-4 col-12 col-xs-12">
                         <select class="form-control">
                             <option value='all'>Todos</option>
                         </select>
                     </div>
                     <div class="col-sm-3"></div>
                 </div>
                 <div class="row mt-2">
                     <div class="col-sm-3"></div>
                     <div class="col-sm-3 col-md-4 col-12 col-xs-12">
                        Seleccione un estado de la cuota
                     </div>
                     <div class="col-sm-3 col-md-4 col-12 col-xs-12">
                         <select class="form-control">
                             <option value='1'>PENDIENTE POR PAGO</option>
                             <option value='1'>PAGA</option>
                         </select>
                     </div>
                     <div class="col-sm-3"></div>
                 </div>
             </div>
        </div>
        <div class="card" style=" font-family:Century Gothic;">
            <div class="card-header text-center" style="font-family:Century Gothic; background-color:#007bff; color:white; font-weigth:bold;">
               Cuotas de libranza
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tablaOrdenes" class="table">
                        <thead>
                            <tr>
                              <th scope="col">Codigo Cuota</th>
                              <th scope="col">Documento</th>
                              <th scope="col">Empleado</th>
                              <th scope="col">Codigo Libranza</th>
                              <th scope="col">Cuota</th>
                              <th scope="col">Valor</th>
                              <th scope="col">Fecha para Descontar</th>
                              <th scope="col">Fecha Pago</th>
                              <th scope="col">Estado</th>
                            </tr>
                      </thead>
                        <tbody>
                            <tr>
                                <td>a</td>
                                <td>s</td>
                                <td>d</td>
                                <td>d</td>
                                <td>c</td>
                                <td>v</td>
                                <td>n</td>
                                <td>b</td>
                                <td>b</td>
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
    
<script>
 const AttributeBinding = {
        data() {
            return {
                fechaDescontar: '',
                estadoCuota: '',
            }
        },
        methods:{
            
        },
        mounted(){
           
        }
    }
        var example2=Vue.createApp(AttributeBinding).mount('#appvc')

</script>
@endpush