@extends('layouts.appp')

@push('custom-css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
<style>
    button.dt-button, div.dt-button, a.dt-button, input.dt-button {
    padding: 0;
    border: none;    
    }
    .my-validation-message::before {
    display: none;
    }
    .my-validation-message i {
    margin: 0 .4em;
    color: #f27474;
    font-size: 1.4em;
    }
    .swal2-textarea{
    height: 150px !important;
    padding: 0.75em !important;
    width: 400px !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid mt-2">
  <div class="card" style=" font-family:Century Gothic;">
    <div class="card-header text-center" style="font-family:Century Gothic; background-color:#007bff; color:white; font-weigth:bold;">
      COMPARAR PICKING
    </div>
    <div class="card-body">
      <div class="table-responsive">
        
<div class="row">
  <div class="col-6">
    <div class="container-fluid mt-2">
      <div class="card" style=" font-family:Century Gothic;">
        <div class="card-header text-center" style="font-family:Century Gothic; background-color:#007bff; color:white; font-weigth:bold;">
          PICKING TERMINACION
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="mydatatable-terminacion" class="table" style="width:100%">
              <thead class="">
                  <tr>
                      <th scope="col">Id</th>
                      <th scope="col">Orden Picking</th>
                      <th scope="col">Item</th>
                      <th scope="col">Cantidad</th>
                  </tr>
              </thead>
              <tbody>
                @foreach($arrayTerminacion as $ter)
                  <tr>
                    <td>{{$ter['id']}}</td>
                    <td>{{$ter['orden']}}</td>
                    <td><span class="{{$ter['class_item']}}">{{$ter['item']}}</span></td>
                    <td><span class="{{$ter['class_cant']}}">{{$ter['cantidad']}}</span></td>
                  </tr>
                  @endforeach     
              </tbody>
              <tfoot>
                <tr>
                    <th scope="col" colspan="3" style="text-align: right">Suma Total</th>
                    <th scope="col">{{$sumTer}}</th>
                </tr>
            </tfoot>
          </table>
          </div>
        </div>
      </div>
    </div>
   </div>
     <div class="col-6">
        <div class="container-fluid mt-2">
          <div class="card" style=" font-family:Century Gothic;">
            <div class="card-header text-center" style="font-family:Century Gothic; background-color:#007bff; color:white; font-weigth:bold;">
              PICKING BODEGA
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="mydatatable-bodega" class="table" style="width:100%">
                  <thead class="">
                      <tr>
                          <th scope="col">Id</th>
                          <th scope="col">Orden Picking</th>
                          <th scope="col">Item</th>
                          <th scope="col">Cantidad</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach($arrayBodega as $bod)
                    <tr>
                      <td>{{$bod['id']}}</td>
                      <td>{{$bod['orden']}}</td>
                      <td><span class="{{$bod['class_item']}}">{{$bod['item']}}</span></td>
                      <td><span class="{{$bod['class_cant']}}">{{$bod['cantidad']}}</span></td>
                    </tr>
                    @endforeach                    
                  </tbody>
                  <tfoot>
                    <tr>
                        <th scope="col" colspan="3" style="text-align: right">Suma Total</th>
                        <th scope="col">{{$sumBod}}</th>
                    </tr>
                </tfoot>
              </table>
              </div>
            </div>
          </div>
        </div>
     </div>
</div>

  <a type="button" href="{{route('repicking_picking_bodega',$id)}}" style="margin: 5px; width: 99%;" class="btn btn-info">RE-PICKING</a>

<form method="" action="{{route('aceptar_picking_bodega',$id)}}" id="aceptar" accept-charset="UTF-8" autocomplete="off">
  <input type="text" name="obs_acp" id="obs_acp" hidden>
  <a type="submit" style="margin: 5px; width: 99%;" class="btn btn-success">ACEPTAR</a>
</form>

<form method="" action="{{route('rechazar_picking_bodega',$id)}}" id="rechazar" accept-charset="UTF-8" autocomplete="off">
  <input type="text" name="obs_rec" id="obs_rec" hidden>
  <a type="button" style="margin: 5px; width: 99%;" class="btn btn-danger">RECHAZAR</a>
</form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts-custom')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
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
        $("#aceptar").click(function(event){
            event.preventDefault()
            Swal.fire({
              title: '¿Por qué acepta?',
              input: 'textarea',
              customClass: {
                validationMessage: 'my-validation-message'
              },
              preConfirm: (value) => {
                if (!value) {
                  Swal.showValidationMessage(
                    '<i class="fa fa-info-circle"></i> ¡Debe ingresar una observacion!'
                  )
                }
                else{
                  Swal.getInput().addEventListener('change', () => {
                   Swal.getInput().value
                  })
                }
              }
            }).then((result) => {
              let value = result.value;
              if(value!=undefined){
                $("#obs_acp").val(value);
                $('#aceptar').submit();
              }
            })

        })

        $("#rechazar").click(function(event){
            event.preventDefault()
            Swal.fire({
              title: '¿Por qué rechaza?',
              input: 'textarea',
              customClass: {
                validationMessage: 'my-validation-message'
              },
              preConfirm: (value) => {
                if (!value) {
                  Swal.showValidationMessage(
                    '<i class="fa fa-info-circle"></i> ¡Debe ingresar una observacion!'
                  )
                }
                else{
                  Swal.getInput().addEventListener('change', () => {
                   Swal.getInput().value
                  })
                }
              }
            }).then((result) => {
              let value = result.value;
              if(value!=undefined){
                $("#obs_rec").val(value);
                $('#rechazar').submit();
              }
            })

        })
    });
</script>    

@endpush