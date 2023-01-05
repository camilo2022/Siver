<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\AdapterInterface;
use App\Models\Imagen;

class BankImgController extends Controller
{
    public function index(){
        return view('bankimg.referencias.check')->with('notificaciones',$this->getNotificaciones());
    }

    private function getNotificaciones(){
        $noti=[];
        $j=0;
        $notificaciones = auth()->user()->rol->notificacions;
        for($i=0;$i<count($notificaciones);$i++){
            if($notificaciones[$i]->estado == 1){
                if($j<=5){
                    $noti[$j]=$notificaciones[$i];
                    $j++;
                }
            }
        }
        return $noti;
    }


    public function fileStore(Request $request){
        $codbarra= $request->codbarras;
        if(str_contains($codbarra,'/')){
            $codbarra = str_replace('/','-',$codbarra);
        }
        $file_name1 = $request->file1->getClientOriginalName();
        $file_name1= $codbarra. '-1.' .$request->file1->getClientOriginalExtension();
    
        //$file_name2 = $request->file2->getClientOriginalName();
        //$file_name2= $codbarra. '-2.' .$request->file2->getClientOriginalExtension();

        $content1=$request->file1->getContent();
        //$content2=$request->file2->getContent();

        $so1=Storage::disk('google')->put($codbarra.'-1',$content1);
        //$so2=Storage::disk('google')->put($codbarra.'-2',$content2);
        $respuesta=json_encode(Storage::disk('google')->listContents('.'));

        
        Imagen::create([
            'codigobarras' => $request->codbarras,
            'pathimg1' => $this->getPath($codbarra.'-1'),
            //'pathimg2' => $this->getPath($codbarra.'-2')
        ]);

        $this->setVisibilityAll();

        return response()->json('Las imagenes han sido subidas correctamente.');
    }

    private function getPath($nameFile){
        $respuesta=json_encode(Storage::disk('google')->listContents(''));
        $arrayRespuesta=json_decode($respuesta);
        foreach($arrayRespuesta as $file){
            if($file->filename == $nameFile)
            return $file->basename;
        }
        return null;
    }

    private function setVisibilityAll(){
        $respuesta=json_encode(Storage::disk('google')->listContents('.'));
        $arrayRespuesta=json_decode($respuesta);
        foreach($arrayRespuesta as $file){
            Storage::disk('google')->setVisibility($file->basename, AdapterInterface::VISIBILITY_PUBLIC);
        }
    }


    public function getItemCodBarra(Request $request){
        $codbarra = $request->codbarra;
        $item = Imagen::where('codigobarras','=',$codbarra)->get();
        return response()->json($item);
    }


}
