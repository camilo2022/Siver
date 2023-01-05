<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use File;

class PickingAntiguoController extends Controller
{
    public function picking_list(){
        $pickings = DB::table('picking')->get();
        $users = DB::table('users')->get();
        return view('picking.tabla_picking')->with('pickings',$pickings)->with('users',$users);
    }
    
    public function picking_list_hoy(){
        $fecha = Carbon::now();
        $fecha = $fecha->format('Y-m-d');
        $pickings = DB::table('picking')->where('fecha','=',$fecha)->get();
        $users = DB::table('users')->get();
        return view('picking.tabla_picking')->with('pickings',$pickings)->with('users',$users);
    }
    
    public function picking_list_hoy_user(){
        $fecha = Carbon::now();
        $fecha = $fecha->format('Y-m-d');
        $id = Auth::user()->id;
        $pickings = DB::table('picking')->where('fecha','=',$fecha)->where('id_user','=',$id)->get();
        $users = DB::table('users')->get();
        return view('picking.tabla_picking')->with('pickings',$pickings)->with('users',$users);
    }

    public function picking_create()
    {
        return view('picking.picking_form');
    }

    public function picking_store(Request $request)
    {
        $created_at = Carbon::now();
        $tableDinamicArray = $request->get('tableDinamicArray');
        $userid = $request->get('userid');
        for ($i=0;$i<count($tableDinamicArray);$i++){ 
            DB::insert('insert into picking (fecha, referencia, cantidad, id_user, created_at) values (?,?,?,?,?)', [$created_at,$tableDinamicArray[$i][0], $tableDinamicArray[$i][1], $userid, $created_at]);
        }
        return response()->json(1);
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
    
    public function picking_update(Request $request)
    {
        $updated_at = Carbon::now();
        $id = $request->get('id');
        $cantidad = $request->get('cantidad');
        DB::table('picking')->where('id','=',$id)->update(['cantidad'=>$cantidad,'updated_at'=>$updated_at]);
        return response()->json(1);
    }

}
