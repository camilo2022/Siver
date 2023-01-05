@extends('layouts.appp')
@push('custom-css')
<style>
        /* spacing */

    table {
      table-layout: fixed;
      width: 100%;
      border-collapse: collapse;
    }
    td{
        font-family: Courier, "Lucida Console", monospace !important;
    }
    thead{
        background-color:#0079fc;
        color:white;
    }
    thead th:nth-child(1) {
      width: 7%;
    }
    
    thead th:nth-child(2) {
      width: 7%;
    }
    
    thead th:nth-child(3) {
      width: 7%;
    }
    
    .totales{
        background-color:#0079fc;
        color:white;
    }
    
    textarea{
        border:none;
    }

    .btn-flotante2{
        font-size: 16px; /* Cambiar el tamaño de la tipografia */
        text-transform: uppercase; /* Texto en mayusculas */
        font-weight: bold; /* Fuente en negrita o bold */
        color: #ffffff; /* Color del texto */
        border-radius: 5px; /* Borde del boton */
        letter-spacing: 2px; /* Espacio entre letras */
        background-color: #ace91e; /* Color de fondo */
        position: fixed;
        bottom: 161px;
        right: 44px;
        cursor:pointer;
        transition: all 300ms ease 0ms;
        box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
        z-index: 79;
    }
    .btn-flotante:hover {
        background-color: #2c2fa5; /* Color de fondo al pasar el cursor */
        box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.3);
        transform: translateY(-7px);
    }

    .btn-flotante {
	font-size: 16px; /* Cambiar el tamaño de la tipografia */
	text-transform: uppercase; /* Texto en mayusculas */
	font-weight: bold; /* Fuente en negrita o bold */
	color: #ffffff; /* Color del texto */
	border-radius: 5px; /* Borde del boton */
	letter-spacing: 2px; /* Espacio entre letras */
	background-color: #E91E63; /* Color de fondo */
	position: fixed;
	bottom: 127px;
	cursor:pointer;
    right: 44px;
	transition: all 300ms ease 0ms;
	box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
	z-index: 99;
}
.btn-flotante:hover {
	background-color: #2c2fa5; /* Color de fondo al pasar el cursor */
	box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.3);
	transform: translateY(-7px);
}
@media only screen and (max-width: 600px) {
 	.btn-flotante {
		font-size: 14px;
		padding: 12px 20px;
		bottom: 20px;
		right: 20px;
	}
} 
    body{
        background-color: white !important;
    }
