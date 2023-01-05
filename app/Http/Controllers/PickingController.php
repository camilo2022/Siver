<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use File;

class PickingController extends Controller
{
    public function reporteTerminacion()
    {
        return view('picking.reporteTerminacion');
    }
    
    public function reporteTerminacion_generar(Request $request)
    {
        $fecha1 = $request->fecha1;
        $fecha2 = $request->fecha2;
        $reporte = DB::select('select id,id_orden_picking,(SELECT picking_orden.orden_picking from picking_orden WHERE picking_terminacion.id_orden_picking = picking_orden.id) AS orden_picking, item, cantidad, created_at from picking_terminacion WHERE created_at BETWEEN "'.$request->fecha1.' 00:00:00" AND "'.$request->fecha2.' 23:59:59"');
        return response()->json(view('picking.fragmentoReporteTerminacion', compact('reporte','fecha1','fecha2'))->render());
    }
    
    public function reporteBodega()
    {
        return view('picking.reporteBodega');
    }
    
    public function reporteBodega_generar(Request $request)
    {
        $fecha1 = $request->fecha1;
        $fecha2 = $request->fecha2;
        $reporte = DB::select('select id,id_orden_picking,(SELECT picking_orden.orden_picking from picking_orden WHERE picking_bodega.id_orden_picking = picking_orden.id) AS orden_picking, item, cantidad, created_at from picking_bodega WHERE created_at BETWEEN "'.$request->fecha1.' 00:00:00" AND "'.$request->fecha2.' 23:59:59"');
        return response()->json(view('picking.fragmentoReporteBodega', compact('reporte','fecha1','fecha2'))->render());
    }
    
    public function orden_picking_list()
    {
        //$ordenes = DB::table('picking_orden')->get();
        $ordenes = DB::select('select id,orden_picking,tipo_referencia,referencia,observacion,fecha_picking_terminacion,(SELECT users.names from users WHERE id_user_terminacion = users.id) as user_name_terminacion,(SELECT users.apellidos from users WHERE id_user_terminacion = users.id) as user_apellido_terminacion,observacion_terminacion,fecha_picking_bodega,(SELECT users.names from users WHERE id_user_bodega = users.id) as user_name_bodega,(SELECT users.apellidos from users WHERE id_user_bodega = users.id) as user_apellido_bodega,observacion_bodega,status,created_at from picking_orden');
        return view('picking.tabla_orden_picking')->with('ordenes',$ordenes);
    }

    public function picking_historial_list()
    {
        //$historial = DB::table('picking_historial_orden')->get();
        $historial = DB::select('select id,orden_picking,tipo_referencia,referencia,fecha_picking_terminacion,(SELECT users.names from users WHERE id_user_terminacion = users.id) as user_name_terminacion,(SELECT users.apellidos from users WHERE id_user_terminacion = users.id) as user_apellido_terminacion,observacion_terminacion,fecha_picking_bodega,(SELECT users.names from users WHERE id_user_bodega = users.id) as user_name_bodega,(SELECT users.apellidos from users WHERE id_user_bodega = users.id) as user_apellido_bodega,observacion_bodega,created_at from picking_historial_orden');
        return view('picking.tabla_historial_picking')->with('historial',$historial);
    }

    public function picking_terminacion_list()
    {
        $ordenes = DB::table('picking_orden')->where('status','=','Creado')->get();
        return view('picking.tabla_picking_terminacion')->with('ordenes',$ordenes);
    }

    public function picking_bodega_list()
    {
        $ordenes = DB::table('picking_orden')->where('status','=','Enviado')->get();
        return view('picking.tabla_picking_bodega')->with('ordenes',$ordenes);
    }

