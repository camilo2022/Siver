@extends('layouts.appp')

@push('custom-css')
<link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
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
    table{
    text-align: center;
    }
    td{
    font-size: 20px;
    border-color: #ebedf2;
    }
    .swal2-html-container{
    text-align: center;
    color: #fff;
    }
    select {
    font-size: 14px;
    border-color: #ebedf2;
    padding: 0.6rem 1rem;
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
        <div class="card-header text-center" style="font-family:Century Gothic; background-color:#007bff; color:white; font-weigth:bold;">
            PICKING BODEGA
          </div>
        <div class="card-body">
            <div class="table-responsive">
<body>
    <form method="" action="" id="referenciaForm" accept-charset="UTF-8" autocomplete="off">
   <div class="row">
       <div class="col-3"></div>
            <div class="col-6">
                <input type="number" name="" id="id" value="{{$picking[0]->id}}" style="display: none">
                <label style="text-align:center; width: 49.5%;">Orden Picking:<span class="badge badge-primary" id="orden" style="width:100%; font-size:20px; text-align:center;">{{$picking[0]->orden_picking}}</span></label>
                <label style="text-align:center; width: 49.5%;">Tipo Refrencia:<span class="badge badge-primary" id="tipo" style="width:100%; font-size:20px; text-align:center;">{{$picking[0]->tipo_referencia}}</span></label>
                <label style="text-align:center; width: 100%;margin-bottom: 25px;">Refrencia:<span class="badge badge-primary" id="referencia" style="width:100%; font-size:20px; text-align:center;">{{$picking[0]->referencia}}</span></label>
                <table id="items" class="table">
                    <thead>
                        <th scope="col">Item</th>
                        <th scope="col">Cantidad</th>
                    </thead>
                    <tbody id="body">

                    </tbody>

                    <tfoot>
                        <tr>
                            <th scope="col" style="width:350px;">Total</th>
                            <th scope="col" style="width:350px;" id="total">0</th>
                        </tr>
                    </tfoot>

                </table>
            </div>
        <div class="col-3"></div>
    </div>        
            
            <div class="col-12" style="display: grid; place-content: center;">
                <table id="cod_ing" class="table" style="width:100%">
                    <thead>
                        <th scope="col">Codigos Ingresados</th>
                        <th scope="col">Accion</th>
                    </thead>
                    <tbody id="codigos">
                        
                    </tbody>
                </table>
                <br>
                <input type="text" id="ingreso_codigo">
            </div>

            

        <br>
        <a type="button" class="btn btn-secondary" style="color: #fff;">Cancelar</a>
        <button type="button" class="btn btn-primary" id="guardar">Guardar</button>
    </form>
</body>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts-custom')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/v/bs4-4.1.1/dt-1.10.18/datatables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="{{asset('js/picking_bodega.js')}}"></script>       

@endpush