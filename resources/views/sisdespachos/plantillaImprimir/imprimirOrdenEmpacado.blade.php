<?php
$medidaTicket = 180;

?>
<!DOCTYPE html>
<html>

<head>

    <style>
        * {
            font-size: 12px;
            font-family: 'Century Gothic', serif;
        }

        h1 {
            font-size: 18px;
        }

        .ticket {
            margin: 2px;
        }

        td,
        th,
        tr,
        table {
            border-top: 1px solid black;
            border-collapse: collapse;
            margin: 0 auto;
        }

        td.precio {
            text-align: right;
            font-size: 11px;
        }

        td.cantidad {
            font-size: 11px;
        }

        td.producto {
            text-align: center;
        }

        th {
            text-align: center;
        }
        .p-23{
            padding:23px;
        }
        .izquierda{
            text-align: left;
            align-content: left;
        }
        .centrado {
            text-align: center;
            align-content: center;
        }

        .ticket {
            padding-top:60px !important;
            padding-left:60px !important;
            max-width: 8.5in;
            height:5.5in;
        }

        img {
            max-width: inherit;
            width: inherit;
        }

        * {
            margin: 0;
            padding: 0;
        }

        .ticket {
            margin: 0;
            padding: 0;
        }
        .contiene{
            display:flex;
        }
        .pb-10{
            padding-bottom:10px;
        }

        body {
            text-align: center;
        }
        
        .text-center{
            text-align:center;
        }
        
    </style>
</head>

<body>
    <div class="ticket">
        <div class="contiene text-center">
            <div class="izquierda p-23">
                <h1>ORDEN DE EMPACADO</h1>
                <h2 class="pb-10">ID : {{$consecutivo}}</h2>
                {!!QrCode::size(190)->generate($ordendespachoid.'') !!}
                <b style="font-size:3em;">{{$ordendespachoid}}</b>
                <br>
                <b style="font-size:1em; text-align:justify; width:23px">Numero de consecutivo de despacho</b>
            </div>
            <div class="centrado p-23">
                <h1 class="pb-10">ORDEN DE CONSECUTIVO</h1>
                {!!QrCode::size(190)->generate($ordendespachoid.'') !!}
            </div>
            <div class="derecha p-23">
                 <h1 class="pb-10">VISUALIZACION DIRECTA</h1>
                {!!QrCode::size(190)->generate(asset('sisdespachos/ordenes-despacho/viewEmpacado/'.$consecutivo))!!}
            </div>
        </div>
        <div class="otroContenedor" style="text-align:right">
            <b style="font-size:6em;">{{$ordendespachoid}}</b>
            <br>
            Revisión y Empacado realizado por el operario {{$alista}} el dia 28/01/2022 8:40 a.m.
            <br>
            Bless Manufacturing S.A.S  | SIVER SOFTWARE | 2021 | Departamento Desarrollo Tecnologico. YG
        </div>
        
    </div>
</body>

</html>