<div class="container-fluid">
	<div class="col-lg-12 col-sm-12 col-sm-offset-0">

		<div class="panel-body">
			<div class="box box-danger">
				<div class="box-header with-border">
					<center>
						<h3 class="box-title">Busqueda del Personal del Estado {{ Auth::user()->estados }}<h3>
					</center>
				</div>

				<form id="form_estadoempleado" class="form_entrada" role="form" method="POST" action="{{ url('estadoempleado') }}">
				{{-- <form id="" class="" role="form" method="POST" action="{{ url('estadoempleado') }}"> --}}
					<input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="id_users" value="{{Auth::user()->id}}">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="box">
								<div class="box-header">
									<h3 class="box-title">Personal del estado @foreach($cedula as $c => $co) {{ $co->estado }} @endforeach</h3>
								</div>
								<!-- /.box-header -->
								<div class="box-body table-responsive no-padding">
									<table class="table table-hover">
										<tbody>
											<tr>
												<th><center>Cédula</center></th>
												<th><center>Nombres</center></th>
												<th><center>Apellidos</center></th>
												<th><center>Edad</center></th>
												<th><center>Sexo</center></th>
												<th><center>Teléfonos</center></th>
												<!-- <th><center>Tipo de Personal</center></th> -->
												<th><center>Tipo de Nómina</center></th>
												<th><center>Dependencia</center></th>
												<!-- <th><center>Votos Movilizados</center></th> -->
												<th><center>¿Votó?</center></th>
												<!--<th><center>Llamadas Realizadas</center></th>-->
											</tr>
											@foreach($cedula as $c => $co)
											<input type="hidden" name="cedulaempleado" value="{{$co->cedula}}" required>
											<tr>
												<td><center>{{ $co->cedula }}</center></td>
												<td><center>{{ $co->nombre }}</center></td>
												<td><center>{{ $co->apellido }}</td>
												<td><center>{{ $co->edad }}</td>
												<td><center>{{ $co->sexo }}</td>
												<td>
													<center>
															<span class="label label-danger">
																Teléfono 1: {{ $co->telefono1 }}
															</span>
																<br>
															<!-- <span class="label label-danger">
																Teléfono 2: {{ $co->telefono2 }}
															</span> -->
													</center>
												</td>
												<!-- <td><center>{{ $co->tipo_personal }}</center></td> -->
												<td><center>{{ $co->tipo_nomina }}</center></td>
												<td><center>{{ $co->dependencia }}</center></td>
<!-- 												<td>
													<center>
														@if($co->calificacion==0)
															<input type="text" maxlength="5" name="votos_movilizados" value="0" style="width:50%" required>
														@endif
														@if($co->calificacion==1 || $co->calificacion==2)
															<center><p>{{ $co->voto_movilizado }}</p></center>
														@endif
													</center>
												</td> -->
												<td>
													<center>
														@if($co->calificacion==1)
															SI
														@endif
														@if($co->calificacion==0 || $co->calificacion==2)
															<p>NO</p>
														@endif
													</center>
												</td>
												<!--<td>
													<center>
														{{ $co->llamadas }}
													</center>
												</td>-->
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
								@if($co->calificacion==0)
									<div class="row">
										<div class="col-lg-4"></div>
										<div class="col-lg-4 form-group">
											<center>	
												<div class="form-group">
													<label>
														<div class="iradio_flat-green " aria-checked="false" aria-disabled="true" style="position: relative;padding-left:15px;">
															<input type="radio" name="estadoempleado" value="0" checked="" class="flat-red" style="position: absolute; opacity: 0;">
															<ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;">
															</ins>
															<div>VERIFICANDO</div>
														</div>
														
													</label>
													<label>
														<div class="iradio_flat-green checked" aria-checked="false" aria-disabled="false" style="position: relative;padding-left:15px;">
															<input type="radio" name="estadoempleado" value="1" class="flat-red" style="position: absolute; opacity: 0;">
															<ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;">
															</ins>
														</div>
														
														<div>VOTÓ</div>
													</label>
													<label>
														<div class="iradio_flat-green" aria-checked="false" aria-disabled="false" style="position: relative;padding-left:15px;">
															<input type="radio" name="estadoempleado" value="2" class="flat-red" style="position: absolute; opacity: 0;">
															<ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;">
															</ins>
															<div>NO VOTARÁ</div>
														</div>
														
													</label>
												</div>
											</center>
										</div>
										<div class="col-lg-4"></div>
									</div>
								@endif
								<center>
									<div class="box-footer">
										@if($co->calificacion==0)
										<button type="submit" class="btn btn-danger">Guardar</button>
										@endif
										@if($co->calificacion==1)
										<span class="label label-danger">Esta persona ha indicado que ya votó</span>
										@endif
										@if($co->calificacion==2)
										<span class="label label-danger">Esta persona ha indicado que no votará</span>
										@endif
									</div>
								</center>
								<!-- /.box-body -->
							</div>
							<!-- /.box -->
						</div>
					</div>
				</form>

				<!-- /.box-body -->
			</div>
		</div>
	</div>
</div>



<!-- jQuery 2.1.4 -->
<script src="{{ asset('/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="{{ asset('/js/bootstrap.js') }}" type="text/javascript"></script>
<!-- iCheck -->
<script src="{{ asset('/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/js/app.min.js') }}" type="text/javascript"></script>

{{-- mensajes toastr --}}
<script src="{{ asset('/js/toastr.js')}}" type="text/javascript"></script>
<script src="{{ asset('/js/mensajes.js')}}" type="text/javascript"></script>
<!-- Slect2 -->
<script src="{{ asset('/plugins/select2/select2.js') }}" type="text/javascript"></script>

{{-- datatables JS --}}
<script src="{{ asset('/plugins/datatables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/dataTables.buttons.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('/plugins/datatables/buttons.flash.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('/plugins/datatables/jszip.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('/plugins/datatables/vfs_fonts.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/buttons.html5.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('/js/main.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/functions.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/mack.js') }}" type="text/javascript"></script>

<script src="{{ asset('/js/select2.full.min.js') }}"></script>
<!-- InputMask -->
<script src="{{ asset('/js/jquery.inputmask.js') }}"></script>
<script src="{{ asset('/js/jquery.inputmask.date.extensions.js') }}"></script>
<script src="{{ asset('/js/jquery.inputmask.extensions.js') }}"></script>
<!-- date-range-picker -->
<script src="{{ asset('/js/moment.min.js') }}"></script>
<script src="{{ asset('/js/daterangepicker.js') }}"></script>
<!-- bootstrap datepicker -->
<script src="{{ asset('/js/bootstrap-datepicker.min.js') }}"></script>
<!-- bootstrap color picker -->
<script src="{{ asset('/js/bootstrap-colorpicker.min.js') }}"></script>
<!-- bootstrap time picker -->
<script src="{{ asset('/js/bootstrap-timepicker.min.js') }}"></script>
<!-- iCheck 1.0.1 -->
<script src="{{ asset('/js/icheck.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('/js/fastclick.js') }}"></script>

<script src="{{ asset('/plugins/datepicker/locales/bootstrap-datepicker.es.js') }}" type="text/javascript"></script>