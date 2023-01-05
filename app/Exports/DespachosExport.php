<?php


namespace App\Exports;


use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Despachos\DetallesOrdenEmpacado;
use App\Models\Despachos\OrdenEmpacado;
use App\Models\Despachos\OrdenDespacho;
use App\Models\Despachos\OrdenAlistamiento;
use App\Models\Prefix;
use App\Models\User;

class DespachosExport implements FromArray, Responsable, WithHeadings, WithTitle
{
    use Exportable;
    
    private $listadoEmpacados;

    public function __construct($listadoEmpacados)
    {
        $this->listadoEmpacados = $listadoEmpacados;
    }
    
    public function headings(): array
    {
        return [
                'Consecutivo',
                'Fecha Consecutivo',
                'id_amarrador',
                'pedido_id',
                'referencia',
                'T4',
                'T6',
                'T8',
                'T10',
                'T12',
                'T14',
                'T16',
                'T18',
                'T20',
                'T22',
                'T24',
                'T26',
                'T28',
                'T30',
                'T32',
                'T34',
                'T36',
                'T38',
                'S',
                'M',
                'L',
                'XL',
                'TOTAL',
                'OP Alista',
                'OP Empaca',
                'REV',
                'OBSV. REV',
                'FechaRevision',
                'FechaEmpacado',
                'FechaDespacho',
        ];
    }
    
    public function title(): string
    {
        return 'ListadoDespachos';
    }
    
    public function array(): array
    {
       $array = [];
       $rows = $this->listadoEmpacados;
            $i=0;
            
            foreach ($rows as $row) {
                $ordenEmpacado = OrdenEmpacado::where('id','=',$row->empacado_id)->first();
                $ordenDespacho = OrdenDespacho::where('id','=',$ordenEmpacado->ordendespacho_id)->first();
                $ordenAlistamiento = OrdenAlistamiento::where('ordendespacho_id','=',$ordenEmpacado->ordendespacho_id)->first();
                $userEmpaca=User::where('id','=',$ordenEmpacado->user_id_alista)->first();
                $userEmpaca = $userEmpaca->names.' '.$userEmpaca->apellidos;
                
                $us=json_decode(json_encode($ordenAlistamiento));
                
                if($us->user_id_alista != null){
                    $userAlista = User::where('id','=',$us->user_id_alista)->first();
                    $userAlista = $userAlista->names.' '.$userAlista->apellidos;
                }
                
                    
                $userR= User::where('id','=',$ordenAlistamiento->user_id_aprueba)->first();
                if($userR !=null){
                    $userR = $userR->names.' '.$userR->apellidos;
                }
                    
                $razon = $ordenAlistamiento->razonAprueba;
                
                $fila = [
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
                ];
                array_push($array,$fila);
                $i++;
             }
             
       return $array;
    }
    
    
}