<?php

use App\Models\QrDespachos;
use Illuminate\Support\Facades\Route;
use League\Flysystem\AdapterInterface;
use App\Models\User;


Route::get('/home',function(){
    return redirect('/');
});

Route::get('/clear-cache', function () {
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    return "Cache is cleared";
});










Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/register',function(){
    return redirect('/');
});

Route::group(['prefix' => 'conteoprendas'], function()  {
    Route::post('/', [App\Http\Controllers\ConteoPrendasController::class, 'saveConteoCurva']);
    Route::post('/pickingSave', [App\Http\Controllers\ConteoPrendasController::class, 'pickingSave']);
    Route::post('/getInformacionSKU', [App\Http\Controllers\ConteoPrendasController::class, 'getInformacionSKU']);
    Route::post('/marcarCerrado',[App\Http\Controllers\ConteoPrendasController::class, 'marcarCerrado']);
    Route::get('/informe', function () {
        return view('contador-prendas.informe');
    });
    Route::get('exportarListadoPicking/{fecha1}/{fecha2}',[App\Http\Controllers\ConteoPrendasController::class, 'exportarListadoPicking']);

});

Route::get('/correrias-actuales-export', [App\Http\Controllers\sistemaventas\CorreriaController::class,'index']);

Route::group(['prefix' => 'solicitud'], function()  {
    Route::get('/crear', [App\Http\Controllers\SolicitudController::class, 'index'])->name('solicitud.crear');
    Route::post('/', [App\Http\Controllers\SolicitudController::class, 'store'])->name('solicitud.store');
    Route::get('/misolicitudes',[App\Http\Controllers\SolicitudController::class, 'misolicitudes'])->name('misolicitudes');

});

Route::prefix('user')->group(function () {
    Route::get('/all', [App\Http\Controllers\UserController::class, 'all']);
    Route::get('/mysolicitudes',[App\Http\Controllers\UserController::class, 'showMySolicitudes']);
    Route::get('/notificaciones',[App\Http\Controllers\UserController::class, 'getNotificaciones']);
    Route::get('/notificaciones-normal',[App\Http\Controllers\UserController::class, 'getNotificacionesNormal']);
    Route::get('/{id}',[App\Http\Controllers\UserController::class, 'show']);
});


Route::prefix('conteo')->group(function () {
    Route::post('/inicial', [App\Http\Controllers\SolicitudController::class, 'inicial']);
});

Route::prefix('admin')->group(function () {
    Route::get('users', function () {
        return view('admin.users');
    })->name('admin.users');
    
    Route::get('/users/getUserByDocument/{documento}',[App\Http\Controllers\UserController::class, 'findByDocument']);
    Route::put('/users/create', [App\Http\Controllers\UserController::class, 'create']);
    Route::put('/users/edit', [App\Http\Controllers\UserController::class, 'edit']);
});

Route::prefix('libranza')->group(function () {
    Route::get('cuotas/list', function () {
        return view('libranza.listadoCuotas');
    });
    
    Route::get('new', function () {
        return view('libranza.new');
    });
    Route::get('/', function () {
        return view('libranza.index');
    });
    
    Route::get('validar', [App\Http\Controllers\EmpleadoController::class,'getViewValidarLibranza']);
    Route::post('validaCodigo', [App\Http\Controllers\EmpleadoController::class,'validarCodigoEnviado']);
    
    /*Administrativo*/
    Route::get('empleados', function () {
        return view('libranza.indexEmpleados');
    });
    
    Route::get('pendientes', function () {
        return view('libranza.libranzasPendientes');
    });
    
    Route::get('list', function () {
        return view('libranza.listado');
    });
    
    Route::get('getAllLibranzas',[App\Http\Controllers\EmpleadoController::class,'getAllLibranzas']);
    
    Route::post('descuentaLibranzaContabilidad',[App\Http\Controllers\EmpleadoController::class,'descuentaLibranzaContabilidad']);
    Route::get('listado_pendientes' , [App\Http\Controllers\EmpleadoController::class,'getLibranzasPendiente']);
});


Route::prefix('rol')->group(function(){
    Route::get('/all',[App\Http\Controllers\RolController::class,'showAll']);
});



Route::prefix('solicitud')->group(function(){
    Route::get('/{codigo}',[App\Http\Controllers\SolicitudController::class,'get']);
    Route::get('/items/{codigo}',[App\Http\Controllers\SolicitudController::class,'getItems']);
    Route::delete('/', [App\Http\Controllers\SolicitudController::class,'destroy']);
});

Route::prefix('solicitudes')->group(function(){
    Route::get('/get/{codigo}', [App\Http\Controllers\SolicitudController::class,'getsolicitud']);
    Route::get('/all', [App\Http\Controllers\SolicitudController::class,'all']);
    Route::get('/allday', [App\Http\Controllers\SolicitudController::class,'allday']);
    Route::get('/list', [App\Http\Controllers\SolicitudController::class,'listar'])->name('solicitudes.listar');
    Route::post('/aprove',[App\Http\Controllers\SolicitudController::class,'aprove']);
    Route::post('/informarSolicitante',[App\Http\Controllers\SolicitudController::class,'informarSolicitante']);
});

Route::get('readqrAgil', function () {
    return view('readqr.indexAgil');
})->name('readqrAgil');


Route::get('validar_cupo_empleado', function () {
    return view('validate_cupo_empleado');
})->name('validateCupo');

Route::get('readqr', function () {
    return view('readqr.index');
})->name('readqr');


Route::get('/despachos/list',function(){
    return view('readqr.list');
})->name('despachosqr');


