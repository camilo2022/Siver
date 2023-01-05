<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ClientesModelTiendas;
use App\Models\HistorialLibranza;
use App\Models\DescuentoLibranza;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LibranzaDescuentosImport;
use Carbon\Carbon;
use App\Models\CuotaLibranza;

class EmpleadoController extends Controller
{
    public function getCuotasLibranzasDescontar(Request $request){
        
    }
    
    public function validarCodigoEnviado(Request $request){
        $documento = $request->documento;
        $numfactura = $request->factura;
        
        $cliente = ClientesModelTiendas::where('documento','=',$documento)->first();
        $histoLib = HistorialLibranza::where('clientes_id','=',$cliente->id)->where('numfactura','=',$numfactura)->first();
        
       if($histoLib != null){
           switch($histoLib->estado){
               case  1: $let = 'Enviado'; 
               break;
               case 5: $let = 'CanceladoTotal';
               break;
               case 2: $let ='Usado';
               break;
               case 3: $let = 'Cancelado';
               break;
               case 4: $let = 'Reenviado';
               $histoLib->estado = 1;
               $histoLib->save();
               break;
               case 6: $let = 'Realizando Pagos';
               break;
           }
           return response()->json(['cod'=>1,'estado' => $histoLib->estado,'estadoName'=>$let,'codigoSMS' => $histoLib->codigo]);
       }else{
           return response()->json(['cod'=>2,'message' => 'No se ha encontrado un historial de libranza con ese numero de factura.']);
       }
    }
    
    public function getViewValidarLibranza(Request $request){
        return view('libranza.validar');
    }
    
    public function submitDescuentos_Manual(Request $request){
        $file = $request->file;
        $descuentoslibranzas = new LibranzaDescuentosImport();
        $ts=Excel::import($descuentoslibranzas,$file);
        $items=json_decode(json_encode($descuentoslibranzas->sheetData[0]));
        
        $descuentoPendientesAun=0;
        $descuentoTotalidad=0;
        $total=0;
        $noexisten=0;
        for($i=0;$i<count($items);$i++){
            $descount = $items[$i]->MontoDescuento;
            $libranzacodigo = $items[$i]->CodigoLibranza;
            $resulta = $this->descuentoProceso($descount,$libranzacodigo);
            if($resulta == 6){
                $descuentoPendientesAun++;
            }else if($resulta == 5){
                $descuentoTotalidad++;
            }else if($resulta == 0){
                $noexisten ++;
            }
            $total++;
        }
        return response()->json(['message' => 'se han realizado '.$total.' descuento de libranzas, de los cuales '.$descuentoTotalidad.' han cumplido con el pago de la totalidad del cupo de deuda, '.$descuentoPendientesAun.' aun quedan pendientes de pago y '.$noexisten.' codigos de libranza no existen.'],200);
    }
    
    public function descuentaLibranzaContabilidad(Request $request){
        $descount = $request->monto;
        $libranzacodigo= $request->codigo;
        $resulta = $this->descuentoProceso($descount,$libranzacodigo);
        if($resulta != 0){
            return response()->json(['data' => 'Se ha descontado el monto de $'.$descount.' a la libranza con codigo: '.$libranzacodigo],200);
        } 
        return response()->json(['data' => 'No existe libranza con ese codigo '.$libranzacodigo],400);
    }
    
    private function descuentoProceso($descount,$libranzacodigo){
        $valorRetornar = 1;
        $historial = HistorialLibranza::where('id','=',$libranzacodigo)->get();
        $historial  = $historial[0];
        if($historial == null) return 0;
        $empleado = ClientesModelTiendas::where('id','=',$historial->clientes_id)->get();
        $empleado = $empleado[0];
        
        $empleado->monto_libranza += $descount;
        $empleado->save();
        
        
        DescuentoLibranza::create([
    	    'historial_libranza_id' => $historial->id,
    	    'monto' => $descount,
    	    'users_id' => Auth::user()->id,
        ]);
        
        
        $historiales = HistorialLibranza::where('clientes_id','=',$empleado->id)->get();
        
        if($empleado->monto_libranza == $empleado->cupo){
           
            foreach($historiales as $historial){
                $historial->estado = 5;
                $historial->save();
            }
        }
        
 
        
        foreach($historiales as $historial){
                $descuentos = DescuentoLibranza::where('historial_libranza_id','=',$historial->id)->get();
                
                if($descuentos != null){
                    $suma =0;
                    foreach($descuentos as $descuento){
                        $suma += $descuento->monto;
                    }
                    
                    if($suma == $historial->valormonto){
                        $historial->estado = 5;
                        $historial->save();
                        $valorRetornar = 5;
                    }else{
                        $historial->estado = 6;
                        $historial->save();
                        $valorRetornar = 6;
                    }
                }
                
        }
        
        return $valorRetornar;
    }
    
