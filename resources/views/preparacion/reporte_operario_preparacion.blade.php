@extends('layouts.appp')

@push('custom-css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<style>
    .modal-lg { 
    max-width: 80% !important; 
    }
</style>
@endpush

@section('content')
<div class="container-fluid mt-2">
    <div class="card" style=" font-family:Century Gothic;">
    <div class="card-header text-center" style="font-family:Century Gothic; background-color:#007bff; color:white; font-weigth:bold;">
    REPORTE POR OPERARIO DE PREPARACION
    </div>
        <div class="card-body">
            <div class="table-responsive">
<table id="mydatatable-container" class="table" style="width:100%">
    <thead class="">
        <tr>
            <th scope="col">Fecha</th>
            <th scope="col">Turno</th>
            <th scope="col">Operario</th>
            <th scope="col">CC</th>
            <th scope="col">100 %</th>
            <th scope="col">% Eficiencia</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
      @foreach($consultas as $consulta)
        <tr>
          <td>{{$consulta->fecha}}</td>
          <td>{{$consulta->turno}}</td>
          <td>{{$consulta->nombres." ".$consulta->apellidos}}</td>
          <td>{{$consulta->cantidad}}</td>
          <td>{{$consulta->meta_produccion}}</td>
          @if($consulta->eficiencia>=0 && $consulta->eficiencia<70)
            <td><span class="badge badge-danger">{{number_format($consulta->eficiencia,2, ',', '.')}} %</span></td>
           @elseif($consulta->eficiencia>=70 && $consulta->eficiencia<80)
            <td><span class="badge badge-warning">{{number_format($consulta->eficiencia,2, ',', '.')}} %</span></td>
           @elseif($consulta->eficiencia>=80 && $consulta->eficiencia<100)
            <td><span class="badge badge-success">{{number_format($consulta->eficiencia,2, ',', '.')}} %</span></td>
           @else
            <td><span class="badge badge-primary">{{number_format($consulta->eficiencia,2, ',', '.')}} %</span></td>
           @endif
          <td>
                <a type="button" class="" data-toggle="modal" data-target=".bd-example-modal-lg" onClick="dataUser('{{$consulta->fecha}}','{{$consulta->turno}}','{{$consulta->id_empleado}}','{{$consulta->nombres}}','{{$consulta->apellidos}}');" style="cursor: pointer;"><span class="badge badge-info"><i class="fa fa-solid fa-eye"></i></span></a>
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
    
function dataUser(fecha, turno, id_empleado, nombres, apellidos){
    $('#mydatatable').DataTable().destroy().draw();
    var URLdominio = getAbsolutePath();
    var url = URLdominio + "operario/consulta";
        $.ajax({
            url: url,
            type: 'GET',
            data: {
            fecha: fecha,
            turno: turno,
            id_empleado: id_empleado
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
                        filename: "'"+nombres+" "+apellidos+" "+fecha+"'",
                
                        //Aquí es donde generas el botón personalizado
                        text: '<i class="fa fa-file-excel"></i>'
                      },
                      //Botón para PDF
                      {
                        extend: 'pdf',
                        footer: true,
                        title: 'Organización Bless',
                        filename: "'"+nombres+" "+apellidos+" "+fecha+"'",
                        text: '<i class="fa fa-file-pdf"></i>'
                      }]
                    });
                })
                var efic = "";
                $("#body").html("");
                  for(var i=0; i<data.length; i++){
                    if(data[i].eficiencia>=0 && data[i].eficiencia<70){
                        efic = "badge badge-danger";
                    }else if(data[i].eficiencia>70 && data[i].eficiencia<80){
                        efic = "badge badge-warning";
                    }
                    else if(data[i].eficiencia>=80 && data[i].eficiencia<100){
                        efic = "badge badge-success";
                    }
                    else{
                        efic = "badge badge-primary";
                    }
                    var tallas = data[i].tallas==null ? " " : data[i].tallas
                    var parada_p = data[i].parada_programada==null ? " " : data[i].parada_programada
                    var t_parada_p = data[i].tiempo_parada_programada==null ? 0 : data[i].tiempo_parada_programada
                    var parada_np = data[i].parada_no_programada==null ? " " : data[i].parada_no_programada
                    var t_parada_np = data[i].tiempo_noprg==null ? 0 : data[i].tiempo_noprg
                    
                    var tr = `<tr>
                      <td>`+data[i].id+`</td>
                      <td>`+data[i].fecha+`</td>
                      <td>`+data[i].turno+`</td>
                      <td>`+data[i].modulo+`</td>
                      <td>`+data[i].nombres+` `+data[i].apellidos+`</td>
                      <td><span class="badge badge-info">`+data[i].referencia+`</span></td>
                      <td>`+tallas+`</td>
                      <td>`+data[i].tc+`</td>
                      <td>`+data[i].tipo+`</td>
                      <td>Hora`+data[i].hora+`</td>
                      <td>`+data[i].cantidad+`</td>
                      <td>`+data[i].tiempo_req_h+`</td>
                      <td>`+data[i].meta_produccion+`</td>
                      <td><span class="`+efic+`">`+data[i].eficiencia+` %</span></td>
                      <td>`+data[i].n_operarios+`</td>
                      <td>`+parada_p+`</td>
                      <td>`+t_parada_p+`</td>
                      <td>`+parada_np+`</td>
                      <td>`+t_parada_np+`</td>
                    </tr>`;
                    $("#body").append(tr)
                    
                  }
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
        filename: 'Reporte Ensamble Operarios',

        //Aquí es donde generas el botón personalizado
        text: '<i class="fa fa-light fa-file-excel"></i>'
      },
      //Botón para PDF
      {
        extend: 'pdf',
        footer: true,
        title: 'Organización Bless',
        filename: 'Reporte Ensamble Operarios',
        text: '<i class="fa fa-file-pdf"></i>'
      },
      {
        extend: 'print',
        footer: true,
        title: 'Organizacion Bless',
        filename: 'Reporte Preparacion Operarios',
        text: '<i class="fa fa-light fa-print"></i>'
      }
    ]
        });
    });
</script>    
@endpush