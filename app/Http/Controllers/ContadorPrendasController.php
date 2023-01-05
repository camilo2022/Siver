<?php
namespace App\Http\Controllers;

use App\Models\RefTranslados;
use Illuminate\Http\Request;

class ContadorPrendasController extends Controller
{
    public function index()
    {
       return view('contador-prendas.index');
    }
    
    public function individual(){
        return view('contador-prendas.individualPrenda');
    }
    
    public function individualTransladoID(Request $request){
        $idtranslado = $request->idtranslado;
        $picking = RefTranslados::where('numTransferencia','=',$idtranslado)->get();
        return view('contador-prendas.viewIndividual')->with('picking',$picking);
    }
}
?>