<?php


namespace App\Exports;


use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class PreparacionExport implements FromArray, Responsable, WithHeadings, WithTitle
{
    use Exportable;
    
    private $listadoPreparacion;

    public function __construct($listadoPreparacion)
    {
        $this->listadoPreparacion = $listadoPreparacion;
    }
    
    public function headings(): array
    {
        return [
            'Id',
            'Fecha',
            'Turno',
            'Modulo',
            'Operario',
            'Referencia',
            'Tallas',
            'TC',
            'Tipo',
            'Hora',
            'CC',
            'Tiempo',
            '100 %',
            '% Eficiencia',
            'N° Operarios',
            'Tipo PP',
            'Tiempo PP',
            'Tipo PNP',
            'Tiempo PNP'
        ];
    }
    
    public function title(): string
    {
        return 'listadoPreparacion';
    }
    
    public function array(): array
    {
       $array = [];
       $rows = $this->listadoPreparacion;
            $i=0;
            
            foreach($rows as $row){
                $fila = [
                    'Id' => $row->id,
                    'Fecha' => $row->fecha,
                    'Turno' => $row->turno,
                    'Modulo' => $row->modulo,
                    'Operario' => "C.C.".$row->documento." ".$row->nombres." ".$row->apellidos,
                    'Referencia' => $row->referencia,
                    'Tallas' => $row->tallas,
                    'TC' => $row->tc,
                    'Tipo' => $row->tipo,
                    'Hora' => $row->hora,
                    'CC' => $row->cantidad,
                    'Tiempo' => $row->tiempo_req_h,
                    '100 %' => $row->meta_produccion,
                    '% Eficiencia' => $row->eficiencia == null ? "0 %": number_format($row->eficiencia,2, ',', '.')." %",
                    'N° Operarios' => $row->n_operarios,
                    'Tipo PP' => $row->parada_programada,
                    'Tiempo PP' => $row->tiempo_parada_programada,
                    'Tipo PNP' => $row->parada_no_programada,
                    'Tiempo PNP' => $row->tiempo_noprg
                ];
                array_push($array,$fila);
                $i++;
            }
            
       return $array;
    }
    
    
}