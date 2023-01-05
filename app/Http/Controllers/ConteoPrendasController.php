<?php

namespace App\Http\Controllers;

use App\Models\conteoPrenda;
use App\Models\pickingConteoPrendas;
use Illuminate\Http\Request;
use App\Exports\PickingExport;
use App\Exports\ExportPickinMultiSheet;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PickingTipoPrenda;
use Illuminate\Support\Facades\Http;

class ConteoPrendasController extends Controller
{
    
    public function exportarListadoPicking(Request $request){
        $fecha1 = $request->fecha1;
        $fecha2 = $request->fecha2;
        
       $listado = conteoPrenda::whereBetween('created_at', [$fecha1." 00:00:00",$fecha2." 23:59:59"])->get();
        if($listado != null){
            //$name="listadoPicking".$fecha1." hasta ".$fecha2.".xlsx";
            return Excel::download(new PickingExport($listado),"ListadoPicking.xlsx");
            //return Excel::download(new ExportPickinMultiSheet($listado),"ListadoPicking.xlsx");
        }else {
            return 'No hay despachos para mostrar';
        }
    }
    
    
    public function saveConteoCurva(Request $request){
        $referencia = $request->referencia;
        $curva = $request->curva;
        $conteo = conteoPrenda::where('referencia','=',$referencia)->where('estado','=',0)->groupBy('id')->latest()->first();
        if(isset($conteo)){
         $mytime = \Carbon\Carbon::now();
         $conteo->estado=1;
         $conteo->obs='Cerrada el '.$mytime->toDateTimeString().' luego de ingresar referencia';
         $conteo->save();
        }
        $total =0;
        for($i=0;$i<count($curva);$i++){
            $total += abs($curva[$i]['cantidad']);
        }
    
        
        $conteoCreate = conteoPrenda::create([
    	   'referencia' => $referencia,
    	   'estado' => 0,
    	   'tipo' => '',
    	   'obs' => 'NULL',
    	   'total' => $total,
    	   'user_id' => auth()->user()->id,
    	   'restante' => $total,
    	   't04' => isset($curva[0]['cantidad'])?abs($curva[0]['cantidad']):0,
    	   't06' => isset($curva[1]['cantidad'])?abs($curva[1]['cantidad']):0,
    	   't08' => isset($curva[2]['cantidad'])?abs($curva[2]['cantidad']):0,
    	   't10' => isset($curva[3]['cantidad'])?abs($curva[3]['cantidad']):0,
    	   't12' => isset($curva[4]['cantidad'])?abs($curva[4]['cantidad']):0,
    	   't14' => isset($curva[5]['cantidad'])?abs($curva[5]['cantidad']):0,
    	   't16' => isset($curva[6]['cantidad'])?abs($curva[6]['cantidad']):0,
    	   't18' => isset($curva[7]['cantidad'])?abs($curva[7]['cantidad']):0,
    	   't20' => isset($curva[8]['cantidad'])?abs($curva[8]['cantidad']):0,
    	   't22' => isset($curva[9]['cantidad'])?abs($curva[9]['cantidad']):0,
    	   't24' => isset($curva[10]['cantidad'])?abs($curva[10]['cantidad']):0,
    	   't26' => isset($curva[11]['cantidad'])?abs($curva[11]['cantidad']):0,
    	   't28' => isset($curva[12]['cantidad'])?abs($curva[12]['cantidad']):0,
    	   't30' => isset($curva[13]['cantidad'])?abs($curva[13]['cantidad']):0,
    	   't32' => isset($curva[14]['cantidad'])?abs($curva[14]['cantidad']):0,
    	   't34' => isset($curva[15]['cantidad'])?abs($curva[15]['cantidad']):0,
    	   't36' => isset($curva[16]['cantidad'])?abs($curva[16]['cantidad']):0,
    	   't38' => isset($curva[17]['cantidad'])?abs($curva[17]['cantidad']):0,
    	]);
    	if(str_contains($conteoCreate->referencia,'S975')){
               $conteoCreate->tipo='SALDOS';
           }else if(str_contains($conteoCreate->referencia,'M975')){
               $conteoCreate->tipo='MARRAS';
           }
           $conteoCreate->save();
    	
        return response()->json(['message'=> 'Se ha cargado la curva de  la referencia, comienza a pickear', 'conteoCreate' => $conteoCreate]);
    }
    
