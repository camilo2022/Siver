@extends('layouts.appp')

@push('custom-css')
<link rel="stylesheet" href="/css/eficiencia_1.css">
@endpush

@section('content')

<body>
<div class="container-fluid mt-2">
    <div class="card" style=" font-family:Century Gothic;">
    <div class="card-header text-center" style="font-family:Century Gothic; background-color:#007bff; color:white; font-weigth:bold;">
    PREPARACION VALORES DE EFICIENCIA
    </div>
        <div class="card-body">
            <div class="table-responsive">
        <table style="width:100%">
            <tr>
                <td colspan="2" class="encabezado1 infe_white"> <label for="" class="letraWhite">Embonar Parche</label> </td>
                <td colspan="2" class="encabezado2 infe_white"> <label for="" class="letraWhite">Embonar Relojera</label> </td>
                <td colspan="2" class="encabezado1 infe_white"> <label for="" class="letraWhite">Pinzas</label> </td>
                <td colspan="2" class="encabezado2 infe_white"> <label for="" class="letraWhite">Cotilla</label> </td>
                <td colspan="2" class="encabezado1 infe_white"> <label for="" class="letraWhite">Cola</label> </td>
                <td colspan="2" class="encabezado2 infe_white"> <label for="" class="letraWhite">Parchado</label> </td>
            </tr>

            <tr>
                
                <td class="encabezado1 infe_black drch_white"> <label for="" class="letraWhite">Prendas</label> </td>
                <td class="encabezado1 infe_black"> <label for="" class="letraWhite">100%</label> </td>
                <td class="encabezado2 infe_black drch_white"> <label for="" class="letraWhite">Prendas</label> </td>
                <td class="encabezado2 infe_black"> <label for="" class="letraWhite">100%</label> </td>
                <td class="encabezado1 infe_black drch_white"> <label for="" class="letraWhite">Prendas</label> </td>
                <td class="encabezado1 infe_black"> <label for="" class="letraWhite">100%</label> </td>
                <td class="encabezado2 infe_black drch_white"> <label for="" class="letraWhite">Prendas</label> </td>
                <td class="encabezado2 infe_black"> <label for="" class="letraWhite">100%</label> </td>
                <td class="encabezado1 infe_black drch_white"> <label for="" class="letraWhite">Prendas</label> </td>
                <td class="encabezado1 infe_black"> <label for="" class="letraWhite">100%</label> </td>
                <td class="encabezado2 infe_black drch_white"> <label for="" class="letraWhite">Prendas</label> </td>
                <td class="encabezado2 infe_black"> <label for="" class="letraWhite">100%</label> </td>
            </tr>

           

            <tr>
                <td> <label for="">{{$array_mod[0]['Cant']}}</label> </td>
                <td class="drch_black2"> <label for="">{{$array_mod[0]['Meta']}}</label> </td>
                <td> <label for="">{{$array_mod[1]['Cant']}}</label> </td>
                <td class="drch_black2"> <label for="">{{$array_mod[1]['Meta']}}</label> </td>
                <td> <label for="">{{$array_mod[2]['Cant']}}</label> </td>
                <td class="drch_black2"> <label for="">{{$array_mod[2]['Meta']}}</label> </td>
                <td> <label for="">{{$array_mod[3]['Cant']}}</label> </td>
                <td class="drch_black2"> <label for="">{{$array_mod[3]['Meta']}}</label> </td>
                <td> <label for="">{{$array_mod[4]['Cant']}}</label> </td>
                <td class="drch_black2"> <label for="">{{$array_mod[4]['Meta']}}</label> </td>
                <td> <label for="">{{$array_mod[5]['Cant']}}</label> </td>
                <td class="drch_black2"> <label for="">{{$array_mod[5]['Meta']}}</label> </td>

            </tr>

            <tr>
                <td colspan="2" class="drch_black2" style="background: {{$array_mod[0]['Color']}}"> <label for="">{{$array_mod[0]['Efic']." %"}}</label> </td>
                <td colspan="2" class="drch_black2" style="background: {{$array_mod[1]['Color']}}"> <label for="">{{$array_mod[1]['Efic']." %"}}</label> </td>
                <td colspan="2" class="drch_black2" style="background: {{$array_mod[2]['Color']}}"> <label for="">{{$array_mod[2]['Efic']." %"}}</label> </td>
                <td colspan="2" class="drch_black2" style="background: {{$array_mod[3]['Color']}}"> <label for="">{{$array_mod[3]['Efic']." %"}}</label> </td>
                <td colspan="2" class="drch_black2" style="background: {{$array_mod[4]['Color']}}"> <label for="">{{$array_mod[4]['Efic']." %"}}</label> </td>
                <td colspan="2" class="drch_black2" style="background: {{$array_mod[5]['Color']}}"> <label for="">{{$array_mod[5]['Efic']." %"}}</label> </td>
            </tr>
        </table>
<br>

        <table style="width:100%">
            @for($i=0;$i<count($array_per);$i+=5)
            <tr>
                @for($j=$i;$j<count($array_per);$j++)
                @if($j==$i+5)
                    @break
                @endif
                <td class="border_black_right infe_black" style="width: 210px;"><label for="">{{$array_per[$j]['Empl']}}</label></td>
                <td class="drch_black infe_black" style="width: 110px; background: {{$array_per[$j]['Color']}};"><label for="">{{$array_per[$j]['Efic']." %"}}</label></td>
                @endfor
            </tr>
            @endfor

            
        </table>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection

@push('scripts-custom')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function(){
        $(".wrapper").addClass("sidebar_minimize");
        setTimeout('document.location.reload()',60000);
    })
</script>
@endpush