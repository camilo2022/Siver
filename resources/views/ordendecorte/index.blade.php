@extends('layouts.appp')

@push('custom-css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<style>
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
    GESTION DE ORDENES DE CORTE
    </div>
<!--<a href="{{route('createC') }}" class="btn btn-primary mb-3" > Crear </a>-->

    <div class="card-body">
        <div class="table-responsive">
            <table id="cortes" class="table" style="width:100%">
                <thead class="">
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Coleccion</th>
                        <th scope="col">N° Corte</th>
                        <th scope="col">Tela</th>
                        <th scope="col">Referencia</th>
                        <th scope="col">Letra</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Diseñador</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Acciones</th>
                        
                    </tr>
                </thead>
                <tbody>
                @foreach($cortes as $corte)
                <tr>
                        <td>{{ $corte->id }}</td>
                        <td>{{ $corte->coleccion }}</td>
                        <td>{{ $corte->ncorte }}</td>
                        <?php
                        $t = json_decode($telas,true);
                        $tela="";
            
                        for($i = 0 ; $i < count($t) ; $i++){
                          if( $t[$i]['id'] == $corte->id_tela ){
                            $tela = $t[$i]['tela'];
                          }
                        }
                        ?>
                        <td>{{ $tela }}</td>
                        <td>{{ $corte->referencia }}</td>
                        <td>{{ $corte->letra }}</td>
                        <td>{{ $corte->marca }}</td>
                        <td>{{ $corte->diseñador }}</td>
                        <td>{{ $corte->fecha }}</td>
                        
                        <td>
                         @if(Auth::user()->rol->slug == 'AD' || Auth::user()->rol->slug == 'ADOC' )
                            @if($corte->estado==0)
                            
                            <a href="{{route('showC',$corte->id)}}" class=""><span class="badge badge-primary"><i class="fa fa-solid fa-eye"></i></span></a>
                            <a href="{{route('updateEstadoCorte',$corte->id)}}" class=""><span class="badge badge-success"><i class="fa fa-solid fa-thumbs-up"></i></span></a>
                            <a href="{{route('editC',$corte->id)}}" class=""><span class="badge badge-info"><i class="fa fa-solid fa-marker"></i></span></a>
                            <a href="{{route('destroyC',$corte->id)}}" class=""><span class="badge badge-danger"><i class="fa fa-solid fa-trash"></i></span></a>
                            
                            
                            
                            @elseif($corte->estado==1)
                            <a href="{{route('showC',$corte->id)}}" class=""><span class="badge badge-primary"><i class="fa fa-solid fa-eye"></i></span></a>
                            <a href="{{route('updateEstadoCorte',$corte->id)}}" class=""><span class="badge badge-warning"><i class="fa fa-solid fa-thumbs-down"></i></span></a>
                            <a href="" class="not-active"><span class="badge badge-info"><i class="fa fa-solid fa-marker"></i></span></a>
                            <a href="" class="not-active"><span class="badge badge-danger"><i class="fa fa-solid fa-trash"></i></span></a>
                            @endif
                        @else
                            @if($corte->estado==0)
                            <a href="{{route('showC',$corte->id)}}" class=""><span class="badge badge-primary"><i class="fa fa-solid fa-eye"></i></span></a>
                            <a href="" class="not-active"><span class="badge badge-success"><i class="fa fa-solid fa-thumbs-up"></i></span></a>
                            <a href="" class="not-active"><span class="badge badge-info"><i class="fa fa-solid fa-marker"></i></span></a>
                            <a href="" class="not-active"><span class="badge badge-danger"><i class="fa fa-solid fa-trash"></i></span></a>

                            
                            @elseif($corte->estado==1)
                            <a href="{{route('showC',$corte->id)}}" class=""><span class="badge badge-primary"><i class="fa fa-solid fa-eye"></i></span></a>
                            <a href="" class="not-active"><span class="badge badge-warning"><i class="fa fa-solid fa-thumbs-down"></i></span></a>
                            <a href="" class="not-active"><span class="badge badge-info"><i class="fa fa-solid fa-marker"></i></span></a>
                            <a href="" class="not-active"><span class="badge badge-danger"><i class="fa fa-solid fa-trash"></i></span></a>
                            @endif
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
        $('#cortes').DataTable({
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
        filename: 'Orden de Corte',

        //Aquí es donde generas el botón personalizado
        text: '<i class="fa fa-light fa-file-excel"></i>'
      },
      //Botón para PDF
      {
        extend: 'pdf',
        footer: true,
        title: 'Organización Bless',
        filename: 'Orden de Corte',
        text: '<i class="fa fa-file-pdf"></i>'
      },
      {
        extend: 'print',
        footer: true,
        title: 'Organizacion Bless',
        filename: 'Orden de Corte',
        text: '<i class="fa fa-light fa-print"></i>'
      }
    ]
        });
    });
</script>  

@endpush



