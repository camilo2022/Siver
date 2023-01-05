@extends('layouts.appp')

@push('custom-css')
<style>
    #tipo_pno_prgm{
        width: 90%;
    }
    #tipo_p_prgm{
        width: 90%;
    }
    .parada_no_prg{
    font-size: 14px;
    border-color: #ebedf2;
    padding: 0.6rem 1rem;
    width: 9%;
    margin-left: 1%;
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
    .parada_prg{
    font-size: 14px;
    border-color: #ebedf2;
    padding: 0.6rem 1rem;
    width: 9%;
    margin-left: 1%;
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
    input { 
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
    .swal-modal .swal-text {
    text-align: center;
    }
</style>
@endpush

@section('content')
<div class="container-fluid mt-2">
    <div class="card" style=" font-family:Century Gothic;">
    <div class="card-header text-center" style="font-family:Century Gothic; background-color:#007bff; color:white; font-weigth:bold;">
    FORMULARIO DE EDICION DE TERMINACION
    </div>
        <div class="card-body">
            <div class="table-responsive">
<body>
    <form method="" action="" id="terminacionForm" accept-charset="UTF-8" autocomplete="off">
        @csrf
        <input style="display: none" type="number" id="id" name="id" value="{{$ter[0]['id']}}">

        <label for="">Fecha:</label> 
        <input type="date" class="fecha" id="fecha" name="fecha" value="{{$ter[0]['fecha']}}">
        
        <label for="">Turno:</label> 
        <select name="turno" id="turno" class="lista">
            <option value="{{$ter[0]['turno']}}" selected>Turno {{$ter[0]['turno']}}</option>
            <option value="1">Turno 1</option>
            <option value="2">Turno 2</option>
        </select>
        
        <label for="">Modulo:</label>
        <select name="modulo" id="modulo" class="lista">
            <option value="{{$ter[0]['modulo']}}" selected>
                @if($ter[0]['modulo'] == 1)
                <td>Despeluzado</td>
                @elseif($ter[0]['modulo'] == 2)
                <td>Taches</td>
                @elseif($ter[0]['modulo']== 3)
                <td>Plana</td>
                @elseif($ter[0]['modulo'] == 4)
                <td>Meson</td>
                @endif
            </option>
            <option value="1">Despeluzado</option>
            <option value="2">Taches</option>
            <option value="3">Plana</option>
            <option value="4">Meson</option>
        </select>

        <label for="">Referencia:</label><br>
        <input type="number" id="id_refe" style="display: none" value="{{$ter[0]['id_referencia']}}">
        <input type="text" id="referencia" name="referencia" class="" value="{{$refe[0]['lote_referencia']}}">
        
        <label for="">Tallas:</label>
        <input type="text" id="tallas" name="tallas" class="" value="{{$ter[0]['tallas']}}">

        <br>
        <label for="">Tiempo de Ciclo:</label>
        <input type="number" id="tc" name="tc" class="" value="{{$ter[0]['tc']}}">

        <label for="">Tipo:</label>
        <select name="tipo" id="tipo" class="lista">
            <option value="{{$ter[0]['tipo']}}" selected>{{$ter[0]['tipo']}}</option>
            <option value="Clasico">Clasico</option>
            <option value="Moda">Moda</option>
        </select>
   
        <label for="">Hora:</label>
        <select name="hora" id="hora" class="lista">
            <option value="{{$ter[0]['hora']}}" selected>Hora {{$ter[0]['hora']}}</option>
            <option value="1">Hora 01</option>
            <option value="2">Hora 02</option>
            <option value="3">Hora 03</option>
            <option value="4">Hora 04</option>
            <option value="5">Hora 05</option>
            <option value="6">Hora 06</option>
            <option value="7">Hora 07</option>
            <option value="8">Hora 08</option>
            <option value="9">Hora 09</option>
            <option value="10">Hora 10</option>
            <option value="11">Hora 11</option>
            <option value="12">Hora 12</option>
            <option value="13">Hora 13</option>
            <option value="14">Hora 14</option>
            <option value="15">Hora 15</option>
        </select>

        <label for="">Cantidad:</label>
        <input type="number" id="cantidad" class="" name="cantidad" value="{{$ter[0]['cantidad']}}"> 

        <label for="">Tiempo Requerido en Horas:</label>
        <input type="number" id="tiempo_r" class="" name="tiempo_r" value="{{$ter[0]['tiempo_req_h']}}">

        <label for="">Numero de Operarios:</label>
        <input type="number" id="n_operarios" class="" name="n_operarios" value="{{$ter[0]['n_operarios']}}">

        <label for="">Tipo de Parada Programada:</label>
        <select name="tipo_p_prgm" id="tipo_p_prgm">
            <?php
            $p = json_decode($programadas,true);
            $tipop = ""; 
            for($i=0;$i<count($p);$i++){
                if($p[$i]['id'] == $ter[0]['id_parada_prg']){
                    $tipop = $p[$i]['tipo_parada_prg'];
                }
            }
            ?>
            @if($ter[0]['id_parada_prg']==0)
            <option value="">Seleccione TPP</option>
            @else
            <option value="{{$ter[0]['id_parada_prg']}}">{{$tipop}}</option>
            @endif
            <option value="">Seleccione TPP</option>
                @foreach($programadas as $a)
                <option value="{{$a->id}}">{{$a->tipo_parada_prg}}</option>
                @endforeach
        </select><button type="button" class="parada_prg" data-toggle="modal" data-target="#ventanaModal1">
            <i class="fa fa-plus"></i></button>

            <div class="modal" id="ventanaModal1" tabindex="-1" role="dialog" aria-labelledby="tituloVentana">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 id="tituloVentana" class="modal-title" name="name">Agregar Paradas Programada</h3>
                        </div>

                            <div class="modal-body">
                                <label for="">Tipo Parada Programada</label> <br>
                                <input type="text" name="prg" id="prg" required> <br> 
                                <label for="">Tiempo Parada Programada</label> <br>
                                <input type="number" name="tprg" id="tprg" required> <br>                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button id="agregar_prg" type="button" class="btn btn-primary">Guardar</button>
                            </div>

                    </div>
                </div>
            </div>

        <label for="">Tipo de Parada No Programada:</label>
        <select name="tipo_pno_prgm" id="tipo_pno_prgm">
            <?php
            $pn = json_decode($no_programadas,true);
            $tipopn = ""; 
            for($i=0;$i<count($pn);$i++){
                if($pn[$i]['id'] == $ter[0]['id_parada_noprg']){
                    $tipopn = $pn[$i]['tipo_parada_noprg'];
                }
            }
            ?>
            @if($ter[0]['id_parada_noprg']==0)
            <option value="">Seleccione TPNP</option>
            @else
            <option value="{{$ter[0]['id_parada_noprg']}}">{{$tipopn}}</option>
            @endif
            <option value="">Seleccione TPNP</option>
                @foreach($no_programadas as $b)
                <option value="{{$b->id}}">{{$b->tipo_parada_noprg}}</option>
                @endforeach
        </select><button type="button" class="parada_no_prg" data-toggle="modal" data-target="#ventanaModalNoPrg">
        <i class="fa fa-plus"></i></button>

            <div class="modal" id="ventanaModalNoPrg" tabindex="-1" role="dialog" aria-labelledby="tituloVentana">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 id="tituloVentana" class="modal-title" name="name">Agregar Paradas no Programada</h3>
                        </div>

                            <div class="modal-body">
                                <label for="">Tipo Parada No Programada</label> <br>
                                <input type="text" name="no_prg" id="no_prg" required> <br>                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button id="agregar_no_prg" type="button" class="btn btn-primary">Guardar</button>
                            </div>

                    </div>
                </div>
            </div>

        <label for="">Tiempo de Parada No Programada</label>
        @if($ter[0]['tiempo_noprg']==0)
        <input type="number" id="tiempo_pno_prgm" name="tiempo_pno_prgm" value="">
            @else
            <input type="number" id="tiempo_pno_prgm" name="tiempo_pno_prgm" value="{{$ter[0]['tiempo_noprg']}}">
            @endif
        
        
        <br><br>
        <a href="{{route('list_terminacion')}}" class="btn btn-secondary" >Cancelar</a>
        <button type="button" class="btn btn-primary" id="submitEditar">Guardar</button>
    </form>
</body>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts-custom')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{asset('js/edit_terminacion.js')}}"></script>
@endpush