</style>
@endpush
@section('content')
<div id="apper">
    <a class="btn btn-info m-2" href="../../list">Volver</a>
    <div class="container-fluid" id="areaImprimir">
        @if(isset($cajas))
        <!--Details Cajas-->
        <div class="card" id="areaImprimirDetailsCajas" hidden>
            <div class="card-header" style="background-color:#008cff !important; color:white;">
                <center><h3><b>Relacion de Cajas del Empacado: {{$ordenEmpacado->id}}</b></h3></center>
            </div>
            <div class="card-body">
                <div class="row">
                    @for($i=0;$i<count($cajas);$i++)
                    @if($cajas[$i]['tipo']==1)
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-header" style="background-color:#008cff !important; color:white;">
                                Caja #{{$cajas[$i]['empaqueid']}}
                            </div>
                            <div class="card-body">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>REF</th>
                                            <th>CANT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @for ($j=0;$j<count($cajas[$i]['details']);$j++)
                                    <tr>
                                        <td>{{$cajas[$i]['details'][$j]['referencia']}}</td>
                                        <td>{{$cajas[$i]['details'][$j]['total']}}</td>
                                    </tr>
                                    @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @elseif($cajas[$i]['tipo']==2)
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-header" style="background-color:#061f33 !important; color:white;">
                                Bolsa # {{$cajas[$i]['empaqueid']}}
                            </div>
                            <div class="card-body">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>REF</th>
                                            <th>CANT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @for ($j=0;$j<count($cajas[$i]['details']);$j++)
                                    <tr>
                                        <td>{{$cajas[$i]['details'][$j]['referencia']}}</td>
                                        <td>{{$cajas[$i]['details'][$j]['total']}}</td>
                                    </tr>
                                    @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    @endfor
                </div>
            </div>
        </div>
        <!--Details Cajas-->
        @endif
        
        <div class="card m-2" >
            <div class="card-header" style="background-color:#008cff !important; color:white;">
                <center><h3><b>Orden de Despacho Inicial</b></h3></center>
            </div>
            <div class="card-header">
                <div class="row">
                    <div class="col-md-3" style="display:flex; flex-direction:column;">
                        <label>NIT: <b>{{$orden->nit}}</b></label>
                        <label>DIRECCIÓN: <b>{{$orden->direccion}}</b></label>
                        <label>CIUDAD <b>{{$orden->ciudad}}</b></label>
                        <label>OBSERV.  </label> <textarea disabled>{{$orden->observacion}}   </textarea>
                        <label>CLIENTE: <b style="font-size: 1.1em;">{{$orden->cliente}}</b></label>
                    </div>
                    <div class="col-md-3" style="display:flex; flex-direction:column;">
                        Fecha: {{$orden->created_at}}
                        <img width="120px" heigth="120px" src="https://media-exp1.licdn.com/dms/image/C4E0BAQFnW0TdfpMO8w/company-logo_200_200/0/1533585316799?e=2159024400&v=beta&t=L_6VODgFex5zDVs1kvw1dvR9_g-W7j-KfEvVDpkWivo">
                    </div>
                    <div class="col-md-6" style="display:flex; flex-direction:column;">
                        ORDEN DE DESPACHO Nº
                        <div style="width:100%; background-color:#0079fc; color:white; font-size:5em; text-align:center;">{{$orden->consecutivo}}</div>
                       
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="tablecurva">
                        <thead>
                            <tr>
                                <th style="width: 5%;">Pedido</th>
                                <th>Vendedor</th>
                                <th>referencia</th>
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
                            @foreach($detallesOrden as $detalle)
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
                                <td>{{App\Models\Despachos\UserProyNew::where('id','=',App\Models\Despachos\PedidosPROYNEW::where('id','=',App\Models\Despachos\DetallesPedido::where('id','=',$detalle->id)->first()->pedido_id ?? 1)->first()->user_id ?? 1)->first()->username}}</td>
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @if(isset($ordenAlistamiento))

        <!--Orden Alistamiento-->
        <div class="card m-2">
            <div class="card-header" style="background-color:#008cff !important; color:white;">
                <center><h3><b>Detalle Alistamiento</b></h3></center>
            </div>
            <div class="card-header">
                <div class="row">
                    <div class="col-md-3" style="display:flex; flex-direction:column;">
                        <label>NIT: <b>{{$ordenAlistamiento->nit}}</b></label>
                        <label>DIRECCIÓN: <b>{{$orden->direccion}}</b></label>
                        <label>CIUDAD <b>{{$orden->ciudad}}</b></label>
                        <label>OBSERV.  </label> <textarea disabled>{{$orden->observacion}}   </textarea>
                        <label>CLIENTE: <b style="font-size: 1.1em;">{{$orden->cliente}}</b></label>
                    </div>
                    <div class="col-md-3" style="display:flex; flex-direction:column;">
                        Fecha: {{$ordenAlistamiento->created_at}}
                        <p><b>Operario a cargo: </b>{{$operario}} </p>
                        <p><b>Coordinador Reviso: </b> {{$rechaza}}</p>
                        <p v-if="$rechaza != 'No necesito revision'"><b>Razón de revisión: </b>{{$razonrevisa}}</p>
                    </div>
                    <div class="col-md-6" style="display:flex; flex-direction:column;">
                        <div style='background-color:rgb(8, 88, 236); color:white;'><center >ORDEN DE ALISTAMIENTO ID</center></div>
                        @if($ordenAlistamiento->estado == 2)
                        <div style="width:100%; background-color:#0079fc; color:white; font-size:5em; text-align:center;">{{$ordenAlistamiento->id}}</div>
                        @elseif($ordenAlistamiento->estado > 2)
                        <div style="width:100%; background-color:#fc1500; color:white; font-size:5em; text-align:center;">{{$ordenAlistamiento->id}}</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="tablecurva">
                        <thead>
                            <tr>
                                <th style="width: 5%;">Pedido</th>
                                <th>referencia</th>
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
                            @foreach($detailOrdenAlistamiento as $detalle)
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
                            <tr class="totales">
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--Orden Alistamiento-->
        @else
        <div class="card m-2">
            <div class="card-header" style="background-color:#008cff !important; color:white;">
                <center><h3><b>Detalle Alistamiento</b></h3></center>
            </div>
            <div class="card-body">
                No hay Alistamiento aun.
            </div>
        </div>
        @endif

        @if(isset($ordenEmpacado))
        <!--Orden Empacado-->
        <div class="card m-2">
            <div class="card-header" style="background-color:#008cff !important; color:white;">
                <center><h3><b>Detalle de Empacado</b></h3></center>
            </div>
            <div class="card-header">
                <div class="row">
                    <div class="col-md-3" style="display:flex; flex-direction:column;">
                        <label>NIT: <b>{{$ordenAlistamiento->nit}}</b></label>
                        <label>DIRECCIÓN: <b>{{$orden->direccion}}</b></label>
                        <label>CIUDAD <b>{{$orden->ciudad}}</b></label>
                        <label>OBSERV.  </label> <textarea disabled>{{$orden->observacion}}   </textarea>
                        <label>CLIENTE: <b style="font-size: 1.1em;">{{$orden->cliente}}</b></label>
                    </div>
                    <div class="col-md-3" style="display:flex; flex-direction:column;">
                        Fecha: {{$ordenAlistamiento->created_at}}
                        <p><b>Operario a cargo: </b>{{$opempaca}} </p>
                    </div>
                    <div class="col-md-6" style="display:flex; flex-direction:column;">
                        <div style='background-color:rgb(8, 88, 236); color:white;'><center >ORDEN DE ALISTAMIENTO ID</center></div>
                        @if($ordenAlistamiento->estado == 2)
                        <div style="width:100%; background-color:#0079fc; color:white; font-size:5em; text-align:center;">{{$ordenEmpacado->id}}</div>
                        @elseif($ordenAlistamiento->estado > 2)
                        <div style="width:100%; background-color:#fc1500; color:white; font-size:5em; text-align:center;">{{$ordenEmpacado->id}}</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="tablecurva">
                        <thead>
                            <tr>
                                <th style="width: 5%;">Pedido</th>
                                <th>referencia</th>
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
                            @foreach($detalleOrdenEmpacado as $detalle)
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
                            <tr class="totales">
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!--Orden Empacado-->
        @else
        <div class="card m-2">
            <div class="card-header" style="background-color:#008cff !important; color:white;">
                <center><h3><b>Detalle Empacado</b></h3></center>
            </div>
            <div class="card-body">
                No hay Orden de Empacado aún.
            </div>
        </div>
        @endif
        </div>
        @if(isset($cajas))
        <button type="button" onclick="printDiv('areaImprimirDetailsCajas')" class="btn-flotante2"><i class="fa fa-print"></i></button>
        @endif
        <button type="button" onclick="printDiv('areaImprimir')" class="btn-flotante"><i class="fa fa-print"></i></button>
</div>
@endsection
@push('scripts-custom')
<script>

    function printDiv(nombreDiv) {
     var contenido= document.getElementById(nombreDiv).innerHTML;
     var contenidoOriginal= document.body.innerHTML;

     document.body.innerHTML = contenido;

     window.print();

     document.body.innerHTML = contenidoOriginal;
    }

</script>
@endpush