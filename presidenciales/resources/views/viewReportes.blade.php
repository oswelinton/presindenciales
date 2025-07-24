@extends('layouts.app')
@section('htmlheader_title')
Home
@endsection
@section('main-content')
<!-- nombre del panel -->
@section('contentheader_title')
Reportes
@endsection



<div class="container-fluid">
	<div class="col-lg-12 col-sm-12 col-sm-offset-0">

		<div class="panel-body">
			<div class="box box-danger">
				<div class="box-header with-border">
					<center>
						<h3 class="box-title">REPORTES DEL PERSONAL @if(Auth::user()->estados == 'TODOS') DE TODAS LAS DIRECCIONES @else del Estado {{ Auth::user()->estados }} @endif</h3>
					</center>
				</div>
				<div class="box-body">
					<form id="form_reporte" class="form_entrada" role="form" method="POST" >
						<div class="box-header with-border">
							<div class="form-group col-sm-1">
								FILTRAR POR EDADES:
							</div>
							<div class="form-group col-sm-5">
								<select id="selectEdad" name="selectEdad" class="form-control">
									<option value="0" selected >TODAS LAS EDADES</option>
									<option value="1">DE 18 A 25 AÑOS</option>
									<option value="2">DE 26 A 35 AÑOS</option>
									<option value="3">DE 36 A 45 AÑOS</option>
									<option value="4">DE 46 A 55 AÑOS</option>
									<option value="5">MAYORES DE 55 AÑOS</option>
								</select>
							</div>
						</div>
						<div class="center">
							<div class="form-group has-feedback col-md-4">
								<center>
				            	<label>Descargar reporte del Personal que votó</label><br><hr>
				                <a class="btn btn-success fa fa-file-excel-o fa-3x" href="javascript:ExportarExcelReporte(1)"></a>
				                <!-- <a class="btn btn-success fa fa-file-excel-o fa-3x" href="{{url('/reportes/'.'1')}}"></a> -->
								</center>
				            </div>
							<div class="form-group has-feedback col-md-4">
								<center>
				            	<label>Descargar reporte del Personal que indicó que no votarán</label><br><hr>
				                <a class="btn btn-success fa fa-file-excel-o fa-3x" href="javascript:ExportarExcelReporte(2)"></a>
				                <!-- <a class="btn btn-success fa fa-file-excel-o fa-3x" href="{{url('/reportes/'.'2')}}"></a> -->

								</center>
				            </div>
							<div class="form-group has-feedback col-md-4">
								<center>
				            	<label>Descargar reporte del Personal que quedo en estado de verificación</label><br><hr>
				                <a class="btn btn-success fa fa-file-excel-o fa-3x" href="javascript:ExportarExcelReporte(0)"></a>
				                <!-- <a class="btn btn-success fa fa-file-excel-o fa-3x" href="{{url('/reportes/'.'0')}}"></a> -->
								</center>
				            </div>
						</div>
					</form>
				</div>
				<!-- /.box-body -->
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

function ExportarExcelReporte(TipoReporte){
	link='/reportes/'+TipoReporte+'/'+$('#selectEdad').val();
	// alert(link)
    window.open(link);
 }

</script>	

<!-- <div class="container-fluid">
	<div class="col-lg-12 col-sm-12 col-sm-offset-0">

		<div class="panel-body">
			<div class="box box-danger">
				<div class="box-header with-border">
					<center>
						<h3 class="box-title">Reportes Generales por Edades @if(Auth::user()->estados == 'TODOS') DE TODOS LOS ESTADOS @else del Estado {{ Auth::user()->estados }} @endif</h3>
					</center>
				</div>
 --><!-- 				<div class="box-body">
					<label for="disabledSelect">Seleccione una opción para visualizar los Reportes por Edades</label>
					<div class="center">
						<div class="form-group col-sm-3">
							<select id="disabledSelect" class="form-control">
								<option selected disabled>...</option>
								<option value="1">18-25</option>
								<option value="2">26-35</option>
								<option value="3">36-45</option>
								<option value="4">46-55</option>
							</select>
						</div><br><br><br>
						<div class="form-group has-feedback col-md-4">
							<center>
			            	<label>Descargar reporte del Personal que votó</label><br><hr>
			                <a class="btn btn-success fa fa-file-excel-o fa-3x" href="{{url('/reportes/'.'1')}}"></a>
							</center>
			            </div>
						<div class="form-group has-feedback col-md-4">
							<center>
			            	<label>Descargar reporte del Personal que indicó que no votarán</label><br><hr>
			                <a class="btn btn-success fa fa-file-excel-o fa-3x" href="{{url('/reportes/'.'2')}}"></a>
							</center>
			            </div>
						<div class="form-group has-feedback col-md-4">
							<center>
			            	<label>Descargar reporte del Personal que quedo en estado de verificación</label><br><hr>
			                <a class="btn btn-success fa fa-file-excel-o fa-3x" href="{{url('/reportes/'.'0')}}"></a>
							</center>
			            </div>
					</div>
				</div> -->
				<!-- /.box-body -->
<!-- 			</div>
		</div>
	</div>
</div> -->


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

@endsection
