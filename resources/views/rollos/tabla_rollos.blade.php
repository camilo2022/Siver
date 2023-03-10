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
    width: 75px !important;
    }
    .long{
    height: 40px !important;
    width: 150px !important;
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
    TABLA DE ROLLOS
    </div>
        <div class="card-body">
            <div class="table-responsive">
<table id="mydatatable-container" class="table dataTable_width_auto" >
    <thead class="">
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Proveedor</th>
            <th scope="col">Fecha Entrada</th>
            <th scope="col">Tela</th>
            <th scope="col">Tipo</th>
            <th scope="col">Rollo</th>
            <th scope="col">Ancho</th>
            <th scope="col">Metros</th>
            <th scope="col">Tono</th>
            <th scope="col">Fecha Salida</th>
            <th scope="col">Salida</th>
            <th scope="col">Observacion</th>
            <th scope="col">Estado</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td><input type="text" class="form-control short input-sm" placeholder="Id"></td>
            <td><input type="text" class="form-control long input-sm" placeholder="Proveedor"></td>
            <td><input type="text" class="form-control long input-sm" placeholder="Fecha Entrada"></td>
            <td><input type="text" class="form-control long input-sm" placeholder="Tela"></td>
            <td><input type="text" class="form-control long input-sm" placeholder="Tipo"></td>
            <td><input type="text" class="form-control short input-sm" placeholder="Rollo"></td>
            <td><input type="text" class="form-control short input-sm" placeholder="Ancho"></td>
            <td><input type="text" class="form-control short input-sm" placeholder="Metro"></td>
            <td><input type="text" class="form-control short input-sm" placeholder="Tono"></td>
            <td><input type="text" class="form-control long input-sm" placeholder="Fecha Salida"></td>
            <td><input type="text" class="form-control short input-sm" placeholder="Salida"></td>
            <td><input type="text" class="form-control long input-sm" placeholder="Observacion"></td>
            <td><input type="text" class="form-control long input-sm" placeholder="Estado"></td>
            <td><label style="width:100px;"></label></td>
        </tr>
    </tfoot>
    <tbody>
      @foreach($rollos as $rollo)
      <tr>
              <td>{{ $rollo->id }}</td>
              <td>{{ $rollo->proveedor }}</td>
              <td><span class="badge badge-info">{{ $rollo->fecha_entrada }}</span></td>
              <td>{{ $rollo->tela }}</td>
              <td>{{ $rollo->tipo }}</td>
              <td>{{ $rollo->rollo }}</td>
              <td>{{ $rollo->ancho }}</td>
              <td>{{ $rollo->metros }}</td>
              <td>{{ $rollo->tono }}</td>
              <td><span class="badge badge-info">{{ $rollo->fecha_salida }}</span></td>
              @if($rollo->salida==0)
              <td><span class="badge badge-success">{{ $rollo->salida }}</span></td>
              @else
              <td><span class="badge badge-danger">{{ $rollo->salida }}</span></td>
              @endif
              <td>{{ $rollo->observacion }}</td>
              @if($rollo->estado == 0)
              <td><span class="badge badge-success">Disponible</span></td>
              @elseif($rollo->estado == 1)
              <td><span class="badge badge-danger">No Disponible</span></td>
              @endif
              
              @if(Auth::user()->rol->slug == 'AD' || Auth::user()->rol->slug == 'ADR' || Auth::user()->rol->slug == 'ADOC' || Auth::user()->rol->slug == 'ADPRD')
              <td> 
                  <a href="{{route('edit_rollos',$rollo->id)}}" class=""><span class="badge badge-info"><i class="fa fa-solid fa-marker"></i></span></a>
                  @if($rollo->estado == 0)
                  <a href="{{route('rollos_estado',$rollo->id)}}"  class=""><span class="badge badge-success"><i class="fa fa-solid fa-thumbs-up"></i></span></a>
                  @elseif($rollo->estado == 1)
                  <a href="{{route('rollos_estado',$rollo->id)}}" class=""><span class="badge badge-danger"><i class="fa fa-solid fa-thumbs-down"></i></span></a>
                  @endif
                  
              </td>
              @else
              <td>
                  <a href="" class="not-active"><span class="badge badge-info"><i class="fa fa-solid fa-marker"></i></span>
                  @if($rollo->estado == 0)
                  <a href="" class="not-active"><span class="badge badge-success"><i class="fa fa-solid fa-thumbs-up"></i></span>
                  @elseif($rollo->estado == 1)
                  <a href="" class="not-active"><span class="badge badge-danger"><i class="fa fa-solid fa-thumbs-down"></i></span>
                  @endif
              </td>
              @endif
              
      </tr>
          @endforeach
    
    
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
        var table = $('#mydatatable-container').DataTable({

        dom: 'Blfrtip',
        buttons: [{
        extend: 'copy',
        footer: true,
        title: 'Organizaci??n Bless',
        filename: 'Date Copy',
        text: '<i class="fa fa-light fa-copy"></i>'
      },
      {
        //Bot??n para Excel
        extend: 'excel',
        footer: true,
        title: 'Organizaci??n Bless',
        filename: 'Rollos',

        //Aqu?? es donde generas el bot??n personalizado
        text: '<i class="fa fa-light fa-file-excel"></i>'
      },
      //Bot??n para PDF
      {
        extend: 'pdf',
        footer: true,
        title: 'Organizaci??n Bless',
        filename: 'Rollos',
        text: '<i class="fa fa-file-pdf"></i>'
      },
      {
        extend: 'print',
        footer: true,
        title: 'Organizacion Bless',
        filename: 'Rollos',
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
        table.columns([0,1,2,3,4,5,6,7,8,9,10,11,12]).every( function () {
            var that = this;
            $( 'input', this.footer() ).on( 'keyup change', function () {
                if (that.search() !== this.value ) {
                    that.search(this.value)
                        .draw();
                }
            });
        });
        
        
        
         })
</script>    

@endpush