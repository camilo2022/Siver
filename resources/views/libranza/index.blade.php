@extends('layouts.appp')
@push('custom-css')

@endpush
@section('content')
<div id="appvc">
    <div class="container-fluid mt-2">
        <div class="card" style=" font-family:Century Gothic;">
            <div class="card-header text-center" style="font-family:Century Gothic; background-color:#007bff; color:white; font-weigth:bold;">
                LIBRANZAS DE LA TIENDA
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tablaOrdenes" style="width:105%;" class="table table-striped">
                        <thead>
                            
                            <tr>
                              <th scope="col">Consecutivo #</th>
                              <th scope="col">Fecha</th>
                              <th scope="col">CC</th>
                              <th scope="col">Empleado</th>
                              <th scope="col">Empresa</th>
                              <th scope="col">Factura</th>
                              <th scope="col">Cuotas</th>
                              <th scope="col">Monto</th>
                              <th scope="col">Estado</th>
                              <th scope="col">Acciones</th>
                            </tr>
                      </thead>
                        <tbody>
                            <tr v-for="libranza in libranzas">
                                <td v-html="libranza.id"></td>
                                <td v-html="libranza.created_at">23/02/2021</td>
                                <td v-html="libranza.cedula"></td>
                                <td v-html="libranza.cliente"></td>
                                <td v-if="libranza.empresa != 4">Org. Bless</td>
                                <td v-if="libranza.empresa == 4">Bless Manufacturing</td>
                                <td v-html="libranza.numfactura">FEV-54</td>
                                <th v-html="libranza.cuotas"></th>
                                <td v-html="libranza.valormonto" style="font-weight: bold;"></td>
                                <td v-if="libranza.estado==1"><span class="badge badge-info">Enviado</span></td>
                                <td v-if="libranza.estado==2"><span class="badge badge-success">Firmado</span></td>
                                <td v-if="libranza.estado==3"><span class="badge badge-danger">Cancelado</span></td>
                                <td v-if="libranza.estado==4"><span class="badge badge-warning">Reenviado</span></td>
                                <td v-if="libranza.estado==5"><span class="badge badge-success">PAGADO</span></td>
                                <td v-if="libranza.estado==6"><span class="badge badge-warning">Realizando PAGOS</span></td>
                                <td v-if="libranza.estado==1"><button v-on:click="cancelarCodigo(libranza.id)" class="btn btn-xs btn-danger ">Cancelar</button></td>
                                <td v-if="libranza.estado!=1"></td>
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
<script src="https://unpkg.com/axios@0.27.2/dist/axios.min.js"></script>
<script src="https://unpkg.com/vue@next"></script>
<script src="assets/js/plugin/datatables/datatables.min.js"></script>    
    
<script>
    const AttributeBinding = {
        mounted(){},
        data() {
            return {
                libranzas:[]
            }
        },
        methods:{
            getLibranzas(){
                axios.get('getLibranzasTienda')
                .then(response => {
                    this.libranzas = response.data.info;
                    
                    var i=0;
                    for(i;i<this.libranzas.length;i++){
                        this.libranzas[i].valormonto="$"+new Intl.NumberFormat().format(this.libranzas[i].valormonto);
                        var date = new Date(this.libranzas[i].created_at);
                        var result = (date.getDate() > 9 ? '' : '0') + date.getDate()+ "/" + (date.getMonth() + 1)+"/"+date.getFullYear() + ((date.getMonth() + 1) > 9 ? '' : '0');
                        this.libranzas[i].created_at = result;
                    }
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
            cancelPOST(id){
                const form_data = new FormData();
                form_data.append('codigo', id);
                axios.post('cancelarCodigo',form_data)
                .then(response => {
                    this.getLibranzas();
                    swal("Se ha cancelado correctamente el codigo de firma de libranza.", {
                        icon: "success",
                    });
                });
            },
            cancelarCodigo(id){
               swal({
                      title: "¿Esta seguro que desea cancelar? ",
                      text: "Una vez cancelado el codigo no se podra usar y deveras volver a hacer proceso.",
                      icon: "warning",
                      buttons: true,
                      dangerMode: true,
                    })
                    .then((willDelete) => {
                      if (willDelete) {
                        this.cancelPOST(id);
                      }
                    });
            }
            
        },
        mounted(){
            this.getLibranzas();
        }
    }
        var example2=Vue.createApp(AttributeBinding).mount('#appvc')

    </script>
@endpush