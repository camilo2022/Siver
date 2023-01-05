<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\ClientesModelTiendas;
use App\Exports\PreparacionExport;
use App\Exports\ArchivoPrimarioExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;


class PreparacionController extends Controller
{
    public function reporte_preparacion_operario()
    {
        $consultas = DB::select('select id_empleado,(SELECT zarethpr_tiendas.clientes.nombres from zarethpr_tiendas.clientes WHERE preparacion.id_empleado=zarethpr_tiendas.clientes.id) AS nombres,(SELECT zarethpr_tiendas.clientes.apellidos from zarethpr_tiendas.clientes WHERE preparacion.id_empleado=zarethpr_tiendas.clientes.id) AS apellidos,fecha,turno, SUM(cantidad) as cantidad, SUM(meta_produccion) as meta_produccion, (SUM(cantidad)/ SUM(meta_produccion))*100 as eficiencia FROM preparacion where fecha BETWEEN date_add(NOW(), INTERVAL -31 DAY) AND NOW() GROUP BY id_empleado,fecha,turno HAVING COUNT(*)>0 ORDER BY fecha ASC');
        return view('preparacion.reporte_operario_preparacion')->with('consultas',$consultas);
    }
    
    public function reporte_operario_consulta(Request $request)
    {
        $fecha = $request->get('fecha');
        $turno = $request->get('turno');
        $id_empleado = $request->get('id_empleado');
        $reporte_ope = DB::select('select id,fecha,turno,modulo,(SELECT zarethpr_tiendas.clientes.nombres from zarethpr_tiendas.clientes WHERE preparacion.id_empleado=zarethpr_tiendas.clientes.id) AS nombres, (SELECT zarethpr_tiendas.clientes.apellidos from zarethpr_tiendas.clientes WHERE preparacion.id_empleado=zarethpr_tiendas.clientes.id) AS apellidos,(SELECT referencias.lote_referencia from referencias WHERE preparacion.id_referencia=referencias.id) AS referencia,tallas,tc, tipo, hora, cantidad,tiempo_req_h,meta_produccion,eficiencia,n_operarios,(SELECT paradas_programadas.tipo_parada_prg from paradas_programadas WHERE preparacion.id_parada_prg=paradas_programadas.id) AS parada_programada, (SELECT paradas_programadas.tiempo from paradas_programadas WHERE preparacion.id_parada_prg = paradas_programadas.id) AS tiempo_parada_programada, (SELECT paradas_no_programadas.tipo_parada_noprg from paradas_no_programadas WHERE preparacion.id_parada_noprg=paradas_no_programadas.id) AS parada_no_programada,tiempo_noprg from preparacion where fecha = "'.$fecha.'" and turno ='.$turno.' and id_empleado = '.$id_empleado);
        return response()->json($reporte_ope);
    }

    public function reporte_preparacion_modulo()
    {
        $consultas = DB::select('select modulo,fecha,turno, SUM(cantidad) as cantidad, SUM(meta_produccion) as meta_produccion, (SUM(cantidad)/ SUM(meta_produccion))*100 as eficiencia FROM preparacion where fecha BETWEEN date_add(NOW(), INTERVAL -31 DAY) AND NOW() GROUP BY modulo,fecha,turno HAVING COUNT(*)>0 ORDER BY fecha ASC');
        return view('preparacion.reporte_modulo_preparacion')->with('consultas',$consultas);
    }
    
    public function reporte_modulo_consulta(Request $request)
    {
        $fecha = $request->get('fecha');
        $turno = $request->get('turno');
        $modulo = $request->get('modulo');
        $reporte_mod = DB::select('select id,fecha,turno,modulo,(SELECT zarethpr_tiendas.clientes.nombres from zarethpr_tiendas.clientes WHERE preparacion.id_empleado=zarethpr_tiendas.clientes.id) AS nombres, (SELECT zarethpr_tiendas.clientes.apellidos from zarethpr_tiendas.clientes WHERE preparacion.id_empleado=zarethpr_tiendas.clientes.id) AS apellidos,(SELECT referencias.lote_referencia from referencias WHERE preparacion.id_referencia=referencias.id) AS referencia,tallas,tc, tipo, hora, cantidad,tiempo_req_h,meta_produccion,eficiencia,n_operarios,(SELECT paradas_programadas.tipo_parada_prg from paradas_programadas WHERE preparacion.id_parada_prg=paradas_programadas.id) AS parada_programada, (SELECT paradas_programadas.tiempo from paradas_programadas WHERE preparacion.id_parada_prg = paradas_programadas.id) AS tiempo_parada_programada, (SELECT paradas_no_programadas.tipo_parada_noprg from paradas_no_programadas WHERE preparacion.id_parada_noprg=paradas_no_programadas.id) AS parada_no_programada,tiempo_noprg from preparacion where fecha = "'.$fecha.'" and turno ='.$turno.' and modulo = "'.$modulo.'"');
        return response()->json($reporte_mod);
    }
    