    public function bodega_list()
    {
        //$ordenes = DB::table('picking_orden')->where('status','!=','Creado')->get();
        $ordenes = DB::select('select id,orden_picking,tipo_referencia,referencia,observacion,fecha_picking_bodega,(SELECT users.names from users WHERE id_user_bodega = users.id) as user_name_bodega,(SELECT users.apellidos from users WHERE id_user_bodega = users.id) as user_apellido_bodega,observacion_bodega,status,created_at from picking_orden where status != "Creado"');
        return view('picking.tabla_bodega')->with('ordenes',$ordenes);
    }

    public function picking_historial_consulta(Request $request)
    {
        $datos = DB::select('select id,proceso,(SELECT users.names from users WHERE id_user = users.id) as user_name,(SELECT users.apellidos from users WHERE id_user = users.id) as user_apellido,id_orden_picking,item,cantidad,created_at,(SELECT picking_historial_orden.orden_picking from picking_historial_orden WHERE id_orden_picking = picking_historial_orden.id) AS orden_picking from picking_historial WHERE id_orden_picking = '.$request->id.' and created_at = "'.$request->fecha.'"');
        return response()->json($datos);
    }

    public function bodega_list_consulta(Request $request)
    {
        $datos = DB::select('select id,item,cantidad,(SELECT picking_orden.orden_picking from picking_orden WHERE '.$request->id.'=picking_orden.id) AS orden_picking from picking_bodega WHERE '.$request->id.'=id_orden_picking');
        return response()->json($datos);
    }

    public function terminacion_consulta(Request $request)
    {   
        $datos = DB::select('select id,item,cantidad,(SELECT picking_orden.orden_picking from picking_orden WHERE '.$request->id.'=picking_orden.id) AS orden_picking from picking_terminacion WHERE '.$request->id.'=id_orden_picking');
        return response()->json($datos);   
    }

    public function bodega_consulta(Request $request)
    {   
        $datos = DB::select('select id,item,cantidad,(SELECT picking_orden.orden_picking from picking_orden WHERE '.$request->id.'=picking_orden.id) AS orden_picking from picking_bodega WHERE '.$request->id.'=id_orden_picking');
        return response()->json($datos);   
    }

    public function orden_picking_create()
    {
        $consecutivo = DB::select('select max(orden_picking) as consecutivo from picking_orden');
        $newconsecutivo = $consecutivo[0]->consecutivo + 1;
        return view('picking.form_orden_picking')->with('newconsecutivo',$newconsecutivo);
    }

    public function orden_picking_store(Request $request)
    {
        $created_at = Carbon::now();
        $status = "Creado";
        DB::insert('insert into picking_orden (orden_picking,tipo_referencia,referencia,observacion,status,created_at) values (?,?,?,?,?,?)', [$request->orden,$request->tipo,strtoupper($request->referencia),$request->observacion,$status,$created_at]);
        return redirect()->route('orden_picking_list');
    }

    public function terminacion_picking_create($id)
    {
        $picking = DB::table('picking_orden')->where('id','=',$id)->get();
        return view('picking.form_picking_terminacion')->with('picking',$picking);
    }

    public function picking_terminacion_store(Request $request)
    {
        $created_at = Carbon::now();
        $error = null;
        if($request->error == 0){
            $error = null;
        }elseif($request->error > 0){
            $error = "Se registraron ".$request->error." errores de tickets al momento del picking.";
        }
        $id = $request->id;
        $tableDinamicArray = $request->get('tableDinamicArray');
        for ($i=0;$i<count($tableDinamicArray);$i++){ 
            DB::insert('insert into picking_terminacion (id_orden_picking, item, cantidad, created_at) values (?,?,?,?)', [$id,$tableDinamicArray[$i][0], $tableDinamicArray[$i][1], $created_at]);
        }
        DB::table('picking_orden')->where('id','=',$request->id)->update(['id_user_terminacion'=>$request->userid,'observacion_terminacion'=>$error,'fecha_picking_terminacion'=>$created_at,'status'=>'Enviado']);
        return response()->json([1,'Terminacion']);
    }

    public function bodega_picking_create($id)
    {
        $picking = DB::table('picking_orden')->where('id','=',$id)->get();
        return view('picking.form_picking_bodega')->with('picking',$picking);
    }

