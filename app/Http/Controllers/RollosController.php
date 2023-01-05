<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Telas;
use File;

class RollosController extends Controller
{
    public function index()
    {
        $rollos = DB::table('rollos')->get();
        return view('rollos.tabla_rollos')->with('rollos',$rollos);
    }
    
    public function index_disponibles()
    {
        $rollos = DB::select('select tela, SUM(metros) as metros_totales FROM rollos WHERE salida=0 and estado=0 GROUP BY tela HAVING COUNT(*)>0');
        return view('rollos.tabla_rollos_disponibles')->with('rollos',$rollos);
    }
    
    public function disponibles_consulta(Request $request)
    {
        $tela = $request->get('tela');
        $rollos = DB::table('rollos')->where('tela','=',$tela)->where('estado','=',0)->where('salida','=',0)->get();
        return response()->json($rollos);
    }

    public function create()
    {
        $telas = DB::select('select * from telas order by tela asc');
        return view('rollos.form_rollos')->with('telas',$telas);
    }

    public function store(Request $request)
    {
        $created_at = Carbon::now();
        $proveedor = strtoupper($request->get('proveedor'));
        $fecha_e = $request->get('fecha_e');
        $tela = strtoupper($request->get('tela'));
        $tipo = strtoupper($request->get('tipo'));
        $rollo = $request->get('rollo');
        $ancho = $request->get('ancho');
        $metros = $request->get('metros');
        $tono = strtoupper($request->get('tono'));
        $fecha_s = $request->get('fecha_s');
        $salida = $request->get('salida');
        $observacion = strtoupper($request->get('observacion'));

        DB::insert('insert into rollos (proveedor, fecha_entrada, tela, tipo, rollo, ancho, metros, tono, fecha_salida, salida, observacion, created_at) values (?,?,?,?,?,?,?,?,?,?,?,?)', [$proveedor,$fecha_e,$tela,$tipo,$rollo,$ancho,$metros,$tono,$fecha_s,$salida,$observacion,$created_at]);
        return response()->json(1);
    }

    public function edit($id)
    {
        $telas = DB::select('select * from telas order by tela asc');
        $rollos = DB::table('rollos')->where('id','=',$id)->get();
        $rollo = json_decode($rollos,true);
        return view('rollos.edit_rollos',compact('rollo','telas'));
    }

    public function update(Request $request, $id)
    {
        $updated_at = Carbon::now();
        $id = $request->get('id');
        $proveedor = strtoupper($request->get('proveedor'));
        $fecha_e = $request->get('fecha_e');
        $tela = strtoupper($request->get('tela'));
        $tipo = strtoupper($request->get('tipo'));
        $rollo = $request->get('rollo');
        $ancho = $request->get('ancho');
        $metros = $request->get('metros');
        $tono = strtoupper($request->get('tono'));
        $fecha_s = $request->get('fecha_s');
        $salida = $request->get('salida');
        $observacion = strtoupper($request->get('observacion'));

        DB::table('rollos')->where('id','=',$id)->update(['proveedor'=>$proveedor,'fecha_entrada'=>$fecha_e,'tela'=>$tela,'tipo'=>$tipo,'rollo'=>$rollo,'ancho'=>$ancho,'metros'=>$metros,'tono'=>$tono,'fecha_salida'=>$fecha_s,'salida'=>$salida,'observacion'=>$observacion,'updated_at'=>$updated_at]);
        return response()->json(1);
    }
    
    public function estado($id)
    {   
        $estadoRollo = DB::table('rollos')->where('id','=',$id)->get();
        //dd($estadoRollo);
        if($estadoRollo[0]->estado == 0){
            DB::table('rollos')->where('id','=',$id)->update(['estado'=>1]);
        };
        if($estadoRollo[0]->estado == 1){
            DB::table('rollos')->where('id','=',$id)->update(['estado'=>0]);
        };
        
        $rollos = DB::table('rollos')->get();
        return redirect()->route('list_rollos')->with('rollos',$rollos);
    }
    
    public function index_telas()
    {
        $telas = DB::table('telas')->get();
        return view('rollos.tabla_telas')->with('telas',$telas);
    }
    
    public function telas_create(Request $request)
    {
        return view('rollos.form_telas');
    }  
    
    public function telas_store(Request $request)
    {
        $datostelas = new Telas();
        $datostelas->codigo = strtoupper($request->codigo);
        $datostelas->tela = strtoupper($request->tela);
        $datostelas->estado = 0;
        $datostelas->save();

        return response()->json($datostelas);
    } 
    
    public function telas_edit($id)
    {
        $tela = DB::table('telas')->where('id','=',$id)->get();
        return view('rollos.edit_telas')->with('tela',$tela);
    }
    
    public function telas_update(Request $request,$id)
    {
        $datostelas = Telas::findOrFail($id);
        $datostelas->codigo = strtoupper($request->codigo);
        $datostelas->tela = strtoupper($request->tela);
        $datostelas->save();
 
        return response()->json($datostelas);
    }
    
    public function estado_telas($id)
    {   
        $estadoTela = DB::table('telas')->where('id','=',$id)->get();
        //dd($estadoRollo);
        if($estadoTela[0]->estado == 0){
            DB::table('telas')->where('id','=',$id)->update(['estado'=>1]);
        };
        if($estadoTela[0]->estado == 1){
            DB::table('telas')->where('id','=',$id)->update(['estado'=>0]);
        };
        
        $telas = DB::table('telas')->get();
        return redirect()->route('list_telas')->with('telas',$telas);
    }
}
