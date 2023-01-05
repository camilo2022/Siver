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
    .swal-modal .swal-text {
    text-align: center;
    }
    .chosen-container-multi .chosen-choices li.search-field input[type="text"]{
    font-family: Century Gothic !important;
    color: #686868 !important;
    }
    .chosen-container-multi .chosen-choices {
    font-size: 14px !important;
    font-family: Century Gothic !important;
    border-color: #ebedf2 !important;
    padding: 0.6rem 1rem !important;
    height: calc(2.25rem + 2px) !important;
    padding: 0.375rem 0.75rem !important;
    font-size: 1rem !important;
    line-height: 1.5 !important;
    color: #495057 !important;
    background: #fff !important;
    background-clip: padding-box !important;
    border: 1px solid #ced4da !important;
    border-radius: 0.25rem !important;
    width: 100% !important;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out !important;
    }
    .chosen-container-single .chosen-single .chosen-container-active .chosen-with-drop{
    width: 100% !important;
    }
    .chosen-container-single .chosen-single {
    font-size: 14px !important;
    font-family: Century Gothic !important;
    border-color: #ebedf2 !important;
    padding: 0.6rem 1rem !important;
    height: calc(2.25rem + 2px) !important;
    padding: 0.375rem 0.75rem !important;
    font-size: 1rem !important;
    line-height: 1.5 !important;
    color: #495057 !important;
    background: #fff !important;
    background-clip: padding-box !important;
    border: 1px solid #ced4da !important;
    border-radius: 0.25rem !important;
    width: 100 !important;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out !important;
    }
    .chosen-container-single .chosen-single .chosen-container-active .chosen-with-drop{
    width: 100% !important;
    }
</style>
<link href="https://harvesthq.github.io/chosen/chosen.css" rel="stylesheet"/>
@endpush

@section('content')
<div class="container-fluid mt-2">
    <div class="card" style=" font-family:Century Gothic;">
    <div class="card-header text-center" style="font-family:Century Gothic; background-color:#007bff; color:white; font-weigth:bold;">
    FORMULARIO DE CREACIÓN MASIVO PREPARACION
    </div>
        <div class="card-body">
            <div class="table-responsive">
<body onload="miFuncion('{{$errors->first()}}');"> 
    <form method="" action="{{route('store_preparacion_masivo')}}" id="terminacionForm" accept-charset="UTF-8" autocomplete="off">
        <label for="">Fecha:</label> 
        <input type="date" class="fecha" id="fecha" name="fecha" value="{{$fecha}}">

        <label for="">Turno:</label> 
        <select name="turno" id="turno" class="lista">
            <option value="" selected disabled>Seleccione Turno</option>
            <option value="1">Turno 1</option>
            <option value="2">Turno 2</option>
        </select>
        
        <label for="">Modulo:</label>
        <select name="modulo" id="modulo" class="lista">
            <option value="" selected disabled>Seleccione Modulo</option>
            <option value="Embonar Parche">Embonar Parche</option>
            <option value="Embonar Relojera">Embonar Relojera</option>
            <option value="Pinzas">Pinzas</option>
            <option value="Cotilla">Cotilla</option>
            <option value="Cola">Cola</option>
            <option value="Parchado">Parchado</option>
        </select>

        <label for="">Horas:</label>
        <select multiple data-placeholder="Seleccione las Horas" style="width:100%;" class="chosen-select chosen-select-multiple" name="hora[]" id="hora">
            <option value=""></option>
            <option value="1">Hora 01</option>
            <option value="2">Hora 02</option>
            <option value="3">Hora 03</option>
            <option value="4">Hora 04</option>
            <option value="5">Hora 05</option>
            <option value="6">Hora 06</option>
            <option value="7">Hora 07</option>
            <option value="8">Hora 08</option>
            <option value="9">Hora 09</option>
            <option value="10">Hora 10</option>
            <option value="11">Hora 11</option>
            <option value="12">Hora 12</option>
        </select>

        <label for="">Operario:</label><br>
        <select id="empleado" name="empleado" class="chosen-select" data-placeholder="Seleccione un Operario" style="width:100%;">
            <option value=""></option>
                @foreach($empleados as $empleado)
                <option value="{{$empleado->id}}">{{$empleado->nombres." ".$empleado->apellidos." - ".$empleado->documento}}</option>
                @endforeach
        </select>

        <label for="">Referencia:</label><br>
        <select id="referencia" name="referencia" class="chosen-select" data-placeholder="Seleccione una Referencia" style="width:100%;">
            <option value="" selected disabled></option>
            @foreach($referencias as $referencia)
                <option value="{{$referencia->id}}">{{$referencia->lote_referencia}}</option>
            @endforeach
            
        </select>

        <label for="">Tiempo de Ciclo:</label>
        <input type="number" id="tc" name="tc" class="">

        <label for="">Tipo:</label>
        <select name="tipo" id="tipo" class="lista">
            <option value="" selected disabled>Seleccione Tipo</option>
            <option value="Clasico">Clasico</option>
            <option value="Moda">Moda</option>
        </select>
        
        <label for="">Numero de Operarios:</label>
        <input type="number" id="n_operarios" name="n_operarios" class="">
       
        <br><br>
        <a href="{{route('list_preparacion')}}" class="btn btn-secondary" >Cancelar</a>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://harvesthq.github.io/chosen/chosen.jquery.js"></script>
