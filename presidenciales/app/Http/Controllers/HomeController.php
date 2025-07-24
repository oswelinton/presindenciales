<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.2/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use App\InventarioSistema;
use App\Estatus;
use App\LenguajesSistema;
use App\Gestordb;
use App\Framework;
use DB;
use Auth;
use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;
class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        $personal='active';
        return view('buscarcedula',compact('personal'));
   }

}