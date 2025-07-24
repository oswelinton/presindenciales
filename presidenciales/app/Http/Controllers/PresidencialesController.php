<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Auth;
use Documento;
use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;
use Dompdf\Dompdf;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Encuesta;
use Carbon\Carbon;


class PresidencialesController extends Controller
{
	protected $intervaloIni;
	protected $intervaloFin;

	public function Bscedula()
	{
		$personal='active';
		return view('buscarcedula',compact('personal'));
	}
	public function Bcedula($ci)
	{
		if (Auth::user()->estados=='TODOS')
		{
			$cedula = DB::table('encuesta')->select('calificacion', 'cedula','nombre','apellido','estado','telefono1','telefono2','tipo_personal','voto_movilizado','tipo_nomina','llamadas','sexo','dependencia', 'edad')
			->where('cedula',$ci)
			->get();
		}
		else
		{
			$cedula = DB::table('encuesta')->select('calificacion', 'cedula','nombre','apellido','estado','telefono1','telefono2','tipo_personal','voto_movilizado','tipo_nomina','llamadas','sexo','dependencia', 'edad')
			->where('estado',Auth::user()->estados)
			->where('cedula',$ci)
			->get();
		}
		if(empty($cedula))
		{
			 $respuesta = array('tipo'=>'error','msj'=>'No se ha encontrado esta cedula o no le corresponde en su estado','url'=>'');
			return response()->json($respuesta);
		}
		else
		{
			$respuesta = array('tipo'=>'success','msj'=>'Busqueda Exitosa','url'=>'');

			return view('cedulaempleado',compact('cedula'));
		}
	}

	public function estadoempleado(Request $request)
	{

		$carbon = new Carbon();
		$fechaActual = $carbon->now();
		$fechaActual = $fechaActual->setTimezone('America/Caracas');
		$fechaActual = $fechaActual->format('d-m-Y');

		$fechaElecciones='25-05-2025';

// ATENCION se coloca la fechaActual del dia de votaciones por defecto en el ambiente de desarrollo, comentarla en PRODUCCION

$fechaActual = $fechaElecciones;

// se coloca la fechaActual del dia de votaciones por defecto en el ambiente de desarrollo, comentarla en PRODUCCION

		if($fechaActual == $fechaElecciones)
		{
			if($request['estadoempleado']==2) // NO VOTARA
			{
				if(Auth::user()->estados=='TODOS')
				{
					$result = DB::table('encuesta')
			            ->where('cedula', $request['cedulaempleado'])
			            ->increment('llamadas', 1, ['calificacion' => $request['estadoempleado'],'voto_movilizado' => 0]);
				}
				else
				{
					$result = DB::table('encuesta')
			            ->where('cedula', $request['cedulaempleado'])
			            ->where('estado', Auth::user()->estados)
			            ->increment('llamadas', 1, ['calificacion' => $request['estadoempleado'],'voto_movilizado' => 0]);
				}
			}
			if($request['estadoempleado']==1) // VOTO
			{
				if(Auth::user()->estados=='TODOS')
				{
					$result = DB::table('encuesta')
			            ->where('cedula', $request['cedulaempleado'])
			            ->increment('llamadas', 1, ['calificacion' => $request['estadoempleado'],'voto_movilizado' => $request['votos_movilizados']]);
				}
				else
				{
					$result = DB::table('encuesta')
			            ->where('cedula', $request['cedulaempleado'])
			            ->where('estado', Auth::user()->estados)
			            ->increment('llamadas', 1, ['calificacion' => $request['estadoempleado'],'voto_movilizado' => $request['votos_movilizados']]);
				}
			}
			if($request['estadoempleado']==0) // VERIFICANDO
			{
				if(Auth::user()->estados=='TODOS')
				{
					$result = DB::table('encuesta')
			            ->where('cedula', $request['cedulaempleado'])
			            ->increment('llamadas', 1, ['calificacion' => $request['estadoempleado'],'voto_movilizado' => 0]);
				}
				else
				{
					$result = DB::table('encuesta')
			            ->where('cedula', $request['cedulaempleado'])
			            ->where('estado', Auth::user()->estados)
			            ->increment('llamadas', 1, ['calificacion' => $request['estadoempleado'],'voto_movilizado' => 0]);
				}
			}
	        if($result)
	        {
	        	$respuesta = array('tipo'=>'success','msj'=>'Datos actualizados','url'=>'buscarcedula');
				return response()->json($respuesta);
	        }
	        else
	        {
				$respuesta = array('tipo'=>'error','msj'=>'Ocurrió un error','url'=>'buscarcedula');
				return response()->json($respuesta);
	        }

		}
		else
		{
			$respuesta = array('tipo'=>'error','msj'=>"Aun no es la fecha de las elecciones estipuladas para el día $fechaElecciones",'url'=>'');
			return response()->json($respuesta);
		}

	}


	public function viewReportes()
	{
		$reportes='active';
		return view('viewReportes',compact('reportes'));
	}

