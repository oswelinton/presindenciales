// $(document).ready(function() {
//   $('.solonumber').on('input', function () {
//       this.value = this.value.replace(/[^0-9]/g,'');
//   });

	/*pasamos a la funcion nombres de
		1-tabla
		2-padre de la tabla en referencial
		3-valor en caso de existir una relacion ejmplo en el caso de EStado,Municipio,Parroquia
		4-id del select HTML
   */
 //   loadSelect('referencial','motivos',false,'.motivos','val');
 //   loadSelect('referencial','nacionalidad',false,'#nac','char');

 //   loadSelect('referencial','dependencia',false,'#dependencias','val');


 // });


// valor para datos relacionados como es en el caso de direccion
function loadSelect(tabla,item,valor,res,tipo){

  var select = $(res);

  select.append('<option value="">Cargando..</option>');
  $.ajax({
   url:'/main/'+tabla+'/'+item+'/'+valor,
   type: 'get',
   dataType: 'json'

 })
  .done(function(data) {
            //alert("Funciona en el select direccion");
            select.empty();
            if (valor == '') {select.append('<option value="">...</option>');}
            for (var i = 0; i < data.length; i++) {

              if (tipo == "char") {
                select.append('<option value="'+data[i].name+'">'+data[i].name+'</option>');
              }else{
                select.append('<option value="'+data[i].id+'">'+data[i].name+'</option>');
              }

            };

          })
  .fail(function() {
           // alert("Error al cargar el select "+item);
         })
  .always(function() {

  });
}
/*dar limite de numeros a campos de cedula*/
function ShowSelected(quien,dni)
{

  var combo = document.getElementById(''+quien+'');
  var nac = combo.options[combo.selectedIndex].text;

  select=$("#"+dni);
  select.attr('readonly',false);
  error=$("#cedula-error");

  select.attr({
    disabled: false,
  });
  select.removeAttr('aria-describedby').removeAttr('aria-invalid');
  select.val('');
  error.empty();
  if (nac == 'E')
  {
   select.attr({maxlength:"9"})
 }
 else if (nac == 'V') {
   select.attr({maxlength:"8"})
 }
}
function sololetras(e){

  key = e.keyCode || e.which;
  teclado=String.fromCharCode(key).toLowerCase();
  letras=" abcdefghijgklmnñopqrstuvwxyz";
  especiales="8-37-38-46-164";

  teclado_especial=false;

  for(var i in especiales){
    if (key==especiales[i]) {
      teclado_especial=true;break;
    }
  }

  if (letras.indexOf(teclado)==-1 && !teclado_especial)
  {
    return false;
  }
}