    public function download_excel()
    {
        $preparacion = DB::select('select id,fecha,turno,modulo,(SELECT zarethpr_tiendas.clientes.nombres from zarethpr_tiendas.clientes WHERE preparacion.id_empleado=zarethpr_tiendas.clientes.id) AS nombres, (SELECT zarethpr_tiendas.clientes.apellidos from zarethpr_tiendas.clientes WHERE preparacion.id_empleado=zarethpr_tiendas.clientes.id) AS apellidos,(SELECT zarethpr_tiendas.clientes.documento from zarethpr_tiendas.clientes WHERE preparacion.id_empleado=zarethpr_tiendas.clientes.id) AS documento,(SELECT referencias.lote_referencia from referencias WHERE preparacion.id_referencia=referencias.id) AS referencia,tallas,tc, tipo, hora, cantidad,tiempo_req_h,meta_produccion,eficiencia,n_operarios,(SELECT paradas_programadas.tipo_parada_prg from paradas_programadas WHERE preparacion.id_parada_prg=paradas_programadas.id) AS parada_programada, (SELECT paradas_programadas.tiempo from paradas_programadas WHERE preparacion.id_parada_prg = paradas_programadas.id) AS tiempo_parada_programada, (SELECT paradas_no_programadas.tipo_parada_noprg from paradas_no_programadas WHERE preparacion.id_parada_noprg=paradas_no_programadas.id) AS parada_no_programada,tiempo_noprg from preparacion');
        return Excel::download(new PreparacionExport($preparacion),"Preparacion.xlsx");
    }

    public function index_preparacion()
    {
        $preparacion = DB::select('select id,fecha,turno,modulo,(SELECT zarethpr_tiendas.clientes.nombres from zarethpr_tiendas.clientes WHERE preparacion.id_empleado=zarethpr_tiendas.clientes.id) AS nombres, (SELECT zarethpr_tiendas.clientes.apellidos from zarethpr_tiendas.clientes WHERE preparacion.id_empleado=zarethpr_tiendas.clientes.id) AS apellidos,(SELECT referencias.lote_referencia from referencias WHERE preparacion.id_referencia=referencias.id) AS referencia,tallas,tc, tipo, hora, cantidad,tiempo_req_h,meta_produccion,eficiencia,n_operarios,(SELECT paradas_programadas.tipo_parada_prg from paradas_programadas WHERE preparacion.id_parada_prg=paradas_programadas.id) AS parada_programada, (SELECT paradas_programadas.tiempo from paradas_programadas WHERE preparacion.id_parada_prg = paradas_programadas.id) AS tiempo_parada_programada, (SELECT paradas_no_programadas.tipo_parada_noprg from paradas_no_programadas WHERE preparacion.id_parada_noprg=paradas_no_programadas.id) AS parada_no_programada,tiempo_noprg from preparacion where fecha BETWEEN date_add(NOW(), INTERVAL -15 DAY) AND NOW()');
        return view('preparacion.tabla_preparacion')->with('preparacion',$preparacion);
    }

    public function index_preparacion_hoy()
    {
        $fecha = Carbon::now();
        $fecha = $fecha->format('Y-m-d');
        $preparacion = DB::select('select id,fecha,turno,modulo,(SELECT zarethpr_tiendas.clientes.nombres from zarethpr_tiendas.clientes WHERE preparacion.id_empleado=zarethpr_tiendas.clientes.id) AS nombres, (SELECT zarethpr_tiendas.clientes.apellidos from zarethpr_tiendas.clientes WHERE preparacion.id_empleado=zarethpr_tiendas.clientes.id) AS apellidos,(SELECT referencias.lote_referencia from referencias WHERE preparacion.id_referencia=referencias.id) AS referencia,tallas,tc, tipo, hora, cantidad,tiempo_req_h,meta_produccion,eficiencia,n_operarios,(SELECT paradas_programadas.tipo_parada_prg from paradas_programadas WHERE preparacion.id_parada_prg=paradas_programadas.id) AS parada_programada, (SELECT paradas_programadas.tiempo from paradas_programadas WHERE preparacion.id_parada_prg = paradas_programadas.id) AS tiempo_parada_programada, (SELECT paradas_no_programadas.tipo_parada_noprg from paradas_no_programadas WHERE preparacion.id_parada_noprg=paradas_no_programadas.id) AS parada_no_programada,tiempo_noprg from preparacion where fecha = "'.$fecha.'"');
        return view('preparacion.tabla_preparacion')->with('preparacion',$preparacion);
    }

    public function create_preparacion_masivo()
    {
        $referencias = DB::select('select * from referencias order by lote_referencia asc');
        $programadas = DB::table('paradas_programadas')->get();
        $no_programadas = DB::table('paradas_no_programadas')->get();
        $fecha = Carbon::now();
        $fecha = $fecha->format('Y-m-d');
        $empleados = ClientesModelTiendas::where('estado_empresa','=',1)->orderBy('nombres', 'ASC')->get();
        return view('preparacion.form_preparacion_masivo',compact('programadas','no_programadas','referencias','fecha','empleados'));
    }

