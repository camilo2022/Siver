@extends('layouts.appp')

@push('custom-css')
<link rel="stylesheet" href="{!! asset('/css/formEditCorte.css') !!}">
<link rel="stylesheet" href="{!! asset('/css/loading.css') !!}">
<link href="https://harvesthq.github.io/chosen/chosen.css" rel="stylesheet"/>
<style>
    .chosen-choices {
    font-size: 14px;
    border-color: #ebedf2;
    padding: 0.6rem 1rem;
    width: 100%;
    height: calc(2.25rem + 2px);
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }
</style>
@endpush

@section('content')
<body>
    <div class="card-body">
    <div class="table-responsive">
    <!--INCIO DE LA PRIMERA TABLA-->
<form method="post" action="{{route('updateC',$OrdenCorte->id)}}" accept-charset="UTF-8" id="EditarCorte" enctype="multipart/form-data" autocomplete="off">
    @csrf
    <br>
    <div id="areaImprimir">
    <table>

        <!--ENCABEZADO DE LA PRIMERA TABLA-->

            <tr>
                <td rowspan="2" colspan="3"> <img src="{{ asset('img/logo.jpg') }}" alt="" class="encabezadoPrincipal img"> </td> 
                <td colspan="6"> <label for="" class="encabezadoPrincipal">CORTE</label> </td> 
                <td colspan="3"> <label for="" class="encabezadoPrincipal">CT FR #2 Versión: 01</label> </td> 
                <tr>
                    <td colspan="6"> <label for="" class="encabezadoPrincipal">ORDEN DE CORTE</label>  </td>
                    <td colspan="3"> <label for="" class="encabezadoPrincipal">Vigencia desde: 20/09/2018</label> </td>
                </tr>
            </tr>

            <?php
            $infoTallas = json_decode($OrdenCorte->info_tallas,true);
            $result = [];
            foreach($infoTallas as $internal_array) {
                $result = array_merge($result, $internal_array);
            } 

            $total = 0;
            for($i=0;$i<=20;$i++){
                $total += $result[$i]['Cantidad'];
            }
            
            $Tallas = json_decode($OrdenCorte->tallas,true);
            $sumCantidad2 = array_sum($Tallas);
           
            ?>

            <!--PRIMERA FILA DE LA TABLA-->

            <tr>
                <td> <label for="" class="">COLECCIÓN</label> </td>
                <td> <label for="" class=""># CORTE</label> </td>
                <td> <label for="" class="">REFERENCIA</label> </td>
                <td> <label for="" class="">LETRA</label> </td>
                <td colspan="3" class="fondoDurazno"> <label for="" class="fondoDurazno">TELA</label> </td>
                <td> <label for="" class="">ANCHO</label> </td>
                <td> <label for="" class="">METROS REALES</label> </td>
                <td> <label for="" class="">PROMEDIO</label> </td>
                <td> <input type="text" class="camposF1" name="nombre" id="nombre" value="{{$OrdenCorte->nombre}}"> </td>
                <td> <input type="text" class="camposF1" name="porc" id="porc" value="{{$OrdenCorte->porc}}"> </td>
            </tr>

            <!--SEGUNDA FILA DE LA TABLA-->

            <tr>
                <td class="fondoVerde"> <input class="fondoVerde" type="text" name="coleccion" id="coleccion" value="{{$OrdenCorte->coleccion}}"> </td>
                <td> <input class="" type="text" name="ncorte" id="ncorte" value="{{$OrdenCorte->ncorte}}"> </td>
                <td> <input class="letraRoja" type="text" name="referencia" id="referencia" value="{{$OrdenCorte->referencia}}"> </td>
                <td> <input class="letraRoja" type="text" name="letra" id="letra" value="{{$OrdenCorte->letra}}"> </td>
                <td colspan="3"> 

                    <select class="cTela" name="tela" id="tela" class="form-control" tabindex="1">
                        <option selected value="{{$OrdenCorte->id_tela}}">{{$ntela[0]['tela']}}</option>
                        @foreach($telas as $tela)
                            @if($tela->estado == 0)
                                <option value="{{$tela['id']}}">{{$tela['tela']}}</option>
                            @endif
                        @endforeach
                    </select>

                    <button type="button" class="tela" data-toggle="modal" data-target="#ventanaModal">
                    <i class="fa fa-plus"></i>
                    </button> 

                </td>

                <div class="modal" id="ventanaModal" tabindex="-1" role="dialog" aria-labelledby="tituloVentana">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 id="tituloVentana" class="modal-title" name="name">Agregar Telas</h3>
                            </div>

                                <div class="modal-body">
                                    <label for="">Codigo Tela</label> <br>
                                    <input type="text" name="codtela" id="codtela" required> <br>
                                    <label for="">Tela</label> <br>
                                    <input type="text" name="nametela" id="nametela" required> <br>
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button id="agregarTela" type="button" class="btn btn-primary">Guardar</button>
                                </div>

                        </div>
                    </div>
                </div>

                
                <td> <input class="" type="number" name="ancho" id="ancho" value="{{$OrdenCorte->ancho}}"> </td>
                <td> <input type="number" name="" id="metros" disabled> </td>
                <td> <input type="number" name="" id="promedio" disabled> </td>
                <td class="fondoRosa"> <label class="fondoRosa" for="">LARGO T-2</label> </td>
                <td class="fondoRosa"> <label class="fondoRosa" for="">TENDIDA -2</label> </td>
            </tr>

            <!--TERCERA FILA DE LA TABLA-->

            <tr>
                <td rowspan="2" class="fondoAzulOscuro"> <label for="" class="fondoAzulOscuro">CANT CM2</label> </td>
                <td rowspan="2"> <span id="cantcm2"></span> </td>
                <td colspan="2"> <label class="" for="">DISEÑADOR</label> </td>
                <td> <label class="" for="">FECHA</label> </td>
                <td colspan="2" class="fondoAzulClaro"> <label class="fondoAzulClaro" for="">TELA BOLSILLO</label> </td>
                <td class="fondoAzulClaro"> <input class="fondoAzulClaro" name="tela_bolsillo" id="tela_bolsillo" value="{{$OrdenCorte->tela_bolsillo}}" type="text"> </td>
                <td class="fondoAzulClaro"> <input class="fondoAzulClaro" type="number" name="metroTB" id="metroTB"> </td>
                <td class="fondoAzulClaro"> <input class="fondoAzulClaro" type="number" name="promedioTB" id="promedioTB"> </td>
                <td class="fondoAzulClaro"> <input class="fondoAzulClaro telas" type="number" name="largot2_tela_bolsillo" id="largot2_tela_bolsillo" value="{{$OrdenCorte->largot2_tela_bolsillo}}"> </td>
                <td class="fondoAzulClaro"> <input class="fondoAzulClaro telas" type="number" name="tendida2_tela_bolsillo" id="tendida2_tela_bolsillo" value="{{$OrdenCorte->tendida2_tela_bolsillo}}"> </td>
            </tr>

            <!--CUARTA FILA DE LA TABLA-->

            <tr>
                <td colspan="2"> <input class="d" type="text" name="diseñador" id="diseñador" value="{{$OrdenCorte->diseñador}}"> </td>
                <td> <input class="letraAzul" type="date" name="fecha" id="fecha" value="{{$OrdenCorte->fecha}}"> </td>
                <td colspan="2" class="fondoAmarillo"> <label class="fondoAmarillo" for="">TELA DOS</label> </td>
                <td class="fondoAmarillo"> <input class="fondoAmarillo" name="tela_dos" id="tela_dos" value="{{$OrdenCorte->tela_dos}}" type=text></td>
                <td class="fondoAmarillo"> <input class="fondoAmarillo" type="number" name="metroTD" id="metroTD"> </td>
                <td class="fondoAmarillo"> <input class="fondoAmarillo" type="number" name="promedioTD" id="promedioTD"> </td>
                <td class="fondoAmarillo"> <input class="fondoAmarillo telas" type="number" name="largot2_tela_dos" id="largot2_tela_dos" value="{{$OrdenCorte->largot2_tela_dos}}"> </td>
                <td class="fondoAmarillo"> <input class="fondoAmarillo telas" type="number" name="tendida2_tela_dos" id="tendida2_tela_dos" value="{{$OrdenCorte->tendida2_tela_dos}}"> </td>
            </tr>

            <!--QUINTA FILA DE LA TABLA-->

            <tr>
                <td> <label for="">RIBETE</label> </td>
                <td> <input type="number" name="ribete" id="ribete" value="{{$OrdenCorte->ribete}}"> </td>
                <td colspan="2"> <label for="">TRAZO PASADORES</label> </td>
                <td> <input type="number" name="trazo_pasadores" id="trazo_pasadores" value="{{$OrdenCorte->trazo_pasadores}}"> </td>
                <td> <label for="">-</label> </td>
                <td> <label for="">-</label> </td>
                <td colspan="2"> <label for="">TRAZO ALETILLONES</label> </td>
                <td> <input type="number" name="trazo_aletillones" id="trazo_aletillones" value="{{$OrdenCorte->trazo_aletillones}}"> </td>
                <td> <label for="">-</label> </td>
                <td> <label for="">-</label> </td>
            </tr>

            <!--SEXTA FILA DE LA TABLA-->

            <tr>
                <td> <label for="">TENDIDOS</label> </td>
                <td> <input type="number" name="tendidos_1" id="tendidos_1" value="{{$OrdenCorte->tendidos_1}}"> </td>
                <td colspan="2"> <label for="">TENDIDOS</label> </td>
                <td> <input type="number" name="tendidos_2" id="tendidos_2" value="{{$OrdenCorte->tendidos_2}}"> </td>
                <td> <label for="">-</label> </td>
                <td> <label for="">-</label> </td>
                <td colspan="2"> <label for="">TENDIDOS</label> </td>
                <td> <input type="number" name="tendidos_3" id="tendidos_3" value="{{$OrdenCorte->tendidos_3}}"> </td>
                <td> <label for="">-</label> </td>
                <td> <label for="">-</label> </td>
            </tr>

            <!--SEPTIMA FILA DE LA TABLA-->

            <tr>
                <td colspan="6"> <input type="file" class="fotosPrendas" name="foto_D" id="foto_D" accept="imageD/*"> <img id="imagenPrevisualizacionD" src="{{ asset('storage').'/'.$OrdenCorte->foto_D }}"> </td>
                <td colspan="6"> <input type="file" class="fotosPrendas" name="foto_T" id="foto_T" accept="imageT/*"> <img id="imagenPrevisualizacionT" src="{{ asset('storage').'/'.$OrdenCorte->foto_T }}"> </td> 
            </tr>

            <!--OCTAVA FILA DE LA TABLA-->

            <tr>
                <td rowspan="2" colspan="2"> <input class="marca" type="text" name="marca" id="marca" value="{{$OrdenCorte->marca}}"> </td>
                    <td colspan="10"> <input class="california" type="text" name="especificacion1" id="especificacion1" value="{{$OrdenCorte->especificacion1}}"> </td>
                <tr>
                    <td colspan="10"> <input class="california" type="text" name="especificacion2" id="especificacion2" value="{{$OrdenCorte->especificacion2}}"> </td>
                </tr>
            </tr>
            
            <tr>
                <td> <label for="">LARGO</label></td>
                <td> <input type="number" step="any" class="negrita largo" name="largo1" id="largo1" value="{{ $result[0]['Largo'] }}"> </td>
                <td> <input type="number" step="any" class="negrita largo" name="largo2" id="largo2" value="{{ $result[1]['Largo'] }}"> </td>
                <td> <input type="number" step="any" class="negrita largo" name="largo3" id="largo3" value="{{ $result[2]['Largo'] }}"> </td>
                <td> <input type="number" step="any" class="negrita largo" name="largo4" id="largo4" value="{{ $result[3]['Largo'] }}"> </td>
                <td> <input type="number" step="any" class="negrita largo" name="largo5" id="largo5" value="{{ $result[4]['Largo'] }}"> </td>
                <td> <input type="number" step="any" class="negrita largo" name="largo6" id="largo6" value="{{ $result[5]['Largo'] }}"> </td>
                <td> <input type="number" step="any" class="negrita largo" name="largo7" id="largo7" value="{{ $result[6]['Largo'] }}"> </td>
                <td> <input type="number" step="any" class="negrita largo" name="largo8" id="largo8" value="{{ $result[7]['Largo'] }}"> </td>
                <td> <input type="number" step="any" class="negrita largo" name="largo9" id="largo9" value="{{ $result[8]['Largo'] }}"> </td>
                <td> <input type="number" step="any" class="negrita largo" name="largo10" id="largo10" value="{{ $result[9]['Largo'] }}"> </td>
                <td> <input type="number" step="any" class="negrita largo" name="largo11" id="largo11" value="{{ $result[10]['Largo'] }}"> </td>
            </tr>

            <tr>
                <td> <label for="">TALLAS</label> </td>
                <td> <input type="number" class="talla" name="talla1" id="talla1" value="{{ $result[0]['Talla'] }}"> </td>
                <td> <input type="number" class="talla" name="talla2" id="talla2" value="{{ $result[1]['Talla'] }}"> </td>
                <td> <input type="number" class="talla" name="talla3" id="talla3" value="{{ $result[2]['Talla'] }}"> </td>
                <td> <input type="number" class="talla" name="talla4" id="talla4" value="{{ $result[3]['Talla'] }}"> </td>
                <td> <input type="number" class="talla" name="talla5" id="talla5" value="{{ $result[4]['Talla'] }}"> </td>
                <td> <input type="number" class="talla" name="talla6" id="talla6" value="{{ $result[5]['Talla'] }}"> </td>
                <td> <input type="number" class="talla" name="talla7" id="talla7" value="{{ $result[6]['Talla'] }}"> </td>
                <td> <input type="number" class="talla" name="talla8" id="talla8" value="{{ $result[7]['Talla'] }}"> </td>
                <td> <input type="number" class="talla" name="talla9" id="talla9" value="{{ $result[8]['Talla'] }}"> </td>
                <td> <input type="number" class="talla" name="talla10" id="talla10" value="{{ $result[9]['Talla'] }}"> </td>
                <td> <input type="number" class="talla" name="talla11" id="talla11" value="{{ $result[10]['Talla'] }}"> </td>
            </tr>
            
            <tr>
                <td> <label for="">CANTIDAD</label> </td>
                <td> <input type="number" class="cant" name="cantidad1" id="cantidad1" value="{{ $result[0]['Cantidad'] }}"> </td>
                <td> <input type="number" class="cant" name="cantidad2" id="cantidad2" value="{{ $result[1]['Cantidad'] }}"> </td>
                <td> <input type="number" class="cant" name="cantidad3" id="cantidad3" value="{{ $result[2]['Cantidad'] }}"> </td>
                <td> <input type="number" class="cant" name="cantidad4" id="cantidad4" value="{{ $result[3]['Cantidad'] }}"> </td>
                <td> <input type="number" class="cant" name="cantidad5" id="cantidad5" value="{{ $result[4]['Cantidad'] }}"> </td>
                <td> <input type="number" class="cant" name="cantidad6" id="cantidad6" value="{{ $result[5]['Cantidad'] }}"> </td>
                <td> <input type="number" class="cant" name="cantidad7" id="cantidad7" value="{{ $result[6]['Cantidad'] }}"> </td>
                <td> <input type="number" class="cant" name="cantidad8" id="cantidad8" value="{{ $result[7]['Cantidad'] }}"> </td>
                <td> <input type="number" class="cant" name="cantidad9" id="cantidad9" value="{{ $result[8]['Cantidad'] }}"> </td>
                <td> <input type="number" class="cant" name="cantidad10" id="cantidad10" value="{{ $result[9]['Cantidad'] }}"> </td>
                <td> <input type="number" class="cant" name="cantidad11" id="cantidad11" value="{{ $result[10]['Cantidad'] }}"> </td>
            </tr>

            <tr>
                <td> <label for=""></label> </td>
                <td> <input type="text" name="info1" id="info1" value="{{ $result[0]['Informacion'] }}"> </td>
                <td> <input type="text" name="info2" id="info2" value="{{ $result[1]['Informacion'] }}"> </td>
                <td> <input type="text" name="info3" id="info3" value="{{ $result[2]['Informacion'] }}"> </td>
                <td> <input type="text" name="info4" id="info4" value="{{ $result[3]['Informacion'] }}"> </td>
                <td> <input type="text" name="info5" id="info5" value="{{ $result[4]['Informacion'] }}"> </td>
                <td> <input type="text" name="info6" id="info6" value="{{ $result[5]['Informacion'] }}"> </td>
                <td> <input type="text" name="info7" id="info7" value="{{ $result[6]['Informacion'] }}"> </td>
                <td> <input type="text" name="info8" id="info8" value="{{ $result[7]['Informacion'] }}"> </td>
                <td> <input type="text" name="info9" id="info9" value="{{ $result[8]['Informacion'] }}"> </td>
                <td> <input type="text" name="info10" id="info10" value="{{ $result[9]['Informacion'] }}"> </td>
                <td> <input type="text" name="info11" id="info11" value="{{ $result[10]['Informacion'] }}"> </td>
            </tr>

            <tr>
                <td> <label for="">LARGO</label> </td>
                <td> <input type="number" step="any" class="negrita largo" name="largo12" id="largo12" value="{{ $result[11]['Largo'] }}"> </td>
                <td> <input type="number" step="any" class="negrita largo" name="largo13" id="largo13" value="{{ $result[12]['Largo'] }}"> </td>
                <td> <input type="number" step="any" class="negrita largo" name="largo14" id="largo14" value="{{ $result[13]['Largo'] }}"> </td>
                <td> <input type="number" step="any" class="negrita largo" name="largo15" id="largo15" value="{{ $result[14]['Largo'] }}"> </td>
                <td> <input type="number" step="any" class="negrita largo" name="largo16" id="largo16" value="{{ $result[15]['Largo'] }}"> </td>
                <td> <input type="number" step="any" class="negrita largo" name="largo17" id="largo17" value="{{ $result[16]['Largo'] }}"> </td>
                <td> <input type="number" step="any" class="negrita largo" name="largo18" id="largo18" value="{{ $result[17]['Largo'] }}"> </td>
                <td> <input type="number" step="any" class="negrita largo" name="largo19" id="largo19" value="{{ $result[18]['Largo'] }}"> </td>
                <td> <input type="number" step="any" class="negrita largo" name="largo20" id="largo20" value="{{ $result[19]['Largo'] }}"> </td>
                <td> <input type="number" step="any" class="negrita largo" name="largo21" id="largo21" value="{{ $result[20]['Largo'] }}"> </td>
                <td> <label for="">-</label> </td>
            </tr>

            <tr>
                <td> <label for="">TALLAS</label> </td>
                <td> <input type="number" class="talla" name="talla12"" id="talla12" value="{{ $result[11]['Talla'] }}"> </td>
                <td> <input type="number" class="talla" name="talla13"" id="talla13" value="{{ $result[12]['Talla'] }}"> </td>
                <td> <input type="number" class="talla" name="talla14"" id="talla14" value="{{ $result[13]['Talla'] }}"> </td>
                <td> <input type="number" class="talla" name="talla15"" id="talla15" value="{{ $result[14]['Talla'] }}"> </td>
                <td> <input type="number" class="talla" name="talla16"" id="talla16" value="{{ $result[15]['Talla'] }}"> </td>
                <td> <input type="number" class="talla" name="talla17"" id="talla17" value="{{ $result[16]['Talla'] }}"> </td>
                <td> <input type="number" class="talla" name="talla18"" id="talla18" value="{{ $result[17]['Talla'] }}"> </td>
                <td> <input type="number" class="talla" name="talla19"" id="talla19" value="{{ $result[18]['Talla'] }}"> </td>
                <td> <input type="number" class="talla" name="talla20"" id="talla20" value="{{ $result[19]['Talla'] }}"> </td>
                <td> <input type="number" class="talla" name="talla21"" id="talla21" value="{{ $result[20]['Talla'] }}"> </td>
                <td> <label for="">TOTAL</label> </td>
            </tr>
            
            <tr>
                <td> <label for="">CANTIDAD</label> </td>
                <td> <input type="number" class="cant" name="cantidad12" id="cantidad12" value="{{ $result[11]['Cantidad'] }}"> </td>
                <td> <input type="number" class="cant" name="cantidad13" id="cantidad13" value="{{ $result[12]['Cantidad'] }}"> </td>
                <td> <input type="number" class="cant" name="cantidad14" id="cantidad14" value="{{ $result[13]['Cantidad'] }}"> </td>
                <td> <input type="number" class="cant" name="cantidad15" id="cantidad15" value="{{ $result[14]['Cantidad'] }}"> </td>
                <td> <input type="number" class="cant" name="cantidad16" id="cantidad16" value="{{ $result[15]['Cantidad'] }}"> </td>
                <td> <input type="number" class="cant" name="cantidad17" id="cantidad17" value="{{ $result[16]['Cantidad'] }}"> </td>
                <td> <input type="number" class="cant" name="cantidad18" id="cantidad18" value="{{ $result[17]['Cantidad'] }}"> </td>
                <td> <input type="number" class="cant" name="cantidad19" id="cantidad19" value="{{ $result[18]['Cantidad'] }}"> </td>
                <td> <input type="number" class="cant" name="cantidad20" id="cantidad20" value="{{ $result[19]['Cantidad'] }}"> </td>
                <td> <input type="number" class="cant" name="cantidad21" id="cantidad21" value="{{ $result[20]['Cantidad'] }}"> </td>
                <td> <input type="number" name="" id="spTotal" disabled> </td>
            </tr>

            <tr>
                <td> <label for=""></label> </td>
                <td> <input type="text" name="info12"" id="info12" value="{{ $result[11]['Informacion'] }}"> </td>
                <td> <input type="text" name="info13"" id="info13" value="{{ $result[12]['Informacion'] }}"> </td>
                <td> <input type="text" name="info14"" id="info14" value="{{ $result[13]['Informacion'] }}"> </td>
                <td> <input type="text" name="info15"" id="info15" value="{{ $result[14]['Informacion'] }}"> </td>
                <td> <input type="text" name="info16"" id="info16" value="{{ $result[15]['Informacion'] }}"> </td>
                <td> <input type="text" name="info17"" id="info17" value="{{ $result[16]['Informacion'] }}"> </td>
                <td> <input type="text" name="info18"" id="info18" value="{{ $result[17]['Informacion'] }}"> </td>
                <td> <input type="text" name="info19"" id="info19" value="{{ $result[18]['Informacion'] }}"> </td>
                <td> <input type="text" name="info20"" id="info20" value="{{ $result[19]['Informacion'] }}"> </td>
                <td> <input type="text" name="info21"" id="info21" value="{{ $result[20]['Informacion'] }}"> </td>
                <td> <input type="text" name="" id=""> </td>
            </tr>

            <tr class="fondoMostaza">
                <td> <label for="">4</label> </td>
                <td> <label for="">6</label> </td>
                <td> <label for="">8</label> </td>
                <td> <label for="">10</label> </td>
                <td> <label for="">12</label> </td>
                <td> <label for="">14</label> </td>
                <td> <label for="">16</label> </td>
                <td> <label for="">18</label> </td>
                <td> <label for="">20</label> </td>
                <td> <label for="">22</label> </td>
                <td> <label for="">24</label> </td>
                <td> <label for="">TOTAL</label> </td>
            </tr>

            <tr class="fondoAzul">
                <td> <input type="number" class="fondoAzul total1" id="n4"  value="0" disabled></td>
                <td> <input type="number" class="fondoAzul total1" id="n6"  value="0" disabled></td>
                <td> <input type="number" class="fondoAzul total1" id="n8"  value="0" disabled></td>
                <td> <input type="number" class="fondoAzul total1" id="n10" value="0" disabled></td>
                <td> <input type="number" class="fondoAzul total1" id="n12" value="0" disabled></td>
                <td> <input type="number" class="fondoAzul total1" id="n14" value="0" disabled></td>
                <td> <input type="number" class="fondoAzul total1" id="n16" value="0" disabled></td>
                <td> <input type="number" class="fondoAzul total1" id="n18" value="0" disabled></td>
                <td> <input type="number" class="fondoAzul total1" id="n20" value="0" disabled></td>
                <td> <input type="number" class="fondoAzul total1" id="n22" value="0" disabled></td>
                <td> <input type="number" class="fondoAzul total1" id="n24" value="0" disabled></td>
                <td> <span class="fondoAzul" id="Total1">0</span> </td>
            </tr>

            <tr>
                <td> <input type="number" class="total2" name="tallaN4" id="tallaN4" value="{{ $Tallas[0] }}"></td>
                <td> <input type="number" class="total2" name="tallaN6" id="tallaN6" value="{{ $Tallas[1] }}"></td>
                <td> <input type="number" class="total2" name="tallaN8" id="tallaN8" value="{{ $Tallas[2] }}"></td>
                <td> <input type="number" class="total2" name="tallaN10" id="tallaN10" value="{{ $Tallas[3] }}"></td>
                <td> <input type="number" class="total2" name="tallaN12" id="tallaN12" value="{{ $Tallas[4] }}"></td>
                <td> <input type="number" class="total2" name="tallaN14" id="tallaN14" value="{{ $Tallas[5] }}"></td>
                <td> <input type="number" class="total2" name="tallaN16" id="tallaN16" value="{{ $Tallas[6] }}"></td>
                <td> <input type="number" class="total2" name="tallaN18" id="tallaN18" value="{{ $Tallas[7] }}"></td>
                <td> <input type="number" class="total2" name="tallaN20" id="tallaN20" value="{{ $Tallas[8] }}"></td>
                <td> <input type="number" class="total2" name="tallaN22" id="tallaN22" value="{{ $Tallas[9] }}"></td>
                <td> <input type="number" class="total2" name="tallaN24" id="tallaN24" value="{{ $Tallas[10] }}"></td>
                <td> <span id="Total2">0</span> </td>
            </tr>

            <tr>
                <td> <input type="number" name="" id="difN4" disabled> </td>
                <td> <input type="number" name="" id="difN6" disabled> </td>
                <td> <input type="number" name="" id="difN8" disabled> </td>
                <td> <input type="number" name="" id="difN10" disabled> </td>
                <td> <input type="number" name="" id="difN12" disabled> </td>
                <td> <input type="number" name="" id="difN14" disabled> </td>
                <td> <input type="number" name="" id="difN16" disabled> </td>
                <td> <input type="number" name="" id="difN18" disabled> </td>
                <td> <input type="number" name="" id="difN20" disabled> </td>
                <td> <input type="number" name="" id="difN22" disabled> </td>
                <td> <input type="number" name="" id="difN24" disabled> </td>
                <td> <span id="difTotal3">0</span> </td>
            </tr>
        </table>
        </div>
        <br>
        <label for="">Seleccione los Rollos a utilizar para esta Orden de Corte (Tela - Salida - Tono - Ancho - Metros - Rollo)</label>
        <select multiple data-placeholder="Tela - Salida - Tono - Ancho - Metros - Rollo" style="width:1236px;" class="chosen-select" name="rollos[]" id="rollos">
            <?php
            $ids_rollos = json_decode($OrdenCorte->ids_rollos,true);
            ?>
            @for($i=0;$i<count($ids_rollos);$i++)
                @foreach($rollos as $rollo)
                    @if($rollo->id == $ids_rollos[$i])
                        <option value="{{$rollo->id}}" selected>{{$rollo->tela." - ".$rollo->salida." - ".$rollo->tono." - ".$rollo->ancho." - ".$rollo->metros." - ".$rollo->rollo}}</option>                   
                    @endif
                @endforeach
            @endfor
            
            @for($i=0;$i<count($gruporollos);$i++)
                <optgroup label="{{$gruporollos[$i]->tela}}">
                    @foreach($newconsulta as $newc)
                        @if($newc->tela == $gruporollos[$i]->tela)
                            <option value="{{$newc->id}}">{{$newc->tela." - ".$newc->salida." - ".$newc->tono." - ".$newc->ancho." - ".$newc->metros." - ".$newc->rollo}}</option>
                        @endif
                    @endforeach
                </optgroup>
            @endfor

        </select>
        

        <br><br>
        <a href="{{route('indexC')}}" class="btn btn-secondary" tabindex="3">Cancelar</a>
        @if($OrdenCorte->estado==0)
        <button type="submit" class="btn btn-primary" id="submitEditarCorte" tabindex="9">Guardar</button>
        @elseif($OrdenCorte->estado==1)
        <button type="button" class="btn btn-primary" disabled>Guardar</button>
        @endif
        </form>
</div>
</div>
</body>
@endsection

@push('scripts-custom')
<script src="{!! asset('https://unpkg.com/sweetalert/dist/sweetalert.min.js') !!}"></script>
<script src="{!! asset('https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js') !!}"></script>
<script src="{!! asset('https://cdn.jsdelivr.net/npm/lodash@4.17.11/lodash.min.js') !!}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://harvesthq.github.io/chosen/chosen.jquery.js"></script>
<script src="{!! asset('js/formEditCorte.js') !!}"></script>
<script>
    $(".chosen-select").chosen();

$(".chosen-select").on('change', function (event,el) {
  var selected_element = $(".chosen-select option:contains("+el.selected+")");
  var selected_value  = selected_element.val();
  var parent_optgroup = selected_element.closest('optgroup').attr('label');
  var parent_optgroup_class = selected_element.closest('optgroup').attr('class');
  $(".search-choice:last > span").css("background-color", parent_optgroup_class);
  selected_element.text(parent_optgroup+' - '+selected_value);
  
  //$(selected_element).addClass(`${parent_optgroup_class}`);
});
</script>
@endpush
