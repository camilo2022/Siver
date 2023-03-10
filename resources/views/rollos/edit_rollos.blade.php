@extends('layouts.appp')

@push('custom-css')
<link href="https://harvesthq.github.io/chosen/chosen.css" rel="stylesheet"/>
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
    .swal-modal .swal-text {
    text-align: center;
    }
    .chosen-select{
    width: 100%;
    }
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
    width: 96.5%;
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
    FORMULARIO DE EDICION DE ROLLOS
    </div>
        <div class="card-body">
            <div class="table-responsive">
<body>
    <form method="" action="" id="rolloForm" accept-charset="UTF-8" autocomplete="off">
        @csrf
        <input type="number" class="" id="id" name="id" value="{{$rollo[0]['id']}}" style="display: none">

        <label for="">Proveedor:</label> 
        <input type="text" class="" id="proveedor" name="proveedor" value="{{$rollo[0]['proveedor']}}">

        <label for="">Fecha Entrada:</label> 
        <input type="date" class="" id="fecha_e" name="fecha_e" value="{{$rollo[0]['fecha_entrada']}}">

        <label for="">Tela:</label> 
        <!--
        <input type="text" class="" id="tela" name="tela" value="{{$rollo[0]['tela']}}">
        -->
        <select class="chosen-select" data-placeholder="Seleccione una Tela" id="tela">
            <option value=""></option>
            @foreach($telas as $tela)
                @if($rollo[0]['tela'] == $tela->tela)
                    <option value="{{$rollo[0]['tela']}}" selected>{{$rollo[0]['tela']}}</option>
                @else
                <option value="{{$tela->tela}}">{{$tela->tela}}</option>
                @endif
            @endforeach
        </select>
        <br>

        <label for="">Tipo:</label> 
        <input type="text" class="" id="tipo" name="tipo" value="{{$rollo[0]['tipo']}}">

        <label for="">Rollo:</label> 
        <input type="number" class="" id="rollo" name="rollo" value="{{$rollo[0]['rollo']}}">

        <label for="">Ancho:</label> 
        <input type="number" class="" id="ancho" name="ancho" value="{{$rollo[0]['ancho']}}">

        <label for="">Metros:</label> 
        <input type="number" class="" id="metros" name="metros" value="{{$rollo[0]['metros']}}">

        <label for="">Tono:</label> 
        <input type="text" class="" id="tono" name="tono" value="{{$rollo[0]['tono']}}">
        
        <label for="">Fecha Salida:</label> 
        <input type="date" class="" id="fecha_s" name="fecha_s" value="{{$rollo[0]['fecha_salida']}}">

        <label for="">Salida:</label> 
        <input type="number" class="" id="salida" name="salida" value="{{$rollo[0]['salida']}}">

        <label for="">Observacion:</label> 
        <textarea id="observacion" name="observacion" rows="3">{{$rollo[0]['observacion']}}</textarea>

        <br><br>
        <a href="{{route('list_rollos')}}" class="btn btn-secondary" >Cancelar</a>
        <button type="button" class="btn btn-primary" id="agregar_rollo">Guardar</button>
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
</script>
<script>
    function getAbsolutePath() {
    var loc = window.location;
    var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
    return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
  }
$(document).ready(function(){

    $("#agregar_rollo").click(function() {
    var id = $("#id").val();
    var URLdominio = getAbsolutePath();
    var url = URLdominio + id + "/rollos_update";
    var proveedor = $("#proveedor").val();
    var fecha_e = $("#fecha_e").val();
    var tela = $("#tela").val();
    var tipo = $("#tipo").val();
    var rollo = $("#rollo").val();
    var ancho = $("#ancho").val();
    var metros = $("#metros").val();
    var tono = $("#tono").val();
    var fecha_s = $("#fecha_s").val();
    var salida = $("#salida").val();
    var observacion = $("#observacion").val();
    if(fecha_e == ""){
          swal("??Cuidado!", "El campo Fecha Entrada es requerido.", "warning"); 
    }else if(tela == ""){
          swal("??Cuidado!", "El campo Tela es requerido.", "warning"); 
    }else if(tipo == ""){
          swal("??Cuidado!", "El campo Tipo es requerido.", "warning"); 
    }else if(rollo == ""){
          swal("??Cuidado!", "El campo Rollo es requerido.", "warning"); 
    }else if(ancho == ""){
          swal("??Cuidado!", "El campo Ancho es requerido.", "warning"); 
    }else if(metros == ""){
          swal("??Cuidado!", "El campo Metros es requerido.", "warning"); 
    }else if(tono == ""){
          swal("??Cuidado!", "El campo Tono es requerido. Si la tela no tiene tono, coloque ST para especificar que no tiene tono.", "warning"); 
    }else if(salida == ""){
          swal("??Cuidado!", "El campo Salida es requerido.", "warning"); 
    }else{
    $.ajax({
          url: url,
          type: 'GET',
          data: {
            id: id,
            proveedor: proveedor,
            fecha_e: fecha_e,
            tela: tela,
            tipo: tipo,
            rollo: rollo,
            ancho: ancho,
            metros: metros,
            tono: tono,
            fecha_s: fecha_s,
            salida: salida,
            observacion: observacion,
          },
          dataType: 'json',
          success: function(data){  
            if(data==1){
                window.location = "http://siversoftware.zarethpremium.com/rollos/list";
            }
        }
          });

    }
});
})
</script>
@endpush
