<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Redirect;
use Illuminate\Support\Facades\Input;
class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'terms' => 'required',
        ]);
    }

    protected function login()
    {

        $data = [
            'name' => \Input::get('username'),
            'password' => \Input::get('password')
        ];
        // Obtenemos los datos del formulario

       if (empty(\Input::get('username'))) {
            $msj = array('message'=>'Debes ingresar tú Usuario','username'=>true,'tipo'=>'error');
            return response()->json($msj);
           //return Redirect::back()->with('error_message', "Debes ingresar tú Usuario")->withInput();
       }
       if (empty(\Input::get('password'))) {
            $msj = array('message'=>'Debes ingresar tú Contraseña','password'=>true,'tipo'=>'error');
           return response()->json($msj);

           //return Redirect::back()->with('error_message', "Debes ingresar tú Contraseña")->withInput();
       }

        if (\Auth::attempt($data, \Input::get('remember'))) // Como segundo parámetro pasámos el checkbox para sabes si queremos recordar la contraseña
        {
            // Si nuestros datos son correctos mostramos la página de inicio
            $msj = array('message'=>'Datos Validos','tipo'=>'success');
           return response()->json($msj);
        }else{
            // Si los datos no son los correctos volvemos al login y mostramos un error
            $msj = array('message'=>'Datos incorrectos','username'=>true,'password'=>true,'tipo'=>'error');
           return response()->json($msj);

            // return Redirect::back()->with('error_message', " ")->withInput();
        }


    }
}