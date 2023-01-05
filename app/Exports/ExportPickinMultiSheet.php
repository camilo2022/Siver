<?php

namespace App\Exports;

use App\Exports\PickingExportSaldos;
use App\Exports\PickingExportMarras;
use App\Exports\PickingExport; 
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class ExportPickinMultiSheet implements WithMultipleSheets
{


    use Exportable;
    protected $pickingExport;
    protected $pickingSaldos;
    protected $pickingMarras;

    public function __construct($listado)
    {
        $this->pickingExport = new PickingExport($listado);
        $this->pickingSaldos = new PickingExportSaldos($listado->id);
        $this->pickingMarras = new PickingExportMarras($listado->id);
    }

    public function sheets(): array
    {
        $sheets = [];
            $sheets[1] = $this->pickingExport;
            $sheets[2] = $this->pickingSaldos;
            $sheets[3] = $this->pickingMarras;

        return $sheets;
    }
}