Route::get('/readqr/despacho/list', function(){
    $despachos = QrDespachos::get();
    $despachos = json_encode($despachos);
    $despachos = json_decode($despachos);
    $arrayData = array();
    $carbon = new \Carbon\Carbon();
    for($i=0;$i<count($despachos);$i++){
        $user = User::find($despachos[$i]->user_id);
        $arr = array(
        'destinatario' => $despachos[$i]->destinatario,
        'nit' => $despachos[$i]->nit,
        'direccion'  => $despachos[$i]->direccion,
        'departamento' => $despachos[$i]->departamento,
        'ciudad' => $despachos[$i]->ciudad,
        'phone' => $despachos[$i]->phone,
        'created_at' => $carbon->parse($despachos[$i]->created_at)->format('d-m-Y'),
        'factura_numero' => $despachos[$i]->factura_numero,
        'ncaja' => $despachos[$i]->ncaja,
        'cajas' => $despachos[$i]->cajas,
        'cantidad'  => $despachos[$i]->cantidad,
        'peso'  => $despachos[$i]->peso,
        'ndespacho'  => $despachos[$i]->ndespacho,
        'npedido'  => $despachos[$i]->npedido,
        'filtro' => $despachos[$i]->filtro,
        'usuario'  => explode(' ',$user->names)[0].' '.explode(' ',$user->apellidos)[0]
    );
        array_push($arrayData,$arr);
    }
    return json_encode($arrayData);
});

Route::post('readqr/store',[App\Http\Controllers\UserController::class,'storeDespachoQR'])->name('store.qr.despacho');


Route::get('tiposolicitudes', [App\Http\Controllers\TipoSolicitudController::class,'getTipos']);
Route::get('consultaReferencia/{referencia}',[App\Http\Controllers\IndexController::class,'consultaReferencia']);
Route::post('consultaRefColor',[App\Http\Controllers\IndexController::class,'consultaRefColor']);

Route::get('infophp',[App\Http\Controllers\IndexController::class,'phpINFO']);

Route::group(['prefix' => 'bank'], function()  {
    Route::post('/store/img',[App\Http\Controllers\BankImgController::class,'fileStore'])->name('bank.store.img');
    Route::post('/item/get/',[App\Http\Controllers\BankImgController::class,'getItemCodBarra'])->name('bank.get.item');
    Route::get('/referencia/check',[App\Http\Controllers\BankImgController::class,'index'])->name('bank.referencia.check');
}); 

Route::get('/contador-prendas',[App\Http\Controllers\ContadorPrendasController::class,'index']);
Route::get('/contador-prendas/individual',[App\Http\Controllers\ContadorPrendasController::class,'individual']);
Route::get('/contador-prendas/individual/{idtranslado}',[App\Http\Controllers\ContadorPrendasController::class,'individualTransladoID']);

Route::post('sincronize/siesa_empleados',[App\Http\Controllers\SiesaController::class,'sincronize_empleados']);
Route::post('sincronize/siesa_terceros', [App\Http\Controllers\SiesaController::class,'sincronize_clientes']);
Route::get('sincronizar/siesa/terceros', function () {
    return view('sincronizar.terceros_siesa');
})->name('sincronize.terceros');

Route::get('sincronizar/siesa/system_productos_siesa', function () {
    return view('sincronizar.productos_siesa_system_productos');
})->name('sincronizar.siesaProductos');

Route::get('reprogramaciones', function () {
    return view('sincronizar.subirReprogramacionesLorena');
});


Route::get('listaReprogramaciones', function () {
    return view('sincronizar.listaReprogramaciones');
});

Route::get('getListadoReprogramaciones',[App\Http\Controllers\IndexController::class,'getListadoReprogramaciones']);

Route::post('sincronizar/siesa/submitproductosSiesa_Manual',[App\Http\Controllers\SiesaController::class,'submitproductosSiesa_Manual']);



Route::post('reprogramaciones/subirPost',[App\Http\Controllers\IndexController::class,'lecturaArchivoLorena']);