    public function picking_bodega_store(Request $request)
    {
        $created_at = Carbon::now();
        $id = $request->id;
        $tableDinamicArray = $request->get('tableDinamicArray');
        for ($i=0;$i<count($tableDinamicArray);$i++){ 
            DB::insert('insert into picking_bodega (id_orden_picking, item, cantidad, created_at) values (?,?,?,?)', [$id,$tableDinamicArray[$i][0], $tableDinamicArray[$i][1], $created_at]);
        }
        $terminacion = DB::table('picking_terminacion')->where('id_orden_picking','=',$id)->get();
        $bodega = DB::table('picking_bodega')->where('id_orden_picking','=',$id)->get();
        $boolean = false;
        foreach ($terminacion as $ter) {
        $existe = false;
        $cantidad = 0;
            foreach ($bodega as $bod) {
                if($ter->item == $bod->item){
                    $existe = true;
                    $cantidad = $bod->cantidad;
                    break;
                }else{
                    $existe = false;
                }
            }
            if($existe == true){
                if($ter->cantidad != $cantidad){
                    $boolean = true;
                    break;
                }
            }else{
                $boolean = true;
                    break;
            }
        }
        
        if($boolean){
            return $this->actualizacionEstado($request->id,$request->userid,$created_at, 'En espera');
        }else {
            return $this->actualizacionEstado($request->id,$request->userid,$created_at, 'Aceptado');
        }
    }
    
    private function actualizacionEstado($id,$userid,$fechacreacion,$status){
        DB::table('picking_orden')->where('id','=',$id)->update(['id_user_bodega'=>$userid,'fecha_picking_bodega'=>$fechacreacion,'status'=>$status]);
        return $status == 'En espera' ? response()->json([2,'Bodega']) : response()->json([1,'Bodega']);;
    }

    public function picking_consulta(Request $request)
    {
        $refe_ing = $request->get('refe_ing');
        $consulta = DB::table('smc_picking')->where('codigo','=',$refe_ing)->get();
        if(count($consulta)>0){
            return response()->json(1);
        }else{
            return response()->json(2);
        }
    }
    public function consulta_cantidad(Request $request)
    {
        $existe = DB::table('picking_terminacion')->where('id_orden_picking','=',$request->id)->where('item','=',$request->cod)->get();
        if(count($existe)==0){
            return response()->json(2);
        }else{
            if($request->sum_cant > $existe[0]->cantidad){
                return response()->json([1,$request->cod,$request->sum_cant,$existe[0]->cantidad]);
            }
        }
        
    }