    public function getAllLibranzas(Request $request){
        $historiales = HistorialLibranza::where('estado','=',5)->orWhere('estado','=',2)->orWhere('estado','=',6)->orWhere('estado','=',5)->get();
        $devolvera =[];
        $total = 0;
        $data = [];
        $montoTotalPagado = 0;
        $montoTotalDeuda = 0;
        foreach($historiales as $historial){
            $estado="";
            $descuentos = DescuentoLibranza::where('historial_libranza_id','=',$historial->id)->get();
            $suma = 0;
            foreach($descuentos as $descuento){
                $suma += $descuento->monto;
            }
            
            switch($historial->estado){
                    case 1: $estado = "Enviado";
                    break;
                    case 2: $estado = "Firmado";
                    break;
                    case 3: $estado =  "CANCELADO";
                    break;
                    case 4: $estado =  "REENVIADO";
                    break;
                    case 5: $estado = "PAGADO";
                    break;
                    case 6: $estado = "Realizando Pagos";
                }
                
                $deuda=0;
            if($historial->estado != 3){
                //$montoTotalDeuda += $historial->valormonto-$suma;
                $deuda=$historial->valormonto-$suma;
                $total += $historial->valormonto;
                $montoTotalDeuda += $deuda;
            }
            
            $cuotasLibranza = CuotaLibranza::where('historial_libranza_id','=',$historial->id)->get();
            
            $totalCuotas = 4;
            $cuotasPagas = CuotaLibranza::where('historial_libranza_id','=',$historial->id)->where('estado','=',1)->get();
            $cuotasPagas = count($cuotasPagas);
            
            $montoCuota = $historial->valormonto / $totalCuotas;
            $empresa = "Org. Bless";
            if($historial->clientes->entidad == 4){
                $empresa = "Bless Manufacturing";
            }else if($historial->clientes->entidad == 3){
                $empresa = "Yerson Villamizar";
            }
            setlocale(LC_MONETARY, 'es_CO');
            $monto = $historial->valormonto;
            $monto = round($monto);
            $arr = [
                'codigo' => $historial->id,
                'fecha' => \Carbon\Carbon::parse($historial->created_at)->format('d/m/Y'),
                'documento' => $historial->clientes->documento,
                'empleado' => $historial->clientes->nombres.' '.$historial->clientes->apellidos,
                'tienda' => $historial->users->tiendacargo, 
                'monto' => $monto,
                'empresa' => $empresa,
                'pagado' => $suma,
                'cuotas' => $totalCuotas,
                'pagas' => count($descuentos),
                'valorCuota' => round($montoCuota),
                'deuda' => round($deuda),
                'estado' => $estado
            ];
            
            $montoTotalPagado += $suma;
            
            array_push($data,$arr);
        }
        $totale=[
            'data' => $data,
            'montoTotalLibranzas' => $total,
            'montoTotalPagado' => $montoTotalPagado,
            'montoTotalDeuda'=> $montoTotalDeuda];
        array_push($devolvera,$totale);
    
        return response()->json($devolvera);
    }
    
