$(document).on("submit",".form_entrada",function(e){
//funcion para atrapar los formularios y enviar los datos
e.preventDefault();
var formu=$(this);
var quien=$(this).attr("id");
var token = $("#token").val();

if(quien=="form_buscarcedula"){ var miurl="/cedulaempleado"; }
if(quien=="form_estadoempleado"){ var miurl="/estadoempleado"; }

var formData = new FormData($('#'+quien+'')[0]);
$.ajax({
    url: miurl,
    type:"POST",
    headers:{'X-CSRF-TOKEN':token},
    data: formData,
    cache: false,
    contentType: false,
    processData: false,

    beforeSend: function(){
        $('.loading').show();
        $('.saved').hide();
    },
    success : function(response)
    {
        dataMessage(response['tipo'],response['msj']);
        setTimeout(function() {
            $('.loading').hide();
            $('.saved').show();
            redireccionar(response['url']);
            $('#detalles').modal('hide');
        }, 5000);
    },
    error:function(response){
        $('.loading').hide();
        $.each(response.responseJSON, function(index, val) {
          dataMessage('error',val);
          $('#detalles').modal('hide');
      });
    }
});
})


function redireccionar(URL){
    if (URL != '') {
     location.href = ''+URL+'';
 };
}



function accionModal(ruta,id)
{
   $.get('/'+ruta+'/'+id, function(data)
   {
    if (data['tipo']=='error')
    {
        dataMessage(data['tipo'],data['msj']);
    }
    else
    {
        dataMessage('success','Busqueda Exitosa');
        $('#detalles').modal('show');
        $('#ventaModal').html(data);
    }
});
}