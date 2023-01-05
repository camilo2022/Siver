<?php


namespace App\Exports;


use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\User;
use App\Models\conteoPrenda;
use App\Models\pickingConteoPrendas;

class PickingExport implements FromArray, Responsable, WithHeadings, WithTitle
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
                'Fecha',
                'Usuario Picking',
                'Tipo',
                'Observacion',
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
                'Pickeado',
                'PT04',
                'PT06',
                'PT08',
                'PT10',
                'PT12',
                'PT14',
                'PT16',
                'PT18',
                'PT20',
                'PT22',
                'PT24',
                'PT26',
                'PT28',
                'PT30',
                'PT32',
                'PT34',
                'PT36',
                'PT38',
        ];
    }
    
    public function title(): string
    {
        return 'ListadoPickingConteoPrendas';
    }
    
    public function array(): array
    {
       $array = [];
       $rows = $this->listadoEmpacados;
            $i=0;
            
            foreach($rows as $row){
                $userPicking=User::where('id','=',$row->user_id)->first();
                $userPicking = $userPicking->names.' '.$userPicking->apellidos;
                $pickeo = pickingConteoPrendas::where('idconteoprendas','=',$row->id)->get();
                
                $fila = [
                    'Fecha' => \Carbon\Carbon::parse($row->created_at)->format('d/M/Y m:s'),
                    'Usuario Picking' => isset($userPicking) ? $userPicking : 'No user',
                    'Tipo' => isset($row->tipo) ? $row->tipo : 'N/A',
                    'Observacion' => isset($row->obs) ? $row->obs : 'N/A',
                    'referencia' => isset($row->referencia) ? $row->referencia : 'N/A',
                    'T4' => isset($row->t04 ) ? $row->t04: 0,
                    'T6' => isset($row->t06 ) ? $row->t06: 0,
                    'T8' => isset($row->t08 ) ? $row->t08: 0,
                    'T10' => isset($row->t10 ) ? $row->t10: 0,
                    'T12' => isset($row->t12 ) ? $row->t12: 0,
                    'T14' => isset($row->t14 ) ? $row->t14: 0,
                    'T16' => isset($row->t16 ) ? $row->t16: 0,
                    'T18' => isset($row->t18 ) ? $row->t18: 0,
                    'T20' => isset($row->t20 ) ? $row->t20: 0,
                    'T22' => isset($row->t22 ) ? $row->t22: 0,
                    'T24' => isset($row->t24 ) ? $row->t24: 0,
                    'T26' => isset($row->t26 ) ? $row->t26: 0,
                    'T28' => isset($row->t28 ) ? $row->t28: 0,
                    'T30' => isset($row->t30 ) ? $row->t30: 0,
                    'T32' => isset($row->t32 ) ? $row->t32: 0,
                    'T34' => isset($row->t34 ) ? $row->t34: 0,
                    'T36' => isset($row->t36 ) ? $row->t36: 0,
                    'T38' => isset($row->t38 ) ? $row->t38: 0,
                    'Pickeado' => '',
                    'PT04' => isset($pickeo[0]->t04 ) ? $pickeo[0]->t04: '0',
                    'PT06' => isset($pickeo[0]->t06 ) ? $pickeo[0]->t06: '0',
                    'PT08' => isset($pickeo[0]->t08 ) ? $pickeo[0]->t08: '0',
                    'PT10' => isset($pickeo[0]->t10 ) ? $pickeo[0]->t10: '0',
                    'PT12' => isset($pickeo[0]->t12 ) ? $pickeo[0]->t12: '0',
                    'PT14' => isset($pickeo[0]->t14 ) ? $pickeo[0]->t14: '0',
                    'PT16' => isset($pickeo[0]->t16 ) ? $pickeo[0]->t16: '0',
                    'PT18' => isset($pickeo[0]->t18 ) ? $pickeo[0]->t18: '0',
                    'PT20' => isset($pickeo[0]->t20 ) ? $pickeo[0]->t20: '0',
                    'PT22' => isset($pickeo[0]->t22 ) ? $pickeo[0]->t22: '0',
                    'PT24' => isset($pickeo[0]->t24 ) ? $pickeo[0]->t24: '0',
                    'PT26' => isset($pickeo[0]->t26 ) ? $pickeo[0]->t26: '0',
                    'PT28' => isset($pickeo[0]->t28 ) ? $pickeo[0]->t28: '0',
                    'PT30' => isset($pickeo[0]->t30 ) ? $pickeo[0]->t30: '0',
                    'PT32' => isset($pickeo[0]->t32 ) ? $pickeo[0]->t32: '0',
                    'PT34' => isset($pickeo[0]->t34 ) ? $pickeo[0]->t34: '0',
                    'PT36' => isset($pickeo[0]->t36 ) ? $pickeo[0]->t36: '0',
                    'PT38' => isset($pickeo[0]->t38 ) ? $pickeo[0]->t38: '0',
                ];
                array_push($array,$fila);
                $i++;
            }
            
       return $array;
    }
    
    
}