    public function getLibranzasPendiente(Request $request){
        $historiales = HistorialLibranza::where('estado','=',2)->orWhere('estado','=',6)->get();
        $devolvera =[];
        $total = 0;
        $data = [];
        foreach($historiales as $historial){
            $descuentos = DescuentoLibranza::where('historial_libranza_id','=',$historial->id)->get();
            $suma = 0;
            foreach($descuentos as $descuento){
                $suma += $descuento->monto;
            }
           // $cuotasPagas = CuotaLibranza::where('historial_libranza_id','=',$historial->id)->where('estado','=',1)->get();
            $cuotasPagas = count($descuentos);
            
            $arr = [
                'codigo' => $historial->id,
                'fecha' => \Carbon\Carbon::parse($historial->created_at)->format('d/m/Y'),
                'empleado' => 'C.C.'.$historial->clientes->documento.' '.$historial->clientes->nombres.' '.$historial->clientes->apellidos,
                'tienda' => $historial->users->tiendacargo, 
                'monto' => round($historial->valormonto),
                'cuotas' => $historial->cuotas,
                'valorCuota'=>round($historial->cuotas != 0 ? $historial->valormonto / $historial->cuotas : 4 ),
                'pagas'=> $cuotasPagas,
                'codsms' => $historial->codigo,
                'pagado' => round($historial->valormonto-$suma)
            ];
            $total += $historial->valormonto;
            array_push($data,$arr);
        }
        $totale=[
            'data' => $data,
            'montoTotal' => $total];
        array_push($devolvera,$totale);
        return response()->json($devolvera);
    }
    
    public function getHistorialMovimientosEmpleado(Request $request){
        $empleado = ClientesModelTiendas::where('documento','=',$request->documento)->get();
        $historiales = HistorialLibranza::where('clientes_id','=',$empleado[0]->id)->get();
        if(count($historiales) > 0){
        
            $arrayGlobal = [];
            $estado = "";
            foreach($historiales as $historial){
                switch($historial->estado){
                    case 1: $estado = "Enviado";
                    break;
                    case 2: $estado = "Firmado";
                    break;
                    case 3: $estado =  "Cancelado";
                    break;
                    case 4: $estado =  "Reenviado";
                    break;
                    case 5: $estado = "PAGADO";
                    break;
                }
                $array = [
                    'fecha' => \Carbon\Carbon::parse($historial->created_at)->format('d/m/Y'),
                    'movimiento' => 'Solicitud de libranza',
                    'libranzaID' => 'N/A',
                    'fechaLibranza' => 'N/A',
                    'monto' => $historial->valormonto,
                    'tienda' => User::where('id','=',$historial->users_id)->first()->tiendacargo,
                    'estado' => $estado
                ];
                array_push($arrayGlobal,$array);
                $descuentoLibranza = DescuentoLibranza::where('historial_libranza_id','=',$historial->id)->get();
                if($descuentoLibranza != null){
                    foreach($descuentoLibranza as $desc ){
                        $array = [
                            'fecha' => \Carbon\Carbon::parse($desc->created_at)->format('d/m/Y'),
                            'movimiento' => 'Descuento por Nomina',
                            'libranzaID' => $historial->id,
                            'fechaLibranza' => \Carbon\Carbon::parse($historial->created_at)->format('d/m/Y'),
                            'monto' => $desc->monto,
                            'tienda' => User::where('id','=',$desc->users_id)->first()->tiendacargo,
                            'estado' => 'SALDADO'
                             
                        ];
                        array_push($arrayGlobal,$array);
                    }
                }
            }
            
            return response()->json(['respuesta' => 200, 'info' => $arrayGlobal]);
        }
        return response()->json(['respuesta' => 500, 'info' => 'El empleado no ha tenido movimientos de historial.']);
    }

    public function getLibranzasEmpleados(Request $request){
        $empleados = ClientesModelTiendas::where('estado_empresa','=',1)->get();
        $empleadoRetornar = [];
        
        foreach($empleados as $empleado){
            $historialesLibranza = HistorialLibranza::where('clientes_id','=',$empleado->id)->where('estado','=',2)->orWhere('estado','=',5)->get();
            
            $ih = HistorialLibranza::where('clientes_id','=',$empleado->id)->orderBy('created_at', 'desc')->first();
            $fecha = 'N/A';
            if($ih !=null) {
                $fecha =  \Carbon\Carbon::parse($ih->created_at)->format('d/m/Y');
            }
            $deuda = $empleado->cupo - $empleado->monto_libranza;
            
                $empresa = $empleado->entidad;
                if($empresa == 4){
                    $empresa = "Bless Manufacturing";
                }else if($empresa == 3){
                    $empresa = "Yerson Villamizar";
                }else{
                    $empresa = "Org. Bless";
                }
            $unitario = [
                'documento' => $empleado->documento,
                'nombres' => $empleado->nombres.' '.$empleado->apellidos,
                'telefono' => $empleado->telefono,
                'fechaUltimaLibranza' => $fecha,
                'totalLibranzas' => 0,
                'deuda' => $deuda,
                'empresa' => $empresa,
                'cupoDisponible' => $empleado->cupo-$deuda,
                'cupo' => $empleado->cupo,
            ];
            array_push($empleadoRetornar,$unitario);
        }
        
        /*Ordenar por deuda*/
        
        $empleadoLista = $this->array_sort_by($empleadoRetornar,'deuda');
        return response()->json($empleadoLista);
    }
    
