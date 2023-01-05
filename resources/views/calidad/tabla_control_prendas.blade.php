@extends('layouts.appp')

@push('custom-css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<style>
    button.dt-button, div.dt-button, a.dt-button, input.dt-button {
    padding: 0;
    border: none;
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
    TABLA CONTROL DE PRENDAS NO CONFORMES DE CONFECCION
    </div>
        <div class="card-body">
            <div class="table-responsive">
<table id="mydatatable-container" class="table" style="width:100%">
    <thead class="">
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Fecha</th>
            <th scope="col">Proceso</th>
            <th scope="col">Referencia</th>
            <th scope="col">Lote</th>
            <th scope="col">Cantidad Muestra Revisar</th>
            
            <th scope="col">Marra</th>
            <th scope="col">Mancha</th>
            <th scope="col">Dos Tonos</th>
            
            <th scope="col">Tamaño Piezas</th>
            
            <th scope="col">Piezas mal Cortadas</th>
            
            <th scope="col">Bota</th>
            <th scope="col">Pretina</th>
            <th scope="col">Presilla</th>
            <th scope="col">Ojal</th>
            <th scope="col">Mol</th>
            <th scope="col">Cotilla</th>
            <th scope="col">Cola</th>
            
            <th scope="col">Pinza</th>
            <th scope="col">Embonada Relojera</th>
            <th scope="col">Embonada Parche</th>
            <th scope="col">Cerradora</th>
            <th scope="col">Parchadora</th>
            
            <th scope="col">Marcacion Caida Parche</th>
            <th scope="col">Marcacion Parche</th>
            <th scope="col">Marcado Pinza</th>
            <th scope="col">Marcado Moda</th>
            <th scope="col">Suministro Insumos</th>
            
            <th scope="col">Cierre</th>
            <th scope="col">Cola</th>
            <th scope="col">Costura Bolsillo Posterior</th>
            <th scope="col">Costura Costado</th>
            <th scope="col">Costura Costilla</th>
            <th scope="col">Costura de Pretina</th>
            <th scope="col">Costura Jota</th>
            <th scope="col">Costura Parche</th>
            <th scope="col">Costura Pinza</th>
            <th scope="col">Costura Reboque</th>
            <th scope="col">Costura Ribete</th>
            <th scope="col">Costura Vista</th>
            <th scope="col">Embonado de Parche</th>
            <th scope="col">Filete de Costado</th>
            <th scope="col">Filete Entrepierna</th>
            <th scope="col">Punta</th>
            <th scope="col">Relojera</th>
            <th scope="col">Roto</th>
            <th scope="col">Tiro</th>
            <th scope="col">Total Prendas no Conforme</th>
            <th scope="col">Total Arreglos Modulos</th>
            <th scope="col">Accciones</th>
            
        </tr>
    </thead>
    <tbody>
      @forEach($prendas as $prenda)
      <tr>
        <td>{{$prenda->id}}</td>
        <td>{{$prenda->fecha}}</td>
        <td>{{$prenda->modulo}}</td>
        <?php
            $r = json_decode($referencias,true);
            $refe="";

            for($i = 0 ; $i < count($r) ; $i++){
              if( $r[$i]['id'] == $prenda->id_referencia ){
                $refe = $r[$i]['lote_referencia'];
              }
            }
            ?>
        <td>{{$refe}}</td>
        <td>{{$prenda->cant_lote}}</td>
        <td>{{$prenda->cant_muestra_rev}}</td>
        
        <td>{{$prenda->text_marra}}</td>
        <td>{{$prenda->text_mancha}}</td>
        <td>{{$prenda->text_dos_tonos}}</td>
        
        <td>{{$prenda->patro_t_piezas}}</td>
        
        <td>{{$prenda->corte_piezas_mcor}}</td>
        
        <td>{{$prenda->maqui_bota}}</td>
        <td>{{$prenda->maqui_pretina}}</td>
        <td>{{$prenda->maqui_presilla}}</td>
        <td>{{$prenda->maqui_ojal}}</td>
        <td>{{$prenda->maqui_mol}}</td>
        <td>{{$prenda->maqui_cotilla}}</td>
        <td>{{$prenda->maqui_cola}}</td>
        
        <td>{{$prenda->prepa_pinza}}</td>
        <td>{{$prenda->prepa_relojera}}</td>
        <td>{{$prenda->prepa_parche}}</td>
        <td>{{$prenda->prepa_cerra}}</td>
        <td>{{$prenda->prepa_parcha}}</td>
        
        <td>{{$prenda->patin_caida_parche}}</td>
        <td>{{$prenda->patin_marc_parche}}</td>
        <td>{{$prenda->patin_marc_pinza}}</td>
        <td>{{$prenda->patin_marc_moda}}</td>
        <td>{{$prenda->patin_sumn_ins}}</td>
        
        <td>{{$prenda->mod_cierre}}</td>
        <td>{{$prenda->mod_cola}}</td>
        <td>{{$prenda->mod_cos_bolsillo_pos}}</td>
        <td>{{$prenda->mod_cos_costado}}</td>
        <td>{{$prenda->mod_cos_cotilla}}</td>
        <td>{{$prenda->mod_cos_pretina}}</td>
        <td>{{$prenda->mod_cos_jota}}</td>
        <td>{{$prenda->mod_cos_parche}}</td>
        <td>{{$prenda->mod_cos_pinza}}</td>
        <td>{{$prenda->mod_cos_reboque}}</td>
        <td>{{$prenda->mod_cos_ribete}}</td>
        <td>{{$prenda->mod_cos_vista}}</td>
        <td>{{$prenda->mod_embonado_parche}}</td>
        <td>{{$prenda->mod_filete_costado}}</td>
        <td>{{$prenda->mod_filete_entrepierna}}</td>
        <td>{{$prenda->mod_punta}}</td>
        <td>{{$prenda->mod_relojera}}</td>
        <td>{{$prenda->mod_roto}}</td>
        <td>{{$prenda->mod_tiro}}</td>
        <td>{{$prenda->total_pno_conforme}}</td>
        <td>{{$prenda->total_arreglos_mod}}</td>
        
        <td>
          @if(Auth::user()->id == 102 || Auth::user()->rol->slug == 'AD')
            <a href="{{route('edit_prendas',$prenda->id)}}" class=""><span class="badge badge-info"><i class="fa fa-solid fa-marker"></i></span></a>
          @else
          <a href="" class="not-active"><span class="badge badge-info"><i class="fa fa-solid fa-marker"></i></span></a>
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
        filename: 'Control de Prendas no Conforme de Confeccion',

        //Aquí es donde generas el botón personalizado
        text: '<i class="fa fa-light fa-file-excel"></i>'
      },
      //Botón para PDF
      {
        extend: 'pdf',
        footer: true,
        title: 'Organización Bless',
        filename: 'Control de Prendas no Conforme de Confeccion',
        text: '<i class="fa fa-file-pdf"></i>'
      },
      {
        extend: 'print',
        footer: true,
        title: 'Organizacion Bless',
        filename: 'Control de Prendas no Conforme de Confeccion',
        text: '<i class="fa fa-light fa-print"></i>'
      }
    ]
        });
    });
</script>    
@endpush