<!DOCTYPE html>
<html>
@section('htmlheader')
	<link rel="stylesheet" type="text/css" href="css/notificacion.css">
<body class="margen">

	<div align="center">
		<img src="img/logos/dem-logotipo.png" width="140" height="50">
	</div>
	<div class="linea-horizontal letra-mediana" align="center">
		REPÚBLICA BOLIVARIANA DE VENEZUELA<br>
		<strong>DIRECCIÓN EJECUTIVA DE LA MAGISTRATURA</strong><br>
	</div>
	<div class="primer-parrafo" align="justify">
			@if(empty($consultaPersonal))
				Aún no hay personal reportado con esta condición
			@endif
			@if(!empty($consultaPersonal))
			<p>Por medio del presente oficio se hace constancia del {{$condicionPersonal}} Simulacro Referendum Esequibos 2023 en el estado {{ Auth::user()->estados }}:</p>
			<div>
				<div>
					<table border=1 cellspacing=0 style="width: 100%">
						<thead>
							<tr>
								<td><center>Cédula</center></td>
								<td><center>Apellidos y Nombres</center></td>
								<td><center>Genero</center></td>
								<td><center>Telefono 1</center></td>
								<td><center>Telefono 2</center></td>
								<td><center>Tipo de Personal</center></td>
								<td><center>Votos Movilizados</center></td>
								<td><center>Número de Llamadas</center></td>
							</tr>
						</thead>
						<tbody>
							@foreach($consultaPersonal as $cp)
							<tr>
								<td><center>{{ $cp->cedula }}</center></td>
								<td><center>{{ $cp->apellido }} {{ $cp->nombre }}</center></td>
								<td><center>{{ $cp->sexo }}</center></td>
								<td><center>{{ $cp->telefono1 }}</center></td>
								<td><center>{{ $cp->telefono2 }}</center></td>
								<td><center>{{ $cp->tipo_personal }}</center></td>
								<td><center>{{ $cp->voto_movilizado }}</center></td>
								<td><center>{{ $cp->llamadas }}</center></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			@endif
	</div>

</body>
</html>



