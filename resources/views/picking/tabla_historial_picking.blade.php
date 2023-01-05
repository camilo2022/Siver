@extends('layouts.appp')

@push('custom-css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<style>
    button.dt-button, div.dt-button, a.dt-button, input.dt-button {
    padding: 0;
    border: none;
    }
</style>
@endpush

@section('content')
<div class="container-fluid mt-2">
    <div class="card" style=" font-family:Century Gothic;">
      <div class="card-header text-center" style="font-family:Century Gothic; background-color:#007bff; color:white; font-weigth:bold;">
        HISTORIAL PICKING RECHAZADO
      </div>
        <div class="card-body">
            <div class="table-responsive">
<table id="mydatatable-container" class="table" style="width:100%">
    <thead class="">
        <tr>
          <th scope="col">Id</th>
          <th scope="col">Orden Picking</th>
          <th scope="col">Tipo Referencia</th>
          <th scope="col">Referencia</th>
          <th scope="col">Fecha Picking Terminacion</th>
          <th scope="col">Usuario Picking Terminacion</th>
          <th scope="col">Observacion Terminacion</th>
          <th scope="col">Fecha Picking Bodega</th>
          <th scope="col">Usuario Picking Bodega</th>
          <th scope="col">Observacion Bodega</th>
          <th scope="col">Creacion de Orden</th>
          <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
      @forEach($historial as $history)
      <tr>
        <td>{{$history->id}}</td>
        <td>{{$history->orden_picking}}</td>
        <td>{{$history->tipo_referencia}}</td>
        <td>{{$history->referencia}}</td>
        <td>{{$history->fecha_picking_terminacion}}</td>
        <td>{{$history->user_name_terminacion." ".$history->user_apellido_terminacion}}</td>
        <td>{{$history->observacion_terminacion}}</td>
        <td>{{$history->fecha_picking_bodega}}</td>
        <td>{{$history->user_name_bodega." ".$history->user_apellido_bodega}}</td>
        <td>{{$history->observacion_bodega}}</td>
        <td>{{$history->created_at}}</td>
        <td>
          <a type="button" class="" data-toggle="modal" data-target="#modal" onClick="datos('{{$history->id}}','{{$history->created_at}}');" style="cursor: pointer;"><span class="badge badge-info"><i class="fa fa-solid fa-eye"></i></span></a>
        </td>
    </tr>
      @endforeach
    </tbody>
    
</table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                          <table id="mydatatable_consulta" class="table" style="margin: auto;">
                              <thead class="">
                                  <tr>
                                      <th scope="col">Id</th>
                                      <th scope="col">Orden Picking</th>
                                      <th scope="col">Proceso</th>
                                      <th scope="col">Usuario</th>
                                      <th scope="col">Item</th>
                                      <th scope="col">Cantidad</th>
                                      <th scope="col">Fecha Creacion</th>
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
    
function datos(id, fecha){
    $('#mydatatable_consulta').DataTable().destroy().draw();
    var URLdominio = getAbsolutePath();
    var url = URLdominio + "rechazados/consulta";
        $.ajax({
            url: url,
            type: 'GET',
            data: {
              id: id,
              fecha: fecha
            },
            dataType: 'json',
            success: function(data){
                $(document).ready(function(){
                    $('#mydatatable_consulta').DataTable({
                        dom: 'Blfrtip',
                        buttons: [{
                        extend: 'excel',
                        footer: true,
                        title: 'Organización Bless',
                        filename: "Historial Picking Orden: "+data[0]['orden_picking'],
                        text: '<i class="fa fa-file-excel"></i>'
                      },
                      {
                        extend: 'pdf',
                        footer: true,
                        title: 'Organización Bless',
                        filename: "Historial Picking Orden: "+data[0]['orden_picking'],
                        text: '<i class="fa fa-file-pdf"></i>'
                      }]
                    });
                })
                $("#body").html("");
                  for(var i=0; i<data.length; i++){
                    
                    var tr = `<tr>
                      <td>`+data[i].id+`</td>
                      <td>`+data[i].orden_picking+`</td>
                      <td>`+data[i].proceso+`</td>
                      <td>`+data[i].user_name+" "+data[i].user_apellido+`</td>
                      <td>`+data[i].item+`</td>
                      <td>`+data[i].cantidad+`</td>
                      <td>`+data[i].created_at+`</td>
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
        filename: 'Historial Picking Rechazados',

        //Aquí es donde generas el botón personalizado
        text: '<i class="fa fa-light fa-file-excel"></i>'
      },
      //Botón para PDF
      {
        extend: 'pdf',
        footer: true,
        title: 'Organización Bless',
        filename: 'Historial Picking Rechazados',
        text: '<i class="fa fa-file-pdf"></i>'
      },
      {
        extend: 'print',
        footer: true,
        title: 'Organizacion Bless',
        filename: 'Historial Picking Rechazados',
        text: '<i class="fa fa-light fa-print"></i>'
      }
    ]
        });
    });
</script>    

@endpush