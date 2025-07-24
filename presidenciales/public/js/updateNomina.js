// 	$(document).on("submit",".form_edit",function(e){
// //funcion para atrapar los formularios y enviar los datos
//         e.preventDefault();
//         var formu=$(this);
//         var quien=$(this).attr("id");
//         var token = $("#token").val();
//         if(quien=="form_updateEmpleado"){ var miurl="/empleadoUpdate";  var table = reloadTable('nominaTable');}
//         if(quien=="form_deleteEmpleado"){ var miurl="/deleteEmpleado";  var table = reloadTable('nominaTable');}
//         var formData = new FormData($('#'+quien+'')[0]);
//           $.ajax({
//             url: miurl,
//             type:"POST",
//             headers:{'X-CSRF-TOKEN':token},

//             data: formData,
//             //necesario para subir archivos via ajax
//             cache: false,
//             contentType: false,
//             processData: false,
//             //mientras enviamos el archivo
//             beforeSend: function(){
//                 $('.loadingg').show();
//                 $('.savedd').hide();
//             },
//             success : function(response)
//             {
//                 setTimeout(function(){  $('.loadingg').hide(); $('.savedd').show(); },2000);
//                 $('#'+quien).trigger("reset");
//                 dataSuccess(response);//retornar mensaje
//                 table
//                 $('#detalles').modal('hide');//venta modal encaso ser abierta cerrar despues de enviar datos
//             },
//             error:function(){
//                 setTimeout(function(){  $('.loadingg').hide(); $('.savedd').show(); },2000);
//                 dataError('Error al enviar los datos');
//                 $('#detalles').modal('hide');
//             }
//         });
// })