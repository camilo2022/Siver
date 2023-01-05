<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\ClientesModelTiendas;
use App\Exports\ConfeccionExport;
use App\Exports\ArchivoPrimarioExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;


class ConfeccionController extends Controller
{
    public function download_excel()
    {
        $confeccion = DB::select('select id,fecha,turno,modulo,(SELECT referencias.lote_referencia from referencias WHERE modulos.id_referencia=referencias.id) AS referencia,tallas,tc, tipo, hora, cantidad,tiempo_req_h,meta_produccion,eficiencia,n_operarios,(SELECT paradas_programadas.tipo_parada_prg from paradas_programadas WHERE modulos.id_parada_prg=paradas_programadas.id) AS parada_programada, (SELECT paradas_programadas.tiempo from paradas_programadas WHERE modulos.id_parada_prg = paradas_programadas.id) AS tiempo_parada_programada, (SELECT paradas_no_programadas.tipo_parada_noprg from paradas_no_programadas WHERE modulos.id_parada_noprg=paradas_no_programadas.id) AS parada_no_programada,tiempo_noprg from modulos');
        return Excel::download(new ConfeccionExport($confeccion),"Confeccion.xlsx");
    }
    
    public function index_modulos()
    {
        $modulos = DB::select('select id,fecha,turno,modulo,(SELECT referencias.lote_referencia from referencias WHERE modulos.id_referencia=referencias.id) AS referencia,tallas,tc, tipo, hora, cantidad,tiempo_req_h,meta_produccion,eficiencia,n_operarios,(SELECT paradas_programadas.tipo_parada_prg from paradas_programadas WHERE modulos.id_parada_prg=paradas_programadas.id) AS parada_programada, (SELECT paradas_programadas.tiempo from paradas_programadas WHERE modulos.id_parada_prg = paradas_programadas.id) AS tiempo_parada_programada, (SELECT paradas_no_programadas.tipo_parada_noprg from paradas_no_programadas WHERE modulos.id_parada_noprg=paradas_no_programadas.id) AS parada_no_programada,tiempo_noprg from modulos where fecha BETWEEN date_add(NOW(), INTERVAL -15 DAY) AND NOW()');
        return view('horas.tabla_modulos')->with('modulos',$modulos);
    }

    public function index_modulos_hoy()
    {
        $fecha = Carbon::now();
        $fecha = $fecha->format('Y-m-d');
        $modulos = DB::select('select id,fecha,turno,modulo,(SELECT referencias.lote_referencia from referencias WHERE modulos.id_referencia=referencias.id) AS referencia,tallas,tc, tipo, hora, cantidad,tiempo_req_h,meta_produccion,eficiencia,n_operarios,(SELECT paradas_programadas.tipo_parada_prg from paradas_programadas WHERE modulos.id_parada_prg=paradas_programadas.id) AS parada_programada, (SELECT paradas_programadas.tiempo from paradas_programadas WHERE modulos.id_parada_prg = paradas_programadas.id) AS tiempo_parada_programada, (SELECT paradas_no_programadas.tipo_parada_noprg from paradas_no_programadas WHERE modulos.id_parada_noprg=paradas_no_programadas.id) AS parada_no_programada,tiempo_noprg from modulos where fecha = "'.$fecha.'"');
        return view('horas.tabla_modulos')->with('modulos',$modulos);
    }

