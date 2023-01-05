@extends('layouts.appp')

@push('custom-css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<style></style>
@endpush

@section('content')
<div class="container-fluid mt-2">
    <div class="card" style=" font-family:Century Gothic;">
      <div class="card-header text-center" style="font-family:Century Gothic; background-color:#007bff; color:white; font-weigth:bold;">
        REPORTE DE PICKING TERMINACION
        </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-3">
                                <input type="date" class="form-control" id="date1">
                                </div>
                            <div class="col-sm-3">
                                <input type="date" class="form-control" id="date2">
                                </div>
                            <div class="col-sm-3"></div>
                        </div>
                        <br>
                        <button class="btn w-100 btn-success" style="font-family:Century Gothic; color:white; font-weigth:bold;" id="generar">Generar Consulta</button>
                     </div>
                     <div id="tablar"></div>
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
    $(document).ready(function(){
        $("#generar").click(function() {
            var fecha1 = $("#date1").val();
            var fecha2 = $("#date2").val();
            
            if(fecha1 == null || fecha1 == "" || fecha1 == undefined){
                swal("¡Ojo!", "Debe ingresar una fecha inicial", "warning");
            }else if(fecha2 == null || fecha2 == "" || fecha2 == undefined){
                swal("¡Ojo!", "Debe ingresar una fecha final", "warning");
            }else if(fecha1>fecha2){
                swal("¡Error!", "La fecha inicial debe ser menor a la fecha final", "error");
            }else{
                var URLdominio = getAbsolutePath();
                var url = URLdominio + "reporte_terminacion/generar";
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        fecha1: fecha1,
                        fecha2: fecha2
                    },
                    dataType: 'json',
                    success: function(data){
                        $('#tablar').html(data);
                        $(document).ready(function(){
                            $('#example23').DataTable({
                                dom: 'Blfrtip',
                                buttons: [{
                                        extend: 'excel',
                                        footer: true,
                                        title: 'Organización Bless',
                                        filename: 'Picking Terminacion entre '+fecha1+' y '+fecha2,
                                        text: '<i class="fa fa-light fa-file-excel"></i>'
                                    },
                                    {
                                        extend: 'pdf',
                                        footer: true,
                                        title: 'Organización Bless',
                                        filename: 'Picking Terminacion entre '+fecha1+' y '+fecha2,
                                        text: '<i class="fa fa-file-pdf"></i>'
                                }]
                            });
                        });
                    }
                });
            }
        })
    })
</script>    

@endpush