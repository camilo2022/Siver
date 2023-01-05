<?php


namespace App\Exports;


use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class CorreriasActualesExport implements FromArray, Responsable, WithHeadings, WithTitle
{
    use Exportable;

    private $fecha1;
    private $fecha2;
    private $listadoCorrerias;

    public function __construct($listado)
    {
        $this->listadoCorrerias = $listado;
    }
    
    public function headings(): array
    {
        return [
            "Correria",
            "Tipo",
            "Id Amarrador",
            "Estado Pedido",
            "Estado Cartera",
            "Codigo",
            "Fecha",
            "Vendedor",
            "Ped",
            "Observacion",
            "Nit",
            "Cliente",
            "Zona",
            "Prioridad",
            "Direccion",
            "Departamento",
            "Ciudad",
            "Referencia",
            "Color",
            "Identificador",
            "4",
            "6",
            "8",
            "10",
            "12",
            "14",
            "16",
            "18",
            "20",
            "22",
            "24",
            "26",
            "28",
            "30",
            "32",
            "34",
            "36",
            "38",
            "XS",
            "S",
            "M",
            "L",
            "XL",
            "Total",
            "Marca",
            "Pedido",
            "Existencia",
            "ESTADO DESPACHO",
            "TIPO DESPACHO",
            "FECHA DESPACHO",
            "FILTRO",
            "TIPO VENDEDOR"
            ];
        
    }
    
    public function title(): string
    {
        return 'CorreriasActuales2022';
    }
    
    public function array(): array
    {
       $array = [];
       $rows = $this->listadoCorrerias;
            $i=0;
            foreach ($rows as $row) {
                
                if($row->zona == 'ANTIOQUIA'){
                $tipovendedor="PERIFERIA";
                }else{
                $tipovendedor="NACIONAL";
                }
               
                if($row->marca == '1'){
                    $marca = "ZARETH PREMIUM";
                }else if($row->marca == '2'){
                    $marca = "STARA GIRLS";
                }else if($row->marca == '3'){             
                    $marca = "STARA";
            	}else if($row->marca == '4'){                  
                    $marca = "ZARETH TEENS";
            	}else if($row->marca == '5'){
                    $marca = "BLESS";
            	}else if($row->marca == '6'){
                    $marca = "BLESS 23 JUNIOR";
            	}else if($row->marca == '7'){
                    $marca = "ZARETH";
            	}else if($row->marca == '8'){
                    $marca = "BLESS 23";
            	}else if($row->marca == '9'){
                    $marca = "SHIREL";
            	}else if($row->marca == 'H'){
                    $marca = "STARA MEN";
                }else if($row->marca == 'E'){
                    $marca = "ZARETH EXPORTACION";
            	}else if($row->marca == 'S'){
                $var=substr($row->referencia ,0 ,3);
                    if ( $var[0] == 'S' && $var[1] == 'T' && $var[2] == 'G') {
                        $marca = "STARA BLUSAS";
                    }else{
                        $marca = "SIN DEFINIR";
                     } 
                }else if($row->marca == 'M' ||$row->marca == 'm'  ){
                    $marca = "MICHELL V";
            	}else if($row->marca == 'F'){
                $var=substr($row->referencia ,0 ,2);
                    if ( $var[0] == 'F' && $var[1] == 'V') {
                        $marca = "FIANCHI VIP";
                    }else if($var[0] == 'F' && $var[1] == 'R'){
                        $marca = "FARFALLA";
                    }else{
                            $marca = "FLOW";
                    }                
            	}else if($row->marca == 'B'){
                $var=substr($row->referencia ,0 ,2);
                     if ( $var[0] == 'B' && $var[1] == 'Z') {
                        $marca = "ESTILOS BZ";
                    }else{
                        $marca = "ZARETH CURVI PLUS";
                    }                 
            	}else if($row->marca == 'D'){
                    $marca = "DHARA";
            	}else if($row->marca == 'Z'){
                    $marca = "STORE";
            	}else if($row->marca == 'K'){
                    $marca = "STARA KIDS";
            	}else if($row->marca == 'C'){
                $var=substr($row->referencia ,0 ,2);
                    if ( $var[0] == 'C' && $var[1] == 'R') {
                        $marca = "CALIFORNIA";
                    }else if($var[0] == 'C' && $var[1] == 'M'){
                        $marca = "CALIFORNIA MEN";
                    }else if($var[0] == 'C' && $var[1] == 'K'){
                         $marca = "CALIFORNIA KIDS";
                    }else if($var[0] == 'C' && $var[1] == 'T'){
                        $marca = "CALIFORNIA TEENS";
                    }else{
                         $marca = "CLASIC SHIREL";
                    }             
            	}else if($row->marca == 'L'){
                $var=substr($row->referencia ,0 ,2);
                    if ( $var[0] == 'L' && $var[1] == 'R') {
                        $marca = "LOA RIGIDO";
                    }else if($var[0] == 'L' && $var[1] == 'S'){
                        $marca = "LOA STRECH";
                    }else{
                        $marca = "LOA";
                   } 
                                                
            	}else if($row->marca == 'O'){
                    $marca = "BLESS ORIGINAL";
            	}else if($row->marca == 'P'){
                    $marca = "ZARETH PREMIUM";
            	} else if($row->marca == 'A'){
                    $marca = "ALFA LEGACY";
            	} else if($row->marca == 'N'){
                    $marca = "NEON";
            	}else if($row->marca == 'N'){
                $var=substr($row->referencia ,0 ,2);
                    if ( $var[0] == 'N' && $var[1] == 'E') {
                        $marca = "NEON CAMISA";
                        }else if($var[0] == 'N' && $var[1] == 'K'){
                            $marca = "NEON KIDS";
                        }else if($var[0] == 'N' && $var[1] == 'B'){
                            $marca = "NEON CAMISA NIﾃ前";
                        }else{
                            $marca = "NEON PANTALON";
                    } 
                }else if($row->marca == 'Y'){
                $var=substr($row->referencia ,0 ,2);
                    if ( $var[0] == 'Y' && $var[1] == 'D') {
                        $marca = "NEW YORK";
                    }else if($var[0] == 'Y' && $var[1] == 'B'){
                         $marca = "NEW YORK PLUS";
                    }else if($var[0] == 'Y' && $var[1] == 'G'){
                        $marca = "NEW YORK PLUS";
                    }else if($var[0] == 'Y' && $var[1] == 'M'){
                        $marca = "NEW YORK MEN";
                    }else if($var[0] == 'Y' && $var[1] == 'K'){
                        $marca = "NEW YORK KIDS";
                    }else if($var[0] == 'Y' && $var[1] == 'T'){
                        $marca = "NEW YORK TEENS";
                    }else{
                        $marca = "NEW YORK";
                    }        
            	} 
              $total = $row->t04+ $row->t06 + $row->t08 + $row->t10 +$row->t12 +$row->t14+$row->t16+$row->t18+$row->t20+$row->t22+$row->t24+$row->t28+$row->t30+$row->t32+$row->t34+$row->t36+$row->t38+$row->xs+$row->s+$row->m+$row->l+$row->xl;
              $fila = [
                    "Correria" => 'All2022',
                    "Tipo" => 'Pedidos',
                    "Id Amarrador" => $row->idamarrador,
                    "Estado Pedido" => $row->estado,
                    "Estado Cartera" => $row->revision,
                    "Codigo" => $row->codigo,
                    "Fecha" => date("d/m/Y", strtotime ($row->fecha)),
                    "Vendedor" => $row->vendedor,
                    "Ped" => $row->nped,
                    "Observacion" => $row->observaciones,
                    "Nit" => $row->nit,
                    "Cliente" => $row->nombre,
                    "Zona" => $row->zona,
                    "Prioridad" => 0,
                    "Direccion" => $row->direccion,
                    "Departamento" => isset($row->departamento) ? $row->departamento:'Sin Departamento',
                    "Ciudad" => $row->ciudad,
                    "Referencia" => $row->referencia,
                    "Color" => $row->color,
                    "Identificador" => $row->identificador,
                    "4" => isset($row->t04) ? $row->t04:0,
                    "6" => isset($row->t06)? $row->t06:0,
                    "8" => isset($row->t08)? $row->t08:0,
                    "10" => isset($row->t10)? $row->t10:0,
                    "12" => isset($row->t12)? $row->t12:0,
                    "14" => isset($row->t14)? $row->t14:0,
                    "16" => isset($row->t16)? $row->t16:0,
                    "18" => isset($row->t18)? $row->t18:0,
                    "20" => isset($row->t20)? $row->t20:0,
                    "22" => isset($row->t22)? $row->t22:0,
                    "24" => isset($row->t24)? $row->t24:0,
                    "26" => isset($row->t26)? $row->t26:0,
                    "28" => isset($row->t28)? $row->t28:0,
                    "30" => isset($row->t30)? $row->t30:0,
                    "32" => isset($row->t32)? $row->t32:0,
                    "34" => isset($row->t34)? $row->t34:0,
                    "36" => isset($row->t36)? $row->t36:0,
                    "38" => isset($row->t38)? $row->t38:0,
                    "XS" => isset($row->xs)? $row->xs:0,
                    "S" => isset($row->s)? $row->s:0,
                    "M" => isset($row->m)? $row->m:0,
                    "L" => isset($row->l)? $row->l:0,
                    "XL" => isset($row->xl)? $row->xl:0,
                    "Total" => $total,
                    "Marca" => $row->marca,
                    "Pedido" => 'Pedido',
                    "Existencia" => '',
                    "ESTADO DESPACHO" => $row->despacho,
                    "TIPO DESPACHO" => $row->despachar,
                    "FECHA DESPACHO" => $row->fdespacho,
                    "FILTRO" => $row->filtro,
                    "TIPO VENDEDOR" => $tipovendedor,
                ];
                /*$fila = [
                    'Consecutivo' => $ordenDespacho->consecutivo,
                    'Fecha Consecutivo'=> $ordenDespacho->created_at,
                    'id_amarrador' => $row->id_amarrador,
                    'pedido_id' => $row->pedido_id,
                    'referencia' => $row->referencia,
                    'T4' =>  $row->t4 >=1 ? $row->t4 : '0',
                    'T6' => $row->t6 >=1 ? $row->t6 : '0',
                    'T8' => $row->t8  >=1 ? $row->t8 : '0',
                    'T10' => $row->t10 >=1 ? $row->t10 : '0',
                    'T12' => $row->t12 >=1 ? $row->t12 : '0',
                    'T14' => $row->t14 >=1 ? $row->t14 : '0',
                    'T16' => $row->t16 >=1 ? $row->t16 : '0',
                    'T18' => $row->t18 >=1 ? $row->t18 : '0',
                    'T20' => $row->t20 >=1 ? $row->t20 : '0',
                    'T22' => $row->t22 >=1 ? $row->t22 : '0',
                    'T24' => $row->t24 >=1 ? $row->t24 : '0',
                    'T26' => $row->t26 >=1 ? $row->t26 : '0',
                    'T28' => $row->t28 >=1 ? $row->t28 : '0',
                    'T30' => $row->t30 >=1 ? $row->t30 : '0',
                    'T32' => $row->t32 >=1 ? $row->t32 : '0',
                    'T34' => $row->t34 >=1 ? $row->t34 : '0',
                    'T36' => $row->t36 >=1 ? $row->t36 : '0',
                    'T38' => $row->t38 >=1 ? $row->t38 : '0',
                    'S' => $row->s >=1 ? $row->s : '0',
                    'M' => $row->m >=1 ? $row->m : '0',
                    'L' => $row->l >=1 ? $row->l : '0',
                    'XL' => $row->xl >=1 ? $row->xl : '0',
                    'TOTAL' => $row->total >=1 ? $row->total : '0',
                    'OP Alista' => $userAlista,
                    'OP Empaca' => $userEmpaca,
                    'REV' => $userR != null ? $userR : 'Digital',
                    'OBSV. REV' => $razon != null ? $razon : ' ',
                    'FechaRevision' => $userR != null ? \Carbon\Carbon::parse($ordenAlistamiento->updated_at)->format('d/M/Y m:s') : '',
                    'FechaEmpacado' => \Carbon\Carbon::parse($row->created_at)->format('d/M/Y m:s'),
                    'FechaDespacho' => \Carbon\Carbon::parse($row->updated_at)->format('d/M/Y m:s'),
                ];*/
                array_push($array,$fila);
                $i++;
             }
             
       return $array;
    }
    
    
}