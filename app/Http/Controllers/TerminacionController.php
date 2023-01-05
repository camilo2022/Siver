<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\ClientesModelTiendas;
use App\Exports\TerminacionExport;
use App\Exports\ArchivoPrimarioExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;


class TerminacionController extends Controller
{
    public function download_excel()
    {
        $terminacion = DB::select('select id,fecha,turno,modulo,(SELECT referencias.lote_referencia from referencias WHERE terminacion.id_referencia=referencias.id) AS referencia,tallas,tc, tipo, hora, cantidad,tiempo_req_h,meta_produccion,eficiencia,n_operarios,(SELECT paradas_programadas.tipo_parada_prg from paradas_programadas WHERE terminacion.id_parada_prg=paradas_programadas.id) AS parada_programada, (SELECT paradas_programadas.tiempo from paradas_programadas WHERE terminacion.id_parada_prg = paradas_programadas.id) AS tiempo_parada_programada, (SELECT paradas_no_programadas.tipo_parada_noprg from paradas_no_programadas WHERE terminacion.id_parada_noprg=paradas_no_programadas.id) AS parada_no_programada,tiempo_noprg from terminacion');
        return Excel::download(new TerminacionExport($terminacion),"Terminacion.xlsx");
    }
    
    public function index_terminacion()
    {
        $terminacion = DB::select('select id,fecha,turno,modulo,(SELECT referencias.lote_referencia from referencias WHERE terminacion.id_referencia=referencias.id) AS referencia,tallas,tc, tipo, hora, cantidad,tiempo_req_h,meta_produccion,eficiencia,n_operarios,(SELECT paradas_programadas.tipo_parada_prg from paradas_programadas WHERE terminacion.id_parada_prg=paradas_programadas.id) AS parada_programada, (SELECT paradas_programadas.tiempo from paradas_programadas WHERE terminacion.id_parada_prg = paradas_programadas.id) AS tiempo_parada_programada, (SELECT paradas_no_programadas.tipo_parada_noprg from paradas_no_programadas WHERE terminacion.id_parada_noprg=paradas_no_programadas.id) AS parada_no_programada,tiempo_noprg from terminacion where fecha BETWEEN date_add(NOW(), INTERVAL -45 DAY) AND NOW()');
        
        return view('terminacion.tabla_terminacion')->with('terminacion',$terminacion);
    }

    public function index_terminacion_hoy()
    {
        $fecha = Carbon::now();
        $fecha = $fecha->format('Y-m-d');
        $terminacion = DB::select('select id,fecha,turno,modulo,(SELECT referencias.lote_referencia from referencias WHERE terminacion.id_referencia=referencias.id) AS referencia,tallas,tc, tipo, hora, cantidad,tiempo_req_h,meta_produccion,eficiencia,n_operarios,(SELECT paradas_programadas.tipo_parada_prg from paradas_programadas WHERE terminacion.id_parada_prg=paradas_programadas.id) AS parada_programada, (SELECT paradas_programadas.tiempo from paradas_programadas WHERE terminacion.id_parada_prg = paradas_programadas.id) AS tiempo_parada_programada, (SELECT paradas_no_programadas.tipo_parada_noprg from paradas_no_programadas WHERE terminacion.id_parada_noprg=paradas_no_programadas.id) AS parada_no_programada,tiempo_noprg from terminacion where fecha = "'.$fecha.'"');
        return view('terminacion.tabla_terminacion')->with('terminacion',$terminacion);
    }

    public function parada_no_prg_store(Request $request)
    {
        $created_at = Carbon::now();
        $tipo_parada_noprg = $request->get('no_prg');
        DB::insert('insert into paradas_no_programadas (tipo_parada_noprg,created_at) values (?,?)', [$tipo_parada_noprg,$created_at]);
        
        $new = DB::table('paradas_no_programadas')->where('tipo_parada_noprg','=',$tipo_parada_noprg)->get();
        $array = json_decode($new,true);
        return response()->json($array);
    }

    public function parada_prg_store(Request $request)
    {
        $created_at = Carbon::now();
        $tipo_parada_prg = $request->get('prg');
        $tiempo_parada_prg = $request->get('tprg');
        DB::insert('insert into paradas_programadas (tipo_parada_prg,tiempo,created_at) values (?,?,?)', [$tipo_parada_prg,$tiempo_parada_prg,$created_at]);
        
        $new = DB::table('paradas_programadas')->where('tipo_parada_prg','=',$tipo_parada_prg)->get();
        $array = json_decode($new,true);
        return response()->json($array);
    }

    public function create_terminacion()
    {
        $programadas = DB::table('paradas_programadas')->get();
        $no_programadas = DB::table('paradas_no_programadas')->get();
        return view('terminacion.form_terminacion',compact('programadas','no_programadas'));
    }

