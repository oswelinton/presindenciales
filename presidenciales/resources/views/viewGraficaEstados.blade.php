@extends('layouts.app')
@section('htmlheader_title')
PDF
@endsection
@section('main-content')
<!-- nombre del panel -->
@section('contentheader_title')
Graficas @if(Auth::user()->estados == 'TODOS') de todos los estados @else del Estado {{ Auth::user()->estados }} @endif
@endsection

<div class="container-fluid">
	<div class="col-lg-12 col-sm-12 col-sm-offset-0">

		<!-- <div class="panel-body" > -->
			<div class="box box-danger" style="padding-left: 100px;">
				<div class="mx-auto"  >
					<center>
						<h3 class="box-title">REPORTES DEL PERSONAL VOTANTE @if(Auth::user()->estados == 'TODOS') DE TODAS LAS DIRECCIONES @else del Estado {{ Auth::user()->estados }} @endif</h3>
					</center>
				</div>
				<div class="form-group has-feedback col-md-12">
				    <a class="btn btn-danger fa fa-bar-chart fa-4x" href="{{url('/graficaEstadosTodos')}}" target="_blank"></a>
				    <label>GENERAL</label>
				</div>

				@foreach($estados as $es)
				<div class="form-group has-feedback col-md-3">
				  <a class="btn btn-danger fa fa-bar-chart fa-4x" href="{{url('/graficaEstados', $es->estado)}}" target="_blank"></a>
				  <label>{{ $es->estado }}</label>
				</div>
			    @endforeach
			</div>
		<!-- </div> -->
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

@endsection