Route::group(['prefix' => 'sisdespachos'], function()  {
    Route::get('/', function () { return view('sisdespachos.exportar'); });
    Route::post('quitarOperarioDelaOrden',[App\Http\Controllers\Despachos\OrdenDespachoController::class,'quitarOperarioDelaOrden']);
    Route::get('ordenes-despacho/list', function () { return view('sisdespachos.ordenes.list'); })->name('ordenes.despacho');
    Route::get('ordenes-despacho/view-curva/{id}',[App\Http\Controllers\Despachos\OrdenDespachoController::class,'viewCurva'])->name('ordenes.viewcurva');
    Route::post('ordenes-despacho/submitordenes',[App\Http\Controllers\Despachos\OrdenDespachoController::class,'cargaMasiva'])->name('submit.ordenes.despacho');
    Route::get('ordenes-despacho/getordenes',[App\Http\Controllers\Despachos\OrdenDespachoController::class,'getOrdenes']);
    Route::post('ordenes-despacho/getForFecha',[App\Http\Controllers\Despachos\OrdenDespachoController::class,'getOrdenesPorFecha']);
    Route::get('ordenes-despacho/pendienteAlistar',[App\Http\Controllers\Despachos\OrdenDespachoController::class,'getPendientesPorAlistar'])->name('pendiente.alistarr');
    Route::get('ordenes-despacho/getDataPendienteAlistar',[App\Http\Controllers\Despachos\OrdenDespachoController::class,'getDataPendienteAlistar'])->name('pendiente.alistar');
    Route::post('ordenes-despacho/createAlistamiento',[App\Http\Controllers\Despachos\OrdenDespachoController::class,'createAlistamiento']);
    Route::get('ordenes-despacho/getCurvaDespacho/{consecutivo}',[App\Http\Controllers\Despachos\OrdenDespachoController::class,'getCurvaDespacho']);
    Route::get('ordenes-despacho/getCurvaAlistamientoV2/{consecutivo}',[App\Http\Controllers\Despachos\OrdenDespachoController::class,'getCurvaAlistamientoConsecutivo']);
    Route::post('ordenes-despacho/getCurvaAlistamiento',[App\Http\Controllers\Despachos\OrdenDespachoController::class,'getCurvaAlistamiento']);
    Route::post('ordenes-despacho/validaSiTieneOrden',[App\Http\Controllers\Despachos\OrdenDespachoController::class,'validaSiTieneOrden']);
    Route::post('ordenes-despacho/deleteAlistamiento',[App\Http\Controllers\Despachos\OrdenDespachoController::class,'deleteAlistamiento']);
    Route::post('ordenes-despacho/mandarARevisar',[App\Http\Controllers\Despachos\OrdenDespachoController::class,'mandarARevisar']);
    Route::get('ordenes-despacho/getOrdenAlistamiento/{consecutivo}',[App\Http\Controllers\Despachos\OrdenDespachoController::class,'getOrdenAlistamiento']);
    Route::post('ordenes-despacho/marcarCompletada',[App\Http\Controllers\Despachos\OrdenDespachoController::class,'marcarCompletada']);
    Route::get('ordenes-despacho/pendienteEmpacar',[App\Http\Controllers\Despachos\OrdenDespachoController::class,'pendienteEmpacar'])->name('pendiente.empacar');
    Route::get('ordenes-despacho/getDataPendienteEmpacar',[App\Http\Controllers\Despachos\OrdenDespachoController::class,'getDataPendienteEmpacar'])->name('pendiente.alistar');
    Route::get('ordenes-despacho/getOrdenEmpacado/{consecutivo}',[App\Http\Controllers\Despachos\OrdenDespachoController::class,'getOrdenEmpacado']);
    Route::post('ordenes-despacho/createEmpacado',[App\Http\Controllers\Despachos\OrdenDespachoController::class,'createEmpacado']);
    Route::post('ordenes-despacho/getCurvaEmpacado',[App\Http\Controllers\Despachos\OrdenDespachoController::class,'getCurvaEmpacado']);
    Route::post('ordenes-despacho/validaSiTieneOrdenEmpacado',[App\Http\Controllers\Despachos\OrdenDespachoController::class,'validaSiTieneOrdenEmpacado']);
    Route::post('ordenes-despacho/deleteEmpacado',[App\Http\Controllers\Despachos\OrdenDespachoController::class,'deleteEmpacado']);
    Route::post('ordenes-despacho/marcarCompletadaEmpacado',[App\Http\Controllers\Despachos\OrdenDespachoController::class,'marcarCompletadaEmpacado']);
    Route::post('ordenes-despacho/getEmpaques',[App\Http\Controllers\Despachos\OrdenDespachoController::class,'getEmpaques']);
    Route::post('ordenes-despacho/getDetailsEmpaque', [App\Http\Controllers\Despachos\OrdenDespachoController::class,'getDetallesEmpaque']);
    Route::post('ordenes-despacho/createEmpaque', [App\Http\Controllers\Despachos\OrdenDespachoController::class,'createEmpaque']);
    Route::post('ordenes-despacho/deleteEmpaque', [App\Http\Controllers\Despachos\OrdenDespachoController::class,'deleteEmpaque']);
    Route::post('ordenes-despacho/getEmpaque', [App\Http\Controllers\Despachos\OrdenDespachoController::class,'getEmpaque']);
    Route::post('ordenes-despacho/marcarCierreEmpaque', [App\Http\Controllers\Despachos\OrdenDespachoController::class,'marcarCierreEmpaque']);
    Route::get('ordenes-despacho/pendienteFacturar', [App\Http\Controllers\Despachos\OrdenDespachoController::class,'viewFacturar'])->name('pendienteFacturar');
    Route::get('ordenes-despacho/getordenesParaFacturar', [App\Http\Controllers\Despachos\OrdenDespachoController::class,'getordenesParaFacturar']);
    Route::get('view-proceso/consecutivo/{consecutivo}', [App\Http\Controllers\Despachos\OrdenDespachoController::class,'viewProcesoConsecutivo']);
    Route::get('ordenes-despacho/view-proceso/consecutivo/{consecutivo}', [App\Http\Controllers\Despachos\OrdenDespachoController::class,'viewProcesoConsecutivoDespacho'])->name('viewprocesodespacho');
    Route::post('ordenes-despacho/saveNumFacturas', [App\Http\Controllers\Despachos\OrdenDespachoController::class,'saveNumFacturas']);
    Route::get('ordenes-despacho/revisarOrdenes', [App\Http\Controllers\Despachos\OrdenDespachoController::class,'revisarOrdenes'])->name('ordenesrevisar');
    Route::get('ordenes-despacho/ordenesRevisionGet', [App\Http\Controllers\Despachos\OrdenDespachoController::class,'getOrdenesPendienteRevision']);
    Route::get('ordenes-despacho/getOrdenDespacho/{consecutivo}', [App\Http\Controllers\Despachos\OrdenDespachoController::class,'getOrdenDespacho']);
    Route::get('ordenes-despacho/getDetailsOrdenDespacho/{consecutivo}', [App\Http\Controllers\Despachos\OrdenDespachoController::class,'getDetailsOrdenDespacho']);
    Route::get('ordenes-despacho/getDetailAlistamiento/{consecutivo}', [App\Http\Controllers\Despachos\OrdenDespachoController::class,'getDetailAlistamiento']);
    Route::get('ordenes-despacho/getDetailAlistamientoRevisar/{consecutivo}', [App\Http\Controllers\Despachos\OrdenDespachoController::class,'getDetailAlistamientoRevisar']);
    Route::post('ordenes-despacho/alistarDeNuevo', [App\Http\Controllers\Despachos\OrdenDespachoController::class,'alistarDeNuevo']);
    Route::post('ordenes-despacho/rechazaOrdenDespacho', [App\Http\Controllers\Despachos\OrdenDespachoController::class,'rechazaOrdenDespacho']);
    Route::post('ordenes-despacho/apruebaOrdenDespacho', [App\Http\Controllers\Despachos\OrdenDespachoController::class,'apruebaOrdenDespacho']);
    Route::get('ordenes-despacho/viewCurvaPDF/{consecutivo}', [App\Http\Controllers\Despachos\OrdenDespachoController::class,'viewCurvaPDF']);
    Route::get('ordenes-despacho/infoOrdenAlistamiento/{consecutivo}', [App\Http\Controllers\Despachos\OrdenDespachoController::class,'infoOrdenAlistamiento']);
    Route::get('ordenes-despacho/viewAlistamiento/{id}', [App\Http\Controllers\Despachos\OrdenDespachoController::class,'viewAlistamiento']);
    Route::get('ordenes-despacho/viewEmpacado/{id}', [App\Http\Controllers\Despachos\OrdenDespachoController::class,'viewEmpacado']);
    Route::get('ordenes-despacho/viewCurvaPDFEmpacado/{consecutivo}', [App\Http\Controllers\Despachos\OrdenDespachoController::class,'viewCurvaPDFEmpacado']);
    Route::get('ordenes-despacho/despachosQrAgil', function () {return view('despachos.marcarDespacho');})->name('marcar.despacho');
    Route::post('ordenes-despacho/marcarDespacho', [App\Http\Controllers\Despachos\OrdenDespachoController::class,'marcarDespacho']);
    Route::get('ordenes-despacho/rastrearConsecutivo', function () {return view('despachos.rastrearConsecutivo');})->name('marcar.rastrearConsecutivo');
    
    
    Route::get('facturacionPDF/generar/{consecutivo}', [App\Http\Controllers\Despachos\OrdenDespachoController::class,'viewPDFacturacion']);
    
    
}); 

