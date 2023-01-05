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
                  <h2 class="text-white fw-bold">Lector de QR Ágil SISDESPACHOS</h2>
                  <h5 class="text-white">Ey {{Auth()->user()->names.' '.Auth()->user()->apellidos}} <b>{{Auth()->user()->rol->descripcion}}</b> lee porfavor el codigo Qr que se encuentra en la orden de despacho para realizar el despacho de la caja/empaque en el sistema.!
                  </h5>
                </div>
              </div>
            </div>
          </div>
          <div class="panel panel-body page-inner mt--5">
          <div class="card full-height">
              <div class="card-body">
                 <input id="txtQr" style="border: 1px solid #0095ff ;" @change="changeText($event.target.value)" type="text" class="form-control">
                 
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
                    
                }
            },
            methods:{
                changeText(value){
                   $('#txtQr').val('');
                     let data ={idEmpacado: value, '_token': document.querySelector('meta[name="csrf-token"]').content};
                    axios.post('marcarDespacho',data)
                    .then(res => {
                        if(res.data.codigo == 1){
                          swal(res.data.message);
                        }else{
                            let empaque=res.data.empaque;
                            let ordendespacho=res.data.ordenDespacho;
                            let empacado=res.data.empacado;
                            var form = document.createElement("div");
                            form.innerHTML = 'La caja ID ha sido despachada, <b>'+empaque.id+'</b> del empacado ID <b>'+empacado.id+'</b> de la orden de despacho: <br><b>Consecutivo: </b> '+ordendespacho.consecutivo+' <br><b>Cliente: </b> '+ordendespacho.cliente+'<br><b>EMPAQUE '+res.data.pos+'</b> de <b>'+res.data.total+'</b>';
                            swal({
                                    title: 'Informaci��n del sistema:',
                                    content: form,
                                  }).then((value) => {
                                    console.log(value);
                                  });
        
                        }
                    }) 
                    
                }
            }
        }
        var example2=Vue.createApp(AttributeBinding).mount('#appvue')

    </script>
@endpush