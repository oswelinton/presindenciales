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
	public function Bscedula()
	{
		$personal='active';
		return view('buscarcedula',compact('personal'));
	} 
	public function Bcedula($ci)
	{
		if (Auth::user()->estados=='TODOS') 
		{
			$cedula = DB::table('encuesta')->select('calificacion', 'cedula','nombre','apellido','estado','telefono1','telefono2','tipo_personal','voto_movilizado','tipo_nomina','llamadas')
			->where('cedula',$ci)
			->get();
		}
		else
		{
			$cedula = DB::table('encuesta')->select('calificacion', 'cedula','nombre','apellido','estado','telefono1','telefono2','tipo_personal','voto_movilizado','tipo_nomina','llamadas')
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

		if($fechaActual == '20-05-2018')
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
			$respuesta = array('tipo'=>'error','msj'=>'Error, aún no es la fecha de las elecciones estipulada para el día Domingo 20/05/2018','url'=>'');
			return response()->json($respuesta);
		}

	}


	public function viewReportes()
	{
		$reportes='active';
		return view('viewReportes',compact('reportes'));
	}

	public function reportes($tipoconsulta)
	{
		if($tipoconsulta==0)
		{
			if (Auth::user()->estados=='TODOS') 
			{
		        Excel::create('Reporte DEM del personal que quedó en un estado de verificando de todos los estados', function($excel) {
		            $excel->sheet('Votantes', function($sheet)
		            {
		                $votantes = Encuesta::select('cedula as Cédula','apellido as Apellidos','nombre as Nombres','telefono1 as Teléfono_1','telefono2 as Teléfono_2','tipo_personal as Tipo_de_Personal','voto_movilizado as Votos_Movilizados','llamadas as Llamadas_Realizadas')->where('calificacion',0)->get();
		                $sheet->fromArray($votantes);
		            });
		        })->export('xls');
			}
			else
			{
		        Excel::create('Reporte DEM del personal que quedó en un estado de verificando del estado '.Auth::user()->estados.'', function($excel) {
		            $excel->sheet('Votantes', function($sheet)
		            {
		                $votantes = Encuesta::select('cedula as Cédula','apellido as Apellidos','nombre as Nombres','telefono1 as Teléfono_1','telefono2 as Teléfono_2','tipo_personal as Tipo_de_Personal','voto_movilizado as Votos_Movilizados','llamadas as Llamadas_Realizadas')->where('calificacion',0)->where('estado', Auth::user()->estados)->get();
		                $sheet->fromArray($votantes);
		            });
		        })->export('xls');
			}
		}
		if($tipoconsulta==1)
		{
			if (Auth::user()->estados=='TODOS') 
			{
		        Excel::create('Reporte DEM del personal que indicó que votaron de todos los estados', function($excel) {
		            $excel->sheet('Votantes', function($sheet)
		            {
		                $votantes = Encuesta::select('cedula as Cédula','apellido as Apellidos','nombre as Nombres','telefono1 as Teléfono_1','telefono2 as Teléfono_2','tipo_personal as Tipo_de_Personal','voto_movilizado as Votos_Movilizados','llamadas as Llamadas_Realizadas')->where('calificacion',1)->get();
		                $sheet->fromArray($votantes);
		            });
		        })->export('xls');
			}
			else
			{
		        Excel::create('Reporte DEM del personal que indicó que votaron del estado '.Auth::user()->estados.'', function($excel) {
		            $excel->sheet('Votantes', function($sheet)
		            {
		                $votantes = Encuesta::select('cedula as Cédula','apellido as Apellidos','nombre as Nombres','telefono1 as Teléfono_1','telefono2 as Teléfono_2','tipo_personal as Tipo_de_Personal','voto_movilizado as Votos_Movilizados','llamadas as Llamadas_Realizadas')->where('calificacion',1)->where('estado', Auth::user()->estados)->get();
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
		        Excel::create('Reporte DEM del personal que indicó que no votarian de todos los estados', function($excel) {
		            $excel->sheet('Votantes', function($sheet)
		            {
		                $votantes = Encuesta::select('cedula as Cédula','apellido as Apellidos','nombre as Nombres','telefono1 as Teléfono_1','telefono2 as Teléfono_2','tipo_personal as Tipo_de_Personal','voto_movilizado as Votos_Movilizados','llamadas as Llamadas_Realizadas')->where('calificacion',2)->get();
		                $sheet->fromArray($votantes);
		            });
		        })->export('xls');
			}
			else
			{
		        Excel::create('Reporte DEM del personal que indicó que no votarian del estado '.Auth::user()->estados.'', function($excel) {
		            $excel->sheet('Votantes', function($sheet)
		            {
		                $votantes = Encuesta::select('cedula as Cédula','apellido as Apellidos','nombre as Nombres','telefono1 as Teléfono_1','telefono2 as Teléfono_2','tipo_personal as Tipo_de_Personal','voto_movilizado as Votos_Movilizados','llamadas as Llamadas_Realizadas')->where('calificacion',2)->where('estado', Auth::user()->estados)->get();
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
				$estados = DB::select(" SELECT estado from encuesta group by estado ");
				return view('viewGraficaEstados', compact('grafica','estados'));
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
				where estado='".$estado."' group by estado
			");
			$valores = array(
				'estado' => $consulta[0]->estado,
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
			return $valores;
	}


	public function graficaEstadosJSON($estado)
	{
		$consulta = DB::select("
			SELECT 
				estado as estado,
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
			where estado='".$estado."' group by estado
		");
		$valores = array(
			'estado' => $consulta[0]->estado,
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
			return $valores;
	}




}
