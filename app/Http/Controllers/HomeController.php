<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
       return view('home')->with('notificaciones',$this->getNotificaciones());
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

}
