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
        TABLA PICKING TERMINACION
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
            <th scope="col">Estado</th>
            <th scope="col">Creacion de Orden</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
      @forEach($ordenes as $orden)
      <tr>
        <td>{{$orden->id}}</td>
        <td>{{$orden->orden_picking}}</td>
        <td>{{$orden->tipo_referencia}}</td>
        <td>{{$orden->referencia}}</td>
        <td>{{$orden->observacion}}</td>
        @if($orden->status == "Creado")
        <td><span class="badge badge-secondary">{{$orden->status}}</span></td>
        @endif
        <td>{{$orden->created_at}}</td>
        <td>
          <a href="{{route('terminacion_picking_create',$orden->id)}}"><span class="badge badge-secondary"><i class="fa fa-solid fa-marker"></i></span></a>
        </td>
    </tr>
      @endforeach
    </tbody>
    
</table>
                </div>
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
        filename: 'Picking pendiente Terminacion',

        //Aquí es donde generas el botón personalizado
        text: '<i class="fa fa-light fa-file-excel"></i>'
      },
      //Botón para PDF
      {
        extend: 'pdf',
        footer: true,
        title: 'Organización Bless',
        filename: 'Picking pendiente Terminacion',
        text: '<i class="far fa-file-pdf"></i>'
      },
      {
        extend: 'print',
        footer: true,
        title: 'Organizacion Bless',
        filename: 'Picking pendiente Terminacion',
        text: '<i class="fa fa-light fa-print"></i>'
      }
    ]
        });
    });
</script>    

@endpush