    public function revision_picking_bodega($id)
    {
        $terminacion = DB::select('select id,item,cantidad,(SELECT picking_orden.orden_picking from picking_orden WHERE '.$id.'=picking_orden.id) AS orden_picking from picking_terminacion WHERE '.$id.'=id_orden_picking');
        $bodega = DB::select('select id,item,cantidad,(SELECT picking_orden.orden_picking from picking_orden WHERE '.$id.'=picking_orden.id) AS orden_picking from picking_bodega WHERE '.$id.'=id_orden_picking');
        $arrayTerminacion = [];
        $arrayBodega = [];
        $sumTer = 0;
        $sumBod = 0;
        foreach ($bodega as $item_bod) {
            $existe = true;
            foreach ($terminacion as $item_ter) {
                if($item_bod->item == $item_ter->item){
                    $existe = true;
                    if($item_bod->cantidad != $item_ter->cantidad){
                        array_push($arrayBodega, array(  
                            "class_item" => 'badge badge-success',
                            "class_cant" => 'badge badge-danger',
                            "id" => $item_bod->id,
                            "orden" => $item_bod->orden_picking,
                            "item" => $item_bod->item,
                            "cantidad" => $item_bod->cantidad,
                        ));
                        break;
                    }
                    if($item_bod->cantidad == $item_ter->cantidad){
                        array_push($arrayBodega, array(  
                            "class_item" => 'badge badge-success',
                            "class_cant" => 'badge badge-success',
                            "id" => $item_bod->id,
                            "orden" => $item_bod->orden_picking,
                            "item" => $item_bod->item,
                            "cantidad" => $item_bod->cantidad,
                        ));
                        break;
                    }
                }else{
                    $existe = false;
                }
            }
            if($existe == false){
                array_push($arrayBodega, array(  
                    "class_item" => 'badge badge-danger',
                    "class_cant" => 'badge badge-danger',
                    "id" => $item_bod->id,
                    "orden" => $item_bod->orden_picking,
                    "item" => $item_bod->item,
                    "cantidad" => $item_bod->cantidad,
                ));
            }
            $sumBod+=$item_bod->cantidad;
        }
        foreach ($terminacion as $item_ter) {
            $existe = true;
            foreach ($bodega as $item_bod) {
                if($item_ter->item == $item_bod->item){
                    $existe = true;
                    if($item_ter->cantidad != $item_bod->cantidad){
                        array_push($arrayTerminacion, array(  
                            "class_item" => 'badge badge-success',
                            "class_cant" => 'badge badge-danger',
                            "id" => $item_ter->id,
                            "orden" => $item_ter->orden_picking,
                            "item" => $item_ter->item,
                            "cantidad" => $item_ter->cantidad,
                        ));
                        break;
                    }
                    if($item_bod->cantidad == $item_ter->cantidad){
                        array_push($arrayTerminacion, array(  
                            "class_item" => 'badge badge-success',
                            "class_cant" => 'badge badge-success',
                            "id" => $item_ter->id,
                            "orden" => $item_ter->orden_picking,
                            "item" => $item_ter->item,
                            "cantidad" => $item_ter->cantidad,
                        ));
                        break;
                    }
                }else{
                    $existe = false;
                }
            }
            if($existe == false){
                array_push($arrayTerminacion, array(  
                    "class_item" => 'badge badge-danger',
                    "class_cant" => 'badge badge-danger',
                    "id" => $item_ter->id,
                    "orden" => $item_ter->orden_picking,
                    "item" => $item_ter->item,
                    "cantidad" => $item_ter->cantidad,
                ));
            }
            $sumTer+=$item_ter->cantidad;
        }
        return view('picking.form_comparacion')->with('sumTer',$sumTer)->with('sumBod',$sumBod)->with('arrayTerminacion',$arrayTerminacion)->with('arrayBodega',$arrayBodega)->with('id',$id);
    }

    public function aceptar_picking_bodega(Request $request,$id)
    {
        DB::table('picking_orden')->where('id','=',$request->id)->update(['observacion_bodega'=>$request->obs_acp,'status'=>'Aceptado']);
        return redirect()->route('bodega_list');
    }

    public function rechazar_picking_bodega(Request $request,$id)
    {
        DB::table('picking_orden')->where('id','=',$request->id)->update(['observacion_bodega'=>$request->obs_rec,'status'=>'Rechazado']);
        return redirect()->route('bodega_list');
    }

    public function repicking_picking_bodega($id)
    {
        $picking = DB::table('picking_orden')->where('id','=',$id)->get();
        return view('picking.form_picking_confirmacion_bodega')->with('picking',$picking);
    }

