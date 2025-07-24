<!-- jQuery 2.1.4 -->
{{-- <script src="{{ asset('/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script> --}}
<!-- Bootstrap 3.3.2 JS -->
{{-- <script src="{{ asset('/js/bootstrap.min.js') }}" type="text/javascript"></script> --}}
<!-- iCheck -->
{{-- <script src="{{ asset('/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script> --}}
{{-- mensajes toastr --}}
<script src="{{ asset('/js/toastr.js')}}" type="text/javascript"></script>
<script src="{{ asset('/js/login.js') }}" type="text/javascript"></script>



<script type="text/javascript">
	$('.vercontra').click(function(event) {
		if($('.vercontra').is(':checked')){
			$('#password1').attr('type','text');
		}else{
			$('#password1').attr('type','password');
		}
	});
</script>