    public function store_terminacion(Request $request)
    {
        $fecha = $request->get('fecha');
        $turno = $request->get('turno');
        $modulo = $request->get('modulo');
        $id_refe = $request->get('id_refe');
        $tallas = $request->get('tallas');
        $tc = $request->get('tc');
        $tipo = $request->get('tipo');
        $hora = $request->get('hora');
        $cantidad = $request->get('cantidad');
        $tiempo_r = $request->get('tiempo_r');
        $n_operarios = $request->get('n_operarios');
        $tipo_p_prgm = $request->get('tipo_p_prgm');
        $tipo_pno_prgm = $request->get('tipo_pno_prgm');
        $tiempo_pno_prgm = $request->get('tiempo_pno_prgm');
        $created_at = Carbon::now();

        $tiempo_p_prg = DB::table('paradas_programadas')->where('id','=',$tipo_p_prgm)->get('tiempo');
        
        if(count($tiempo_p_prg) == 0){
            $tiempo_p_prg = 0;
        }else{
            $t = json_decode($tiempo_p_prg,true);
            $tiempo_p_prg = $t[0]['tiempo'];
        }
        if($tiempo_pno_prgm == ""){
            $tiempo_pno_prgm = 0;
        }

        $td = $n_operarios*$tiempo_r*3600;
        $totaltpp = $tiempo_p_prg*$n_operarios;
        $meta_p = ($td-$totaltpp-$tiempo_pno_prgm)/$tc;
        
        if($meta_p==0){
            $eficiencia=0;
            $cantidad=0;
        }else{
        $eficiencia = ($cantidad/$meta_p)*100;
        }

        $updated_refe = Carbon::now();
        $cant_refe = DB::table('referencias')->where('id','=',$id_refe)->get();
        $cant_ref = json_decode($cant_refe,true);
        $new_cant = 0;

        if($modulo == 1){
            $new_cant = $cant_ref[0]['cantidad_disponible_terminacion_des']-$cantidad;
            }
        elseif($modulo == 2){
            $new_cant = $cant_ref[0]['cantidad_disponible_terminacion_tac']-$cantidad;
            }
        elseif($modulo == 3){
            $new_cant = $cant_ref[0]['cantidad_disponible_terminacion_pla']-$cantidad;
            }
        elseif($modulo == 4){
            $new_cant = $cant_ref[0]['cantidad_disponible_terminacion_mes']-$cantidad;
            }
        

        $validar_si_existe = DB::table('terminacion')->where('fecha','=',$fecha)->where('turno','=',$turno)->where('modulo','=',$modulo)->where('hora','=',$hora)->get();
        
        if(count($validar_si_existe)>0){
            $array_validar = json_decode($validar_si_existe,true);
            $sum_time_req = 0;
                for($i=0;$i<count($array_validar);$i++){
                    $sum_time_req+=$array_validar[$i]['tiempo_req_h'];
                }
                $sum_time_req+=$tiempo_r;
                if($sum_time_req>1){
                    return response()->json(2);
                }else{
                    if($modulo == 1){
                        DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_terminacion_des'=>$new_cant, 'updated_at'=>$updated_refe,]);
                        }
                    elseif($modulo == 2){
                        DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_terminacion_tac'=>$new_cant, 'updated_at'=>$updated_refe,]);
                        }
                    elseif($modulo == 3){
                        DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_terminacion_pla'=>$new_cant, 'updated_at'=>$updated_refe,]);
                        }
                    elseif($modulo == 4){
                        DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_terminacion_mes'=>$new_cant, 'updated_at'=>$updated_refe,]);
                        }
                    DB::insert('insert into terminacion (fecha,turno,modulo,id_referencia,tallas,tc,tipo,hora,cantidad,tiempo_req_h,meta_produccion,eficiencia,n_operarios,id_parada_prg,id_parada_noprg,tiempo_noprg,created_at) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$fecha,$turno,$modulo,$id_refe,$tallas,$tc,$tipo,$hora,$cantidad,$tiempo_r,$meta_p,$eficiencia,$n_operarios,$tipo_p_prgm,$tipo_pno_prgm,$tiempo_pno_prgm,$created_at]);
                    return response()->json(1);
                }
        }else{
            if($modulo == 1){
                DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_terminacion_des'=>$new_cant, 'updated_at'=>$updated_refe,]);
                }
            elseif($modulo == 2){
                DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_terminacion_tac'=>$new_cant, 'updated_at'=>$updated_refe,]);
                }
            elseif($modulo == 3){
                DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_terminacion_pla'=>$new_cant, 'updated_at'=>$updated_refe,]);
                }
            elseif($modulo == 4){
                DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_terminacion_mes'=>$new_cant, 'updated_at'=>$updated_refe,]);
                }
            DB::insert('insert into terminacion (fecha,turno,modulo,id_referencia,tallas,tc,tipo,hora,cantidad,tiempo_req_h,meta_produccion,eficiencia,n_operarios,id_parada_prg,id_parada_noprg,tiempo_noprg,created_at) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$fecha,$turno,$modulo,$id_refe,$tallas,$tc,$tipo,$hora,$cantidad,$tiempo_r,$meta_p,$eficiencia,$n_operarios,$tipo_p_prgm,$tipo_pno_prgm,$tiempo_pno_prgm,$created_at]);
            return response()->json(1);
        }

        
    }

    public function edit_terminacion($id)
    {
        $programadas = DB::table('paradas_programadas')->get();
        $no_programadas = DB::table('paradas_no_programadas')->get();
        $terminacion = DB::table('terminacion')->where('id','=',$id)->get();
        $ter = json_decode($terminacion,true);
        
        $referencias = DB::table('referencias')->where('id','=',$ter[0]['id_referencia'])->get('lote_referencia');
        $refe = json_decode($referencias,true);
        
        return view('terminacion.edit_terminacion',compact('programadas','no_programadas','ter','refe'));
    }

    public function update_terminacion(Request $request, $id)
    {
        $id = $request->get('id');
        $fecha = $request->get('fecha');
        $turno = $request->get('turno');
        $modulo = $request->get('modulo');
        $id_refe = $request->get('id_refe');
        $tallas = $request->get('tallas');
        $tc = $request->get('tc');
        $tipo = $request->get('tipo');
        $hora = $request->get('hora');
        $cantidad = $request->get('cantidad');
        $tiempo_r = $request->get('tiempo_r');
        $n_operarios = $request->get('n_operarios');
        $tipo_p_prgm = $request->get('tipo_p_prgm');
        $tipo_pno_prgm = $request->get('tipo_pno_prgm');
        $tiempo_pno_prgm = $request->get('tiempo_pno_prgm');
        $updated_at = Carbon::now();

        $tiempo_p_prg = DB::table('paradas_programadas')->where('id','=',$tipo_p_prgm)->get('tiempo');
        
        if(count($tiempo_p_prg) == 0){
            $tiempo_p_prg = 0;
        }else{
            $t = json_decode($tiempo_p_prg,true);
            $tiempo_p_prg = $t[0]['tiempo'];
        }
        if($tiempo_pno_prgm == ""){
            $tiempo_pno_prgm = 0;
        }

        $td = $n_operarios*$tiempo_r*3600;
        $totaltpp = $tiempo_p_prg*$n_operarios;
        $meta_p = ($td-$totaltpp-$tiempo_pno_prgm)/$tc;
        
        if($meta_p==0){
            $eficiencia=0;
            $cantidad=0;
        }else{
        $eficiencia = ($cantidad/$meta_p)*100;
        }

        $updated_refe = Carbon::now();
        $cant_mod = DB::table('terminacion')->where('id','=',$id)->get();
        $can_mod = json_decode($cant_mod,true);
        $cant_refe = DB::table('referencias')->where('id','=',$id_refe)->get();
        $cant_ref = json_decode($cant_refe,true);
        $cant_refe_new = DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->get();
        $cant_ref_new = json_decode($cant_refe_new,true);
        $new_cant = 0;
        $new_cant_new = 0;
        
        $validar_si_existe = DB::table('terminacion')->where('fecha','=',$fecha)->where('turno','=',$turno)->where('modulo','=',$modulo)->where('hora','=',$hora)->where('id','!=',$id)->get();

        if(count($validar_si_existe)>0){
            $array_validar = json_decode($validar_si_existe,true);
            $sum_time_req = 0;
                for($i=0;$i<count($array_validar);$i++){
                    $sum_time_req+=$array_validar[$i]['tiempo_req_h'];
                }
                
                $sum_time_req+=$tiempo_r;
                if($sum_time_req>1){
                    return response()->json(2);
                }else{
                    if($id_refe==$can_mod[0]['id_referencia']){
                        if($modulo == $can_mod[0]['modulo']){
                            if($modulo == 1){
                                $new_cant = ($cant_ref[0]['cantidad_disponible_terminacion_des']+$can_mod[0]['cantidad'])-$cantidad;
                                DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_terminacion_des'=>$new_cant, 'updated_at'=>$updated_refe,]);
                                }
                            elseif($modulo == 2){
                                $new_cant = ($cant_ref[0]['cantidad_disponible_terminacion_tac']+$can_mod[0]['cantidad'])-$cantidad;
                                DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_terminacion_tac'=>$new_cant, 'updated_at'=>$updated_refe,]);
                                }
                            elseif($modulo == 3){
                                $new_cant = ($cant_ref[0]['cantidad_disponible_terminacion_pla']+$can_mod[0]['cantidad'])-$cantidad;
                                DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_terminacion_pla'=>$new_cant, 'updated_at'=>$updated_refe,]);
                                }
                            elseif($modulo == 4){
                                $new_cant = ($cant_ref[0]['cantidad_disponible_terminacion_mes']+$can_mod[0]['cantidad'])-$cantidad;
                                DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_terminacion_mes'=>$new_cant, 'updated_at'=>$updated_refe,]);
                                }
                        }else{
                            if($modulo == 1){
                                $new_cant = $cant_ref[0]['cantidad_disponible_terminacion_des']-$cantidad;
                                DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_terminacion_des'=>$new_cant, 'updated_at'=>$updated_refe,]);
                                }
                            elseif($modulo == 2){
                                $new_cant = $cant_ref[0]['cantidad_disponible_terminacion_tac']-$cantidad;
                                DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_terminacion_tac'=>$new_cant, 'updated_at'=>$updated_refe,]);
                                }
                            elseif($modulo == 3){
                                $new_cant = $cant_ref[0]['cantidad_disponible_terminacion_pla']-$cantidad;
                                DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_terminacion_pla'=>$new_cant, 'updated_at'=>$updated_refe,]);
                                }
                            elseif($modulo == 4){
                                $new_cant = $cant_ref[0]['cantidad_disponible_terminacion_mes']-$cantidad;
                                DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_terminacion_mes'=>$new_cant, 'updated_at'=>$updated_refe,]);
                                }

                            if($can_mod[0]['modulo'] == 1){
                                $new_cant_new = $can_mod[0]['cantidad']+$cant_ref_new[0]['cantidad_disponible_terminacion_des'];
                                DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->update(['cantidad_disponible_terminacion_des'=>$new_cant_new, 'updated_at'=>$updated_refe,]);
                                }
                            elseif($can_mod[0]['modulo'] == 2){
                                $new_cant_new = $can_mod[0]['cantidad']+$cant_ref_new[0]['cantidad_disponible_terminacion_tac'];
                                DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->update(['cantidad_disponible_terminacion_tac'=>$new_cant_new, 'updated_at'=>$updated_refe,]);
                                }
                            elseif($can_mod[0]['modulo'] == 3){
                                $new_cant_new = $can_mod[0]['cantidad']+$cant_ref_new[0]['cantidad_disponible_terminacion_pla'];
                                DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->update(['cantidad_disponible_terminacion_pla'=>$new_cant_new, 'updated_at'=>$updated_refe,]);
                                }
                            elseif($can_mod[0]['modulo'] == 4){
                                $new_cant_new = $can_mod[0]['cantidad']+$cant_ref_new[0]['cantidad_disponible_terminacion_mes'];
                                DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->update(['cantidad_disponible_terminacion_mes'=>$new_cant_new, 'updated_at'=>$updated_refe,]);
                                }
                        }
                        DB::table('terminacion')->where('id','=',$id)->update(['fecha'=>$fecha, 'turno'=>$turno, 'modulo'=>$modulo, 'id_referencia'=>$id_refe, 'tallas'=>$tallas, 'tc'=>$tc, 'tipo'=>$tipo, 'hora'=>$hora, 'cantidad'=>$cantidad, 'tiempo_req_h'=>$tiempo_r, 'meta_produccion'=>$meta_p, 'eficiencia'=>$eficiencia, 'n_operarios'=>$n_operarios, 'id_parada_prg'=>$tipo_p_prgm, 'id_parada_noprg'=>$tipo_pno_prgm, 'tiempo_noprg'=>$tiempo_pno_prgm, 'updated_at'=>$updated_at, ]);
                        return response()->json(1);
                    }else{
                        if($modulo == 1){
                            $new_cant = $cant_ref[0]['cantidad_disponible_terminacion_des']-$cantidad;
                            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_terminacion_des'=>$new_cant, 'updated_at'=>$updated_refe,]);
                        }
                        elseif($modulo == 2){
                            $new_cant = $cant_ref[0]['cantidad_disponible_terminacion_tac']-$cantidad;
                            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_terminacion_tac'=>$new_cant, 'updated_at'=>$updated_refe,]);
                        }
                        elseif($modulo == 3){
                            $new_cant = $cant_ref[0]['cantidad_disponible_terminacion_pla']-$cantidad;
                            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_terminacion_pla'=>$new_cant, 'updated_at'=>$updated_refe,]);
                        }
                        elseif($modulo == 4){
                            $new_cant = $cant_ref[0]['cantidad_disponible_terminacion_mes']-$cantidad;
                            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_terminacion_mes'=>$new_cant, 'updated_at'=>$updated_refe,]);
                        }
                        
                        if($can_mod[0]['modulo'] == 1){
                            $new_cant_new = $can_mod[0]['cantidad']+$cant_ref_new[0]['cantidad_disponible_terminacion_des'];
                            DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->update(['cantidad_disponible_terminacion_des'=>$new_cant_new, 'updated_at'=>$updated_refe,]);
                        }
                        elseif($can_mod[0]['modulo'] == 2){
                            $new_cant_new = $can_mod[0]['cantidad']+$cant_ref_new[0]['cantidad_disponible_terminacion_tac'];
                            DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->update(['cantidad_disponible_terminacion_tac'=>$new_cant_new, 'updated_at'=>$updated_refe,]);
                        }
                        elseif($can_mod[0]['modulo'] == 3){
                            $new_cant_new = $can_mod[0]['cantidad']+$cant_ref_new[0]['cantidad_disponible_terminacion_pla'];
                            DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->update(['cantidad_disponible_terminacion_pla'=>$new_cant_new, 'updated_at'=>$updated_refe,]);
                        }
                        elseif($can_mod[0]['modulo'] == 4){
                            $new_cant_new = $can_mod[0]['cantidad']+$cant_ref_new[0]['cantidad_disponible_terminacion_mes'];
                            DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->update(['cantidad_disponible_terminacion_mes'=>$new_cant_new, 'updated_at'=>$updated_refe,]);
                        }
                            DB::table('terminacion')->where('id','=',$id)->update(['fecha'=>$fecha, 'turno'=>$turno, 'modulo'=>$modulo, 'id_referencia'=>$id_refe, 'tallas'=>$tallas, 'tc'=>$tc, 'tipo'=>$tipo, 'hora'=>$hora, 'cantidad'=>$cantidad, 'tiempo_req_h'=>$tiempo_r, 'meta_produccion'=>$meta_p, 'eficiencia'=>$eficiencia, 'n_operarios'=>$n_operarios, 'id_parada_prg'=>$tipo_p_prgm, 'id_parada_noprg'=>$tipo_pno_prgm, 'tiempo_noprg'=>$tiempo_pno_prgm, 'updated_at'=>$updated_at, ]);
                        return response()->json(1);
                    }
                }
        }else{
            if($id_refe==$can_mod[0]['id_referencia']){
                if($modulo == $can_mod[0]['modulo']){
                    if($modulo == 1){
                        $new_cant = ($cant_ref[0]['cantidad_disponible_terminacion_des']+$can_mod[0]['cantidad'])-$cantidad;
                        DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_terminacion_des'=>$new_cant, 'updated_at'=>$updated_refe,]);
                        }
                    elseif($modulo == 2){
                        $new_cant = ($cant_ref[0]['cantidad_disponible_terminacion_tac']+$can_mod[0]['cantidad'])-$cantidad;
                        DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_terminacion_tac'=>$new_cant, 'updated_at'=>$updated_refe,]);
                        }
                    elseif($modulo == 3){
                        $new_cant = ($cant_ref[0]['cantidad_disponible_terminacion_pla']+$can_mod[0]['cantidad'])-$cantidad;
                        DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_terminacion_pla'=>$new_cant, 'updated_at'=>$updated_refe,]);
                        }
                    elseif($modulo == 4){
                        $new_cant = ($cant_ref[0]['cantidad_disponible_terminacion_mes']+$can_mod[0]['cantidad'])-$cantidad;
                        DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_terminacion_mes'=>$new_cant, 'updated_at'=>$updated_refe,]);
                        }
                }else{
                    if($modulo == 1){
                        $new_cant = $cant_ref[0]['cantidad_disponible_terminacion_des']-$cantidad;
                        DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_terminacion_des'=>$new_cant, 'updated_at'=>$updated_refe,]);
                        }
                    elseif($modulo == 2){
                        $new_cant = $cant_ref[0]['cantidad_disponible_terminacion_tac']-$cantidad;
                        DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_terminacion_tac'=>$new_cant, 'updated_at'=>$updated_refe,]);
                        }
                    elseif($modulo == 3){
                        $new_cant = $cant_ref[0]['cantidad_disponible_terminacion_pla']-$cantidad;
                        DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_terminacion_pla'=>$new_cant, 'updated_at'=>$updated_refe,]);
                        }
                    elseif($modulo == 4){
                        $new_cant = $cant_ref[0]['cantidad_disponible_terminacion_mes']-$cantidad;
                        DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_terminacion_mes'=>$new_cant, 'updated_at'=>$updated_refe,]);
                        }

                    if($can_mod[0]['modulo'] == 1){
                        $new_cant_new = $can_mod[0]['cantidad']+$cant_ref_new[0]['cantidad_disponible_terminacion_des'];
                        DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->update(['cantidad_disponible_terminacion_des'=>$new_cant_new, 'updated_at'=>$updated_refe,]);
                        }
                    elseif($can_mod[0]['modulo'] == 2){
                        $new_cant_new = $can_mod[0]['cantidad']+$cant_ref_new[0]['cantidad_disponible_terminacion_tac'];
                        DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->update(['cantidad_disponible_terminacion_tac'=>$new_cant_new, 'updated_at'=>$updated_refe,]);
                        }
                    elseif($can_mod[0]['modulo'] == 3){
                        $new_cant_new = $can_mod[0]['cantidad']+$cant_ref_new[0]['cantidad_disponible_terminacion_pla'];
                        DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->update(['cantidad_disponible_terminacion_pla'=>$new_cant_new, 'updated_at'=>$updated_refe,]);
                        }
                    elseif($can_mod[0]['modulo'] == 4){
                        $new_cant_new = $can_mod[0]['cantidad']+$cant_ref_new[0]['cantidad_disponible_terminacion_mes'];
                        DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->update(['cantidad_disponible_terminacion_mes'=>$new_cant_new, 'updated_at'=>$updated_refe,]);
                        }
                }
                DB::table('terminacion')->where('id','=',$id)->update(['fecha'=>$fecha, 'turno'=>$turno, 'modulo'=>$modulo, 'id_referencia'=>$id_refe, 'tallas'=>$tallas, 'tc'=>$tc, 'tipo'=>$tipo, 'hora'=>$hora, 'cantidad'=>$cantidad, 'tiempo_req_h'=>$tiempo_r, 'meta_produccion'=>$meta_p, 'eficiencia'=>$eficiencia, 'n_operarios'=>$n_operarios, 'id_parada_prg'=>$tipo_p_prgm, 'id_parada_noprg'=>$tipo_pno_prgm, 'tiempo_noprg'=>$tiempo_pno_prgm, 'updated_at'=>$updated_at, ]);
                return response()->json(1);
            }else{
                    if($modulo == 1){
                        $new_cant = $cant_ref[0]['cantidad_disponible_terminacion_des']-$cantidad;
                        DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_terminacion_des'=>$new_cant, 'updated_at'=>$updated_refe,]);
                    }
                    elseif($modulo == 2){
                        $new_cant = $cant_ref[0]['cantidad_disponible_terminacion_tac']-$cantidad;
                        DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_terminacion_tac'=>$new_cant, 'updated_at'=>$updated_refe,]);
                    }
                    elseif($modulo == 3){
                        $new_cant = $cant_ref[0]['cantidad_disponible_terminacion_pla']-$cantidad;
                        DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_terminacion_pla'=>$new_cant, 'updated_at'=>$updated_refe,]);
                    }
                    elseif($modulo == 4){
                        $new_cant = $cant_ref[0]['cantidad_disponible_terminacion_mes']-$cantidad;
                        DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_terminacion_mes'=>$new_cant, 'updated_at'=>$updated_refe,]);
                    }
                        
                    if($can_mod[0]['modulo'] == 1){
                        $new_cant_new = $can_mod[0]['cantidad']+$cant_ref_new[0]['cantidad_disponible_terminacion_des'];
                        DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->update(['cantidad_disponible_terminacion_des'=>$new_cant_new, 'updated_at'=>$updated_refe,]);
                    }
                    elseif($can_mod[0]['modulo'] == 2){
                        $new_cant_new = $can_mod[0]['cantidad']+$cant_ref_new[0]['cantidad_disponible_terminacion_tac'];
                        DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->update(['cantidad_disponible_terminacion_tac'=>$new_cant_new, 'updated_at'=>$updated_refe,]);
                    }
                    elseif($can_mod[0]['modulo'] == 3){
                        $new_cant_new = $can_mod[0]['cantidad']+$cant_ref_new[0]['cantidad_disponible_terminacion_pla'];
                        DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->update(['cantidad_disponible_terminacion_pla'=>$new_cant_new, 'updated_at'=>$updated_refe,]);
                    }
                    elseif($can_mod[0]['modulo'] == 4){
                        $new_cant_new = $can_mod[0]['cantidad']+$cant_ref_new[0]['cantidad_disponible_terminacion_mes'];
                        DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->update(['cantidad_disponible_terminacion_mes'=>$new_cant_new, 'updated_at'=>$updated_refe,]);
                    }
                DB::table('terminacion')->where('id','=',$id)->update(['fecha'=>$fecha, 'turno'=>$turno, 'modulo'=>$modulo, 'id_referencia'=>$id_refe, 'tallas'=>$tallas, 'tc'=>$tc, 'tipo'=>$tipo, 'hora'=>$hora, 'cantidad'=>$cantidad, 'tiempo_req_h'=>$tiempo_r, 'meta_produccion'=>$meta_p, 'eficiencia'=>$eficiencia, 'n_operarios'=>$n_operarios, 'id_parada_prg'=>$tipo_p_prgm, 'id_parada_noprg'=>$tipo_pno_prgm, 'tiempo_noprg'=>$tiempo_pno_prgm, 'updated_at'=>$updated_at, ]);
                return response()->json(1);
            }
        }
    }
    
    public function delete_terminacion($id)
    {
        $terminacion = DB::table('terminacion')->where('id','=',$id)->get();
        $refe = DB::table('referencias')->where('id','=',$terminacion[0]->id_referencia)->get();
        if($terminacion[0]->modulo == 1){
            DB::table('referencias')->where('id','=',$terminacion[0]->id_referencia)->update(['cantidad_disponible_terminacion_des'=>$refe[0]->cantidad_disponible_terminacion_des+$terminacion[0]->cantidad]);
        }elseif($terminacion[0]->modulo == 2){
            DB::table('referencias')->where('id','=',$terminacion[0]->id_referencia)->update(['cantidad_disponible_terminacion_tac'=>$refe[0]->cantidad_disponible_terminacion_tac+$terminacion[0]->cantidad]);
        }elseif($terminacion[0]->modulo == 3){
            DB::table('referencias')->where('id','=',$terminacion[0]->id_referencia)->update(['cantidad_disponible_terminacion_pla'=>$refe[0]->cantidad_disponible_terminacion_pla+$terminacion[0]->cantidad]);
        }elseif($terminacion[0]->modulo == 4){
            DB::table('referencias')->where('id','=',$terminacion[0]->id_referencia)->update(['cantidad_disponible_terminacion_mes'=>$refe[0]->cantidad_disponible_terminacion_mes+$terminacion[0]->cantidad]);
        }
        DB::table('terminacion')->where('id','=',$id)->delete();
        return redirect()->route('list_terminacion_hoy');
    }

    public function eficiencia($id)
    {
        $consulta_fecha = DB::table('terminacion')->where('id','=',$id)->get();
        $consulta = json_decode($consulta_fecha,true);
        $eficiencia_hoy = DB::table('terminacion')->where('fecha','=',$consulta[0]['fecha'])->where('turno','=',$consulta[0]['turno'])->get();
        $array = json_decode($eficiencia_hoy,true);
        //dd($array);
        $array_mod1 = [];
        $array_mod2 = [];
        $array_mod3 = [];
        $array_mod4 = [];

        for($i=0;$i<15;$i++){
            array_push($array_mod1, array(  
                "cant" => 0,
                "meta" => 0,
                ));
            array_push($array_mod2, array(  
                "cant" => 0,
                "meta" => 0,
                ));
            array_push($array_mod3, array(  
                "cant" => 0,
                "meta" => 0,
                ));
            array_push($array_mod4, array(  
                "cant" => 0,
                "meta" => 0,
                ));
        }
        
        for($i=0;$i<count($array);$i++){
            for($x=0;$x<15;$x++){
                if($array[$i]['modulo'] == 1){
                    if($array[$i]['hora'] == $x+1){
                        $array_mod1[$x]['cant'] = $array_mod1[$x]['cant'] + $array[$i]['cantidad'];
                        $array_mod1[$x]['meta'] = $array_mod1[$x]['meta'] + $array[$i]['meta_produccion'];
                    }
                }
                if($array[$i]['modulo'] == 2){
                    if($array[$i]['hora'] == $x+1){
                        $array_mod2[$x]['cant'] = $array_mod2[$x]['cant'] + $array[$i]['cantidad'];
                        $array_mod2[$x]['meta'] = $array_mod2[$x]['meta'] + $array[$i]['meta_produccion'];
                    }
                }
                if($array[$i]['modulo'] == 3){
                    if($array[$i]['hora'] == $x+1){
                        $array_mod3[$x]['cant'] = $array_mod3[$x]['cant'] + $array[$i]['cantidad'];
                        $array_mod3[$x]['meta'] = $array_mod3[$x]['meta'] + $array[$i]['meta_produccion'];
                    }
                }
                if($array[$i]['modulo'] == 4){
                    if($array[$i]['hora'] == $x+1){
                        $array_mod4[$x]['cant'] = $array_mod4[$x]['cant'] + $array[$i]['cantidad'];
                        $array_mod4[$x]['meta'] = $array_mod4[$x]['meta'] + $array[$i]['meta_produccion'];
                    }
                }
            }
        }    
        $array_modulos = [$array_mod1, $array_mod2, $array_mod3, $array_mod4];
        //dd($array_modulos[0][0]['cant']);
        return view('terminacion.eficiencia')->with('array_modulos',$array_modulos);
    }

    public function referencia_consulta(Request $request)
    {
        $referencia = $request->get('referencia');
        $validar = DB::table('referencias')->where('lote_referencia','=',$referencia)->get();
        $new = json_decode($validar,true);
        if(count($new)>0){
            return response()->json($new);
        }else{
            return response()->json(2);
        }
    }

    public function lote_referencia(Request $request)
    {   
        $cantidad = $request->get('cantidad');
        $id_refe = $request->get('id_refe');
        $modulo = $request->get('modulo');
        $consulta_refe = DB::table('referencias')->where('id','=',$id_refe)->get();
        $consulta = json_decode($consulta_refe,true);
        $cons = 0;
        $disp = 0;

        if($modulo == 1){
        $disp = $consulta[0]['cantidad_disponible_terminacion_des']-$cantidad;
        $cons = $consulta[0]['cantidad_disponible_terminacion_des'];
        }
        if($modulo == 2){
            $disp = $consulta[0]['cantidad_disponible_terminacion_tac']-$cantidad;
            $cons = $consulta[0]['cantidad_disponible_terminacion_tac'];
        }
        if($modulo == 3){
            $disp = $consulta[0]['cantidad_disponible_terminacion_pla']-$cantidad;
            $cons = $consulta[0]['cantidad_disponible_terminacion_pla'];
        }
        if($modulo == 4){
            $disp = $consulta[0]['cantidad_disponible_terminacion_mes']-$cantidad;
            $cons = $consulta[0]['cantidad_disponible_terminacion_mes'];
        }

        if($disp>=0){
            return response()->json([1,$cantidad,$cons,$disp]);
        }else{
            return response()->json([2,$cantidad,$cons,$disp]);
        }
    }

    public function lote_referencia_new(Request $request)
    {   
        $cantidad = $request->get('cantidad');
        $id_refe = $request->get('id_refe');
        $id = $request->get('id');
        $modulo = $request->get('modulo');
        $cant_mod = DB::table('terminacion')->where('id','=',$id)->get();
        $can_mod = json_decode($cant_mod,true);
        $consulta_refe = DB::table('referencias')->where('id','=',$id_refe)->get();
        $consulta = json_decode($consulta_refe,true);
        $disp = 0;
        $cons = 0;
        

        if($id_refe==$can_mod[0]['id_referencia']){

            if($modulo == $can_mod[0]['modulo']){
                if($modulo == 1){
                    $disp = ($consulta[0]['cantidad_disponible_terminacion_des']+$can_mod[0]['cantidad'])-$cantidad;
                    $cons = $consulta[0]['cantidad_disponible_terminacion_des'];
                    }
                if($modulo == 2){
                    $disp = ($consulta[0]['cantidad_disponible_terminacion_tac']+$can_mod[0]['cantidad'])-$cantidad;
                    $cons = $consulta[0]['cantidad_disponible_terminacion_tac'];
                    }
                if($modulo == 3){
                    $disp = ($consulta[0]['cantidad_disponible_terminacion_pla']+$can_mod[0]['cantidad'])-$cantidad;
                    $cons = $consulta[0]['cantidad_disponible_terminacion_pla'];
                    }
                if($modulo == 4){
                    $disp = ($consulta[0]['cantidad_disponible_terminacion_mes']+$can_mod[0]['cantidad'])-$cantidad;
                    $cons = $consulta[0]['cantidad_disponible_terminacion_mes'];
                    }
            }else{
                if($modulo == 1){
                    $disp = $consulta[0]['cantidad_disponible_terminacion_des']-$cantidad;
                    $cons = $consulta[0]['cantidad_disponible_terminacion_des'];
                }
                if($modulo == 2){
                    $disp = $consulta[0]['cantidad_disponible_terminacion_tac']-$cantidad;
                    $cons = $consulta[0]['cantidad_disponible_terminacion_tac'];
                }
                if($modulo == 3){
                    $disp = $consulta[0]['cantidad_disponible_terminacion_pla']-$cantidad;
                    $cons = $consulta[0]['cantidad_disponible_terminacion_pla'];
                }
                if($modulo == 4){
                    $disp = $consulta[0]['cantidad_disponible_terminacion_mes']-$cantidad;
                    $cons = $consulta[0]['cantidad_disponible_terminacion_mes'];
                }
            }
            
            if($disp>=0){
                return response()->json([1,$cantidad,$cons,$disp]);
            }else{
                return response()->json([2,$cantidad,$cons,$disp]);
            }
        }else{
            if($modulo == 1){
                $disp = $consulta[0]['cantidad_disponible_terminacion_des']-$cantidad;;
                $cons = $consulta[0]['cantidad_disponible_terminacion_des'];
                }
                if($modulo == 2){
                $disp = $consulta[0]['cantidad_disponible_terminacion_tac']-$cantidad;
                $cons = $consulta[0]['cantidad_disponible_terminacion_tac'];
                }
                if($modulo == 3){
                $disp = $consulta[0]['cantidad_disponible_terminacion_pla']-$cantidad;
                $cons = $consulta[0]['cantidad_disponible_terminacion_pla'];
                }
                if($modulo == 4){
                $disp = $consulta[0]['cantidad_disponible_terminacion_mes']-$cantidad;
                $cons = $consulta[0]['cantidad_disponible_terminacion_mes'];
                }
            if($disp>=0){
                return response()->json([1,$cantidad,$cons,$disp]);
            }else{
                return response()->json([2,$cantidad,$cons,$disp]);
            }
        }
    }

}
