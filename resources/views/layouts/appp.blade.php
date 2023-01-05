<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<meta name="user-id" content="{{ Auth::user()->id }}">
	<meta name="base-url" content="{{ url('/') }}" />
	<title>{{ config('app.name', 'Laravel') }} | Dashboard</title>
	<link rel="icon" href="{{asset('img/favicon.png')}}" type="image/x-icon"/>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Georama&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/b-2.1.1/b-html5-2.1.1/b-print-2.1.1/datatables.min.css"/>
    <style>
        .dt-buttons{
            padding-right: 23px !important;
        }
    </style>
	<script src="{{ asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{asset("assets/css/fonts.min.css")}}']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{ asset('assets/css/atlantis.css')}}">
    @stack('custom-css')
</head>
<body>
	<div class="wrapper">
		<div class="main-header">
			<!-- Logo Header -->
			<div class="logo-header" data-background-color="blue">
				
				<a href="/" class="logo">
					<img src="{{ asset('assets/img/icon.png')}}" alt="navbar brand" class="navbar-brand">
					<span style="font-size: 1.5em; display: inline-block;color: white;">Siver</span>
				</a>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
						<i class="icon-menu"></i>
					</span>
				</button>
				<button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
				<div class="nav-toggle">
					<button class="btn btn-toggle toggle-sidebar">
						<i class="icon-menu"></i>
					</button>
				</div>
			</div>
			<!-- End Logo Header -->

			<!-- Navbar Header -->
			<nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">
				
				<div class="container-fluid">
					
					<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
						<div id="app2">
							
							@if(Auth::user()->rol->slug == "INS" )
							<user-notificaciones/>
							@elseif (Auth::user()->rol->slug == "SOL" ||  Auth::user()->rol->slug == "QR")
							<user-notificaciones-normal/>
							@endif
						</div>
						
						<li class="nav-item dropdown hidden-caret">
							<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
								<div class="avatar-sm">
									<img src="{{asset('assets/img/icon.png')}}" alt=" {{ Auth::user()->names }} {{ Auth::user()->apellidos}}" class="avatar-img rounded-circle">
								</div>
							</a>
							<ul class="dropdown-menu dropdown-user animated fadeIn">
								<div class="dropdown-user-scroll scrollbar-outer">
									<li>
										<div class="user-box">
											<div class="avatar-lg"><img src="{{asset('assets/img/icon.png')}}" alt="image profile" class="avatar-img rounded"></div>
											<div class="u-text">
												<h4> {{ Auth::user()->names }} {{ Auth::user()->apellidos}}</h4>
												<p class="text-muted">{{ Auth::user()->rol->descripcion}}</p>
												<p class="text-muted">{{ Auth::user()->tiendacargo}}</p>
											</div>
										</div>
									</li>
									<li>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item" href="#">Notificaciones</a>
										<div class="dropdown-divider"></div>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                        </form>
                                        <button type="submit" form="logout-form" class="btn dropdown-item" href="#">Cerrar Sesion</button>
									</li>
								</div>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
			<!-- End Navbar -->
		</div>

		<!-- Sidebar -->
		<div class="sidebar sidebar-style-2">			
			<div class="sidebar-wrapper scrollbar scrollbar-inner">
				<div class="sidebar-content">
					<div class="user">
						<div class="avatar-sm float-left mr-2">
							<img src="{{asset('assets/img/icon.png')}}" alt="..." class="avatar-img rounded-circle">
						</div>
						<div class="info">
							<a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
								<span>
                                    {{explode(' ', Auth::user()->names)[0]}} {{explode(' ', Auth::user()->apellidos)[0]}}
									<strong>{{ Auth::user()->tiendacargo}}</strong>
									<span class="caret"></span>
								</span>
							</a>
							<div class="clearfix"></div>

							<div class="collapse in" id="collapseExample">
								<ul class="nav">
									<li>
										<a href="#profile">
											<span class="link-collapse">Mis notificaciones</span>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<ul class="nav nav-primary">
					  
					  
					    
					    <li class="nav-item active">
							<a href="/" class="collapsed" aria-expanded="false">
								<i class="fa fa-home"></i>
								<p>Inicio</p>
							</a>
						</li>
						
						@if(Auth::user()->rol->slug == 'AD')
						<li class="nav-item submenu">
							<a data-toggle="collapse" href="#sidebarPreparacion">
								<i class="flaticon-interface-6"></i>
								<p>Preparacion</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="sidebarPreparacion">
								<ul class="nav nav-collapse">
									
									<li class="nav-item">
    							<a href="/preparacion/list" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-list-ul"></i>
    								<p>Preparacion Listado</p>
    							</a>
    						        </li>
    						        
            						<li class="nav-item">
    							<a href="/preparacion/list/hoy" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-list-ul"></i>
    								<p>Preparacion Diarios</p>
    							</a>
    						        </li>
    						  
    						    <li class="nav-item">
    							<a href="/preparacion/excel" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-file-excel"></i>
    								<p>Preparacion Excel</p>
    							</a>
    						        </li>
    						        
    						    <li class="nav-item">
    							<a href="/preparacion/reporte/operario" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-clipboard"></i>
    								<p>Reporte Operarios</p>
    							</a>
    						        </li>
    						        
    						    <li class="nav-item">
    							<a href="/preparacion/reporte/modulo" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-clipboard"></i>
    								<p>Reporte Modulos</p>
    							</a>
    						        </li>
    						        
    						        <li class="nav-item">
    							<a href="/preparacion" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-marker"></i>
    								<p>Preparacion Formulario</p>
    							</a>
    						        </li>

                                <li class="nav-item">
    							<a href="/preparacion/masivo" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-marker"></i>
    								<p>Formulario Masivo</p>
    							</a>
    						        </li>
    						        
							    </ul>
							</div>
						
						<li class="nav-item submenu">
							<a data-toggle="collapse" href="#sidebarEnsamble">
								<i class="flaticon-interface-6"></i>
								<p>Ensamble</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="sidebarEnsamble">
								<ul class="nav nav-collapse">
									
									<li class="nav-item">
    							<a href="/ensamble/list" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-list-ul"></i>
    								<p>Ensamble Listado</p>
    							</a>
    						        </li>
    						        
            						<li class="nav-item">
    							<a href="/ensamble/list/hoy" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-list-ul"></i>
    								<p>Ensamble Diarios</p>
    							</a>
    						        </li>
    						  
    						    <li class="nav-item">
    							<a href="/ensamble/excel" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-file-excel"></i>
    								<p>Ensamble Excel</p>
    							</a>
    						        </li>
    						        
    						    <li class="nav-item">
    							<a href="/ensamble/reporte/operario" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-clipboard"></i>
    								<p>Reporte Operarios</p>
    							</a>
    						        </li>
    						        
    						    <li class="nav-item">
    							<a href="/ensamble/reporte/modulo" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-clipboard"></i>
    								<p>Reporte Modulos</p>
    							</a>
    						        </li>
    						        
    						        <li class="nav-item">
    							<a href="/ensamble" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-marker"></i>
    								<p>Ensamble Formulario</p>
    							</a>
    						        </li>

                                <li class="nav-item">
    							<a href="/ensamble/masivo" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-marker"></i>
    								<p>Formulario Masivo</p>
    							</a>
    						        </li>
    						        
							    </ul>
							</div>
						
						<li class="nav-item submenu">
							<a data-toggle="collapse" href="#sidebarModulop">
								<i class="flaticon-interface-6"></i>
								<p>Confeccion</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="sidebarModulop">
								<ul class="nav nav-collapse">
									
									<li class="nav-item">
    							<a href="/modulos/list" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-list-ul"></i>
    								<p>Confeccion Listado</p>
    							</a>
    						        </li>
    						        
            						<li class="nav-item">
    							<a href="/modulos/list/hoy" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-list-ul"></i>
    								<p>Confeccion Diarios</p>
    							</a>
    						        </li>
    						    
    						    <li class="nav-item">
    							<a href="/modulos/excel" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-file-excel"></i>
    								<p>Confeccion Excel</p>
    							</a>
    						        </li>
    						        
    						        <li class="nav-item">
    							<a href="/modulos" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-marker"></i>
    								<p>Confeccion Formulario</p>
    							</a>
    						        </li>

							    </ul>
							</div>
						    </li>
						    
						    <li class="nav-item submenu">
							<a data-toggle="collapse" href="#sidebarModulopStr">
								<i class="flaticon-interface-6"></i>
								<p>Confeccion STR</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="sidebarModulopStr">
								<ul class="nav nav-collapse">
									
									<li class="nav-item">
    							<a href="/modulos_stara/list" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-list-ul"></i>
    								<p>Confeccion STR Listado</p>
    							</a>
    						        </li>
    						        
            						<li class="nav-item">
    							<a href="/modulos_stara/list/hoy" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-list-ul"></i>
    								<p>Confeccion STR Diarios</p>
    							</a>
    						        </li>
    						    
    						    <li class="nav-item">
    							<a href="/modulos_stara/excel" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-file-excel"></i>
    								<p>Confeccion STR Excel</p>
    							</a>
    						        </li>
    						        
    						        <li class="nav-item">
    							<a href="/modulos_stara" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-marker"></i>
    								<p>Confeccion STR Formulario</p>
    							</a>
    						        </li>

							    </ul>
							</div>
						    </li>
						    
						    <li class="nav-item submenu">
							<a data-toggle="collapse" href="#sidebarTerminacion">
								<i class="flaticon-interface-6"></i>
								<p>Terminacion</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="sidebarTerminacion">
								<ul class="nav nav-collapse">
									
									<li class="nav-item">
    							<a href="/terminacion/list" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-list-ul"></i>
    								<p>Terminacion Listado</p>
    							</a>
    						        </li>
    						        
            						<li class="nav-item">
    							<a href="/terminacion/list/hoy" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-list-ul"></i>
    								<p>Terminacion Diarios</p>
    							</a>
    						        </li>
    						        
    						    <li class="nav-item">
    							<a href="/terminacion/excel" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-file-excel"></i>
    								<p>Terminacion Excel</p>
    							</a>
    						        </li>
    						        
    						        <li class="nav-item">
    							<a href="/terminacion" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-marker"></i>
    								<p>Terminacion Formulario</p>
    							</a>
    						        </li>

							    </ul>
							</div>
						    </li>
						    
						   <li class="nav-item submenu">
							<a data-toggle="collapse" href="#sidebarReferenciap">
								<i class="flaticon-interface-6"></i>
								<p>Referencias</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="sidebarReferenciap">
								<ul class="nav nav-collapse">
    						        
            						<li class="nav-item">
    							<a href="/referencias/list" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-list-ul"></i>
    								<p>Referencias Listado</p>
    							</a>
    						        </li>
    						        
    						        <li class="nav-item">
    							<a href="/referencias" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-marker"></i>
    								<p>Referencias Formulario</p>
    							</a>
    						        </li>
    						        
							    </ul>
							</div>
						    </li>
						    
						    <li class="nav-item submenu">
							<a data-toggle="collapse" href="#sidebarReferenciapStr">
								<i class="flaticon-interface-6"></i>
								<p>Referencias STR</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="sidebarReferenciapStr">
								<ul class="nav nav-collapse">
    						        
            						<li class="nav-item">
    							<a href="/referencias_stara/list" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-list-ul"></i>
    								<p>Referencias STR Listado</p>
    							</a>
    						        </li>
    						        
    						        <li class="nav-item">
    							<a href="/referencias_stara" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-marker"></i>
    								<p>Referencias STR Formulario</p>
    							</a>
    						        </li>
    						        
							    </ul>
							</div>
						    </li>
						
						<li class="nav-item submenu">
							<a data-toggle="collapse" href="#sidebarOrdenC">
								<i class="flaticon-interface-6"></i>
								<p>Orden de Corte</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="sidebarOrdenC">
								<ul class="nav nav-collapse">
									
									<li class="nav-item">
    							<a href="/corte/list" class="collapsed" aria-expanded="false">
    								<i class="fa fa-list"></i>
    								<p>Orden Corte Listado</p>
    							</a>
    						        </li>
    						        
    						        <li class="nav-item">
    							<a href="/corte/list/inactivas" class="collapsed" aria-expanded="false">
    								<i class="fa fa-list"></i>
    								<p>Orden Corte Inactivas</p>
    							</a>
    						        </li>
    						        
            						<li class="nav-item">
    							<a href="/corteCreate" class="collapsed" aria-expanded="false">
    								<i class="fa fa-edit"></i>
    								<p>Crear Orden de Corte</p>
    							</a>
    						        </li>
							    </ul>
							</div>
						    </li>
						    
						   <li class="nav-item submenu">
							<a data-toggle="collapse" href="#sidebarRollo">
								<i class="flaticon-interface-6"></i>
								<p>Telas y Rollos</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="sidebarRollo">
								<ul class="nav nav-collapse">
									
									<li class="nav-item">
    							<a href="/rollos/list" class="collapsed" aria-expanded="false">
    								<i class="fa fa-list"></i>
    								<p>Rollos Listado</p>
    							</a>
    						        </li>
    						        
    						        <li class="nav-item">
    							<a href="/rollos/list/telas" class="collapsed" aria-expanded="false">
    								<i class="fa fa-list"></i>
    								<p>Metros Disponibles Tela</p>
    							</a>
    						        </li>
    						        
    						        <li class="nav-item">
    							<a href="/rollos" class="collapsed" aria-expanded="false">
    								<i class="fa fa-edit"></i>
    								<p>Rollos Formulario</p>
    							</a>
    						        </li>
                                
                                <li class="nav-item">
    							<a href="/telas/list" class="collapsed" aria-expanded="false">
    								<i class="fa fa-list"></i>
    								<p>Telas Listado</p>
    							</a>
    						        </li>
    						        
    						     <li class="nav-item">
    							<a href="/telas" class="collapsed" aria-expanded="false">
    								<i class="fa fa-edit"></i>
    								<p>Telas Formulario</p>
    							</a>
    						        </li>
							    </ul>
							</div>
						    </li>
						    
						  <li class="nav-item submenu">
							<a data-toggle="collapse" href="#sidebarControlc">
								<i class="flaticon-interface-6"></i>
								<p>Control de Calidad</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="sidebarControlc">
								<ul class="nav nav-collapse">
    									
    									<li class="nav-item">
        							<a href="/prendas/list" class="collapsed" aria-expanded="false">
        								<i class="fa fa-list"></i>
        								<p>Crtl Prendas Listado</p>
        							</a>
        						        </li>
        						        
                						<li class="nav-item">
        							<a href="/prendas/list/hoy" class="collapsed" aria-expanded="false">
        								<i class="fa fa-list"></i>
        								<p>Crtl Prendas Diarios</p>
        							</a>
        						        </li>
        						        
        						        <li class="nav-item">
        							<a href="/prendas" class="collapsed" aria-expanded="false">
        								<i class="fa fa-edit"></i>
        								<p>Crtl Prendas Formulario</p>
        							</a>
        							</li>
							    </ul>
							</div>
						    </li>  
						    
						<li class="nav-item submenu">
							<a data-toggle="collapse" href="#sidebarPicking">
								<i class="flaticon-interface-6"></i>
								
								<p>Picking</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="sidebarPicking">
								<ul class="nav nav-collapse">
									
									<li class="nav-item">
    							<a href="/picking/list" class="collapsed" aria-expanded="false">
    								<i class="fa fa-list"></i>
    								<p>Picking Listado</p>
    							</a>
    						        </li>
    						        
            						<li class="nav-item">
    							<a href="/picking/list/hoy" class="collapsed" aria-expanded="false">
    								<i class="fa fa-list"></i>
    								<p>Picking Diarios</p>
    							</a>
    						        </li>
    						        
    						        <li class="nav-item">
    							<a href="/picking" class="collapsed" aria-expanded="false">
    								<i class="fa fa-edit"></i>
    								<p>Picking Formulario</p>
    							</a>
    						        </li>

							    </ul>
							</div>
						    </li>
						    
						    <li class="nav-item submenu">
							<a data-toggle="collapse" href="#sidebarPickingOrden">
								<i class="flaticon-interface-6"></i>
								
								<p>Gestion de Picking</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="sidebarPickingOrden">
								<ul class="nav nav-collapse">
									
									<li class="nav-item">
    							<a href="/orden_picking/list" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-list-ul"></i>
    								<p>Orden Picking Listado</p>
    							</a>
    						        </li>
    						        
    						        <li class="nav-item">
    							<a href="/orden_picking" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-marker"></i>
    								<p>Orden Picking Formulario</p>
    							</a>
    						        </li>
    						        
            						<li class="nav-item">
    							<a href="/orden_picking_historial/list/rechazados" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-list-ul"></i>
    								<p>Historial Rechazados</p>
    							</a>
    						        </li>
    						        
    						          <li class="nav-item">
    							<a href="/terminacion_picking/list" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-list-ul"></i>
    								<p>Picking Terminacion</p>
    							</a>
    						        </li>  	
    						        
    						        <li class="nav-item">
    							<a href="/bodega_picking/list" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-list-ul"></i>
    								<p>Picking Bodega</p>
    							</a>
    						        </li> 

                                    <li class="nav-item">
    							<a href="/bodega_picking/list/gestion" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-list-ul"></i>
    								<p>Gestion Bodega</p>
    							</a>
    						        </li>
    						        
    						        <li class="nav-item">
    							<a href="/orden_picking/reporte_terminacion" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-clipboard"></i>
    								<p>Reporte Terminacion</p>
    							</a>
    						        </li>
    						        
    						        <li class="nav-item">
    							<a href="/orden_picking/reporte_bodega" class="collapsed" aria-expanded="false">
    								<i class="fa fa-solid fa-clipboard"></i>
    								<p>Reporte Bodega</p>
    							</a>
    						        </li>
							    </ul>
							</div>
						    </li>
					    
						<li class="nav-item submenu">
							<a data-toggle="collapse" href="#sidebarUser">
								<i class="fa fa-user"></i>
								<p>Usuarios</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="sidebarUser">
								<ul class="nav nav-collapse">
									<li>
										<a href="{{route('admin.users')}}">
											<i class="fa fa-eyes"></i> Administrar
										</a>
									</li>
								</ul>
							</div>
						</li>
					
						
					    @endif
					  
						
					</ul>
				</div>
			</div>
		</div>
		<!-- End Sidebar -->

		    <div class="main-panel">
		        
			    <div class="content">
			        @if($errors->any())
			        <input value="{{$errors->first()}}" id="valorE" hidden>
			        
                    @endif
					@yield('content')
					 
				</div>
			</div>
			<footer class="footer">
				<div class="container-fluid">
					<div class="copyright mx-auto">
						&copy; 2021 Sistema Verificacion Referencias <a href="">Departamento Desarrollo Informatico</a>
					</div>				
				</div>
			</footer>
		</div>
		
	<!--   Core JS Files   -->
	
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	
	<script src="{{ asset('assets/js/core/popper.min.js')}}"></script>
	<script src="{{ asset('assets/js/core/bootstrap.min.js')}}"></script>
@if($errors->any())
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
					<script>
					swal("Hay un error.",$('#valorE').val(), "warning");
			        </script>
			        @endif
	<!-- jQuery UI -->
	<script src="{{ asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
	<script src="{{ asset('assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}"></script>
<script src="https://unpkg.com/vuejs-datepicker"></script>
@stack('scripts-custom')
	<!-- jQuery Scrollbar -->
	<script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>


	<!-- Chart JS -->
	<script src="{{ asset('assets/js/plugin/chart.js/chart.min.js')}}"></script>

	<!-- jQuery Sparkline -->
	<script src="{{ asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js')}}"></script>

	<!-- Chart Circle -->
	<script src="{{ asset('assets/js/plugin/chart-circle/circles.min.js')}}"></script>

	<!-- Bootstrap Notify -->
	<script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js')}}"></script>
	<!-- Sweet Alert -->
	<script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js')}}"></script>
	<script src="{{ asset('js/app.js') }}" defer></script>
	<!-- Atlantis JS -->
	<script src="{{ asset('assets/js/atlantis.js')}}"></script>
	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/b-2.1.1/b-html5-2.1.1/b-print-2.1.1/datatables.min.js"></script>

	
</body>
</html>