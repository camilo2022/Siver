@extends('layouts.appp')

@section('content')
    <div id="appvue" class="container-fluid mt-4">
        <div class="card">
            <div class="card-header text-center" style="background-color:black; color:white; font-weight:bold">
                CONTADOR DE LOTES DE PRENDAS
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card" style="background-color:black; color:white;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6"></div>
                                    <div class="col-sm-6">ASDDS</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                         <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Referencia</th>
                                <th>Cantidad</th>
                                <th>Es Marra</th>
                                <th>Es Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($picking as $pik)
                            <tr>
                                <th>{{$pik->referencia}}</th>
                                <th>{{$pik->cantidad}}</th>
                                @if($pik->esmarra==1)
                                <th>X</th>
                                @else
                                <th></th>
                                @endif
                                @if($pik->essaldo==1 && $pik->esmarra==0)
                                <th>X</th>
                                @else
                                <th></th>
                                @endif
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
                    </div>
                </div>
            </div>
           
        </div>
    </div>
@endsection
