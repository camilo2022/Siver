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
use App\Models\PickingTipoPrenda;

class PickingExportSaldos implements FromArray, Responsable, WithHeadings, WithTitle
{
    use Exportable;
    
    private $idConteoPrenda;

    public function __construct($idConteoPrenda)
    {
        $this->idConteoPrenda= $idConteoPrenda;
    }
    
    public function headings(): array
    {
        return [
                'Fecha',
                'Referencia',
                'SALDO',
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
        ];
    }
    
    public function title(): string
    {
        return 'Saldos';
    }
    
    public function array(): array
    {
       $array = [];
       $rows = PickingTipoPrenda::where('id_referencia','=',$this->idConteoPrenda)->where('tipo_prenda','=','SALDOS')->get();
       $conteo=conteoPrenda::where('id','=',$this->idConteoPrenda)->first();
            $i=0;
            
            foreach($rows as $row){
                $fila =[
                    'Fecha' => \Carbon\Carbon::parse($row->created_at)->format('d/M/Y m:s'),
                    'Referencia'  => $conteo->referencia,
                    'SALDO' => 'S975',
                    'T4'  => $row->talla == '04'?$row->cantidad:0,
                    'T6'  => $row->talla == '06'?$row->cantidad:0,
                    'T8'  => $row->talla == '08'?$row->cantidad:0,
                    'T10' => $row->talla == '10'?$row->cantidad:0,
                    'T12' => $row->talla == '12'?$row->cantidad:0,
                    'T14' => $row->talla == '14'?$row->cantidad:0,
                    'T16' => $row->talla == '16'?$row->cantidad:0,
                    'T18' => $row->talla == '18'?$row->cantidad:0,
                    'T20' => $row->talla == '20'?$row->cantidad:0,
                    'T22' => $row->talla == '22'?$row->cantidad:0,
                    'T24' => $row->talla == '24'?$row->cantidad:0,
                    'T26' => $row->talla == '26'?$row->cantidad:0,
                    'T28' => $row->talla == '28'?$row->cantidad:0,
                    'T30' => $row->talla == '30'?$row->cantidad:0,
                    'T32' => $row->talla == '32'?$row->cantidad:0,
                    'T34' => $row->talla == '34'?$row->cantidad:0,
                    'T36' => $row->talla == '36'?$row->cantidad:0,
                    'T38' => $row->talla == '38'?$row->cantidad:0,
                    ];
                array_push($array,$fila);
                $i++;
            }
            
       return $array;
    }
    
    
}