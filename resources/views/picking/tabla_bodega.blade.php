@extends('layouts.appp')

@push('custom-css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<style>
    button.dt-button, div.dt-button, a.dt-button, input.dt-button {
    padding: 0;
    border: none;
    }
    .form-control{
    font-size: 14px;
    border-color: #ebedf2;
    padding: 0.6rem 1rem;
    }
    .short {
    height: 40px !important;
    width: 90px !important;
    }
    .long{
    height: 40px !important;
    width: 180px !important;
    }
    tfoot {
    display: table-header-group;
    }
    table{
    text-align: center;
    }
    .not-active { 
    pointer-events: none; 
    cursor: default; 
    } 
</style>
@endpush

@section('content')
<div class="container-fluid mt-2">
    <div class="card" style=" font-family:Century Gothic;">
      <div class="card-header text-center" style="font-family:Century Gothic; background-color:#007bff; color:white; font-weigth:bold;">
        GESTION PICKING BODEGA
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
            <th scope="col">Observacion</th>
            <th scope="col">Fecha Picking Bodega</th>
            <th scope="col">Usuario Picking Bodega</th>
            <th scope="col">Observacion Bodega</th>
            <th scope="col">Estado</th>
            <th scope="col">Creacion de Orden</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td><input type="text" class="form-control short input-sm" placeholder="Id"></td>
            <td><input type="text" class="form-control long input-sm" placeholder="Picking"></td>
            <td><input type="text" class="form-control short input-sm" placeholder="Tipo Ref"></td>
            <td><input type="text" class="form-control long input-sm" placeholder="Referencia"></td>
            <td><input type="text" class="form-control long input-sm" placeholder="Observacion"></td>
            <td><input type="text" class="form-control long input-sm" placeholder="Fecha PB"></td>
            <td><input type="text" class="form-control long input-sm" placeholder="Usuario PB"></td>
            <td><input type="text" class="form-control long input-sm" placeholder="Observacion B"></td>
            <td><input type="text" class="form-control short input-sm" placeholder="Estado"></td>
            <td><input type="text" class="form-control long input-sm" placeholder="Fecha Orden"></td>
            <td><label style="width:100px;"></label></td>
        </tr>
    </tfoot>
    <tbody>
      @forEach($ordenes as $orden)
      <tr>
        <td>{{$orden->id}}</td>
        <td>{{$orden->orden_picking}}</td>
        <td>{{$orden->tipo_referencia}}</td>
        <td>{{$orden->referencia}}</td>
        <td>{{$orden->observacion}}</td>
        <td>{{$orden->fecha_picking_bodega}}</td>
        <td>{{$orden->user_name_bodega." ".$orden->user_apellido_bodega}}</td>
        <td>{{$orden->observacion_bodega}}</td>
        @if($orden->status == "Enviado")
        <td><span class="badge badge-info">{{$orden->status}}</span></td>
        @elseif($orden->status == "Aceptado")
        <td><span class="badge badge-success">{{$orden->status}}</span></td>
        @elseif($orden->status == "En espera")
        <td><span class="badge badge-warning">{{$orden->status}}</span></td>
        @elseif($orden->status == "Rechazado")
        <td><span class="badge badge-danger">{{$orden->status}}</span></td>
        @endif
        <td>{{$orden->created_at}}</td>
        <td>
          @if($orden->status == "Enviado")
            <a href="{{route('bodega_picking_create',$orden->id)}}"><span class="badge badge-info"><i class="fa fa-solid fa-marker"></i></span></a>
          @elseif($orden->status == "Aceptado")
            <a type="button" class="" data-toggle="modal" data-target=".bd-example-modal-lg" onClick="datos('{{$orden->id}}');" style="cursor: pointer;"><span class="badge badge-success"><i class="fa fa-solid fa-arrow-down"></i></span></a>
          @elseif($orden->status == "En espera")
            <a href="{{route('revision_picking_bodega',$orden->id)}}"><span class="badge badge-warning"><i class="fa fa-solid fa-retweet"></i></span></a>
          @elseif($orden->status == "Rechazado")
            <a type="button" class="" data-toggle="modal" data-target=".bd-example-modal-lg" onClick="datos('{{$orden->id}}');" style="cursor: pointer;"><span class="badge badge-danger"><i class="fa fa-solid fa-arrow-down"></i></span></a>
          @endif
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
                                      <th scope="col">Orden Picking</th>
                                      <th scope="col">Item</th>
                                      <th scope="col">Cantidad</th>
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
    
function datos(id){
    $('#mydatatable').DataTable().destroy().draw();
    var URLdominio = getAbsolutePath();
    var url = URLdominio + "gestion/consulta";
        $.ajax({
            url: url,
            type: 'GET',
            data: {
              id: id
            },
            dataType: 'json',
            success: function(data){
                $(document).ready(function(){
                    $('#mydatatable').DataTable({
                        dom: 'Blfrtip',
                        buttons: [{
                        extend: 'excel',
                        footer: true,
                        title: 'Organización Bless',
                        filename: "Detalle Picking Bodega Orden: "+data[0]['orden_picking'],
                        text: '<i class="fa fa-file-excel"></i>'
                      },
                      {
                        extend: 'pdf',
                        footer: true,
                        title: 'Organización Bless',
                        filename: "Detalle Picking Bodega Orden: "+data[0]['orden_picking'],
                        text: '<i class="fa fa-file-pdf"></i>'
                      }]
                    });
                })
                $("#body").html("");
                  for(var i=0; i<data.length; i++){
                    
                    var tr = `<tr>
                      <td>`+data[i].id+`</td>
                      <td>`+data[i].orden_picking+`</td>
                      <td>`+data[i].item+`</td>
                      <td>`+data[i].cantidad+`</td>
                    </tr>`;
                    $("#body").append(tr)
                    
                  }
            }
        });
}

    $(document).ready(function(){
        var table = $('#mydatatable-container').DataTable({
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
        filename: 'Gestion Picking Bodega',

        //Aquí es donde generas el botón personalizado
        text: '<i class="fa fa-light fa-file-excel"></i>'
      },
      //Botón para PDF
      {
        extend: 'pdf',
        footer: true,
        title: 'Organización Bless',
        filename: 'Gestion Picking Bodega',
        text: '<i class="fa fa-file-pdf"></i>'
      },
      {
        extend: 'print',
        footer: true,
        title: 'Organizacion Bless',
        filename: 'Gestion Picking Bodega',
        text: '<i class="fa fa-light fa-print"></i>'
      }
    ]
        });
        $('#datos tfoot th.text-search').each(function () {
          var title = $(this).text();
          $(this).html(
           "&lt;input type='text' placeholder='"+title+"' size='10em'/>"
          );
        });
         
        // Aplicamos los filtros en las columnas del array
        table.columns([0,1,2,3,4,5,6,7,8,9]).every( function () {
            var that = this;
            $( 'input', this.footer() ).on( 'keyup change', function () {
                if (that.search() !== this.value ) {
                    that.search(this.value)
                        .draw();
                }
            });
        });
    });
</script>    

@endpush