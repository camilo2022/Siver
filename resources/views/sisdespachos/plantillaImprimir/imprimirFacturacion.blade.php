<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proceso Facturación.</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <style>

     @page contenedor-rotulo{
         size:8.27in 11.69in;
         margin:.5in .5in .5in .5in;
         mso-header-margin:.5in;
         mso-footer-margin:.5in;
         mso-paper-source:0;
        }
     div.contenedor-rotulo {
         page:Section1;
         
         margin:22px;
        }
       
    .tablecurva {
      width: 100%;
      table-layout: fixed;
      width: 100%;
      border-collapse: collapse;
        font-family: Courier, "Lucida Console", monospace !important;
    }
    .tablecurva>td{
        
    }
    .tablecurva>thead{
        width: 100%;
        background-color:#0079fc;
        color:white;
    }
    .tablecurva>thead th:nth-child(1) {
      width: 7%;
    }
    
    .tablecurva>thead th:nth-child(2) {
      width: 10%;
    }
    .tablecurva>thead th:nth-child(3) {
      width: 7%;
    }
    
    .totales{
        background-color:#0079fc;
        color:white;
    }
    
    textarea{
        border:none;
    }

    body{
        background-color: white !important;
    } 
    </style>
</head>
<body>
    <div class="contenedor-rotulo">
        <div class="contenedor-general">
            <div class="contenido1">
                <table class="table table-bordered">
                   <tbody>
                    @php
                    $actual = 0;
                    $totalCajas = 0;
                    $totalBolsas = 0;
                    $bolsaActual = 0;
                    $cajaActual = 0;
                    foreach ($empaques as $empaque) {
                        if($empaque->tipo_empaque == 1){
                            $totalCajas++;
                        }else{
                            $totalBolsas++;
                        }
                    }
                @endphp
                      @foreach ($empaques as $empaque)
                      @php
                      if($empaque->tipo_empaque == 1){
                        $cajaActual++;
                      }else{
                        $bolsaActual++;
                      }
                          $actual ++;
                          
                      @endphp
                      <tr>
                          <td style="width:27%;" class="text-center" rowspan="3">
                            @if($orden->identificador == 'CR')
                              <img style="width:230px;" src="{{asset('img/california.jpeg')}}">
                                @else
                                <img style="width:230px;" src="{{asset('img/bless.jpeg')}}">
                              @endif
                            </td>
                          <td style="width: 6%;"><b>FECHA:</b></td>
                          <td class="text-center" colspan="3">{{date('d-m-Y h:i A')}} </td>
                          <td rowspan="3" colspan="2" class="text-center">
                              <div class="title m-b-md">
                                  {!!QrCode::size(250)->generate(''.$empaque->id) !!}
                               </div>
                          </td>
                     </tr>
                     <tr>
                         <td><b>FACTURA:</b></td>
                         <td class="text-center" colspan="3">{{$orden->facturas}}</td>
                     </tr>
                    @if($empaque->tipo_empaque == 1)
                     <tr>
                         <td><b>CAJA</b></td>
                         <td>{{$cajaActual}}</td>
                         <td><b>DE</b></td>
                         <td>{{$totalCajas}}</td>
                     </tr>
                     @else
                     <tr>
                        <td><b>BOLSA</b></td>
                        <td>{{$bolsaActual}}</td>
                        <td><b>DE</b></td>
                        <td>{{$totalBolsas}}</td>
                    </tr>
                     @endif
                     <tr>
                         <td><b>DESTINATARIO</b></td>
                         <td style="width:35%;">{{$orden->cliente}}</td>
                         <td><b>NIT</b></td>
                         <td colspan="1">{{$orden->nit}}</td>
                         <td><b>FACTURADOR: </b></td>
                         <td colspan="2">{{$encargadoFacturacion}}</td>
                     </tr>
                     <tr>
                          <td><b>DIRECCIÓN</b></td>
                          <td style="width:35%;">{{$orden->direccion}}</td>
                          <td><b>PRENDAS</b></td>
                          <td colspan="1">{{$empaque->cantidad}}</td>
                          <td><b>PESO</b></td>
                          <td>{{$empaque->peso}}</td>
                          
                     </tr>
                     <tr>
                          <td><b>DEPARTAMENTO</b></td>
                          <td style="width:35%;">{{$departamento}}</td>
                          <td><b>CIUDAD</b></td>
                          <td colspan="1">{{$orden->ciudad}}</td>
                          <td><b>DESPACHO</b></td>
                          <td>{{$ordenEmpacado->id}}</td>
                      </tr>
                     
                     <tr>
                         <td colspan="1"><b>ALISTÓ</b></td>
                         <td style="width: 13px;">{{$ordenAlistamiento->user_id_alista}}</td>
                         <td style="width: 12%;"><b>EMPACÓ</b></td>
                         <td style="width: 13%;">{{$ordenEmpacado->user_id_alista}}</td>
                         <td><b>REVISO</b></td>
                         <td colspan="2">{{$encargadoRevision}}</td>
                         
                     </tr>
                     @if($orden->identificador == "NA")
                     <tr>
                          <td colspan="9" class="text-center"><b>EN CASO DE PÉRDIDA PORFAVOR COMUNICARSE AL NUMERO 3152820926</b></td>
                      </tr>
                      <tr>
                          <td colspan="9" class="text-center">BLESS MANUFACTURING INDUSTRY S.A.S </td>
                      </tr>
                      @endif
                     <tr>
                          <td style=""colspan="9" rowspan="1" >
                              <div class="mx-auto my-0" style="width: 32em;" id="dian" >
                              
                        </div>
                          </td> 
                      </tr>
                     
                     @if($orden->identificador == "NA")
                     <tr style="height:20px"></tr>
                     @else
                     <tr style="height:70px"></tr>
                     @endif 
                      @endforeach
                      
                   </tbody>
                    
                </table>
                <br>
                <table>
                    <tbody>
                        <tr>
                            <td>
                                <div class="container-fluid">
                                    <div class="row" style="padding-left: 15px;">
                                        <div class="col-md-4">
                                            <p>
                                                <b>NIT: </b> {{$orden->nit}}
                                                <br> <b>DIRECCIÓN: </b> {{$orden->direccion}}
                                                <br> <b>CIUDAD:</b> {{$orden->ciudad}}
                                                <br><b>CLIENTE: </b> {{$orden->cliente}}
                            
                                            </p>
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <label><b>Fecha: </b>{{$orden->created_at}}</label>
                                            <br>
                                            @if($orden->identificador == 'CR')
                                            <img style="width:230px;" src="{{asset('img/california.jpeg')}}">
                                              @else
                                              <img style="width:230px;" src="{{asset('img/bless.jpeg')}}">
                                            @endif
                                        </div>
                                        <div class="col-md-4 p-5 text-center">
                                            <div  class="w-100" style="color:white; background-color: #0079fc; padding:10px">
                                                <p><h4>ORDEN Nº</h4>
                                                    <h1>{{$consecutivo}}</h1></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="container-fluid">
                                        <table class="tablecurva">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%;">Pedido</th>
                                                    <th>Vendedor</th>
                                                    <th>REF</th>
                                                    <th>T4</th>
                                                    <th>T6</th>
                                                    <th>T8</th>
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
                                                    <th>S</th>
                                                    <th>M</th>
                                                    <th>L</th>
                                                    <th>XL</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $t4=0;$t6=0;$t8=0;$t10=0;$t12=0;$t14=0;
                                                $t16=0;$t18=0;$t20=0;$t22=0;$t24=0;$t26=0;
                                                $t28=0;$t30=0;$t32=0;$t34=0;$t36=0;$t38=0;$ts=0;
                                                $tm=0;$tl=0;$txl=0; $total=0;
                                            @endphp
                                            @foreach($detalles  as $detalle)
                                            @php
                                                $t4 += $detalle->t4;
                                                $t6 += $detalle->t6;
                                                $t8 += $detalle->t8;
                                                $t10 += $detalle->t10;
                                                $t12 += $detalle->t12;
                                                $t14 += $detalle->t14;
                                                $t16 += $detalle->t16;
                                                $t18 += $detalle->t18;
                                                $t20 += $detalle->t20;
                                                $t22 += $detalle->t22;
                                                $t24 += $detalle->t24;
                                                $t26 += $detalle->t26;
                                                $t28 += $detalle->t28;
                                                $t30 += $detalle->t30;
                                                $t32 += $detalle->t32;
                                                $t34 += $detalle->t34;
                                                $t36 += $detalle->t36;
                                                $t38 += $detalle->t38;
                                                $ts += $detalle->s;
                                                $tm += $detalle->m;
                                                $tl += $detalle->l;
                                                $txl += $detalle->xl;
                                                $total += $detalle->total;
                
                                            @endphp
                                            <tr>
                                                <td>{{$detalle->pedido_id}}</td>
                                                <td>{{$detalle->vendedor}}</td>
                                                <td>{{$detalle->referencia}}</td>
                                                <td>{{$detalle->t4}}</td>
                                                <td>{{$detalle->t6}}</td>
                                                <td>{{$detalle->t8}}</td>
                                                <td>{{$detalle->t10}}</td>
                                                <td>{{$detalle->t12}}</td>
                                                <td>{{$detalle->t14}}</td>
                                                <td>{{$detalle->t16}}</td>
                                                <td>{{$detalle->t18}}</td>
                                                <td>{{$detalle->t20}}</td>
                                                <td>{{$detalle->t22}}</td>
                                                <td>{{$detalle->t24}}</td>
                                                <td>{{$detalle->t26}}</td>
                                                <td>{{$detalle->t28}}</td>
                                                <td>{{$detalle->t30}}</td>
                                                <td>{{$detalle->t32}}</td>
                                                <td>{{$detalle->t34}}</td>
                                                <td>{{$detalle->t36}}</td>
                                                <td>{{$detalle->t38}}</td>
                                                <td>{{$detalle->s}}</td>
                                                <td>{{$detalle->m}}</td>
                                                <td>{{$detalle->l}}</td>
                                                <td>{{$detalle->xl}}</td>
                                                <td><b>{{$detalle->total}}</b></td>
                                            </tr>
                                            @endforeach
                                            
                                            </tbody>
                                            <tfoot>
                                                <tr class="totales">
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td><b>{{$t4}}</b></td>
                                                    <td><b>{{$t6}}</b></td>
                                                    <td><b>{{$t8}}</b></td>
                                                    <td><b>{{$t10}}</b></td>
                                                    <td><b>{{$t12}}</b></td>
                                                    <td><b>{{$t14}}</b></td>
                                                    <td><b>{{$t16}}</b></td>
                                                    <td><b>{{$t18}}</b></td>
                                                    <td><b>{{$t20}}</b></td>
                                                    <td><b>{{$t22}}</b></td>
                                                    <td><b>{{$t24}}</b></td>
                                                    <td><b>{{$t26}}</b></td>
                                                    <td><b>{{$t28}}</b></td>
                                                    <td><b>{{$t30}}</b></td>
                                                    <td><b>{{$t32}}</b></td>
                                                    <td><b>{{$t34}}</b></td>
                                                    <td><b>{{$t36}}</b></td>
                                                    <td><b>{{$t38}}</b></td>
                                                    <td><b>{{$ts}}</b></td>
                                                    <td><b>{{$tm}}</b></td>
                                                    <td><b>{{$tl}}</b></td>
                                                    <td><b>{{$txl}}</b></td>
                                                    <td><b>{{$total}}</b></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br>
                @php
                    $actual = 0;
                    $totalCajas = 0;
                    $totalBolsas = 0;
                    $bolsaActual = 0;
                    $cajaActual = 0;
                    foreach ($empaques as $empaque) {
                        if($empaque->tipo_empaque == 1){
                            $totalCajas++;
                        }else{
                            $totalBolsas++;
                        }
                    }
                @endphp
                @foreach ($empaques as $empaque)
                @php
                      if($empaque->tipo_empaque == 1){
                        $cajaActual++;
                      }else{
                        $bolsaActual++;
                      }
                          $actual ++;
                          
                      @endphp
                <table>
                    <tbody>
                        
                        <tr>
                            <td>
                                <div class="container-fluid">
                                    <div class="card">
                                        <div class="card-header" style="background-color:#0079fc !important;
                                        color:white;">
                                    @if($empaque->tipo_empaque == 1)
                                    <center><b><h2>CONTENIDO DE CAJA {{$cajaActual}} de {{$totalCajas}}</h2></b></center>
                                    @else
                                    <center><b><h2>CONTENIDO DE BOLSA {{$bolsaActual}} de {{$totalBolsas}}</h2></b></center>
                                    @endif
                                          </div>
                                        <div class="card-body">
                                            <table class="tablecurva">
                                                <thead>
                                                    <tr>
                                                        <th style="width:7%;">ID.A</th>
                                                        <th style="width:7%;">REF</th>
                                                        <th style="width:3%;">T4</th>
                                                        <th style="width:3%;">T6</th>
                                                        <th style="width:3%;">T8</th>
                                                        <th style="width:3%;">T10</th>
                                                        <th style="width:3%;">T12</th>
                                                        <th style="width:3%;">T14</th>
                                                        <th style="width:3%;">T16</th>
                                                        <th style="width:3%;">T18</th>
                                                        <th style="width:3%;">T20</th>
                                                        <th style="width:3%;">T22</th>
                                                        <th style="width:3%;">T24</th>
                                                        <th style="width:3%;">T26</th>
                                                        <th style="width:3%;">T28</th>
                                                        <th style="width:3%;">T30</th>
                                                        <th style="width:3%;">T32</th>
                                                        <th style="width:3%;">T34</th>
                                                        <th style="width:3%;">T36</th>
                                                        <th style="width:3%;">T38</th>
                                                        <th style="width:3%;">S</th>
                                                        <th style="width:3%;">M</th>
                                                        <th style="width:3%;">L</th>
                                                        <th style="width:3%;">XL</th>
                                                        <th style="width:12%;">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody> 
                                                    @php
                                                         $empaquesE = App\Models\Despachos\DetallesEmpaque::where('empaque_id','=',$empaque->id)->get();
                                                    @endphp
                                                    @foreach ($empaquesE as  $detalleEmpaque)
                                                        <tr>
                                                            <td>{{$detalleEmpaque->id_amarrador}}</td>
                                                            <td>{{$detalleEmpaque->referencia}}</td>
                                                            <td>{{$detalleEmpaque->t4}}</td>
                                                            <td>{{$detalleEmpaque->t6}}</td>
                                                            <td>{{$detalleEmpaque->t8}}</td>
                                                            <td>{{$detalleEmpaque->t10}}</td>
                                                            <td>{{$detalleEmpaque->t12}}</td>
                                                            <td>{{$detalleEmpaque->t14}}</td>
                                                            <td>{{$detalleEmpaque->t16}}</td>
                                                            <td>{{$detalleEmpaque->t18}}</td>
                                                            <td>{{$detalleEmpaque->t20}}</td>
                                                            <td>{{$detalleEmpaque->t22}}</td>
                                                            <td>{{$detalleEmpaque->t24}}</td>
                                                            <td>{{$detalleEmpaque->t26}}</td>
                                                            <td>{{$detalleEmpaque->t28}}</td>
                                                            <td>{{$detalleEmpaque->t30}}</td>
                                                            <td>{{$detalleEmpaque->t32}}</td>
                                                            <td>{{$detalleEmpaque->t34}}</td>
                                                            <td>{{$detalleEmpaque->t36}}</td>
                                                            <td>{{$detalleEmpaque->t38}}</td>
                                                            <td>{{$detalleEmpaque->s}}</td>
                                                            <td>{{$detalleEmpaque->m}}</td>
                                                            <td>{{$detalleEmpaque->l}}</td>
                                                            <td>{{$detalleEmpaque->xl}}</td>
                                                            <td>{{$detalleEmpaque->total}}</td>
                                                        </tr>
                                                    @endforeach
                                                   
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br>
                @endforeach
            </div>
            
        </div>
    </div>
</body>
</html>