@extends('layouts.appp')

@push('custom-css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<style>
    input{ 
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
        <div class="card-body">
            <div class="table-responsive">
<table id="mydatatable-container" class="table" style="width:100%">
    <thead class="">
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Fecha</th>
            <th scope="col">Referencia</th>
            <th scope="col">Cantidad</th>
            <th scope="col">Usuario</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
      @forEach($pickings as $picking)
      <tr>
        <td>{{$picking->id}}</td>
        <td>{{$picking->fecha}}</td>
        <td>{{$picking->referencia}}</td>
        <td>{{$picking->cantidad}}</td>
        <?php

            $user=null;

            for($i = 0 ; $i < count($users) ; $i++){
              if( $users[$i]->id == $picking->id_user){
                $user = $users[$i]->names." ".$users[$i]->apellidos;
                break;
              }
            }
            ?>
        <td>{{$user}}</td>
        <td>
            @if(Auth::user()->rol->slug == 'AD' || Auth::user()->rol->slug == 'ADPICKING' )
            <a type="button" class="" data-toggle="modal" data-target="#exampleModal" onClick="dataPicking('{{$picking->id}}', '{{$picking->referencia}}', '{{$picking->cantidad}}');" style="cursor: pointer;"><span class="badge badge-info"><i class="fa fa-solid fa-marker"></i></span></a>
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
    
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#0058ff; color:white;">
                <h5 class="modal-title" id="exampleModalLongTitle">Editar Picking</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <div class="card-body">
                    <input typ="number" id="id" style="display:none;">
                    <label>Referencia: </label><input typ="text" id="referencia" disabled>
                    <label>Cantidad: </label><input typ="number" id="cantidad" autocomplete="off">
                </div>    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="editar">Guardar</button>
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
function getAbsolutePath() {
      var loc = window.location;
      var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
      return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
    }
    
function dataPicking(id, referencia, cantidad){
    $("#id").val(id)
    $("#referencia").val(referencia)
    $("#cantidad").val(cantidad)
}
    $(document).ready(function(){
        
        $("#editar").click(function(){
            let id = $("#id").val();
            let referencia = $("#referencia").val();
            let cantidad = $("#cantidad").val();
            var URLdominio = getAbsolutePath();
            var url = URLdominio + "picking_update";
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                id:id,
                cantidad:cantidad
                },
                dataType: 'json',
                success: function(data){
                    if(data==1){
                        window.location.reload();
                    }
                }
            });
        })
        
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
        filename: 'Picking',

        //Aquí es donde generas el botón personalizado
        text: '<i class="fa fa-light fa-file-excel"></i>'
      },
      //Botón para PDF
      {
        extend: 'pdf',
        footer: true,
        title: 'Organización Bless',
        filename: 'Picking',
        text: '<i class="fa fa-file-pdf"></i>'
      },
      {
        extend: 'print',
        footer: true,
        title: 'Organizacion Bless',
        filename: 'Picking',
        text: '<i class="fa fa-light fa-print"></i>'
      }
    ]
        });
    });
</script>    

@endpush