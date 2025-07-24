@extends('layouts.app')
@section('htmlheader_title')
PDF
@endsection
@section('main-content')
<!-- nombre del panel -->
@section('contentheader_title')
Graficas @if(Auth::user()->estados == 'TODOS') de todos los estados @else del Estado {{ Auth::user()->estados }} @endif
@endsection
<style>
	.leyenda{
		text-align: justify;
		color: white;
		/*letter-spacing: -1px;*/
	}
	.listado{
	/*width: 200px;*/
	display: inline-block;
	margin-top: -50px;
	z-index: auto !important;
	}
	.listado a {
		color: white;
		text-decoration:none;
		font-size: 12px;
		/*letter-spacing: -1px;*/

	}
	.listado ul {
		text-align: left;
		white-space: nowrap;
	}
	.listado li {
		/*padding-right: 15px;*/
		list-style-type: none;
	}
	.background{
		background-image: url('../img/fondoMapa.jpg');
		background-size: cover;
		background-repeat: no-repeat;
	}
</style>
<div class="container-fluid">
	<div class="col-lg-12 col-sm-12 col-sm-offset-0">

		<!-- <div class="panel-body" > -->
			<div class="box box-danger background" style="padding-left: 100px;">
				<div class="mx-auto"  >
					<center>
						<h2 class="">GRAFICAS DEL PROCESO @if(Auth::user()->estados == 'TODOS') EN TODOS LOS ESTADOS @else DEL ESTADO {{ Auth::user()->estados }} @endif</h2>
					</center>
				</div>
	<!-- 			<div class="form-group has-feedback col-md-12">
				    <a class="btn btn-danger fa fa-bar-chart fa-4x" href="{{url('/graficaEstadosTodos')}}" target="_blank"></a>
				    <label>GENERAL</label>
				</div>

				@foreach($estados as $es)
				<div class="form-group has-feedback col-md-3">
				  <a class="btn btn-danger fa fa-bar-chart fa-4x" href="{{url('/graficaEstados', $es->estado)}}" target="_blank"></a>
				  <label>{{ $es->estado }}</label>
				</div>
			    @endforeach -->

  				<div class="row">
					<div class="col-md-4 leyenda" id="leyenda" >
  						<div class="container"> 
			      			<img src="img/Mapeado3.png" class="map d-none d-lg-block" height="100%" alt="" usemap="#MapaVenezuela"/>

    						<div id="listaEstados" class="listado">
									<div class="row">
								          <ul class="col-6 col-sm-6 col-md-3">
								            <li>1.<a href="">AMAZONAS</a></li>
								            <li>2.<a href="">ANZOATEGUI</a></li>
								            <li>3.<a href="">APURE</a> </li>
								            <li>4.<a href="">ARAGUA</a></li>
								            <li>5.<a href="">BARINAS</a></li>
								            <li>6.<a href="">BOLÍVAR</a></li>
								          </ul>
								          <ul class="col-6 col-sm-6 col-md-3">
								            <li>7.<a href="">CARABOBO</a></li>
								            <li>8.<a href="">COJEDES</a></li>
								            <li>9.<a href="">DELTA AMACURO</a></li>
								            <li>10.<a href="">DISTRITO CAPITAL</a> </li>
								            <li>11.<a href="">FALCON</a></li>
								            <li>12.<a href="">GUÁRICO</a></li>
								          </ul>
								          <ul class="col-6 col-sm-6 col-md-3">
								            <li>13.<a href="">LA GUAIRA</a></li>
								            <li>14.<a href="">LARA</a></li>
								            <li>15.<a href="">MÉRIDA</a></li>
								            <li>16.<a href="">MIRANDA</a> </li>
								            <li>17.<a href="">MONAGAS</a></li>
								            <li>18.<a href="">NUEVA ESPARTA</a></li>
								          </ul>
								          <ul class="col-6 col-sm-6 col-md-3">
								            <li>19.<a href="">PORTUGUESA</a></li>
								            <li>20.<a href="">SUCRE</a></li>
								            <li>21.<a href="">TÁCHIRA</a></li>
								            <li>22.<a href="">TRUJILLO</a> </li>
								            <li>23<a href="">YARACUY</a></li>
								            <li>24.<a href="">ZULIA</a></li>
								          </ul>
								  	</div>
    						</div>
  						</div>
  					</div>
  				</div>




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
