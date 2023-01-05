<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\ClientesModelTiendas;
use App\Exports\EnsambleExport;
use App\Exports\ArchivoPrimarioExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;


class EnsambleController extends Controller
{
    public function reporte_ensamble_operario()
    {
        /*************************************
        Se hace consulta la BD donde se calcula la eficiencia por empleado agrupando por fecha, empleado y turno ordenando por fecha de forma ascendente.
        *************************************/
        $consultas = DB::select('select id_empleado,(SELECT zarethpr_tiendas.clientes.nombres from zarethpr_tiendas.clientes WHERE ensamble.id_empleado=zarethpr_tiendas.clientes.id) AS nombres,(SELECT zarethpr_tiendas.clientes.apellidos from zarethpr_tiendas.clientes WHERE ensamble.id_empleado=zarethpr_tiendas.clientes.id) AS apellidos,fecha,turno, SUM(cantidad) as cantidad, SUM(meta_produccion) as meta_produccion, (SUM(cantidad)/ SUM(meta_produccion))*100 as eficiencia FROM ensamble where fecha BETWEEN date_add(NOW(), INTERVAL -31 DAY) AND NOW() GROUP BY id_empleado,fecha,turno HAVING COUNT(*)>0 ORDER BY fecha ASC');
        return view('ensamble.reporte_operario_ensamble')->with('consultas',$consultas);
    }
    
    public function reporte_operario_consulta(Request $request)
    {
        /*************************************
        Metodo recibe parametros via ajax donde se recibe fecha, turno, empleado y se guardan en variables.
        *************************************/
        $fecha = $request->get('fecha');
        $turno = $request->get('turno');
        $id_empleado = $request->get('id_empleado');
        /*************************************
        Se genera una consulta a la BD condicionando a que los registros que traiga tengan estos datos.
        *************************************/
        $reporte_ope = DB::select('select id,fecha,turno,modulo,(SELECT zarethpr_tiendas.clientes.nombres from zarethpr_tiendas.clientes WHERE ensamble.id_empleado=zarethpr_tiendas.clientes.id) AS nombres, (SELECT zarethpr_tiendas.clientes.apellidos from zarethpr_tiendas.clientes WHERE ensamble.id_empleado=zarethpr_tiendas.clientes.id) AS apellidos,(SELECT referencias.lote_referencia from referencias WHERE ensamble.id_referencia=referencias.id) AS referencia,tallas,tc, tipo, hora, cantidad,tiempo_req_h,meta_produccion,eficiencia,n_operarios,(SELECT paradas_programadas.tipo_parada_prg from paradas_programadas WHERE ensamble.id_parada_prg=paradas_programadas.id) AS parada_programada, (SELECT paradas_programadas.tiempo from paradas_programadas WHERE ensamble.id_parada_prg = paradas_programadas.id) AS tiempo_parada_programada, (SELECT paradas_no_programadas.tipo_parada_noprg from paradas_no_programadas WHERE ensamble.id_parada_noprg=paradas_no_programadas.id) AS parada_no_programada,tiempo_noprg from ensamble where fecha = "'.$fecha.'" and turno ='.$turno.' and id_empleado = '.$id_empleado);
        return response()->json($reporte_ope);
    }

    public function reporte_ensamble_modulo()
    {
        /*************************************
        Se hace consulta la BD donde se calcula la eficiencia por modulo agrupando por fecha, modulo y turno ordenando por fecha de forma ascendente.
        *************************************/
        $consultas = DB::select('select modulo,fecha,turno, SUM(cantidad) as cantidad, SUM(meta_produccion) as meta_produccion, (SUM(cantidad)/ SUM(meta_produccion))*100 as eficiencia FROM ensamble where fecha BETWEEN date_add(NOW(), INTERVAL -31 DAY) AND NOW() GROUP BY modulo,fecha,turno HAVING COUNT(*)>0 ORDER BY fecha ASC');
        return view('ensamble.reporte_modulo_ensamble')->with('consultas',$consultas);
    }
    
    public function reporte_modulo_consulta(Request $request)
    {
        /*************************************
        Metodo recibe parametros via ajax donde se recibe fecha, turno, empleado y se guardan en variables.
        *************************************/
        $fecha = $request->get('fecha');
        $turno = $request->get('turno');
        $modulo = $request->get('modulo');
        /*************************************
        Se genera una consulta a la BD condicionando a que los registros que traiga tengan estos datos.
        *************************************/
        $reporte_mod = DB::select('select id,fecha,turno,modulo,(SELECT zarethpr_tiendas.clientes.nombres from zarethpr_tiendas.clientes WHERE ensamble.id_empleado=zarethpr_tiendas.clientes.id) AS nombres, (SELECT zarethpr_tiendas.clientes.apellidos from zarethpr_tiendas.clientes WHERE ensamble.id_empleado=zarethpr_tiendas.clientes.id) AS apellidos,(SELECT referencias.lote_referencia from referencias WHERE ensamble.id_referencia=referencias.id) AS referencia,tallas,tc, tipo, hora, cantidad,tiempo_req_h,meta_produccion,eficiencia,n_operarios,(SELECT paradas_programadas.tipo_parada_prg from paradas_programadas WHERE ensamble.id_parada_prg=paradas_programadas.id) AS parada_programada, (SELECT paradas_programadas.tiempo from paradas_programadas WHERE ensamble.id_parada_prg = paradas_programadas.id) AS tiempo_parada_programada, (SELECT paradas_no_programadas.tipo_parada_noprg from paradas_no_programadas WHERE ensamble.id_parada_noprg=paradas_no_programadas.id) AS parada_no_programada,tiempo_noprg from ensamble where fecha = "'.$fecha.'" and turno ='.$turno.' and modulo = "'.$modulo.'"');
        return response()->json($reporte_mod);
    }

    public function download_excel()
    {
        /*************************************
        Se crea una clase en "App\Exports", se utiliza "App\Exports\ArchivoPrimarioExport", "Maatwebsite\Excel\Facades\Excel" y "App\Exports\Ensamble" -> (Class creada para exportar el excel).
        Se hace la consulta a la BD y se envia como parametro a la clase previamente creada para generar el reporte en excel.
        *************************************/
        $ensamble = DB::select('select id,fecha,turno,modulo,(SELECT zarethpr_tiendas.clientes.nombres from zarethpr_tiendas.clientes WHERE ensamble.id_empleado=zarethpr_tiendas.clientes.id) AS nombres, (SELECT zarethpr_tiendas.clientes.apellidos from zarethpr_tiendas.clientes WHERE ensamble.id_empleado=zarethpr_tiendas.clientes.id) AS apellidos, (SELECT zarethpr_tiendas.clientes.documento from zarethpr_tiendas.clientes WHERE ensamble.id_empleado=zarethpr_tiendas.clientes.id) AS documento,(SELECT referencias.lote_referencia from referencias WHERE ensamble.id_referencia=referencias.id) AS referencia,tallas,tc, tipo, hora, cantidad,tiempo_req_h,meta_produccion,eficiencia,n_operarios,(SELECT paradas_programadas.tipo_parada_prg from paradas_programadas WHERE ensamble.id_parada_prg=paradas_programadas.id) AS parada_programada, (SELECT paradas_programadas.tiempo from paradas_programadas WHERE ensamble.id_parada_prg = paradas_programadas.id) AS tiempo_parada_programada, (SELECT paradas_no_programadas.tipo_parada_noprg from paradas_no_programadas WHERE ensamble.id_parada_noprg=paradas_no_programadas.id) AS parada_no_programada,tiempo_noprg from ensamble');
        return Excel::download(new EnsambleExport($ensamble),"Ensamble.xlsx");
    }
    
    public function index_ensamble()
    {   
        /*************************************
        Se hace consulta a la BD para que traiga los resgistros ingresados en los ultimos 15 dias.
        *************************************/
        $ensamble = DB::select('select id,fecha,turno,modulo,(SELECT zarethpr_tiendas.clientes.nombres from zarethpr_tiendas.clientes WHERE ensamble.id_empleado=zarethpr_tiendas.clientes.id) AS nombres, (SELECT zarethpr_tiendas.clientes.apellidos from zarethpr_tiendas.clientes WHERE ensamble.id_empleado=zarethpr_tiendas.clientes.id) AS apellidos,(SELECT referencias.lote_referencia from referencias WHERE ensamble.id_referencia=referencias.id) AS referencia,tallas,tc, tipo, hora, cantidad,tiempo_req_h,meta_produccion,eficiencia,n_operarios,(SELECT paradas_programadas.tipo_parada_prg from paradas_programadas WHERE ensamble.id_parada_prg=paradas_programadas.id) AS parada_programada, (SELECT paradas_programadas.tiempo from paradas_programadas WHERE ensamble.id_parada_prg = paradas_programadas.id) AS tiempo_parada_programada, (SELECT paradas_no_programadas.tipo_parada_noprg from paradas_no_programadas WHERE ensamble.id_parada_noprg=paradas_no_programadas.id) AS parada_no_programada,tiempo_noprg from ensamble where fecha BETWEEN date_add(NOW(), INTERVAL -15 DAY) AND NOW()');
        return view('ensamble.tabla_ensamble')->with('ensamble',$ensamble);
    }

