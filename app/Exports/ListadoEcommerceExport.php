<?php


namespace App\Exports;


use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\EcommerceModel;
use App\Models\Prefix;


class ListadoEcommerceExport implements FromArray, Responsable, WithHeadings, WithTitle
{
    use Exportable;
    
    private $fecha1;
    private $fecha2;

    public function __construct($fecha1,$fecha2)
    {
        $this->fecha1 = $fecha1;
        $this->fecha2 = $fecha2;
    }
    
    public function headings(): array
    {
        return [
                'Fecha',
                'Telefono',
                'Cliente',
                'Asesor de Venta',
                'Talla',
                'Venta Concreta',
                'Tipo Requerimiento',
                'Clasificacion',
                'Observacion'
        ];
    }
    
    public function title(): string
    {
        return 'ListadoEcommerce';
    }
    
    public function array(): array
    {
       $array = [];

       /*$this->fecha1 = date_create($this->fecha1);
       $this->fecha2 = date_create($this->fecha2);
        date_add($this->fecha1,date_interval_create_from_date_string("1 months"));
        date_add($this->fecha2,date_interval_create_from_date_string("1 months"));
        $this->fecha1=date_format($this->fecha1,"Y-m-d");
        $this->fecha2=date_format($this->fecha2,"Y-m-d");
        dd($this->fecha1);*/
       $rows = EcommerceModel::whereBetween('created_at', [$this->fecha1." 00:00:00",$this->fecha2." 23:59:59"])->get();
            $i=0;
            foreach ($rows as $row) {
                if($row['ventaconcreta'] == 1) {
                    $ventac = 'SI';
                }else{
                    $ventac ='NO';
                }

                if($row['tiporequerimiento'] == 1){
                    $tipor = 'Tipo A';
                }else if($row['tiporequerimiento'] == 2){
                    $tipor = 'Tipo B';
                }else{
                    $tipor = 'Otro';
                }

                $cla = '';

                if($row['clasificacion'] == 1){
                    $cla = 'Al Mayor';
                }else if($row['clasificacion'] == 2){
                    $cla = 'Intermedio';
                }else{
                    $cla = 'Detal';
                }

                $fila = [
                    'Fecha' => \Carbon\Carbon::parse($row['created_at'])->format('d/M/Y m:s'),
                    'Telefono' => $row['cliente']->telefono,
                    'Cliente' => $row['cliente']->nombres,
                    'Asesor de Venta' => $row['user']->names.' '.$row['user']->apellidos,
                    'Talla' => $row['talla'],
                    'Venta Concreta' => $ventac,
                    'Tipo Requerimiento' => $tipor,
                    'Clasificacion' => $cla,
                    'Observacion' =>$row['observacion']
                    
                ];
                array_push($array,$fila);
                $i++;
             }
             
       return $array;
    }
    
    
}