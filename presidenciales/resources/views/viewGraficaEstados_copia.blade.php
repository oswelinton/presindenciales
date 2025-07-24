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
 	.logo{
		padding-top: 20px;
	}
    .card-container {
      font-family: 'Open Sans', sans-serif;
      font-size: 20px;
      font-weight: bold;

      width: 400px;
      height: 250px;
      margin: 80px auto;

      border-radius: 10px;

      perspective: 1400px;
    }

    .card {
      position: relative;

      height: 40%;

      border-radius: 10px;

      width: 40%;
      transform-style: preserve-3d;
      transition: transform 0.6s;
    }

    .front,
    .back {
      display: flex;

      width: 100%;
      height: 100%;

      border-radius: 10px;

      justify-content: center;
      align-items: center;
      backface-visibility: hidden;
    }

    .front {
      color: black;
      background: #2196f3;
      /*background-image: url('https://via.placeholder.com/400x250');*/ /* Añade la imagen de tu elección */
      background-image: url({{url('img/sep2024_min.png')}}); /* Añade la imagen de tu elección */
      background-size: cover;
      background-position: center;
      padding-top:140px;

    }

    .back {
      position: absolute;
      top: 0;
      left: 0;

      transform: rotateY(180deg);

      color: #2196f3;
      background: #fff;
    }
  </style>

<div class="container-fluid">
	<div class="col-lg-12 col-sm-12 col-sm-offset-0">

		<!-- <div class="panel-body" > -->
			<div class="box box-danger" style="padding-left: 100px;">
				<div class="mx-auto"  >
					<center>
						<h3 class="box-title">Reportes del Personal @if(Auth::user()->estados == 'TODOS') DE TODOS LOS ESTADOS @else del Estado {{ Auth::user()->estados }} @endif</h3>
					</center>
				</div>
<!-- 				<div class="form-group has-feedback col-md-4">
				    <a class="btn btn-danger fa fa-bar-chart fa-4x" href="{{url('/graficaEstadosTodos')}}" target="_blank"></a>
				    <label>GENERAL</label>
				</div> -->

				@foreach($estados as $es)
	<!-- 			<div class="form-group has-feedback col-md-4">
				  <a class="btn btn-danger fa fa-bar-chart fa-4x" href="{{url('/graficaEstados', $es->estado)}}" target="_blank"></a>
				  <label>{{ $es->estado }}</label>
				</div> -->
			    @endforeach
			</div>
	  <div class="card-container">
		    <div class="card">
		      <div class="front">
		        <!-- Imagen ya añadida como fondo -->
    			<!-- <img class="logo" src="img/logos/dem-2.png" alt="" width="150px"> -->
				<label>GENERAL</label>
		      </div>
		      <div class="back">
				    <a class="" href="{{url('/graficaEstadosTodos')}}" target="_blank"></a>
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

<!-- TARJETA ANIMADA -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
  <script>
    var card = document.querySelector(".card");
    var playing = false;

    card.addEventListener('mouseenter', function() {
      if (playing)
        return;

      playing = true;
      anime({
        targets: card,
        scale: [{value: 1}, {value: 1.4}, {value: 1, delay: 250}],
        rotateY: {value: '+=180', delay: 200},
        easing: 'easeInOutSine',
        duration: 300, // Reduje la duración para que sea más rápida
        complete: function(anim){
          playing = false;
        }
      });
    });

    card.addEventListener('mouseleave', function() {
      if (playing)
        return;

      playing = true;
      anime({
        targets: card,
        scale: [{value: 1}, {value: 1.4}, {value: 1, delay: 250}],
        rotateY: {value: '-=180', delay: 200},
        easing: 'easeInOutSine',
        duration: 300, // Reduje la duración para que sea más rápida
        complete: function(anim){
          playing = false;
        }
      });
    });
  </script>
@endsection
