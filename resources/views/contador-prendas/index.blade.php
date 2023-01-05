@extends('layouts.appp')

@section('content')
<style>
   
</style>
    <div id="appvue" class="container-fluid mt-2 mb-2">
       <div class="card" style="border:1px solid black;">
           <div class="card-header" style="background-color:#0f0f0f; font-weight:bold; color:white; text-align:center;">
               Contador de prendas.
           </div>
           <div class="card-body" style="text-align:center;" v-if="displayDiv == true">
                <h3>Ingrese la referencia para hacer el conteo.</h3>
                <div class="row">
                    <div class="col-sm-8">
                        <input type="text" v-model="loteTransferencia" style="background-color:#0f0f0f; color:white; font-weigth:bold; font-size: 1.5em; text-align:center;" class="form-control">
                    </div>
                    <div class="col-sm-4">
                        <button class="btn btn-success w-100 p-3"  v-on:click="EmpezarModalReferencias()">EMPEZAR</button>
                    </div>
                </div>
           </div>
           <div class="card-body" v-if="displayDiv == false">
               <div class="card" style="border:1px solid black;">
                   <div class="card-header" style="background-color:#0f0f0f; font-weight:bold; color:white;">
                       Datos Informativos
                   </div>
                   <div class="card-body">
                       <div class="row">
                           <div class="col-lg-4 col-sm-4 p-2 mb-4" style=" margin-left:10px; font-size:1.5em; text-align:center; border-radius:10px;">
                                Referencia en Picking: <span  style="font-weight: bold;" v-html="loteTransferencia.toUpperCase()"></span>
                           </div>
                           <div class="col-lg-4 col-sm-4 p-2 mb-4" style="font-size:1.8em; margin-left:10px;  text-align:center; border-radius:10px;">
                               Faltantes  <span v-if="totalConteo != conteoCreado.total"  v-html="conteoCreado.total-totalConteo" ></span>
                           </div>
                           <div class="col-lg-2 col-sm-2 p-2 mb-4">
                               <a href="#"  v-on:click="enviarCompletado()" v-if="totalConteo == conteoCreado.total" class="btn btn-success">Presiona para enviar</a>
                           </div>
                       </div>
                       <br>
                       <br>
                       <div class="row">
                           <div class="col-sm p-2 text-center mb-2">
                               CONTEO <span style="background-color:#9cbdee; color:white; padding:20px; text-align:center !important; height:50px; font-size:1.5em; border-radius:20px;" class="m-2" v-html="totalConteo" ></span>
                           </div>
                           <div class="col-sm p-2 text-center mb-2">
                               SALDOS <span style="background-color:#9cbdee; color:white; padding:20px; text-align:center !important; height:50px; font-size:1.5em; border-radius:20px;" class="m-2" v-html="Totalsaldos" ></span>
                           </div>
                           <div class="col-sm p-2 text-center mb-2">
                              MARRAS  <span style="background-color:#9cbdee; color:white; padding:20px; text-align:center !important; height:50px; font-size:1.5em; border-radius:20px;" class="m-2" v-html="Totalmarras" ></span>
                           </div>
                       </div>
                       <br>
                       <br>
                   </div>
               </div>
               
           </div>
           
           <div class="card-body" style="text-align:center;" v-if="displayDiv == false">
               <br>
               <div class="container" style="width:50% !important; color:white; background-color:#0f0f0f; padding:20px;  margin-bottom:20px; font-size:2em;">
                  Ultima referencia pasada:
                  <br><span v-html="ultimaReferencia"></span>
               </div>
               <br>
               <div class="container">
                   <span style="font-size:1.5em;">INGRESE LA REFERENCIA</span>
                   <input type="text" id="texte2" class="form-control p-2" v-on:keyup.enter="changeText($event.target.value)"  style="border-color:black !important; font-size:2em; text-align:center;">
               </div>
               <br>
               <div class="table-responsive">
               <table class="table">
                   <thead>
                       <tr>
                           <th>T04</th>
                           <th>T06</th>
                           <th>T08</th>
                           <th>T10</th>
                           <th>T12</th>
                           <th>T14</th>
                           <th>T16</th>
                           <th>T18</th>
                           <th>T20</th>
                           <th>T22</th>
                           <th>T24</th>
                           <th>T26</th>
                           <th>T28</th>
                           <th>T30</th>
                           <th>T32</th>
                           <th>T34</th>
                           <th>T36</th>
                           <th>T38</th>
                           <th>CONTEO</th>
                           <th>CANTIDAD TOTAL</th>
                       </tr>
                   </thead>
                   <tbody>
                       <tr>
                           <td><span v-if="curvaConteo[0] == conteoCreado.t04" class="badge badge-success" v-html="conteoCreado.t04"></span><span v-if="curvaConteo[0] != conteoCreado.t04" class="badge badge-danger" v-html="conteoCreado.t04-curvaConteo[0]"></span></td>
                            <td><span v-if="curvaConteo[1] == conteoCreado.t06" class="badge badge-success" v-html="conteoCreado.t06"></span><span v-if="curvaConteo[1] != conteoCreado.t06" class="badge badge-danger" v-html="conteoCreado.t06-curvaConteo[1]"></span></td>
                            <td><span v-if="curvaConteo[2] == conteoCreado.t08" class="badge badge-success" v-html="conteoCreado.t08"></span><span v-if="curvaConteo[2] != conteoCreado.t08" class="badge badge-danger" v-html="conteoCreado.t08-curvaConteo[2]"></span></td>
                            <td><span v-if="curvaConteo[3] == conteoCreado.t10" class="badge badge-success" v-html="conteoCreado.t10"></span><span v-if="curvaConteo[3] != conteoCreado.t10" class="badge badge-danger" v-html="conteoCreado.t10-curvaConteo[3]"></span></td>
                            <td><span v-if="curvaConteo[4] == conteoCreado.t12" class="badge badge-success" v-html="conteoCreado.t12"></span><span v-if="curvaConteo[4] != conteoCreado.t12" class="badge badge-danger" v-html="conteoCreado.t12-curvaConteo[4]"></span></td>
                            <td><span v-if="curvaConteo[5] == conteoCreado.t14" class="badge badge-success" v-html="conteoCreado.t14"></span><span v-if="curvaConteo[5] != conteoCreado.t14" class="badge badge-danger" v-html="conteoCreado.t14-curvaConteo[5]"></span></td>
                            <td><span v-if="curvaConteo[6] == conteoCreado.t16" class="badge badge-success" v-html="conteoCreado.t16"></span><span v-if="curvaConteo[6] != conteoCreado.t16" class="badge badge-danger" v-html="conteoCreado.t16-curvaConteo[6]"></span></td>
                            <td><span v-if="curvaConteo[7] == conteoCreado.t18" class="badge badge-success" v-html="conteoCreado.t18"></span><span v-if="curvaConteo[7] != conteoCreado.t18" class="badge badge-danger" v-html="conteoCreado.t18-curvaConteo[7]"></span></td>
                            <td><span v-if="curvaConteo[8] == conteoCreado.t20" class="badge badge-success" v-html="conteoCreado.t20"></span><span v-if="curvaConteo[8] != conteoCreado.t20" class="badge badge-danger" v-html="conteoCreado.t20-curvaConteo[8]"></span></td>
                            <td><span v-if="curvaConteo[9] == conteoCreado.t22" class="badge badge-success" v-html="conteoCreado.t22"></span><span v-if="curvaConteo[9] != conteoCreado.t22" class="badge badge-danger" v-html="conteoCreado.t22-curvaConteo[9]"></span></td>
                            <td><span v-if="curvaConteo[10] == conteoCreado.t24" class="badge badge-success" v-html="conteoCreado.t24"></span><span v-if="curvaConteo[10] != conteoCreado.t24" class="badge badge-danger" v-html="conteoCreado.t24-curvaConteo[10]"></span></td>
                            <td><span v-if="curvaConteo[11] == conteoCreado.t26" class="badge badge-success" v-html="conteoCreado.t26"></span><span v-if="curvaConteo[11] != conteoCreado.t26" class="badge badge-danger" v-html="conteoCreado.t26-curvaConteo[11]"></span></td>
                            <td><span v-if="curvaConteo[12] == conteoCreado.t28" class="badge badge-success" v-html="conteoCreado.t28"></span><span v-if="curvaConteo[12] != conteoCreado.t28" class="badge badge-danger" v-html="conteoCreado.t28-curvaConteo[12]"></span></td>
                            <td><span v-if="curvaConteo[13] == conteoCreado.t30" class="badge badge-success" v-html="conteoCreado.t30"></span><span v-if="curvaConteo[13] != conteoCreado.t30" class="badge badge-danger" v-html="conteoCreado.t30-curvaConteo[13]"></span></td>
                            <td><span v-if="curvaConteo[14] == conteoCreado.t32" class="badge badge-success" v-html="conteoCreado.t32"></span><span v-if="curvaConteo[14] != conteoCreado.t32" class="badge badge-danger" v-html="conteoCreado.t32-curvaConteo[14]"></span></td>
                            <td><span v-if="curvaConteo[15] == conteoCreado.t34" class="badge badge-success" v-html="conteoCreado.t34"></span><span v-if="curvaConteo[15] != conteoCreado.t34" class="badge badge-danger" v-html="conteoCreado.t34-curvaConteo[15]"></span></td>
                            <td><span v-if="curvaConteo[16] == conteoCreado.t36" class="badge badge-success" v-html="conteoCreado.t36"></span><span v-if="curvaConteo[16] != conteoCreado.t36" class="badge badge-danger" v-html="conteoCreado.t36-curvaConteo[16]"></span></td>
                            <td><span v-if="curvaConteo[17] == conteoCreado.t38" class="badge badge-success" v-html="conteoCreado.t38"></span><span v-if="curvaConteo[17] != conteoCreado.t38" class="badge badge-danger" v-html="conteoCreado.t38-curvaConteo[17]"></span></td>
                            <td v-html="totalConteo"></td>
                            <td v-html="conteoCreado.total"></td>
                       </tr>
                   </tbody>
               </table>
               </div>
           </div>
       </div>
       
       <!-- The Modal -->
      <div class="modal fade" id="myModalTalla">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
          
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Informacion curva de referencia. </h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body" style="text-align:center; ">
               <div class="w-100" style="background-color:#0f0f0f; color:white;">
                   <span v-html="loteTransferencia" style="font-size:2em;  widt:1580px !important; font-weigth:bold; padding:20px;"></span>
               </div>
               <br>
              <div class="row">
                  <div class="col-sm-2" v-for="(talla,indice) in tallas">
                     <span v-html="talla.name"></span>
                      <input type="number" min='0' step="1" class="form-control" v-model="tallas[indice].cantidad" style="border:1px solid black;">
                  </div>
              </div>
            </div>
            
            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button v-on:click="submitEmpezar()" class="btn btn-success">Empezar Conteo</button>
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
              displayDiv:true,
              loteTransferencia:'',
              ultimaReferencia:'',
              Totalsaldos:0,
              Totalmarras:0,
              tallas:[
                {
                    'name' : 'T04',
                    'cantidad' : 0,
                }, 
                {
                    'name' : 'T06',
                    'cantidad' : 0,
                },
                {
                    'name' : 'T08',
                    'cantidad' : 0,
                },
                {
                    'name' : 'T10',
                    'cantidad' : 0,
                },
                {
                    'name' : 'T12',
                    'cantidad' : 0,
                },
                {
                    'name' : 'T14',
                    'cantidad' : 0,
                },
                {
                    'name' : 'T16',
                    'cantidad' : 0,
                },
                {
                    'name' : 'T18',
                    'cantidad' : 0,
                },
                {
                    'name' : 'T20',
                    'cantidad' : 0,
                },
                {
                    'name' : 'T22',
                    'cantidad' : 0,
                },
                {
                    'name' : 'T24',
                    'cantidad' : 0,
                },
                {
                    'name' : 'T26',
                    'cantidad' : 0,
                },
                {
                    'name' : 'T28',
                    'cantidad' : 0,
                },
                {
                    'name' : 'T30',
                    'cantidad' : 0,
                },
                {
                    'name' : 'T32',
                    'cantidad' : 0,
                },
                {
                    'name' : 'T34',
                    'cantidad' : 0,
                },
                {
                    'name' : 'T36',
                    'cantidad' : 0,
                },
                {
                    'name' : 'T38',
                    'cantidad' : 0,
                },
                
              ],
              conteoCreado: [],
              totalConteo:0,
              totalesConteo:[
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                  ],
              curvaConteo: [
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                ]
              
            }
        },
        methods:{
             changeText(value){
                 let valor=value;
                 if(valor.length == 5) return this.cargaPorSKU(valor);
                    if(valor.includes('-')){
                        valor = valor.split('-');
                        
                        let referencia = '';
                        if(valor.length > 3){
                            referencia = valor[0]+"-"+valor[1];
                            talla = valor[2];
                        }else if(valor.length > 1){
                            referencia=valor[0];
                            talla = valor[1];
                        }else{
                            referencia = valor
                        }
                        if(!(referencia == this.loteTransferencia.toUpperCase() || referencia.length == 5 ||  referencia == this.loteTransferencia.toLowerCase() || referencia == "S975" || referencia == "s975"|| referencia =="M975" || referencia == "m975")) return swal('La referencia digitada es diferente.');
                        
                        if(this.hayParaContar(talla)){
                            
                                if(!this.verificarCantidades()){
                                    let datie = {
                                    '_token' : document.querySelector('meta[name="csrf-token"]').content,
                                    'lecturaReferencia':value,
                                    'idconteo' : this.conteoCreado.id
                                };
                                
                                axios.post('../conteoprendas/pickingSave',datie)
                                      .then(response => {
                                           this.Totalsaldos = response.data.Totalsaldos;
                                            this.Totalmarras = response.data.Totalmarras;
                                       if(response.data.conteoObject.restante == response.data.conteoObject.total){
                                           this.totalConteo = 0;
                                       }else{
                                           this.totalConteo = response.data.conteoObject.total - response.data.conteoObject.restante;
                                       }      
                                       
                                       this.curvaConteo = response.data.conteo;
                                       this.conteoCreado = response.data.conteoObject;
                                });
                                 if(value!=''){
                                     this.ultimaReferencia=value
                                 }
                                 
                                }else{
                                    swal({
                                          title: 'Error', 
                                          text: 'Ya esta completo el conteo para esta talla.',
                                          confirmButtonText: 'OK'
                                      })
                                }
                                 this.ultimaReferencia=''
                                $('#texte2').val('');
                        }else{
                            swal({
                              title: 'Error', 
                              text: 'La talla en el codigo leido  no esta para contar.',
                              icon: 'danger',
                              confirmButtonText: 'OK'
                              })
                              this.ultimaReferencia=''
                              $('#texte2').val('');
                        }
                        
                    }else{
                        valor = valor.split("'");
                        let referencia = '';
                        if(valor.length > 3){
                            referencia = valor[0]+"'"+valor[1];
                            talla = valor[2];
                        }else{
                            referencia=valor[0];
                            talla = valor[1];
                        }
                        
                        if(!(referencia == this.loteTransferencia || referencia == this.loteTransferencia.toLowerCase() || referencia == "S975" || referencia == "s975"|| referencia=="M975" || referencia == "m975")) return swal('La referencia digitada es diferente.');
                        if(this.hayParaContar(talla)){
                                if(!this.verificarCantidades()){
                                    let datie = {
                                    '_token' : document.querySelector('meta[name="csrf-token"]').content,
                                    'lecturaReferencia':value,
                                    'idconteo' : this.conteoCreado.id
                                };
                                
                                axios.post('../conteoprendas/pickingSave',datie)
                                      .then(response => {
                                       if(response.data.conteoObject.restante == response.data.conteoObject.total){
                                           this.totalConteo = 0;
                                       }else{
                                           this.totalConteo = response.data.conteoObject.total - response.data.conteoObject.restante;
                                       }      
                                       this.curvaConteo = response.data.conteo;
                                       this.conteoCreado = response.data.conteoObject;
                                });
                                 if(value!=''){
                                     this.ultimaReferencia=value
                                 }
                                 $('#texte2').val('');
                                }else{
                                    swal({
                                          title: 'Error', 
                                          text: 'Ya esta completo el conteo para esta talla.',
                                          confirmButtonText: 'OK'
                                      })
                                     this.ultimaReferencia=''
                                     $('#texte2').val('');
                                }
                        }else{
                            swal({
                              title: 'Error', 
                              text: 'La talla en el codigo le¨ªdo  no esta para contar.',
                              icon: 'danger',
                              confirmButtonText: 'OK'
                              })
                               this.ultimaReferencia=''
                               $('#texte2').val('');
                        }
                         
                    }
             },
             cargaPorSKU(valor){
                let datie = {
                    '_token' : document.querySelector('meta[name="csrf-token"]').content,
                    'sku': valor
                };
                 axios.post('../conteoprendas/getInformacionSKU',datie)
                          .then(response => {
                                 swal({
                                  title: 'Transaccion exitosa', 
                                  text: response.data.message,
                                  icon: 'success',
                                  confirmButtonText: 'OK'
                                  })
                                  this.displayDiv=true
                                  this.loteTransferencia=''
                                  this.ultimaReferencia=''
                    });
                
             },
             enviarCompletado(){
                  let datie = {
                    '_token' : document.querySelector('meta[name="csrf-token"]').content,
                    'conteoid':this.conteoCreado.id
                };
                 axios.post('../conteoprendas/marcarCerrado',datie)
                          .then(response => {
                                 swal({
                                  title: 'Transaccion exitosa', 
                                  text: response.data.message,
                                  icon: 'success',
                                  confirmButtonText: 'OK'
                                  })
                                  this.displayDiv=true
                                  this.loteTransferencia=''
                                  this.ultimaReferencia=''
                    });
             },
             verificarCantidades(){
                 if(talla == '04' || talla == '4'){
                    if(this.conteoCreado.t04 == this.curvaConteo[0]) return true; 
                 }else if(talla == '06' || talla == '6'){
                    if(this.conteoCreado.t06 == this.curvaConteo[1]) return true; 
                 }else if(talla == '08' || talla == '8'){
                    if(this.conteoCreado.t08 == this.curvaConteo[2]) return true; 
                 }else if(talla == '10'){
                    if(this.conteoCreado.t10 == this.curvaConteo[3]) return true; 
                 }else if(talla == '12'){
                    if(this.conteoCreado.t12 == this.curvaConteo[4]) return true; 
                 }else if(talla == '14'){
                    if(this.conteoCreado.t14 == this.curvaConteo[5]) return true; 
                 }else if(talla == '16'){
                    if(this.conteoCreado.t16 == this.curvaConteo[6]) return true; 
                 }else if(talla == '18'){
                    if(this.conteoCreado.t18 == this.curvaConteo[7]) return true; 
                 }else if(talla == '20'){
                    if(this.conteoCreado.t20 == this.curvaConteo[8]) return true; 
                 }else if(talla == '22'){
                    if(this.conteoCreado.t22 == this.curvaConteo[9]) return true; 
                 }else if(talla == '24'){
                    if(this.conteoCreado.t24 == this.curvaConteo[10]) return true; 
                 }else if(talla == '26'){
                    if(this.conteoCreado.t26 == this.curvaConteo[11]) return true; 
                 }else if(talla == '28'){
                    if(this.conteoCreado.t28 == this.curvaConteo[12]) return true; 
                 }else if(talla == '30'){
                    if(this.conteoCreado.t30 == this.curvaConteo[13]) return true; 
                 }else if(talla == '32'){
                    if(this.conteoCreado.t32 == this.curvaConteo[14]) return true; 
                 }else if(talla == '34'){
                    if(this.conteoCreado.t34 == this.curvaConteo[15]) return true; 
                 }else if(talla == '36'){
                    if(this.conteoCreado.t36 == this.curvaConteo[16]) return true; 
                 }else if(talla == '38'){
                    if(this.conteoCreado.t38 == this.curvaConteo[17]) return true; 
                 }
                 return false;
             },
             hayParaContar(talla){
                 if(talla == '04' || talla == '4'){
                    if(this.conteoCreado.t04 > 0) return true; 
                 }else if(talla == '06' || talla == '6'){
                    if(this.conteoCreado.t06 > 0) return true; 
                 }else if(talla == '08' || talla == '8'){
                    if(this.conteoCreado.t08 > 0) return true; 
                 }else if(talla == '10'){
                    if(this.conteoCreado.t10 > 0) return true; 
                 }else if(talla == '12'){
                    if(this.conteoCreado.t12 > 0) return true; 
                 }else if(talla == '14'){
                    if(this.conteoCreado.t14 > 0) return true; 
                 }else if(talla == '16'){
                    if(this.conteoCreado.t16 > 0) return true; 
                 }else if(talla == '18'){
                    if(this.conteoCreado.t18 > 0) return true; 
                 }else if(talla == '20'){
                    if(this.conteoCreado.t20 > 0) return true; 
                 }else if(talla == '22'){
                    if(this.conteoCreado.t22 > 0) return true; 
                 }else if(talla == '24'){
                    if(this.conteoCreado.t24 > 0) return true; 
                 }else if(talla == '26'){
                    if(this.conteoCreado.t26 > 0) return true; 
                 }else if(talla == '28'){
                    if(this.conteoCreado.t28 > 0) return true; 
                 }else if(talla == '30'){
                    if(this.conteoCreado.t30 > 0) return true; 
                 }else if(talla == '32'){
                    if(this.conteoCreado.t32 > 0) return true; 
                 }else if(talla == '34'){
                    if(this.conteoCreado.t34 > 0) return true; 
                 }else if(talla == '36'){
                    if(this.conteoCreado.t36 > 0) return true; 
                 }else if(talla == '38'){
                    if(this.conteoCreado.t38 > 0) return true; 
                 }
                 return false;
             },
            EmpezarModalReferencias(){
                if(this.loteTransferencia != ''){
                    if(this.loteTransferencia.includes('-')){
                        let array = this.loteTransferencia.split("-");
                        if(array.length > 3 ){
                            this.loteTransferencia=array[0]+"-"+array[1];
                        }else{
                            this.loteTransferencia=array[0];
                        }
                    }else{
                       let array = this.loteTransferencia.split("'");
                        if(array.length > 3 ){
                            this.loteTransferencia=array[0]+"'"+array[1];
                        }else{
                            this.loteTransferencia=array[0];
                        } 
                    }
                    
                   $('#myModalTalla').modal('show');
                }else return swal("No ha sido ingresada ninguna referencia. Verifique.")
            },
            submitEmpezar(){
                if(!this.estanEnCero()){
                    swal('Todo el tallaje de la curva esta vacio, adicione por lo  menos una talla para continuar.');
                }else{
                    this.algunCampoSinDigitar();
                    this.mandaInformacionPickear();
                }
            },
            mandaInformacionPickear(){
                let datie = {
                    '_token' : document.querySelector('meta[name="csrf-token"]').content,
                    'referencia':this.loteTransferencia,
                    'curva' : this.tallas
                };
             axios.post('/conteoprendas',datie)
                      .then(response => {
                         if(response.data.message == 'Se ha cargado la curva de  la referencia, comienza a pickear'){
                             swal({
                              title: 'Creacion exitosa', 
                              text: response.data.message,
                              icon: 'success',
                              confirmButtonText: 'OK'
                              })
                             $('#myModalTalla').modal('hide');
                             this.displayDiv=false
                             this.conteoCreado = response.data.conteoCreate
                         }
                });
            
            },
            algunCampoSinDigitar(){
                let suma = 0;
                for(let i=0;i<this.tallas.length;i++){
                    if(this.tallas[i] == '' || this.tallas[i] == ' '){
                        this.tallas[i] = 0;
                    }
                }
            },
            estanEnCero(){
                let suma = 0;
                this.tallas.forEach(element => suma += element.cantidad);
                return suma >0  ? true:false;
            },
        }
    }
        var example2=Vue.createApp(AttributeBinding).mount('#appvue')

    </script>
@endpush