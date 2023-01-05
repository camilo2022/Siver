@extends('layouts.appp')

@push('custom-css')
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
    .swal2-html-container {
    text-align: center
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
<link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid mt-2">
    <div class="card" style=" font-family:Century Gothic;">
        <div class="card-body">
            <div class="table-responsive">
<body>
    <form method="" action="" id="referenciaForm" accept-charset="UTF-8" autocomplete="off">
<div class="row">
       <div class="col-3"></div>
            <div class="col-6">
                <label style="text-align:center; width:100%;"><span class="badge badge-info" id="span" style="width:100%; font-size:20px; text-align:center;"></span></label>
                <label for="" class="tipo">¿Referencia o Sku?</label> 
                <select name="tipo" id="tipo" class="tipo" onchange="selectTipo()">
                    <option value="" selected disabled>Seleccione</option>
                    <option value="Referencia">Referencia</option>
                    <option value="Sku">Sku</option>
                </select>

                <label for="" class="sku">Sku</label> 
                <input type="text" name="" id="sku" class="sku">

                <label for="" class="tonos">¿Con Tono o Sin Tono?</label> 
                <select name="tonos" id="tonos" class="tonos" onchange="selectTono()">
                    <option value="" selected disabled>Seleccione Tono</option>
                    <option value="Con Tono">Con Tono</option>
                    <option value="Sin Tono">Sin Tono</option>
                </select>

                <label for="" class="referencia">Referencia</label> 
                <input type="text" name="" id="referencia" class="referencia">

                <label for="" class="tono">Tono</label> 
                <input type="text" name="" id="tono" class="tono">
                <br><br>
                <button type="button" class="btn btn-success" id="registrar" style="width:100%">Registrar</button>


            </div>
        <div class="col-3"></div>
    </div>   
    <br> 
            
   <div class="row">
       <div class="col-3"></div>
            <div class="col-6">
                <table id="items" class="table" >
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
<script src="{{asset('js/picking.js')}}"></script>  
@endpush