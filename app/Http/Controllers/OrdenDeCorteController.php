<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OrdenDeCorte;
use App\Models\OrdenDeCorteInformacionTalla;
use App\Models\OrdenDeCorteDetalle;
use App\Models\OrdenDeCorteTallas;
use App\Models\Telas;
use Carbon\Carbon;
use File;
use Illuminate\Support\Facades\Storage;
class OrdenDeCorteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cortes = DB::table('orden_de_cortes')->where('estado','=',0)->get();
        $telas = DB::table('telas')->get();
        return view('ordendecorte.index')->with('cortes',$cortes)->with('telas',$telas);
    }
    
    public function index_inactivas()
    {
        $cortes = DB::table('orden_de_cortes')->where('estado','=',1)->get();
        $telas = DB::table('telas')->get();
        return view('ordendecorte.index')->with('cortes',$cortes)->with('telas',$telas);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function estado($id)
    {
        $estadoUpdate = OrdenDeCorte::find($id); 
        if($estadoUpdate->estado == 0){
            $estadoUpdate->estado = 1;
            $estadoUpdate->save();
        }
        elseif($estadoUpdate->estado == 1){
            $estadoUpdate->estado = 0;
            $estadoUpdate->save();
        };
        $cortes = OrdenDeCorte::all();
        return redirect()->route('indexC')->with('cortes',$cortes);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /*public function tela(Request $request)
    {
        $datostelas = new Telas();
        $datostelas->codigo = strtoupper($request->codigo);
        $datostelas->tela = strtoupper($request->tela);
        $datostelas->estado = 0;
        $datostelas->save();

        return response()->json($datostelas);
    } */   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $telas=Telas::all();
        $consecutivo = DB::select('select max(ncorte) as consecutivo from orden_de_cortes');
        //dd($consecutivo[0]->consecutivo);
        $newconsecutivo = $consecutivo[0]->consecutivo + 1;
        $rollos = DB::select('select * from rollos order by tela asc');
        $gruporollos = DB::select('select tela FROM rollos GROUP BY tela HAVING COUNT(*)>0');
        return view('ordendecorte.formCorte', compact('telas','newconsecutivo','rollos','gruporollos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        $consecutivo = DB::select('select max(ncorte) as consecutivo from orden_de_cortes');
        //dd($consecutivo[0]->consecutivo);
        $newconsecutivo = $consecutivo[0]->consecutivo + 1;
        $arrayDetalle = [];
        for($i = 1; $i <= 21; $i++){
            array_push($arrayDetalle, array(  #Aquí está la respuesta, usa [] luego del nombre del array.
                "Largo" => $request->get('largo'.$i),
                "Talla" => $request->get('talla'.$i),
                "Cantidad" => $request->get('cantidad'.$i),
                "Informacion" => $request->get('info'.$i),
                ));
        };

        $levels = array_unique(array_column($arrayDetalle, 'Largo'));
        $infoTallas = array();
        foreach($arrayDetalle as $key => $value){ 
        $infoTallas[$levels[array_search($value['Largo'],$levels )]][] = $value ; 
        };

        $Tallas = [];
        for($i = 4; $i <= 24; $i=$i+2){
            array_push($Tallas, $request->get('tallaN'.$i));
        };

        //QUITAR KEYS A UN ARRAY
        /*$result = [];
        foreach($infoTallas as $internal_array) {
            $result = array_merge($result, $internal_array);
        }
        dd($result[0]['Largo']);*/
        //dd(json_encode($request->get('rollos')));

        if($request->hasFile('foto_D') and $request->hasFile('foto_T'))
        {
        $datoscorte = new OrdenDeCorte();
        $datoscorte->coleccion = strtoupper($request->get('coleccion'));
        $datoscorte->ncorte = $newconsecutivo;
        $datoscorte->referencia = strtoupper($request->get('referencia'));
        $datoscorte->letra = strtoupper($request->get('letra'));
        $datoscorte->diseñador = strtoupper($request->get('diseñador'));
        $datoscorte->fecha = $request->get('fecha');
        $datoscorte->nombre = strtoupper($request->get('nombre'));
        $datoscorte->porc = $request->get('porc');
        $datoscorte->id_tela = strtoupper($request->get('tela'));
        $datoscorte->ancho = $request->get('ancho');
        $datoscorte->tela_bolsillo = strtoupper($request->get('tela_bolsillo'));
        $datoscorte->largot2_tela_bolsillo = strtoupper($request->get('largot2_tela_bolsillo'));
        $datoscorte->tendida2_tela_bolsillo = strtoupper($request->get('tendida2_tela_bolsillo'));
        $datoscorte->tela_dos = strtoupper($request->get('tela_dos'));
        $datoscorte->largot2_tela_dos = strtoupper($request->get('largot2_tela_dos'));
        $datoscorte->tendida2_tela_dos = strtoupper($request->get('tendida2_tela_dos'));
        $datoscorte->ribete = $request->get('ribete');
        $datoscorte->trazo_pasadores = $request->get('trazo_pasadores');
        $datoscorte->trazo_aletillones = $request->get('trazo_aletillones');
        $datoscorte->tendidos_1 = $request->get('tendidos_1');
        $datoscorte->tendidos_2 = $request->get('tendidos_2');
        $datoscorte->tendidos_3 = $request->get('tendidos_3');
        $datoscorte->foto_D = $request->file('foto_D')->store('uploads','public');
        $datoscorte->foto_T = $request->file('foto_T')->store('uploads','public');
        $datoscorte->marca = strtoupper($request->get('marca'));
        $datoscorte->especificacion1 = strtoupper($request->get('especificacion1'));
        $datoscorte->especificacion2 = strtoupper($request->get('especificacion2'));
        $datoscorte->info_tallas = json_encode($infoTallas);
        $datoscorte->tallas = json_encode($Tallas);
        $datoscorte->ids_rollos = json_encode($request->rollos);
        $datoscorte->estado = 0;
        $datoscorte->save();
        $updated_at_rollo = Carbon::now();
        $ids_rollos = $request->get('rollos');
        for($i=0;$i<count($ids_rollos);$i++){
            $r = DB::table('rollos')->where('id','=',$ids_rollos[$i])->get();
            DB::table('rollos')->where('id','=',$ids_rollos[$i])->update(['salida'=>$r[0]->salida+1,'fecha_salida'=>$updated_at_rollo,'updated_at'=>$updated_at_rollo]);
        }


        return redirect()->route('indexC');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(OrdenDeCorte $OrdenCorte, $id)
    {
        $OrdenCorte = OrdenDeCorte::findOrFail($id);
        $telas=Telas::all();
        $nametela= DB::table('telas')->where('id','=',$OrdenCorte->id_tela)->get();
        $ntela = json_decode($nametela,true);
        $rollos = DB::select('select * from rollos order by tela asc');
        
        $infoTallas = json_decode($OrdenCorte->info_tallas,true);
            $result = [];
            foreach($infoTallas as $internal_array) {
                $result = array_merge($result, $internal_array);
            } 

            $total = 0;
            for($i=0;$i<=20;$i++){
                $total += $result[$i]['Cantidad'];
            }
            $talla4=0; $talla6=0; $talla8=0; $talla10=0; $talla12=0; $talla14=0; $talla16=0; $talla18=0; $talla20=0; $talla22=0; $talla24=0;
            $sumtallas=0;
            for($i=0;$i<=20;$i++){
                if($result[$i]['Talla'] == 4){
                $talla4 += $result[$i]['Cantidad'];
                }
                if($result[$i]['Talla'] == 6){
                $talla6 += $result[$i]['Cantidad'];
                }
                if($result[$i]['Talla'] == 8){
                $talla8 += $result[$i]['Cantidad'];
                }
                if($result[$i]['Talla'] == 10){
                $talla10 += $result[$i]['Cantidad'];
                }
                if($result[$i]['Talla'] == 12){
                $talla12 += $result[$i]['Cantidad'];
                }
                if($result[$i]['Talla'] == 14){
                $talla14 += $result[$i]['Cantidad'];
                }
                if($result[$i]['Talla'] == 16){
                $talla16 += $result[$i]['Cantidad'];
                }
                if($result[$i]['Talla'] == 18){
                $talla18 += $result[$i]['Cantidad'];
                }
                if($result[$i]['Talla'] == 20){
                $talla20 += $result[$i]['Cantidad'];
                }
                if($result[$i]['Talla'] == 22){
                $talla22 += $result[$i]['Cantidad'];
                }
                if($result[$i]['Talla'] == 24){
                $talla24 += $result[$i]['Cantidad'];
                }
                $sumtallas += $result[$i]['Cantidad'];
            }
            
            $mtrs = 0;
            $largo = 0;
            $cantidad = 0;
            for($i=0;$i<=20;$i++){
                if($result[$i]['Largo'] != $largo || $result[$i]['Cantidad'] != $cantidad){
                    $mtrs += $result[$i]['Largo']*$result[$i]['Cantidad'];
                }
                $largo = $result[$i]['Largo'];
                $cantidad = $result[$i]['Cantidad'];
            }
            $mtrs += $OrdenCorte->ribete*$OrdenCorte->tendidos_1;
            $promedio = $mtrs / $total;
            
            
            $cantcm2 = $OrdenCorte->ancho * 10000 * $promedio;
            $cantcm2 = round($cantcm2,0);
            $Tallas = json_decode($OrdenCorte->tallas,true);
            $sumCantidad2 = array_sum($Tallas);
            $largot2tb = $OrdenCorte->largot2_tela_bolsillo;
            $tendida2tb= $OrdenCorte->tendida2_tela_bolsillo;
            if($largot2tb=="" || $largot2tb==null){
                $largot2tb=0;
            }
            if($tendida2tb=="" || $tendida2tb==null){
                $tendida2tb=0;
            }
            
            $largot2td = $OrdenCorte->largot2_tela_dos;
            $tendida2td= $OrdenCorte->tendida2_tela_dos;
            if($largot2td=="" || $largot2td==null){
                $largot2td=0;
            }
            if($tendida2td=="" || $tendida2td==null){
                $tendida2td=0;
            }
            $metrosTB = $largot2tb*$tendida2tb;
            $metrosTD = $largot2td*$tendida2td;
            $promTB = $metrosTB/$total;
            $promTD = $metrosTD/$total;
            
            $promedio = round($promedio,3);
            $promTB = round($promTB,3);
            $promTD = round($promTD,3);
        return view('ordendecorte.showCorte', compact('OrdenCorte','rollos','telas','ntela','mtrs','promedio','metrosTB','metrosTD','promTB','promTD','result','total','Tallas','talla4','talla6','talla8','talla10','talla12','talla14','talla16','talla18','talla20','talla22','talla24','sumtallas','sumCantidad2','cantcm2'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(OrdenDeCorte $OrdenCorte, $id)
    {
        $OrdenCorte = OrdenDeCorte::findOrFail($id);
        $telas=Telas::all();
        $nametela= DB::table('telas')->where('id','=',$OrdenCorte->id_tela)->get();
        $ntela = json_decode($nametela,true);
        $rollos = DB::select('select * from rollos order by tela asc');
        $gruporollos = DB::select('select tela FROM rollos GROUP BY tela HAVING COUNT(*)>0');

        $ids_rollos = json_decode($OrdenCorte->ids_rollos,true);
        $concat = "";
        for($i=0;$i<count($ids_rollos);$i++){
            $concat = $concat." ".$ids_rollos[$i];
            if($i+1!=count($ids_rollos)){
                $concat = $concat." and id !=";
            }
        }
        $newconsulta = DB::select('select * from rollos where id !='.$concat.' order by tela asc');
        return view('ordendecorte.editCorte', compact('OrdenCorte','telas','ntela','rollos','gruporollos','newconsulta'));
    }
        
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $arrayDetalle = [];
        for($i = 1; $i <= 21; $i++){
            array_push($arrayDetalle, array(  #Aquí está la respuesta, usa [] luego del nombre del array.
                "Largo" => $request->get('largo'.$i),
                "Talla" => $request->get('talla'.$i),
                "Cantidad" => $request->get('cantidad'.$i),
                "Informacion" => $request->get('info'.$i),
                ));
        };

        $levels = array_unique(array_column($arrayDetalle, 'Largo'));
        $infoTallas = array();
        foreach($arrayDetalle as $key => $value){ 
        $infoTallas[$levels[array_search($value['Largo'],$levels )]][] = $value ; 
        };

        $Tallas = [];
        for($i = 4; $i <= 24; $i=$i+2){
            array_push($Tallas, $request->get('tallaN'.$i));
        };

        $ids_rollos_ini = DB::table('orden_de_cortes')->where('id','=',$id)->get();
        $id_r = json_decode($ids_rollos_ini,true);
        $ids_rollos = $request->get('rollos');
        //dd(json_decode($id_r[0]['ids_rollos']));
        $datoscorte = OrdenDeCorte::findOrFail($id);
        $datoscorte->coleccion = strtoupper($request->get('coleccion'));
        $datoscorte->ncorte = strtoupper($request->get('ncorte'));
        $datoscorte->referencia = strtoupper($request->get('referencia'));
        $datoscorte->letra = strtoupper($request->get('letra'));
        $datoscorte->diseñador = strtoupper($request->get('diseñador'));
        $datoscorte->fecha = $request->get('fecha');
        $datoscorte->nombre = strtoupper($request->get('nombre'));
        $datoscorte->porc = $request->get('porc');
        $datoscorte->id_tela = strtoupper($request->get('tela'));
        $datoscorte->ancho = $request->get('ancho');
        $datoscorte->tela_bolsillo = strtoupper($request->get('tela_bolsillo'));
        $datoscorte->largot2_tela_bolsillo = strtoupper($request->get('largot2_tela_bolsillo'));
        $datoscorte->tendida2_tela_bolsillo = strtoupper($request->get('tendida2_tela_bolsillo'));
        $datoscorte->tela_dos = strtoupper($request->get('tela_dos'));
        $datoscorte->largot2_tela_dos = strtoupper($request->get('largot2_tela_dos'));
        $datoscorte->tendida2_tela_dos = strtoupper($request->get('tendida2_tela_dos'));
        $datoscorte->ribete = $request->get('ribete');
        $datoscorte->trazo_pasadores = $request->get('trazo_pasadores');
        $datoscorte->trazo_aletillones = $request->get('trazo_aletillones');
        $datoscorte->tendidos_1 = $request->get('tendidos_1');
        $datoscorte->tendidos_2 = $request->get('tendidos_2');
        $datoscorte->tendidos_3 = $request->get('tendidos_3');
        if($request->hasFile('foto_D'))
        {
            Storage::delete('public/'.$datoscorte->foto_D);
            $datoscorte->foto_D = $request->file('foto_D')->store('uploads','public');
        }
        if($request->hasFile('foto_T'))
        {
            Storage::delete('public/'.$datoscorte->foto_T);
            $datoscorte->foto_T = $request->file('foto_T')->store('uploads','public');
        }
        $datoscorte->marca = strtoupper($request->get('marca'));
        $datoscorte->especificacion1 = strtoupper($request->get('especificacion1'));
        $datoscorte->especificacion2 = strtoupper($request->get('especificacion2'));
        $datoscorte->info_tallas = json_encode($infoTallas);
        $datoscorte->tallas = json_encode($Tallas);
        $datoscorte->ids_rollos = json_encode($request->rollos);
        $datoscorte->save();

        for($i=0;$i<count(json_decode($id_r[0]['ids_rollos']));$i++){
            $r = DB::table('rollos')->where('id','=',json_decode($id_r[0]['ids_rollos'])[$i])->get();
            DB::table('rollos')->where('id','=',json_decode($id_r[0]['ids_rollos'])[$i])->update(['salida'=>$r[0]->salida-1,'fecha_salida'=>'']);
        }
        $updated_at_rollo = Carbon::now();
        for($i=0;$i<count($ids_rollos);$i++){
            $r = DB::table('rollos')->where('id','=',$ids_rollos[$i])->get();
            DB::table('rollos')->where('id','=',$ids_rollos[$i])->update(['salida'=>$r[0]->salida+1,'fecha_salida'=>$updated_at_rollo,'updated_at'=>$updated_at_rollo]);
        }

        return redirect()->route('indexC');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cortes = OrdenDeCorte::find($id);
        Storage::delete('public/'.$cortes->foto_D);
        Storage::delete('public/'.$cortes->foto_T);

        $ids_rollos_ini = DB::table('orden_de_cortes')->where('id','=',$id)->get();
        $id_r = json_decode($ids_rollos_ini,true);
        for($i=0;$i<count(json_decode($id_r[0]['ids_rollos']));$i++){
            $r = DB::table('rollos')->where('id','=',json_decode($id_r[0]['ids_rollos'])[$i])->get();
            DB::table('rollos')->where('id','=',json_decode($id_r[0]['ids_rollos'])[$i])->update(['salida'=>$r[0]->salida-1]);
        }
        $cortes-> delete();      

        return redirect()->route('indexC');
    }
}
