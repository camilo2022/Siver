@extends('layouts.appp')

@push('custom-css')
<link rel="stylesheet" href="/css/form_control_prendas.css">
<style>
    input { 
    font-size: 14px;
    border-color: #ebedf2;
    padding: 0.6rem 1rem;
    height: inherit !important;
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
<div class="container-fluid mt-2">
    <div class="card" style=" font-family:Century Gothic;">
    <div class="card-header text-center" style="font-family:Century Gothic; background-color:#007bff; color:white; font-weigth:bold;">
    FORMULARIO DE EDICION DE REFERENCIAS
    </div>
        <div class="card-body">
            <div class="table-responsive">
<body>
    <form method="" action="" id="referenciaForm" accept-charset="UTF-8" autocomplete="off">
        @csrf
        <input type="number" class="" id="id" name="id" value="{{$referencia[0]['id']}}" style="display: none">

        <label for="">Referencia:</label> 
        <input type="text" class="" id="refe" name="refe" value="{{$referencia[0]['referencia']}}">

        <label for="">Lote:</label> 
        <input type="text" class="" id="lote" name="lote" value="{{$referencia[0]['lote_referencia']}}">

        <label for="">Cantidad Lote:</label> 
        <input type="number" class="" id="cant_lote" name="cant_lote" value="{{$referencia[0]['cantidad_lote']}}">
        
        <div id="accordionGroup" class="accordion">
            <br>
            <h3 id="preparacion">
              <button type="button" aria-expanded="false" class="accordion-trigger" aria-controls="sect1" id="accordion1id">
                <label for="">Preparacion<span class="accordion-icon"></span></label>
              </button>
            </h3>
            <div id="sect1" role="region" aria-labelledby="accordion1id" class="accordion-panel" hidden> <div>

        <label for="">Cantidad Disponible Preparacion Embonar Parche:</label> 
        <input type="number" class="" id="cant_prep_emb_prc" name="cant_prep_emb_prc" value="{{$referencia[0]['cantidad_disponible_preparacion_emb_prc']}}">
        
        <label for="">Cantidad Disponible Preparacion Embonar Relojera:</label> 
        <input type="number" class="" id="cant_prep_emb_rlj" name="cant_prep_emb_rlj" value="{{$referencia[0]['cantidad_disponible_preparacion_emb_rlj']}}">
        
        <label for="">Cantidad Disponible Preparacion Pinzas:</label> 
        <input type="number" class="" id="cant_prep_pin" name="cant_prep_pin" value="{{$referencia[0]['cantidad_disponible_preparacion_pin']}}">
        
        <label for="">Cantidad Disponible Preparacion Cotilla:</label> 
        <input type="number" class="" id="cant_prep_cot" name="cant_prep_cot" value="{{$referencia[0]['cantidad_disponible_preparacion_cot']}}">
        
        <label for="">Cantidad Disponible Preparacion Cola:</label> 
        <input type="number" class="" id="cant_prep_col" name="cant_prep_col" value="{{$referencia[0]['cantidad_disponible_preparacion_col']}}">
        
        <label for="">Cantidad Disponible Preparacion Parchado:</label> 
        <input type="number" class="" id="cant_prep_prc" name="cant_prep_prc" value="{{$referencia[0]['cantidad_disponible_preparacion_prc']}}">
        
            </div>
        </div>
        
        <h3 id="confeccion">
              <button type="button" aria-expanded="false" class="accordion-trigger" aria-controls="sect2" id="accordion2id">
                <label for="">Confeccion<span class="accordion-icon"></span></label>
              </button>
            </h3>
            <div id="sect2" role="region" aria-labelledby="accordion2id" class="accordion-panel" hidden> <div>

        <label for="">Cantidad Disponible Confeccion:</label> 
        <input type="number" class="" id="cant_conf" name="cant_conf" value="{{$referencia[0]['cantidad_disponible_confeccion']}}">
        
            </div>
        </div>
        
        <h3 id="ensamble">
              <button type="button" aria-expanded="false" class="accordion-trigger" aria-controls="sect3" id="accordion3id">
                <label for="">Ensamble<span class="accordion-icon"></span></label>
              </button>
            </h3>
            <div id="sect3" role="region" aria-labelledby="accordion3id" class="accordion-panel" hidden> <div>
        
        <label for="">Cantidad Disponible Ensamble Pretina:</label> 
        <input type="number" class="" id="cant_ensa_prt" name="cant_ensa_prt" value="{{$referencia[0]['cantidad_disponible_ensamble_prt']}}">
        
        <label for="">Cantidad Disponible Ensamble Punta:</label> 
        <input type="number" class="" id="cant_ensa_pnt" name="cant_ensa_pnt" value="{{$referencia[0]['cantidad_disponible_ensamble_pnt']}}">
        
        <label for="">Cantidad Disponible Ensamble Bota:</label> 
        <input type="number" class="" id="cant_ensa_bot" name="cant_ensa_bot" value="{{$referencia[0]['cantidad_disponible_ensamble_bot']}}">
        
        <label for="">Cantidad Disponible Ensamble Bota Plana:</label> 
        <input type="number" class="" id="cant_ensa_bot_pln" name="cant_ensa_bot_pln" value="{{$referencia[0]['cantidad_disponible_ensamble_bot_pln']}}">
        
        <label for="">Cantidad Disponible Ensamble Presilla:</label> 
        <input type="number" class="" id="cant_ensa_prs" name="cant_ensa_prs" value="{{$referencia[0]['cantidad_disponible_ensamble_prs']}}">
        
        <label for="">Cantidad Disponible Ensamble Pasador Presilla:</label> 
        <input type="number" class="" id="cant_ensa_pas_prs" name="cant_ensa_pas_prs" value="{{$referencia[0]['cantidad_disponible_ensamble_pas_prs']}}">
        
        <label for="">Cantidad Disponible Ensamble Pasador Mol:</label> 
        <input type="number" class="" id="cant_ensa_pas_mol" name="cant_ensa_pas_mol" value="{{$referencia[0]['cantidad_disponible_ensamble_pas_mol']}}">
        
        <label for="">Cantidad Disponible Ensamble Ojal:</label> 
        <input type="number" class="" id="cant_ensa_ojal" name="cant_ensa_ojal" value="{{$referencia[0]['cantidad_disponible_ensamble_ojal']}}">
        
        <label for="">Cantidad Disponible Ensamble Revision:</label> 
        <input type="number" class="" id="cant_ensa_rvs" name="cant_ensa_rvs" value="{{$referencia[0]['cantidad_disponible_ensamble_rvs']}}">
        
        <label for="">Cantidad Disponible Ensamble Revision Ext:</label> 
        <input type="number" class="" id="cant_ensa_rvs_ext" name="cant_ensa_rvs_ext" value="{{$referencia[0]['cantidad_disponible_ensamble_rvs_ext']}}">
        
        <label for="">Cantidad Disponible Ensamble Revision Presilla:</label> 
        <input type="number" class="" id="cant_ensa_rvs_prs" name="cant_ensa_rvs_prs" value="{{$referencia[0]['cantidad_disponible_ensamble_rvs_prs']}}">
        
            </div>
        </div>
        
        <h3 id="terminacion">
              <button type="button" aria-expanded="false" class="accordion-trigger" aria-controls="sect4" id="accordion4id">
                <label for="">Terminacion<span class="accordion-icon"></span></label>
              </button>
            </h3>
            <div id="sect4" role="region" aria-labelledby="accordion4id" class="accordion-panel" hidden> <div>
        
        <label for="">Cantidad Disponible Terminacion Despeluzado:</label> 
        <input type="number" class="" id="cant_term_des" name="cant_term_des" value="{{$referencia[0]['cantidad_disponible_terminacion_des']}}">
        
        <label for="">Cantidad Disponible Terminacion Taches:</label> 
        <input type="number" class="" id="cant_term_tac" name="cant_term_tac" value="{{$referencia[0]['cantidad_disponible_terminacion_tac']}}">
        
        <label for="">Cantidad Disponible Terminacion Plana:</label> 
        <input type="number" class="" id="cant_term_pla" name="cant_term_pla" value="{{$referencia[0]['cantidad_disponible_terminacion_pla']}}">
        
        <label for="">Cantidad Disponible Terminacion Meson:</label> 
        <input type="number" class="" id="cant_term_mes" name="cant_term_mes" value="{{$referencia[0]['cantidad_disponible_terminacion_mes']}}">
        
            </div>
        </div>
        
        <label for="">Tiempo de Ciclo:</label> 
        <input type="number" class="" id="tc_refe" name="tc_refe" value="{{$referencia[0]['tc']}}">
        
        <br><br>
        <a href="{{route('list_referencias')}}" class="btn btn-secondary" >Cancelar</a>
        <button type="button" class="btn btn-primary" id="actu_refe">Guardar</button>
    </form>
</body>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts-custom')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{asset('js/edit_referencia.js')}}"></script>
@endpush