	public function reportes($tipoconsulta,$intervalo)
	{
		// $intervaloEdad=$request['selectEdad'];
		// dd($intervalo);
		if($intervalo==0){
			$this->intervaloIni=18;
			$this->intervaloFin=150;
		}else if($intervalo==1){
			$this->intervaloIni=18;
			$this->intervaloFin=25;
		}else if($intervalo==2){
			$this->intervaloIni=26;
			$this->intervaloFin=35;
		}else if($intervalo==3){
			$this->intervaloIni=36;
			$this->intervaloFin=45;
		}else if($intervalo==4){
			$this->intervaloIni=46;
			$this->intervaloFin=55;
		}else if($intervalo==5){
			$this->intervaloIni=56;
			$this->intervaloFin=150;
		}
	// dd($this->intervaloIni);

		if($tipoconsulta==0)
		{
			if (Auth::user()->estados=='TODOS')
{
    Excel::create('Reporte del personal que quedó en un estado de verificando', function($excel) {
        $excel->sheet('Votantes', function($sheet)
        {
            $votantes = Encuesta::select('cedula as Cédula','apellido as Apellidos','nombre as Nombres','edad as Edad','sexo as Genero','telefono1 as Teléfono_1','telefono2 as Teléfono_2','tipo_personal as Tipo_de_Personal','dependencia','voto_movilizado as Votos_Movilizados','llamadas as Llamadas_Realizadas')
                ->where('calificacion', 0)->get();

            $sheet->fromArray($votantes);
        });
    })->export('xls');
}
			else
			{
		        Excel::create('Reporte DEM del personal que quedó en un estado de verificando del estado '.Auth::user()->estados.'', function($excel) {
		            $excel->sheet('Votantes', function($sheet)
		            {
		                $votantes = Encuesta::select('cedula as Cédula','apellido as Apellidos','nombre as Nombres','edad as Edad','sexo as Genero','telefono1 as Teléfono_1','telefono2 as Teléfono_2','tipo_personal as Tipo_de_Personal','dependencia','voto_movilizado as Votos_Movilizados','llamadas as Llamadas_Realizadas')->where('calificacion',0)->where('estado', Auth::user()->estados)->get();
		                $sheet->fromArray($votantes);
		            });
		        })->export('xls');
			}
		}
		if($tipoconsulta==1)
		{
			if (Auth::user()->estados=='TODOS')
{
    Excel::create('Reporte del personal que indicó que votaron', function($excel) {
        $excel->sheet('Votantes', function($sheet)
        {
            $votantes = Encuesta::select('cedula as Cédula','apellido as Apellidos','nombre as Nombres','edad as Edad','sexo as Genero','telefono1 as Teléfono_1','telefono2 as Teléfono_2','tipo_personal as Tipo_de_Personal','dependencia','voto_movilizado as Votos_Movilizados','llamadas as Llamadas_Realizadas','sexo')
                ->where('calificacion', 1)->get();

            $sheet->fromArray($votantes);
        });
    })->export('xls');
}
			else
			{
		        Excel::create('Reporte DEM del personal que indicó que votaron del estado '.Auth::user()->estados.'', function($excel) {
		            $excel->sheet('Votantes', function($sheet)
		            {
		                $votantes = Encuesta::select('cedula as Cédula','apellido as Apellidos','nombre as Nombres','edad as Edad','sexo as Genero','telefono1 as Teléfono_1','telefono2 as Teléfono_2','tipo_personal as Tipo_de_Personal','dependencia','voto_movilizado as Votos_Movilizados','llamadas as Llamadas_Realizadas')->where('calificacion',1)->where('estado', Auth::user()->estados)->get();
		                $sheet->fromArray($votantes);
		            });
		        })->export('xls');
			}
		}
		if($tipoconsulta==2)
		{
			$condicionPersonal = "personal que indicó que no votarian";
			if (Auth::user()->estados=='TODOS')
		{
    Excel::create('Reporte del personal que indicó que no votarían', function($excel) {
        $excel->sheet('Votantes', function($sheet)
        {
            $votantes = Encuesta::select('cedula as Cédula','apellido as Apellidos','nombre as Nombres','edad as Edad','sexo as Genero','telefono1 as Teléfono_1','telefono2 as Teléfono_2','tipo_personal as Tipo_de_Personal','dependencia','voto_movilizado as Votos_Movilizados','llamadas as Llamadas_Realizadas')
                ->where('calificacion', 2)->get();

            $sheet->fromArray($votantes);
        });
    })->export('xls');
}
			else
			{
		        Excel::create('Reporte DEM del personal que indicó que no votarian del estado '.Auth::user()->estados.'', function($excel) {
		            $excel->sheet('Votantes', function($sheet)
		            {
		                $votantes = Encuesta::select('cedula as Cédula','apellido as Apellidos','nombre as Nombres','edad as Edad','sexo as Genero','telefono1 as Teléfono_1','telefono2 as Teléfono_2','tipo_personal as Tipo_de_Personal','dependencia','voto_movilizado as Votos_Movilizados','llamadas as Llamadas_Realizadas')->where('calificacion',2)->where('estado', Auth::user()->estados)->get();
		                $sheet->fromArray($votantes);
		            });
		        })->export('xls');
			}
		}
	}


