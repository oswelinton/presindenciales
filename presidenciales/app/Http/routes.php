<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/', function () {
	return view('auth.login');
});
Route::group(['middleware' => 'auth'], function () {
    Route::get('Inicio', 'PresidencialesController@BsCedula');
    Route::get('cedulaempleado/{ci}', 'PresidencialesController@Bcedula');
    Route::get('buscarcedula', 'PresidencialesController@BsCedula');
    Route::post('estadoempleado', 'PresidencialesController@estadoempleado');
    Route::get('/viewReportes', 'PresidencialesController@viewReportes');
    Route::get('/reportes/{tipoconsulta}/{intervalo}', 'PresidencialesController@reportes');
    // Route::get('/reportes/{tipoconsulta}', 'PresidencialesController@reportes');

    Route::get('/viewGraficas', 'PresidencialesController@viewGraficas');
    Route::get('graficaJSON', 'PresidencialesController@graficaJSON');
    Route::get('graficaEstados/{estado}', 'PresidencialesController@graficaEstados');
    Route::get('graficaEstadosJSON/{estado}', 'PresidencialesController@graficaEstadosJSON');
    Route::get('graficaEstadosJSON2/{estado}', 'PresidencialesController@graficaEstadosJSON2');
    Route::get('graficaEstadosJSON3/{estado}', 'PresidencialesController@graficaEstadosJSON3');
    
    Route::get('graficaEstadosTodos', 'PresidencialesController@graficaEstadosTodos');
    Route::get('graficaJSONTodos', 'PresidencialesController@graficaJSONTodos');
    Route::get('graficaJSONTodos2', 'PresidencialesController@graficaJSONTodos2');
    Route::get('graficaJSONTodos3', 'PresidencialesController@graficaJSONTodos3');


});
