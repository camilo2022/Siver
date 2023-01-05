@extends('layouts.appp')

@section('content')
<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h2 class="text-white fw-bold">Dashboard</h2>
								<h5 class="text-white">Sistemas de verificación de referencias</h5>
							</div>
							
						</div>
					</div>
				</div>
				<div class="panel panel-body page-inner mt--5">
				    <div class="card full-height">
						<div class="card-body">
							<div id="app">
								@if(Auth::user()->rol->slug == 'INS')
								<user-insumos/>
								@elseif(Auth::user()->rol->slug == 'SOL')
								<user-solicitante/>
								@elseif(Auth::user()->rol->slug == 'AD')
								<user-administrador/>
								@elseif(Auth::user()->rol->slug == 'EC' || Auth::user()->rol->slug == 'CEC')
								<ecommerce-whatsaoo/>
								@endif
							</div>
						
							
						</div>
					</div>
				</div>
@endsection
