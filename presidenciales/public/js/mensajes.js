/*mostrar mensajes simples para confirmar o alertar al usuario*/
function dataMessage(tipo,msj){
	Command: toastr[""+tipo+""](""+msj+"");
	cuerpoMessage();

}


/*el mismo cuerpo sera usado para mostrar el mensaje*/
function cuerpoMessage(){
	toastr.options = {
	  "closeButton": true,
	  "debug": false,
	  "newestOnTop": false,
	  "progressBar": true,
	  "rtl": false,
	  "positionClass": "toast-top-right",
	  "preventDuplicates": false,
	  "onclick": null,
	  "showDuration": 300,
	  "hideDuration": 1000,
	  "timeOut": 5000,
	  "extendedTimeOut": 1000,
	  "showEasing": "swing",
	  "hideEasing": "linear",
	  "showMethod": "fadeIn",
	  "hideMethod": "fadeOut"
	}
}