    private function array_sort_by(&$arrIni, $col)
    {
        $arrAux = array();
        foreach ($arrIni as $key=> $row)
        {
            $arrAux[$key] = is_object($row) ? $arrAux[$key] = $row->$col : $row[$col];
            $arrAux[$key] = strtolower($arrAux[$key]);
        }
        array_multisort($arrAux,SORT_DESC, $arrIni);
        return $arrIni;
    }
    
    public function getEmpleado(Request $request){
        $documento = $request->documento;
        $cliente = ClientesModelTiendas::where('documento','=',$documento)->where('estado_empresa','=',1)->get();
        if($cliente != "[]" && $cliente[0]->cargo != null ){
            return response()->json($cliente);
        }
        return response()->json(1);
    }
    
    public function disminuirCupoEmpleado(Request $request){
        $documento = $request->documento;
        $cupoGastado = $request->cupoGastado;
        
        $cliente = ClientesModelTiendas::where('documento','=',$documento)->where('estado_empresa','=',1)->first();
        if($cliente != "[]" ){
            $cliente->monto_libranza -= $cupoGastado;
            $cliente->save();
            return response()->json(2);
        }       
        return response()->json(1);
    }
    
    public function validarSMSCode(Request $request){
        $monto = $request->monto;
        $numfactura = $request->numfactura;
        $documento = $request->documento;
        $codigoverf = $request->codigoverf;
        $cliente = ClientesModelTiendas::where('documento','=',$documento)->first();
        $historial=HistorialLibranza::where('clientes_id','=',$cliente->id)->where('numfactura','=',$numfactura)->where('valormonto','=',$monto)->first();
        
        if($historial != null){
            if($historial->codigo == $codigoverf && $historial->estado == '1'){
                $historial->estado = 2;
                $historial->save();
                $cliente->monto_libranza -= $monto;
                $cliente->save();
                return response()->json(['codigo' => 200,'message' => 'Se ha firmado correctamente la libranza del empleado ID GENERADO #'.$historial->id]);
            }else if($historial->estado == '2'){
                return response()->json(['codigo' => 500,'message' => 'El codigo ya se ha usado para firmar la libranza.']);
            }else{
                return response()->json(['codigo' => 500,'message' => 'El codigo ingresado no es el mismo generado para la firma de libranza.']);
            }
        }else{
            return response()->json(['codigo'=>500,'message'=>'No hay ningun historial de libranza con este codigo.']);
        }
        
    }
    
    public function cancelarCodigo(Request $request){
        $idhistorial = $request->codigo;
        
        $historial=HistorialLibranza::where('id','=',$idhistorial)->first();
        $historial->estado = 3;
        $historial->save();
        
        return response()->json(['message' => 'Se ha cancelado correctamente el codigo sms de libranza.']);
    }   
    
    public function getLibranzasTienda(){
         $historial=HistorialLibranza::where('users_id','=',Auth::user()->id)->get();
         $arr=[];
         for($i=0;$i<count($historial);$i++){
             $cliente=ClientesModelTiendas::where('id','=',$historial[$i]->clientes_id)->first();
             $enviar = [
                 'id' => $historial[$i]->id,
        		'clientes_id' => $historial[$i]->clientes_id,
        		'users_id' => $historial[$i]->users_id,
        		'valormonto' => $historial[$i]->valormonto,
        		'numfactura' => $historial[$i]->numfactura,
        		'codigo' => $historial[$i]->codigo,
        		'cuotas' => $historial[$i]->cuotas,
        		'smsID' => $historial[$i]->smsID,
        		'estado' => $historial[$i]->estado,
        		'created_at' => $historial[$i]->created_at,
        		'updated_at' => $historial[$i]->updated_at,
        		'cedula'=>$cliente->documento,
        		'empresa' => $cliente->entidad,
        		'cliente'=> $cliente->nombres.' '.$cliente->apellidos,
             ];
             array_push($arr,$enviar);
         }
         return response()->json(['info' => $arr]);
    }
    
