@extends('layouts.appp')

@push('custom-css')
<link rel="stylesheet" href="/css/edit_control_prendas.css">
<link href="https://harvesthq.github.io/chosen/chosen.css" rel="stylesheet"/>
<style>
    .chosen-container-single .chosen-single {
    font-size: 14px;
    font-family: Century Gothic;
    border-color: #ebedf2;
    padding: 0.6rem 1rem;
    height: calc(2.25rem + 2px);
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    background: #fff !important;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }
    .chosen-container-single .chosen-single .chosen-container-active .chosen-with-drop{
    width: 96,5%;
    }
    button, select {
    text-transform: none;
    }
</style>
@endpush

@section('content')
<div class="container-fluid mt-2">
    <div class="card" style=" font-family:Century Gothic;">
    <div class="card-header text-center" style="font-family:Century Gothic; background-color:#007bff; color:white; font-weigth:bold;">
    FORMULARIO DE EDICION DE PRENDAS NO CONFORMES DE CONFECCION
    </div>
        <div class="card-body">
            <div class="table-responsive">
<body>
    <form method="" action="" id="ctrlprendasForm" accept-charset="UTF-8" autocomplete="off">
        @csrf
        
        <input type="number" id="id" style="display: none" value="{{$prenda[0]['id']}}">

        <label for="">Fecha:</label> 
        <input type="date" class="" id="fecha" name="fecha" value="{{$prenda[0]['fecha']}}">

        <label for="">Proceso:</label>
        <select name="modulo" id="modulo" class="lista">
            <?php
            $mystring = $prenda[0]['modulo'];
            ?>
            @if( strpos($mystring, "Modulo") !== false )
            <option value="Modulos" selected>Modulos</option>
            @else
            <option value="{{$prenda[0]['modulo']}}" selected>{{$prenda[0]['modulo']}}</option>
            @endif
            <option value="Textilera">Textilera</option>
            <option value="Patronaje">Patronaje</option>
            <option value="Corte">Corte</option>
            <option value="Maquinas Especiales">Maquinas Especiales</option>
            <option value="Preparacion">Preparacion</option>
            <option value="Patinadores">Patinadores</option>
            <option value="Modulos">Modulos</option>
        </select>
        
        <label for="" class="lista mod">Modulo:</label>
        <select name="modulos" id="modulos" class="lista mod">
            @if( strpos($mystring, "Modulo") !== false )
            <option value="{{$prenda[0]['modulo']}}" selected>{{$prenda[0]['modulo']}}</option>
            @else
            <option value="" selected disabled>Seleccione un Modulo</option>
            @endif
            <option value="Modulo 01">Modulo 01</option>
            <option value="Modulo 02">Modulo 02</option>
            <option value="Modulo 03">Modulo 03</option>
            <option value="Modulo 04">Modulo 04</option>
            <option value="Modulo 05">Modulo 05</option>
            <option value="Modulo 06">Modulo 06</option>
            <option value="Modulo 07">Modulo 07</option>
            <option value="Modulo 08">Modulo 08</option>
            <option value="Modulo 09">Modulo 09</option>
            <option value="Modulo 10">Modulo 10</option>
            <option value="Modulo 11">Modulo 11</option>
            <option value="Modulo Multifuncional">Modulo Multifuncional</option>
            
        </select>

        <label for="">Referencia Lote:</label><br>
        <!--
        <input type="text" id="referencia" name="referencia" class="">
        <input type="number" id="id_refe" style="display: none">
        -->
        <select id="referencia" class="chosen-select" data-placeholder="Seleccione una Referencia" style="width:98,5%;" onchange="ShowSelected();">
            <option value="" selected disabled></option>
            @foreach($referencias as $referencia)
                @if($prenda[0]['id_referencia'] == $referencia->id)
                <option value="{{$referencia->id}}" selected>{{$referencia->lote_referencia}}</option>
                @else
                <option value="{{$referencia->id}}">{{$referencia->lote_referencia}}</option>
                @endif
            @endforeach
        </select>

        <label for="">Cantidad Lote:</label> 
        <input type="number" class="" id="cant_lote" name="cant_lote" value="{{$prenda[0]['cant_lote']}}" disabled>

        <label for="">Cantidad de Muestra a Revisar:</label> 
        <input type="number" class="" id="cant_rev" name="cant_rev" value="{{$prenda[0]['cant_muestra_rev']}}" disabled>
        
        <div id="accordionGroup" class="accordion">
            <br>
            <h3 id="textilera">
              <button type="button" aria-expanded="false" class="accordion-trigger" aria-controls="sect1" id="accordion1id">
                <label for="">Textilera<span class="accordion-icon"></span></label>
              </button>
            </h3>
            <div id="sect1" role="region" aria-labelledby="accordion1id" class="accordion-panel" hidden> <div>

                    <label for="">Marra:</label>
                    <input type="number" value="{{$prenda[0]['text_marra']}}" id="marra">

                    <label for="">Mancha:</label>
                    <input type="number" value="{{$prenda[0]['text_mancha']}}" id="mancha">

                    <label for="">Dos Tonos:</label>
                    <input type="number" value="{{$prenda[0]['text_dos_tonos']}}" id="dos_tonos">

            </div>
        </div>

            <h3 id="patronaje">
              <button type="button" aria-expanded="false" class="accordion-trigger" aria-controls="sect2" id="accordion2id">
                <label for="">Patronaje<span class="accordion-icon"></span></label>
              </button>
            </h3>
            <div id="sect2" role="region" aria-labelledby="accordion2id" class="accordion-panel" hidden> <div>

                    <label for="">Tamaño de Piezas:</label>
                    <input type="number" value="{{$prenda[0]['patro_t_piezas']}}" id="t_piezas">

              </div>
            </div>

            <h3 id="corte">
                <button type="button" aria-expanded="false" class="accordion-trigger" aria-controls="sect3" id="accordion3id">
                  <label for="">Corte<span class="accordion-icon"></span></label>
                </button>
              </h3>
              <div id="sect3" role="region" aria-labelledby="accordion3id" class="accordion-panel" hidden> <div>
  
                      <label for="">Piezas mal Cortadas:</label>
                      <input type="number" value="{{$prenda[0]['corte_piezas_mcor']}}" id="piezas_mcor">
  
                </div>
              </div>

            <h3 id="maquinas">
                <button type="button" aria-expanded="false" class="accordion-trigger" aria-controls="sect4" id="accordion4id">
                  <label for="">Maquinas Especiales<span class="accordion-icon"></span></label>
                </button>
              </h3>
              <div id="sect4" role="region" aria-labelledby="accordion4id" class="accordion-panel" hidden> <div>
  
                      <label for="">Bota:</label>
                      <input type="number" value="{{$prenda[0]['maqui_bota']}}" id="bota">

                      <label for="">Pretina:</label>
                      <input type="number" value="{{$prenda[0]['maqui_pretina']}}" id="pretina">

                      <label for="">Presilla:</label>
                      <input type="number" value="{{$prenda[0]['maqui_presilla']}}" id="presilla">

                      <label for="">Ojal:</label>
                      <input type="number" value="{{$prenda[0]['maqui_ojal']}}" id="ojal">

                      <label for="">Mol:</label>
                      <input type="number" value="{{$prenda[0]['maqui_mol']}}" id="mol">
                      
                      <label for="">Cotilla:</label>
                      <input type="number" value="{{$prenda[0]['maqui_cotilla']}}" id="mecotilla">
                      
                      <label for="">Cola:</label>
                      <input type="number" value="{{$prenda[0]['maqui_cola']}}" id="mecola">
                    
                </div>
              </div>
              
              <h3 id="preparacion">
                <button type="button" aria-expanded="false" class="accordion-trigger" aria-controls="sect5" id="accordion5id">
                  <label for="">Preparacion<span class="accordion-icon"></span></label>
                </button>
              </h3>
              <div id="sect5" role="region" aria-labelledby="accordion5id" class="accordion-panel" hidden> <div>
  
                      <label for="">Pinza:</label>
                      <input type="number" value="{{$prenda[0]['prepa_pinza']}}" id="prepa_pinza">

                      <label for="">Embonada de Relojera:</label>
                      <input type="number" value="{{$prenda[0]['prepa_relojera']}}" id="prepa_relojera">
                      
                      <label for="">Embonada de Parche:</label>
                      <input type="number" value="{{$prenda[0]['prepa_parche']}}" id="prepa_parche">
                      
                      <label for="">Cerradora:</label>
                      <input type="number" value="{{$prenda[0]['prepa_cerra']}}" id="prepa_cerra">
                      
                      <label for="">Parchadora:</label>
                      <input type="number" value="{{$prenda[0]['prepa_parcha']}}" id="prepa_parcha">

                </div>
              </div>
              
              <h3 id="patinadores">
                <button type="button" aria-expanded="false" class="accordion-trigger" aria-controls="sect6" id="accordion6id">
                  <label for="">Patinadores<span class="accordion-icon"></span></label>
                </button>
              </h3>
              <div id="sect6" role="region" aria-labelledby="accordion6id" class="accordion-panel" hidden> <div>
  
                      <label for="">Marcacion Caida de Parche:</label>
                      <input type="number" value="{{$prenda[0]['patin_caida_parche']}}" id="caida_parche">

                      <label for="">Marcacion de Parche:</label>
                      <input type="number" value="{{$prenda[0]['patin_marc_parche']}}" id="marc_parche">
                      
                      <label for="">Marcado de Pinza:</label>
                      <input type="number" value="{{$prenda[0]['patin_marc_pinza']}}" id="marc_pinza">
                      
                      <label for="">Marcado en Moda:</label>
                      <input type="number" value="{{$prenda[0]['patin_marc_moda']}}" id="marc_moda">
                      
                      <label for="">Suministro de Insumos:</label>
                      <input type="number" value="{{$prenda[0]['patin_sumn_ins']}}" id="sumn_ins">

                </div>
              </div>
              
              <h3 id="modul">
                <button type="button" aria-expanded="false" class="accordion-trigger" aria-controls="sect7" id="accordion7id">
                  <label for="">Modulos<span class="accordion-icon"></span></label>
                </button>
              </h3>
              <div id="sect7" role="region" aria-labelledby="accordion7id" class="accordion-panel" hidden> <div>
  
                      <label for="">Cierre:</label>
                      <input type="number" value="{{$prenda[0]['mod_cierre']}}" id="cierre">

                      <label for="">Cola:</label>
                      <input type="number" value="{{$prenda[0]['mod_cola']}}" id="cola">

                      <label for="">Costura Bolsillo Posterior:</label>
                      <input type="number" value="{{$prenda[0]['mod_cos_bolsillo_pos']}}" id="cbp">

                      <label for="">Costura Costado:</label>
                      <input type="number" value="{{$prenda[0]['mod_cos_costado']}}" id="ccos">

                      <label for="">Costura Cotilla:</label>
                      <input type="number" value="{{$prenda[0]['mod_cos_cotilla']}}" id="ccot">

                      <label for="">Costura de Pretina:</label>
                      <input type="number" value="{{$prenda[0]['mod_cos_pretina']}}" id="cpre">

                      <label for="">Costura Jota:</label>
                      <input type="number" value="{{$prenda[0]['mod_cos_jota']}}" id="cjot">

                      <label for="">Costura Parche:</label>
                      <input type="number" value="{{$prenda[0]['mod_cos_parche']}}" id="cpar">

                      <label for="">Costura Pinza:</label>
                      <input type="number" value="{{$prenda[0]['mod_cos_pinza']}}" id="cpin">

                      <label for="">Costura Reboque:</label>
                      <input type="number" value="{{$prenda[0]['mod_cos_reboque']}}" id="creb">

                      <label for="">Costura Ribete:</label>
                      <input type="number" value="{{$prenda[0]['mod_cos_ribete']}}" id="crib">

                      <label for="">Costura Vista:</label>
                      <input type="number" value="{{$prenda[0]['mod_cos_vista']}}" id="cvis">

                      <label for="">Embonado de Parche:</label>
                      <input type="number" value="{{$prenda[0]['mod_embonado_parche']}}" id="embparche">

                      <label for="">Filete de Costado:</label>
                      <input type="number" value="{{$prenda[0]['mod_filete_costado']}}" id="fcos">

                      <label for="">Filete de Entrepierna:</label>
                      <input type="number" value="{{$prenda[0]['mod_filete_entrepierna']}}" id="fentp">

                      <label for="">Punta:</label>
                      <input type="number" value="{{$prenda[0]['mod_punta']}}" id="punta">

                      <label for="">Relojera:</label>
                      <input type="number" value="{{$prenda[0]['mod_relojera']}}" id="relojera">

                      <label for="">Roto:</label>
                      <input type="number" value="{{$prenda[0]['mod_roto']}}" id="roto">

                      <label for="">Tiro:</label>
                      <input type="number" value="{{$prenda[0]['mod_tiro']}}" id="tiro">

                </div>
              </div>
            

        <br>
        <label for="">Total Prendas no Conforme:</label><br>
        <input type="number" id="total_pno_conf" value="{{$prenda[0]['total_pno_conforme']}}" class="" disabled>

        <label for="">Total Arreglos Modulos:</label><br>
        <input type="number" id="total_arr_mod" value="{{$prenda[0]['total_arreglos_mod']}}" class="" disabled>

        <br><br>
        <a href="{{route('list_prendas_hoy')}}" class="btn btn-secondary" >Cancelar</a>
        <button type="button" class="btn btn-primary" id="agregar_ctrlp">Guardar</button>
    </form>
</body>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts-custom')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{asset('js/edit_control_prendas.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://harvesthq.github.io/chosen/chosen.jquery.js"></script>
<script>
$(".chosen-select").chosen();
$(".chosen-select").chosen({no_results_text:'No hay resultados para '});

</script>
@endpush