    public function create_modulos()
    {
        $programadas = DB::table('paradas_programadas')->get();
        $no_programadas = DB::table('paradas_no_programadas')->get();
        return view('horas.form_modulos',compact('programadas','no_programadas'));
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

    public function store_modulos(Request $request)
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
        $new_cant = $cant_ref[0]['cantidad_disponible_confeccion']-$cantidad;

        $validar_si_existe = DB::table('modulos')->where('fecha','=',$fecha)->where('turno','=',$turno)->where('modulo','=',$modulo)->where('hora','=',$hora)->get();
        
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
                    DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_confeccion'=>$new_cant, 'updated_at'=>$updated_refe,]);
                    DB::insert('insert into modulos (fecha,turno,modulo,id_referencia,tallas,tc,tipo,hora,cantidad,tiempo_req_h,meta_produccion,eficiencia,n_operarios,id_parada_prg,id_parada_noprg,tiempo_noprg,created_at) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$fecha,$turno,$modulo,$id_refe,$tallas,$tc,$tipo,$hora,$cantidad,$tiempo_r,$meta_p,$eficiencia,$n_operarios,$tipo_p_prgm,$tipo_pno_prgm,$tiempo_pno_prgm,$created_at]);
                    return response()->json(1);
                }
        }else{
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_confeccion'=>$new_cant, 'updated_at'=>$updated_refe,]);
            DB::insert('insert into modulos (fecha,turno,modulo,id_referencia,tallas,tc,tipo,hora,cantidad,tiempo_req_h,meta_produccion,eficiencia,n_operarios,id_parada_prg,id_parada_noprg,tiempo_noprg,created_at) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$fecha,$turno,$modulo,$id_refe,$tallas,$tc,$tipo,$hora,$cantidad,$tiempo_r,$meta_p,$eficiencia,$n_operarios,$tipo_p_prgm,$tipo_pno_prgm,$tiempo_pno_prgm,$created_at]);
            return response()->json(1);
        }

        
    }

    public function edit_modulos($id)
    {
        $programadas = DB::table('paradas_programadas')->get();
        $no_programadas = DB::table('paradas_no_programadas')->get();
        $modulos = DB::table('modulos')->where('id','=',$id)->get();
        $modulo = json_decode($modulos,true);
        
        $referencias = DB::table('referencias')->where('id','=',$modulo[0]['id_referencia'])->get('lote_referencia');
        $refe = json_decode($referencias,true);
        
        return view('horas.edit_modulos',compact('programadas','no_programadas','modulo','refe'));
    }

    public function update_modulos(Request $request, $id)
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
        $cant_mod = DB::table('modulos')->where('id','=',$id)->get();
        $can_mod = json_decode($cant_mod,true);
        $cant_refe = DB::table('referencias')->where('id','=',$id_refe)->get();
        $cant_ref = json_decode($cant_refe,true);
        $cant_refe_new = DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->get();
        $cant_ref_new = json_decode($cant_refe_new,true);
        $new_cant = 0;
        $new_cant_new = 0;
        