Route::get('empleado/{documento}', [App\Http\Controllers\EmpleadoController::class,'getEmpleado']);
Route::post('empleadoModificar', [App\Http\Controllers\EmpleadoController::class,'disminuirCupoEmpleado']);


Route::post('sendSMSEmpleadoLibranza', [App\Http\Controllers\EmpleadoController::class,'sendSMSAutenticacion']);
Route::post('validarCodigoSMS', [App\Http\Controllers\EmpleadoController::class,'validarSMSCode']);
Route::post('saveTelefonoEmpleado', [App\Http\Controllers\EmpleadoController::class,'saveTelefonoE']);
Route::get('getLibranzasTienda', [App\Http\Controllers\EmpleadoController::class,'getLibranzasTienda']);


Route::post('libranza/subirDescuentosLibranzaManual',[App\Http\Controllers\EmpleadoController::class,'submitDescuentos_Manual']);


Route::get('getLibranzasEmpleados', [App\Http\Controllers\EmpleadoController::class,'getLibranzasEmpleados']);
Route::post('cancelarCodigo', [App\Http\Controllers\EmpleadoController::class,'cancelarCodigo']);

Route::post('getHistorialMovsLibEmp', [App\Http\Controllers\EmpleadoController::class,'getHistorialMovimientosEmpleado']);


Route::get('consultaNumeroTelefono/{telefono}', [App\Http\Controllers\Despachos\EcommerceController::class,'consultaNumeroTelefono']);
Route::post('ecommerce/save', [App\Http\Controllers\Despachos\EcommerceController::class,'saveContact']);
Route::get('ecommerce/listClientes',[App\Http\Controllers\Despachos\EcommerceController::class,'ListClientes']);
Route::get('ecommerce/listadoClientes', function () {return view('listadoClientesEcommerce');});
Route::get('getClienteList/{telefono}',[App\Http\Controllers\Despachos\EcommerceController::class,'getClienteList']);
Route::get('/ecommerce/exportarListado',function () {return view('ecommerce.exportar');});
Route::get('exportarListadoExcelController/{fecha1}/{fecha2}', [App\Http\Controllers\Despachos\EcommerceController::class,'exportarListadoExcelController']);
Route::get('/ecommerce/reporteDiario',function () {return view('ecommerce.reporteDiario');});
Route::get('/ecommerce/obtenerVentasVendedores/{fecha1}/{fecha2}',[App\Http\Controllers\Despachos\EcommerceController::class,'getVendedoresCantidad']);


Route::get('exportarListadoDespachos/{fecha1}/{fecha2}', [App\Http\Controllers\Despachos\OrdenDespachoController::class,'exportarListadoDespachos']);

Route::post('/getLoteConteo',[App\Http\Controllers\RefTransladosController::class,'getLoteConteo']);
Route::post('/saveReferencias',[App\Http\Controllers\RefTransladosController::class,'saveReferencias']);
Route::post('/DeleteConteo',[App\Http\Controllers\RefTransladosController::class,'DeleteConteo']); 


//RUTAS PARA CREAR TELAS
Route::get('/telaCreateC','App\Http\Controllers\RollosController@telas_store')->name('createTela.viewCreate');
Route::get('/{id}/telaCreate','App\Http\Controllers\RollosController@telas_store')->name('createTela.viewEdit');