	public function viewGraficas()
	{
			$grafica='active';
			$estado = Auth::user()->estados;
			if($estado=='TODOS')
			{
				$estados = DB::select(" SELECT estado from encuesta group by estado order by estado");
				return view('viewGraficaEstados', compact('grafica','estados'));
				// return view('viewGraficaMapaEstados', compact('grafica','estados'));
			}
			else
			{
				return view('grafica', compact('grafica'));
			}
	}

public function graficaJSON()
{
    $estado = Auth::user()->estados;
    $consulta = DB::select("
        SELECT
            estado as estado,
            count(cedula) as total_personas,
            sum(CASE WHEN calificacion=1 THEN 1 ELSE 0 END) as total_personas_votaron,
            sum(CASE WHEN calificacion=0 THEN 1 ELSE 0 END) as total_personas_verificando,
            sum(CASE WHEN calificacion=2 THEN 1 ELSE 0 END) as total_personas_novotara,
            sum(CASE WHEN tipo_personal='JUBILADOS' THEN 1 ELSE 0 END) as total_jubilados,
            sum(CASE WHEN tipo_personal='ADMINISTRATIVOS' THEN 1 ELSE 0 END) as total_administrativos,
            sum(CASE WHEN tipo_personal='JURIDICOS' THEN 1 ELSE 0 END) as total_juridicos,
            sum(CASE WHEN tipo_personal='CONTRATADOS' THEN 1 ELSE 0 END) as total_contratados,
            sum(CASE WHEN tipo_personal='JUBILADOS' and calificacion=1 THEN 1 ELSE 0 END) as total_jubilados_votaron,
            sum(CASE WHEN tipo_personal='ADMINISTRATIVOS' and calificacion=1 THEN 1 ELSE 0 END) as total_administrativos_votaron,
            sum(CASE WHEN tipo_personal='JURIDICOS' and calificacion=1 THEN 1 ELSE 0 END) as total_juridicos_votaron,
            sum(CASE WHEN tipo_personal='CONTRATADOS' and calificacion=1 THEN 1 ELSE 0 END) as total_contratados_votaron,
            sum(CASE WHEN tipo_personal='JUBILADOS' and calificacion=0 THEN 1 ELSE 0 END) as total_jubilados_verificando,
            sum(CASE WHEN tipo_personal='ADMINISTRATIVOS' and calificacion=0 THEN 1 ELSE 0 END) as total_administrativos_verificando,
            sum(CASE WHEN tipo_personal='JURIDICOS' and calificacion=0 THEN 1 ELSE 0 END) as total_juridicos_verificando,
            sum(CASE WHEN tipo_personal='CONTRATADOS' and calificacion=0 THEN 1 ELSE 0 END) as total_contratados_verificando,
            sum(CASE WHEN tipo_personal='JUBILADOS' and calificacion=2 THEN 1 ELSE 0 END) as total_jubilados_novotara,
            sum(CASE WHEN tipo_personal='ADMINISTRATIVOS' and calificacion=2 THEN 1 ELSE 0 END) as total_administrativos_novotara,
            sum(CASE WHEN tipo_personal='JURIDICOS' and calificacion=2 THEN 1 ELSE 0 END) as total_juridicos_novotara,
            sum(CASE WHEN tipo_personal='CONTRATADOS' and calificacion=2 THEN 1 ELSE 0 END) as total_contratados_novotara,
            sum(voto_movilizado) as voto_m,
            sum(CASE WHEN tipo_personal='JUBILADOS' THEN voto_movilizado ELSE 0 END) as total_movilizados_jubilados,
            sum(CASE WHEN tipo_personal='ADMINISTRATIVOS' THEN voto_movilizado ELSE 0 END) as total_movilizados_administrativos,
            sum(CASE WHEN tipo_personal='JURIDICOS' THEN voto_movilizado ELSE 0 END) as total_movilizados_juridicos,
            sum(CASE WHEN tipo_personal='CONTRATADOS' THEN voto_movilizado ELSE 0 END) as total_movilizados_contratados
        from encuesta
        where estado='".$estado."' group by estado
    ");

    // Crear valores por defecto
    $valoresPorDefecto = [
        'estado' => $estado,
        'total_personas' => 0,
        'total_personas_votaron' => 0,
        'total_personas_verificando' => 0,
        'total_personas_novotara' => 0,
        'total_jubilados' => 0,
        'total_administrativos' => 0,
        'total_juridicos' => 0,
        'total_contratados' => 0,
        'total_jubilados_votaron' => 0,
        'total_administrativos_votaron' => 0,
        'total_juridicos_votaron' => 0,
        'total_contratados_votaron' => 0,
        'total_jubilados_verificando' => 0,
        'total_administrativos_verificando' => 0,
        'total_juridicos_verificando' => 0,
        'total_contratados_verificando' => 0,
        'total_jubilados_novotara' => 0,
        'total_administrativos_novotara' => 0,
        'total_juridicos_novotara' => 0,
        'total_contratados_novotara' => 0,
        'voto_m' => 0,
        'total_movilizados_jubilados' => 0,
        'total_movilizados_administrativos' => 0,
        'total_movilizados_juridicos' => 0,
        'total_movilizados_contratados' => 0
    ];

    // Si hay resultados, combinar con los valores por defecto
    if (!empty($consulta)) {
        $valores = (array)$consulta[0];
        return array_merge($valoresPorDefecto, $valores);
    }

    return $valoresPorDefecto;
}


public function graficaEstadosJSON($estado)
{
    $consulta = DB::select("
        SELECT
            estado as estado,
            count(cedula) as total_personas,
            sum(CASE WHEN calificacion=1 THEN 1 ELSE 0 END) as total_personas_votaron,
            sum(CASE WHEN calificacion=0 THEN 1 ELSE 0 END) as total_personas_verificando,
            sum(CASE WHEN calificacion=2 THEN 1 ELSE 0 END) as total_personas_novotara,
            sum(CASE WHEN tipo_personal='JUBILADOS' THEN 1 ELSE 0 END) as total_jubilados,
            sum(CASE WHEN tipo_personal='ADMINISTRATIVOS' THEN 1 ELSE 0 END) as total_administrativos,
            sum(CASE WHEN tipo_personal='JURIDICOS' THEN 1 ELSE 0 END) as total_juridicos,
            sum(CASE WHEN tipo_personal='CONTRATADOS' THEN 1 ELSE 0 END) as total_contratados,
            sum(CASE WHEN tipo_personal='JUBILADOS' and calificacion=1 THEN 1 ELSE 0 END) as total_jubilados_votaron,
            sum(CASE WHEN tipo_personal='ADMINISTRATIVOS' and calificacion=1 THEN 1 ELSE 0 END) as total_administrativos_votaron,
            sum(CASE WHEN tipo_personal='JURIDICOS' and calificacion=1 THEN 1 ELSE 0 END) as total_juridicos_votaron,
            sum(CASE WHEN tipo_personal='CONTRATADOS' and calificacion=1 THEN 1 ELSE 0 END) as total_contratados_votaron,
            sum(CASE WHEN tipo_personal='JUBILADOS' and calificacion=0 THEN 1 ELSE 0 END) as total_jubilados_verificando,
            sum(CASE WHEN tipo_personal='ADMINISTRATIVOS' and calificacion=0 THEN 1 ELSE 0 END) as total_administrativos_verificando,
            sum(CASE WHEN tipo_personal='JURIDICOS' and calificacion=0 THEN 1 ELSE 0 END) as total_juridicos_verificando,
            sum(CASE WHEN tipo_personal='CONTRATADOS' and calificacion=0 THEN 1 ELSE 0 END) as total_contratados_verificando,
            sum(CASE WHEN tipo_personal='JUBILADOS' and calificacion=2 THEN 1 ELSE 0 END) as total_jubilados_novotara,
            sum(CASE WHEN tipo_personal='ADMINISTRATIVOS' and calificacion=2 THEN 1 ELSE 0 END) as total_administrativos_novotara,
            sum(CASE WHEN tipo_personal='JURIDICOS' and calificacion=2 THEN 1 ELSE 0 END) as total_juridicos_novotara,
            sum(CASE WHEN tipo_personal='CONTRATADOS' and calificacion=2 THEN 1 ELSE 0 END) as total_contratados_novotara,
            sum(voto_movilizado) as voto_m,
            sum(CASE WHEN tipo_personal='JUBILADOS' THEN voto_movilizado ELSE 0 END) as total_movilizados_jubilados,
            sum(CASE WHEN tipo_personal='ADMINISTRATIVOS' THEN voto_movilizado ELSE 0 END) as total_movilizados_administrativos,
            sum(CASE WHEN tipo_personal='JURIDICOS' THEN voto_movilizado ELSE 0 END) as total_movilizados_juridicos,
            sum(CASE WHEN tipo_personal='CONTRATADOS' THEN voto_movilizado ELSE 0 END) as total_movilizados_contratados
        from encuesta
        where estado= :estado 
        group by estado
    ", ['estado' => $estado]);

    // Valores por defecto
    $valoresPorDefecto = [
        'estado' => $estado,
        'total_personas' => 0,
        'total_personas_votaron' => 0,
        'total_personas_verificando' => 0,
        'total_personas_novotara' => 0,
        'total_jubilados' => 0,
        'total_administrativos' => 0,
        'total_juridicos' => 0,
        'total_contratados' => 0,
        'total_jubilados_votaron' => 0,
        'total_administrativos_votaron' => 0,
        'total_juridicos_votaron' => 0,
        'total_contratados_votaron' => 0,
        'total_jubilados_verificando' => 0,
        'total_administrativos_verificando' => 0,
        'total_juridicos_verificando' => 0,
        'total_contratados_verificando' => 0,
        'total_jubilados_novotara' => 0,
        'total_administrativos_novotara' => 0,
        'total_juridicos_novotara' => 0,
        'total_contratados_novotara' => 0,
        'voto_m' => 0,
        'total_movilizados_jubilados' => 0,
        'total_movilizados_administrativos' => 0,
        'total_movilizados_juridicos' => 0,
        'total_movilizados_contratados' => 0
    ];

    // Si hay resultados, combinarlos con los valores por defecto
    if (!empty($consulta)) {
        return array_merge($valoresPorDefecto, (array)$consulta[0]);
    }

    return $valoresPorDefecto;
}
	public function graficaEstadosJSON2($estado)
{
    $consulta = DB::select("
        SELECT
            estado as estado,
            count(cedula) as total_personas,
            sum(CASE WHEN sexo='M' THEN 1 ELSE 0 END) as total_masculino,
            sum(CASE WHEN sexo='F' THEN 1 ELSE 0 END) as total_femenino,
            sum(CASE WHEN calificacion=1 THEN 1 ELSE 0 END) as total_personas_votaron,
            sum(CASE WHEN calificacion=0 THEN 1 ELSE 0 END) as total_personas_verificando,
            sum(CASE WHEN calificacion=2 THEN 1 ELSE 0 END) as total_personas_novotara,
            sum(CASE WHEN calificacion=1 AND sexo='M' THEN 1 ELSE 0 END) as total_masc_votaron,
            sum(CASE WHEN calificacion=1 AND sexo='F' THEN 1 ELSE 0 END) as total_fem_votaron,
            sum(CASE WHEN calificacion=0 OR calificacion is null THEN 1 ELSE 0 END) as total_personas_verificando,
            sum(CASE WHEN (calificacion=0 OR calificacion is null) AND sexo='M' THEN 1 ELSE 0 END) as total_masc_verificando,
            sum(CASE WHEN (calificacion=0 OR calificacion is null) AND sexo='F' THEN 1 ELSE 0 END) as total_fem_verificando,
            sum(CASE WHEN calificacion=2 THEN 1 ELSE 0 END) as total_personas_novotara,
            sum(CASE WHEN calificacion=2 AND sexo='M' THEN 1 ELSE 0 END) as total_masc_novotara,
            sum(CASE WHEN calificacion=2 AND sexo='F' THEN 1 ELSE 0 END) as total_fem_novotara
        from encuesta
        where estado= :estado 
        group by estado
    ", ['estado' => $estado]);

    // Valores por defecto para masculino
    $datosmaculino = [
        0 => 0, // total_masculino
        1 => 0, // total_masc_votaron
        2 => 0, // total_masc_novotara
        3 => 0  // total_masc_verificando
    ];

    // Valores por defecto para femenino
    $datosfemenino = [
        0 => 0, // total_femenino
        1 => 0, // total_fem_votaron
        2 => 0, // total_fem_novotara
        3 => 0  // total_fem_verificando
    ];

    // Si hay resultados, actualizamos los valores
    if (!empty($consulta)) {
        $registro = $consulta[0];
        
        $datosmaculino = [
            0 => $registro->total_masculino ?? 0,
            1 => $registro->total_masc_votaron ?? 0,
            2 => $registro->total_masc_novotara ?? 0,
            3 => $registro->total_masc_verificando ?? 0
        ];

        $datosfemenino = [
            0 => $registro->total_femenino ?? 0,
            1 => $registro->total_fem_votaron ?? 0,
            2 => $registro->total_fem_novotara ?? 0,
            3 => $registro->total_fem_verificando ?? 0
        ];
    }

    return [
        'masculino' => $datosmaculino,
        'femenino' => $datosfemenino
    ];
}
	
	public function graficaEstadosJSON3($estado)
{
    $consulta = DB::select("
        SELECT
            count(cedula) as total_personas,
            sum(CASE WHEN edad>=18 AND edad<=25 THEN 1 ELSE 0 END) as total_personal,
            sum(CASE WHEN edad>=18 AND edad<=25 THEN 1 ELSE 0 END) as total_personal1825,
            sum(CASE WHEN edad>=26 AND edad<=35 THEN 1 ELSE 0 END) as total_personal2635,
            sum(CASE WHEN edad>=36 AND edad<=45 THEN 1 ELSE 0 END) as total_personal3645,
            sum(CASE WHEN edad>=46 AND edad<=55 THEN 1 ELSE 0 END) as total_personal4655,
            sum(CASE WHEN edad>55 THEN 1 ELSE 0 END) as total_personal_mayor55,

            sum(CASE WHEN calificacion=0 AND (edad>=18 AND edad<=25) THEN 1 ELSE 0 END) as total_verificando1825,
            sum(CASE WHEN calificacion=0 AND (edad>=26 AND edad<=35) THEN 1 ELSE 0 END) as total_verificando2635,
            sum(CASE WHEN calificacion=0 AND (edad>=36 AND edad<=45) THEN 1 ELSE 0 END) as total_verificando3645,
            sum(CASE WHEN calificacion=0 AND (edad>=46 AND edad<=55) THEN 1 ELSE 0 END) as total_verificando4655,
            sum(CASE WHEN calificacion=0 AND edad>55 THEN 1 ELSE 0 END) as total_verificando_mayor55,

            sum(CASE WHEN calificacion=1 AND edad>=18 AND edad<=25 THEN 1 ELSE 0 END) as total_voto1825,
            sum(CASE WHEN calificacion=1 AND edad>=26 AND edad<=35 THEN 1 ELSE 0 END) as total_voto2635,
            sum(CASE WHEN calificacion=1 AND edad>=36 AND edad<=45 THEN 1 ELSE 0 END) as total_voto3645,
            sum(CASE WHEN calificacion=1 AND edad>=46 AND edad<=55 THEN 1 ELSE 0 END) as total_voto4655,
            sum(CASE WHEN calificacion=1 AND edad>55 THEN 1 ELSE 0 END) as total_voto_mayor55,

            sum(CASE WHEN calificacion=2 AND edad>=18 AND edad<=25 THEN 1 ELSE 0 END) as total_novotara1825,
            sum(CASE WHEN calificacion=2 AND edad>=26 AND edad<=35 THEN 1 ELSE 0 END) as total_novotara2635,
            sum(CASE WHEN calificacion=2 AND edad>=36 AND edad<=45 THEN 1 ELSE 0 END) as total_novotara3645,
            sum(CASE WHEN calificacion=2 AND edad>=46 AND edad<=55 THEN 1 ELSE 0 END) as total_novotara4655,
            sum(CASE WHEN calificacion=2 AND edad>55 THEN 1 ELSE 0 END) as total_novotara_mayor55
        from encuesta 
        where estado= :estado 
        group by estado
    ", ['estado' => $estado]);

    // Valores por defecto para cada grupo de edad
    $defaultAgeGroup = [0 => 0, 1 => 0, 2 => 0, 3 => 0];
    
    // Inicializar todos los grupos de edad con valores por defecto
    $valores = [
        'data1825' => $defaultAgeGroup,
        'data2635' => $defaultAgeGroup,
        'data3645' => $defaultAgeGroup,
        'data4655' => $defaultAgeGroup,
        'dataMayor55' => $defaultAgeGroup
    ];

    // Si hay resultados, actualizar los valores
    if (!empty($consulta)) {
        $registro = $consulta[0];
        
        $valores = [
            'data1825' => [
                0 => $registro->total_personal1825 ?? 0,
                1 => $registro->total_voto1825 ?? 0,
                2 => $registro->total_novotara1825 ?? 0,
                3 => $registro->total_verificando1825 ?? 0
            ],
            'data2635' => [
                0 => $registro->total_personal2635 ?? 0,
                1 => $registro->total_voto2635 ?? 0,
                2 => $registro->total_novotara2635 ?? 0,
                3 => $registro->total_verificando2635 ?? 0
            ],
            'data3645' => [
                0 => $registro->total_personal3645 ?? 0,
                1 => $registro->total_voto3645 ?? 0,
                2 => $registro->total_novotara3645 ?? 0,
                3 => $registro->total_verificando3645 ?? 0
            ],
            'data4655' => [
                0 => $registro->total_personal4655 ?? 0,
                1 => $registro->total_voto4655 ?? 0,
                2 => $registro->total_novotara4655 ?? 0,
                3 => $registro->total_verificando4655 ?? 0
            ],
            'dataMayor55' => [
                0 => $registro->total_personal_mayor55 ?? 0,
                1 => $registro->total_voto_mayor55 ?? 0,
                2 => $registro->total_novotara_mayor55 ?? 0,
                3 => $registro->total_verificando_mayor55 ?? 0
            ]
        ];
    }

    return $valores;
}
	public function graficaEstados($estado)
	{
		$grafica = 'active';
		return view('graficaEstados', compact('grafica','estado'));
	}

	public function graficaEstadosTodos()
	{
		$grafica = 'active';
		return view('graficaEstadosTodos', compact('grafica'));
	}

	public function graficaJSONTodos()
	{
			$consulta = DB::select("
				SELECT
					count (cedula) as total_personas,
					sum( CASE WHEN calificacion=1 THEN 1 ELSE 0 END ) as total_personas_votaron,
					sum( CASE WHEN calificacion=0 THEN 1 ELSE 0 END ) as total_personas_verificando,
					sum( CASE WHEN calificacion=2 THEN 1 ELSE 0 END ) as total_personas_novotara,
						sum( CASE WHEN tipo_personal='JUBILADOS' THEN 1 ELSE 0 END ) as total_jubilados,
						sum( CASE WHEN tipo_personal='ADMINISTRATIVOS' THEN 1 ELSE 0 END ) as total_administrativos,
						sum( CASE WHEN tipo_personal='JURIDICOS' THEN 1 ELSE 0 END ) as total_juridicos,
						sum( CASE WHEN tipo_personal='CONTRATADOS' THEN 1 ELSE 0 END ) as total_contratados,
							sum( CASE WHEN tipo_personal='JUBILADOS' and calificacion=1 THEN 1 ELSE 0 END ) as total_jubilados_votaron,
							sum( CASE WHEN tipo_personal='ADMINISTRATIVOS' and calificacion=1  THEN 1 ELSE 0 END ) as total_administrativos_votaron,
							sum( CASE WHEN tipo_personal='JURIDICOS' and calificacion=1  THEN 1 ELSE 0 END ) as total_juridicos_votaron,
							sum( CASE WHEN tipo_personal='CONTRATADOS' and calificacion=1  THEN 1 ELSE 0 END ) as total_contratados_votaron,
								sum( CASE WHEN tipo_personal='JUBILADOS' and calificacion=0 THEN 1 ELSE 0 END ) as total_jubilados_verificando,
								sum( CASE WHEN tipo_personal='ADMINISTRATIVOS' and calificacion=0  THEN 1 ELSE 0 END ) as total_administrativos_verificando,
								sum( CASE WHEN tipo_personal='JURIDICOS' and calificacion=0  THEN 1 ELSE 0 END ) as total_juridicos_verificando,
								sum( CASE WHEN tipo_personal='CONTRATADOS' and calificacion=0  THEN 1 ELSE 0 END ) as total_contratados_verificando,
									sum( CASE WHEN tipo_personal='JUBILADOS' and calificacion=2 THEN 1 ELSE 0 END ) as total_jubilados_novotara,
									sum( CASE WHEN tipo_personal='ADMINISTRATIVOS' and calificacion=2  THEN 1 ELSE 0 END ) as total_administrativos_novotara,
									sum( CASE WHEN tipo_personal='JURIDICOS' and calificacion=2  THEN 1 ELSE 0 END ) as total_juridicos_novotara,
									sum( CASE WHEN tipo_personal='CONTRATADOS' and calificacion=2  THEN 1 ELSE 0 END ) as total_contratados_novotara,
					sum (voto_movilizado) as voto_m,
						sum( CASE WHEN tipo_personal='JUBILADOS' THEN voto_movilizado ELSE 0 END ) as total_movilizados_jubilados,
						sum( CASE WHEN tipo_personal='ADMINISTRATIVOS' THEN voto_movilizado ELSE 0 END ) as total_movilizados_administrativos,
						sum( CASE WHEN tipo_personal='JURIDICOS' THEN voto_movilizado ELSE 0 END ) as total_movilizados_juridicos,
						sum( CASE WHEN tipo_personal='CONTRATADOS' THEN voto_movilizado ELSE 0 END ) as total_movilizados_contratados
				from encuesta
			");
			$valores = array(
				'total_personas' => $consulta[0]->total_personas,
				'total_personas_votaron' => $consulta[0]->total_personas_votaron,
				'total_personas_verificando' => $consulta[0]->total_personas_verificando,
				'total_personas_novotara' => $consulta[0]->total_personas_novotara,
				'total_jubilados' => $consulta[0]->total_jubilados,
				'total_administrativos' => $consulta[0]->total_administrativos,
				'total_juridicos' => $consulta[0]->total_juridicos,
				'total_contratados' => $consulta[0]->total_contratados,
				'total_jubilados_votaron' => $consulta[0]->total_jubilados_votaron,
				'total_administrativos_votaron' => $consulta[0]->total_administrativos_votaron,
				'total_juridicos_votaron' => $consulta[0]->total_juridicos_votaron,
				'total_contratados_votaron' => $consulta[0]->total_contratados_votaron,
				'total_jubilados_verificando' => $consulta[0]->total_jubilados_verificando,
				'total_administrativos_verificando' => $consulta[0]->total_administrativos_verificando,
				'total_juridicos_verificando' => $consulta[0]->total_juridicos_verificando,
				'total_contratados_verificando' => $consulta[0]->total_contratados_verificando,
				'total_jubilados_novotara' => $consulta[0]->total_jubilados_novotara,
				'total_administrativos_novotara' => $consulta[0]->total_administrativos_novotara,
				'total_juridicos_novotara' => $consulta[0]->total_juridicos_novotara,
				'total_contratados_novotara' => $consulta[0]->total_contratados_novotara,
				'voto_m' => $consulta[0]->voto_m,
				'total_movilizados_jubilados' => $consulta[0]->total_movilizados_jubilados,
				'total_movilizados_administrativos' => $consulta[0]->total_movilizados_administrativos,
				'total_movilizados_juridicos' => $consulta[0]->total_movilizados_juridicos,
				'total_movilizados_contratados' => $consulta[0]->total_movilizados_contratados
			);
			// dd($valores);
			return $valores;
	}
	public function graficaJSONTodos2()
	{
		$consulta = DB::select("
			SELECT
				count (cedula) as total_personas,
				sum( CASE WHEN sexo='M' THEN 1 ELSE 0 END ) as total_masculino,
				sum( CASE WHEN sexo='F' THEN 1 ELSE 0 END ) as total_femenino,
				sum( CASE WHEN calificacion=1 THEN 1 ELSE 0 END ) as total_personas_votaron,
				sum( CASE WHEN calificacion=0 THEN 1 ELSE 0 END ) as total_personas_verificando,
				sum( CASE WHEN calificacion=2 THEN 1 ELSE 0 END ) as total_personas_novotara,
				sum( CASE WHEN calificacion=1 AND sexo='M' THEN 1 ELSE 0 END ) as total_masc_votaron,
				sum( CASE WHEN calificacion=1 AND sexo='F' THEN 1 ELSE 0 END ) as total_fem_votaron,
				sum( CASE WHEN calificacion=0 THEN 1 ELSE 0 END ) as total_personas_verificando,
				sum( CASE WHEN calificacion=0 AND sexo='M' THEN 1 ELSE 0 END ) as total_masc_verificando,
				sum( CASE WHEN calificacion=0 AND sexo='F' THEN 1 ELSE 0 END ) as total_fem_verificando,
				sum( CASE WHEN calificacion=2 THEN 1 ELSE 0 END ) as total_personas_novotara,
				sum( CASE WHEN calificacion=2 AND sexo='M' THEN 1 ELSE 0 END ) as total_masc_novotara,
				sum( CASE WHEN calificacion=2 AND sexo='F' THEN 1 ELSE 0 END ) as total_fem_novotara
			from encuesta ");
		// $valores['masculino'] = array(
		// 	'total_masculino' => $consulta[0]->total_masculino,
		// 	'total_masc_votaron' => $consulta[0]->total_masc_votaron,
		// 	'total_masc_novotara' => $consulta[0]->total_masc_novotara,
		// 	'total_masc_verificando' => $consulta[0]->total_masc_verificando
		// );
		$datosfemenino = array();
		$datosmaculino = array();

		$valores = array();

		foreach($consulta as $i=>$registro){
			// $datosfemenino[0]=0;
			$datosfemenino[0]=$registro->total_masculino;

			// $datosfemenino[1]=1;
			$datosfemenino[1]=$registro->total_masc_votaron;

			// $datosfemenino[2]=2;
			$datosfemenino[2]=$registro->total_masc_novotara;

			// $datosfemenino[3]=3;
			$datosfemenino[3]=$registro->total_masc_verificando;


			// $datosmaculino[0]=0;
			$datosmaculino[0]=$registro->total_femenino;

			// $datosmaculino[1]=1;
			$datosmaculino[1]=$registro->total_fem_votaron;

			// $datosmaculino[2]=2;
			$datosmaculino[2]=$registro->total_fem_novotara;

			// $datosmaculino[3]=3;
			$datosmaculino[3]=$registro->total_fem_verificando;

		}
			$valores['masculino']=$datosmaculino;
			$valores['femenino'] =$datosfemenino;

		// $valores['femenino'] = array(
		// 	'total_femenino' => $consulta[0]->total_femenino,
		// 	'total_fem_votaron' => $consulta[0]->total_fem_votaron,
		// 	'total_fem_novotara' => $consulta[0]->total_fem_novotara,
		// 	'total_fem_verificando' => $consulta[0]->total_fem_verificando
		// );
		return $valores;
	}

	public function graficaJSONTodos3()
	{
		$consulta = DB::select("
			SELECT
				count (cedula) as total_personas,
				sum(CASE WHEN edad>=18 AND edad<=25 THEN 1 ELSE 0 END) as total_personal,
				sum(CASE WHEN edad>=18 AND edad<=25 THEN 1 ELSE 0 END) as total_personal1825,
				sum(CASE WHEN edad>=26 AND edad<=35 THEN 1 ELSE 0 END) as total_personal2635,
				sum(CASE WHEN edad>=36 AND edad<=45 THEN 1 ELSE 0 END) as total_personal3645,
				sum(CASE WHEN edad>=46 AND edad<=55 THEN 1 ELSE 0 END) as total_personal4655,
				sum(CASE WHEN edad>55  THEN 1 ELSE 0 END ) as total_personal_mayor55,

				sum(CASE WHEN calificacion=0 AND edad>=18 AND edad<=25 THEN 1 ELSE 0 END) as total_verificando1825,
				sum(CASE WHEN calificacion=0 AND edad>=26 AND edad<=35 THEN 1 ELSE 0 END) as total_verificando2635,
				sum(CASE WHEN calificacion=0 AND edad>=36 AND edad<=45 THEN 1 ELSE 0 END) as total_verificando3645,
				sum(CASE WHEN calificacion=0 AND edad>=46 AND edad<=55 THEN 1 ELSE 0 END) as total_verificando4655,
				sum(CASE WHEN calificacion=0 AND edad>55  THEN 1 ELSE 0 END) as total_verificando_mayor55,

				sum(CASE WHEN calificacion=1 AND edad>=18 AND edad<=25 THEN 1 ELSE 0 END) as total_voto1825,
				sum(CASE WHEN calificacion=1 AND edad>=26 AND edad<=35 THEN 1 ELSE 0 END) as total_voto2635,
				sum(CASE WHEN calificacion=1 AND edad>=36 AND edad<=45 THEN 1 ELSE 0 END) as total_voto3645,
				sum(CASE WHEN calificacion=1 AND edad>=46 AND edad<=55 THEN 1 ELSE 0 END) as total_voto4655,
				sum(CASE WHEN calificacion=1 AND edad>55  THEN 1 ELSE 0 END ) as total_voto_mayor55,

				sum(CASE WHEN calificacion=2 AND edad>=18 AND edad<=25 THEN 1 ELSE 0 END) as total_novotara1825,
				sum(CASE WHEN calificacion=2 AND edad>=26 AND edad<=35 THEN 1 ELSE 0 END) as total_novotara2635,
				sum(CASE WHEN calificacion=2 AND edad>=36 AND edad<=45 THEN 1 ELSE 0 END) as total_novotara3645,
				sum(CASE WHEN calificacion=2 AND edad>=46 AND edad<=55 THEN 1 ELSE 0 END) as total_novotara4655,
				sum(CASE WHEN calificacion=2 AND edad>55  THEN 1 ELSE 0 END) as total_novotara_mayor55

			from encuesta ");
		// $valores['masculino'] = array(
		// 	'total_masculino' => $consulta[0]->total_masculino,
		// 	'total_masc_votaron' => $consulta[0]->total_masc_votaron,
		// 	'total_masc_novotara' => $consulta[0]->total_masc_novotara,
		// 	'total_masc_verificando' => $consulta[0]->total_masc_verificando
		// );

		// dd($consulta);
		$valores = array();

		foreach($consulta as $i=>$registro){
/*		
			// DATOS TOTAL PERSONAL
			$datatotalpersonal=$registro->total_personal1825;
			$datatotalpersonal=$registro->total_personal2635;
			$datatotalpersonal=$registro->total_personal3645;
			$datatotalpersonal=$registro->total_personal4655;
			$datatotalpersonal=$registro->total_personal_mayor55;

			// DATOS VOTO
			$datavoto=$registro->total_voto1825;
			$datavoto=$registro->total_voto2635;
			$datavoto=$registro->total_voto3645;
			$datavoto=$registro->total_voto4655;
			$datavoto=$registro->total_voto_mayor55;

			// DATOS NO VOTARA
			$datanovotara=$registro->total_novotara1825;
			$datanovotara=$registro->total_novotara2635;
			$datanovotara=$registro->total_novotara3645;
			$datanovotara=$registro->total_novotara4655;
			$datanovotara=$registro->total_novotara_mayor55;

			// DATOS VERIFICANDO
			$dataverificando=$registro->total_verificando1825;
			$dataverificando=$registro->total_verificando2635;
			$dataverificando=$registro->total_verificando3645;
			$dataverificando=$registro->total_verificando4655;
			$dataverificando=$registro->total_verificando_mayor55;
*/

			// DATOS DE 18 A 25
			$data1825[0]=$registro->total_personal1825;
			$data1825[1]=$registro->total_voto1825;
			$data1825[2]=$registro->total_novotara1825;
			$data1825[3]=$registro->total_verificando1825;

			// DATOS DE 26 A 35
			$data2635[0]=$registro->total_personal2635;
			$data2635[1]=$registro->total_voto2635;
			$data2635[2]=$registro->total_novotara2635;
			$data2635[3]=$registro->total_verificando2635;			

			// DATOS DE 36 A 45
			$data3645[0]=$registro->total_personal3645;
			$data3645[1]=$registro->total_voto3645;
			$data3645[2]=$registro->total_novotara3645;
			$data3645[3]=$registro->total_verificando3645;

			// DATOS DE 46 A 55
			$data4655[0]=$registro->total_personal4655;
			$data4655[1]=$registro->total_voto4655;
			$data4655[2]=$registro->total_novotara4655;
			$data4655[3]=$registro->total_verificando4655;

			// DATOS MAYORES DE 55
			$dataMayor55[0]=$registro->total_personal_mayor55;
			$dataMayor55[1]=$registro->total_voto_mayor55;
			$dataMayor55[2]=$registro->total_novotara_mayor55;
			$dataMayor55[3]=$registro->total_verificando_mayor55;
		}
			$valores['data1825']	=	$data1825;
			$valores['data2635'] 	=	$data2635;
			$valores['data3645'] 	=	$data3645;
			$valores['data4655'] 	=	$data4655;
			$valores['dataMayor55'] =	$dataMayor55;

			/*$valores['datatotalpersonal']	=	$datatotalpersonal;
			$valores['datavoto'] 			=	$datavoto;
			$valores['datanovotara'] 		=	$datanovotara;
			$valores['dataverificando'] 	=	$dataverificando;*/



		// $valores['femenino'] = array(
		// 	'total_femenino' => $consulta[0]->total_femenino,
		// 	'total_fem_votaron' => $consulta[0]->total_fem_votaron,
		// 	'total_fem_novotara' => $consulta[0]->total_fem_novotara,
		// 	'total_fem_verificando' => $consulta[0]->total_fem_verificando
		// );
		return $valores;
	}


}
