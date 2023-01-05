@extends('layouts.appp')

@push('custom-css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<style>
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
    TABLA DE TERMINACION
    </div>
        <div class="card-body">
            <div class="table-responsive">
                
<table id="mydatatable-container" class="table" style="width:100%">
    <thead class="">
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Fecha</th>
            <th scope="col">Turno</th>
            <th scope="col">Modulo</th>
            <th scope="col">Referencia</th>
            <th scope="col">Tallas</th>
            <th scope="col">TC</th>
            <th scope="col">Tipo</th>
            <th scope="col">Hora</th>
            <th scope="col">CC</th>
            <th scope="col">Tiempo</th>
            <th scope="col">100 %</th>
            <th scope="col">% Eficiencia</th>
            <th scope="col">N°Operarios</th>
            <th scope="col">Tipo PP</th>
            <th scope="col">Tiempo PP</th>
            <th scope="col">Tipo PNP</th>
            <th scope="col">Tiempo PNP</th>
            <th scope="col">Accciones</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <td><input type="text" class="form-control short input-sm" placeholder="Id"></td>
            <td><input type="text" class="form-control long input-sm" placeholder="Fecha"></td>
            <td><input type="text" class="form-control short input-sm" placeholder="Turno"></td>
            <td><input type="text" class="form-control long input-sm" placeholder="Modulo"></td>
            <td><input type="text" class="form-control long input-sm" placeholder="Referencia"></td>
            <td><input type="text" class="form-control long input-sm" placeholder="Tallas"></td>
            <td><input type="text" class="form-control short input-sm" placeholder="TC"></td>
            <td><input type="text" class="form-control long input-sm" placeholder="Tipo"></td>
            <td><input type="text" class="form-control long input-sm" placeholder="Hora"></td>
            <td><input type="text" class="form-control short input-sm" placeholder="CC"></td>
            <td><input type="text" class="form-control short input-sm" placeholder="Tiempo"></td>
            <td><input type="text" class="form-control short input-sm" placeholder="100 %"></td>
            <td><input type="text" class="form-control long input-sm" placeholder="% Eficiencia"></td>
            <td><input type="text" class="form-control short input-sm" placeholder="N°Operarios"></td>
            <td><input type="text" class="form-control long input-sm" placeholder="Tipo PP"></td>
            <td><input type="text" class="form-control short input-sm" placeholder="Tiempo PP"></td>
            <td><input type="text" class="form-control long input-sm" placeholder="Tipo PNP"></td>
            <td><input type="text" class="form-control short input-sm" placeholder="Tiempo PN"></td>
            <td><label style="width:100px;"></label></td>
        </tr>
    </tfoot>
    <tbody>
      @foreach($terminacion as $ter)
        <tr>
            <td>{{$ter->id}}</td>
            <td>{{$ter->fecha}}</td>
            <td>{{$ter->turno}}</td>
            @if($ter->modulo == 1)
            <td>Despeluzado</td>
            @elseif($ter->modulo == 2)
            <td>Taches</td>
            @elseif($ter->modulo == 3)
            <td>Plana</td>
            @elseif($ter->modulo == 4)
            <td>Meson</td>
            @endif
            <td><span class="badge badge-info">{{$ter->referencia}}</span></td>
            <td>{{$ter->tallas}}</td>
            <td>{{$ter->tc}}</td>
            <td>{{$ter->tipo}}</td>
            <td>{{"Hora ".$ter->hora}}</td>
            <td>{{$ter->cantidad}}</td>
            <td>{{$ter->tiempo_req_h}}</td>
            <td>{{$ter->meta_produccion}}</td>
            @if($ter->eficiencia>=0 && $ter->eficiencia<70)
            <td><span class="badge badge-danger">{{number_format($ter->eficiencia,2, ',', '.')}} %</span></td>
            @elseif($ter->eficiencia>=70 && $ter->eficiencia<80)
            <td><span class="badge badge-warning">{{number_format($ter->eficiencia,2, ',', '.')}} %</span></td>
            @elseif($ter->eficiencia>=80 && $ter->eficiencia<100)
            <td><span class="badge badge-success">{{number_format($ter->eficiencia,2, ',', '.')}} %</span></td>
            @else
            <td><span class="badge badge-primary">{{number_format($ter->eficiencia,2, ',', '.')}} %</span></td>
            @endif
            <td>{{$ter->n_operarios}}</td>
            <td>{{$ter->parada_programada}}</td>
            <td>{{$ter->tiempo_parada_programada}}</td>
            <td>{{$ter->parada_no_programada}}</td>
            <td>{{$ter->tiempo_noprg}}</td>
            <td>
              <form>
                <a href="{{route('eficiencia_terminacion',$ter->id)}}" class=""><span class="badge badge-success"><i class="fa fa-solid fa-eye"></i></span></a>
                <a href="{{route('edit_terminacion',$ter->id)}}" class=""><span class="badge badge-info"><i class="fa fa-solid fa-marker"></i></span></a>
                @if(Auth::user()->rol->slug == 'ADPRD' )
                <a href="{{route('delete_terminacion',$ter->id)}}" class=""><span class="badge badge-danger"><i class="fa fa-solid fa-trash"></i></span></a>
                @else
                <a href="" class="not-active"><span class="badge badge-danger"><i class="fa fa-solid fa-trash"></i></span></a>
                @endif
              </form>
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
        filename: 'Terminacion',

        //Aquí es donde generas el botón personalizado
        text: '<i class="fa fa-light fa-file-excel"></i>'
      },
      //Botón para PDF
      {
        extend: 'pdf',
        footer: true,
        title: 'Organización Bless',
        filename: 'Terminacion',
        text: '<i class="fa fa-file-pdf"></i>'
      },
      {
        extend: 'print',
        footer: true,
        title: 'Organizacion Bless',
        filename: 'Terminacion',
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
        table.columns([0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17]).every( function () {
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