    public function store_preparacion_masivo(Request $request)
    {
        $created_at = Carbon::now();
        $turno = $request->get('turno');
        $modulo = $request->get('modulo');
        $hora = $request->get('hora');
        $empleado = $request->get('empleado');
        $tc = $request->get('tc');
        $tipo = $request->get('tipo');
        $n_operarios = $request->get('n_operarios');
        $tiempo_r = 1;
        $td = $n_operarios*$tiempo_r*3600;
        $meta_p = $td/$tc;
        $id_refe = $request->get('referencia');
        $fecha = $request->get('fecha');

        $validar_turno = false;
        $validar_modulo = false;
        $validar_operario = false;
        $consulta = DB::table('preparacion')->where('fecha','=',$fecha)->get();
        
        for ($i=0;$i<count($consulta);$i++) { 
            if($consulta[$i]->turno == $turno){
                $validar_turno[0]=true;
            }
            if($consulta[$i]->modulo == $modulo){
                $validar_modulo[0]=true;
            }
            if($consulta[$i]->id_empleado == $empleado){
                $validar_operario[0]=true;
            }
        }
        if($validar_turno==true && $validar_modulo==true && $validar_operario==true){
        return redirect()->back()->withErrors(['msg' => 'Ya se hizo una carga masiva al empleado seleccionado en el modulo '.$modulo.' en el turno '.$turno.' en la fecha '.$fecha.'.']);
        }else{
            for ($i=0; $i<count($hora); $i++) { 
                DB::insert('insert into preparacion (fecha,turno,modulo,id_empleado,id_referencia,tc,tipo,hora,cantidad,tiempo_req_h,meta_produccion,eficiencia,n_operarios,created_at) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$fecha,$turno,$modulo,$empleado,$id_refe,$tc,$tipo,$hora[$i],0,$tiempo_r,$meta_p,0,$n_operarios,$created_at]);
            }
            return redirect()->route('list_preparacion_hoy');
        }
        
    }

    public function create_preparacion()
    {
        $referencias = DB::select('select * from referencias order by lote_referencia asc');
        $programadas = DB::table('paradas_programadas')->get();
        $no_programadas = DB::table('paradas_no_programadas')->get();
        $empleados = ClientesModelTiendas::where('estado_empresa','=',1)->orderBy('nombres', 'ASC')->get();
        return view('preparacion.form_preparacion',compact('programadas','no_programadas','referencias','empleados'));
    }

    public function store_preparacion(Request $request)
    {
        $fecha = $request->get('fecha');
        $turno = $request->get('turno');
        $modulo = $request->get('modulo');
        $id_empl = $request->get('id_empl');
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

        if($modulo == "Embonar Parche"){
            $new_cant = $cant_ref[0]['cantidad_disponible_preparacion_emb_prc']-$cantidad;
        }elseif($modulo == "Embonar Relojera"){
            $new_cant = $cant_ref[0]['cantidad_disponible_preparacion_emb_rlj']-$cantidad;
        }elseif($modulo == "Pinzas"){
            $new_cant = $cant_ref[0]['cantidad_disponible_preparacion_pin']-$cantidad;
        }elseif($modulo == "Cotilla"){
            $new_cant = $cant_ref[0]['cantidad_disponible_preparacion_cot']-$cantidad;
        }elseif($modulo == "Cola"){
            $new_cant = $cant_ref[0]['cantidad_disponible_preparacion_col']-$cantidad;
        }elseif($modulo == "Parchado"){
            $new_cant = $cant_ref[0]['cantidad_disponible_preparacion_prc']-$cantidad;
        }
        

        $validar_si_existe = DB::table('preparacion')->where('fecha','=',$fecha)->where('turno','=',$turno)->where('modulo','=',$modulo)->where('hora','=',$hora)->where('id_empleado','=',$id_empl)->get();
        
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
                    $this->actualizarLoteDisponible($modulo,$id_refe,$new_cant,$updated_refe);
                    DB::insert('insert into preparacion (fecha,turno,modulo,id_empleado,id_referencia,tallas,tc,tipo,hora,cantidad,tiempo_req_h,meta_produccion,eficiencia,n_operarios,id_parada_prg,id_parada_noprg,tiempo_noprg,created_at) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$fecha,$turno,$modulo,$id_empl,$id_refe,$tallas,$tc,$tipo,$hora,$cantidad,$tiempo_r,$meta_p,$eficiencia,$n_operarios,$tipo_p_prgm,$tipo_pno_prgm,$tiempo_pno_prgm,$created_at]);
                    return response()->json(1);
                }
        }else{
            $this->actualizarLoteDisponible($modulo,$id_refe,$new_cant,$updated_refe);
            DB::insert('insert into preparacion (fecha,turno,modulo,id_empleado,id_referencia,tallas,tc,tipo,hora,cantidad,tiempo_req_h,meta_produccion,eficiencia,n_operarios,id_parada_prg,id_parada_noprg,tiempo_noprg,created_at) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$fecha,$turno,$modulo,$id_empl,$id_refe,$tallas,$tc,$tipo,$hora,$cantidad,$tiempo_r,$meta_p,$eficiencia,$n_operarios,$tipo_p_prgm,$tipo_pno_prgm,$tiempo_pno_prgm,$created_at]);
            return response()->json(1);
        }   
    }

    private function actualizarLoteDisponible($modulo,$id_refe,$new_cant,$updated_refe)
    {
        if($modulo == "Embonar Parche"){
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_preparacion_emb_prc'=>$new_cant, 'updated_at'=>$updated_refe,]);
            }
        elseif($modulo == "Embonar Relojera"){
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_preparacion_emb_rlj'=>$new_cant, 'updated_at'=>$updated_refe,]);
            }
        elseif($modulo == "Pinzas"){
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_preparacion_pin'=>$new_cant, 'updated_at'=>$updated_refe,]);
            }
        elseif($modulo == "Cotilla"){
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_preparacion_cot'=>$new_cant, 'updated_at'=>$updated_refe,]);
            }
        elseif($modulo == "Cola"){
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_preparacion_col'=>$new_cant, 'updated_at'=>$updated_refe,]);
            }   
        elseif($modulo == "Parchado"){
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_preparacion_prc'=>$new_cant, 'updated_at'=>$updated_refe,]);
            }
    }

    public function edit_preparacion($id)
    {
        $programadas = DB::table('paradas_programadas')->get();
        $no_programadas = DB::table('paradas_no_programadas')->get();
        $preparacion = DB::table('preparacion')->where('id','=',$id)->get();
        $pre = json_decode($preparacion,true);
        $empleados = ClientesModelTiendas::where('estado_empresa','=',1)->orderBy('nombres', 'ASC')->get();
        $referencias = DB::table('referencias')->get();
        
        return view('preparacion.edit_preparacion',compact('programadas','no_programadas','pre','referencias','empleados'));
    }

    public function update_preparacion(Request $request, $id)
    {
        $id = $request->get('id');
        $fecha = $request->get('fecha');
        $turno = $request->get('turno');
        $modulo = $request->get('modulo');
        $id_empl = $request->get('id_empl');
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
        $cant_mod = DB::table('preparacion')->where('id','=',$id)->get();
        $can_mod = json_decode($cant_mod,true);
        $cant_refe = DB::table('referencias')->where('id','=',$id_refe)->get();
        $cant_ref = json_decode($cant_refe,true);
        $cant_refe_new = DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->get();
        $cant_ref_new = json_decode($cant_refe_new,true);
        $new_cant = 0;
        $new_cant_new = 0;
        
        $validar_si_existe = DB::table('preparacion')->where('fecha','=',$fecha)->where('turno','=',$turno)->where('modulo','=',$modulo)->where('hora','=',$hora)->where('id_empleado','=',$id_empl)->where('id','!=',$id)->get();

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
                            $this->validarActualizacionCantidadDisponibleReferenciaOld($modulo,$id_refe,$cant_ref,$cantidad,$can_mod,$updated_refe);
                        }else{
                            $this->validarActualizacionCantidadDisponibleReferencia($modulo,$id_refe,$cant_ref,$cantidad,$updated_refe);
                            $this->validarActualizacionCantidadDisponibleReferenciaNew($modulo,$can_mod,$cant_ref_new,$updated_refe);
                        }
                        DB::table('preparacion')->where('id','=',$id)->update(['fecha'=>$fecha, 'turno'=>$turno, 'modulo'=>$modulo, 'id_empleado'=>$id_empl, 'id_referencia'=>$id_refe, 'tallas'=>$tallas, 'tc'=>$tc, 'tipo'=>$tipo, 'hora'=>$hora, 'cantidad'=>$cantidad, 'tiempo_req_h'=>$tiempo_r, 'meta_produccion'=>$meta_p, 'eficiencia'=>$eficiencia, 'n_operarios'=>$n_operarios, 'id_parada_prg'=>$tipo_p_prgm, 'id_parada_noprg'=>$tipo_pno_prgm, 'tiempo_noprg'=>$tiempo_pno_prgm, 'updated_at'=>$updated_at, ]);
                        return response()->json(1);
                    }else{
                        $this->validarActualizacionCantidadDisponibleReferencia($modulo,$id_refe,$cant_ref,$cantidad,$updated_refe);
                        $this->validarActualizacionCantidadDisponibleReferenciaNew($modulo,$can_mod,$cant_ref_new,$updated_refe);
                        DB::table('preparacion')->where('id','=',$id)->update(['fecha'=>$fecha, 'turno'=>$turno, 'modulo'=>$modulo, 'id_empleado'=>$id_empl, 'id_referencia'=>$id_refe, 'tallas'=>$tallas, 'tc'=>$tc, 'tipo'=>$tipo, 'hora'=>$hora, 'cantidad'=>$cantidad, 'tiempo_req_h'=>$tiempo_r, 'meta_produccion'=>$meta_p, 'eficiencia'=>$eficiencia, 'n_operarios'=>$n_operarios, 'id_parada_prg'=>$tipo_p_prgm, 'id_parada_noprg'=>$tipo_pno_prgm, 'tiempo_noprg'=>$tiempo_pno_prgm, 'updated_at'=>$updated_at, ]);
                        return response()->json(1);
                    }
                }
        }else{
            if($id_refe==$can_mod[0]['id_referencia']){
                if($modulo == $can_mod[0]['modulo']){
                    $this->validarActualizacionCantidadDisponibleReferenciaOld($modulo,$id_refe,$cant_ref,$cantidad,$can_mod,$updated_refe);
                }else{
                    $this->validarActualizacionCantidadDisponibleReferencia($modulo,$id_refe,$cant_ref,$cantidad,$updated_refe);
                    $this->validarActualizacionCantidadDisponibleReferenciaNew($modulo,$can_mod,$cant_ref_new,$updated_refe);
                }
                DB::table('preparacion')->where('id','=',$id)->update(['fecha'=>$fecha, 'turno'=>$turno, 'modulo'=>$modulo, 'id_empleado'=>$id_empl, 'id_referencia'=>$id_refe, 'tallas'=>$tallas, 'tc'=>$tc, 'tipo'=>$tipo, 'hora'=>$hora, 'cantidad'=>$cantidad, 'tiempo_req_h'=>$tiempo_r, 'meta_produccion'=>$meta_p, 'eficiencia'=>$eficiencia, 'n_operarios'=>$n_operarios, 'id_parada_prg'=>$tipo_p_prgm, 'id_parada_noprg'=>$tipo_pno_prgm, 'tiempo_noprg'=>$tiempo_pno_prgm, 'updated_at'=>$updated_at, ]);
                return response()->json(1);
            }else{
                $this->validarActualizacionCantidadDisponibleReferencia($modulo,$id_refe,$cant_ref,$cantidad,$updated_refe);
                $this->validarActualizacionCantidadDisponibleReferenciaNew($modulo,$can_mod,$cant_ref_new,$updated_refe);
                DB::table('preparacion')->where('id','=',$id)->update(['fecha'=>$fecha, 'turno'=>$turno, 'modulo'=>$modulo, 'id_empleado'=>$id_empl, 'id_referencia'=>$id_refe, 'tallas'=>$tallas, 'tc'=>$tc, 'tipo'=>$tipo, 'hora'=>$hora, 'cantidad'=>$cantidad, 'tiempo_req_h'=>$tiempo_r, 'meta_produccion'=>$meta_p, 'eficiencia'=>$eficiencia, 'n_operarios'=>$n_operarios, 'id_parada_prg'=>$tipo_p_prgm, 'id_parada_noprg'=>$tipo_pno_prgm, 'tiempo_noprg'=>$tiempo_pno_prgm, 'updated_at'=>$updated_at, ]);
                return response()->json(1);
            }
        }
    }

    private function validarActualizacionCantidadDisponibleReferenciaNew($modulo,$can_mod,$cant_ref_new,$updated_refe)
    {
        if($can_mod[0]['modulo'] == "Embonar Parche"){
            $new_cant_new = $can_mod[0]['cantidad']+$cant_ref_new[0]['cantidad_disponible_preparacion_emb_prc'];
            DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->update(['cantidad_disponible_preparacion_emb_prc'=>$new_cant_new, 'updated_at'=>$updated_refe,]);
            }
        elseif($can_mod[0]['modulo'] == "Embonar Relojera"){
            $new_cant_new = $can_mod[0]['cantidad']+$cant_ref_new[0]['cantidad_disponible_preparacion_emb_rlj'];
            DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->update(['cantidad_disponible_preparacion_emb_rlj'=>$new_cant_new, 'updated_at'=>$updated_refe,]);
            }
        elseif($can_mod[0]['modulo'] == "Pinzas"){
            $new_cant_new = $can_mod[0]['cantidad']+$cant_ref_new[0]['cantidad_disponible_preparacion_pin'];
            DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->update(['cantidad_disponible_preparacion_pin'=>$new_cant_new, 'updated_at'=>$updated_refe,]);
            }
        elseif($can_mod[0]['modulo'] == "Cotilla"){
            $new_cant_new = $can_mod[0]['cantidad']+$cant_ref_new[0]['cantidad_disponible_preparacion_cot'];
            DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->update(['cantidad_disponible_preparacion_cot'=>$new_cant_new, 'updated_at'=>$updated_refe,]);
            }
        elseif($can_mod[0]['modulo'] == "Cola"){
            $new_cant_new = $can_mod[0]['cantidad']+$cant_ref_new[0]['cantidad_disponible_preparacion_col'];
            DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->update(['cantidad_disponible_preparacion_col'=>$new_cant_new, 'updated_at'=>$updated_refe,]);
            }
        elseif($can_mod[0]['modulo'] == "Parchado"){
            $new_cant_new = $can_mod[0]['cantidad']+$cant_ref_new[0]['cantidad_disponible_preparacion_prc'];
            DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->update(['cantidad_disponible_preparacion_prc'=>$new_cant_new, 'updated_at'=>$updated_refe,]);
            }
    }

    private function validarActualizacionCantidadDisponibleReferenciaOld($modulo,$id_refe,$cant_ref,$cantidad,$can_mod,$updated_refe)
    {
        if($modulo == "Embonar Parche"){
            $new_cant = ($cant_ref[0]['cantidad_disponible_preparacion_emb_prc']+$can_mod[0]['cantidad'])-$cantidad;
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_preparacion_emb_prc'=>$new_cant, 'updated_at'=>$updated_refe,]);
            }
        elseif($modulo == "Embonar Relojera"){
            $new_cant = ($cant_ref[0]['cantidad_disponible_preparacion_emb_rlj']+$can_mod[0]['cantidad'])-$cantidad;
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_preparacion_emb_rlj'=>$new_cant, 'updated_at'=>$updated_refe,]);
            }
        elseif($modulo == "Pinzas"){
            $new_cant = ($cant_ref[0]['cantidad_disponible_preparacion_pin']+$can_mod[0]['cantidad'])-$cantidad;
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_preparacion_pin'=>$new_cant, 'updated_at'=>$updated_refe,]);
            }
        elseif($modulo == "Cotilla"){
            $new_cant = ($cant_ref[0]['cantidad_disponible_preparacion_cot']+$can_mod[0]['cantidad'])-$cantidad;
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_preparacion_cot'=>$new_cant, 'updated_at'=>$updated_refe,]);
            }
        elseif($modulo == "Cola"){
            $new_cant = ($cant_ref[0]['cantidad_disponible_preparacion_col']+$can_mod[0]['cantidad'])-$cantidad;
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_preparacion_col'=>$new_cant, 'updated_at'=>$updated_refe,]);
            }
        elseif($modulo == "Parchado"){
            $new_cant = ($cant_ref[0]['cantidad_disponible_preparacion_prc']+$can_mod[0]['cantidad'])-$cantidad;
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_preparacion_prc'=>$new_cant, 'updated_at'=>$updated_refe,]);
            }
    }

    private function validarActualizacionCantidadDisponibleReferencia($modulo,$id_refe,$cant_ref,$cantidad,$updated_refe)
    {
        if($modulo == "Embonar Parche"){
            $new_cant = $cant_ref[0]['cantidad_disponible_preparacion_emb_prc']-$cantidad;
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_preparacion_emb_prc'=>$new_cant, 'updated_at'=>$updated_refe,]);
            }
        elseif($modulo == "Embonar Relojera"){
            $new_cant = $cant_ref[0]['cantidad_disponible_preparacion_emb_rlj']-$cantidad;
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_preparacion_emb_rlj'=>$new_cant, 'updated_at'=>$updated_refe,]);
            }
        elseif($modulo == "Pinzas"){
            $new_cant = $cant_ref[0]['cantidad_disponible_preparacion_pin']-$cantidad;
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_preparacion_pin'=>$new_cant, 'updated_at'=>$updated_refe,]);
            }
        elseif($modulo == "Cotilla"){
            $new_cant = $cant_ref[0]['cantidad_disponible_preparacion_cot']-$cantidad;
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_preparacion_cot'=>$new_cant, 'updated_at'=>$updated_refe,]);
            }
        elseif($modulo == "Cola"){
            $new_cant = $cant_ref[0]['cantidad_disponible_preparacion_col']-$cantidad;
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_preparacion_col'=>$new_cant, 'updated_at'=>$updated_refe,]);
            }
        elseif($modulo == "Parchado"){
            $new_cant = $cant_ref[0]['cantidad_disponible_preparacion_prc']-$cantidad;
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_preparacion_prc'=>$new_cant, 'updated_at'=>$updated_refe,]);
            }
    }
    
    public function delete_preparacion($id)
    {
        $preparacion = DB::table('preparacion')->where('id','=',$id)->get();
        $refe = DB::table('referencias')->where('id','=',$preparacion[0]->id_referencia)->get();
        if($preparacion[0]->modulo == "Embonar Parche"){
            DB::table('referencias')->where('id','=',$preparacion[0]->id_referencia)->update(['cantidad_disponible_preparacion_emb_prc'=>$refe[0]->cantidad_disponible_preparacion_emb_prc+$preparacion[0]->cantidad]);
        }elseif($preparacion[0]->modulo == "Embonar Relojera"){
            DB::table('referencias')->where('id','=',$preparacion[0]->id_referencia)->update(['cantidad_disponible_preparacion_emb_rlj'=>$refe[0]->cantidad_disponible_preparacion_emb_rlj+$preparacion[0]->cantidad]);
        }elseif($preparacion[0]->modulo == "Pinzas"){
            DB::table('referencias')->where('id','=',$preparacion[0]->id_referencia)->update(['cantidad_disponible_preparacion_pin'=>$refe[0]->cantidad_disponible_preparacion_pin+$preparacion[0]->cantidad]);
        }elseif($preparacion[0]->modulo == "Cotilla"){
            DB::table('referencias')->where('id','=',$preparacion[0]->id_referencia)->update(['cantidad_disponible_preparacion_cot'=>$refe[0]->cantidad_disponible_preparacion_cot+$preparacion[0]->cantidad]);
        }elseif($preparacion[0]->modulo == "Cola"){
            DB::table('referencias')->where('id','=',$preparacion[0]->id_referencia)->update(['cantidad_disponible_preparacion_col'=>$refe[0]->cantidad_disponible_preparacion_col+$preparacion[0]->cantidad]);
        }elseif($preparacion[0]->modulo == "Parchado"){
            DB::table('referencias')->where('id','=',$preparacion[0]->id_referencia)->update(['cantidad_disponible_preparacion_prc'=>$refe[0]->cantidad_disponible_preparacion_prc+$preparacion[0]->cantidad]);
        }
        DB::table('preparacion')->where('id','=',$id)->delete();
        return redirect()->route('list_preparacion_hoy');
    }

    public function eficiencia($id)
    {
        $consulta_fecha = DB::table('preparacion')->where('id','=',$id)->get();
        $consulta = json_decode($consulta_fecha,true);
        $eficiencia_hoy = DB::table('preparacion')->where('fecha','=',$consulta[0]['fecha'])->where('turno','=',$consulta[0]['turno'])->get();
        $array = json_decode($eficiencia_hoy,true);
        $empleados = DB::select('select id_empleado FROM preparacion WHERE turno = '.$consulta[0]['turno'].' and fecha = "'.$consulta[0]['fecha'].'" GROUP BY id_empleado HAVING COUNT(*)>0');
        $array_per = [];

        foreach($empleados as $empleado){
        $meta = 0;
        $cantidad = 0;
        $eficiencia = 0;
        $color = "";
        $operario = "";
            for($i=0;$i<count($array);$i++){
                if($array[$i]['id_empleado'] == $empleado->id_empleado){
                    $meta += $array[$i]['meta_produccion'];
                    $cantidad += $array[$i]['cantidad'];
                }
            }
            if($meta!=0){
            $eficiencia = ($cantidad/$meta)*100;
            }
            if($eficiencia>=0 && $eficiencia<70){
                $color = "#F44336";
            }elseif($eficiencia>=70 && $eficiencia<80){
                $color = "#ffff00";
            }elseif($eficiencia>=80 && $eficiencia<100){
                $color = "#66FF00";
            }elseif($eficiencia>=100){
                $color = "#00EDB2";
            }
            $operario = DB::select('SELECT zarethpr_tiendas.clientes.nombres,zarethpr_tiendas.clientes.apellidos from zarethpr_tiendas.clientes WHERE '.$empleado->id_empleado.'=zarethpr_tiendas.clientes.id');
            array_push($array_per, array(  #Aquí está la respuesta, usa [] luego del nombre del array.
                "Empl" => $operario[0]->nombres." ".$operario[0]->apellidos,
                "Efic" => round($eficiencia, 2),
                "Color" => $color
                )
            );            
        } 
        $modulos = ["Embonar Parche","Embonar Relojera","Pinzas","Cotilla","Cola","Parchado"];
        $array_mod = [];

        
        foreach($modulos as $modulo){
            $meta = 0;
            $cantidad = 0;
            $eficiencia = 0;
            $color = "#F44336";
                for($i=0;$i<count($array);$i++){
                    if($array[$i]['modulo'] == $modulo){
                        $meta += $array[$i]['meta_produccion'];
                        $cantidad += $array[$i]['cantidad'];
                    }
                }
                if($meta!=0){
                $eficiencia = ($cantidad/$meta)*100;
                }
                if($eficiencia>=0 && $eficiencia<70){
                    $color = "#F44336";
                }elseif($eficiencia>=70 && $eficiencia<80){
                    $color = "#ffff00";
                }elseif($eficiencia>=80 && $eficiencia<100){
                    $color = "#66FF00";
                }elseif($eficiencia>=100){
                    $color = "#00EDB2";
                }
                array_push($array_mod, array(
                    "Mod" => $modulo,
                    "Meta" => $meta,
                    "Cant" => $cantidad,
                    "Efic" => round($eficiencia, 2),
                    "Color" => $color
                    )
                );            
            } 
        return view('preparacion.eficiencia')->with('array_per',$array_per)->with('array_mod',$array_mod);
    }

    public function lote_consulta(Request $request)
    {   
        $cantidad = $request->get('cantidad');
        $id_refe = $request->get('id_refe');
        $modulo = $request->get('modulo');
        $consulta_refe = DB::table('referencias')->where('id','=',$id_refe)->get();
        $consulta = json_decode($consulta_refe,true);
        $cons = 0;
        $disp = 0;

        if($modulo == "Embonar Parche"){
            $disp = $consulta[0]['cantidad_disponible_preparacion_emb_prc']-$cantidad;
            $cons = $consulta[0]['cantidad_disponible_preparacion_emb_prc'];
        }
        if($modulo == "Embonar Relojera"){
            $disp = $consulta[0]['cantidad_disponible_preparacion_emb_rlj']-$cantidad;
            $cons = $consulta[0]['cantidad_disponible_preparacion_emb_rlj'];
        }
        if($modulo == "Pinzas"){
            $disp = $consulta[0]['cantidad_disponible_preparacion_pin']-$cantidad;
            $cons = $consulta[0]['cantidad_disponible_preparacion_pin'];
        }
        if($modulo == "Cotilla"){
            $disp = $consulta[0]['cantidad_disponible_preparacion_cot']-$cantidad;
            $cons = $consulta[0]['cantidad_disponible_preparacion_cot'];
        }
        if($modulo == "Cola"){
            $disp = $consulta[0]['cantidad_disponible_preparacion_col']-$cantidad;
            $cons = $consulta[0]['cantidad_disponible_preparacion_col'];
        }
        if($modulo == "Parchado"){
            $disp = $consulta[0]['cantidad_disponible_preparacion_prc']-$cantidad;
            $cons = $consulta[0]['cantidad_disponible_preparacion_prc'];
        }

        if($disp>=0){
            return response()->json([1,$cantidad,$cons,$disp]);
        }else{
            return response()->json([2,$cantidad,$cons,$disp]);
        }
    }

    public function lote_consulta_new(Request $request)
    {   
        $cantidad = $request->get('cantidad');
        $id_refe = $request->get('id_refe');
        $id = $request->get('id');
        $modulo = $request->get('modulo');
        $cant_mod = DB::table('preparacion')->where('id','=',$id)->get();
        $can_mod = json_decode($cant_mod,true);
        $consulta_refe = DB::table('referencias')->where('id','=',$id_refe)->get();
        $consulta = json_decode($consulta_refe,true);
        $disp = 0;
        $cons = 0;
        

        if($id_refe==$can_mod[0]['id_referencia']){

            if($modulo == $can_mod[0]['modulo']){
                if($modulo == "Embonar Parche"){
                    $disp = ($consulta[0]['cantidad_disponible_preparacion_emb_prc']+$can_mod[0]['cantidad'])-$cantidad;
                    $cons = $consulta[0]['cantidad_disponible_preparacion_emb_prc'];
                }
                if($modulo == "Embonar Relojera"){
                    $disp = ($consulta[0]['cantidad_disponible_preparacion_emb_rlj']+$can_mod[0]['cantidad'])-$cantidad;
                    $cons = $consulta[0]['cantidad_disponible_preparacion_emb_rlj'];
                }
                if($modulo == "Pinzas"){
                    $disp = ($consulta[0]['cantidad_disponible_preparacion_pin']+$can_mod[0]['cantidad'])-$cantidad;
                    $cons = $consulta[0]['cantidad_disponible_preparacion_pin'];
                }
                if($modulo == "Cotilla"){
                    $disp = ($consulta[0]['cantidad_disponible_preparacion_cot']+$can_mod[0]['cantidad'])-$cantidad;
                    $cons = $consulta[0]['cantidad_disponible_preparacion_cot'];
                }
                if($modulo == "Cola"){
                    $disp = ($consulta[0]['cantidad_disponible_preparacion_col']+$can_mod[0]['cantidad'])-$cantidad;
                    $cons = $consulta[0]['cantidad_disponible_preparacion_col'];
                }
                if($modulo == "Parchado"){
                    $disp = ($consulta[0]['cantidad_disponible_preparacion_prc']+$can_mod[0]['cantidad'])-$cantidad;
                    $cons = $consulta[0]['cantidad_disponible_preparacion_prc'];
                }
            }else{
                if($modulo == "Embonar Parche"){
                    $disp = $consulta[0]['cantidad_disponible_preparacion_emb_prc']-$cantidad;
                    $cons = $consulta[0]['cantidad_disponible_preparacion_emb_prc'];
                }
                if($modulo == "Embonar Relojera"){
                    $disp = $consulta[0]['cantidad_disponible_preparacion_emb_rlj']-$cantidad;
                    $cons = $consulta[0]['cantidad_disponible_preparacion_emb_rlj'];
                }
                if($modulo == "Pinzas"){
                    $disp = $consulta[0]['cantidad_disponible_preparacion_pin']-$cantidad;
                    $cons = $consulta[0]['cantidad_disponible_preparacion_pin'];
                }
                if($modulo == "Cotilla"){
                    $disp = $consulta[0]['cantidad_disponible_preparacion_cot']-$cantidad;
                    $cons = $consulta[0]['cantidad_disponible_preparacion_cot'];
                }
                if($modulo == "Cola"){
                    $disp = $consulta[0]['cantidad_disponible_preparacion_col']-$cantidad;
                    $cons = $consulta[0]['cantidad_disponible_preparacion_col'];
                }
                if($modulo == "Parchado"){
                    $disp = $consulta[0]['cantidad_disponible_preparacion_prc']-$cantidad;
                    $cons = $consulta[0]['cantidad_disponible_preparacion_prc'];
                }
            }
            
            if($disp>=0){
                return response()->json([1,$cantidad,$cons,$disp]);
            }else{
                return response()->json([2,$cantidad,$cons,$disp]);
            }
        }else{
            if($modulo == "Embonar Parche"){
                $disp = $consulta[0]['cantidad_disponible_preparacion_emb_prc']-$cantidad;
                $cons = $consulta[0]['cantidad_disponible_preparacion_emb_prc'];
            }
            if($modulo == "Embonar Relojera"){
                $disp = $consulta[0]['cantidad_disponible_preparacion_emb_rlj']-$cantidad;
                $cons = $consulta[0]['cantidad_disponible_preparacion_emb_rlj'];
            }
            if($modulo == "Pinzas"){
                $disp = $consulta[0]['cantidad_disponible_preparacion_pin']-$cantidad;
                $cons = $consulta[0]['cantidad_disponible_preparacion_pin'];
            }
            if($modulo == "Cotilla"){
                $disp = $consulta[0]['cantidad_disponible_preparacion_cot']-$cantidad;
                $cons = $consulta[0]['cantidad_disponible_preparacion_cot'];
            }
            if($modulo == "Cola"){
                $disp = $consulta[0]['cantidad_disponible_preparacion_col']-$cantidad;
                $cons = $consulta[0]['cantidad_disponible_preparacion_col'];
            }
            if($modulo == "Parchado"){
                $disp = $consulta[0]['cantidad_disponible_preparacion_prc']-$cantidad;
                $cons = $consulta[0]['cantidad_disponible_preparacion_prc'];
            }

            if($disp>=0){
                return response()->json([1,$cantidad,$cons,$disp]);
            }else{
                return response()->json([2,$cantidad,$cons,$disp]);
            }
        }
    }
}
