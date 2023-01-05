@extends('layouts.appp')

@push('custom-css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<style>
    button.dt-button, div.dt-button, a.dt-button, input.dt-button {
    padding: 0;
    border: none;
    }
    .form-control {
    font-size: 14px;
    border-color: #ebedf2;
    padding: 0.6rem 1rem;
    height: 40px !important;
    width: 90% !important;
    }
    tfoot {
    display: table-header-group;
    }
</style>
@endpush

@section('content')
<div class="container-fluid mt-2">
    <div class="card" style=" font-family:Century Gothic;">
    <div class="card-header text-center" style="font-family:Century Gothic; background-color:#007bff; color:white; font-weigth:bold;">
    TABLA DE METROS DISPONIBLES DE ROLLOS POR TELA
    </div>
        <div class="card-body">
            <div class="table-responsive">
<table id="mydatatable-container" class="table" style="width:100%">
    <thead class="">
        <tr>
            <th scope="col">N°</th>
            <th scope="col">Tela</th>
            <th scope="col">Cantidad Metros Disponibles</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td><input type="text" class="form-control input-sm" placeholder="N°"></td>
            <td><input type="text" class="form-control input-sm" placeholder="Tela"></td>
            <td><input type="text" class="form-control input-sm" placeholder="Metros Disponibles"></td>
            <td></td>
        </tr>
    </tfoot>
    <tbody>
        @for($i=0;$i<count($rollos);$i++)
        <tr>
              <td>{{ $i+1 }}</td>
              <td>{{ $rollos[$i]->tela }}</td>
              <td>{{ $rollos[$i]->metros_totales }}</td>
              <td>
                  <a type="button" class="" data-toggle="modal" data-target=".bd-example-modal-lg" onClick="dataUser('{{$rollos[$i]->tela}}');" style="cursor: pointer;"><span class="badge badge-info"><i class="fa fa-solid fa-eye"></i></span></a>
              </td>
        </tr>
        @endfor

</table>
                </div>
            </div>
        </div>
    </div>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#0058ff; color:white;">
                <h5 class="modal-title" id="exampleModalLongTitle">Rollos Disponibles</h5>
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
                                    <th scope="col">Tela</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Rollo</th>
                                    <th scope="col">Ancho</th>
                                    <th scope="col">Metros</th>
                                    <th scope="col">Tono</th>
                                    <th scope="col">Estado</th>
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
    
function dataUser(tela){
    $('#mydatatable').DataTable().destroy().draw();
    var URLdominio = getAbsolutePath();
    var url = URLdominio + "consulta";
        $.ajax({
            url: url,
            type: 'GET',
            data: {
            tela: tela,
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
                        filename: "'"+tela+"'",
                
                        //Aquí es donde generas el botón personalizado
                        text: '<i class="fa fa-file-excel"></i>'
                      },
                      //Botón para PDF
                      {
                        extend: 'pdf',
                        footer: true,
                        title: 'Organización Bless',
                        filename: "'"+tela+"'",
                        text: '<i class="fa fa-file-pdf"></i>'
                      }]
                    });
                })
                var clase = "";
                var status = "";
                $("#body").html("");
                  for(var i=0; i<data.length; i++){
                    if(data[i].estado == 0){
                        clase = "badge badge-success";
                        status = "Disponible";
                    }else{
                        clase = "badge badge-danger";
                        status = "No Disponible"; 
                    }
                    
                    var tr = `<tr>
                      <td>`+data[i].id+`</td>
                      <td>`+data[i].tela+`</td>
                      <td>`+data[i].tipo+`</td>
                      <td>`+data[i].rollo+`</td>
                      <td>`+data[i].ancho+`</td>
                      <td>`+data[i].metros+`</td>
                      <td>`+data[i].tono+`</td>
                      <td>`+`<span class="`+clase+`">`+status+`</i></span>`+`</td>
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
        filename: 'Metros Disponibles',

        //Aquí es donde generas el botón personalizado
        text: '<i class="fa fa-file-excel"></i>'
      },
      //Botón para PDF
      {
        extend: 'pdf',
        footer: true,
        title: 'Organización Bless',
        filename: 'Metros Disponibles',
        text: '<i class="fa fa-file-pdf"></i>'
      },
      {
        extend: 'print',
        footer: true,
        title: 'Organizacion Bless',
        filename: 'Metros Disponibles',
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
        table.columns([0,1,2,]).every( function () {
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
<script>

</script>
@endpush