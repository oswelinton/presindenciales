$(document).on("submit",".form_login",function(e){
//funcion para atrapar los formularios y enviar los datos
        e.preventDefault();
        var formu=$(this);
        var quien=$(this).attr("id");
        var token = $("#token").val();

        if(quien=="form_login"){ var miurl="/login"; var table = ''; }
        var formData = new FormData($('#'+quien+'')[0]);
          $.ajax({
            url: miurl,
            type:"POST",
            headers:{'X-CSRF-TOKEN':token},

            data: formData,
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
            //mientras enviamos el archivo
            beforeSend: function(){
            },
            success : function(response){

                dataMessage(response['tipo'],response['message'])

                if (response['username'] == true) {
                   $("#username").focus().css('border', '1px solid red');
                }else{
                   $("#username").css('border', '1px solid #d2d6de');
                   a = 1;
                }
                if (response['password'] == true) {
                   $("#password").focus().css('border', '1px solid red');
                }else{
                   $("#password").css('border', '1px solid #d2d6de');
                   b = 1;
                }
                /*
                  una vez los datos esten validados
                  se procede a mostrar capa de carga
                */
                capa = (a + b);
                if (capa == 2) {
                  $('.loading').show();
                }
            },
            error:function(){
                $('.loading').hide();
                alert('Error al enviar los datos');
            }
        });
})
/*mostrar mensajes simples para confirmar o alertar al usuario*/
function dataMessage(tipo,msj){
    Command: toastr[""+tipo+""](""+msj+"")
    cuerpoMessage();
    setTimeout(
        function(){
                 if (tipo == 'success')
                 {
                    location.href = '/Inicio';
                 }
        },5000);
}

/*el mismo cuerpo sera usado para mostrar el mensaje*/
function cuerpoMessage(){
    toastr.options = {
      "closeButton": false,
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