    public function index_ensamble_hoy()
    {
        /*************************************
        Se hace consulta a la BD para que traiga los resgistros ingresados en el dia actual.
        *************************************/
        $fecha = Carbon::now();
        $fecha = $fecha->format('Y-m-d');
        $ensamble = DB::select('select id,fecha,turno,modulo,(SELECT zarethpr_tiendas.clientes.nombres from zarethpr_tiendas.clientes WHERE ensamble.id_empleado=zarethpr_tiendas.clientes.id) AS nombres, (SELECT zarethpr_tiendas.clientes.apellidos from zarethpr_tiendas.clientes WHERE ensamble.id_empleado=zarethpr_tiendas.clientes.id) AS apellidos,(SELECT referencias.lote_referencia from referencias WHERE ensamble.id_referencia=referencias.id) AS referencia,tallas,tc, tipo, hora, cantidad,tiempo_req_h,meta_produccion,eficiencia,n_operarios,(SELECT paradas_programadas.tipo_parada_prg from paradas_programadas WHERE ensamble.id_parada_prg=paradas_programadas.id) AS parada_programada, (SELECT paradas_programadas.tiempo from paradas_programadas WHERE ensamble.id_parada_prg = paradas_programadas.id) AS tiempo_parada_programada, (SELECT paradas_no_programadas.tipo_parada_noprg from paradas_no_programadas WHERE ensamble.id_parada_noprg=paradas_no_programadas.id) AS parada_no_programada,tiempo_noprg from ensamble where fecha = "'.$fecha.'"');
        return view('ensamble.tabla_ensamble')->with('ensamble',$ensamble);
    }

    public function create_ensamble_masivo()
    {
        /*************************************
        Se hace consulta a la BD para traer referencias, paradas programadas, paradas no programadas y se retornar a la vista junto con la fecha de hoy.
        *************************************/
        $referencias = DB::select('select * from referencias order by lote_referencia asc');
        $programadas = DB::table('paradas_programadas')->get();
        $no_programadas = DB::table('paradas_no_programadas')->get();
        $fecha = Carbon::now();
        $fecha = $fecha->format('Y-m-d');
        $empleados = ClientesModelTiendas::where('estado_empresa','=',1)->orderBy('nombres', 'ASC')->get();
        return view('ensamble.form_ensamble_masivo',compact('programadas','no_programadas','referencias','fecha','empleados'));
    }