    public function sendSMSAutenticacion(Request $request){
        
        $monto = $request->monto;
        $numfactura = $request->numfactura;
        $documento = $request->documento;
        $montoFormat = $request->montoFormat;
        $cuotas = $request->cuotas;
        
        $cliente = ClientesModelTiendas::where('documento','=',$documento)->first();
        $historial=HistorialLibranza::where('clientes_id','=',$cliente->id)->where('numfactura','=',$numfactura)->where('valormonto','=',$monto)->first();
        
        $fechas = $this->calcularFechasCuotas($cuotas);
        
        if($historial != null){
            //$smsID = 'DESACTIVADO';
          $smsID=$this->send_sms_hablame($historial->codigo,$numfactura,$montoFormat,$cliente->telefono);
        //   $smsID='DESACTIVADO';
            $historial->smsID = $smsID;
            $historial->estado = 4;
            $historial->save();
            return response()->json(['message' => 'Se ha reenviado el codigo de verificacion de 6 digitos al numero '.$cliente->telefono.' pidelo al cliente para firmar la libranza.']);
        }else{
            $permitted_chars = '0123456789ABCDEFGHJKMNOPQRSTUVWXYZ';
            $codigoverifica = $this->generate_string($permitted_chars, 6);
            $smsID=$this->send_sms_hablame($codigoverifica,$numfactura,$montoFormat,$cliente->telefono);
           
            $historial = HistorialLibranza::create([
    		    'clientes_id' => $cliente->id,
        		'users_id' => Auth::user()->id,
        		'valormonto' => $monto,
        		'numfactura' => $numfactura,
        		'codigo' => $codigoverifica,
        		'cuotas' => $cuotas,
        		'fechaCuota1' => $fechas['fecha1'],
        		'fechaCuota2' => $fechas['fecha2'],
        		'fechaCuota3' => $fechas['fecha3'],
        		'fechaCuota4' => $fechas['fecha4'],
        		'smsID' => $smsID,
        		'estado' => 1,
            ]);
                
            $valorCuota =  $monto/$cuotas;
            if($fechas['fecha1'] != null){
                CuotaLibranza::create([
                    'historial_libranza_id' => $historial->id,
            		'fechaCuota' => Carbon::parse($fechas['fecha1']),
            		'monto' => $valorCuota ,
            		'fechaPago' => ''
                ]);
            }
            
            if($fechas['fecha2'] != null){
                CuotaLibranza::create([
                    'historial_libranza_id' => $historial->id,
            		'fechaCuota' => Carbon::parse($fechas['fecha2']),
            		'monto' => $valorCuota ,
            		'fechaPago' => ''
                ]);
            }
            
            if($fechas['fecha3'] != null){
                CuotaLibranza::create([
                    'historial_libranza_id' => $historial->id,
            		'fechaCuota' => Carbon::parse($fechas['fecha3']),
            		'monto' => $valorCuota ,
            		'fechaPago' => ''
                ]);
            }
            
            if($fechas['fecha4'] != null){
                CuotaLibranza::create([
                    'historial_libranza_id' => $historial->id,
            		'fechaCuota' => Carbon::parse($fechas['fecha4']),
            		'monto' => $valorCuota ,
            		'fechaPago' => ''
                ]);
            }
            
            return response()->json(['message' => 'Se ha enviado un codigo de verificacion de 6 digitos al numero '.$cliente->telefono.' pidelo al cliente para firmar la libranza.']);
        }
        
    }
    
