<?php

namespace App\Http\Controllers;

use App\Models\RefTranslados;
use Illuminate\Http\Request;

class RefTransladosController extends Controller
{

    public function getLoteConteo(Request $request){
        $lote = $request->lote;
        $picking = RefTranslados::where('numTransferencia','=',$lote)->get();
        return response()->json($picking);
    }
    
    public function DeleteConteo(Request $request){
        $id = $request->id;
        $picking = RefTranslados::where('id','=',$id)->first();
        $picking->delete();
    }
    
    public function saveReferencias(Request $request){
        $lote = $request->lote;
        $referencia= $request->referencia;
        $esmarra = $request->esmarra;
        $essaldo = $request->esSaldo;
        
        
        if($esmarra == "true"){
            $esmarra = 1;
        }else{
            $esmarra = 0;
        }
        
        if($essaldo == "true"){
            $essaldo = 1;
        }else{
            $essaldo = 0;
        }
        
        
        if($essaldo == 1){
            $pi = RefTranslados::where('numTransferencia','=',$lote)->where('referencia','=',$referencia)->where('essaldo','=',$essaldo)->first();
        }else if($esmarra == 1){
            $pi = RefTranslados::where('numTransferencia','=',$lote)->where('referencia','=',$referencia)->where('esmarra','=',$esmarra)->first();
        }else if($esmarra == 0 && $essaldo == 0){
            $pi = RefTranslados::where('numTransferencia','=',$lote)->where('referencia','=',$referencia)->where('esmarra','=',$esmarra)->where('essaldo','=',$essaldo)->first();
        }
        
        if($pi != null){
            $pi->cantidad += 1;
            $pi->save();
            return response()->json(['message' => 'Se ha sumado a la cantidad']);
        }else{
             $picking = RefTranslados::create([
                'referencia' => $referencia,
        	    'cantidad' => 1,
        	    'esmarra'  => $esmarra,
        	    'numTransferencia' => $lote,
        	    'essaldo' => $essaldo, 
    	    ]);   
    	     return response()->json(['message' => 'Se ha creado un nuevo']);
        }
    }


    
}