Route::get('/telas/list','App\Http\Controllers\RollosController@index_telas')->name('list_telas');
Route::get('/telas','App\Http\Controllers\RollosController@telas_create')->name('create_telas');
Route::get('/telas_store','App\Http\Controllers\RollosController@telas_store')->name('telas_store');
Route::get('/telas/{id}','App\Http\Controllers\RollosController@telas_edit')->name('edit_telas');
Route::get('/telas/{id}/telas_update','App\Http\Controllers\RollosController@telas_update')->name('telas_update');
Route::get('/telas/{id}/estado','App\Http\Controllers\RollosController@estado_telas')->name('telas_estado');
//RUTAS DE ORDEN DE CORTE
Route::get('/corte/list','App\Http\Controllers\OrdenDeCorteController@index')->name('indexC');
Route::get('/corte/list/inactivas','App\Http\Controllers\OrdenDeCorteController@index_inactivas')->name('indexI');
Route::get('/corteCreate','App\Http\Controllers\OrdenDeCorteController@create')->name('createC');
Route::post('/corteStore','App\Http\Controllers\OrdenDeCorteController@store')->name('storeC');
Route::get('/corteEdit/{id}','App\Http\Controllers\OrdenDeCorteController@edit')->name('editC');
Route::post('/corteUpdate/{id}','App\Http\Controllers\OrdenDeCorteController@update')->name('updateC');
Route::get('/corteShow/{id}','App\Http\Controllers\OrdenDeCorteController@show')->name('showC');
Route::get('/corteDelete/{id}','App\Http\Controllers\OrdenDeCorteController@destroy')->name('destroyC');
Route::get('/updateE/{id}','App\Http\Controllers\OrdenDeCorteController@estado')->name('updateEstadoCorte');
//RUTAS PARA CREACION DE ROLLOS
Route::get('/rollos/list','App\Http\Controllers\RollosController@index')->name('list_rollos');
Route::get('/rollos/list/telas','App\Http\Controllers\RollosController@index_disponibles')->name('list_rollos_tela');
Route::get('/rollos/list/consulta','App\Http\Controllers\RollosController@disponibles_consulta')->name('list_rollos_tela_consulta');
Route::get('/rollos','App\Http\Controllers\RollosController@create')->name('create_rollos');
Route::get('/rollos_store','App\Http\Controllers\RollosController@store')->name('rollos_store');
Route::get('/rollos/{id}','App\Http\Controllers\RollosController@edit')->name('edit_rollos');
Route::get('/rollos/{id}/rollos_update','App\Http\Controllers\RollosController@update')->name('rollos_update');
Route::get('/rollos/{id}/estado','App\Http\Controllers\RollosController@estado')->name('rollos_estado');
//RUTAS PARA CREAR PARADAS PROGRAMADAS Y NO PROGRAMADAS
Route::get('/parada_no_prg_store','App\Http\Controllers\ConfeccionController@parada_no_prg_store')->name('parada_no_prg_store');
Route::get('/parada_prg_store','App\Http\Controllers\ConfeccionController@parada_prg_store')->name('parada_prg_store');
Route::get('/{id}/parada_no_prg_store','App\Http\Controllers\ConfeccionController@parada_no_prg_store')->name('parada_no_prg_store');
Route::get('/{id}/parada_prg_store','App\Http\Controllers\ConfeccionController@parada_prg_store')->name('parada_prg_store');
//RUTAS PARA MODULOS DE CONFECCION
Route::get('/modulos/excel','App\Http\Controllers\ConfeccionController@download_excel')->name('download_excel_modulos');
Route::get('/modulos/list','App\Http\Controllers\ConfeccionController@index_modulos')->name('list_modulos');
Route::get('/modulos/list/hoy','App\Http\Controllers\ConfeccionController@index_modulos_hoy')->name('list_modulos_hoy');
Route::get('/modulos','App\Http\Controllers\ConfeccionController@create_modulos')->name('create_modulos');
Route::get('/modulos_store','App\Http\Controllers\ConfeccionController@store_modulos')->name('modulos_store');
Route::get('/modulos/{id}','App\Http\Controllers\ConfeccionController@edit_modulos')->name('edit_modulos');
Route::get('/modulos/{id}/modulos_update','App\Http\Controllers\ConfeccionController@update_modulos')->name('modulos_update');
Route::get('/modulos/{id}/modulos_delete','App\Http\Controllers\ConfeccionController@delete_modulos')->name('delete_modulos');
Route::get('/modulos/eficiencia/{id}','App\Http\Controllers\ConfeccionController@eficiencia')->name('eficiencia');
//RUTAS PARA CREACION DE REFERENCIAS
Route::get('/referencias/list','App\Http\Controllers\ConfeccionController@index_referencias')->name('list_referencias');
Route::get('/referencias/list/consulta','App\Http\Controllers\ConfeccionController@index_referencias_consulta')->name('index_referencias_consulta');
Route::get('/referencias','App\Http\Controllers\ConfeccionController@create_referencias')->name('create_referencias');
Route::get('/referencias_store','App\Http\Controllers\ConfeccionController@store_referencias')->name('referencias_store_c');
Route::get('/modulos/{id}/referencias_store','App\Http\Controllers\ConfeccionController@store_referencias')->name('referencias_store_e');
Route::get('/referencias_validar','App\Http\Controllers\ConfeccionController@validar_referencias')->name('referencias_validar_c');
Route::get('/modulos/{id}/referencias_validar','App\Http\Controllers\ConfeccionController@validar_referencias')->name('referencias_validar_e');
Route::get('/referencias/{id}','App\Http\Controllers\ConfeccionController@edit_referencias')->name('edit_referencias');
Route::get('/referencias/{id}/referencias_update','App\Http\Controllers\ConfeccionController@update_referencias')->name('referencias_update');
Route::get('/consultar_lote','App\Http\Controllers\ConfeccionController@consultar_lote')->name('consultar_lote_c');
Route::get('/modulos/{id}/consultar_lote','App\Http\Controllers\ConfeccionController@consultar_lote_new')->name('consultar_lote_e');
//RUTAS PARA CONTROL DE CALIDAD DE PRENDAS
Route::get('/prendas/list','App\Http\Controllers\PrendasConfeccionController@index')->name('list_prendas');
Route::get('/prendas/list/hoy','App\Http\Controllers\PrendasConfeccionController@index_hoy')->name('list_prendas_hoy');
Route::get('/prendas','App\Http\Controllers\PrendasConfeccionController@create')->name('create_prendas');
Route::get('/referencia_validar','App\Http\Controllers\PrendasConfeccionController@referencia_validar')->name('referencia_validar_c');
Route::get('/prendas/{id}/referencia_validar','App\Http\Controllers\PrendasConfeccionController@referencia_validar')->name('referencia_validar_e');
Route::get('/prendas_store','App\Http\Controllers\PrendasConfeccionController@store')->name('prendas_store');
Route::get('/prendas/{id}','App\Http\Controllers\PrendasConfeccionController@edit')->name('edit_prendas');
Route::get('/prendas/{id}/prendas_update','App\Http\Controllers\PrendasConfeccionController@update')->name('prendas_update');
//RUTAS PARA MODULOS DE TERMINACION
Route::get('/terminacion/excel','App\Http\Controllers\TerminacionController@download_excel')->name('download_excel_terminacion');
Route::get('/terminacion/list','App\Http\Controllers\TerminacionController@index_terminacion')->name('list_terminacion');
Route::get('/terminacion/list/hoy','App\Http\Controllers\TerminacionController@index_terminacion_hoy')->name('list_terminacion_hoy');
Route::get('/terminacion','App\Http\Controllers\TerminacionController@create_terminacion')->name('create_terminacion');
Route::get('/terminacion_store','App\Http\Controllers\TerminacionController@store_terminacion')->name('store_terminacion');
Route::get('/referencia_consulta','App\Http\Controllers\TerminacionController@referencia_consulta')->name('referencia_consulta_c');
Route::get('/terminacion/{id}','App\Http\Controllers\TerminacionController@edit_terminacion')->name('edit_terminacion');
Route::get('/terminacion/{id}/terminacion_update','App\Http\Controllers\TerminacionController@update_terminacion')->name('update_terminacion');
Route::get('/terminacion/{id}/terminacion_delete','App\Http\Controllers\TerminacionController@delete_terminacion')->name('delete_terminacion');
Route::get('/terminacion/{id}/referencia_consulta','App\Http\Controllers\TerminacionController@referencia_consulta')->name('referencia_consulta_e');
Route::get('/terminacion/eficiencia/{id}','App\Http\Controllers\TerminacionController@eficiencia')->name('eficiencia_terminacion');
Route::get('/lote_referencia','App\Http\Controllers\TerminacionController@lote_referencia')->name('lote_referencia_c');
Route::get('/terminacion/{id}/lote_referencia','App\Http\Controllers\TerminacionController@lote_referencia_new')->name('lote_referencia_e');
//RUTAS PARA PICKING ANTIGUO
Route::get('/picking/list','App\Http\Controllers\PickingAntiguoController@picking_list')->name('picking_list');
Route::get('/picking/list/hoy','App\Http\Controllers\PickingAntiguoController@picking_list_hoy')->name('picking_list_hoy');
Route::get('/picking/list/hoy/user','App\Http\Controllers\PickingAntiguoController@picking_list_hoy_user')->name('picking_list_hoy_user');
Route::get('/picking','App\Http\Controllers\PickingAntiguoController@picking_create')->name('picking_create');
Route::get('/picking_store','App\Http\Controllers\PickingAntiguoController@picking_store')->name('picking_store');
Route::get('/picking/list/picking_update','App\Http\Controllers\PickingAntiguoController@picking_update')->name('picking_update');
Route::get('/picking/picking_update','App\Http\Controllers\PickingAntiguoController@picking_update')->name('picking_update');
Route::get('/picking_consulta','App\Http\Controllers\PickingAntiguoController@picking_consulta')->name('picking_consulta');
//RUTAS PARA PICKING NUEVO
Route::get('/orden_picking_historial/list/rechazados','App\Http\Controllers\PickingController@picking_historial_list')->name('picking_historial_list');
Route::get('/orden_picking_historial/list/rechazados/consulta','App\Http\Controllers\PickingController@picking_historial_consulta')->name('picking_historial_consulta');
Route::get('/orden_picking/list','App\Http\Controllers\PickingController@orden_picking_list')->name('orden_picking_list');
Route::get('/orden_picking/list/consulta/terminacion','App\Http\Controllers\PickingController@terminacion_consulta')->name('terminacion_consulta');
Route::get('/orden_picking/list/consulta/bodega','App\Http\Controllers\PickingController@bodega_consulta')->name('bodega_consulta');
Route::get('/orden_picking','App\Http\Controllers\PickingController@orden_picking_create')->name('orden_picking_create');
Route::get('/orden_picking_store','App\Http\Controllers\PickingController@orden_picking_store')->name('store_orden_picking');
Route::get('/orden_picking_control/{id}','App\Http\Controllers\PickingController@repicking_orden_picking')->name('repicking_orden_picking');
Route::post('/orden_picking_control/picking_store','App\Http\Controllers\PickingController@repicking_orden_picking_store')->name('repicking_orden_picking_store');
Route::get('/orden_picking_control/{id}/picking_consulta','App\Http\Controllers\PickingController@picking_consulta')->name('repicking_orden_picking_consulta');
Route::get('/orden_picking_control/{id}/consulta_cantidad','App\Http\Controllers\PickingController@consulta_cantidad')->name('repicking_orden_picking_consulta_cantidad');
Route::get('/orden_picking/reporte_terminacion','App\Http\Controllers\PickingController@reporteTerminacion')->name('orden_picking_reporteTerminacion');
Route::get('/orden_picking/reporte_terminacion/generar','App\Http\Controllers\PickingController@reporteTerminacion_generar')->name('orden_picking_reporteTerminacion_generar');
Route::get('/orden_picking/reporte_bodega','App\Http\Controllers\PickingController@reporteBodega')->name('orden_picking_reporteBodega');
Route::get('/orden_picking/reporte_bodega/generar','App\Http\Controllers\PickingController@reporteBodega_generar')->name('orden_picking_reporteBodega_generar');