    private function calcularFechasCuotas($cuotas){
        
        $date = Carbon::now();
        $arrayFecha = $date->toArray();
        $fecha1 = '';
        $fecha2 = '';
        $fecha3 = '';
        $fecha4 = '';
        $sigPre=$arrayFecha['month'];
        $sigPre = $sigPre+1;
        if($sigPre>12){
            $sigPre = 1;
        }
        $sigsigPre=$sigPre+1;
        if($arrayFecha['day'] <= 15){
           if($cuotas == 1){
                $fecha1= new Carbon($arrayFecha['year'].'-'.$arrayFecha['month'].'-15');
            }else if($cuotas == 2){
              if($arrayFecha['month'] == '02'){
                    $fecha1= new Carbon($arrayFecha['year'].'-'.$arrayFecha['month'].'-15');
                    $fecha2= new Carbon($arrayFecha['year'].'-'.$arrayFecha['month'].'-28');
                }else{
                    $fecha1= new Carbon($arrayFecha['year'].'-'.$arrayFecha['month'].'-15');
                    if($arrayFecha['month']=='02'){
                        $fecha2= new Carbon($arrayFecha['year'].'-'.$arrayFecha['month'].'-28');
                    }else{
                        $fecha2= new Carbon($arrayFecha['year'].'-'.$arrayFecha['month'].'-30');
                    }
                }
            }else if($cuotas == 3){
                if($arrayFecha['month'] == '02'){
                    $fecha1= new Carbon($arrayFecha['year'].'-'.$arrayFecha['month'].'-15');
                    $fecha2= new Carbon($arrayFecha['year'].'-'.$arrayFecha['month'].'-28');
                    $fecha3= new Carbon($arrayFecha['year'].'-'.$sigPre.'-15');
                }else{
                    $fecha1= new Carbon($arrayFecha['year'].'-'.$arrayFecha['month'].'-15');
                    if($arrayFecha['month']=='02'){
                        $fecha2= new Carbon($arrayFecha['year'].'-'.$arrayFecha['month'].'-28');
                    }else{
                        $fecha2= new Carbon($arrayFecha['year'].'-'.$arrayFecha['month'].'-30');
                    }
                    $fecha3= new Carbon($arrayFecha['year'].'-'.$sigPre.'-15');
                }
            }else{
                if($arrayFecha['month'] == '02'){
                    $fecha1= new Carbon($arrayFecha['year'].'-'.$arrayFecha['month'].'-15');
                    $fecha2= new Carbon($arrayFecha['year'].'-'.$arrayFecha['month'].'-28');
                    $fecha3= new Carbon($arrayFecha['year'].'-'.$sigPre.'-15');
                    if($sigPre=='02'){
                        $fecha4= new Carbon($arrayFecha['year'].'-'.$sigPre.'-28');
                    }else{
                        $fecha4= new Carbon($arrayFecha['year'].'-'.$sigPre.'-30');
                    }
                }else{
                    $fecha1= new Carbon($arrayFecha['year'].'-'.$arrayFecha['month'].'-15');
                    $fecha2= new Carbon($arrayFecha['year'].'-'.$arrayFecha['month'].'-30');
                    $fecha3= new Carbon($arrayFecha['year'].'-'.$sigPre.'-15');
                    if($sigPre=='02'){
                        $fecha4= new Carbon($arrayFecha['year'].'-'.$sigPre.'-28');
                    }else{
                        $fecha4= new Carbon($arrayFecha['year'].'-'.$sigPre.'-30');
                    }
                }
            }
        }else{
            if($cuotas == 1){
                if($arrayFecha['month'] == '02'){
                    $fecha1 = new Carbon($arrayFecha['year'].'-'.$arrayFecha['month'].'-28');
                }else{
                    $fecha1= new Carbon($arrayFecha['year'].'-'.$arrayFecha['month'].'-30');
                }   
            }else if($cuotas == 2){
                if($arrayFecha['month'] == '02'){
                    $fecha1 = new Carbon($arrayFecha['year'].'-'.$arrayFecha['month'].'-28');
                    $fecha2 = new Carbon($arrayFecha['year'].'-'.$sigPre.'-15');
                }else{
                    $fecha1= new Carbon($arrayFecha['year'].'-'.$arrayFecha['month'].'-30');
                    $fecha2= new Carbon($arrayFecha['year'].'-'.$sigPre.'-15');
                }
            }else if($cuotas == 3){
                if($arrayFecha['month'] == '02'){
                    $fecha1 = new Carbon($arrayFecha['year'].'-'.$arrayFecha['month'].'-28');
                    $fecha2 = new Carbon($arrayFecha['year'].'-'.$sigPre.'-15');
                    $fecha3 = new Carbon($arrayFecha['year'].'-'.$sigPre.'-30');
                }else{
                    $fecha1= new Carbon($arrayFecha['year'].'-'.$arrayFecha['month'].'-30');
                    $fecha2= new Carbon($arrayFecha['year'].'-'.$sigPre.'-15');
                    if($sigPre=='02'){
                        $fecha3= new Carbon($arrayFecha['year'].'-'.$sigPre.'-28');
                    }else{
                        $fecha3= new Carbon($arrayFecha['year'].'-'.$sigPre.'-30');
                    }
                    
                }
            }else{
                if($arrayFecha['month'] == '02'){
                    $fecha1 = new Carbon($arrayFecha['year'].'-'.$arrayFecha['month'].'-28');
                    $fecha2 = new Carbon($arrayFecha['year'].'-'.$sigPre.'-15');
                    $fecha3 = new Carbon($arrayFecha['year'].'-'.$sigPre.'-30');
                    $fecha4 = new Carbon($arrayFecha['year'].'-'.$sigsigPre.'-15');
                }else{
                    $fecha1= new Carbon($arrayFecha['year'].'-'.$arrayFecha['month'].'-30');
                    $fecha2= new Carbon($arrayFecha['year'].'-'.$sigPre.'-15');
                    if($sigPre=='02'){
                        $fecha3= new Carbon($arrayFecha['year'].'-'.$sigPre.'-28');
                    }else{
                        $fecha3= new Carbon($arrayFecha['year'].'-'.$sigPre.'-30');
                    }
                    
                    $fecha4= new Carbon($arrayFecha['year'].'-'.$sigsigPre.'-15');
                }
            }
        }
        if($fecha1 != ''){
            $fecha1 = Carbon::parse($fecha1);
        }
        
        if($fecha2 != ''){
            $fecha2 = Carbon::parse($fecha2);
        }
        if($fecha3 != ''){
            $fecha3 = Carbon::parse($fecha3);
        }
        if($fecha4 != ''){
            $fecha4 = Carbon::parse($fecha4);
        }
        
        $fechas = [
            'fecha1' => $fecha1,
            'fecha2' => $fecha2,
            'fecha3' => $fecha3,
            'fecha4' => $fecha4,
        ];
        
        return $fechas;
    }
    
