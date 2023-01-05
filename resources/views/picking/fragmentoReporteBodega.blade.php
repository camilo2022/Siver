


<div class="container-fluid mt-2">
    <div class="card" style=" font-family:Century Gothic;">
      <div class="card-header text-center" style="font-family:Century Gothic; background-color:#007bff; color:white; font-weigth:bold;">
        CONSULTA DE PICKING BODEGA ENTRE {{$fecha1}} Y {{$fecha2}}
      </div>
        <div class="card-body">
            <div class="table-responsive">

                        <table id="example23" class="table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id Orden Picking</th>
                                    <th>Orden Picking</th>
                                    <th>Id Item</th>
                                    <th>Item</th>
                                    <th>Cantidad</th>
                                    <th>Creacion de Registro</th>
                                </tr>
                            </thead>
                       
                            <tbody id="tabla_devolucion">
                                @foreach($reporte as $report)
                                    <tr>
                                        <td>{{ $report->id_orden_picking }}</td>
                                        <td>{{ $report->orden_picking }}</td>
                                        <td>{{ $report->id }}</td>
                                        <td>{{ $report->item }}</td>
                                        <td>{{ $report->cantidad }}</td>
                                        <td>{{ $report->created_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                </div>
            </div>
        </div>
    </div>
