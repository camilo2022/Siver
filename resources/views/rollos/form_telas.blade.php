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
    .swal-modal .swal-text {
    text-align: center;
    }
    
</style>

@endpush

@section('content')
<div class="container-fluid mt-2">
    <div class="card" style=" font-family:Century Gothic;">
    <div class="card-header text-center" style="font-family:Century Gothic; background-color:#007bff; color:white; font-weigth:bold;">
    FORMULARIO DE CREACION DE TELAS
    </div>
        <div class="card-body">
            <div class="table-responsive">
<body>
    <form method="" action="" id="referenciaForm" accept-charset="UTF-8" autocomplete="off">
        @csrf
        <label for="">Codigo:</label> 
        <input type="text" class="" id="codigo" name="codigo">

        <label for="">Tela:</label> 
        <input type="text" class="" id="tela" name="tela">
  
        <br><br>
        <a href="{{route('list_telas')}}" class="btn btn-secondary" >Cancelar</a>
        <button type="button" class="btn btn-primary" id="agregar_tela">Guardar</button>
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

//$(".chosen-select").chosen();
//$(".chosen-select").chosen({no_results_text:'No hay resultados para '});

    function getAbsolutePath() {
    var loc = window.location;
    var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
    return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
  }
$(document).ready(function(){

    $("#agregar_tela").click(function() {
    var URLdominio = getAbsolutePath();
    var url = URLdominio + "telas_store";
    
    var codigo = $("#codigo").val();
    var tela = $("#tela").val();
    console.log(codigo)
    if(codigo == ""){
          swal("¡Cuidado!", "El campo Codigo es Requerido.", "warning"); 
    }else if(tela == ""){
          swal("¡Cuidado!", "El campo Tela es Requerido.", "warning"); 
    }else{
    $.ajax({
          url: url,
          type: 'GET',
          data: {
            codigo: codigo,
            tela: tela,
          },
          dataType: 'json',
          success: function(data){  
                swal("¡Bien!", "Datos guardados con Exito", "success"); 
                $("#codigo").val("");
                $("#tela").val("");
            },
          error: function(jqXHR,error, errorThrown){
                swal("¡Error!", "No se guardaron los datos Ingresados.", "error");
                }
          });

    }
    });
})
</script>
@endpush