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
            
</style>
@endpush
@section('content')
<div id="appvue">
   <section>
        <div class="container-fluid">
            <div class="card m-2">
                <div class="card-header" style="background-color:#007bff !important; color:white; text-align:center;">
                  <h3 v-if="display==false">Revisión de Orden #<span v-html="idordenDespacho"></span></h3><h3 v-if="display==true">Listado Ordenes Pendientes de Revisar</h3>
                </div>
                <div v-if="display==true" class="card-body">
                    <div class="card" style="width:100%;">
                        <div class="card-header" style="background-color:#0095ff; color:white; text-align:center;">
                            Para recordar
                        </div>
                        <div class="card-body">
                            <p><b>CANT.D</b> . Cantidad Real de Despacho | 
                            
                            <b>CANT.A</b> . Cantidad Alistada | 
                            
                            <b>CANT.R</b> . Cantidad Restante  | 
                            
                            <b>OPR</b> . Operario que alista y manda a revisión</p>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width:14%;">Consecutivo</th>
                                    <th style="width:23%;">Cliente</th>
                                    <th style="width:9%;">CANT.D</th>
                                    <th style="width:9%;">CANT.A</th>
                                    <th style="width:9%;">CANT.R</th>
                                    <th style="width:19%;">OPR</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="orden in ordenesDespachoRevisar">
                                    <td v-html="orden.ordenDespacho.consecutivo"></td>
                                    <td v-html="orden.ordenDespacho.cliente+' '+orden.ordenDespacho.nit"></td>
                                    <td v-html="orden.cantidadDespacho"></td>
                                    <td v-html="orden.cantidadAlistada"></td>
                                    <td v-html="orden.cantidadDespacho - orden.cantidadAlistada"></td>
                                    <td v-html="orden.operario"></td>
                                    <td><a style="cursor:pointer;" v-on:click="updateOrden(orden.ordenDespacho.consecutivo)"><span class="badge badge-success"><i class="fa fa-eye"></i></span></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div v-if="display==false" class="card-body">
                    <div class="card-header" style="text-align:center;">
                        <h2>Información del Cliente</h2>
                    </div>
                    <div class="card-body">
                        <div class="row mb-5">
                            <div class="col-sm-4"> </div>
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4">
                                <button @click="alistarNuevamente()" type="button"  class="btn btn-info" >Alistar de Nuevo</button>
                                <button @click="rechazaOrden()" type="button" class="btn btn-danger">Rechazar Orden</button>
                                <button @click="aceptaOrden()" ype="button" class="btn btn-success">Aprobar Orden</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3" style="display:flex; flex-direction:column;">
                                <label>NIT: <b v-html="orden.nit"></b></label>
                                <label>DIRECCIÓN: <b v-html="orden.direccion"></b></label>
                                <label>CIUDAD <b v-html="orden.ciudad"></b></label>
                                <label>OBSERV.  </label> <textarea disabled v-html="orden.observacion"></textarea>
                                <label>CLIENTE: <b style="font-size: 1.1em;" v-html="orden.cliente"></b></label>
                            </div>
                            <div class="col-md-3" style="display:flex; flex-direction:column;">
                                Fecha: <span v-html="orden.created_at"></span>
                                <img width="120px" heigth="120px" src="https://media-exp1.licdn.com/dms/image/C4E0BAQFnW0TdfpMO8w/company-logo_200_200/0/1533585316799?e=2159024400&v=beta&t=L_6VODgFex5zDVs1kvw1dvR9_g-W7j-KfEvVDpkWivo">
                            Operario que remite a revision: 
                              <b v-html="ordenAlistamiento.user_id_alista"></b>
                              Razon por la que remite a revisi+on:
                              <b v-html="ordenAlistamiento.razonRevisionOp"></b>
                            </div>
                            <div class="col-md-6" style="display:flex; flex-direction:column;">
                                ORDEN DE DESPACHO Nº
                                <div style="width:100%; background-color:#0079fc; color:white; font-size:5em; text-align:center;"><span v-html="orden.consecutivo"></span></div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary mb-2 w-100" type="button" data-toggle="collapse" data-target="#collapseCurvaDespacho" aria-expanded="false" aria-controls="collapseExample">
                        Curva Despacho <span class="badge badge-success">Total: <span v-html="totalesDespacho.total"></span></span>
                    </button>
                    <div class="collapse" id="collapseCurvaDespacho">
                        <div class="card card-body">
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
                                    <tr v-for="(detalle,indice) in detailsOrdenDespacho">
                                        <td v-html="detalle.pedido_id"></td>
                                        <td>Por Definir</td>
                                        <td v-html="detalle.referencia"></td>
                                        <td v-html="detalle.t4"></td>
                                        <td v-html="detalle.t6"></td>
                                        <td v-html="detalle.t8"></td>
                                        <td v-html="detalle.t10"></td>
                                        <td v-html="detalle.t12"></td>
                                        <td v-html="detalle.t14"></td>
                                        <td v-html="detalle.t16"></td>
                                        <td v-html="detalle.t18"></td>
                                        <td v-html="detalle.t20"></td>
                                        <td v-html="detalle.t22"></td>
                                        <td v-html="detalle.t24"></td>
                                        <td v-html="detalle.t26"></td>
                                        <td v-html="detalle.t28"></td>
                                        <td v-html="detalle.t30"></td>
                                        <td v-html="detalle.t32"></td>
                                        <td v-html="detalle.t34"></td>
                                        <td v-html="detalle.t36"></td>
                                        <td v-html="detalle.t38"></td>
                                        <td v-html="detalle.s"></td>
                                        <td v-html="detalle.m"></td>
                                        <td v-html="detalle.l"></td>
                                        <td v-html="detalle.xl"></td>
                                        <td v-html="detalle.total"></td>
                                    </tr>
                                    <tr style="background-color:#008cff; color:white;">
                                        <td colspan="3" style="text-align:center">Totales</td>
                                        <td v-html="totalesDespacho.t4"></td>
                                        <td v-html="totalesDespacho.t6"></td>
                                        <td v-html="totalesDespacho.t8"></td>
                                        <td v-html="totalesDespacho.t10"></td>
                                        <td v-html="totalesDespacho.t12"></td>
                                        <td v-html="totalesDespacho.t14"></td>
                                        <td v-html="totalesDespacho.t16"></td>
                                        <td v-html="totalesDespacho.t18"></td>
                                        <td v-html="totalesDespacho.t20"></td>
                                        <td v-html="totalesDespacho.t22"></td>
                                        <td v-html="totalesDespacho.t24"></td>
                                        <td v-html="totalesDespacho.t26"></td>
                                        <td v-html="totalesDespacho.t28"></td>
                                        <td v-html="totalesDespacho.t30"></td>
                                        <td v-html="totalesDespacho.t32"></td>
                                        <td v-html="totalesDespacho.t34"></td>
                                        <td v-html="totalesDespacho.t36"></td>
                                        <td v-html="totalesDespacho.t38"></td>
                                        <td v-html="totalesDespacho.s"></td>
                                        <td v-html="totalesDespacho.m"></td>
                                        <td v-html="totalesDespacho.l"></td>
                                        <td v-html="totalesDespacho.xl"></td>
                                        <td v-html="totalesDespacho.total"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <button class="btn btn-danger w-100" type="button" data-toggle="collapse" data-target="#collapseCurvaAlistamiento" aria-expanded="false" aria-controls="collapseExample">
                        Curva Alistada <span class="badge badge-success" v-html="'Total: '+totalesAlistamiento.total"></span>
                    </button>
                    <div class="collapse" id="collapseCurvaAlistamiento">
                        <div class="card card-body">
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
                                    <tr v-for="(detalle,indice) in detailsOrdenAlistamiento">
                                        <td v-html="detalle.pedido_id"></td>
                                        <td >Por definir</td>
                                        <td v-html="detalle.referencia"></td>
                                        <td v-if="detalle.t4 == detailsOrdenDespacho[indice].t4"><span class="badge badge-success" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'t4')" v-html="detalle.t4"></span></td>
                                        <td v-if="detalle.t4 != detailsOrdenDespacho[indice].t4"><span class="badge badge-danger" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'t4')" v-html="detailsOrdenDespacho[indice].t4 - detalle.t4"></span></td>
                                        <td v-if="detalle.t6 == detailsOrdenDespacho[indice].t6"><span class="badge badge-success" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'t6')" v-html="detalle.t6"></span></td>
                                        <td v-if="detalle.t6 != detailsOrdenDespacho[indice].t6"><span class="badge badge-danger" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'t6')" v-html="detailsOrdenDespacho[indice].t6 - detalle.t6"></span></td>
                                        <td v-if="detalle.t8 == detailsOrdenDespacho[indice].t8"><span class="badge badge-success" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'t8')" v-html="detalle.t8"></span></td>
                                        <td v-if="detalle.t8 != detailsOrdenDespacho[indice].t8"><span class="badge badge-danger" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'t8')" v-html="detailsOrdenDespacho[indice].t8 - detalle.t8"></span></td>
                                        <td v-if="detalle.t10 == detailsOrdenDespacho[indice].t10"><span class="badge badge-success" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'t10')" v-html="detalle.t10"></span></td>
                                        <td v-if="detalle.t10 != detailsOrdenDespacho[indice].t10"><span class="badge badge-danger" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'t10')" v-html="detailsOrdenDespacho[indice].t10 - detalle.t10"></span></td>
                                        <td v-if="detalle.t12 == detailsOrdenDespacho[indice].t12"><span class="badge badge-success" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'t12')" v-html="detalle.t12"></span></td>
                                        <td v-if="detalle.t12 != detailsOrdenDespacho[indice].t12"><span class="badge badge-danger" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'t12')" v-html="detailsOrdenDespacho[indice].t12 - detalle.t12"></span></td>
                                        <td v-if="detalle.t14 == detailsOrdenDespacho[indice].t14"><span class="badge badge-success" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'t14')" v-html="detalle.t14"></span></td>
                                        <td v-if="detalle.t14 != detailsOrdenDespacho[indice].t14"><span class="badge badge-danger" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'t14')" v-html="detailsOrdenDespacho[indice].t14 - detalle.t14"></span></td>
                                        <td v-if="detalle.t16 == detailsOrdenDespacho[indice].t16"><span class="badge badge-success" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'t16')" v-html="detalle.t16"></span></td>
                                        <td v-if="detalle.t16 != detailsOrdenDespacho[indice].t16"><span class="badge badge-danger" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'t16')" v-html="detailsOrdenDespacho[indice].t16 - detalle.t16"></span></td>
                                        <td v-if="detalle.t18 == detailsOrdenDespacho[indice].t18"><span class="badge badge-success" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'t18')" v-html="detalle.t18"></span></td>
                                        <td v-if="detalle.t18 != detailsOrdenDespacho[indice].t18"><span class="badge badge-danger" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'t18')" v-html="detailsOrdenDespacho[indice].t18 - detalle.t18"></span></td>
                                        <td v-if="detalle.t20 == detailsOrdenDespacho[indice].t20"><span class="badge badge-success" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'t20')" v-html="detalle.t20"></span></td>
                                        <td v-if="detalle.t20 != detailsOrdenDespacho[indice].t20"><span class="badge badge-danger" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'t20')" v-html="detailsOrdenDespacho[indice].t20 - detalle.t20"></span></td>
                                        <td v-if="detalle.t22 == detailsOrdenDespacho[indice].t22"><span class="badge badge-success" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'t22')" v-html="detalle.t22"></span></td>
                                        <td v-if="detalle.t22 != detailsOrdenDespacho[indice].t22"><span class="badge badge-danger" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'t22')" v-html="detailsOrdenDespacho[indice].t22 - detalle.t22"></span></td>
                                        <td v-if="detalle.t24 == detailsOrdenDespacho[indice].t24"><span class="badge badge-success" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'t24')" v-html="detalle.t24"></span></td>
                                        <td v-if="detalle.t24 != detailsOrdenDespacho[indice].t24"><span class="badge badge-danger" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'t24')" v-html="detailsOrdenDespacho[indice].t24 - detalle.t24"></span></td>
                                        <td v-if="detalle.t26 == detailsOrdenDespacho[indice].t26"><span class="badge badge-success" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'t26')" v-html="detalle.t26"></span></td>
                                        <td v-if="detalle.t26 != detailsOrdenDespacho[indice].t26"><span class="badge badge-danger" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'t26')" v-html="detailsOrdenDespacho[indice].t26 - detalle.t26"></span></td>
                                        <td v-if="detalle.t28 == detailsOrdenDespacho[indice].t28"><span class="badge badge-success" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'t28')" v-html="detalle.t28"></span></td>
                                        <td v-if="detalle.t28 != detailsOrdenDespacho[indice].t28"><span class="badge badge-danger" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'t28')" v-html="detailsOrdenDespacho[indice].t28 - detalle.t28"></span></td>
                                        <td v-if="detalle.t30 == detailsOrdenDespacho[indice].t30"><span class="badge badge-success" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'t30')" v-html="detalle.t30"></span></td>
                                        <td v-if="detalle.t30 != detailsOrdenDespacho[indice].t30"><span class="badge badge-danger" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'t30')" v-html="detailsOrdenDespacho[indice].t30 - detalle.t30"></span></td>
                                        <td v-if="detalle.t32 == detailsOrdenDespacho[indice].t32"><span class="badge badge-success" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'t32')" v-html="detalle.t32"></span></td>
                                        <td v-if="detalle.t32 != detailsOrdenDespacho[indice].t32"><span class="badge badge-danger" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'t32')" v-html="detailsOrdenDespacho[indice].t32 - detalle.t32"></span></td>
                                        <td v-if="detalle.t34 == detailsOrdenDespacho[indice].t34"><span class="badge badge-success" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'t34')" v-html="detalle.t34"></span></td>
                                        <td v-if="detalle.t34 != detailsOrdenDespacho[indice].t34"><span class="badge badge-danger" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'t34')" v-html="detailsOrdenDespacho[indice].t34 - detalle.t34"></span></td>
                                        <td v-if="detalle.t36 == detailsOrdenDespacho[indice].t36"><span class="badge badge-success" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'t36')" v-html="detalle.t36"></span></td>
                                        <td v-if="detalle.t36 != detailsOrdenDespacho[indice].t36"><span class="badge badge-danger" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'t36')" v-html="detailsOrdenDespacho[indice].t36 - detalle.t36"></span></td>
                                        <td v-if="detalle.t38 == detailsOrdenDespacho[indice].t38"><span class="badge badge-success" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'t38')" v-html="detalle.t38"></span></td>
                                        <td v-if="detalle.t38 != detailsOrdenDespacho[indice].t38"><span class="badge badge-danger" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'t38')" v-html="detailsOrdenDespacho[indice].t38 - detalle.t38"></span></td>
                                        <td v-if="detalle.s == detailsOrdenDespacho[indice].s"><span class="badge badge-success" style="cursor:pointer;"  v-on:click="aumentaCantidadFaltante(indice,'s')" v-html="detalle.s"></span></td>
                                        <td v-if="detalle.s != detailsOrdenDespacho[indice].s"><span class="badge badge-danger" style="cursor:pointer;"  v-on:click="aumentaCantidadFaltante(indice,'s')" v-html="detailsOrdenDespacho[indice].s - detalle.s"></span></td>
                                        <td v-if="detalle.m == detailsOrdenDespacho[indice].m"><span class="badge badge-success" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'m')" v-html="detalle.m"></span></td>
                                        <td v-if="detalle.m != detailsOrdenDespacho[indice].m"><span class="badge badge-danger" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'m')" v-html="detailsOrdenDespacho[indice].m - detalle.m"></span></td>
                                        <td v-if="detalle.l == detailsOrdenDespacho[indice].l"><span class="badge badge-success" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'l')" v-html="detalle.l"></span></td>
                                        <td v-if="detalle.l != detailsOrdenDespacho[indice].l"><span class="badge badge-danger" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'l')" v-html="detailsOrdenDespacho[indice].l - detalle.l"></span></td>
                                        <td v-if="detalle.xl == detailsOrdenDespacho[indice].xl"><span class="badge badge-success" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'xl')" v-html="detalle.xl"></span></td>
                                        <td v-if="detalle.xl != detailsOrdenDespacho[indice].xl"><span class="badge badge-danger" style="cursor:pointer;" v-on:click="aumentaCantidadFaltante(indice,'xl')" v-html="detailsOrdenDespacho[indice].xl - detalle.xl"></span></td>
                                        
                                        <td><span class="badge badge-info" v-html="detalle.total"></span></td>
                                    </tr>
                                    <tr style="background-color:#008cff; color:white;">
                                        <td colspan="3" style="text-align:center">Totales</td>
                                        <td v-html="totalesAlistamiento.t4"></td>
                                        <td v-html="totalesAlistamiento.t6"></td>
                                        <td v-html="totalesAlistamiento.t8"></td>
                                        <td v-html="totalesAlistamiento.t10"></td>
                                        <td v-html="totalesAlistamiento.t12"></td>
                                        <td v-html="totalesAlistamiento.t14"></td>
                                        <td v-html="totalesAlistamiento.t16"></td>
                                        <td v-html="totalesAlistamiento.t18"></td>
                                        <td v-html="totalesAlistamiento.t20"></td>
                                        <td v-html="totalesAlistamiento.t22"></td>
                                        <td v-html="totalesAlistamiento.t24"></td>
                                        <td v-html="totalesAlistamiento.t26"></td>
                                        <td v-html="totalesAlistamiento.t28"></td>
                                        <td v-html="totalesAlistamiento.t30"></td>
                                        <td v-html="totalesAlistamiento.t32"></td>
                                        <td v-html="totalesAlistamiento.t34"></td>
                                        <td v-html="totalesAlistamiento.t36"></td>
                                        <td v-html="totalesAlistamiento.t38"></td>
                                        <td v-html="totalesAlistamiento.s"></td>
                                        <td v-html="totalesAlistamiento.m"></td>
                                        <td v-html="totalesAlistamiento.l"></td>
                                        <td v-html="totalesAlistamiento.xl"></td>
                                        <td v-html="totalesAlistamiento.total"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                    
                
            </div>
        </div>
        <div id="modalRazonAprueba" class="modal fade" role="dialog">
          <div class="modal-dialog">
        
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Confirmación Orden Despacho</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <p>¿Cual es la razon por la que aprueba la orden?</p>
                <select class="form-control" v-model="razonApruebaOrden">
                    <option value="Puedo despachar asi al cliente">Puedo despachar asi al cliente</option>
                    <option value="Orden administrativa">Orden administrativa</option>
                </select>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <a style="cursor:pointer; color:white !important;" class="btn btn-success" v-on:click="confirmarRevisionAprueba()" data-dismiss="modal">Aprobar ahora</a>
              </div>
            </div>
        
          </div>
        </div>
        
        <div id="modalRazonRechaza" class="modal fade" role="dialog">
          <div class="modal-dialog">
        
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Confirmación Orden Despacho</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <p>¿Cual es la razon por la que rechaza la orden?</p>
                <select class="form-control" v-model="razonRechazaOrden">
                    <option value="Cliente no admite prendas de menos">Cliente no admite prendas de menos</option>
                    <option value="Orden administrativa">Orden administrativa</option>
                </select>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <a style="cursor:pointer; color:white !important;" class="btn btn-warning" v-on:click="confirmarRevisionRechaza()" data-dismiss="modal">Rechazar ahora</a>
              </div>
            </div>
        
          </div>
        </div>
        
        <div id="modalAddValores" class="modal fade" role="dialog">
          <div class="modal-dialog">
        
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Aumentar valores</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <div class="row">
                    <div class="col-md-6" style="text-align:center">
                        <p v-html="'Cantidad '+tallaModificacion+' :'"></p>
                        <span style="font-size:1.5em;" v-html="numeroModificacion"></span>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-sm-12">
                                <span v-on:click="sumarValor()" class="btn btn-success">
                                    <i class="fa fa-plus"></i>
                                </span>
                            </div>
                            <div class="col-sm-12 pt-2">
                                <span v-on:click="restarValor()" class="btn btn-warning">
                                    <i class="fa fa-minus"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        
          </div>
        </div>
        
    </section>