    public function pickingSave(Request $request){
        $idConteo = $request->idconteo;
        $lecturaReferencia = $request->lecturaReferencia;
        
        if(strlen($lecturaReferencia) == 5) return $this->consumirAPIDescontarTalla($lecturaReferencia);
        
        if(str_contains($lecturaReferencia,"-")){
            $partes = explode('-',$lecturaReferencia);
        }else{
            $partes = explode("'",$lecturaReferencia);
        }
        
        if(count($partes) > 3){
            if(str_contains($lecturaReferencia,"-")){
                $referencia = $partes[0]."-".$partes[1];
                $talla = $partes[2];
            }else{
                $referencia = $partes[0]."'".$partes[1];
                $talla = $partes[2];
            }
        }else{
            $referencia = $partes[0];
            $talla = $partes[1];
        }
        
        
        $pickingConteoPrendas = pickingConteoPrendas::where('idconteoprendas','=',$idConteo)->first();
        $pik=null;
        
        if(isset($pickingConteoPrendas)){
            $pik = $pickingConteoPrendas;
        }else{
            $pik = pickingConteoPrendas::create([
        	   'idconteoprendas' => $idConteo,
        	   'tipo' => 0,
        	   't04' => 0,
        	   't06' => 0,
        	   't08' => 0,
        	   't10' => 0,
        	   't12' => 0,
        	   't14' => 0,
        	   't16' => 0,
        	   't18' => 0,
        	   't20' => 0,
        	   't22' => 0,
        	   't24' => 0,
        	   't26' => 0,
        	   't28' => 0,
        	   't30' => 0,
        	   't32' => 0,
        	   't34' => 0,
        	   't36' => 0,
        	   't38' => 0,
            ]);
        }
        
        $this->sumarTalla($pik,$talla,$referencia,$idConteo);
           if(str_contains($referencia,'S975') || str_contains($referencia,'s975') ){
               $pik->tipo=1;
           }else if(str_contains($referencia,'M975') || str_contains($referencia,'m975')){
               $pik->tipo=2;
           }
           $pik->save();
           
           $curvaConteo = [
                    $pik->t04,
                    $pik->t06,
                    $pik->t08,
                    $pik->t10,
                    $pik->t12,
                    $pik->t14,
                    $pik->t16,
                    $pik->t18,
                    $pik->t20,
                    $pik->t22,
                    $pik->t24,
                    $pik->t26,
                    $pik->t28,
                    $pik->t30,
                    $pik->t32,
                    $pik->t34,
                    $pik->t36,
                    $pik->t38,
            ];
            
            $totali=0;
           for($i=0;$i<count($curvaConteo);$i++){
               $totali+=$curvaConteo[$i];
           }
           $conteoe = conteoPrenda::where('id','=',$idConteo)->first();
           $conteoe->restante = $conteoe->total - $totali;
           $conteoe->save();
           
           $saldos = PickingTipoPrenda::where('id_referencia','=',$idConteo)->where('tipo_prenda','=','SALDOS')->get();
           $marras = PickingTipoPrenda::where('id_referencia','=',$idConteo)->where('tipo_prenda','=','MARRAS')->get();
           
           $saldoss=0;
           $marrass=0;
           
           foreach($saldos as $saldo){
               $saldoss += $saldo->cantidad;
           }
           
           foreach($marras as $marra){
               $marrass += $marra->cantidad;
           }
           
        return response()->json(['message' => 'se ha guardado correctamente la referencia','conteoObject'=>$conteoe,'conteo' => $curvaConteo,'Totalsaldos' => $saldoss, 'Totalmarras' => $marrass]);
    }
    
