moraanto:19100517@

usuario
<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Auth;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Redirect;
use Illuminate\Support\Facades\Input;
use App\Jefes;
use DB;
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

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }


    protected function login()
    {
       if (empty(\Input::get('username'))) {
            $msj = array('message'=>'Debes ingresar tú Usuario','tipo'=>'error');
            return response()->json($msj);
           //return Redirect::back()->with('error_message', "Debes ingresar tú Usuario")->withInput();
       }
       if (empty(\Input::get('password'))) {
            $msj = array('message'=>'Debes ingresar tú Contraseña','tipo'=>'error');
           return response()->json($msj);

           //return Redirect::back()->with('error_message', "Debes ingresar tú Contraseña")->withInput();
       }
        /*
            datos de conexion a plataforma ELDAP PHP
         */
        $ldaprdn  = 'cn=Admin,dc=dem,dc=int';/*ldap rdn or dn*/
        $ldappass = 'Hola12357';  /*associated password*/
        $ldapconn = ldap_connect("ldap.dem.int", 636) or die("Could not connect to LDAP server.");
        ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

         if ($ldapconn)
         {
            $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);
            print_r($ldapbind);

            if ($ldapbind )
            {
                $username = \Input::get('username');
                $password = \Input::get('password');
                 /*filtrar un usuario LDAP por el uid recibido de la pantalla login y nos traemos sólo su clave encriptada*/
                $dn = "ou=Personas,ou=Usuarios,dc=dem,dc=int";
                $filter="(uid=$username)";
                $justthese = array("userPassword");
                $result =ldap_search($ldapconn, $dn, $filter,$justthese);

                $info = ldap_get_entries($ldapconn, $result);


                /*condicional para cuando el usuario existe en LDAP*/
                if (!empty($info[0][0]) && isset($info[0][0]))
                {

                    $d = $info[0][0];

                    $clave_encriptada=$info[0][$d][0];
                    //
                    //filtrar el mismo usuario LDAP y nos traemos el resto de su información
                    $justthese2 = array("demCedula");
                    $result2 =ldap_search($ldapconn, $dn, $filter,$justthese2);
                    $info2 = ldap_get_entries($ldapconn, $result2);
                    $c = $info2[0][0];
                    $cedula=$info2[0][$c][0];
                    //


                    /*CIERRE DE CONEXION CON ELDAP RETURNA LA CEDULA DE DICHO USUARIO*/
                    ldap_close($ldapconn);

                    self::password_check($clave_encriptada,$password);
                    $existe = self::logeoInterno($cedula,$username,$password);
                    /*print_r($existe);
                     die();*/
                    if ($existe)
                    {
                        $msj = array('message'=>'Datos Validos','tipo'=>'success');
                        return response()->json($msj);
                    }else{
                         $msj = array('message'=>'Usted no puede acceder a este módulo','tipo'=>'error');
                         return response()->json($msj);

                     }


                 }else{
                    $msj = array('message'=>'Usuario Inexistente','tipo'=>'error');
                   return response()->json($msj);
                 }
             }
            else{

                    $msj = array('message'=>'Could not connect to LDAP server.','tipo'=>'error');
                   return response()->json($msj);
             }
         }

     }
        /*función que compara el password obtenido del filtro en LDAp y la clave plana recibida desde la pantalla login*/
             function password_check( $cryptedpassword, $plainpassword ) {
             /*if (DEBUG_ENABLED)*/
                 if( preg_match( "/{([^}]+)}(.*)/", $cryptedpassword, $cypher ) ) {
                     $cryptedpassword = $cypher[2];
                     $_cypher = strtolower($cypher[1]);
                 } else {
                     $_cypher = NULL;
                 }
                 switch( $_cypher ) {
                     case 'ssha':
                      /*check php mhash support before using it*/
                     if( function_exists( 'mhash' ) ) {
                         $hash = base64_decode($cryptedpassword);
                         # OpenLDAP uses a 4 byte salt, SunDS uses an 8 byte salt - both from char 20.
                         $salt = substr($hash,20);
                         $new_hash = base64_encode( mhash( MHASH_SHA1, $plainpassword.$salt).$salt );

                         if( strcmp( $cryptedpassword, $new_hash ) == 0 )
                             return true;
                         else
                             return false;

                     } else {
                         pla_error( _('Your PHP install does not have the mhash() function. Cannot do SHA hashes.') );
                     }
                     break;
                 }
             }


     /*
         FUNCION ENCARGADA DE BUSCAR EN DB INTERNA DEL SISTEMA PARA RETORNAR
         PERSONAL BAJO EL CARGO DEL JEFE
      */

    public function logeoInterno($cedula,$name,$password){

    $dataJefe = Jefes::getData($cedula);/*ver si existe en jefes*/

    $user = DB::select("select * from users where cedula = '".$cedula."' ");/*ver si existes como usuario*/


   if (is_array($dataJefe))/*validar que sea un arreglo*/
   {

       if ($user == false) {

           self::registerU($name,$password,$cedula);
       }


       $data = ['name' => $name,'password' => $password];


      foreach ($dataJefe as $sta) {
           if ($sta->estatus == true) {
               if (Auth::attempt($data, \Input::get('remember')))
               {
                    return $cedula;
               }
           }
      }

   }

    }

    public function registerU($name,$password,$cedula){
           $user = new User;
               $user->name    = $name;
               $user->password= bcrypt($password);
               $user->email   = $name.'@tsj-dem.gob.ve';
               $user->cedula  = $cedula;
           $user->save();
    }
}