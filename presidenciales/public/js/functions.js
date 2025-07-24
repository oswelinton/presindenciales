/*
	venta "#ventaModal" div ubicado en layouts/app esta comentado
	util para insetar,actualizar o eliminar
	sin necesidad de cargar una nueva página
*/
 $(function () {
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-red',
        radioClass: 'iradio_square-red',
        increaseArea: '20%' // optional
    });

	 $('.departamentos-select').select2({
	 	placeholder: 'Seleccione...',
	 });


});
 $(document).ready(function() {

	 (function ($) {

			$('#filtrar').keyup(function () {

				var rex = new RegExp($(this).val(), 'i');
				$('.buscar tr').hide();
				$('.buscar tr').filter(function () {
					return rex.test($(this).text());
				}).show();
			});

		}(jQuery));
 });
 function contRegister(){
    if ($('#tablepersonal >tbody >tr').length > 0){
      $(".numFilas").empty().append($('#tablepersonal >tbody >tr').length);
    }
}
/*habilitar campo de motivo de ausencia*/
$(document).on('ifChanged', '.ausente', function(event) {
	var option 	= $(this).attr('data-ausente');//nombre descriptor de campo radio
	var valor	= $(this).val();//valor del clave de foreach
	var n 		= $(this).attr('data-numP');//valor de id de persona para numerar clase de input oculto
	if (valor == 0)
	{
		$('.asiste'+n).attr('disabled',false);//habilitar
	}
	else{
		$('.asiste'+n).attr('disabled',true);//deshabilitar

	}
});