        $validar_si_existe = DB::table('modulos')->where('fecha','=',$fecha)->where('turno','=',$turno)->where('modulo','=',$modulo)->where('hora','=',$hora)->where('id','!=',$id)->get();

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
                        $new_cant = ($cant_ref[0]['cantidad_disponible_confeccion']+$can_mod[0]['cantidad'])-$cantidad;
                        DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_confeccion'=>$new_cant, 'updated_at'=>$updated_refe,]);
                        DB::table('modulos')->where('id','=',$id)->update(['fecha'=>$fecha, 'turno'=>$turno, 'modulo'=>$modulo, 'id_referencia'=>$id_refe, 'tallas'=>$tallas, 'tc'=>$tc, 'tipo'=>$tipo, 'hora'=>$hora, 'cantidad'=>$cantidad, 'tiempo_req_h'=>$tiempo_r, 'meta_produccion'=>$meta_p, 'eficiencia'=>$eficiencia, 'n_operarios'=>$n_operarios, 'id_parada_prg'=>$tipo_p_prgm, 'id_parada_noprg'=>$tipo_pno_prgm, 'tiempo_noprg'=>$tiempo_pno_prgm, 'updated_at'=>$updated_at, ]);
                        return response()->json(1);
                    }else{
                        $new_cant = $cant_ref[0]['cantidad_disponible_confeccion']-$cantidad;
                        $new_cant_new = $can_mod[0]['cantidad']+$cant_ref_new[0]['cantidad_disponible_confeccion'];
                        DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_confeccion'=>$new_cant, 'updated_at'=>$updated_refe,]);
                        DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->update(['cantidad_disponible_confeccion'=>$new_cant_new, 'updated_at'=>$updated_refe,]);
                        DB::table('modulos')->where('id','=',$id)->update(['fecha'=>$fecha, 'turno'=>$turno, 'modulo'=>$modulo, 'id_referencia'=>$id_refe, 'tallas'=>$tallas, 'tc'=>$tc, 'tipo'=>$tipo, 'hora'=>$hora, 'cantidad'=>$cantidad, 'tiempo_req_h'=>$tiempo_r, 'meta_produccion'=>$meta_p, 'eficiencia'=>$eficiencia, 'n_operarios'=>$n_operarios, 'id_parada_prg'=>$tipo_p_prgm, 'id_parada_noprg'=>$tipo_pno_prgm, 'tiempo_noprg'=>$tiempo_pno_prgm, 'updated_at'=>$updated_at, ]);
                        return response()->json(1);
                    }
                }
        }else{
            if($id_refe==$can_mod[0]['id_referencia']){
                $new_cant = ($cant_ref[0]['cantidad_disponible_confeccion']+$can_mod[0]['cantidad'])-$cantidad;
                DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_confeccion'=>$new_cant, 'updated_at'=>$updated_refe,]);
                DB::table('modulos')->where('id','=',$id)->update(['fecha'=>$fecha, 'turno'=>$turno, 'modulo'=>$modulo, 'id_referencia'=>$id_refe, 'tallas'=>$tallas, 'tc'=>$tc, 'tipo'=>$tipo, 'hora'=>$hora, 'cantidad'=>$cantidad, 'tiempo_req_h'=>$tiempo_r, 'meta_produccion'=>$meta_p, 'eficiencia'=>$eficiencia, 'n_operarios'=>$n_operarios, 'id_parada_prg'=>$tipo_p_prgm, 'id_parada_noprg'=>$tipo_pno_prgm, 'tiempo_noprg'=>$tiempo_pno_prgm, 'updated_at'=>$updated_at, ]);
                return response()->json(1);
            }else{
                $new_cant = $cant_ref[0]['cantidad_disponible_confeccion']-$cantidad;
                $new_cant_new = $can_mod[0]['cantidad']+$cant_ref_new[0]['cantidad_disponible_confeccion'];
                DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_confeccion'=>$new_cant, 'updated_at'=>$updated_refe,]);
                DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->update(['cantidad_disponible_confeccion'=>$new_cant_new, 'updated_at'=>$updated_refe,]);
                DB::table('modulos')->where('id','=',$id)->update(['fecha'=>$fecha, 'turno'=>$turno, 'modulo'=>$modulo, 'id_referencia'=>$id_refe, 'tallas'=>$tallas, 'tc'=>$tc, 'tipo'=>$tipo, 'hora'=>$hora, 'cantidad'=>$cantidad, 'tiempo_req_h'=>$tiempo_r, 'meta_produccion'=>$meta_p, 'eficiencia'=>$eficiencia, 'n_operarios'=>$n_operarios, 'id_parada_prg'=>$tipo_p_prgm, 'id_parada_noprg'=>$tipo_pno_prgm, 'tiempo_noprg'=>$tiempo_pno_prgm, 'updated_at'=>$updated_at, ]);
                return response()->json(1);
            }
        }
    }
    
    public function delete_modulos($id)
    {
        $modulo = DB::table('modulos')->where('id','=',$id)->get();
        $refe = DB::table('referencias')->where('id','=',$modulo[0]->id_referencia)->get();
        DB::table('referencias')->where('id','=',$modulo[0]->id_referencia)->update(['cantidad_disponible_confeccion'=>$refe[0]->cantidad_disponible_confeccion+$modulo[0]->cantidad]);
        DB::table('modulos')->where('id','=',$id)->delete();
        return redirect()->route('list_modulos_hoy');
    }

    public function eficiencia($id)
    {
        $consulta_fecha = DB::table('modulos')->where('id','=',$id)->get();
        $consulta = json_decode($consulta_fecha,true);
        $eficiencia_hoy = DB::table('modulos')->where('fecha','=',$consulta[0]['fecha'])->where('turno','=',$consulta[0]['turno'])->get();
        $array = json_decode($eficiencia_hoy,true);
        //dd($array);
        $array_mod0 = [];
        $array_mod1 = [];
        $array_mod2 = [];
        $array_mod3 = [];
        $array_mod4 = [];
        $array_mod5 = [];
        $array_mod6 = [];
        $array_mod7 = [];
        $array_mod8 = [];
        $array_mod9 = [];
        $array_mod10 = [];
        $array_mod11 = [];
        for($i=0;$i<12;$i++){
            array_push($array_mod0, array(  
                "cant" => 0,
                "meta" => 0,
                ));
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
            array_push($array_mod5, array(  
                "cant" => 0,
                "meta" => 0,
                ));
            array_push($array_mod6, array(  
                "cant" => 0,
                "meta" => 0,
                ));
            array_push($array_mod7, array(  
                "cant" => 0,
                "meta" => 0,
                ));
            array_push($array_mod8, array(  
                "cant" => 0,
                "meta" => 0,
                ));
            array_push($array_mod9, array(  
                "cant" => 0,
                "meta" => 0,
                ));
            array_push($array_mod10, array(  
                "cant" => 0,
                "meta" => 0,
                ));
            array_push($array_mod11, array(  
                "cant" => 0,
                "meta" => 0,
                ));
        }
        
        for($i=0;$i<count($array);$i++){
            for($x=0;$x<12;$x++){
                if($array[$i]['modulo'] == 0){
                    if($array[$i]['hora'] == $x+1){
                        $array_mod0[$x]['cant'] = $array_mod0[$x]['cant'] + $array[$i]['cantidad'];
                        $array_mod0[$x]['meta'] = $array_mod0[$x]['meta'] + $array[$i]['meta_produccion'];
                    }
                }
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
                if($array[$i]['modulo'] == 5){
                    if($array[$i]['hora'] == $x+1){
                        $array_mod5[$x]['cant'] = $array_mod5[$x]['cant'] + $array[$i]['cantidad'];
                        $array_mod5[$x]['meta'] = $array_mod5[$x]['meta'] + $array[$i]['meta_produccion'];
                    }
                }
                if($array[$i]['modulo'] == 6){
                    if($array[$i]['hora'] == $x+1){
                        $array_mod6[$x]['cant'] = $array_mod6[$x]['cant'] + $array[$i]['cantidad'];
                        $array_mod6[$x]['meta'] = $array_mod6[$x]['meta'] + $array[$i]['meta_produccion'];
                    }
                }
                if($array[$i]['modulo'] == 7){
                    if($array[$i]['hora'] == $x+1){
                        $array_mod7[$x]['cant'] = $array_mod7[$x]['cant'] + $array[$i]['cantidad'];
                        $array_mod7[$x]['meta'] = $array_mod7[$x]['meta'] + $array[$i]['meta_produccion'];
                    }
                }
                if($array[$i]['modulo'] == 8){
                    if($array[$i]['hora'] == $x+1){
                        $array_mod8[$x]['cant'] = $array_mod8[$x]['cant'] + $array[$i]['cantidad'];
                        $array_mod8[$x]['meta'] = $array_mod8[$x]['meta'] + $array[$i]['meta_produccion'];
                    }
                }
                if($array[$i]['modulo'] == 9){
                    if($array[$i]['hora'] == $x+1){
                        $array_mod9[$x]['cant'] = $array_mod9[$x]['cant'] + $array[$i]['cantidad'];
                        $array_mod9[$x]['meta'] = $array_mod9[$x]['meta'] + $array[$i]['meta_produccion'];
                    }
                }
                if($array[$i]['modulo'] == 10){
                    if($array[$i]['hora'] == $x+1){
                        $array_mod10[$x]['cant'] = $array_mod10[$x]['cant'] + $array[$i]['cantidad'];
                        $array_mod10[$x]['meta'] = $array_mod10[$x]['meta'] + $array[$i]['meta_produccion'];
                    }
                }
                if($array[$i]['modulo'] == 11){
                    if($array[$i]['hora'] == $x+1){
                        $array_mod11[$x]['cant'] = $array_mod11[$x]['cant'] + $array[$i]['cantidad'];
                        $array_mod11[$x]['meta'] = $array_mod11[$x]['meta'] + $array[$i]['meta_produccion'];
                    }
                }
            }
        }    
        $array_modulos = [$array_mod0, $array_mod1, $array_mod2, $array_mod3, $array_mod4, $array_mod5, $array_mod6, $array_mod7, $array_mod8, $array_mod9, $array_mod10, $array_mod11];
        //dd($array_modulos[0]);
        return view('horas.eficiencia')->with('array_modulos',$array_modulos);
    }

    public function index_referencias()
    {
        $referencias = DB::table('referencias')->get();
        return view('horas.tabla_referencias')->with('referencias',$referencias);
    }
    
    public function index_referencias_consulta(Request $request)
    {
        $ensamble = DB::select('select id,fecha,turno,modulo,(SELECT referencias.lote_referencia from referencias WHERE ensamble.id_referencia=referencias.id) AS referencia,(SELECT zarethpr_tiendas.clientes.nombres from zarethpr_tiendas.clientes WHERE ensamble.id_empleado=zarethpr_tiendas.clientes.id) AS nombres, (SELECT zarethpr_tiendas.clientes.apellidos from zarethpr_tiendas.clientes WHERE ensamble.id_empleado=zarethpr_tiendas.clientes.id) AS apellidos,tallas,tc,tipo,hora,cantidad,tiempo_req_h,meta_produccion,eficiencia,n_operarios,(SELECT paradas_programadas.tipo_parada_prg from paradas_programadas WHERE ensamble.id_parada_prg=paradas_programadas.id) AS parada_prg,(SELECT paradas_programadas.tiempo from paradas_programadas WHERE ensamble.id_parada_prg=paradas_programadas.id) AS tiempo_parada_prg,(SELECT paradas_no_programadas.tipo_parada_noprg from paradas_no_programadas WHERE ensamble.id_parada_noprg=paradas_no_programadas.id) AS parada_no_prg,tiempo_noprg from ensamble where id_referencia = '.$request->id);
        $preparacion = DB::select('select id,fecha,turno,modulo,(SELECT referencias.lote_referencia from referencias WHERE preparacion.id_referencia=referencias.id) AS referencia,(SELECT zarethpr_tiendas.clientes.nombres from zarethpr_tiendas.clientes WHERE preparacion.id_empleado=zarethpr_tiendas.clientes.id) AS nombres, (SELECT zarethpr_tiendas.clientes.apellidos from zarethpr_tiendas.clientes WHERE preparacion.id_empleado=zarethpr_tiendas.clientes.id) AS apellidos,tallas,tc,tipo,hora,cantidad,tiempo_req_h,meta_produccion,eficiencia,n_operarios,(SELECT paradas_programadas.tipo_parada_prg from paradas_programadas WHERE preparacion.id_parada_prg=paradas_programadas.id) AS parada_prg,(SELECT paradas_programadas.tiempo from paradas_programadas WHERE preparacion.id_parada_prg=paradas_programadas.id) AS tiempo_parada_prg,(SELECT paradas_no_programadas.tipo_parada_noprg from paradas_no_programadas WHERE preparacion.id_parada_noprg=paradas_no_programadas.id) AS parada_no_prg,tiempo_noprg from preparacion where id_referencia = '.$request->id);
        $confeccion = DB::select('select id,fecha,turno,modulo,(SELECT referencias.lote_referencia from referencias WHERE modulos.id_referencia=referencias.id) AS referencia,tallas,tc,tipo,hora,cantidad,tiempo_req_h,meta_produccion,eficiencia,n_operarios,(SELECT paradas_programadas.tipo_parada_prg from paradas_programadas WHERE modulos.id_parada_prg=paradas_programadas.id) AS parada_prg,(SELECT paradas_programadas.tiempo from paradas_programadas WHERE modulos.id_parada_prg=paradas_programadas.id) AS tiempo_parada_prg,(SELECT paradas_no_programadas.tipo_parada_noprg from paradas_no_programadas WHERE modulos.id_parada_noprg=paradas_no_programadas.id) AS parada_no_prg,tiempo_noprg from modulos where id_referencia = '.$request->id);
        $terminacion = DB::select('select id,fecha,turno,modulo,(SELECT referencias.lote_referencia from referencias WHERE terminacion.id_referencia=referencias.id) AS referencia,tallas,tc,tipo,hora,cantidad,tiempo_req_h,meta_produccion,eficiencia,n_operarios,(SELECT paradas_programadas.tipo_parada_prg from paradas_programadas WHERE terminacion.id_parada_prg=paradas_programadas.id) AS parada_prg,(SELECT paradas_programadas.tiempo from paradas_programadas WHERE terminacion.id_parada_prg=paradas_programadas.id) AS tiempo_parada_prg,(SELECT paradas_no_programadas.tipo_parada_noprg from paradas_no_programadas WHERE terminacion.id_parada_noprg=paradas_no_programadas.id) AS parada_no_prg,tiempo_noprg from terminacion where id_referencia = '.$request->id);
        return response()->json([$ensamble,$preparacion,$confeccion,$terminacion]);
    }

    public function create_referencias()
    {
        return view('horas.form_referencia');
    }

    public function store_referencias(Request $request)
    {
        $created_at = Carbon::now();
        $refe = $request->get('refe');
        $lote = $request->get('lote');
        $cant_lote = $request->get('cant_lote');
        $cant_prep_emb_prc = $request->get('cant_lote');
        $cant_prep_emb_rlj = $request->get('cant_lote');
        $cant_prep_pin = $request->get('cant_lote');
        $cant_prep_cot = $request->get('cant_lote');
        $cant_prep_col = $request->get('cant_lote');
        $cant_prep_prc = $request->get('cant_lote');
        $cant_conf = $request->get('cant_lote');
        $cant_ensa_prt = $request->get('cant_lote');
        $cant_ensa_pnt = $request->get('cant_lote');
        $cant_ensa_bot = $request->get('cant_lote');
        $cant_ensa_bot_pln = $request->get('cant_lote');
        $cant_ensa_prs = $request->get('cant_lote');
        $cant_ensa_pas_prs = $request->get('cant_lote');
        $cant_ensa_pas_mol = $request->get('cant_lote');
        $cant_ensa_ojal = $request->get('cant_lote');
        $cant_ensa_rvs = $request->get('cant_lote');
        $cant_ensa_rvs_ext = $request->get('cant_lote');
        $cant_ensa_rvs_prs = $request->get('cant_lote');
        $cant_term_des = $request->get('cant_lote');
        $cant_term_tac = $request->get('cant_lote');
        $cant_term_pla = $request->get('cant_lote');
        $cant_term_mes = $request->get('cant_lote');
        $tc_refe = $request->get('tc_refe');
        $validar_refe = DB::table('referencias')->where('lote_referencia','=',$lote)->get();
        if(count($validar_refe)>0){
            return response()->json(1);
        }else{
        DB::insert('insert into referencias (referencia,lote_referencia,cantidad_lote,cantidad_disponible_preparacion_emb_prc,cantidad_disponible_preparacion_emb_rlj,cantidad_disponible_preparacion_pin,cantidad_disponible_preparacion_cot,cantidad_disponible_preparacion_col,cantidad_disponible_preparacion_prc,cantidad_disponible_confeccion,cantidad_disponible_ensamble_prt,cantidad_disponible_ensamble_pnt,cantidad_disponible_ensamble_bot,cantidad_disponible_ensamble_bot_pln,cantidad_disponible_ensamble_prs,cantidad_disponible_ensamble_pas_prs,cantidad_disponible_ensamble_pas_mol,cantidad_disponible_ensamble_ojal,cantidad_disponible_ensamble_rvs,cantidad_disponible_ensamble_rvs_ext,cantidad_disponible_ensamble_rvs_prs,cantidad_disponible_terminacion_des,cantidad_disponible_terminacion_tac,cantidad_disponible_terminacion_pla,cantidad_disponible_terminacion_mes,tc,created_at) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$refe,$lote,$cant_lote,$cant_prep_emb_prc,$cant_prep_emb_rlj,$cant_prep_pin,$cant_prep_cot,$cant_prep_col,$cant_prep_prc,$cant_conf,$cant_ensa_prt,$cant_ensa_pnt,$cant_ensa_bot,$cant_ensa_bot_pln,$cant_ensa_prs,$cant_ensa_pas_prs,$cant_ensa_pas_mol,$cant_ensa_ojal,$cant_ensa_rvs,$cant_ensa_rvs_ext,$cant_ensa_rvs_prs,$cant_term_des,$cant_term_tac,$cant_term_pla,$cant_term_mes,$tc_refe,$created_at]);
        
        $new = DB::table('referencias')->where('lote_referencia','=',$lote)->get();
        $array = json_decode($new,true);
        return response()->json($array);
        }
    }

    public function edit_referencias($id)
    {
        $referencias = DB::table('referencias')->where('id','=',$id)->get();
        $referencia = json_decode($referencias,true);
        return view('horas.edit_referencia')->with('referencia',$referencia);
    }

    public function update_referencias(Request $request, $id)
    {
        $updated_at = Carbon::now();
        $id = $request->get('id');
        $refe = $request->get('refe');
        $lote = $request->get('lote');
        $cant_lote = $request->get('cant_lote');
        
        $cant_prep_emb_prc = $request->get('cant_prep_emb_prc');
        $cant_prep_emb_rlj = $request->get('cant_prep_emb_rlj');
        $cant_prep_pin = $request->get('cant_prep_pin');
        $cant_prep_cot = $request->get('cant_prep_cot');
        $cant_prep_col = $request->get('cant_prep_col');
        $cant_prep_prc = $request->get('cant_prep_prc');
        
        $cant_conf = $request->get('cant_conf');
        
        $cant_ensa_prt = $request->get('cant_ensa_prt');
        $cant_ensa_pnt = $request->get('cant_ensa_pnt');
        $cant_ensa_bot = $request->get('cant_ensa_bot');
        $cant_ensa_bot_pln = $request->get('cant_ensa_bot_pln');
        $cant_ensa_prs = $request->get('cant_ensa_prs');
        $cant_ensa_pas_prs = $request->get('cant_ensa_pas_prs');
        $cant_ensa_pas_mol = $request->get('cant_ensa_pas_mol');
        $cant_ensa_ojal = $request->get('cant_ensa_ojal');
        $cant_ensa_rvs = $request->get('cant_ensa_rvs');
        $cant_ensa_rvs_ext = $request->get('cant_ensa_rvs_ext');
        $cant_ensa_rvs_prs = $request->get('cant_ensa_rvs_prs');
        
        $cant_term_des = $request->get('cant_term_des');
        $cant_term_tac = $request->get('cant_term_tac');
        $cant_term_pla = $request->get('cant_term_pla');
        $cant_term_mes = $request->get('cant_term_mes');
        $tc_refe = $request->get('tc_refe');
        $validar_refe = DB::table('referencias')->where('lote_referencia','=',$lote)->where('id','!=',$id)->get();
        if(count($validar_refe)>0){
            return response()->json(2);
        }else{
        DB::table('referencias')->where('id','=',$id)->update(['referencia'=>$refe,'lote_referencia'=>$lote,'cantidad_lote'=>$cant_lote,'cantidad_disponible_preparacion_emb_prc' => $cant_prep_emb_prc ,'cantidad_disponible_preparacion_emb_rlj' => $cant_prep_emb_rlj ,'cantidad_disponible_preparacion_pin' => $cant_prep_pin ,'cantidad_disponible_preparacion_cot' => $cant_prep_cot ,'cantidad_disponible_preparacion_col' => $cant_prep_col ,'cantidad_disponible_preparacion_prc' => $cant_prep_prc,'cantidad_disponible_confeccion'=>$cant_conf,'cantidad_disponible_ensamble_prt' => $cant_ensa_prt ,'cantidad_disponible_ensamble_pnt' => $cant_ensa_pnt ,'cantidad_disponible_ensamble_bot' => $cant_ensa_bot ,'cantidad_disponible_ensamble_bot_pln' => $cant_ensa_bot_pln ,'cantidad_disponible_ensamble_prs' => $cant_ensa_prs ,'cantidad_disponible_ensamble_pas_prs' => $cant_ensa_pas_prs,'cantidad_disponible_ensamble_pas_mol' => $cant_ensa_pas_mol,'cantidad_disponible_ensamble_ojal' => $cant_ensa_ojal,'cantidad_disponible_ensamble_rvs' => $cant_ensa_rvs,'cantidad_disponible_ensamble_rvs_ext' => $cant_ensa_rvs_ext,'cantidad_disponible_ensamble_rvs_prs' => $cant_ensa_rvs_prs,'cantidad_disponible_terminacion_des'=>$cant_term_des,'cantidad_disponible_terminacion_tac'=>$cant_term_tac,'cantidad_disponible_terminacion_pla'=>$cant_term_pla,'cantidad_disponible_terminacion_mes'=>$cant_term_mes,'tc'=>$tc_refe,'updated_at'=>$updated_at]);    
        return response()->json(1);
        }
    }

    public function validar_referencias(Request $request)
    {
        $referencia = $request->get('referencia');
        $validar = DB::table('referencias')->where('lote_referencia','=',$referencia)->get();
        $new = json_decode($validar,true);
        if(count($new)>0){
            return response()->json($new);
        }else{
            return response()->json(1);
        }
    }

    public function consultar_lote(Request $request)
    {
        $cantidad = $request->get('cantidad');
        $id_refe = $request->get('id_refe');
        $consulta_refe = DB::table('referencias')->where('id','=',$id_refe)->get();
        $consulta = json_decode($consulta_refe,true);
        $disp = $consulta[0]['cantidad_disponible_confeccion']-$cantidad;
        if($disp>=0){
            return response()->json([1,$consulta[0]['cantidad_disponible_confeccion'],$disp]);
        }else{
            return response()->json([2,$consulta[0]['cantidad_disponible_confeccion'],$disp]);
        }
    }

    public function consultar_lote_new(Request $request){
        $cantidad = $request->get('cantidad');
        $id_refe = $request->get('id_refe');
        $id = $request->get('id');
        $cant_mod = DB::table('modulos')->where('id','=',$id)->get();
        $can_mod = json_decode($cant_mod,true);
        $consulta_refe = DB::table('referencias')->where('id','=',$id_refe)->get();
        $consulta = json_decode($consulta_refe,true);
        $disp = 0;
        if($id_refe==$can_mod[0]['id_referencia']){
            $disp = ($consulta[0]['cantidad_disponible_confeccion']+$can_mod[0]['cantidad'])-$cantidad;
            if($disp>=0){
                return response()->json([1,$consulta[0]['cantidad_disponible_confeccion'],$disp]);
            }else{
                return response()->json([2,$consulta[0]['cantidad_disponible_confeccion'],$disp]);
            }
        }else{
            $disp = $consulta[0]['cantidad_disponible_confeccion']-$cantidad;
            if($disp>=0){
                return response()->json([1,$consulta[0]['cantidad_disponible_confeccion'],$disp]);
            }else{
                return response()->json([2,$consulta[0]['cantidad_disponible_confeccion'],$disp]);
            }
        }
    }
}
