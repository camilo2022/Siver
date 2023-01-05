<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PrendasConfeccionController extends Controller
{
    public function index()
    {
        $prendas = DB::table('prendas_no_conformes_confeccion')->get();
        $referencias = DB::table('referencias')->get();
        return view('calidad.tabla_control_prendas')->with('prendas',$prendas)->with('referencias',$referencias);
    }

    public function index_hoy()
    {
        $fecha = Carbon::now();
        $fecha = $fecha->format('Y-m-d');
        $prendas = DB::table('prendas_no_conformes_confeccion')->where('fecha','=',$fecha)->get();
        $referencias = DB::table('referencias')->get();
        return view('calidad.tabla_control_prendas')->with('prendas',$prendas)->with('referencias',$referencias);
    }

    public function create()
    {
        $referencias = DB::select('select * from referencias order by lote_referencia asc');
        return view('calidad.form_control_prendas')->with('referencias',$referencias);
    }

    public function referencia_validar(Request $request)
    {
        $lote_refe = $request->get('lote_refe');
        $validar = DB::table('referencias')->where('id','=',$lote_refe)->get();
        $new = json_decode($validar,true);
        if(count($new)>0){
            return response()->json($new);
        }else{
            return response()->json(1);
        }
    }

    public function store(Request $request)
    {
        $created_at = Carbon::now();
        $fecha = $request->get('fecha');
        $modulo = $request->get('modulo');
        $id_refe = $request->get('id_refe');
        $cant_lote = $request->get('cant_lote');
        $cant_rev = $request->get('cant_rev');
        
        $text_marra  = $request->get('text_marra');
        $text_mancha  = $request->get('text_mancha');
        $text_dos_tonos  = $request->get('text_dos_tonos');
        
        $patro_t_piezas  = $request->get('patro_t_piezas');
        
        $corte_piezas_mcor  = $request->get('corte_piezas_mcor');
        
        $maqui_bota  = $request->get('maqui_bota');
        $maqui_pretina  = $request->get('maqui_pretina');
        $maqui_presilla  = $request->get('maqui_presilla');
        $maqui_ojal  = $request->get('maqui_ojal');
        $maqui_mol  = $request->get('maqui_mol');
        $maqui_cotilla  = $request->get('maqui_cotilla');
        $maqui_cola  = $request->get('maqui_cola');
        
        $prepa_pinza  = $request->get('prepa_pinza');
        $prepa_relojera  = $request->get('prepa_relojera');
        $prepa_parche  = $request->get('prepa_parche');
        $prepa_cerra  = $request->get('prepa_cerra');
        $prepa_parcha = $request->get('prepa_parcha');
        
        $patin_caida_parche  = $request->get('patin_caida_parche');
        $patin_marc_parche  = $request->get('patin_marc_parche');
        $patin_marc_pinza  = $request->get('patin_marc_pinza');
        $patin_marc_moda  = $request->get('patin_marc_moda');
        $patin_sumn_ins  = $request->get('patin_sumn_ins');
        
        $mod_cierre  = $request->get('mod_cierre');
        $mod_cola  = $request->get('mod_cola');
        $mod_cos_bolsillo_pos  = $request->get('mod_cos_bolsillo_pos');
        $mod_cos_costado  = $request->get('mod_cos_costado');
        $mod_cos_cotilla  = $request->get('mod_cos_cotilla');
        $mod_cos_pretina  = $request->get('mod_cos_pretina');
        $mod_cos_jota  = $request->get('mod_cos_jota');
        $mod_cos_parche  = $request->get('mod_cos_parche');
        $mod_cos_pinza  = $request->get('mod_cos_pinza');
        $mod_cos_reboque  = $request->get('mod_cos_reboque');
        $mod_cos_ribete  = $request->get('mod_cos_ribete');
        $mod_cos_vista  = $request->get('mod_cos_vista');
        $mod_embonado_parche  = $request->get('mod_embonado_parche');
        $mod_filete_costado  = $request->get('mod_filete_costado');
        $mod_filete_entrepierna  = $request->get('mod_filete_entrepierna');
        $mod_punta  = $request->get('mod_punta');
        $mod_relojera  = $request->get('mod_relojera');
        $mod_roto  = $request->get('mod_roto');
        $mod_tiro  = $request->get('mod_tiro');
        
        $total_pno_conf = $request->get('total_pno_conf');
        $total_arr_mod = $request->get('total_arr_mod');

        $validar_existe = DB::table('prendas_no_conformes_confeccion')->where('fecha','=',$fecha)->where('modulo','=',$modulo)->where('id_referencia','=',$id_refe)->get();
        if(count($validar_existe)==0){
            DB::insert('insert into prendas_no_conformes_confeccion (fecha,modulo,id_referencia,cant_lote,cant_muestra_rev,text_marra,text_mancha,text_dos_tonos,patro_t_piezas,corte_piezas_mcor,maqui_bota,maqui_pretina,maqui_presilla,maqui_ojal,maqui_mol,maqui_cotilla,maqui_cola,prepa_pinza,prepa_relojera,prepa_parche,prepa_cerra,prepa_parcha,patin_caida_parche,patin_marc_parche,patin_marc_pinza,patin_marc_moda,patin_sumn_ins,mod_cierre,mod_cola,mod_cos_bolsillo_pos,mod_cos_costado,mod_cos_cotilla,mod_cos_pretina,mod_cos_jota,mod_cos_parche,mod_cos_pinza,mod_cos_reboque,mod_cos_ribete,mod_cos_vista,mod_embonado_parche,mod_filete_costado,mod_filete_entrepierna,mod_punta,mod_relojera,mod_roto,mod_tiro,total_pno_conforme,total_arreglos_mod,created_at) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$fecha,$modulo,$id_refe,$cant_lote,$cant_rev,$text_marra,$text_mancha,$text_dos_tonos,$patro_t_piezas,$corte_piezas_mcor,$maqui_bota,$maqui_pretina,$maqui_presilla,$maqui_ojal,$maqui_mol,$maqui_cotilla,$maqui_cola,$prepa_pinza,$prepa_relojera,$prepa_parche,$prepa_cerra,$prepa_parcha,$patin_caida_parche,$patin_marc_parche,$patin_marc_pinza,$patin_marc_moda,$patin_sumn_ins,$mod_cierre,$mod_cola,$mod_cos_bolsillo_pos,$mod_cos_costado,$mod_cos_cotilla,$mod_cos_pretina,$mod_cos_jota,$mod_cos_parche,$mod_cos_pinza,$mod_cos_reboque,$mod_cos_ribete,$mod_cos_vista,$mod_embonado_parche,$mod_filete_costado,$mod_filete_entrepierna,$mod_punta,$mod_relojera,$mod_roto,$mod_tiro,$total_pno_conf,$total_arr_mod,$created_at]);
            return response()->json(1);
        }elseif(count($validar_existe)>0){
            return response()->json(2); 
        }
    }

    public function edit($id)
    {
        $referencias = DB::select('select * from referencias order by lote_referencia asc');
        $prendas = DB::table('prendas_no_conformes_confeccion')->where('id','=',$id)->get();
        $prenda = json_decode($prendas,true);
        return view('calidad.edit_control_prendas')->with('prenda',$prenda)->with('referencias',$referencias);
    }

    public function update(Request $request, $id)
    {
        $updated_at = Carbon::now();
        $id = $request->get('id');
        $fecha = $request->get('fecha');
        $modulo = $request->get('modulo');
        $id_refe = $request->get('id_refe');
        $cant_lote = $request->get('cant_lote');
        $cant_rev = $request->get('cant_rev');
        
        $text_marra  = $request->get('text_marra');
        $text_mancha  = $request->get('text_mancha');
        $text_dos_tonos  = $request->get('text_dos_tonos');
        
        $patro_t_piezas  = $request->get('patro_t_piezas');
        
        $corte_piezas_mcor  = $request->get('corte_piezas_mcor');
        
        $maqui_bota  = $request->get('maqui_bota');
        $maqui_pretina  = $request->get('maqui_pretina');
        $maqui_presilla  = $request->get('maqui_presilla');
        $maqui_ojal  = $request->get('maqui_ojal');
        $maqui_mol  = $request->get('maqui_mol');
        $maqui_cotilla  = $request->get('maqui_cotilla');
        $maqui_cola  = $request->get('maqui_cola');
        
        $prepa_pinza  = $request->get('prepa_pinza');
        $prepa_relojera  = $request->get('prepa_relojera');
        $prepa_parche  = $request->get('prepa_parche');
        $prepa_cerra  = $request->get('prepa_cerra');
        $prepa_parcha = $request->get('prepa_parcha');
        
        $patin_caida_parche  = $request->get('patin_caida_parche');
        $patin_marc_parche  = $request->get('patin_marc_parche');
        $patin_marc_pinza  = $request->get('patin_marc_pinza');
        $patin_marc_moda  = $request->get('patin_marc_moda');
        $patin_sumn_ins  = $request->get('patin_sumn_ins');
        
        $mod_cierre  = $request->get('mod_cierre');
        $mod_cola  = $request->get('mod_cola');
        $mod_cos_bolsillo_pos  = $request->get('mod_cos_bolsillo_pos');
        $mod_cos_costado  = $request->get('mod_cos_costado');
        $mod_cos_cotilla  = $request->get('mod_cos_cotilla');
        $mod_cos_pretina  = $request->get('mod_cos_pretina');
        $mod_cos_jota  = $request->get('mod_cos_jota');
        $mod_cos_parche  = $request->get('mod_cos_parche');
        $mod_cos_pinza  = $request->get('mod_cos_pinza');
        $mod_cos_reboque  = $request->get('mod_cos_reboque');
        $mod_cos_ribete  = $request->get('mod_cos_ribete');
        $mod_cos_vista  = $request->get('mod_cos_vista');
        $mod_embonado_parche  = $request->get('mod_embonado_parche');
        $mod_filete_costado  = $request->get('mod_filete_costado');
        $mod_filete_entrepierna  = $request->get('mod_filete_entrepierna');
        $mod_punta  = $request->get('mod_punta');
        $mod_relojera  = $request->get('mod_relojera');
        $mod_roto  = $request->get('mod_roto');
        $mod_tiro  = $request->get('mod_tiro');
        
        $total_pno_conf = $request->get('total_pno_conf');
        $total_arr_mod = $request->get('total_arr_mod');

        $validar_existe = DB::table('prendas_no_conformes_confeccion')->where('fecha','=',$fecha)->where('modulo','=',$modulo)->where('id_referencia','=',$id_refe)->where('id','!=',$id)->get();
        if(count($validar_existe)==0){
            DB::table('prendas_no_conformes_confeccion')->where('id','=',$id)->update(['fecha'=>$fecha, 'modulo'=>$modulo, 'id_referencia'=>$id_refe, 'cant_lote'=>$cant_lote,'cant_muestra_rev'=>$cant_rev,'text_marra'=>$text_marra,'text_mancha'=>$text_mancha,'text_dos_tonos'=>$text_dos_tonos,'patro_t_piezas'=>$patro_t_piezas,'corte_piezas_mcor'=>$corte_piezas_mcor,'maqui_bota'=>$maqui_bota,'maqui_pretina'=>$maqui_pretina, 'maqui_presilla'=>$maqui_presilla,'maqui_ojal'=>$maqui_ojal,'maqui_mol'=>$maqui_mol,'maqui_cotilla'=>$maqui_cotilla,'maqui_cola'=>$maqui_cola,'prepa_pinza'=>$prepa_pinza,'prepa_relojera'=>$prepa_relojera,'prepa_parche'=>$prepa_parche,'prepa_cerra'=>$prepa_cerra,'prepa_parcha'=>$prepa_parcha,'patin_caida_parche'=>$patin_caida_parche,'patin_marc_parche'=>$patin_marc_parche,'patin_marc_pinza'=>$patin_marc_pinza,'patin_marc_moda'=>$patin_marc_moda,'patin_sumn_ins'=>$patin_sumn_ins,'mod_cierre'=>$mod_cierre,'mod_cola'=>$mod_cola,'mod_cos_bolsillo_pos'=>$mod_cos_bolsillo_pos,'mod_cos_costado'=>$mod_cos_costado,'mod_cos_cotilla'=>$mod_cos_cotilla,'mod_cos_pretina'=>$mod_cos_pretina,'mod_cos_jota'=>$mod_cos_jota,'mod_cos_parche'=>$mod_cos_parche,'mod_cos_pinza'=>$mod_cos_pinza,'mod_cos_reboque'=>$mod_cos_reboque,'mod_cos_ribete'=>$mod_cos_ribete,'mod_cos_vista'=>$mod_cos_vista,'mod_embonado_parche'=>$mod_embonado_parche,'mod_filete_costado'=>$mod_filete_costado,'mod_filete_entrepierna'=>$mod_filete_entrepierna,'mod_punta'=>$mod_punta,'mod_relojera'=>$mod_relojera,'mod_roto'=>$mod_roto,'mod_tiro'=>$mod_tiro,'total_pno_conforme'=>$total_pno_conf,'total_arreglos_mod'=>$total_arr_mod,'updated_at'=>$updated_at]);
            return response()->json(1);
        }elseif(count($validar_existe)>0){
            return response()->json(2); 
        }
    }
}
