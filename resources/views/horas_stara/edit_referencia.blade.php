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
    FORMULARIO DE EDICION DE REFERENCIAS STARA
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
<script src="{{asset('js/edit_referencia_stara.js')}}"></script>
@endpush