</div>
@endsection
@push('scripts-custom')
<script src="https://unpkg.com/axios@0.27.2/dist/axios.min.js"></script>
<script src="https://unpkg.com/vue@next"></script>
<script>
    $("#modalRazonRechaza").on("hidden.bs.modal", function () {
        swal('Informativo','No has seleccionado una opción valida.','error');
    });
                    
    $("#modalRazonAprueba").on("hidden.bs.modal", function () {
        swal('Informativo','No has seleccionado una opción valida.','error');
    });
</script>
<script>

const AttributeBinding = {
     data () {
    return {
        ordenesDespachoRevisar:[],
        display:true,
        idordenDespacho:'',
        orden:[],
        detailsOrdenDespacho:[],
        detailsOrdenAlistamiento:[],
        ordenAlistamiento:[],
        razonApruebaOrden:'Puedo despachar asi al cliente',
        razonRechazaOrden:'Cliente no admite prendas de menos',
        numeroModificacion:0,
        tallaModificacion:'',
        indiceModificacion:'',
        totalesDespacho:{
            t4:0,
            t6:0,
            t8:0,
            t10:0,
            t12:0,
            t14:0,
            t16:0,
            t18:0,
            t20:0,
            t22:0,
            t24:0,
            t26:0,
            t28:0,
            t30:0,
            t32:0,
            t34:0,
            t36:0,
            t38:0,
            s:0,
            m:0,
            l:0,
            xl:0,
            total:0
        },
        totalesAlistamiento:{
            t4:0,
            t6:0,
            t8:0,
            t10:0,
            t12:0,
            t14:0,
            t16:0,
            t18:0,
            t20:0,
            t22:0,
            t24:0,
            t26:0,
            t28:0,
            t30:0,
            t32:0,
            t34:0,
            t36:0,
            t38:0,
            s:0,
            m:0,
            l:0,
            xl:0,
            total:0
        }
    }
  },
    props: {

    },
    methods: {
        updateOrden(numero){
            this.idordenDespacho = numero
            this.display=false
            this.consultarOrdenDespacho()
            this.getDetailsOrdenDespacho()
            this.getDetailsAlistamiento()
            this.getOrdenAlistamiento()
        },
        aumentaCantidadFaltante(indice,talla){
            this.tallaModificacion = talla;
            this.indiceModificacion = indice;
            if(talla == 't4'){
                this.numeroModificacion = this.detailsOrdenAlistamiento[indice].t4;
            }else if(talla == 't6'){
                 this.numeroModificacion =  this.detailsOrdenAlistamiento[indice].t6;
            }else if(talla == 't8'){
                 this.numeroModificacion =  this.detailsOrdenAlistamiento[indice].t8;
            }else if(talla == 't10'){
                 this.numeroModificacion =  this.detailsOrdenAlistamiento[indice].t10;
            }else if(talla == 't12'){
                 this.numeroModificacion =  this.detailsOrdenAlistamiento[indice].t12;
            }else if(talla == 't14'){
                 this.numeroModificacion =  this.detailsOrdenAlistamiento[indice].t14;
            }else if(talla == 't16'){
                 this.numeroModificacion =  this.detailsOrdenAlistamiento[indice].t16;
            }else if(talla == 't18'){
                 this.numeroModificacion =  this.detailsOrdenAlistamiento[indice].t18;
            }else if(talla == 't20'){
                 this.numeroModificacion =  this.detailsOrdenAlistamiento[indice].t20;
            }else if(talla == 't22'){
                 this.numeroModificacion =  this.detailsOrdenAlistamiento[indice].t22;
            }else if(talla == 't24'){
                 this.numeroModificacion =  this.detailsOrdenAlistamiento[indice].t24;
            }else if(talla == 't26'){
                 this.numeroModificacion =  this.detailsOrdenAlistamiento[indice].t26;
            }else if(talla == 't28'){
                 this.numeroModificacion =  this.detailsOrdenAlistamiento[indice].t28;
            }else if(talla == 't30'){
                 this.numeroModificacion =  this.detailsOrdenAlistamiento[indice].t30;
            }else if(talla == 't32'){
                 this.numeroModificacion =  this.detailsOrdenAlistamiento[indice].t32;
            }else if(talla == 't34'){
                 this.numeroModificacion =  this.detailsOrdenAlistamiento[indice].t34;
            }else if(talla == 't36'){
                 this.numeroModificacion =  this.detailsOrdenAlistamiento[indice].t36;
            }else if(talla == 't38'){
                 this.numeroModificacion =  this.detailsOrdenAlistamiento[indice].t38;
            }else if(talla == 's'){
                 this.numeroModificacion =  this.detailsOrdenAlistamiento[indice].s;
            }else if(talla == 'm'){
                 this.numeroModificacion =  this.detailsOrdenAlistamiento[indice].m;
            }else if(talla == 'l'){
                 this.numeroModificacion =  this.detailsOrdenAlistamiento[indice].l;
            }else if(talla == 'xl'){
                 this.numeroModificacion =  this.detailsOrdenAlistamiento[indice].xl;
            }
            
            $('#modalAddValores').modal('show');
        },
        sumarValor(){
            
                if(this.tallaModificacion == 't4'){
                   this.detailsOrdenAlistamiento[this.indiceModificacion].t4++;
                   this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].t4;
    		       this.totalesAlistamiento.t4++;
    		       this.totalesAlistamiento.total++;
    		       this.detailsOrdenAlistamiento[this.indiceModificacion].total++;
                }else if(this.tallaModificacion == 't6'){
                    this.detailsOrdenAlistamiento[this.indiceModificacion].t6++;
                    this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].t6;
    			    this.totalesAlistamiento.t6++;
    			    this.totalesAlistamiento.total++;
    			    this.detailsOrdenAlistamiento[this.indiceModificacion].total++;
                }else if(this.tallaModificacion == 't8'){
                   this.detailsOrdenAlistamiento[this.indiceModificacion].t8++;
                    this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].t8;
                    this.totalesAlistamiento.t8++;
                    this.totalesAlistamiento.total++;
                    this.detailsOrdenAlistamiento[this.indiceModificacion].total++;
                }else if(this.tallaModificacion == 't10'){
                   this.detailsOrdenAlistamiento[this.indiceModificacion].t10++;
                    this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].t10;
                    this.totalesAlistamiento.t10++;
                    this.totalesAlistamiento.total++;
                    this.detailsOrdenAlistamiento[this.indiceModificacion].total++;
                }else if(this.tallaModificacion == 't12'){
                   this.detailsOrdenAlistamiento[this.indiceModificacion].t12++;
                    this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].t12;
                    this.totalesAlistamiento.t12++;
                    this.totalesAlistamiento.total++;
                    this.detailsOrdenAlistamiento[this.indiceModificacion].total++;
                }else if(this.tallaModificacion == 't14'){
                   this.detailsOrdenAlistamiento[this.indiceModificacion].t14++;
                    this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].t14;
                    this.totalesAlistamiento.t14++;
                    this.totalesAlistamiento.total++;
                    this.detailsOrdenAlistamiento[this.indiceModificacion].total++;
                }else if(this.tallaModificacion == 't16'){
                   this.detailsOrdenAlistamiento[this.indiceModificacion].t16++;
                    this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].t16;
                    this.totalesAlistamiento.t16++;
                    this.totalesAlistamiento.total++;
                    this.detailsOrdenAlistamiento[this.indiceModificacion].total++;
                }else if(this.tallaModificacion == 't18'){
                   this.detailsOrdenAlistamiento[this.indiceModificacion].t18++;
                    this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].t18;
                    this.totalesAlistamiento.t18++;
                    this.totalesAlistamiento.total++;
                    this.detailsOrdenAlistamiento[this.indiceModificacion].total++;
                }else if(this.tallaModificacion == 't20'){
                   this.detailsOrdenAlistamiento[this.indiceModificacion].t20++;
                    this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].t20;
                    this.totalesAlistamiento.t20++;
                    this.totalesAlistamiento.total++;
                    this.detailsOrdenAlistamiento[this.indiceModificacion].total++;
                }else if(this.tallaModificacion == 't22'){
                   this.detailsOrdenAlistamiento[this.indiceModificacion].t22++;
                    this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].t22;
                    this.totalesAlistamiento.t22++;
                    this.totalesAlistamiento.total++;
                    this.detailsOrdenAlistamiento[this.indiceModificacion].total++;
                }else if(this.tallaModificacion == 't24'){
                   this.detailsOrdenAlistamiento[this.indiceModificacion].t24++;
                    this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].t24;
                    this.totalesAlistamiento.t24++;
                    this.totalesAlistamiento.total++;
                    this.detailsOrdenAlistamiento[this.indiceModificacion].total++;
                }else if(this.tallaModificacion == 't26'){
                   this.detailsOrdenAlistamiento[this.indiceModificacion].t26++;
                    this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].t26;
                    this.totalesAlistamiento.t26++;
                    this.totalesAlistamiento.total++;
                    this.detailsOrdenAlistamiento[this.indiceModificacion].total++;
                }else if(this.tallaModificacion == 't28'){
                   this.detailsOrdenAlistamiento[this.indiceModificacion].t28++;
                    this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].t28;
                    this.totalesAlistamiento.t28++;
                    this.totalesAlistamiento.total++;
                    this.detailsOrdenAlistamiento[this.indiceModificacion].total++;
                }else if(this.tallaModificacion == 't30'){
                   this.detailsOrdenAlistamiento[this.indiceModificacion].t30++;
                    this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].t30;
                    this.totalesAlistamiento.t30++;
                    this.totalesAlistamiento.total++;
                    this.detailsOrdenAlistamiento[this.indiceModificacion].total++;
                }else if(this.tallaModificacion == 't32'){
                   this.detailsOrdenAlistamiento[this.indiceModificacion].t32++;
                    this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].t32;
                    this.totalesAlistamiento.t32++;
                    this.totalesAlistamiento.total++;
                    this.detailsOrdenAlistamiento[this.indiceModificacion].total++;
                }else if(this.tallaModificacion == 't34'){
                   this.detailsOrdenAlistamiento[this.indiceModificacion].t34++;
                    this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].t34;
                    this.totalesAlistamiento.t34++;
                    this.totalesAlistamiento.total++;
                    this.detailsOrdenAlistamiento[this.indiceModificacion].total++;
                }else if(this.tallaModificacion == 't36'){
                   this.detailsOrdenAlistamiento[this.indiceModificacion].t36++;
                    this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].t36;
                    this.totalesAlistamiento.t36++;
                    this.totalesAlistamiento.total++;
                    this.detailsOrdenAlistamiento[this.indiceModificacion].total++;
                }else if(this.tallaModificacion == 't38'){
                   this.detailsOrdenAlistamiento[this.indiceModificacion].t38++;
                    this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].t38;
                    this.totalesAlistamiento.t38++;
                    this.totalesAlistamiento.total++;
                    this.detailsOrdenAlistamiento[this.indiceModificacion].total++;
                }else if(this.tallaModificacion == 's'){
                   this.detailsOrdenAlistamiento[this.indiceModificacion].s++;
                    this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].s;
                    this.totalesAlistamiento.s++;
                    this.totalesAlistamiento.total++;
                    this.detailsOrdenAlistamiento[this.indiceModificacion].total++;
                }else if(this.tallaModificacion == 'm'){
                   this.detailsOrdenAlistamiento[this.indiceModificacion].m++;
                    this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].m;
                    this.totalesAlistamiento.m++;
                    this.totalesAlistamiento.total++;
                    this.detailsOrdenAlistamiento[this.indiceModificacion].total++;
                }else if(this.tallaModificacion == 'l'){
                   this.detailsOrdenAlistamiento[this.indiceModificacion].l++;
                    this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].l;
                    this.totalesAlistamiento.l++;
                    this.totalesAlistamiento.total++;
                    this.detailsOrdenAlistamiento[this.indiceModificacion].total++;
                }else if(this.tallaModificacion == 'xl'){
                   this.detailsOrdenAlistamiento[this.indiceModificacion].xl++;
                    this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].xl;
                    this.totalesAlistamiento.xl++;
                    this.totalesAlistamiento.total++;
                    this.detailsOrdenAlistamiento[this.indiceModificacion].total++;
                }
                
                
           
        },
        restarValor(){
            if(this.totalesAlistamiento.total > 0){
                if(this.tallaModificacion == 't4'){
                    if(this.detailsOrdenAlistamiento[this.indiceModificacion].t4 > 0){
                        this.detailsOrdenAlistamiento[this.indiceModificacion].t4--;
                        this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].t4;
        		        this.totalesAlistamiento.t4--;
        		        this.totalesAlistamiento.total--;
        		        this.detailsOrdenAlistamiento[this.indiceModificacion].total--;
                    }else{
                        swal('No puede disminuir mas cantidades, ¡ESTA EN CERO!');
                    }
                   
                }else if(this.tallaModificacion == 't6'){
                    if(this.detailsOrdenAlistamiento[this.indiceModificacion].t6 > 0){
                        this.detailsOrdenAlistamiento[this.indiceModificacion].t6--;
                        this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].t6;
        			    this.totalesAlistamiento.t6--;
        			    this.totalesAlistamiento.total--;
        			    this.detailsOrdenAlistamiento[this.indiceModificacion].total--;
                    }else{
                        swal('No puede disminuir mas cantidades, ¡ESTA EN CERO!');
                    }
                }else if(this.tallaModificacion == 't8'){
                    if(this.detailsOrdenAlistamiento[this.indiceModificacion].t8 > 0){
                        this.detailsOrdenAlistamiento[this.indiceModificacion].t8--;
                        this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].t8;
                        this.totalesAlistamiento.t8--;
                        this.totalesAlistamiento.total--;
                        this.detailsOrdenAlistamiento[this.indiceModificacion].total--;
                    }else{
                        swal('No puede disminuir mas cantidades, ¡ESTA EN CERO!');
                    }
                }else if(this.tallaModificacion == 't10'){
                    if(this.detailsOrdenAlistamiento[this.indiceModificacion].t10 > 0){
                        this.detailsOrdenAlistamiento[this.indiceModificacion].t10--;
                        this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].t10;
                        this.totalesAlistamiento.t10--;
                        this.totalesAlistamiento.total--;
                        this.detailsOrdenAlistamiento[this.indiceModificacion].total--;
                    }else{
                        swal('No puede disminuir mas cantidades, ¡ESTA EN CERO!');
                    }
                }else if(this.tallaModificacion == 't12'){
                    if(this.detailsOrdenAlistamiento[this.indiceModificacion].t12 > 0){
                       this.detailsOrdenAlistamiento[this.indiceModificacion].t12--;
                        this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].t12;
                        this.totalesAlistamiento.t12--;
                        this.totalesAlistamiento.total--;
                        this.detailsOrdenAlistamiento[this.indiceModificacion].total--;
                    }else{
                        swal('No puede disminuir mas cantidades, ¡ESTA EN CERO!');
                    }
                }else if(this.tallaModificacion == 't14'){
                     if(this.detailsOrdenAlistamiento[this.indiceModificacion].t14 > 0){
                       this.detailsOrdenAlistamiento[this.indiceModificacion].t14--;
                        this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].t14;
                        this.totalesAlistamiento.t14--;
                        this.totalesAlistamiento.total--;
                        this.detailsOrdenAlistamiento[this.indiceModificacion].total--;
                     }else{
                        swal('No puede disminuir mas cantidades, ¡ESTA EN CERO!');
                    }
                }else if(this.tallaModificacion == 't16'){
                    if(this.detailsOrdenAlistamiento[this.indiceModificacion].t16 > 0){
                        this.detailsOrdenAlistamiento[this.indiceModificacion].t16--;
                        this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].t16;
                        this.totalesAlistamiento.t16--;
                        this.totalesAlistamiento.total--;
                        this.detailsOrdenAlistamiento[this.indiceModificacion].total--;
                    }else{
                        swal('No puede disminuir mas cantidades, ¡ESTA EN CERO!');
                    }
                }else if(this.tallaModificacion == 't18'){
                    if(this.detailsOrdenAlistamiento[this.indiceModificacion].t18 > 0){
                   this.detailsOrdenAlistamiento[this.indiceModificacion].t18--;
                    this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].t18;
                    this.totalesAlistamiento.t18--;
                    this.totalesAlistamiento.total--;
                    this.detailsOrdenAlistamiento[this.indiceModificacion].total--;
                    }else{
                        swal('No puede disminuir mas cantidades, ¡ESTA EN CERO!');
                    }
                }else if(this.tallaModificacion == 't20'){
                    if(this.detailsOrdenAlistamiento[this.indiceModificacion].t20 > 0){
                   this.detailsOrdenAlistamiento[this.indiceModificacion].t20--;
                    this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].t20;
                    this.totalesAlistamiento.t20--;
                    this.totalesAlistamiento.total--;
                    this.detailsOrdenAlistamiento[this.indiceModificacion].total--;
                    }else{
                        swal('No puede disminuir mas cantidades, ¡ESTA EN CERO!');
                    }
                }else if(this.tallaModificacion == 't22'){
                    if(this.detailsOrdenAlistamiento[this.indiceModificacion].t22 > 0){
                       this.detailsOrdenAlistamiento[this.indiceModificacion].t22--;
                        this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].t22;
                        this.totalesAlistamiento.t22--;
                        this.totalesAlistamiento.total--;
                        this.detailsOrdenAlistamiento[this.indiceModificacion].total--;
                    }else{
                        swal('No puede disminuir mas cantidades, ¡ESTA EN CERO!');
                    }
                }else if(this.tallaModificacion == 't24'){
                    if(this.detailsOrdenAlistamiento[this.indiceModificacion].t24 > 0){
                       this.detailsOrdenAlistamiento[this.indiceModificacion].t24--;
                        this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].t24;
                        this.totalesAlistamiento.t24--;
                        this.totalesAlistamiento.total--;
                        this.detailsOrdenAlistamiento[this.indiceModificacion].total--;
                    }else{
                        swal('No puede disminuir mas cantidades, ¡ESTA EN CERO!');
                    }
                }else if(this.tallaModificacion == 't26'){
                    if(this.detailsOrdenAlistamiento[this.indiceModificacion].t26 > 0){
                       this.detailsOrdenAlistamiento[this.indiceModificacion].t26--;
                        this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].t26;
                        this.totalesAlistamiento.t26--;
                        this.totalesAlistamiento.total--;
                        this.detailsOrdenAlistamiento[this.indiceModificacion].total--;
                    }else{
                        swal('No puede disminuir mas cantidades, ¡ESTA EN CERO!');
                    }
                }else if(this.tallaModificacion == 't28'){
                    if(this.detailsOrdenAlistamiento[this.indiceModificacion].t28 > 0){
                   this.detailsOrdenAlistamiento[this.indiceModificacion].t28--;
                    this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].t28;
                    this.totalesAlistamiento.t28--;
                    this.totalesAlistamiento.total--;
                    this.detailsOrdenAlistamiento[this.indiceModificacion].total--;
                    }else{
                        swal('No puede disminuir mas cantidades, ¡ESTA EN CERO!');
                    }
                }else if(this.tallaModificacion == 't30'){
                    if(this.detailsOrdenAlistamiento[this.indiceModificacion].t30 > 0){
                   this.detailsOrdenAlistamiento[this.indiceModificacion].t30--;
                    this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].t30;
                    this.totalesAlistamiento.t30--;
                    this.totalesAlistamiento.total--;
                    this.detailsOrdenAlistamiento[this.indiceModificacion].total--;
                    }else{
                        swal('No puede disminuir mas cantidades, ¡ESTA EN CERO!');
                    }
                }else if(this.tallaModificacion == 't32'){
                    if(this.detailsOrdenAlistamiento[this.indiceModificacion].t32 > 0){
                   this.detailsOrdenAlistamiento[this.indiceModificacion].t32--;
                    this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].t32;
                    this.totalesAlistamiento.t32--;
                    this.totalesAlistamiento.total--;
                    this.detailsOrdenAlistamiento[this.indiceModificacion].total--;
                    }else{
                        swal('No puede disminuir mas cantidades, ¡ESTA EN CERO!');
                    }
                }else if(this.tallaModificacion == 't34'){
                    if(this.detailsOrdenAlistamiento[this.indiceModificacion].t34 > 0){
                   this.detailsOrdenAlistamiento[this.indiceModificacion].t34--;
                    this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].t34;
                    this.totalesAlistamiento.t34--;
                    this.totalesAlistamiento.total--;
                    this.detailsOrdenAlistamiento[this.indiceModificacion].total--;
                    }else{
                        swal('No puede disminuir mas cantidades, ¡ESTA EN CERO!');
                    }
                }else if(this.tallaModificacion == 't36'){
                    if(this.detailsOrdenAlistamiento[this.indiceModificacion].t36 > 0){
                   this.detailsOrdenAlistamiento[this.indiceModificacion].t36--;
                    this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].t36;
                    this.totalesAlistamiento.t36--;
                    this.totalesAlistamiento.total--;
                    this.detailsOrdenAlistamiento[this.indiceModificacion].total--;
                    }else{
                        swal('No puede disminuir mas cantidades, ¡ESTA EN CERO!');
                    }
                }else if(this.tallaModificacion == 't38'){
                    if(this.detailsOrdenAlistamiento[this.indiceModificacion].t38 > 0){
                   this.detailsOrdenAlistamiento[this.indiceModificacion].t38--;
                    this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].t38;
                    this.totalesAlistamiento.t38--;
                    this.totalesAlistamiento.total--;
                    this.detailsOrdenAlistamiento[this.indiceModificacion].total--;
                    }else{
                        swal('No puede disminuir mas cantidades, ¡ESTA EN CERO!');
                    }
                }else if(this.tallaModificacion == 's'){
                    if(this.detailsOrdenAlistamiento[this.indiceModificacion].s > 0){
                   this.detailsOrdenAlistamiento[this.indiceModificacion].s--;
                    this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].s;
                    this.totalesAlistamiento.s--;
                    this.totalesAlistamiento.total--;
                    this.detailsOrdenAlistamiento[this.indiceModificacion].total--;
                    }else{
                        swal('No puede disminuir mas cantidades, ¡ESTA EN CERO!');
                    }
                }else if(this.tallaModificacion == 'm'){
                    if(this.detailsOrdenAlistamiento[this.indiceModificacion].m > 0){
                   this.detailsOrdenAlistamiento[this.indiceModificacion].m--;
                    this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].m;
                    this.totalesAlistamiento.m--;
                    this.totalesAlistamiento.total--;
                    this.detailsOrdenAlistamiento[this.indiceModificacion].total--;
                    }else{
                        swal('No puede disminuir mas cantidades, ¡ESTA EN CERO!');
                    }
                }else if(this.tallaModificacion == 'l'){
                    if(this.detailsOrdenAlistamiento[this.indiceModificacion].l > 0){
                   this.detailsOrdenAlistamiento[this.indiceModificacion].l--;
                    this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].l;
                    this.totalesAlistamiento.l--;
                    this.totalesAlistamiento.total--;
                    this.detailsOrdenAlistamiento[this.indiceModificacion].total--;
                    }else{
                        swal('No puede disminuir mas cantidades, ¡ESTA EN CERO!');
                    }
                }else if(this.tallaModificacion == 'xl'){
                    if(this.detailsOrdenAlistamiento[this.indiceModificacion].xl > 0){
                   this.detailsOrdenAlistamiento[this.indiceModificacion].xl--;
                    this.numeroModificacion =  this.detailsOrdenAlistamiento[this.indiceModificacion].xl;
                    this.totalesAlistamiento.xl--;
                    this.totalesAlistamiento.total--;
                    this.detailsOrdenAlistamiento[this.indiceModificacion].total--;
                    }else{
                        swal('No puede disminuir mas cantidades, ¡ESTA EN CERO!');
                    }
                }
                
                
            }else{
                swal('No puede disminuir la totalidad de prendas.');
            }
        },
        getOrdenAlistamiento(){
            axios.get('infoOrdenAlistamiento/'+this.idordenDespacho)
            .then(response => {
                this.ordenAlistamiento = response.data
            })
        },
        ordenDespachoRevisar(){
            axios.get('ordenesRevisionGet')
            .then(response => {
                this.ordenesDespachoRevisar = response.data.datica
            })
        },
        consultarOrdenDespacho(){
            axios.get('getOrdenDespacho/'+this.idordenDespacho)
            .then(response => {
                this.orden=response.data
            })
        },
        rechazaOrden(){
             swal({
                title: "Alerta!",
                text: "Si aceptas rechazar esta orden, se cancelara totalmente la orden.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    $('#modalRazonRechaza').modal('show');
                }
            });
        },
        confirmarRevisionRechaza(){
            if(this.razonRechazaOrden != ''){
                let data = {razon:this.razonRechazaOrden,consecutivo:this.idordenDespacho, _token: document.querySelector('meta[name="csrf-token"]').content};
                axios.post('rechazaOrdenDespacho',data)
                    .then(response => {
                        swal('Informativo',response.data.message,'info').then((ref) => {
                            if(ref){
                                this.display = true
                                this.ordenDespachoRevisar()
                            }
                        });
                    })
            }else{
                swal('Informativo','No has seleccionado una opción valida.','error');
            }
            
        },
        aceptaOrden(){
            swal({
                title: "Alerta!",
                text: "Si apruebas esta orden, pasara directamente a empacado.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    $('#modalRazonAprueba').modal('show');
                }
            });
        },
        confirmarRevisionAprueba(){
            if(this.razonApruebaOrden != ''){
                let data = {razon:this.razonApruebaOrden, detalleOrdenAlistamiento: this.detailsOrdenAlistamiento, consecutivo:this.idordenDespacho, _token: document.querySelector('meta[name="csrf-token"]').content};
                this.enviaPeticionAprobacion(data);
            }else{
                swal('Informativo','No has seleccionado una opción valida.','error');
            }
        },
        enviaPeticionAprobacion(data){
            axios.post('apruebaOrdenDespacho',data)
                            .then(response => {
                                swal('Informativo',response.data.message,'success').then((ref) => {
                                    if(ref){
                                        this.display = true
                                        this.ordenDespachoRevisar()
                                    }
                                });
                            })
        },
        getDetailsOrdenDespacho(){
            axios.get('getDetailsOrdenDespacho/'+this.idordenDespacho).then(response => {
                this.detailsOrdenDespacho = response.data
                for (let index = 0; index < response.data.length; index++) {
                    const element = response.data[index];
                    this.totalesDespacho.t4 += element.t4;
                    this.totalesDespacho.t6 += element.t6;
                    this.totalesDespacho.t8 += element.t8;
                    this.totalesDespacho.t10 += element.t10;
                    this.totalesDespacho.t12 += element.t12;
                    this.totalesDespacho.t14 += element.t14;
                    this.totalesDespacho.t16 += element.t16;
                    this.totalesDespacho.t18 += element.t18;
                    this.totalesDespacho.t20 += element.t20;
                    this.totalesDespacho.t22 += element.t22;
                    this.totalesDespacho.t24 += element.t24;
                    this.totalesDespacho.t26 += element.t26;
                    this.totalesDespacho.t28 += element.t28;
                    this.totalesDespacho.t30 += element.t30;
                    this.totalesDespacho.t32 += element.t32;
                    this.totalesDespacho.t34 += element.t34;
                    this.totalesDespacho.t36 += element.t36;
                    this.totalesDespacho.t38 += element.t38;
                    this.totalesDespacho.s += element.s;
                    this.totalesDespacho.m += element.m;
                    this.totalesDespacho.l += element.l;
                    this.totalesDespacho.xl += element.xl;
                    this.totalesDespacho.total += element.total;
                }
            });
        },
        getDetailsAlistamiento(){
             axios.get('getDetailAlistamiento/'+this.idordenDespacho)
            .then(response => {
                this.detailsOrdenAlistamiento=response.data
                for (let index = 0; index < response.data.length; index++) {
                    const element = response.data[index];
                    this.totalesAlistamiento.t4 += element.t4;
                    this.totalesAlistamiento.t6 += element.t6;
                    this.totalesAlistamiento.t8 += element.t8;
                    this.totalesAlistamiento.t10 += element.t10;
                    this.totalesAlistamiento.t12 += element.t12;
                    this.totalesAlistamiento.t14 += element.t14;
                    this.totalesAlistamiento.t16 += element.t16;
                    this.totalesAlistamiento.t18 += element.t18;
                    this.totalesAlistamiento.t20 += element.t20;
                    this.totalesAlistamiento.t22 += element.t22;
                    this.totalesAlistamiento.t24 += element.t24;
                    this.totalesAlistamiento.t26 += element.t26;
                    this.totalesAlistamiento.t28 += element.t28;
                    this.totalesAlistamiento.t30 += element.t30;
                    this.totalesAlistamiento.t32 += element.t32;
                    this.totalesAlistamiento.t34 += element.t34;
                    this.totalesAlistamiento.t36 += element.t36;
                    this.totalesAlistamiento.t38 += element.t38;
                    this.totalesAlistamiento.s += element.s;
                    this.totalesAlistamiento.m += element.m;
                    this.totalesAlistamiento.l += element.l;
                    this.totalesAlistamiento.xl += element.xl;
                    this.totalesAlistamiento.total += element.total;
                }
            })
        },
        alistarNuevamente(){
             swal({
                title: "Alerta!",
                text: "Una vez aceptes mandar a alistar nuevamente la orden, esta será mostrada al operario.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                     let data = {consecutivo:this.idordenDespacho, _token: document.querySelector('meta[name="csrf-token"]').content};
                    axios.post('alistarDeNuevo',data)
                    .then(response => {
                       swal('Informativo',response.data,'info').then((ref) => {
                           if(ref){
                               this.display = true
                               this.ordenDespachoRevisar()
                           }
                       });
                    })
                }
            });
        }


    },
    mounted(){
        this.ordenDespachoRevisar();
    },
}
var example2=Vue.createApp(AttributeBinding).mount('#appvue')
</script>
@endpush
