@extends('layouts.appp')

@push('custom-css')
<link rel="stylesheet" href="/css/eficiencia.css">
@endpush

@section('content')
<div class="container-fluid mt-2">
    <div class="card" style=" font-family:Century Gothic;">
    <div class="card-header text-center" style="font-family:Century Gothic; background-color:#007bff; color:white; font-weigth:bold;">
    CONFECCION VALORES DE EFICIENCIA
    </div>
        <div class="card-body">
            <div class="table-responsive">

<body>
        <table>
            <tr>
                <td class="infe_black" rowspan="2"><label for="">HORA</label></td>
                <td colspan="2" class="encabezado2 infe_white"> <label for="" class="letraWhite">Módulo Piloto</label> </td>
                <td colspan="2" class="encabezado1 infe_white"> <label for="" class="letraWhite">Módulo 01</label> </td>
                <td colspan="2" class="encabezado2 infe_white"> <label for="" class="letraWhite">Módulo 02</label> </td>
                <td colspan="2" class="encabezado1 infe_white"> <label for="" class="letraWhite">Módulo 03</label> </td>
                <td colspan="2" class="encabezado2 infe_white"> <label for="" class="letraWhite">Módulo 04</label> </td>
                <td colspan="2" class="encabezado1 infe_white"> <label for="" class="letraWhite">Módulo 05</label> </td>
                <td colspan="2" class="encabezado2 infe_white"> <label for="" class="letraWhite">Módulo 06</label> </td>
                <td colspan="2" class="encabezado1 infe_white"> <label for="" class="letraWhite">Módulo 07</label> </td>
                <td colspan="2" class="encabezado2 infe_white"> <label for="" class="letraWhite">Módulo 08</label> </td>
                <td colspan="2" class="encabezado1 infe_white"> <label for="" class="letraWhite">Módulo 09</label> </td>
                <td colspan="2" class="encabezado2 infe_white"> <label for="" class="letraWhite">Módulo 10</label> </td>
                <td colspan="2" class="encabezado1 infe_white"> <label for="" class="letraWhite">Módulo 11</label> </td>
                <td colspan="2" class="encabezado2 infe_white"> <label for="" class="letraWhite">Suma Total</label> </td>
            </tr>

            <tr>
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
                <td class="encabezado1 infe_black drch_white"> <label for="" class="letraWhite">Prendas</label> </td>
                <td class="encabezado1 infe_black"> <label for="" class="letraWhite">100%</label> </td>
                <td class="encabezado2 infe_black drch_white"> <label for="" class="letraWhite">Prendas</label> </td>
                <td class="encabezado2 infe_black"> <label for="" class="letraWhite">100%</label> </td>
            </tr>

            <tr>
                <td class="drch_black"> <label for="">HORA 01</label> </td>
                <td>                    <label for="" id="mod0_h1_efic">{{$array_modulos[0][0]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod0_h1_cant">{{$array_modulos[0][0]['meta']}}</label> </td>
                <td>                    <label for="" id="mod1_h1_efic">{{$array_modulos[1][0]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod1_h1_cant">{{$array_modulos[1][0]['meta']}}</label> </td>
                <td>                    <label for="" id="mod2_h1_efic">{{$array_modulos[2][0]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod2_h1_cant">{{$array_modulos[2][0]['meta']}}</label> </td>
                <td>                    <label for="" id="mod3_h1_efic">{{$array_modulos[3][0]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod3_h1_cant">{{$array_modulos[3][0]['meta']}}</label> </td>
                <td>                    <label for="" id="mod4_h1_efic">{{$array_modulos[4][0]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod4_h1_cant">{{$array_modulos[4][0]['meta']}}</label> </td>
                <td>                    <label for="" id="mod5_h1_efic">{{$array_modulos[5][0]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod5_h1_cant">{{$array_modulos[5][0]['meta']}}</label> </td>
                <td>                    <label for="" id="mod6_h1_efic">{{$array_modulos[6][0]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod6_h1_cant">{{$array_modulos[6][0]['meta']}}</label> </td>
                <td>                    <label for="" id="mod7_h1_efic">{{$array_modulos[7][0]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod7_h1_cant">{{$array_modulos[7][0]['meta']}}</label> </td>
                <td>                    <label for="" id="mod8_h1_efic">{{$array_modulos[8][0]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod8_h1_cant">{{$array_modulos[8][0]['meta']}}</label> </td>
                <td>                    <label for="" id="mod9_h1_efic">{{$array_modulos[9][0]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod9_h1_cant">{{$array_modulos[9][0]['meta']}}</label> </td>
                <td>                    <label for="" id="mod10_h1_efic">{{$array_modulos[10][0]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod10_h1_cant">{{$array_modulos[10][0]['meta']}}</label> </td>
                <td>                    <label for="" id="mod11_h1_efic">{{$array_modulos[11][0]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod11_h1_cant">{{$array_modulos[11][0]['meta']}}</label> </td>
                <td> <label for="" id="sumtotal_h1_efic"></label> </td>
                <td> <label for="" id="sumtotal_h1_cant"></label> </td>
            </tr>

            <tr>
                <td class="drch_black"> <label for="">HORA 02</label> </td>
                <td>                    <label for="" id="mod0_h2_efic">{{$array_modulos[0][1]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod0_h2_cant">{{$array_modulos[0][1]['meta']}}</label> </td>
                <td>                    <label for="" id="mod1_h2_efic">{{$array_modulos[1][1]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod1_h2_cant">{{$array_modulos[1][1]['meta']}}</label> </td>
                <td>                    <label for="" id="mod2_h2_efic">{{$array_modulos[2][1]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod2_h2_cant">{{$array_modulos[2][1]['meta']}}</label> </td>
                <td>                    <label for="" id="mod3_h2_efic">{{$array_modulos[3][1]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod3_h2_cant">{{$array_modulos[3][1]['meta']}}</label> </td>
                <td>                    <label for="" id="mod4_h2_efic">{{$array_modulos[4][1]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod4_h2_cant">{{$array_modulos[4][1]['meta']}}</label> </td>
                <td>                    <label for="" id="mod5_h2_efic">{{$array_modulos[5][1]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod5_h2_cant">{{$array_modulos[5][1]['meta']}}</label> </td>
                <td>                    <label for="" id="mod6_h2_efic">{{$array_modulos[6][1]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod6_h2_cant">{{$array_modulos[6][1]['meta']}}</label> </td>
                <td>                    <label for="" id="mod7_h2_efic">{{$array_modulos[7][1]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod7_h2_cant">{{$array_modulos[7][1]['meta']}}</label> </td>
                <td>                    <label for="" id="mod8_h2_efic">{{$array_modulos[8][1]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod8_h2_cant">{{$array_modulos[8][1]['meta']}}</label> </td>
                <td>                    <label for="" id="mod9_h2_efic">{{$array_modulos[9][1]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod9_h2_cant">{{$array_modulos[9][1]['meta']}}</label> </td>
                <td>                    <label for="" id="mod10_h2_efic">{{$array_modulos[10][1]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod10_h2_cant">{{$array_modulos[10][1]['meta']}}</label> </td>
                <td>                    <label for="" id="mod11_h2_efic">{{$array_modulos[11][1]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod11_h2_cant">{{$array_modulos[11][1]['meta']}}</label> </td>
                <td> <label for="" id="sumtotal_h2_efic"></label> </td>
                <td> <label for="" id="sumtotal_h2_cant"></label> </td>
            </tr>

            <tr>
                <td class="drch_black"> <label for="">HORA 03</label> </td>
                <td>                    <label for="" id="mod0_h3_efic">{{$array_modulos[0][2]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod0_h3_cant">{{$array_modulos[0][2]['meta']}}</label> </td>
                <td>                    <label for="" id="mod1_h3_efic">{{$array_modulos[1][2]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod1_h3_cant">{{$array_modulos[1][2]['meta']}}</label> </td>
                <td>                    <label for="" id="mod2_h3_efic">{{$array_modulos[2][2]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod2_h3_cant">{{$array_modulos[2][2]['meta']}}</label> </td>
                <td>                    <label for="" id="mod3_h3_efic">{{$array_modulos[3][2]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod3_h3_cant">{{$array_modulos[3][2]['meta']}}</label> </td>
                <td>                    <label for="" id="mod4_h3_efic">{{$array_modulos[4][2]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod4_h3_cant">{{$array_modulos[4][2]['meta']}}</label> </td>
                <td>                    <label for="" id="mod5_h3_efic">{{$array_modulos[5][2]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod5_h3_cant">{{$array_modulos[5][2]['meta']}}</label> </td>
                <td>                    <label for="" id="mod6_h3_efic">{{$array_modulos[6][2]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod6_h3_cant">{{$array_modulos[6][2]['meta']}}</label> </td>
                <td>                    <label for="" id="mod7_h3_efic">{{$array_modulos[7][2]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod7_h3_cant">{{$array_modulos[7][2]['meta']}}</label> </td>
                <td>                    <label for="" id="mod8_h3_efic">{{$array_modulos[8][2]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod8_h3_cant">{{$array_modulos[8][2]['meta']}}</label> </td>
                <td>                    <label for="" id="mod9_h3_efic">{{$array_modulos[9][2]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod9_h3_cant">{{$array_modulos[9][2]['meta']}}</label> </td>
                <td>                    <label for="" id="mod10_h3_efic">{{$array_modulos[10][2]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod10_h3_cant">{{$array_modulos[10][2]['meta']}}</label> </td>
                <td>                    <label for="" id="mod11_h3_efic">{{$array_modulos[11][2]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod11_h3_cant">{{$array_modulos[11][2]['meta']}}</label> </td>
                <td> <label for="" id="sumtotal_h3_efic"></label> </td>
                <td> <label for="" id="sumtotal_h3_cant"></label> </td>
            </tr>

            <tr>
                <td class="drch_black"> <label for="">HORA 04</label> </td>
                <td>                    <label for="" id="mod0_h4_efic">{{$array_modulos[0][3]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod0_h4_cant">{{$array_modulos[0][3]['meta']}}</label> </td>
                <td>                    <label for="" id="mod1_h4_efic">{{$array_modulos[1][3]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod1_h4_cant">{{$array_modulos[1][3]['meta']}}</label> </td>
                <td>                    <label for="" id="mod2_h4_efic">{{$array_modulos[2][3]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod2_h4_cant">{{$array_modulos[2][3]['meta']}}</label> </td>
                <td>                    <label for="" id="mod3_h4_efic">{{$array_modulos[3][3]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod3_h4_cant">{{$array_modulos[3][3]['meta']}}</label> </td>
                <td>                    <label for="" id="mod4_h4_efic">{{$array_modulos[4][3]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod4_h4_cant">{{$array_modulos[4][3]['meta']}}</label> </td>
                <td>                    <label for="" id="mod5_h4_efic">{{$array_modulos[5][3]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod5_h4_cant">{{$array_modulos[5][3]['meta']}}</label> </td>
                <td>                    <label for="" id="mod6_h4_efic">{{$array_modulos[6][3]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod6_h4_cant">{{$array_modulos[6][3]['meta']}}</label> </td>
                <td>                    <label for="" id="mod7_h4_efic">{{$array_modulos[7][3]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod7_h4_cant">{{$array_modulos[7][3]['meta']}}</label> </td>
                <td>                    <label for="" id="mod8_h4_efic">{{$array_modulos[8][3]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod8_h4_cant">{{$array_modulos[8][3]['meta']}}</label> </td>
                <td>                    <label for="" id="mod9_h4_efic">{{$array_modulos[9][3]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod9_h4_cant">{{$array_modulos[9][3]['meta']}}</label> </td>
                <td>                    <label for="" id="mod10_h4_efic">{{$array_modulos[10][3]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod10_h4_cant">{{$array_modulos[10][3]['meta']}}</label> </td>
                <td>                    <label for="" id="mod11_h4_efic">{{$array_modulos[11][3]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod11_h4_cant">{{$array_modulos[11][3]['meta']}}</label> </td>
                <td> <label for="" id="sumtotal_h4_efic"></label> </td>
                <td> <label for="" id="sumtotal_h4_cant"></label> </td>
            </tr>

            <tr>
                <td class="drch_black"> <label for="">HORA 05</label> </td>
                <td>                    <label for="" id="mod0_h5_efic">{{$array_modulos[0][4]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod0_h5_cant">{{$array_modulos[0][4]['meta']}}</label> </td>
                <td>                    <label for="" id="mod1_h5_efic">{{$array_modulos[1][4]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod1_h5_cant">{{$array_modulos[1][4]['meta']}}</label> </td>
                <td>                    <label for="" id="mod2_h5_efic">{{$array_modulos[2][4]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod2_h5_cant">{{$array_modulos[2][4]['meta']}}</label> </td>
                <td>                    <label for="" id="mod3_h5_efic">{{$array_modulos[3][4]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod3_h5_cant">{{$array_modulos[3][4]['meta']}}</label> </td>
                <td>                    <label for="" id="mod4_h5_efic">{{$array_modulos[4][4]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod4_h5_cant">{{$array_modulos[4][4]['meta']}}</label> </td>
                <td>                    <label for="" id="mod5_h5_efic">{{$array_modulos[5][4]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod5_h5_cant">{{$array_modulos[5][4]['meta']}}</label> </td>
                <td>                    <label for="" id="mod6_h5_efic">{{$array_modulos[6][4]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod6_h5_cant">{{$array_modulos[6][4]['meta']}}</label> </td>
                <td>                    <label for="" id="mod7_h5_efic">{{$array_modulos[7][4]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod7_h5_cant">{{$array_modulos[7][4]['meta']}}</label> </td>
                <td>                    <label for="" id="mod8_h5_efic">{{$array_modulos[8][4]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod8_h5_cant">{{$array_modulos[8][4]['meta']}}</label> </td>
                <td>                    <label for="" id="mod9_h5_efic">{{$array_modulos[9][4]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod9_h5_cant">{{$array_modulos[9][4]['meta']}}</label> </td>
                <td>                    <label for="" id="mod10_h5_efic">{{$array_modulos[10][4]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod10_h5_cant">{{$array_modulos[10][4]['meta']}}</label> </td>
                <td>                    <label for="" id="mod11_h5_efic">{{$array_modulos[11][4]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod11_h5_cant">{{$array_modulos[11][4]['meta']}}</label> </td>
                <td> <label for="" id="sumtotal_h5_efic"></label> </td>
                <td> <label for="" id="sumtotal_h5_cant"></label> </td>
            </tr>

            <tr>
                <td class="drch_black"> <label for="">HORA 06</label> </td>
                <td>                    <label for="" id="mod0_h6_efic">{{$array_modulos[0][5]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod0_h6_cant">{{$array_modulos[0][5]['meta']}}</label> </td>
                <td>                    <label for="" id="mod1_h6_efic">{{$array_modulos[1][5]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod1_h6_cant">{{$array_modulos[1][5]['meta']}}</label> </td>
                <td>                    <label for="" id="mod2_h6_efic">{{$array_modulos[2][5]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod2_h6_cant">{{$array_modulos[2][5]['meta']}}</label> </td>
                <td>                    <label for="" id="mod3_h6_efic">{{$array_modulos[3][5]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod3_h6_cant">{{$array_modulos[3][5]['meta']}}</label> </td>
                <td>                    <label for="" id="mod4_h6_efic">{{$array_modulos[4][5]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod4_h6_cant">{{$array_modulos[4][5]['meta']}}</label> </td>
                <td>                    <label for="" id="mod5_h6_efic">{{$array_modulos[5][5]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod5_h6_cant">{{$array_modulos[5][5]['meta']}}</label> </td>
                <td>                    <label for="" id="mod6_h6_efic">{{$array_modulos[6][5]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod6_h6_cant">{{$array_modulos[6][5]['meta']}}</label> </td>
                <td>                    <label for="" id="mod7_h6_efic">{{$array_modulos[7][5]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod7_h6_cant">{{$array_modulos[7][5]['meta']}}</label> </td>
                <td>                    <label for="" id="mod8_h6_efic">{{$array_modulos[8][5]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod8_h6_cant">{{$array_modulos[8][5]['meta']}}</label> </td>
                <td>                    <label for="" id="mod9_h6_efic">{{$array_modulos[9][5]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod9_h6_cant">{{$array_modulos[9][5]['meta']}}</label> </td>
                <td>                    <label for="" id="mod10_h6_efic">{{$array_modulos[10][5]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod10_h6_cant">{{$array_modulos[10][5]['meta']}}</label> </td>
                <td>                    <label for="" id="mod11_h6_efic">{{$array_modulos[11][5]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod11_h6_cant">{{$array_modulos[11][5]['meta']}}</label> </td>
                <td> <label for="" id="sumtotal_h6_efic"></label> </td>
                <td> <label for="" id="sumtotal_h6_cant"></label> </td>
            </tr>

            <tr>
                <td class="drch_black"> <label for="">HORA 07</label> </td>
                <td>                    <label for="" id="mod0_h7_efic">{{$array_modulos[0][6]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod0_h7_cant">{{$array_modulos[0][6]['meta']}}</label> </td>
                <td>                    <label for="" id="mod1_h7_efic">{{$array_modulos[1][6]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod1_h7_cant">{{$array_modulos[1][6]['meta']}}</label> </td>
                <td>                    <label for="" id="mod2_h7_efic">{{$array_modulos[2][6]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod2_h7_cant">{{$array_modulos[2][6]['meta']}}</label> </td>
                <td>                    <label for="" id="mod3_h7_efic">{{$array_modulos[3][6]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod3_h7_cant">{{$array_modulos[3][6]['meta']}}</label> </td>
                <td>                    <label for="" id="mod4_h7_efic">{{$array_modulos[4][6]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod4_h7_cant">{{$array_modulos[4][6]['meta']}}</label> </td>
                <td>                    <label for="" id="mod5_h7_efic">{{$array_modulos[5][6]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod5_h7_cant">{{$array_modulos[5][6]['meta']}}</label> </td>
                <td>                    <label for="" id="mod6_h7_efic">{{$array_modulos[6][6]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod6_h7_cant">{{$array_modulos[6][6]['meta']}}</label> </td>
                <td>                    <label for="" id="mod7_h7_efic">{{$array_modulos[7][6]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod7_h7_cant">{{$array_modulos[7][6]['meta']}}</label> </td>
                <td>                    <label for="" id="mod8_h7_efic">{{$array_modulos[8][6]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod8_h7_cant">{{$array_modulos[8][6]['meta']}}</label> </td>
                <td>                    <label for="" id="mod9_h7_efic">{{$array_modulos[9][6]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod9_h7_cant">{{$array_modulos[9][6]['meta']}}</label> </td>
                <td>                    <label for="" id="mod10_h7_efic">{{$array_modulos[10][6]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod10_h7_cant">{{$array_modulos[10][6]['meta']}}</label> </td>
                <td>                    <label for="" id="mod11_h7_efic">{{$array_modulos[11][6]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod11_h7_cant">{{$array_modulos[11][6]['meta']}}</label> </td>
                <td> <label for="" id="sumtotal_h7_efic"></label> </td>
                <td> <label for="" id="sumtotal_h7_cant"></label> </td>
            </tr>

            <tr>
                <td class="drch_black"> <label for="">HORA 08</label> </td>
                <td>                    <label for="" id="mod0_h8_efic">{{$array_modulos[0][7]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod0_h8_cant">{{$array_modulos[0][7]['meta']}}</label> </td>
                <td>                    <label for="" id="mod1_h8_efic">{{$array_modulos[1][7]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod1_h8_cant">{{$array_modulos[1][7]['meta']}}</label> </td>
                <td>                    <label for="" id="mod2_h8_efic">{{$array_modulos[2][7]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod2_h8_cant">{{$array_modulos[2][7]['meta']}}</label> </td>
                <td>                    <label for="" id="mod3_h8_efic">{{$array_modulos[3][7]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod3_h8_cant">{{$array_modulos[3][7]['meta']}}</label> </td>
                <td>                    <label for="" id="mod4_h8_efic">{{$array_modulos[4][7]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod4_h8_cant">{{$array_modulos[4][7]['meta']}}</label> </td>
                <td>                    <label for="" id="mod5_h8_efic">{{$array_modulos[5][7]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod5_h8_cant">{{$array_modulos[5][7]['meta']}}</label> </td>
                <td>                    <label for="" id="mod6_h8_efic">{{$array_modulos[6][7]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod6_h8_cant">{{$array_modulos[6][7]['meta']}}</label> </td>
                <td>                    <label for="" id="mod7_h8_efic">{{$array_modulos[7][7]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod7_h8_cant">{{$array_modulos[7][7]['meta']}}</label> </td>
                <td>                    <label for="" id="mod8_h8_efic">{{$array_modulos[8][7]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod8_h8_cant">{{$array_modulos[8][7]['meta']}}</label> </td>
                <td>                    <label for="" id="mod9_h8_efic">{{$array_modulos[9][7]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod9_h8_cant">{{$array_modulos[9][7]['meta']}}</label> </td>
                <td>                    <label for="" id="mod10_h8_efic">{{$array_modulos[10][7]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod10_h8_cant">{{$array_modulos[10][7]['meta']}}</label> </td>
                <td>                    <label for="" id="mod11_h8_efic">{{$array_modulos[11][7]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod11_h8_cant">{{$array_modulos[11][7]['meta']}}</label> </td>
                <td> <label for="" id="sumtotal_h8_efic"></label> </td>
                <td> <label for="" id="sumtotal_h8_cant"></label> </td>
            </tr>

            <tr>
                <td class="drch_black"> <label for="">HORA 09</label> </td>
                <td>                    <label for="" id="mod0_h9_efic">{{$array_modulos[0][8]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod0_h9_cant">{{$array_modulos[0][8]['meta']}}</label> </td>
                <td>                    <label for="" id="mod1_h9_efic">{{$array_modulos[1][8]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod1_h9_cant">{{$array_modulos[1][8]['meta']}}</label> </td>
                <td>                    <label for="" id="mod2_h9_efic">{{$array_modulos[2][8]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod2_h9_cant">{{$array_modulos[2][8]['meta']}}</label> </td>
                <td>                    <label for="" id="mod3_h9_efic">{{$array_modulos[3][8]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod3_h9_cant">{{$array_modulos[3][8]['meta']}}</label> </td>
                <td>                    <label for="" id="mod4_h9_efic">{{$array_modulos[4][8]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod4_h9_cant">{{$array_modulos[4][8]['meta']}}</label> </td>
                <td>                    <label for="" id="mod5_h9_efic">{{$array_modulos[5][8]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod5_h9_cant">{{$array_modulos[5][8]['meta']}}</label> </td>
                <td>                    <label for="" id="mod6_h9_efic">{{$array_modulos[6][8]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod6_h9_cant">{{$array_modulos[6][8]['meta']}}</label> </td>
                <td>                    <label for="" id="mod7_h9_efic">{{$array_modulos[7][8]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod7_h9_cant">{{$array_modulos[7][8]['meta']}}</label> </td>
                <td>                    <label for="" id="mod8_h9_efic">{{$array_modulos[8][8]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod8_h9_cant">{{$array_modulos[8][8]['meta']}}</label> </td>
                <td>                    <label for="" id="mod9_h9_efic">{{$array_modulos[9][8]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod9_h9_cant">{{$array_modulos[9][8]['meta']}}</label> </td>
                <td>                    <label for="" id="mod10_h9_efic">{{$array_modulos[10][8]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod10_h9_cant">{{$array_modulos[10][8]['meta']}}</label> </td>
                <td>                    <label for="" id="mod11_h9_efic">{{$array_modulos[11][8]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod11_h9_cant">{{$array_modulos[11][8]['meta']}}</label> </td>
                <td> <label for="" id="sumtotal_h9_efic"></label> </td>
                <td> <label for="" id="sumtotal_h9_cant"></label> </td>
            </tr>

            <tr>
                <td class="drch_black"> <label for="">HORA 10</label> </td>
                <td>                    <label for="" id="mod0_h10_efic">{{$array_modulos[0][9]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod0_h10_cant">{{$array_modulos[0][9]['meta']}}</label> </td>
                <td>                    <label for="" id="mod1_h10_efic">{{$array_modulos[1][9]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod1_h10_cant">{{$array_modulos[1][9]['meta']}}</label> </td>
                <td>                    <label for="" id="mod2_h10_efic">{{$array_modulos[2][9]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod2_h10_cant">{{$array_modulos[2][9]['meta']}}</label> </td>
                <td>                    <label for="" id="mod3_h10_efic">{{$array_modulos[3][9]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod3_h10_cant">{{$array_modulos[3][9]['meta']}}</label> </td>
                <td>                    <label for="" id="mod4_h10_efic">{{$array_modulos[4][9]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod4_h10_cant">{{$array_modulos[4][9]['meta']}}</label> </td>
                <td>                    <label for="" id="mod5_h10_efic">{{$array_modulos[5][9]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod5_h10_cant">{{$array_modulos[5][9]['meta']}}</label> </td>
                <td>                    <label for="" id="mod6_h10_efic">{{$array_modulos[6][9]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod6_h10_cant">{{$array_modulos[6][9]['meta']}}</label> </td>
                <td>                    <label for="" id="mod7_h10_efic">{{$array_modulos[7][9]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod7_h10_cant">{{$array_modulos[7][9]['meta']}}</label> </td>
                <td>                    <label for="" id="mod8_h10_efic">{{$array_modulos[8][9]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod8_h10_cant">{{$array_modulos[8][9]['meta']}}</label> </td>
                <td>                    <label for="" id="mod9_h10_efic">{{$array_modulos[9][9]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod9_h10_cant">{{$array_modulos[9][9]['meta']}}</label> </td>
                <td>                    <label for="" id="mod10_h10_efic">{{$array_modulos[10][9]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod10_h10_cant">{{$array_modulos[10][9]['meta']}}</label> </td>
                <td>                    <label for="" id="mod11_h10_efic">{{$array_modulos[11][9]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod11_h10_cant">{{$array_modulos[11][9]['meta']}}</label> </td>
                <td> <label for="" id="sumtotal_h10_efic"></label> </td>
                <td> <label for="" id="sumtotal_h10_cant"></label> </td>
            </tr>

            <tr>
                <td class="drch_black"> <label for="">HORA 11</label> </td>
                <td>                    <label for="" id="mod0_h11_efic">{{$array_modulos[0][10]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod0_h11_cant">{{$array_modulos[0][10]['meta']}}</label> </td>
                <td>                    <label for="" id="mod1_h11_efic">{{$array_modulos[1][10]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod1_h11_cant">{{$array_modulos[1][10]['meta']}}</label> </td>
                <td>                    <label for="" id="mod2_h11_efic">{{$array_modulos[2][10]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod2_h11_cant">{{$array_modulos[2][10]['meta']}}</label> </td>
                <td>                    <label for="" id="mod3_h11_efic">{{$array_modulos[3][10]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod3_h11_cant">{{$array_modulos[3][10]['meta']}}</label> </td>
                <td>                    <label for="" id="mod4_h11_efic">{{$array_modulos[4][10]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod4_h11_cant">{{$array_modulos[4][10]['meta']}}</label> </td>
                <td>                    <label for="" id="mod5_h11_efic">{{$array_modulos[5][10]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod5_h11_cant">{{$array_modulos[5][10]['meta']}}</label> </td>
                <td>                    <label for="" id="mod6_h11_efic">{{$array_modulos[6][10]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod6_h11_cant">{{$array_modulos[6][10]['meta']}}</label> </td>
                <td>                    <label for="" id="mod7_h11_efic">{{$array_modulos[7][10]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod7_h11_cant">{{$array_modulos[7][10]['meta']}}</label> </td>
                <td>                    <label for="" id="mod8_h11_efic">{{$array_modulos[8][10]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod8_h11_cant">{{$array_modulos[8][10]['meta']}}</label> </td>
                <td>                    <label for="" id="mod9_h11_efic">{{$array_modulos[9][10]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod9_h11_cant">{{$array_modulos[9][10]['meta']}}</label> </td>
                <td>                    <label for="" id="mod10_h11_efic">{{$array_modulos[10][10]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod10_h11_cant">{{$array_modulos[10][10]['meta']}}</label> </td>
                <td>                    <label for="" id="mod11_h11_efic">{{$array_modulos[11][10]['cant']}}</label> </td>
                <td class="drch_black"> <label for="" id="mod11_h11_cant">{{$array_modulos[11][10]['meta']}}</label> </td>
                <td> <label for="" id="sumtotal_h11_efic"></label> </td>
                <td> <label for="" id="sumtotal_h11_cant"></label> </td>
            </tr>

            <tr>
                <td class="drch_black infe_black"> <label for="">HORA 12</label> </td>
                <td class="infe_black">            <label for="" id="mod0_h12_efic">{{$array_modulos[0][11]['cant']}}</label> </td>
                <td class="drch_black infe_black"> <label for="" id="mod0_h12_cant">{{$array_modulos[0][11]['meta']}}</label> </td>
                <td class="infe_black">            <label for="" id="mod1_h12_efic">{{$array_modulos[1][11]['cant']}}</label> </td>
                <td class="drch_black infe_black"> <label for="" id="mod1_h12_cant">{{$array_modulos[1][11]['meta']}}</label> </td>
                <td class="infe_black">            <label for="" id="mod2_h12_efic">{{$array_modulos[2][11]['cant']}}</label> </td>
                <td class="drch_black infe_black"> <label for="" id="mod2_h12_cant">{{$array_modulos[2][11]['meta']}}</label> </td>
                <td class="infe_black">            <label for="" id="mod3_h12_efic">{{$array_modulos[3][11]['cant']}}</label> </td>
                <td class="drch_black infe_black"> <label for="" id="mod3_h12_cant">{{$array_modulos[3][11]['meta']}}</label> </td>
                <td class="infe_black">            <label for="" id="mod4_h12_efic">{{$array_modulos[4][11]['cant']}}</label> </td>
                <td class="drch_black infe_black"> <label for="" id="mod4_h12_cant">{{$array_modulos[4][11]['meta']}}</label> </td>
                <td class="infe_black">            <label for="" id="mod5_h12_efic">{{$array_modulos[5][11]['cant']}}</label> </td>
                <td class="drch_black infe_black"> <label for="" id="mod5_h12_cant">{{$array_modulos[5][11]['meta']}}</label> </td>
                <td class="infe_black">            <label for="" id="mod6_h12_efic">{{$array_modulos[6][11]['cant']}}</label> </td>
                <td class="drch_black infe_black"> <label for="" id="mod6_h12_cant">{{$array_modulos[6][11]['meta']}}</label> </td>
                <td class="infe_black">            <label for="" id="mod7_h12_efic">{{$array_modulos[7][11]['cant']}}</label> </td>
                <td class="drch_black infe_black"> <label for="" id="mod7_h12_cant">{{$array_modulos[7][11]['meta']}}</label> </td>
                <td class="infe_black">            <label for="" id="mod8_h12_efic">{{$array_modulos[8][11]['cant']}}</label> </td>
                <td class="drch_black infe_black"> <label for="" id="mod8_h12_cant">{{$array_modulos[8][11]['meta']}}</label> </td>
                <td class="infe_black">            <label for="" id="mod9_h12_efic">{{$array_modulos[9][11]['cant']}}</label> </td>
                <td class="drch_black infe_black"> <label for="" id="mod9_h12_cant">{{$array_modulos[9][11]['meta']}}</label> </td>
                <td class="infe_black">            <label for="" id="mod10_h12_efic">{{$array_modulos[10][11]['cant']}}</label> </td>
                <td class="drch_black infe_black"> <label for="" id="mod10_h12_cant">{{$array_modulos[10][11]['meta']}}</label> </td>
                <td class="infe_black">            <label for="" id="mod11_h12_efic">{{$array_modulos[11][11]['cant']}}</label> </td>
                <td class="drch_black infe_black"> <label for="" id="mod11_h12_cant">{{$array_modulos[11][11]['meta']}}</label> </td>
                <td class="infe_black"> <label for="" id="sumtotal_h12_efic"></label> </td>
                <td class="infe_black"> <label for="" id="sumtotal_h12_cant"></label> </td>
            </tr>

            <tr>
                <td class="drch_black"> <label for="">TOTALES</label> </td>
                <td> <label for="" id="mod0_efic_total"></label> </td>
                <td> <label for="" id="mod0_cant_total"></label> </td>
                <td> <label for="" id="mod1_efic_total"></label> </td>
                <td> <label for="" id="mod1_cant_total"></label> </td>
                <td> <label for="" id="mod2_efic_total"></label> </td>
                <td> <label for="" id="mod2_cant_total"></label> </td>
                <td> <label for="" id="mod3_efic_total"></label> </td>
                <td> <label for="" id="mod3_cant_total"></label> </td>
                <td> <label for="" id="mod4_efic_total"></label> </td>
                <td> <label for="" id="mod4_cant_total"></label> </td>
                <td> <label for="" id="mod5_efic_total"></label> </td>
                <td> <label for="" id="mod5_cant_total"></label> </td>
                <td> <label for="" id="mod6_efic_total"></label> </td>
                <td> <label for="" id="mod6_cant_total"></label> </td>
                <td> <label for="" id="mod7_efic_total"></label> </td>
                <td> <label for="" id="mod7_cant_total"></label> </td>
                <td> <label for="" id="mod8_efic_total"></label> </td>
                <td> <label for="" id="mod8_cant_total"></label> </td>
                <td> <label for="" id="mod9_efic_total"></label> </td>
                <td> <label for="" id="mod9_cant_total"></label> </td>
                <td> <label for="" id="mod10_efic_total"></label> </td>
                <td> <label for="" id="mod10_cant_total"></label> </td>
                <td> <label for="" id="mod11_efic_total"></label> </td>
                <td> <label for="" id="mod11_cant_total"></label> </td>
                <td> <label for="" id="sumt_efic_total"></label> </td>
                <td> <label for="" id="sumt_cant_total"></label> </td>
            </tr>

            <tr>
                <td class="drch_black"> <label for="">TOTAL HORA</label> </td>
                <td> <label for="" id="mod0_efic_hora"></label> </td>
                <td> <label for="" id="mod0_cant_hora"></label> </td>
                <td> <label for="" id="mod1_efic_hora"></label> </td>
                <td> <label for="" id="mod1_cant_hora"></label> </td>
                <td> <label for="" id="mod2_efic_hora"></label> </td>
                <td> <label for="" id="mod2_cant_hora"></label> </td>
                <td> <label for="" id="mod3_efic_hora"></label> </td>
                <td> <label for="" id="mod3_cant_hora"></label> </td>
                <td> <label for="" id="mod4_efic_hora"></label> </td>
                <td> <label for="" id="mod4_cant_hora"></label> </td>
                <td> <label for="" id="mod5_efic_hora"></label> </td>
                <td> <label for="" id="mod5_cant_hora"></label> </td>
                <td> <label for="" id="mod6_efic_hora"></label> </td>
                <td> <label for="" id="mod6_cant_hora"></label> </td>
                <td> <label for="" id="mod7_efic_hora"></label> </td>
                <td> <label for="" id="mod7_cant_hora"></label> </td>
                <td> <label for="" id="mod8_efic_hora"></label> </td>
                <td> <label for="" id="mod8_cant_hora"></label> </td>
                <td> <label for="" id="mod9_efic_hora"></label> </td>
                <td> <label for="" id="mod9_cant_hora"></label> </td>
                <td> <label for="" id="mod10_efic_hora"></label> </td>
                <td> <label for="" id="mod10_cant_hora"></label> </td>
                <td> <label for="" id="mod11_efic_hora"></label> </td>
                <td> <label for="" id="mod11_cant_hora"></label> </td>
                <td> <label for="" id="sumt_efic_hora"></label> </td>
                <td> <label for="" id="sumt_cant_hora"></label> </td>
            </tr>

            <tr>
                <td class="drch_black"> <label for="">EFICIENCIA</label> </td>
                <td colspan="2" id="0"> <label for="" id="efic_mod0"></label> </td>
                <td colspan="2" id="1"> <label for="" id="efic_mod1"></label> </td>
                <td colspan="2" id="2"> <label for="" id="efic_mod2"></label> </td>
                <td colspan="2" id="3"> <label for="" id="efic_mod3"></label> </td>
                <td colspan="2" id="4"> <label for="" id="efic_mod4"></label> </td>
                <td colspan="2" id="5"> <label for="" id="efic_mod5"></label> </td>
                <td colspan="2" id="6"> <label for="" id="efic_mod6"></label> </td>
                <td colspan="2" id="7"> <label for="" id="efic_mod7"></label> </td>
                <td colspan="2" id="8"> <label for="" id="efic_mod8"></label> </td>
                <td colspan="2" id="9"> <label for="" id="efic_mod9"></label> </td>
                <td colspan="2" id="10"> <label for="" id="efic_mod10"></label> </td>
                <td colspan="2" id="11"> <label for="" id="efic_mod11"></label> </td>
                <td colspan="2" id="t"> <label for="" id="efic_total"></label> </td>
            </tr>
        </table>
</body>
</div>
</div>
</div>
</div>

@endsection

@push('scripts-custom')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function(){
        
        function modulo0(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=1;i<=12;i++){
                let prds = "mod0_h".concat(i).concat('_efic');
                let cant = "mod0_h".concat(i).concat('_cant');
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
            }
            document.getElementById('mod0_efic_total').innerHTML = prendas;
            document.getElementById('mod0_cant_total').innerHTML = cantidad;
            
        };

        function modulo1(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=1;i<=12;i++){
                let prds = "mod1_h".concat(i).concat('_efic');
                let cant = "mod1_h".concat(i).concat('_cant');
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
            }
            document.getElementById('mod1_efic_total').innerHTML = prendas;
            document.getElementById('mod1_cant_total').innerHTML = cantidad;
            
        };

        function modulo2(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=1;i<=12;i++){
                let prds = "mod2_h".concat(i).concat('_efic');
                let cant = "mod2_h".concat(i).concat('_cant');
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
            }
            document.getElementById('mod2_efic_total').innerHTML = prendas;
            document.getElementById('mod2_cant_total').innerHTML = cantidad;
            
        };

        function modulo3(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=1;i<=12;i++){
                let prds = "mod3_h".concat(i).concat('_efic');
                let cant = "mod3_h".concat(i).concat('_cant');
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
            }
            document.getElementById('mod3_efic_total').innerHTML = prendas;
            document.getElementById('mod3_cant_total').innerHTML = cantidad;
            
        };

        function modulo4(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=1;i<=12;i++){
                let prds = "mod4_h".concat(i).concat('_efic');
                let cant = "mod4_h".concat(i).concat('_cant');
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
            }
            document.getElementById('mod4_efic_total').innerHTML = prendas;
            document.getElementById('mod4_cant_total').innerHTML = cantidad;
            
        };

        function modulo5(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=1;i<=12;i++){
                let prds = "mod5_h".concat(i).concat('_efic');
                let cant = "mod5_h".concat(i).concat('_cant');
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
            }
            document.getElementById('mod5_efic_total').innerHTML = prendas;
            document.getElementById('mod5_cant_total').innerHTML = cantidad;
            
        };

        function modulo6(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=1;i<=12;i++){
                let prds = "mod6_h".concat(i).concat('_efic');
                let cant = "mod6_h".concat(i).concat('_cant');
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
            }
            document.getElementById('mod6_efic_total').innerHTML = prendas;
            document.getElementById('mod6_cant_total').innerHTML = cantidad;
            
        };

        function modulo7(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=1;i<=12;i++){
                let prds = "mod7_h".concat(i).concat('_efic');
                let cant = "mod7_h".concat(i).concat('_cant');
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
            }
            document.getElementById('mod7_efic_total').innerHTML = prendas;
            document.getElementById('mod7_cant_total').innerHTML = cantidad;
            
        };

        function modulo8(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=1;i<=12;i++){
                let prds = "mod8_h".concat(i).concat('_efic');
                let cant = "mod8_h".concat(i).concat('_cant');
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
            }
            document.getElementById('mod8_efic_total').innerHTML = prendas;
            document.getElementById('mod8_cant_total').innerHTML = cantidad;
            
        };

        function modulo9(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=1;i<=12;i++){
                let prds = "mod9_h".concat(i).concat('_efic');
                let cant = "mod9_h".concat(i).concat('_cant');
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
            }
            document.getElementById('mod9_efic_total').innerHTML = prendas;
            document.getElementById('mod9_cant_total').innerHTML = cantidad;
            
        };
        
        function modulo10(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=1;i<=12;i++){
                let prds = "mod10_h".concat(i).concat('_efic');
                let cant = "mod10_h".concat(i).concat('_cant');
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
            }
            document.getElementById('mod10_efic_total').innerHTML = prendas;
            document.getElementById('mod10_cant_total').innerHTML = cantidad;
            
        };
        
        function modulo11(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=1;i<=12;i++){
                let prds = "mod11_h".concat(i).concat('_efic');
                let cant = "mod11_h".concat(i).concat('_cant');
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
            }
            document.getElementById('mod11_efic_total').innerHTML = prendas;
            document.getElementById('mod11_cant_total').innerHTML = cantidad;
            
        };

        function hora1(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=0;i<=11;i++){
                let prds = "mod".concat(i).concat("_h1_efic");
                let cant = "mod".concat(i).concat("_h1_cant");
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
            }
            document.getElementById('sumtotal_h1_efic').innerHTML = prendas;
            document.getElementById('sumtotal_h1_cant').innerHTML = cantidad;
        }

        function hora2(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=0;i<=11;i++){
                let prds = "mod".concat(i).concat("_h2_efic");
                let cant = "mod".concat(i).concat("_h2_cant");
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
            }
            document.getElementById('sumtotal_h2_efic').innerHTML = prendas;
            document.getElementById('sumtotal_h2_cant').innerHTML = cantidad;
        }

        function hora3(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=0;i<=11;i++){
                let prds = "mod".concat(i).concat("_h3_efic");
                let cant = "mod".concat(i).concat("_h3_cant");
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
            }
            document.getElementById('sumtotal_h3_efic').innerHTML = prendas;
            document.getElementById('sumtotal_h3_cant').innerHTML = cantidad;
        }

        function hora4(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=0;i<=11;i++){
                let prds = "mod".concat(i).concat("_h4_efic");
                let cant = "mod".concat(i).concat("_h4_cant");
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
            }
            document.getElementById('sumtotal_h4_efic').innerHTML = prendas;
            document.getElementById('sumtotal_h4_cant').innerHTML = cantidad;
        }

        function hora5(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=0;i<=11;i++){
                let prds = "mod".concat(i).concat("_h5_efic");
                let cant = "mod".concat(i).concat("_h5_cant");
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
            }
            document.getElementById('sumtotal_h5_efic').innerHTML = prendas;
            document.getElementById('sumtotal_h5_cant').innerHTML = cantidad;
        }

        function hora6(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=0;i<=11;i++){
                let prds = "mod".concat(i).concat("_h6_efic");
                let cant = "mod".concat(i).concat("_h6_cant");
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
            }
            document.getElementById('sumtotal_h6_efic').innerHTML = prendas;
            document.getElementById('sumtotal_h6_cant').innerHTML = cantidad;
        }

        function hora7(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=0;i<=11;i++){
                let prds = "mod".concat(i).concat("_h7_efic");
                let cant = "mod".concat(i).concat("_h7_cant");
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
            }
            document.getElementById('sumtotal_h7_efic').innerHTML = prendas;
            document.getElementById('sumtotal_h7_cant').innerHTML = cantidad;
        }

        function hora8(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=0;i<=11;i++){
                let prds = "mod".concat(i).concat("_h8_efic");
                let cant = "mod".concat(i).concat("_h8_cant");
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
            }
            document.getElementById('sumtotal_h8_efic').innerHTML = prendas;
            document.getElementById('sumtotal_h8_cant').innerHTML = cantidad;
        }

        function hora9(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=0;i<=11;i++){
                let prds = "mod".concat(i).concat("_h9_efic");
                let cant = "mod".concat(i).concat("_h9_cant");
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
            }
            document.getElementById('sumtotal_h9_efic').innerHTML = prendas;
            document.getElementById('sumtotal_h9_cant').innerHTML = cantidad;
        }

        function hora10(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=0;i<=11;i++){
                let prds = "mod".concat(i).concat("_h10_efic");
                let cant = "mod".concat(i).concat("_h10_cant");
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
            }
            document.getElementById('sumtotal_h10_efic').innerHTML = prendas;
            document.getElementById('sumtotal_h10_cant').innerHTML = cantidad;
        }

        function hora11(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=0;i<=11;i++){
                let prds = "mod".concat(i).concat("_h11_efic");
                let cant = "mod".concat(i).concat("_h11_cant");
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
            }
            document.getElementById('sumtotal_h11_efic').innerHTML = prendas;
            document.getElementById('sumtotal_h11_cant').innerHTML = cantidad;
        }

        function hora12(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=0;i<=11;i++){
                let prds = "mod".concat(i).concat("_h12_efic");
                let cant = "mod".concat(i).concat("_h12_cant");
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
            }
            document.getElementById('sumtotal_h12_efic').innerHTML = prendas;
            document.getElementById('sumtotal_h12_cant').innerHTML = cantidad;
        }

        function sumaTotal(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=1;i<=12;i++){
                let prds = "sumtotal_h".concat(i).concat("_efic");
                let cant = "sumtotal_h".concat(i).concat("_cant");
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
            }
            document.getElementById('sumt_efic_total').innerHTML = prendas;
            document.getElementById('sumt_cant_total').innerHTML = cantidad;
            
        }
        
        function modulo0Hora(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=1;i<=12;i++){
                let prds = "mod0_h".concat(i).concat('_efic');
                let cant = "mod0_h".concat(i).concat('_cant');
                if(parseInt(document.getElementById(prds).innerHTML)>0){
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
                }
            }
            let eficiencia = ((prendas/cantidad)*100).toFixed(2);
            document.getElementById('mod0_efic_hora').innerHTML = prendas;
            document.getElementById('mod0_cant_hora').innerHTML = cantidad;
            document.getElementById('efic_mod0').innerHTML = eficiencia.concat(" %");

            if(eficiencia>=0 && eficiencia<70){
                $('#0').css({ "background": "#F44336", });
                $("#efic_mod0").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=70 && eficiencia<80){
                $('#0').css({ "background": "#ffff00", });
                $("#efic_mod0").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=80 && eficiencia<100){
                $('#0').css({ "background": "#66FF00", });
                $("#efic_mod0").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=100){
                $('#0').css({ "background": "#00EDB2", });
                $("#efic_mod0").css({"color": "white", "font-weight": "bold",});
            }
        }

        function modulo1Hora(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=1;i<=12;i++){
                let prds = "mod1_h".concat(i).concat('_efic');
                let cant = "mod1_h".concat(i).concat('_cant');
                if(parseInt(document.getElementById(prds).innerHTML)>0){
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
                }
            }
            let eficiencia = ((prendas/cantidad)*100).toFixed(2);
            document.getElementById('mod1_efic_hora').innerHTML = prendas;
            document.getElementById('mod1_cant_hora').innerHTML = cantidad;
            document.getElementById('efic_mod1').innerHTML = eficiencia.concat(" %");

            if(eficiencia>=0 && eficiencia<70){
                $('#1').css({ "background": "#F44336", });
                $("#efic_mod1").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=70 && eficiencia<80){
                $('#1').css({ "background": "#ffff00", });
                $("#efic_mod1").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=80 && eficiencia<100){
                $('#1').css({ "background": "#66FF00", });
                $("#efic_mod1").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=100){
                $('#1').css({ "background": "#00EDB2", });
                $("#efic_mod1").css({"color": "white", "font-weight": "bold",});
            }
        }

        function modulo2Hora(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=1;i<=12;i++){
                let prds = "mod2_h".concat(i).concat('_efic');
                let cant = "mod2_h".concat(i).concat('_cant');
                if(parseInt(document.getElementById(prds).innerHTML)>0){
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
                }
            }
            document.getElementById('mod2_efic_hora').innerHTML = prendas;
            document.getElementById('mod2_cant_hora').innerHTML = cantidad;
            let eficiencia = ((prendas/cantidad)*100).toFixed(2);
            document.getElementById('efic_mod2').innerHTML = eficiencia.concat(" %");
            if(eficiencia>=0 && eficiencia<70){
                $('#2').css({ "background": "#F44336", });
                $("#efic_mod2").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=70 && eficiencia<80){
                $('#2').css({ "background": "#ffff00", });
                $("#efic_mod2").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=80 && eficiencia<100){
                $('#2').css({ "background": "#66FF00", });
                $("#efic_mod2").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=100){
                $('#2').css({ "background": "#00EDB2", });
                $("#efic_mod2").css({"color": "white", "font-weight": "bold",});
            }
        }

        function modulo3Hora(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=1;i<=12;i++){
                let prds = "mod3_h".concat(i).concat('_efic');
                let cant = "mod3_h".concat(i).concat('_cant');
                if(parseInt(document.getElementById(prds).innerHTML)>0){
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
                }
            }
            document.getElementById('mod3_efic_hora').innerHTML = prendas;
            document.getElementById('mod3_cant_hora').innerHTML = cantidad;
            let eficiencia = ((prendas/cantidad)*100).toFixed(2);
            document.getElementById('efic_mod3').innerHTML = eficiencia.concat(" %");
            if(eficiencia>=0 && eficiencia<70){
                $('#3').css({ "background": "#F44336", });
                $("#efic_mod3").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=70 && eficiencia<80){
                $('#3').css({ "background": "#ffff00", });
                $("#efic_mod3").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=80 && eficiencia<100){
                $('#3').css({ "background": "#66FF00", });
                $("#efic_mod3").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=100){
                $('#3').css({ "background": "#00EDB2", });
                $("#efic_mod3").css({"color": "white", "font-weight": "bold",});
            }
        }

        function modulo4Hora(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=1;i<=12;i++){
                let prds = "mod4_h".concat(i).concat('_efic');
                let cant = "mod4_h".concat(i).concat('_cant');
                if(parseInt(document.getElementById(prds).innerHTML)>0){
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
                }
            }
            document.getElementById('mod4_efic_hora').innerHTML = prendas;
            document.getElementById('mod4_cant_hora').innerHTML = cantidad;
            let eficiencia = ((prendas/cantidad)*100).toFixed(2);
            document.getElementById('efic_mod4').innerHTML = eficiencia.concat(" %");
            if(eficiencia>=0 && eficiencia<70){
                $('#4').css({ "background": "#F44336", });
                $("#efic_mod4").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=70 && eficiencia<80){
                $('#4').css({ "background": "#ffff00", });
                $("#efic_mod4").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=80 && eficiencia<100){
                $('#4').css({ "background": "#66FF00", });
                $("#efic_mod4").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=100){
                $('#4').css({ "background": "#00EDB2", });
                $("#efic_mod4").css({"color": "white", "font-weight": "bold",});
            }
        }
        
        function modulo5Hora(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=1;i<=12;i++){
                let prds = "mod5_h".concat(i).concat('_efic');
                let cant = "mod5_h".concat(i).concat('_cant');
                if(parseInt(document.getElementById(prds).innerHTML)>0){
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
                }
            }
            document.getElementById('mod5_efic_hora').innerHTML = prendas;
            document.getElementById('mod5_cant_hora').innerHTML = cantidad;
            let eficiencia = ((prendas/cantidad)*100).toFixed(2);
            document.getElementById('efic_mod5').innerHTML = eficiencia.concat(" %");
            if(eficiencia>=0 && eficiencia<70){
                $('#5').css({ "background": "#F44336", });
                $("#efic_mod5").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=70 && eficiencia<80){
                $('#5').css({ "background": "#ffff00", });
                $("#efic_mod5").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=80 && eficiencia<100){
                $('#5').css({ "background": "#66FF00", });
                $("#efic_mod5").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=100){
                $('#5').css({ "background": "#00EDB2", });
                $("#efic_mod5").css({"color": "white", "font-weight": "bold",});
            }
        }

        function modulo6Hora(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=1;i<=12;i++){
                let prds = "mod6_h".concat(i).concat('_efic');
                let cant = "mod6_h".concat(i).concat('_cant');
                if(parseInt(document.getElementById(prds).innerHTML)>0){
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
                }
            }
            document.getElementById('mod6_efic_hora').innerHTML = prendas;
            document.getElementById('mod6_cant_hora').innerHTML = cantidad;
            let eficiencia = ((prendas/cantidad)*100).toFixed(2);
            document.getElementById('efic_mod6').innerHTML = eficiencia.concat(" %");
            if(eficiencia>=0 && eficiencia<70){
                $('#6').css({ "background": "#F44336", });
                $("#efic_mod6").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=70 && eficiencia<80){
                $('#6').css({ "background": "#ffff00", });
                $("#efic_mod6").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=80 && eficiencia<100){
                $('#6').css({ "background": "#66FF00", });
                $("#efic_mod6").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=100){
                $('#6').css({ "background": "#00EDB2", });
                $("#efic_mod6").css({"color": "white", "font-weight": "bold",});
            }
        }

        function modulo7Hora(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=1;i<=12;i++){
                let prds = "mod7_h".concat(i).concat('_efic');
                let cant = "mod7_h".concat(i).concat('_cant');
                if(parseInt(document.getElementById(prds).innerHTML)>0){
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
                }
            }
            document.getElementById('mod7_efic_hora').innerHTML = prendas;
            document.getElementById('mod7_cant_hora').innerHTML = cantidad;
            let eficiencia = ((prendas/cantidad)*100).toFixed(2);
            document.getElementById('efic_mod7').innerHTML = eficiencia.concat(" %");
            if(eficiencia>=0 && eficiencia<70){
                $('#7').css({ "background": "#F44336", });
                $("#efic_mod7").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=70 && eficiencia<80){
                $('#7').css({ "background": "#ffff00", });
                $("#efic_mod7").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=80 && eficiencia<100){
                $('#7').css({ "background": "#66FF00", });
                $("#efic_mod7").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=100){
                $('#7').css({ "background": "#00EDB2", });
                $("#efic_mod7").css({"color": "white", "font-weight": "bold",});
            }
        }

        function modulo8Hora(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=1;i<=12;i++){
                let prds = "mod8_h".concat(i).concat('_efic');
                let cant = "mod8_h".concat(i).concat('_cant');
                if(parseInt(document.getElementById(prds).innerHTML)>0){
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
                }
            }
            document.getElementById('mod8_efic_hora').innerHTML = prendas;
            document.getElementById('mod8_cant_hora').innerHTML = cantidad;
            let eficiencia = ((prendas/cantidad)*100).toFixed(2);
            document.getElementById('efic_mod8').innerHTML = eficiencia.concat(" %");
            if(eficiencia>=0 && eficiencia<70){
                $('#8').css({ "background": "#F44336", });
                $("#efic_mod8").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=70 && eficiencia<80){
                $('#8').css({ "background": "#ffff00", });
                $("#efic_mod8").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=80 && eficiencia<100){
                $('#8').css({ "background": "#66FF00", });
                $("#efic_mod8").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=100){
                $('#8').css({ "background": "#00EDB2", });
                $("#efic_mod8").css({"color": "white", "font-weight": "bold",});
            }
        }

        function modulo9Hora(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=1;i<=12;i++){
                let prds = "mod9_h".concat(i).concat('_efic');
                let cant = "mod9_h".concat(i).concat('_cant');
                if(parseInt(document.getElementById(prds).innerHTML)>0){
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
                }
            }
            document.getElementById('mod9_efic_hora').innerHTML = prendas;
            document.getElementById('mod9_cant_hora').innerHTML = cantidad;
            let eficiencia = ((prendas/cantidad)*100).toFixed(2);
            document.getElementById('efic_mod9').innerHTML = eficiencia.concat(" %");
            if(eficiencia>=0 && eficiencia<70){
                $('#9').css({ "background": "#F44336", });
                $("#efic_mod9").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=70 && eficiencia<80){
                $('#9').css({ "background": "#ffff00", });
                $("#efic_mod9").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=80 && eficiencia<100){
                $('#9').css({ "background": "#66FF00", });
                $("#efic_mod9").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=100){
                $('#9').css({ "background": "#00EDB2", });
                $("#efic_mod9").css({"color": "white", "font-weight": "bold",});
            }
        }
        
        function modulo10Hora(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=1;i<=12;i++){
                let prds = "mod10_h".concat(i).concat('_efic');
                let cant = "mod10_h".concat(i).concat('_cant');
                if(parseInt(document.getElementById(prds).innerHTML)>0){
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
                }
            }
            document.getElementById('mod10_efic_hora').innerHTML = prendas;
            document.getElementById('mod10_cant_hora').innerHTML = cantidad;
            let eficiencia = ((prendas/cantidad)*100).toFixed(2);
            document.getElementById('efic_mod10').innerHTML = eficiencia.concat(" %");
            if(eficiencia>=0 && eficiencia<70){
                $('#10').css({ "background": "#F44336", });
                $("#efic_mod10").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=70 && eficiencia<80){
                $('#10').css({ "background": "#ffff00", });
                $("#efic_mod10").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=80 && eficiencia<100){
                $('#10').css({ "background": "#66FF00", });
                $("#efic_mod10").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=100){
                $('#10').css({ "background": "#00EDB2", });
                $("#efic_mod10").css({"color": "white", "font-weight": "bold",});
            }
        }
        
        function modulo11Hora(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=1;i<=12;i++){
                let prds = "mod11_h".concat(i).concat('_efic');
                let cant = "mod11_h".concat(i).concat('_cant');
                if(parseInt(document.getElementById(prds).innerHTML)>0){
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
                }
            }
            document.getElementById('mod11_efic_hora').innerHTML = prendas;
            document.getElementById('mod11_cant_hora').innerHTML = cantidad;
            let eficiencia = ((prendas/cantidad)*100).toFixed(2);
            document.getElementById('efic_mod11').innerHTML = eficiencia.concat(" %");
            if(eficiencia>=0 && eficiencia<70){
                $('#11').css({ "background": "#F44336", });
                $("#efic_mod11").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=70 && eficiencia<80){
                $('#11').css({ "background": "#ffff00", });
                $("#efic_mod11").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=80 && eficiencia<100){
                $('#11').css({ "background": "#66FF00", });
                $("#efic_mod11").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=100){
                $('#11').css({ "background": "#00EDB2", });
                $("#efic_mod11").css({"color": "white", "font-weight": "bold",});
            }
        }

        function sumaHora(){
            let prendas = 0;
            let cantidad = 0;
            for(let i=1;i<=12;i++){
                let prds = "sumtotal_h".concat(i).concat('_efic');
                let cant = "sumtotal_h".concat(i).concat('_cant');
                if(parseInt(document.getElementById(prds).innerHTML)>0){
                prendas = prendas + parseInt(document.getElementById(prds).innerHTML);
                cantidad = cantidad + parseInt(document.getElementById(cant).innerHTML);
                }
            }
            document.getElementById('sumt_efic_hora').innerHTML = prendas;
            document.getElementById('sumt_cant_hora').innerHTML = cantidad;
            let eficiencia = ((prendas/cantidad)*100).toFixed(2);
            document.getElementById('efic_total').innerHTML = eficiencia.concat(" %");
            if(eficiencia>=0 && eficiencia<70){
                $('#t').css({ "background": "#F44336", });
                $("#efic_total").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=70 && eficiencia<80){
                $('#t').css({ "background": "#ffff00", });
                $("#efic_total").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=80 && eficiencia<100){
                $('#t').css({ "background": "#66FF00", });
                $("#efic_total").css({"color": "white", "font-weight": "bold",});
            }else if(eficiencia>=100){
                $('#t').css({ "background": "#00EDB2", });
                $("#efic_total").css({"color": "white", "font-weight": "bold",});
            }
        }
        modulo0();
        modulo1();
        modulo2();
        modulo3();
        modulo4();
        modulo5();
        modulo6();
        modulo7();
        modulo8();
        modulo9();
        modulo10();
        modulo11();

        hora1();
        hora2();
        hora3();
        hora4();
        hora5();
        hora6();
        hora7();
        hora8();
        hora9();
        hora10();
        hora11();
        hora12();

        sumaTotal();
        
        modulo0Hora();
        modulo1Hora();
        modulo2Hora();
        modulo3Hora();
        modulo4Hora();
        modulo5Hora();
        modulo6Hora();
        modulo7Hora();
        modulo8Hora();
        modulo9Hora();
        modulo10Hora();
        modulo11Hora();

        sumaHora();
        $(".wrapper").addClass("sidebar_minimize");
        setTimeout('document.location.reload()',60000);
    })

</script>
@endpush