//Terminacion
Route::post('/terminacion_picking/picking_store','App\Http\Controllers\PickingController@picking_terminacion_store')->name('picking_terminacion_store');
Route::get('/terminacion_picking/list','App\Http\Controllers\PickingController@picking_terminacion_list')->name('picking_terminacion_list');
Route::get('/terminacion_picking/{id}','App\Http\Controllers\PickingController@terminacion_picking_create')->name('terminacion_picking_create');
Route::get('/terminacion_picking/{id}/picking_consulta','App\Http\Controllers\PickingController@picking_consulta')->name('picking_consulta');

//Bodega
Route::get('/bodega_picking/list/gestion','App\Http\Controllers\PickingController@bodega_list')->name('bodega_list');
Route::get('/bodega_picking/list/gestion/consulta','App\Http\Controllers\PickingController@bodega_list_consulta')->name('bodega_list_consulta');
Route::get('/bodega_picking/list','App\Http\Controllers\PickingController@picking_bodega_list')->name('picking_bodega_list');
Route::get('/bodega_picking/{id}','App\Http\Controllers\PickingController@bodega_picking_create')->name('bodega_picking_create');
Route::get('/bodega_picking/{id}/picking_consulta','App\Http\Controllers\PickingController@picking_consulta')->name('picking_consulta');
Route::get('/bodega_picking/{id}/consulta_cantidad','App\Http\Controllers\PickingController@consulta_cantidad')->name('consulta_cantidad');
Route::post('/bodega_picking/picking_store','App\Http\Controllers\PickingController@picking_bodega_store')->name('picking_bodega_store_save');

