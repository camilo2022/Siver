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
    select { 
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
    textarea{
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
            FORMULARIO ORDEN PICKING
          </div>
        <div class="card-body">
            <div class="table-responsive">
<body>
    <form method="" action="{{route('store_orden_picking')}}" id="ordenPickingForm" accept-charset="UTF-8" autocomplete="off">
        <label for="">Orden Picking:</label> 
        <input type="text" class="" id="orden" name="orden" value="{{$newconsecutivo}}">

        <label for="" class="tipo">Tipo de Referencia</label> 
        <select name="tipo" id="tipo" class="tipo">
            <option value="" selected disabled>Seleccione</option>
            <option value="REF">Referencia</option>
            <option value="REF-T">Referencia-Tono</option>
            <option value="SKU">Sku</option>
        </select>

        <label for="">Referencia:</label> 
        <input type="text" class="" id="referencia" name="referencia" placeholder="Si ha seleccionado sku escribalos separados por comas. Por ejemplo: 51234, 51235">
        
        <label for="">Observacion:</label> 
        <textarea id="observacion" name="observacion" rows="3"></textarea>
        
        <br><br>
        <a href="" class="btn btn-secondary" >Cancelar</a>
        <button type="submit" class="btn btn-primary" id="submitCrear">Guardar</button>
    </form>
</body>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts-custom')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function(){
        $("#submitCrear").click(function(event){
            event.preventDefault()
            if($("#orden").val() == ""){
            swal("¡Error!", "Ingrese la Orden de Picking.", "error");
            }else if($("#tipo").val() == "" ){
                swal("¡Error!", "Seleccione el tipo.", "error");
            }else if($("#referencia").val() == "" ){
                swal("¡Error!", "Ingrese la referencia.", "error");
            }else if($("#observacion").val() == "" ){
                swal("¡Error!", "Escriba una observacion.", "error");
            }else{
                $('#ordenPickingForm').submit();
            }
        })
    })
</script>
@endpush