@extends('layouts.appp')

@push('custom-css')
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
    FORMULARIO DE CREACIÓN DE REFERENCIAS
    </div>
        <div class="card-body">
            <div class="table-responsive">
<body>
    <form method="" action="" id="referenciaForm" accept-charset="UTF-8" autocomplete="off">
        @csrf
        <label for="">Referencia:</label> 
        <input type="text" class="" id="refe" name="refe">

        <label for="">Lote:</label> 
        <input type="text" class="" id="lote" name="lote">

        <label for="">Cantidad Lote:</label> 
        <input type="number" class="" id="cant_lote" name="cant_lote">
        
        <label for="">Tiempo de Ciclo:</label> 
        <input type="number" class="" id="tc_refe" name="tc_refe">
        
        <br><br>
        <a href="{{route('list_referencias')}}" class="btn btn-secondary" >Cancelar</a>
        <button type="button" class="btn btn-primary" id="agregar_refe">Guardar</button>
    </form>
</body>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts-custom')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{asset('js/form_referencia.js')}}"></script>
@endpush