<script>
$(".chosen-select").chosen();
$(".chosen-select").chosen({no_results_text:'No hay resultados para '});

$(".chosen-select").on('change', function (event,el) {
  var selected_element = $(".chosen-select option:contains("+el.selected+")");
  var selected_value  = selected_element.val();
  var parent_optgroup = selected_element.closest('optgroup').attr('label');
  var parent_optgroup_class = selected_element.closest('optgroup').attr('class');
  $(".search-choice:last > span").css("background-color", parent_optgroup_class);
  selected_element.text(parent_optgroup+' - '+selected_value);
  
  //$(selected_element).addClass(`${parent_optgroup_class}`);
});

function miFuncion(message){
 if(message != ""){
    swal("¡Oops!", message, "error");
 }
}
$(document).ready(function(){

    $("#submitCrear").click(function(event){
        event.preventDefault()
        if( $("#fecha").val() == "" ){
            swal("¡Error!", "El campo Fecha es requerido.", "error");
        }else if( document.getElementById("turno").value == "" ){
            swal("¡Error!", "Seleccione un turno.", "error");
        }else if( document.getElementById("modulo").value == "" ){
            swal("¡Error!", "Seleccione un modulo.", "error");
        }else if( document.getElementById("hora").value == "" ){
            swal("¡Error!", "Seleccione las horas.", "error");
        }else if( document.getElementById("empleado").value == ""){
            swal("¡Error!", "Seleccione un empleado.", "error");
        }else if( document.getElementById("referencia").value == ""){
            swal("¡Error!", "Seleccione una referencia.", "error");
        }else if( $("#tc").val() == "" ){
            swal("¡Error!", "El campo Tiempo de Ciclo es requerido.", "error");
        }else if( $("#n_operarios").val() == "" ){
            swal("¡Error!", "El campo Tiempo de Ciclo es requerido.", "error");
        }else if( document.getElementById("tipo").value == "" ){
            swal("¡Error!", "Seleccione un tipo.", "error");
        }else{
            $('#terminacionForm').submit();
        }
    })

    $("#modulo").click(function(){
        var modulo = $("#modulo").val();
        $("#cantidad").val("")
        if(modulo == "Embonar Parche"){
            $("#tc").val(21);
        }else if(modulo == "Embonar Relojera"){
            $("#tc").val(8);
        }else if(modulo == "Pinzas"){
            $("#tc").val(60);
        }else if(modulo == "Cotilla"){
            $("#tc").val(24);
        }else if(modulo == "Cola"){
            $("#tc").val(24);
        }else if(modulo == "Parchado"){
            $("#tc").val(45);
        }
    })
})
</script>
@endpush