    private function consumirAPIDescontarTalla($lecturaReferencia){
        return dd($this->LoginAPIDataWareHouse('carlos@bless.com','12345678'));
    }
    
    public function getInformacionSKU(Request $request){
        $sku = $request->sku;
         return dd($this->LoginAPIDataWareHouse('carlos@bless.com','12345678')->body());
    }
    
    private function LoginAPIDataWareHouse($email,$password){
        //try {
            $baseUrl = env('API_ENDPOINT');
            
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest',
                'Host' => '51.222.114.20',
            ])->post($baseUrl.'/auth/login', [
                'email' => $email,
                'password' => $password,
            ]);
            return dd($response);
    }
    
    public function marcarCerrado(Request $request){
        $iconteo = $request->conteoid;
        $con = conteoPrenda::where('id','=',$iconteo)->first();
        $con->estado=1;
        $con->obs = 'Ha sido cerrado por el usuario';
        $con->save();
        return response()->json(['message' => 'Se ha marcado el conteo de la prenda como cerrado.']);
    }
    
    private function sumarTalla($pickModel, $talla,$referencia,$idConteo){
            if(str_contains($referencia,"S975") || str_contains($referencia,"s975")){
                $saldo = PickingTipoPrenda::where('id_referencia','=',$idConteo)->where('talla','=',$talla)->where('tipo_prenda','=','SALDOS')->first();
                if(isset($saldo)){
                    $saldo->cantidad ++;
                    $saldo->save();
                }else{
                    PickingTipoPrenda::create([
                	   'id_referencia' => $idConteo ,
                	   'tipo_prenda' => 'SALDOS',
                	   'talla' => $talla,
                	   'cantidad' => 1
                    ]);
                }
            }else if(str_contains($referencia,"M975") || str_contains($referencia,"m975")){
                $saldo = PickingTipoPrenda::where('id_referencia','=',$idConteo)->where('talla','=',$talla)->where('tipo_prenda','=','MARRAS')->first();
                if(isset($saldo)){
                    $saldo->cantidad ++;
                    $saldo->save();
                }else{
                    PickingTipoPrenda::create([
                	   'id_referencia' => $idConteo ,
                	   'tipo_prenda' => 'MARRAS',
                	   'talla' => $talla,
                	   'cantidad' => 1
                    ]);
                }
            }
            if($talla =='04'){
                $pickModel->t04 +=1;
                $pickModel->save();
            }else if($talla =='06'){
                $pickModel->t06 +=1;
                $pickModel->save();
            }else if($talla =='08'){
                $pickModel->t08 +=1;
                $pickModel->save();
            }else if($talla =='10'){
                $pickModel->t10 +=1;
                $pickModel->save();
            }else if($talla =='12'){
                $pickModel->t12 +=1;
                $pickModel->save();
            }else if($talla =='14'){
                $pickModel->t14 +=1;
                $pickModel->save();
            }else if($talla =='16'){
                $pickModel->t16 +=1;
                $pickModel->save();
            }else if($talla =='18'){
                $pickModel->t18 +=1;
                $pickModel->save();
            }else if($talla =='20'){
                $pickModel->t20 +=1;
                $pickModel->save();
            }else if($talla =='22'){
                $pickModel->t22 +=1;
                $pickModel->save();
            }else if($talla =='24'){
                $pickModel->t24 +=1;
                $pickModel->save();
            }else if($talla =='26'){
                $pickModel->t26 +=1;
                $pickModel->save();
            }else if($talla =='28'){
                $pickModel->t28 +=1;
                $pickModel->save();
            }else if($talla =='30'){
                $pickModel->t30 +=1;
                $pickModel->save();
            }else if($talla =='32'){
                $pickModel->t32 +=1;
                $pickModel->save();
            }else if($talla =='34'){
                $pickModel->t34 +=1;
                $pickModel->save();
            }else if($talla =='36'){
                $pickModel->t36+=1;
                $pickModel->save();
            }else if($talla =='38'){
                $pickModel->t38 +=1;
                $pickModel->save();
            }
    }
}