    public function repicking_bodega_store(Request $request)
    {
        DB::table('picking_bodega')->where('id_orden_picking','=',$request->id)->delete();
        $created_at = Carbon::now();
        $id = $request->id;
        $tableDinamicArray = $request->get('tableDinamicArray');
        for ($i=0;$i<count($tableDinamicArray);$i++){ 
            DB::insert('insert into picking_bodega (id_orden_picking, item, cantidad, created_at) values (?,?,?,?)', [$id,$tableDinamicArray[$i][0], $tableDinamicArray[$i][1], $created_at]);
        }
        $terminacion = DB::table('picking_terminacion')->where('id_orden_picking','=',$id)->get();
        $bodega = DB::table('picking_bodega')->where('id_orden_picking','=',$id)->get();
        $boolean = false;
        foreach ($terminacion as $ter) {
        $existe = false;
        $cantidad = 0;
            foreach ($bodega as $bod) {
                if($ter->item == $bod->item){
                    $existe = true;
                    $cantidad = $bod->cantidad;
                    break;
                }else{
                    $existe = false;
                }
            }
            if($existe == true){
                if($ter->cantidad != $cantidad){
                    $boolean = true;
                    break;
                }
            }else{
                $boolean = true;
                    break;
            }
        }
        if($boolean == false){
            DB::table('picking_orden')->where('id','=',$request->id)->update(['fecha_picking_bodega'=>$created_at,'status'=>'Aceptado']);
            return response()->json([1,'Bodega']);
        }
        if($boolean == true){
            DB::table('picking_orden')->where('id','=',$request->id)->update(['fecha_picking_bodega'=>$created_at,'status'=>'En espera']);
            return response()->json([2,'Bodega']);
        }
    }

    public function repicking_orden_picking($id)
    {
        $picking = DB::table('picking_orden')->where('id','=',$id)->get();
        return view('picking.form_picking_confirmacion_control')->with('picking',$picking);
    }

    public function repicking_orden_picking_store(Request $request)
    {
        $created_at = Carbon::now();
        $id = $request->id;
        $tableDinamicArray = $request->get('tableDinamicArray');
        
        $orden = DB::table('picking_orden')->where('id','=',$id)->get();
        $terminacion = DB::table('picking_terminacion')->where('id_orden_picking','=',$id)->get();
        $bodega = DB::table('picking_bodega')->where('id_orden_picking','=',$id)->get();
        $users = DB::table('picking_orden')->where('id','=',$id)->get();

        DB::insert('insert into picking_historial_orden (orden_picking,tipo_referencia,referencia,fecha_picking_terminacion,id_user_terminacion,observacion_terminacion,fecha_picking_bodega,id_user_bodega,observacion_bodega,created_at) values (?,?,?,?,?,?,?,?,?,?)', [$orden[0]->orden_picking, $orden[0]->tipo_referencia, $orden[0]->referencia,$orden[0]->fecha_picking_terminacion,$orden[0]->id_user_terminacion,$orden[0]->observacion_terminacion,$orden[0]->fecha_picking_bodega,$orden[0]->id_user_bodega,$orden[0]->observacion_bodega,$created_at]);
        $orden_history = DB::select('select max(id) as id from picking_historial_orden');
        for ($i=0;$i<count($terminacion);$i++) { 
            DB::insert('insert into picking_historial (proceso, id_user, id_orden_picking, item, cantidad, created_at) values (?,?,?,?,?,?)', ['Terminacion',$users[0]->id_user_terminacion, $orden_history[0]->id, $terminacion[$i]->item, $terminacion[$i]->cantidad, $created_at]);
        }
        for ($i=0;$i<count($bodega);$i++) { 
            DB::insert('insert into picking_historial (proceso, id_user, id_orden_picking, item, cantidad, created_at) values (?,?,?,?,?,?)', ['Bodega',$users[0]->id_user_bodega, $orden_history[0]->id, $bodega[$i]->item, $bodega[$i]->cantidad, $created_at]);
        }
        DB::table('picking_bodega')->where('id_orden_picking','=',$id)->delete();
        for ($i=0;$i<count($tableDinamicArray);$i++){ 
            DB::insert('insert into picking_bodega (id_orden_picking, item, cantidad, created_at) values (?,?,?,?)', [$id,$tableDinamicArray[$i][0], $tableDinamicArray[$i][1], $created_at]);
        }
        DB::table('picking_orden')->where('id','=',$id)->update(['observacion_bodega'=>'Revisar el historial de la orden ya que estuvo en estado Rechazado.','status'=>'Aceptado']);
        return response()->json([1,'Control']);
    }
}