    public function store_ensamble_masivo(Request $request)
    {
        /*************************************
        Se reciben los parametros enviados por la vista y se guaradan en variables.
        *************************************/
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
        /*************************************
        Creamos 3 variables tipo "Boolean" inicializandola como "false" para validar el turno, modulo y operario.
        *************************************/
        $validar_turno = false;
        $validar_modulo = false;
        $validar_operario = false;
        /*************************************
        Generamos una consulta a la BD con la fecha que recibimos en el "Request".
        *************************************/
        $consulta = DB::table('ensamble')->where('fecha','=',$fecha)->get();
        /*************************************
        En el ciclo hacemos que vaya de 0 hasta la cantidad de registros que trajo y que valide en la fecha que colocamos en la consulta si ya hay registros creados con el turno, modulo y empleado recibidos.
        *************************************/
        for ($i=0;$i<count($consulta);$i++) { 
            if($consulta[$i]->turno == $turno){
                $validar_turno=true;
            }
            if($consulta[$i]->modulo == $modulo){
                $validar_modulo=true;
            }
            if($consulta[$i]->id_empleado == $empleado){
                $validar_operario=true;
            }
        }
        /*************************************
        Al terminar el ciclo preguntamos si los 3 booleans que creamos son verdaderos. Si los 3 son verdaderos retornara un mensaje de error a la vista avisando que ya se hizo una carga masiva de registros al cliente, en el modulo turno y fecha recibidos.
        *************************************/
        if($validar_turno==true && $validar_modulo==true && $validar_operario==true){
        return redirect()->back()->withErrors(['msg' => 'Ya se hizo una carga masiva al empleado seleccionado en el modulo '.$modulo.' en el turno '.$turno.' en la fecha '.$fecha.'.']);
        }else{
            /*************************************
            Insertara datos a la BD en un ciclo en todas las horas que fueron seleccionadas para que el operario trabaje junto a la referencia que va a trabajar.
            *************************************/
            for ($i=0; $i<count($hora); $i++) { 
                DB::insert('insert into ensamble (fecha,turno,modulo,id_empleado,id_referencia,tc,tipo,hora,cantidad,tiempo_req_h,meta_produccion,eficiencia,n_operarios,created_at) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$fecha,$turno,$modulo,$empleado,$id_refe,$tc,$tipo,$hora[$i],0,$tiempo_r,$meta_p,0,$n_operarios,$created_at]);
            }
            return redirect()->route('create_ensamble_masivo');
        }
        
    }

    public function create_ensamble()
    {
        /*************************************
        Se hace consulta a la BD para traer referencias, paradas programadas, paradas no programadas, operarios y se retornaran a la vista.
        *************************************/
        $referencias = DB::select('select * from referencias order by lote_referencia asc');
        $programadas = DB::table('paradas_programadas')->get();
        $no_programadas = DB::table('paradas_no_programadas')->get();
        $empleados = ClientesModelTiendas::where('estado_empresa','=',1)->orderBy('nombres', 'ASC')->get();
        return view('ensamble.form_ensamble',compact('programadas','no_programadas','referencias','empleados'));
    }

    public function store_ensamble(Request $request)
    {
        /*************************************
        Se reciben los parametros enviados por la vista y se guaradan en variables.
        *************************************/
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
        /*************************************
        Se consulta el tiempo de la parada programada seleccionada.
        *************************************/
        $tiempo_p_prg = DB::table('paradas_programadas')->where('id','=',$tipo_p_prgm)->get('tiempo');
        /*************************************
        Validamos si la consulta trajo registros. Si no trajo registros declaramos el tiempo de la parada programada como 0, de lo contrario obtenemos el valor del tiempo de esa parada programada.
        *************************************/
        if(count($tiempo_p_prg) == 0){
            $tiempo_p_prg = 0;
        }else{
            $t = json_decode($tiempo_p_prg,true);
            $tiempo_p_prg = $t[0]['tiempo'];
        }
        /*************************************
        Validamos si el tiempo de la parada programada viene vacia. Si es así, le asignamos el valor de 0.
        *************************************/
        if($tiempo_pno_prgm == ""){
            $tiempo_pno_prgm = 0;
        }
        /*************************************
        Calculamos el tiempo disponible multiplicando el numero de operarios recibido en el "Request" y lo multiplicamos por el tiempo requerido en horas que no puede ser menor a 0 y mayor a 1 (eso está validado con js en cada uno de los formularios).
        Calculamos el total de las paradas progrmadas multiplicando el tiempo de la parada programada por el numero de operarios. El tiempo de la parada no programda se calcula igual, pero eso lo hace la persona que está ingresando los datos ya que el tiempo puede variar.
        Calculamos la meta de produccion, primero al tiempo disponible calculado inicialmente le restamos el tiempo total de la parada programada y el tiempo total de la parada no programada, a ese resultado se le divide entre el tiempo de ciclo recibido en el "Request".
        *************************************/
        $td = $n_operarios*$tiempo_r*3600;
        $totaltpp = $tiempo_p_prg*$n_operarios;
        $meta_p = ($td-$totaltpp-$tiempo_pno_prgm)/$tc;
        /*************************************
        Validamos si la meta de produccion es 0, si es así declaramos la eficiencia y la cantidad hecha por el modulo en 0.
        *************************************/
        if($meta_p==0){
            $eficiencia=0;
            $cantidad=0;
        }else{
            /*************************************
            Si la meta no es 0, entonces la calculamos dividiendo la cantidad sobre la meta de produccion y ese resultado lo multiplicamos por 100 para obtener el porcentaje de eficiencia.
            *************************************/
            $eficiencia = ($cantidad/$meta_p)*100;
        }
        /*************************************
        Consultamos a la BD la referencia recibida en el "Request".
        *************************************/
        $updated_refe = Carbon::now();
        $cant_refe = DB::table('referencias')->where('id','=',$id_refe)->get();
        $cant_ref = json_decode($cant_refe,true);
        $new_cant = 0;
        /*************************************
        Validamos el modulo seleccionado y recibido en el "Request" y lo comparamos con todos los modulos creados para el proceso de ensamble. Cada proceso tiene su cantidad de lote disponible.
        Para calcular la nueva cantidad del lote simplemtente obtenemos la cantidad disponible de ese modulo y le restamos la cantidad recibida en el "Request".
        La validacion de la cantidad se hace via ajax, permitiendo a al analista de produccion saber si la cantidad que está ingresando se encuentra disponible o no.
        *************************************/
        if($modulo == "Pretina"){
            $new_cant = $cant_ref[0]['cantidad_disponible_ensamble_prt']-$cantidad;
        }elseif($modulo == "Punta"){
            $new_cant = $cant_ref[0]['cantidad_disponible_ensamble_pnt']-$cantidad;
        }elseif($modulo == "Bota"){
            $new_cant = $cant_ref[0]['cantidad_disponible_ensamble_bot']-$cantidad;
        }elseif($modulo == "Bota Plana"){
            $new_cant = $cant_ref[0]['cantidad_disponible_ensamble_bot_pln']-$cantidad;
        }elseif($modulo == "Presilla"){
            $new_cant = $cant_ref[0]['cantidad_disponible_ensamble_prs']-$cantidad;
        }elseif($modulo == "Pasador Presilla"){
            $new_cant = $cant_ref[0]['cantidad_disponible_ensamble_pas_prs']-$cantidad;
        }elseif($modulo == "Pasador Mol"){
            $new_cant = $cant_ref[0]['cantidad_disponible_ensamble_pas_mol']-$cantidad;
        }elseif($modulo == "Ojal"){
            $new_cant = $cant_ref[0]['cantidad_disponible_ensamble_ojal']-$cantidad;
        }elseif($modulo == "Revision"){
            $new_cant = $cant_ref[0]['cantidad_disponible_ensamble_rvs']-$cantidad;
        }elseif($modulo == "Revision Ext"){
            $new_cant = $cant_ref[0]['cantidad_disponible_ensamble_rvs_ext']-$cantidad;
        }elseif($modulo == "Revision Presilla"){
            $new_cant = $cant_ref[0]['cantidad_disponible_ensamble_rvs_prs']-$cantidad;
        }
        /*************************************
        Consultamos a la BD para validar si existe algun registro en la fecha, turno, modulo, hora y empleado recibidos en el "Request".
        *************************************/
        $validar_si_existe = DB::table('ensamble')->where('fecha','=',$fecha)->where('turno','=',$turno)->where('modulo','=',$modulo)->where('hora','=',$hora)->where('id_empleado','=',$id_empl)->get();
        /*************************************
        Si la cantidad de registros es mayor a eso pasamos a comprobar si la suma de los tiempos en horas requeridos registrados en la base de datos mas el que recibimos en el "Request" es mayor a 1.
        *************************************/
        if(count($validar_si_existe)>0){
            /*************************************
            Iniciamos una variable para ir sumando los registros.
            Creamos un ciclo que vaya de 0 a la cantidad de registros que trajo.
            *************************************/
            $array_validar = json_decode($validar_si_existe,true);
            $sum_time_req = 0;
                for($i=0;$i<count($array_validar);$i++){
                    $sum_time_req+=$array_validar[$i]['tiempo_req_h'];
                }
                /*************************************
                Sumamos el resultado del acomulado del ciclo con el tiempo requerido en horas recibido en el "Request".
                *************************************/
                $sum_time_req+=$tiempo_r;
                /*************************************
                Si es mayor a 1 retornara el valor "2" que hace referencia a "false". En la respuesta de la peticion ajax se mostrara un mensaje "error" cuando el valor develto sea 2.
                *************************************/
                if($sum_time_req>1){
                    return response()->json(2);
                }else{
                    /*************************************
                    Si es menor o igual a 1 entonces llamamos al metodo "actualizarLoteDisponible()" que recibe los parametros enviados, este actualizará la cantidad del lote de la referencia en el lote seleccionado.
                    Luego insertamos a la BD todos lo parametros recibidos en el "Request".
                    Se retornará el valor de "1" que hace referencia a "true".En la respuesta de la peticion ajax se mostrara un mensaje "success" cuando el valor develto sea 1.
                    *************************************/
                    $this->actualizarLoteDisponible($modulo,$id_refe,$new_cant,$updated_refe);
                    DB::insert('insert into ensamble (fecha,turno,modulo,id_empleado,id_referencia,tallas,tc,tipo,hora,cantidad,tiempo_req_h,meta_produccion,eficiencia,n_operarios,id_parada_prg,id_parada_noprg,tiempo_noprg,created_at) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$fecha,$turno,$modulo,$id_empl,$id_refe,$tallas,$tc,$tipo,$hora,$cantidad,$tiempo_r,$meta_p,$eficiencia,$n_operarios,$tipo_p_prgm,$tipo_pno_prgm,$tiempo_pno_prgm,$created_at]);
                    return response()->json(1);
                }
        }else{
            /*************************************
            Si no hay registros en la BD, llamamos al metodo "actualizarLoteDisponible()" que recibe los parametros enviados, este actualizará la cantidad del lote de la referencia en el lote seleccionado.
            Luego insertamos a la BD todos lo parametros recibidos en el "Request".
            Se retornará el valor de "1" que hace referencia a "true".En la respuesta de la peticion ajax se mostrara un mensaje "success" cuando el valor develto sea 1.
            *************************************/
            $this->actualizarLoteDisponible($modulo,$id_refe,$new_cant,$updated_refe);
            DB::insert('insert into ensamble (fecha,turno,modulo,id_empleado,id_referencia,tallas,tc,tipo,hora,cantidad,tiempo_req_h,meta_produccion,eficiencia,n_operarios,id_parada_prg,id_parada_noprg,tiempo_noprg,created_at) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$fecha,$turno,$modulo,$id_empl,$id_refe,$tallas,$tc,$tipo,$hora,$cantidad,$tiempo_r,$meta_p,$eficiencia,$n_operarios,$tipo_p_prgm,$tipo_pno_prgm,$tiempo_pno_prgm,$created_at]);
            return response()->json(1);
        }
    }

    private function actualizarLoteDisponible($modulo,$id_refe,$new_cant,$updated_refe){
        /*************************************
        Esta funcion private actualiza el lote disponible de la referencia recibida en el "Request".
        Recibe unos parametos para validar el modulo recibido en el "Request" y así poder determinar cual será la nueva cantidad disponible.
        Se hace el update a la referencia.
        *************************************/
        if($modulo == "Pretina"){
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_ensamble_prt'=>$new_cant, 'updated_at'=>$updated_refe,]);
            }
        elseif($modulo == "Punta"){
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_ensamble_pnt'=>$new_cant, 'updated_at'=>$updated_refe,]);
            }
        elseif($modulo == "Bota"){
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_ensamble_bot'=>$new_cant, 'updated_at'=>$updated_refe,]);
            }
        elseif($modulo == "Bota Plana"){
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_ensamble_bot_pln'=>$new_cant, 'updated_at'=>$updated_refe,]);
            }
        elseif($modulo == "Presilla"){
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_ensamble_prs'=>$new_cant, 'updated_at'=>$updated_refe,]);
            }   
        elseif($modulo == "Pasador Presilla"){
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_ensamble_pas_prs'=>$new_cant, 'updated_at'=>$updated_refe,]);
            }
        elseif($modulo == "Pasador Mol"){
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_ensamble_pas_mol'=>$new_cant, 'updated_at'=>$updated_refe,]);
            }
        elseif($modulo == "Ojal"){
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_ensamble_ojal'=>$new_cant, 'updated_at'=>$updated_refe,]);
            }
        elseif($modulo == "Revision"){
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_ensamble_rvs'=>$new_cant, 'updated_at'=>$updated_refe,]);
            }
        elseif($modulo == "Revision Ext"){
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_ensamble_rvs_ext'=>$new_cant, 'updated_at'=>$updated_refe,]);
            }
        elseif($modulo == "Revision Presilla"){
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_ensamble_rvs_prs'=>$new_cant, 'updated_at'=>$updated_refe,]);
            }
    }

    public function edit_ensamble($id)
    {
        /*************************************
        Se hace consulta a la BD para traer referencias, paradas programadas, paradas no programadas, operarios y se retornaran a la vista.
        Ademas se consultan los datos del registro del "id" recibido para ser retornadas a la vista y editar los datos.
        *************************************/
        $programadas = DB::table('paradas_programadas')->get();
        $no_programadas = DB::table('paradas_no_programadas')->get();
        $ensamble = DB::table('ensamble')->where('id','=',$id)->get();
        $ens = json_decode($ensamble,true);
        $empleados = ClientesModelTiendas::where('estado_empresa','=',1)->orderBy('nombres', 'ASC')->get();
        $referencias = DB::select('select * from referencias order by lote_referencia asc');
        
        return view('ensamble.edit_ensamble',compact('programadas','no_programadas','ens','referencias','empleados'));
    }

    public function update_ensamble(Request $request, $id)
    {
        /*************************************
        Se reciben los parametros enviados por la vista y se guaradan en variables.
        *************************************/
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
        /*************************************
        Se consulta el tiempo de la parada programada seleccionada.
        *************************************/
        $tiempo_p_prg = DB::table('paradas_programadas')->where('id','=',$tipo_p_prgm)->get('tiempo');
        /*************************************
        Validamos si la consulta trajo registros. Si no trajo registros declaramos el tiempo de la parada programada como 0, de lo contrario obtenemos el valor del tiempo de esa parada programada.
        *************************************/
        if(count($tiempo_p_prg) == 0){
            $tiempo_p_prg = 0;
        }else{
            $t = json_decode($tiempo_p_prg,true);
            $tiempo_p_prg = $t[0]['tiempo'];
        }
        /*************************************
        Validamos si el tiempo de la parada programada viene vacia. Si es así, le asignamos el valor de 0.
        *************************************/
        if($tiempo_pno_prgm == ""){
            $tiempo_pno_prgm = 0;
        }
        /*************************************
        Calculamos el tiempo disponible multiplicando el numero de operarios recibido en el "Request" y lo multiplicamos por el tiempo requerido en horas que no puede ser menor a 0 y mayor a 1 (eso está validado con js en cada uno de los formularios).
        Calculamos el total de las paradas progrmadas multiplicando el tiempo de la parada programada por el numero de operarios. El tiempo de la parada no programda se calcula igual, pero eso lo hace la persona que está ingresando los datos ya que el tiempo puede variar.
        Calculamos la meta de produccion, primero al tiempo disponible calculado inicialmente le restamos el tiempo total de la parada programada y el tiempo total de la parada no programada, a ese resultado se le divide entre el tiempo de ciclo recibido en el "Request".
        *************************************/
        $td = $n_operarios*$tiempo_r*3600;
        $totaltpp = $tiempo_p_prg*$n_operarios;
        $meta_p = ($td-$totaltpp-$tiempo_pno_prgm)/$tc;
        /*************************************
        Validamos si la meta de produccion es 0, si es así declaramos la eficiencia y la cantidad hecha por el modulo en 0.
        *************************************/
        if($meta_p==0){
            $eficiencia=0;
            $cantidad=0;
        }else{
        $eficiencia = ($cantidad/$meta_p)*100;
        }
        /*************************************
        Consultamos a la BD el registro que estamos modificando con el "id" recibido "Request", la referencia cuando el "id referencia" es igual al que recibimos del "Request" y la referencia cuando el "id referencia" es igual al inicialmente registrado.
        *************************************/
        $updated_refe = Carbon::now();
        $cant_mod = DB::table('ensamble')->where('id','=',$id)->get();
        $can_mod = json_decode($cant_mod,true);
        $cant_refe = DB::table('referencias')->where('id','=',$id_refe)->get();
        $cant_ref = json_decode($cant_refe,true);
        $cant_refe_new = DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->get();
        $cant_ref_new = json_decode($cant_refe_new,true);
        $new_cant = 0;
        $new_cant_new = 0;
        /*************************************
        Consultamos a la BD para validar si existe algun registro en la fecha, turno, modulo, hora, empleado y id distinto al del registro que estamos modificando recibidos en el "Request".
        *************************************/
        $validar_si_existe = DB::table('ensamble')->where('fecha','=',$fecha)->where('turno','=',$turno)->where('modulo','=',$modulo)->where('hora','=',$hora)->where('id_empleado','=',$id_empl)->where('id','!=',$id)->get();
        /*************************************
        Si la cantidad de registros es mayor a eso pasamos a comprobar si la suma de los tiempos en horas requeridos registrados en la base de datos mas el que recibimos en el "Request" es mayor a 1.
        *************************************/
        if(count($validar_si_existe)>0){
            /*************************************
            Iniciamos una variable para ir sumando los registros.
            Creamos un ciclo que vaya de 0 a la cantidad de registros que trajo.
            *************************************/
            $array_validar = json_decode($validar_si_existe,true);
            $sum_time_req = 0;
                for($i=0;$i<count($array_validar);$i++){
                    $sum_time_req+=$array_validar[$i]['tiempo_req_h'];
                }
                /*************************************
                Sumamos el resultado del acomulado del ciclo con el tiempo requerido en horas recibido en el "Request".
                *************************************/
                $sum_time_req+=$tiempo_r;
                /*************************************
                Si es mayor a 1 retornara el valor "2" que hace referencia a "false". En la respuesta de la peticion ajax se mostrara un mensaje "error" cuando el valor develto sea 2.
                *************************************/
                if($sum_time_req>1){
                    return response()->json(2);
                }else{
                    /*************************************
                    Validamos si la referencia selecionada es igual a la inicialmente registrada.
                    *************************************/
                    if($id_refe==$can_mod[0]['id_referencia']){
                        /*************************************
                        Validamos si el modulo seleccionado es igual al inicialmente registrado.
                        *************************************/
                        if($modulo == $can_mod[0]['modulo']){
                            /*************************************
                            Si es así llamamos al metodo "validarActualizacionCantidadDisponibleReferenciaOld()" para que actualice la nueva cantidad disponible de la referencia y modulo recibidos del "Request".
                            *************************************/
                            $this->validarActualizacionCantidadDisponibleReferenciaOld($modulo,$id_refe,$cant_ref,$cantidad,$can_mod,$updated_refe);
                        }else{
                            /*************************************
                            Si no, llamamos al metodo "validarActualizacionCantidadDisponibleReferencia()" para que actualice la referencia en el modulo inicialmente registrados.
                            LLmamos al metodo "validarActualizacionCantidadDisponibleReferenciaNew()" para actualice la nueva cantidad disponible de la referencia y modulo recibidos del "Request".
                            *************************************/
                            $this->validarActualizacionCantidadDisponibleReferencia($modulo,$id_refe,$cant_ref,$cantidad,$updated_refe);
                            $this->validarActualizacionCantidadDisponibleReferenciaNew($modulo,$can_mod,$cant_ref_new,$updated_refe);
                        }
                        /*************************************
                        Hacemos un update de todos los datos recibidos del "Request" en el "id" del registro.
                        Se retornará el valor de "1" que hace referencia a "true". En la respuesta de la peticion ajax se mostrara un mensaje "success" cuando el valor develto sea 1.
                        *************************************/
                        DB::table('ensamble')->where('id','=',$id)->update(['fecha'=>$fecha, 'turno'=>$turno, 'modulo'=>$modulo, 'id_empleado'=>$id_empl, 'id_referencia'=>$id_refe, 'tallas'=>$tallas, 'tc'=>$tc, 'tipo'=>$tipo, 'hora'=>$hora, 'cantidad'=>$cantidad, 'tiempo_req_h'=>$tiempo_r, 'meta_produccion'=>$meta_p, 'eficiencia'=>$eficiencia, 'n_operarios'=>$n_operarios, 'id_parada_prg'=>$tipo_p_prgm, 'id_parada_noprg'=>$tipo_pno_prgm, 'tiempo_noprg'=>$tiempo_pno_prgm, 'updated_at'=>$updated_at]);
                        return response()->json(1);
                    }else{
                        /*************************************
                        Si la referencia seleccionada es diferente a la inicialmente registrada llamamos al metodo "validarActualizacionCantidadDisponibleReferencia()" para que actualice la cantidad disponible de la referencia en el modulo inicialmente registrados.
                        Llamamos al metodo "validarActualizacionCantidadDisponibleReferenciaNew()" para que actualice la cantidad disponible de la referencia en el modulo recibidos del "Request".
                        Se retornará el valor de "1" que hace referencia a "true".En la respuesta de la peticion ajax se mostrara un mensaje "success" cuando el valor develto sea 1.
                        *************************************/
                        $this->validarActualizacionCantidadDisponibleReferencia($modulo,$id_refe,$cant_ref,$cantidad,$updated_refe);
                        $this->validarActualizacionCantidadDisponibleReferenciaNew($modulo,$can_mod,$cant_ref_new,$updated_refe);
                        DB::table('ensamble')->where('id','=',$id)->update(['fecha'=>$fecha, 'turno'=>$turno, 'modulo'=>$modulo, 'id_empleado'=>$id_empl, 'id_referencia'=>$id_refe, 'tallas'=>$tallas, 'tc'=>$tc, 'tipo'=>$tipo, 'hora'=>$hora, 'cantidad'=>$cantidad, 'tiempo_req_h'=>$tiempo_r, 'meta_produccion'=>$meta_p, 'eficiencia'=>$eficiencia, 'n_operarios'=>$n_operarios, 'id_parada_prg'=>$tipo_p_prgm, 'id_parada_noprg'=>$tipo_pno_prgm, 'tiempo_noprg'=>$tiempo_pno_prgm, 'updated_at'=>$updated_at]);
                        return response()->json(1);
                    }
                }
        }else{
            /*************************************
            Si no hay registros en la BD, validamos si la referencia selecionada es igual a la inicialmente registrada.
            *************************************/
            if($id_refe==$can_mod[0]['id_referencia']){
                /*************************************
                Validamos si el modulo seleccionado es igual al inicialmente registrado.
                *************************************/
                if($modulo == $can_mod[0]['modulo']){
                    /*************************************
                    Si es así llamamos al metodo "validarActualizacionCantidadDisponibleReferenciaOld()" para que actualice la nueva cantidad disponible de la referencia y modulo recibidos del "Request".
                    *************************************/
                    $this->validarActualizacionCantidadDisponibleReferenciaOld($modulo,$id_refe,$cant_ref,$cantidad,$can_mod,$updated_refe);
                }else{
                    /*************************************
                    Si no, llamamos al metodo "validarActualizacionCantidadDisponibleReferencia()" para que actualice la referencia en el modulo inicialmente registrados.
                    LLmamos al metodo "validarActualizacionCantidadDisponibleReferenciaNew()" para actualice la nueva cantidad disponible de la referencia y modulo recibidos del "Request".
                    *************************************/
                    $this->validarActualizacionCantidadDisponibleReferencia($modulo,$id_refe,$cant_ref,$cantidad,$updated_refe);
                    $this->validarActualizacionCantidadDisponibleReferenciaNew($modulo,$can_mod,$cant_ref_new,$updated_refe);
                }
                /*************************************
                Hacemos un update de todos los datos recibidos del "Request" en el "id" del registro.
                Se retornará el valor de "1" que hace referencia a "true". En la respuesta de la peticion ajax se mostrara un mensaje "success" cuando el valor develto sea 1.
                *************************************/
                DB::table('ensamble')->where('id','=',$id)->update(['fecha'=>$fecha, 'turno'=>$turno, 'modulo'=>$modulo, 'id_empleado'=>$id_empl, 'id_referencia'=>$id_refe, 'tallas'=>$tallas, 'tc'=>$tc, 'tipo'=>$tipo, 'hora'=>$hora, 'cantidad'=>$cantidad, 'tiempo_req_h'=>$tiempo_r, 'meta_produccion'=>$meta_p, 'eficiencia'=>$eficiencia, 'n_operarios'=>$n_operarios, 'id_parada_prg'=>$tipo_p_prgm, 'id_parada_noprg'=>$tipo_pno_prgm, 'tiempo_noprg'=>$tiempo_pno_prgm, 'updated_at'=>$updated_at]);
                return response()->json(1);
            }else{
                /*************************************
                Si la referencia seleccionada es diferente a la inicialmente registrada llamamos al metodo "validarActualizacionCantidadDisponibleReferencia()" para que actualice la cantidad disponible de la referencia en el modulo inicialmente registrados.
                Llamamos al metodo "validarActualizacionCantidadDisponibleReferenciaNew()" para que actualice la cantidad disponible de la referencia en el modulo recibidos del "Request".
                Se retornará el valor de "1" que hace referencia a "true".En la respuesta de la peticion ajax se mostrara un mensaje "success" cuando el valor develto sea 1.
                *************************************/
                $this->validarActualizacionCantidadDisponibleReferenciaNew($modulo,$can_mod,$cant_ref_new,$updated_refe);
                $this->validarActualizacionCantidadDisponibleReferencia($modulo,$id_refe,$cant_ref,$cantidad,$updated_refe);
                DB::table('ensamble')->where('id','=',$id)->update(['fecha'=>$fecha, 'turno'=>$turno, 'modulo'=>$modulo, 'id_empleado'=>$id_empl, 'id_referencia'=>$id_refe, 'tallas'=>$tallas, 'tc'=>$tc, 'tipo'=>$tipo, 'hora'=>$hora, 'cantidad'=>$cantidad, 'tiempo_req_h'=>$tiempo_r, 'meta_produccion'=>$meta_p, 'eficiencia'=>$eficiencia, 'n_operarios'=>$n_operarios, 'id_parada_prg'=>$tipo_p_prgm, 'id_parada_noprg'=>$tipo_pno_prgm, 'tiempo_noprg'=>$tiempo_pno_prgm, 'updated_at'=>$updated_at]);
                return response()->json(1);
            }
        }
    }

    private function validarActualizacionCantidadDisponibleReferenciaNew($modulo,$can_mod,$cant_ref_new,$updated_refe)
    {
        if($can_mod[0]['modulo'] == "Pretina"){
            $new_cant_new = $can_mod[0]['cantidad']+$cant_ref_new[0]['cantidad_disponible_ensamble_prt'];
            DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->update(['cantidad_disponible_ensamble_prt'=>$new_cant_new, 'updated_at'=>$updated_refe]);
            }
        elseif($can_mod[0]['modulo'] == "Punta"){
            $new_cant_new = $can_mod[0]['cantidad']+$cant_ref_new[0]['cantidad_disponible_ensamble_pnt'];
            DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->update(['cantidad_disponible_ensamble_pnt'=>$new_cant_new, 'updated_at'=>$updated_refe]);
            }
        elseif($can_mod[0]['modulo'] == "Bota"){
            $new_cant_new = $can_mod[0]['cantidad']+$cant_ref_new[0]['cantidad_disponible_ensamble_bot'];
            DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->update(['cantidad_disponible_ensamble_bot'=>$new_cant_new, 'updated_at'=>$updated_refe]);
            }
        elseif($can_mod[0]['modulo'] == "Bota Plana"){
            $new_cant_new = $can_mod[0]['cantidad']+$cant_ref_new[0]['cantidad_disponible_ensamble_bot_pln'];
            DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->update(['cantidad_disponible_ensamble_bot_pln'=>$new_cant_new, 'updated_at'=>$updated_refe]);
            }
        elseif($can_mod[0]['modulo'] == "Presilla"){
            $new_cant_new = $can_mod[0]['cantidad']+$cant_ref_new[0]['cantidad_disponible_ensamble_prs'];
            DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->update(['cantidad_disponible_ensamble_prs'=>$new_cant_new, 'updated_at'=>$updated_refe]);
            }
        elseif($can_mod[0]['modulo'] == "Pasador Presilla"){
            $new_cant_new = $can_mod[0]['cantidad']+$cant_ref_new[0]['cantidad_disponible_ensamble_pas_prs'];
            DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->update(['cantidad_disponible_ensamble_pas_prs'=>$new_cant_new, 'updated_at'=>$updated_refe]);
            }
        elseif($can_mod[0]['modulo'] == "Pasador Mol"){
            $new_cant_new = $can_mod[0]['cantidad']+$cant_ref_new[0]['cantidad_disponible_ensamble_pas_mol'];
            DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->update(['cantidad_disponible_ensamble_pas_mol'=>$new_cant_new, 'updated_at'=>$updated_refe]);
            }
        elseif($can_mod[0]['modulo'] == "Ojal"){
            $new_cant_new = $can_mod[0]['cantidad']+$cant_ref_new[0]['cantidad_disponible_ensamble_ojal'];
            DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->update(['cantidad_disponible_ensamble_ojal'=>$new_cant_new, 'updated_at'=>$updated_refe]);
            }
        elseif($can_mod[0]['modulo'] == "Revision"){
            $new_cant_new = $can_mod[0]['cantidad']+$cant_ref_new[0]['cantidad_disponible_ensamble_rvs'];
            DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->update(['cantidad_disponible_ensamble_rvs'=>$new_cant_new, 'updated_at'=>$updated_refe]);
            }
        elseif($can_mod[0]['modulo'] == "Revision Ext"){
            $new_cant_new = $can_mod[0]['cantidad']+$cant_ref_new[0]['cantidad_disponible_ensamble_rvs_ext'];
            DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->update(['cantidad_disponible_ensamble_rvs_ext'=>$new_cant_new, 'updated_at'=>$updated_refe]);
            }
        elseif($can_mod[0]['modulo'] == "Revision Presilla"){
            $new_cant_new = $can_mod[0]['cantidad']+$cant_ref_new[0]['cantidad_disponible_ensamble_rvs_prs'];
            DB::table('referencias')->where('id','=',$can_mod[0]['id_referencia'])->update(['cantidad_disponible_ensamble_rvs_prs'=>$new_cant_new, 'updated_at'=>$updated_refe]);
            }
    }

    private function validarActualizacionCantidadDisponibleReferenciaOld($modulo,$id_refe,$cant_ref,$cantidad,$can_mod,$updated_refe)
    {
        if($modulo == "Pretina"){
            $new_cant = ($cant_ref[0]['cantidad_disponible_ensamble_prt']+$can_mod[0]['cantidad'])-$cantidad;
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_ensamble_prt'=>$new_cant, 'updated_at'=>$updated_refe]);
            }
        elseif($modulo == "Punta"){
            $new_cant = ($cant_ref[0]['cantidad_disponible_ensamble_pnt']+$can_mod[0]['cantidad'])-$cantidad;
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_ensamble_pnt'=>$new_cant, 'updated_at'=>$updated_refe]);
            }
        elseif($modulo == "Bota"){
            $new_cant = ($cant_ref[0]['cantidad_disponible_ensamble_bot']+$can_mod[0]['cantidad'])-$cantidad;
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_ensamble_bot'=>$new_cant, 'updated_at'=>$updated_refe]);
            }
        elseif($modulo == "Bota Plana"){
            $new_cant = ($cant_ref[0]['cantidad_disponible_ensamble_bot_pln']+$can_mod[0]['cantidad'])-$cantidad;
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_ensamble_bot_pln'=>$new_cant, 'updated_at'=>$updated_refe]);
            }
        elseif($modulo == "Presilla"){
            $new_cant = ($cant_ref[0]['cantidad_disponible_ensamble_prs']+$can_mod[0]['cantidad'])-$cantidad;
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_ensamble_prs'=>$new_cant, 'updated_at'=>$updated_refe]);
            }
        elseif($modulo == "Pasador Presilla"){
            $new_cant = ($cant_ref[0]['cantidad_disponible_ensamble_pas_prs']+$can_mod[0]['cantidad'])-$cantidad;
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_ensamble_pas_prs'=>$new_cant, 'updated_at'=>$updated_refe]);
            }
        elseif($modulo == "Pasador Mol"){
            $new_cant = ($cant_ref[0]['cantidad_disponible_ensamble_pas_mol']+$can_mod[0]['cantidad'])-$cantidad;
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_ensamble_pas_mol'=>$new_cant, 'updated_at'=>$updated_refe]);
            }
        elseif($modulo == "Ojal"){
            $new_cant = ($cant_ref[0]['cantidad_disponible_ensamble_ojal']+$can_mod[0]['cantidad'])-$cantidad;
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_ensamble_ojal'=>$new_cant, 'updated_at'=>$updated_refe]);
            }
        elseif($modulo == "Revision"){
            $new_cant = ($cant_ref[0]['cantidad_disponible_ensamble_rvs']+$can_mod[0]['cantidad'])-$cantidad;
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_ensamble_rvs'=>$new_cant, 'updated_at'=>$updated_refe]);
            }
        elseif($modulo == "Revision Ext"){
            $new_cant = ($cant_ref[0]['cantidad_disponible_ensamble_rvs_ext']+$can_mod[0]['cantidad'])-$cantidad;
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_ensamble_rvs_ext'=>$new_cant, 'updated_at'=>$updated_refe]);
            }
        elseif($modulo == "Revision Presilla"){
            $new_cant = ($cant_ref[0]['cantidad_disponible_ensamble_rvs_prs']+$can_mod[0]['cantidad'])-$cantidad;
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_ensamble_rvs_prs'=>$new_cant, 'updated_at'=>$updated_refe]);
            }  
    }

    private function validarActualizacionCantidadDisponibleReferencia($modulo,$id_refe,$cant_ref,$cantidad,$updated_refe)
    {
        if($modulo == "Pretina"){
            $new_cant = $cant_ref[0]['cantidad_disponible_ensamble_prt']-$cantidad;
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_ensamble_prt'=>$new_cant, 'updated_at'=>$updated_refe]);
            }
        elseif($modulo == "Punta"){
            $new_cant = $cant_ref[0]['cantidad_disponible_ensamble_pnt']-$cantidad;
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_ensamble_pnt'=>$new_cant, 'updated_at'=>$updated_refe]);
            }
        elseif($modulo == "Bota"){
            $new_cant = $cant_ref[0]['cantidad_disponible_ensamble_bot']-$cantidad;
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_ensamble_bot'=>$new_cant, 'updated_at'=>$updated_refe]);
            }
        elseif($modulo == "Bota Plana"){
            $new_cant = $cant_ref[0]['cantidad_disponible_ensamble_bot_pln']-$cantidad;
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_ensamble_bot_pln'=>$new_cant, 'updated_at'=>$updated_refe]);
            }
        elseif($modulo == "Presilla"){
            $new_cant = $cant_ref[0]['cantidad_disponible_ensamble_prs']-$cantidad;
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_ensamble_prs'=>$new_cant, 'updated_at'=>$updated_refe]);
            }
        elseif($modulo == "Pasador Presilla"){
            $new_cant = $cant_ref[0]['cantidad_disponible_ensamble_pas_prs']-$cantidad;
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_ensamble_pas_prs'=>$new_cant, 'updated_at'=>$updated_refe]);
            }
        elseif($modulo == "Pasador Mol"){
            $new_cant = $cant_ref[0]['cantidad_disponible_ensamble_pas_mol']-$cantidad;
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_ensamble_pas_mol'=>$new_cant, 'updated_at'=>$updated_refe]);
            }
        elseif($modulo == "Ojal"){
            $new_cant = $cant_ref[0]['cantidad_disponible_ensamble_ojal']-$cantidad;
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_ensamble_ojal'=>$new_cant, 'updated_at'=>$updated_refe]);
            }
        elseif($modulo == "Revision"){
            $new_cant = $cant_ref[0]['cantidad_disponible_ensamble_rvs']-$cantidad;
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_ensamble_rvs'=>$new_cant, 'updated_at'=>$updated_refe]);
            }
        elseif($modulo == "Revision Ext"){
            $new_cant = $cant_ref[0]['cantidad_disponible_ensamble_rvs_ext']-$cantidad;
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_ensamble_rvs_ext'=>$new_cant, 'updated_at'=>$updated_refe]);
            }
        elseif($modulo == "Revision Presilla"){
            $new_cant = $cant_ref[0]['cantidad_disponible_ensamble_rvs_prs']-$cantidad;
            DB::table('referencias')->where('id','=',$id_refe)->update(['cantidad_disponible_ensamble_rvs_prs'=>$new_cant, 'updated_at'=>$updated_refe]);
            }
    }
    
    public function delete_ensamble($id)
    {
        $ensamble = DB::table('ensamble')->where('id','=',$id)->get();
        $refe = DB::table('referencias')->where('id','=',$ensamble[0]->id_referencia)->get();
        if($ensamble[0]->modulo == "Pretina"){
            DB::table('referencias')->where('id','=',$ensamble[0]->id_referencia)->update(['cantidad_disponible_ensamble_prt'=>$refe[0]->cantidad_disponible_ensamble_prt+$ensamble[0]->cantidad]);
        }elseif($ensamble[0]->modulo == "Punta"){
            DB::table('referencias')->where('id','=',$ensamble[0]->id_referencia)->update(['cantidad_disponible_ensamble_pnt'=>$refe[0]->cantidad_disponible_ensamble_pnt+$ensamble[0]->cantidad]);
        }elseif($ensamble[0]->modulo == "Bota"){
            DB::table('referencias')->where('id','=',$ensamble[0]->id_referencia)->update(['cantidad_disponible_ensamble_bot'=>$refe[0]->cantidad_disponible_ensamble_bot+$ensamble[0]->cantidad]);
        }elseif($ensamble[0]->modulo == "Bota Plana"){
            DB::table('referencias')->where('id','=',$ensamble[0]->id_referencia)->update(['cantidad_disponible_ensamble_bot_pln'=>$refe[0]->cantidad_disponible_ensamble_bot_pln+$ensamble[0]->cantidad]);
        }elseif($ensamble[0]->modulo == "Presilla"){
            DB::table('referencias')->where('id','=',$ensamble[0]->id_referencia)->update(['cantidad_disponible_ensamble_prs'=>$refe[0]->cantidad_disponible_ensamble_prs+$ensamble[0]->cantidad]);
        }elseif($ensamble[0]->modulo == "Pasador Presilla"){
            DB::table('referencias')->where('id','=',$ensamble[0]->id_referencia)->update(['cantidad_disponible_ensamble_pas_prs'=>$refe[0]->cantidad_disponible_ensamble_pas_prs+$ensamble[0]->cantidad]);
        }elseif($ensamble[0]->modulo == "Pasador Mol"){
            DB::table('referencias')->where('id','=',$ensamble[0]->id_referencia)->update(['cantidad_disponible_ensamble_pas_mol'=>$refe[0]->cantidad_disponible_ensamble_pas_mol+$ensamble[0]->cantidad]);
        }elseif($ensamble[0]->modulo == "Ojal"){
            DB::table('referencias')->where('id','=',$ensamble[0]->id_referencia)->update(['cantidad_disponible_ensamble_ojal'=>$refe[0]->cantidad_disponible_ensamble_ojal+$ensamble[0]->cantidad]);
        }elseif($ensamble[0]->modulo == "Revision"){
            DB::table('referencias')->where('id','=',$ensamble[0]->id_referencia)->update(['cantidad_disponible_ensamble_rvs'=>$refe[0]->cantidad_disponible_ensamble_rvs+$ensamble[0]->cantidad]);
        }elseif($ensamble[0]->modulo == "Revision Ext"){
            DB::table('referencias')->where('id','=',$ensamble[0]->id_referencia)->update(['cantidad_disponible_ensamble_rvs_ext'=>$refe[0]->cantidad_disponible_ensamble_rvs_ext+$ensamble[0]->cantidad]);
        }elseif($ensamble[0]->modulo == "Revision Presilla"){
            DB::table('referencias')->where('id','=',$ensamble[0]->id_referencia)->update(['cantidad_disponible_ensamble_rvs_prs'=>$refe[0]->cantidad_disponible_ensamble_rvs_prs+$ensamble[0]->cantidad]);
        }
        DB::table('ensamble')->where('id','=',$id)->delete();
        return redirect()->route('list_ensamble_hoy');
    }

    public function eficiencia($id)
    {
        /*************************************
        Se hace consulta a la BD para traer registros cuando el id sea igual al "id" recibido.
        De ahí optenemos la fecha y el turno.
        *************************************/
        $consulta_fecha = DB::table('ensamble')->where('id','=',$id)->get();
        $consulta = json_decode($consulta_fecha,true);
        /*************************************
        Con la fecha y el turno hacemos una nueva consulta a la BD para que traigan todos los registros con esa fecha y turno resgistrados.
        *************************************/
        $eficiencia_hoy = DB::table('ensamble')->where('fecha','=',$consulta[0]['fecha'])->where('turno','=',$consulta[0]['turno'])->get();
        $array = json_decode($eficiencia_hoy,true);
        /*************************************
        Con la fecha y el turno hacemos una nueva consulta a la BD para que traigan todos los registros con esa fecha y turno resgistrados pero esta vez agrupados por empleado.
        *************************************/
        $empleados = DB::select('select id_empleado FROM ensamble WHERE turno = '.$consulta[0]['turno'].' and fecha = "'.$consulta[0]['fecha'].'" GROUP BY id_empleado HAVING COUNT(*)>0');
        $array_per = [];
        /*************************************
        Inicializamos un array para almacenar las eficiencias por empleado.
        Creamos un ciclo para que compare empleado por empleado.
        *************************************/
        foreach($empleados as $empleado){
        /*************************************
        Creamos 4 variables. En meta la suma total de meta de produccion de ese empleado en esa fecha y turno. En cantidad la suma total de la cantidad producida por el empleado.
        En eficiecia la divison de la cantidad producida sobre la meta de produccion. En color se asignará un color dependiendo de la eficiencia.
        En operario se almacenaran los nombres y apellidos del empleado.
        *************************************/
        $meta = 0;
        $cantidad = 0;
        $eficiencia = 0;
        $color = "";
        $operario = "";
        /*************************************
        El ciclo mirara todos los registros obtenidos de la primera consulta, cuando el empleado sea igual al que se muestra en el primer ciclo irá actualizando los datos de las variables.
        *************************************/
            for($i=0;$i<count($array);$i++){
                if($array[$i]['id_empleado'] == $empleado->id_empleado){
                    $meta += $array[$i]['meta_produccion'];
                    $cantidad += $array[$i]['cantidad'];
                }
            }
            /*************************************
            Calculamos eficicencia. Si es mayor igual a 0 y menor a 70 el color asignado será rojo. Si es mayor igual a 70 y menor a 80 el color asignado será amarillo.
            Si es mayor igual a 80 y menor a 100 el color asignado será verde. Si es mayor igual a 100 el color asignado será azul.
            *************************************/
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
            /*************************************
            Consultamos a otra base de datos los nombres y apellidos del empelado.
            *************************************/
            $operario = DB::select('SELECT zarethpr_tiendas.clientes.nombres,zarethpr_tiendas.clientes.apellidos from zarethpr_tiendas.clientes WHERE '.$empleado->id_empleado.'=zarethpr_tiendas.clientes.id');
            /*************************************
            Insertamos un array al array creado incialmente. Los datos del array serán "Empl" -> Nombres y Apellidos, "Efic" -> Eficiencia del empleado, "Color" -> Color según la eficiencia.
            *************************************/
            array_push($array_per, array(
                "Empl" => $operario[0]->nombres." ".$operario[0]->apellidos,
                "Efic" => round($eficiencia, 2),
                "Color" => $color
                )
            );            
        } 
        /*************************************
        Creamos un array de todos los modulos del proceso de Ensamble.
        *************************************/
        $modulos = ["Pretina","Punta","Bota","Bota Plana","Presilla","Pasador Presilla","Pasador Mol","Ojal","Revision","Revision Ext","Revision Presilla"];
        $array_mod = [];
        /*************************************
        Inicializamos un array para almacenar las eficiencias por modulo.
        Creamos un ciclo para que compare modulo por modulo.
        *************************************/
        foreach($modulos as $modulo){
        /*************************************
        Creamos 4 variables. En meta la suma total de meta de produccion de ese modulo en esa fecha y turno. En cantidad la suma total de la cantidad producida en el modulo.
        En eficiencia la divison de la cantidad producida sobre la meta de produccion. En color se asignará un color dependiendo de la eficiencia.
        *************************************/
        $meta = 0;
        $cantidad = 0;
        $eficiencia = 0;
        $color = "#F44336";
        /*************************************
        El ciclo mirara todos los registros obtenidos de la primera consulta, cuando el modulo sea igual al que se muestra en el primer ciclo irá actualizando los datos de las variables.
        *************************************/
            for($i=0;$i<count($array);$i++){
                if($array[$i]['modulo'] == $modulo){
                    $meta += $array[$i]['meta_produccion'];
                    $cantidad += $array[$i]['cantidad'];
                }
            }
            /*************************************
            Validamos si meta produccion es distinto a 0 ya que no podemos dividir entre 0.
            Calculamos eficicencia. Si es mayor igual a 0 y menor a 70 el color asignado será rojo. Si es mayor igual a 70 y menor a 80 el color asignado será amarillo.
            Si es mayor igual a 80 y menor a 100 el color asignado será verde. Si es mayor igual a 100 el color asignado será azul.
            *************************************/
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
            /*************************************
            Insertamos un array al array creado incialmente. Los datos del array serán "Mod" -> Nombre del Modulo, "Meta" -> Meta de produccion,
            "Cant" -> Cantidad porducida en ese modulo, "Efic" -> Eficiencia del modulo, "Color" -> Color según la eficiencia.
            *************************************/
            array_push($array_mod, array(
                "Mod" => $modulo,
                "Meta" => $meta,
                "Cant" => $cantidad,
                "Efic" => round($eficiencia, 2),
                "Color" => $color
                )
            );            
        } 
        return view('ensamble.eficiencia')->with('array_per',$array_per)->with('array_mod',$array_mod);
    }

    public function consulta_lote(Request $request)
    {   
        $cantidad = $request->get('cantidad');
        $id_refe = $request->get('id_refe');
        $modulo = $request->get('modulo');
        $consulta_refe = DB::table('referencias')->where('id','=',$id_refe)->get();
        $consulta = json_decode($consulta_refe,true);
        $cons = 0;
        $disp = 0;

        $response = $this->consultarLoteDisponible($modulo,$consulta,$cantidad);

        if($response[0]>=0){
            return response()->json([1,$cantidad,$response[1],$response[0]]);
        }else{
            return response()->json([2,$cantidad,$response[1],$response[0]]);
        }
    }

    public function consulta_lote_new(Request $request)
    {   
        /*************************************
        Este metodo de consulta es unicamente para la vista de edición.
        Se guardan en variables los datos recibidos del "Request". Los parametros que se reciben son cantidad, id referencia, id del registro que estamos modificando y modulo.
        *************************************/
        $cantidad = $request->get('cantidad');
        $id_refe = $request->get('id_refe');
        $id = $request->get('id');
        $modulo = $request->get('modulo');
        /*************************************
        Consultamos a la BD el registro del "id" del registro que estamos modificando que recibimos del "Request".
        *************************************/
        $cant_mod = DB::table('ensamble')->where('id','=',$id)->get();
        $can_mod = json_decode($cant_mod,true);
        /*************************************
        Consultamos a la BD la referencia del "id referencia" que recibimos del "Request".
        *************************************/
        $consulta_refe = DB::table('referencias')->where('id','=',$id_refe)->get();
        $consulta = json_decode($consulta_refe,true);
        $disp = 0;
        $cons = 0;
        /*************************************
        Validamos si la referencia recibida del "Request" es igual a la referencia inicialmente registrado.
        *************************************/
        if($id_refe==$can_mod[0]['id_referencia']){
            /*************************************
            Validamos si el modulo recibido del "Request" es igual al modulo inicialmente registrado.
            *************************************/
            if($modulo == $can_mod[0]['modulo']){
                /*************************************
                Si es el mismo modulo llamamos al metodo y pasamos los parametros para que calcule la nueva cantidad disponible.
                *************************************/
                $response = $this->colsultarLoteDisponibleNew($modulo,$consulta,$can_mod,$cantidad);
            }else{
                /*************************************
                Si no es el mismo modulo llamamos al metodo y pasamos los parametros para que calcule la cantidad disponible.
                *************************************/
                $response = $this->consultarLoteDisponible($modulo,$consulta,$cantidad);
            }
            /*************************************
            Validamos si el valor dispoble es mayor igual a 0. Si es así retornamos "1" que es equivalente a "true", si no retornamos "2" que es equivalente a "false".
            Enviamos la cantidad ingresada, la cantidad disponible actualmente y cual será la nueva cantidad.
            *************************************/
            if($disp>=0){
                return response()->json([1,$cantidad,$response[1],$response[0]]);
            }else{
                return response()->json([2,$cantidad,$response[1],$response[0]]);
            }
        /*************************************
        Ya validada que la referencia no es la misma a la inicial procedemos a consultar el lote disponible de la nueva referencia.
        *************************************/
        }else{
            /*************************************
            LLamamos al metodo y pasamos los parametros para que consulte la cantidad disponible de la nueva referencia seleccionada.
            *************************************/
            $response = $this->consultarLoteDisponible($modulo,$consulta,$cantidad);
            /*************************************
            Validamos si el valor dispoble es mayor igual a 0. Si es así retornamos "1" que es equivalente a "true", si no retornamos "2" que es equivalente a "false".
            Enviamos la cantidad ingresada, la cantidad disponible actualmente y cual será la nueva cantidad.
            *************************************/
            if($disp>=0){
                return response()->json([1,$cantidad,$response[1],$response[0]]);
            }else{
                return response()->json([2,$cantidad,$response[1],$response[0]]);
            }
        }
    }

    private function consultarLoteDisponible($modulo,$consulta,$cantidad)
    {
        /*************************************
        Con los parametros recibidos validará si cumple alguna de las condiciones para consultar la cantidad disponible.
        Selecciona el valor disponible del modulo y le resta la cantidad recibida del "Request" para así hacer el calculo.
        *************************************/
        if($modulo == "Pretina"){
            $disp = $consulta[0]['cantidad_disponible_ensamble_prt']-$cantidad;
            $cons = $consulta[0]['cantidad_disponible_ensamble_prt'];
        }
        if($modulo == "Punta"){
            $disp = $consulta[0]['cantidad_disponible_ensamble_pnt']-$cantidad;
            $cons = $consulta[0]['cantidad_disponible_ensamble_pnt'];
        }
        if($modulo == "Bota"){
            $disp = $consulta[0]['cantidad_disponible_ensamble_bot']-$cantidad;
            $cons = $consulta[0]['cantidad_disponible_ensamble_bot'];
        }
        if($modulo == "Bota Plana"){
            $disp = $consulta[0]['cantidad_disponible_ensamble_bot_pln']-$cantidad;
            $cons = $consulta[0]['cantidad_disponible_ensamble_bot_pln'];
        }
        if($modulo == "Presilla"){
            $disp = $consulta[0]['cantidad_disponible_ensamble_prs']-$cantidad;
            $cons = $consulta[0]['cantidad_disponible_ensamble_prs'];
        }
        if($modulo == "Pasador Presilla"){
            $disp = $consulta[0]['cantidad_disponible_ensamble_pas_prs']-$cantidad;
            $cons = $consulta[0]['cantidad_disponible_ensamble_pas_prs'];
        }
        if($modulo == "Pasador Mol"){
            $disp = $consulta[0]['cantidad_disponible_ensamble_pas_mol']-$cantidad;
            $cons = $consulta[0]['cantidad_disponible_ensamble_pas_mol'];
        }
        if($modulo == "Ojal"){
            $disp = $consulta[0]['cantidad_disponible_ensamble_ojal']-$cantidad;
            $cons = $consulta[0]['cantidad_disponible_ensamble_ojal'];
        }
        if($modulo == "Revision"){
            $disp = $consulta[0]['cantidad_disponible_ensamble_rvs']-$cantidad;
            $cons = $consulta[0]['cantidad_disponible_ensamble_rvs'];
        }
        if($modulo == "Revision Ext"){
            $disp = $consulta[0]['cantidad_disponible_ensamble_rvs_ext']-$cantidad;
            $cons = $consulta[0]['cantidad_disponible_ensamble_rvs_ext'];
        }
        if($modulo == "Revision Presilla"){
            $disp = $consulta[0]['cantidad_disponible_ensamble_rvs_prs']-$cantidad;
            $cons = $consulta[0]['cantidad_disponible_ensamble_rvs_prs'];
        }

        return array($disp,$cons);
    }

    private function colsultarLoteDisponibleNew($modulo,$consulta,$can_mod,$cantidad)
    {
        /*************************************
        Con los parametros recibidos validará si cumple alguna de las condiciones para consultar la cantidad disponible.
        Selecciona el valor disponible del modulo, le suma la cantidad ingresada inicialmente en el registro y le resta la cantidad recibida del "Request" para así hacer el calculo.
        *************************************/
        if($modulo == "Pretina"){
            $disp = ($consulta[0]['cantidad_disponible_ensamble_prt']+$can_mod[0]['cantidad'])-$cantidad;
            $cons = $consulta[0]['cantidad_disponible_ensamble_prt'];
        }
        if($modulo == "Punta"){
            $disp = ($consulta[0]['cantidad_disponible_ensamble_pnt']+$can_mod[0]['cantidad'])-$cantidad;
            $cons = $consulta[0]['cantidad_disponible_ensamble_pnt'];
        }
        if($modulo == "Bota"){
            $disp = ($consulta[0]['cantidad_disponible_ensamble_bot']+$can_mod[0]['cantidad'])-$cantidad;
            $cons = $consulta[0]['cantidad_disponible_ensamble_bot'];
        }
        if($modulo == "Bota Plana"){
            $disp = ($consulta[0]['cantidad_disponible_ensamble_bot_pln']+$can_mod[0]['cantidad'])-$cantidad;
            $cons = $consulta[0]['cantidad_disponible_ensamble_bot_pln'];
        }
        if($modulo == "Presilla"){
            $disp = ($consulta[0]['cantidad_disponible_ensamble_prs']+$can_mod[0]['cantidad'])-$cantidad;
            $cons = $consulta[0]['cantidad_disponible_ensamble_prs'];
        }
        if($modulo == "Pasador Presilla"){
            $disp = ($consulta[0]['cantidad_disponible_ensamble_pas_prs']+$can_mod[0]['cantidad'])-$cantidad;
            $cons = $consulta[0]['cantidad_disponible_ensamble_pas_prs'];
        }
        if($modulo == "Pasador Mol"){
            $disp = ($consulta[0]['cantidad_disponible_ensamble_pas_mol']+$can_mod[0]['cantidad'])-$cantidad;
            $cons = $consulta[0]['cantidad_disponible_ensamble_pas_mol'];
        }
        if($modulo == "Ojal"){
            $disp = ($consulta[0]['cantidad_disponible_ensamble_ojal']+$can_mod[0]['cantidad'])-$cantidad;
            $cons = $consulta[0]['cantidad_disponible_ensamble_ojal'];
        }
        if($modulo == "Revision"){
            $disp = ($consulta[0]['cantidad_disponible_ensamble_rvs']+$can_mod[0]['cantidad'])-$cantidad;
            $cons = $consulta[0]['cantidad_disponible_ensamble_rvs'];
        }
        if($modulo == "Revision Ext"){
            $disp = ($consulta[0]['cantidad_disponible_ensamble_rvs_ext']+$can_mod[0]['cantidad'])-$cantidad;
            $cons = $consulta[0]['cantidad_disponible_ensamble_rvs_ext'];
        }
        if($modulo == "Revision Presilla"){
            $disp = ($consulta[0]['cantidad_disponible_ensamble_rvs_prs']+$can_mod[0]['cantidad'])-$cantidad;
            $cons = $consulta[0]['cantidad_disponible_ensamble_rvs_prs'];
        }

        return array($disp,$cons);
    }
}