//Bodega repicking
Route::get('/bodega_picking/{id}/revision','App\Http\Controllers\PickingController@revision_picking_bodega')->name('revision_picking_bodega');
Route::get('/bodega_picking/{id}/aceptar','App\Http\Controllers\PickingController@aceptar_picking_bodega')->name('aceptar_picking_bodega');
Route::get('/bodega_picking/{id}/rechazar','App\Http\Controllers\PickingController@rechazar_picking_bodega')->name('rechazar_picking_bodega');
Route::get('/bodega_repicking/{id}/repicking','App\Http\Controllers\PickingController@repicking_picking_bodega')->name('repicking_picking_bodega');
Route::post('/bodega_repicking/picking_store','App\Http\Controllers\PickingController@repicking_bodega_store')->name('repicking_bodega_store');
Route::get('/bodega_repicking/{id}/picking_consulta','App\Http\Controllers\PickingController@picking_consulta')->name('repicking_consulta');
Route::get('/bodega_repicking/{id}/consulta_cantidad','App\Http\Controllers\PickingController@consulta_cantidad')->name('consulta_cantidad');
//RUTAS PARA MODULOS DE ENSAMBLE
Route::get('/ensamble/reporte/operario','App\Http\Controllers\EnsambleController@reporte_ensamble_operario')->name('reporte_ensamble_operario');
Route::get('/ensamble/reporte/operario/consulta','App\Http\Controllers\EnsambleController@reporte_operario_consulta')->name('reporte_operario_consulta');
Route::get('/ensamble/reporte/modulo','App\Http\Controllers\EnsambleController@reporte_ensamble_modulo')->name('reporte_ensamble_modulo');
Route::get('/ensamble/reporte/modulo/consulta','App\Http\Controllers\EnsambleController@reporte_modulo_consulta')->name('reporte_modulo_consulta');
Route::get('/ensamble/excel','App\Http\Controllers\EnsambleController@download_excel')->name('download_excel_ensamble');
Route::get('/ensamble/list','App\Http\Controllers\EnsambleController@index_ensamble')->name('list_ensamble');
Route::get('/ensamble/list/hoy','App\Http\Controllers\EnsambleController@index_ensamble_hoy')->name('list_ensamble_hoy');
Route::get('/ensamble','App\Http\Controllers\EnsambleController@create_ensamble')->name('create_ensamble');
Route::get('/ensamble_store','App\Http\Controllers\EnsambleController@store_ensamble')->name('store_ensamble');
Route::get('/ensamble/masivo','App\Http\Controllers\EnsambleController@create_ensamble_masivo')->name('create_ensamble_masivo');
Route::get('/ensamble_store/masivo','App\Http\Controllers\EnsambleController@store_ensamble_masivo')->name('store_ensamble_masivo');
Route::get('/ensamble/{id}','App\Http\Controllers\EnsambleController@edit_ensamble')->name('edit_ensamble');
Route::get('/ensamble/{id}/ensamble_update','App\Http\Controllers\EnsambleController@update_ensamble')->name('update_ensamble');
Route::get('/ensamble/{id}/ensamble_delete','App\Http\Controllers\EnsambleController@delete_ensamble')->name('delete_ensamble');
Route::get('/ensamble/eficiencia/{id}','App\Http\Controllers\EnsambleController@eficiencia')->name('eficiencia_ensamble');
Route::get('/consulta_lote','App\Http\Controllers\EnsambleController@consulta_lote')->name('consulta_lote_c');
Route::get('/ensamble/{id}/consulta_lote','App\Http\Controllers\EnsambleController@consulta_lote_new')->name('consulta_lote_e');
//RUTAS PARA MODULOS DE PREPARACION
Route::get('/preparacion/reporte/operario','App\Http\Controllers\PreparacionController@reporte_preparacion_operario')->name('reporte_preparacion_operario');
Route::get('/preparacion/reporte/operario/consulta','App\Http\Controllers\PreparacionController@reporte_operario_consulta')->name('reporte_operario_consulta');
Route::get('/preparacion/reporte/modulo','App\Http\Controllers\PreparacionController@reporte_preparacion_modulo')->name('reporte_preparacion_modulo');
Route::get('/preparacion/reporte/modulo/consulta','App\Http\Controllers\PreparacionController@reporte_modulo_consulta')->name('reporte_modulo_consulta');
Route::get('/preparacion/excel','App\Http\Controllers\PreparacionController@download_excel')->name('download_excel_preparacion');
Route::get('/preparacion/list','App\Http\Controllers\PreparacionController@index_preparacion')->name('list_preparacion');
Route::get('/preparacion/list/hoy','App\Http\Controllers\PreparacionController@index_preparacion_hoy')->name('list_preparacion_hoy');
Route::get('/preparacion','App\Http\Controllers\PreparacionController@create_preparacion')->name('create_preparacion');
Route::get('/preparacion_store','App\Http\Controllers\PreparacionController@store_preparacion')->name('store_preparacion');
Route::get('/preparacion/masivo','App\Http\Controllers\PreparacionController@create_preparacion_masivo')->name('create_preparacion_masivo');
Route::get('/preparacion_store/masivo','App\Http\Controllers\PreparacionController@store_preparacion_masivo')->name('store_preparacion_masivo');
Route::get('/preparacion/{id}','App\Http\Controllers\PreparacionController@edit_preparacion')->name('edit_preparacion');
Route::get('/preparacion/{id}/preparacion_update','App\Http\Controllers\PreparacionController@update_preparacion')->name('update_preparacion');
Route::get('/preparacion/{id}/preparacion_delete','App\Http\Controllers\PreparacionController@delete_preparacion')->name('delete_preparacion');
Route::get('/preparacion/{id}/referencia_consulta','App\Http\Controllers\PreparacionController@referencia_consulta')->name('referencia_consulta_e');
Route::get('/preparacion/eficiencia/{id}','App\Http\Controllers\PreparacionController@eficiencia')->name('eficiencia_preparacion');
Route::get('/lote_consulta','App\Http\Controllers\PreparacionController@lote_consulta')->name('lote_consulta_c');
Route::get('/preparacion/{id}/lote_consulta','App\Http\Controllers\PreparacionController@lote_consulta_new')->name('lote_consulta_e');


