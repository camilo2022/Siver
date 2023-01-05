@extends('layouts.appp')

@push('custom-css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<style>
    button.dt-button, div.dt-button, a.dt-button, input.dt-button {
    padding: 0;
    border: none;
    }
    .not-active { 
    pointer-events: none; 
    cursor: default; 
    } 
    .modal-lg { 
    max-width: 80% !important; 
    }
</style>
@endpush

@section('content')
<div class="container-fluid mt-2">
    <div class="card" style=" font-family:Century Gothic;">
    <div class="card-header text-center" style="font-family:Century Gothic; background-color:#007bff; color:white; font-weigth:bold;">
    TABLA DE REFERENCIAS STARA
    </div>
        <div class="card-body">
            <div class="table-responsive">
<table id="mydatatable-container" class="table" style="width:100%">
    <thead class="">
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Referencia</th>
            <th scope="col">Lote Referencia</th>
            <th scope="col">Cantidad Lote</th>
            <th scope="col">Confeccion</th>
            <th scope="col">Tiempo de Ciclo</th>
            <th scope="col">Acciones</th>

        </tr>
    </thead>
    <tbody>
      @foreach($referencias as $referencia)
        <tr>
            <td>{{$referencia->id}}</td>
            <td>{{$referencia->referencia}}</td>
            <td><span class="badge badge-info">{{$referencia->lote_referencia}}</span></td>
            <td>{{$referencia->cantidad_lote}}</td>
            <td>{{$referencia->cantidad_disponible_confeccion}}</td>
            <td>{{$referencia->tc}}</td>
            
            <td>
            @if(Auth::user()->rol->slug != 'RVREF')
                <a href="{{route('edit_referencias_stara',$referencia->id)}}" class=""><span class="badge badge-info"><i class="fa fa-solid fa-marker"></i></span>
            @else
                <a href="" class="not-active"><span class="badge badge-info"><i class="fa fa-solid fa-marker"></i></span>
            @endif
                <a type="button" class="" data-toggle="modal" data-target=".bd-example-modal-lg" onClick="data('{{$referencia->id}}','{{$referencia->lote_referencia}}');" style="cursor: pointer;"><span class="badge badge-success"><i class="fa fa-solid fa-eye"></i></span></a>
                <label style="width:100px;"></label>
           </td>
            
        </tr>
        @endforeach
    </tbody>
</table>
                </div>
            </div>
        </div>
    </div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#0058ff; color:white;">
                <h5 class="modal-title" id="exampleModalLongTitle">Registros Correspondientes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <div class="card-body">
                    <div class="table-responsive">    
                        <table id="mydatatable" class="table" style="margin: auto;">
                            <thead class="">
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Turno</th>
                                    <th scope="col">Proceso</th>
                                    <th scope="col">Modulo</th>
                                    <th scope="col">Operario</th>
                                    <th scope="col">Referencia</th>
                                    <th scope="col">Tallas</th>
                                    <th scope="col">TC</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Hora</th>
                                    <th scope="col">CC</th>
                                    <th scope="col">Tiempo</th>
                                    <th scope="col">100 %</th>
                                    <th scope="col">% Eficiencia</th>
                                    <th scope="col">N° Operarios</th>
                                    <th scope="col">Tipo PP</th>
                                    <th scope="col">Tiempo PP</th>
                                    <th scope="col">Tipo PNP</th>
                                    <th scope="col">Tiempo PNP</th>
                                </tr>
                            </thead>
                            <tbody id="body">
                                
                            </tbody>
                        </table>
                    </div>
                </div>    
            </div>
            <div class="modal-footer"><button type="button" class="btn" data-dismiss="modal" style="background-color: rgb(0, 88, 255); color: white;">Close</button></div>
        </div>
    </div>
</div>
@endsection

@push('scripts-custom')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/v/bs4-4.1.1/dt-1.10.18/datatables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js" type="text/javascript"></script>
<script>
function getAbsolutePath() {
      var loc = window.location;
      var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
      return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
    }
    
function data(id,refe){
    $('#mydatatable').DataTable().destroy().draw();
    var URLdominio = getAbsolutePath();
    var url = URLdominio + "list/consulta";
        $.ajax({
            url: url,
            type: 'GET',
            data: {
            id:id
            },
            dataType: 'json',
            success: function(data){
                $(document).ready(function(){
                    $('#mydatatable').DataTable({
                        dom: 'Blfrtip',
                        buttons: [{
                        //Botón para Excel
                        extend: 'excel',
                        footer: true,
                        title: 'Organización Bless',
                        filename: "'"+refe+"'",
                
                        //Aquí es donde generas el botón personalizado
                        text: '<i class="fa fa-file-excel"></i>'
                      },
                      //Botón para PDF
                      {
                        extend: 'pdf',
                        footer: true,
                        title: 'Organización Bless',
                        filename: "'"+refe+"'",
                        text: '<i class="fa fa-file-pdf"></i>'
                      }]
                    });
                })
                var efic = "";
                var modulo = "";
                $("#body").html("");
                  /*for(var i=0; i<data[0].length; i++){
                    if(data[0][i].eficiencia>=0 && data[0][i].eficiencia<70){
                        efic = "badge badge-danger";
                    }else if(data[0][i].eficiencia>70 && data[0][i].eficiencia<80){
                        efic = "badge badge-warning";
                    }else if(data[0][i].eficiencia>=80 && data[0][i].eficiencia<100){
                        efic = "badge badge-success";
                    }else{
                        efic = "badge badge-primary";}
                    var tallas = data[0][i].tallas==null ? " " : data[0][i].tallas
                    var parada_p = data[0][i].parada_prg==null ? " " : data[0][i].parada_prg
                    var t_parada_p = data[0][i].tiempo_parada_prg==null ? 0 : data[0][i].tiempo_parada_prg
                    var parada_np = data[0][i].parada_no_prg==null ? " " : data[0][i].parada_no_prg
                    var t_parada_np = data[0][i].tiempo_noprg==null ? 0 : data[0][i].tiempo_noprg
                    
                    var tr = `<tr>
                      <td>`+data[0][i].id+`</td>
                      <td>`+data[0][i].fecha+`</td>
                      <td>`+data[0][i].turno+`</td>
                      <td>Ensamble</td>
                      <td>`+data[0][i].modulo+`</td>
                      <td>`+data[0][i].nombres+` `+data[0][i].apellidos+`</td>
                      <td><span class="badge badge-info">`+data[0][i].referencia+`</span></td>
                      <td>`+tallas+`</td>
                      <td>`+data[0][i].tc+`</td>
                      <td>`+data[0][i].tipo+`</td>
                      <td>Hora`+data[0][i].hora+`</td>
                      <td>`+data[0][i].cantidad+`</td>
                      <td>`+data[0][i].tiempo_req_h+`</td>
                      <td>`+data[0][i].meta_produccion+`</td>
                      <td><span class="`+efic+`">`+data[0][i].eficiencia+` %</span></td>
                      <td>`+data[0][i].n_operarios+`</td>
                      <td>`+parada_p+`</td>
                      <td>`+t_parada_p+`</td>
                      <td>`+parada_np+`</td>
                      <td>`+t_parada_np+`</td>
                    </tr>`;
                    $("#body").append(tr)
                    
                  }
                  for(var i=0; i<data[1].length; i++){
                    if(data[1][i].eficiencia>=0 && data[1][i].eficiencia<70){
                        efic = "badge badge-danger";
                    }else if(data[1][i].eficiencia>70 && data[1][i].eficiencia<80){
                        efic = "badge badge-warning";
                    }else if(data[1][i].eficiencia>=80 && data[1][i].eficiencia<100){
                        efic = "badge badge-success";
                    }else{
                        efic = "badge badge-primary";}
                    var tallas = data[1][i].tallas==null ? " " : data[1][i].tallas
                    var parada_p = data[1][i].parada_prg==null ? " " : data[1][i].parada_prg
                    var t_parada_p = data[1][i].tiempo_parada_prg==null ? 0 : data[1][i].tiempo_parada_prg
                    var parada_np = data[1][i].parada_no_prg==null ? " " : data[1][i].parada_no_prg
                    var t_parada_np = data[1][i].tiempo_noprg==null ? 0 : data[1][i].tiempo_noprg
                    
                    var tr = `<tr>
                      <td>`+data[1][i].id+`</td>
                      <td>`+data[1][i].fecha+`</td>
                      <td>`+data[1][i].turno+`</td>
                      <td>Preparacion</td>
                      <td>`+data[1][i].modulo+`</td>
                      <td>`+data[1][i].nombres+` `+data[1][i].apellidos+`</td>
                      <td><span class="badge badge-info">`+data[1][i].referencia+`</span></td>
                      <td>`+tallas+`</td>
                      <td>`+data[1][i].tc+`</td>
                      <td>`+data[1][i].tipo+`</td>
                      <td>Hora`+data[1][i].hora+`</td>
                      <td>`+data[1][i].cantidad+`</td>
                      <td>`+data[1][i].tiempo_req_h+`</td>
                      <td>`+data[1][i].meta_produccion+`</td>
                      <td><span class="`+efic+`">`+data[1][i].eficiencia+` %</span></td>
                      <td>`+data[1][i].n_operarios+`</td>
                      <td>`+parada_p+`</td>
                      <td>`+t_parada_p+`</td>
                      <td>`+parada_np+`</td>
                      <td>`+t_parada_np+`</td>
                    </tr>`;
                    $("#body").append(tr)
                    
                  }*/
                  for(var i=0; i<data[0].length; i++){
                    if(data[0][i].eficiencia>=0 && data[0][i].eficiencia<70){
                        efic = "badge badge-danger";
                    }else if(data[0][i].eficiencia>70 && data[0][i].eficiencia<80){
                        efic = "badge badge-warning";
                    }else if(data[0][i].eficiencia>=80 && data[0][i].eficiencia<100){
                        efic = "badge badge-success";
                    }else{
                        efic = "badge badge-primary";}
                    var tallas = data[0][i].tallas==null ? " " : data[0][i].tallas
                    var parada_p = data[0][i].parada_prg==null ? " " : data[0][i].parada_prg
                    var t_parada_p = data[0][i].tiempo_parada_prg==null ? 0 : data[0][i].tiempo_parada_prg
                    var parada_np = data[0][i].parada_no_prg==null ? " " : data[0][i].parada_no_prg
                    var t_parada_np = data[0][i].tiempo_noprg==null ? 0 : data[0][i].tiempo_noprg
                    var modulo = data[0][i].modulo>0 ? 'Modulo STARA '+ data[0][i].modulo : 'Modulo STARA Pilotos'
                    
                    var tr = `<tr>
                      <td>`+data[0][i].id+`</td>
                      <td>`+data[0][i].fecha+`</td>
                      <td>`+data[0][i].turno+`</td>
                      <td>Confeccion</td>
                      <td>`+modulo+`</td>
                      <td></td>
                      <td><span class="badge badge-info">`+data[0][i].referencia+`</span></td>
                      <td>`+tallas+`</td>
                      <td>`+data[0][i].tc+`</td>
                      <td>`+data[0][i].tipo+`</td>
                      <td>Hora`+data[0][i].hora+`</td>
                      <td>`+data[0][i].cantidad+`</td>
                      <td>`+data[0][i].tiempo_req_h+`</td>
                      <td>`+data[0][i].meta_produccion+`</td>
                      <td><span class="`+efic+`">`+data[0][i].eficiencia+` %</span></td>
                      <td>`+data[0][i].n_operarios+`</td>
                      <td>`+parada_p+`</td>
                      <td>`+t_parada_p+`</td>
                      <td>`+parada_np+`</td>
                      <td>`+t_parada_np+`</td>
                    </tr>`;
                    $("#body").append(tr)
                    
                  }/*
                  for(var i=0; i<data[3].length; i++){
                    if(data[3][i].eficiencia>=0 && data[3][i].eficiencia<70){
                        efic = "badge badge-danger";
                    }else if(data[3][i].eficiencia>70 && data[3][i].eficiencia<80){
                        efic = "badge badge-warning";
                    }else if(data[3][i].eficiencia>=80 && data[3][i].eficiencia<100){
                        efic = "badge badge-success";
                    }else{
                        efic = "badge badge-primary";}
                    
                    if(data[3][i].modulo==1){
                        modulo = "Despeluzado";
                    }else if(data[3][i].modulo==2){
                        modulo = "Taches";}
                    else if(data[3][i].modulo==3){
                        modulo = "Taches";}
                    else{
                        modulo = "Meson";}
                    
                    var tallas = data[3][i].tallas==null ? " " : data[3][i].tallas
                    var parada_p = data[3][i].parada_prg==null ? " " : data[3][i].parada_prg
                    var t_parada_p = data[3][i].tiempo_parada_prg==null ? 0 : data[3][i].tiempo_parada_prg
                    var parada_np = data[3][i].parada_no_prg==null ? " " : data[3][i].parada_no_prg
                    var t_parada_np = data[3][i].tiempo_noprg==null ? 0 : data[3][i].tiempo_noprg
                    
                    var tr = `<tr>
                      <td>`+data[3][i].id+`</td>
                      <td>`+data[3][i].fecha+`</td>
                      <td>`+data[3][i].turno+`</td>
                      <td>Terminacion</td>
                      <td>Modulo `+modulo+`</td>
                      <td></td>
                      <td><span class="badge badge-info">`+data[3][i].referencia+`</span></td>
                      <td>`+tallas+`</td>
                      <td>`+data[3][i].tc+`</td>
                      <td>`+data[3][i].tipo+`</td>
                      <td>Hora`+data[3][i].hora+`</td>
                      <td>`+data[3][i].cantidad+`</td>
                      <td>`+data[3][i].tiempo_req_h+`</td>
                      <td>`+data[3][i].meta_produccion+`</td>
                      <td><span class="`+efic+`">`+data[3][i].eficiencia+` %</span></td>
                      <td>`+data[3][i].n_operarios+`</td>
                      <td>`+parada_p+`</td>
                      <td>`+t_parada_p+`</td>
                      <td>`+parada_np+`</td>
                      <td>`+t_parada_np+`</td>
                    </tr>`;
                    $("#body").append(tr)
                    
                  }*/
            }
        });
}
    $(document).ready(function(){
        $('#mydatatable-container').DataTable({
          dom: 'Blfrtip',
        buttons: [{
        extend: 'copy',
        footer: true,
        title: 'Organización Bless',
        filename: 'Date Copy',
        text: '<i class="fa fa-light fa-copy"></i>'
      },
      {
        //Botón para Excel
        extend: 'excel',
        footer: true,
        title: 'Organización Bless',
        filename: 'Referencias STARA',

        //Aquí es donde generas el botón personalizado
        text: '<i class="fa fa-light fa-file-excel"></i>'
      },
      //Botón para PDF
      {
        extend: 'pdf',
        footer: true,
        title: 'Organización Bless',
        filename: 'Referencias STARA',
        text: '<i class="fa fa-file-pdf"></i>'
      },
      {
        extend: 'print',
        footer: true,
        title: 'Organizacion Bless',
        filename: 'Referencias STARA',
        text: '<i class="fa fa-light fa-print"></i>'
      }
    ]
        });
    });
</script>    

@endpush