    public function saveTelefonoE(Request $request){
        $documento = $request->documento;
        $telefono = $request->telefono;
        
        $cliente = ClientesModelTiendas::where('documento','=',$documento)->first();
        $cliente->telefono = $telefono;
        $cliente->save();
        
        return response()->json(['codigo'=>200,'message'=>'Se ha modificado correctamente el numero telefonico del empleado.']);
    }
    
    private function send_sms_hablame($code_validation,$numfactura,$monto,$phone){
        $ch=curl_init();
        $post = array(
            'account' => '10013809', //número de usuario
            'apiKey' => 'io1oqFfreoZKcmjgTwbuVnOnJ0hyUg', //clave API del usuario
            'token' => '88509050b9ee56a9a44c5c640763f7a9 ', // Token de usuario
            'toNumber' => '57'.$phone, //número de destino
            'sms' => 'STARA Libranza Monto: $'.$monto.'. Este es tu codigo de firma de libranza ' . $code_validation, // mensaje de texto
            'flash'	=> '0', //mensaje tipo flash
            'sendDate'=> time(), //fecha de envío del mensaje
            'isPriority' => 1, //mensaje prioritario
            'sc'=> '899991', //código corto para envío del mensaje de texto
            'request_dlvr_rcpt' => 0, //mensaje de texto con confirmación de entrega al celular

        );

        $url = "https://api101.hablame.co/api/sms/v2.1/send/";

        curl_setopt ($ch,CURLOPT_URL,$url) ;
        curl_setopt ($ch,CURLOPT_POST,1);
        curl_setopt ($ch,CURLOPT_POSTFIELDS, $post);
        curl_setopt ($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch,CURLOPT_CONNECTTIMEOUT ,3);
        curl_setopt ($ch,CURLOPT_TIMEOUT, 20);
        $response= curl_exec($ch);
        curl_close($ch);
        $response= json_decode($response ,true) ;


        //La respuesta estará alojada en la variable $response
            
        if ($response["status"]== '1x000' ){
            return $response["smsId"];
        } else {
            return 'Ha ocurrido un error:'.$response["error_description"].'('.$response ["status" ]. ')'. PHP_EOL;
        }
    }

    private function generate_string($input, $strength = 16) {
        $input_length = strlen($input);
        $random_string = '';
        for($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
     
        return $random_string;
    }
}