//RUTAS PARA MODULOS DE CONFECCION STARA
Route::get('/modulos_stara/excel','App\Http\Controllers\ConfeccionStaraController@download_excel')->name('download_excel_modulos_stara');
Route::get('/modulos_stara/list','App\Http\Controllers\ConfeccionStaraController@index_modulos')->name('list_modulos_stara');
Route::get('/modulos_stara/list/hoy','App\Http\Controllers\ConfeccionStaraController@index_modulos_hoy')->name('list_modulos_stara_hoy');
Route::get('/modulos_stara','App\Http\Controllers\ConfeccionStaraController@create_modulos')->name('create_modulos_stara');
Route::get('/modulos_stara_store','App\Http\Controllers\ConfeccionStaraController@store_modulos')->name('modulos_stara_store');
Route::get('/modulos_stara/{id}','App\Http\Controllers\ConfeccionStaraController@edit_modulos')->name('edit_modulos_stara');
Route::get('/modulos_stara/{id}/modulos_update','App\Http\Controllers\ConfeccionStaraController@update_modulos')->name('modulos_stara_update');
Route::get('/modulos_stara/{id}/modulos_delete','App\Http\Controllers\ConfeccionStaraController@delete_modulos')->name('delete_stara_modulos');
Route::get('/modulos_stara/eficiencia/{id}','App\Http\Controllers\ConfeccionStaraController@eficiencia')->name('eficiencia_stara');

//RUTAS PARA CREACION DE REFERENCIAS STARA
Route::get('/referencias_stara/list','App\Http\Controllers\ConfeccionStaraController@index_referencias')->name('list_referencias_stara');
Route::get('/referencias_stara/list/consulta','App\Http\Controllers\ConfeccionStaraController@index_referencias_consulta')->name('index_referencias_stara_consulta');
Route::get('/referencias_stara','App\Http\Controllers\ConfeccionStaraController@create_referencias')->name('create_referencias_stara');
Route::get('/referencias_stara_store','App\Http\Controllers\ConfeccionStaraController@store_referencias')->name('referencias_stara_store_c');
Route::get('/modulos_stara/{id}/referencias_store','App\Http\Controllers\ConfeccionStaraController@store_referencias')->name('referencias_stara_store_e');
Route::get('/referencias_stara_validar','App\Http\Controllers\ConfeccionStaraController@validar_referencias')->name('referencias_stara_validar_c');
Route::get('/modulos_stara/{id}/referencias_validar','App\Http\Controllers\ConfeccionStaraController@validar_referencias')->name('referencias_stara_validar_e');
Route::get('/referencias_stara/{id}','App\Http\Controllers\ConfeccionStaraController@edit_referencias')->name('edit_referencias_stara');
Route::get('/referencias_stara/{id}/referencias_update','App\Http\Controllers\ConfeccionStaraController@update_referencias')->name('referencias_stara_update');
Route::get('/consultar_lote_stara','App\Http\Controllers\ConfeccionStaraController@consultar_lote')->name('consultar_lote_stara_c');
Route::get('/modulos_stara/{id}/consultar_lote','App\Http\Controllers\ConfeccionStaraController@consultar_lote_new')->name('consultar_lote_stara_e');
