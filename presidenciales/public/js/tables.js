// $(document).ready(function() {
//   // tablaInicial();
// });

// /*recargar tabla despues de enviar formulario*/
// function reloadTable(load)
// {
//      if (load == 'nominaTable')
//      {
//           table = $('#nominaTable').DataTable();
//           table.destroy();
//           table = $("#nominaTable").DataTable({
//            "paging":         false,
//            "scrollY":        "270px",
//            "scrollX":        false,
//            "scrollCollapse": true,
//            "oLanguage": {"sUrl":"/js/EStables.js"},
//            "ajax": "/cargarTabla/nomina",
//                 columns: [
//                       { data: "nombre_completo" },
//                       { data: "cedula" },
//                       { data: "dependencia" },
//                       {
//                           "data": null,
//                           "defaultContent": "<button class='btn btn-info perfil'><i class='md fa fa-pencil'></i></button>"
//                       },
//                       {
//                           "data": null,
//                           "defaultContent": "<button class='btn btn-danger delete'><i class='md fa fa-trash-o'></i></button>"
//                       }
//                   ]
//             });
//           $('#nominaTable tbody').on( 'click', '.perfil', function () {
//                 var data = table.row( $(this).parents('tr') ).data();
//                 accionModal('empleadoEdit',data['idemp']);
//           });
//           $('#nominaTable tbody').on( 'click', '.delete', function () {
//                 var data = table.row( $(this).parents('tr') ).data();
//                 accionModal('empleadoDelete',data['idemp']);
//           });
//      }
// }
// function filterSinNomina(){
//   departamento = $("#dependencias").val();

//   table = $('#reportadoSinNomina').DataTable();
//           table.destroy();
//           table = $("#reportadoSinNomina").DataTable({
//             "paging":   false,
//             "scrollY":  "270px",
//             "scrollX":  false,
//               "scrollCollapse": true,
//             "oLanguage": {"sUrl":"/js/EStables.js"},
//           "ajax": "/cargarTabla/reportado/"+departamento,
//                   columns: [
//                       { data: "nombre_completo" },
//                       { data: "cedula" },
//                       { data: "DEPENDENCIA ACTUAL" },
//                   ],
//                 dom: 'Bfrtip',
//                   buttons: [
//                        {
//                           extend:    'excelHtml5',
//                           text:      'Excel <i class="fa fa-file-excel-o"></i>',
//                           titleAttr: 'Excel',
//                           filename: 'Personal Ausente',
//                            customize: function(xlsx) {
//                                   var sheet = $('cellxfs',xlsx.xl.worksheets['sheet1.xml']);

//                                   var col = $('col', sheet);
//                                   $(col[0]).attr('width', 35);
//                                   $(col[1]).attr('width', 10);
//                                   $(col[2]).attr('width', 40);
//                                   $(col[3]).attr('width', 20);
//                                 /*recorre toda las filas 1 y pon un color*/
//                                   $('row c[r*="1"]', sheet).each( function () {
//                                           $(this).attr( 's', '20' );
//                                   });

//                               /*$('row c[r^="C"]', sheet).each( function () {
//                                   // Get the value
//                                   if ( $('is t', this).text() == 'DIRECCION DE ESTUDIOS TECNICOS' ) {
//                                       $(this).attr( 's', '20' );
//                                   }
//                               });
// */

//                               }
//                       }
//                   ]
//             });
// }
// function filterReportado(){
//   departamento = $("#dependencias").val();

//    table = $('#reportadoNominal').DataTable();
//           table.destroy();
//           table = $("#reportadoNominal").DataTable({
//             "paging":   false,
//             "scrollY":  "270px",
//             "scrollX":  false,
//             "scrollCollapse": true,
//             "oLanguage": {"sUrl":"/js/EStables.js"},
//             "ajax": "/cargarTabla/cruce/"+departamento,
//                   columns: [
//                       { data: "nombre_completo" },
//                       { data: "cedula" },
//                       { data: "DEPENDENCIA ACTUAL" },
//                       { data: "DEPENDENCIA NOMINAL" },
//                   ],
//                 dom: 'Bfrtip',
//                   buttons: [
//                        {
//                           extend:    'excelHtml5',
//                           text:      'Excel <i class="fa fa-file-excel-o"></i>',
//                           titleAttr: 'Excel',
//                           filename: 'Personal Ausente',
//                            customize: function(xlsx) {
//                                   var sheet = xlsx.xl.worksheets['sheet1.xml'];
//                                   var col = $('col', sheet);
//                                   $(col[0]).attr('width', 35);
//                                   $(col[1]).attr('width', 10);
//                                   $(col[2]).attr('width', 40);
//                                   $(col[3]).attr('width', 20);
//                                 /*recorre toda las filas 1 y pon un color*/
//                                   $('row c[r*="1"]', sheet).each( function () {
//                                           $(this).attr( 's', '20' );
//                                   });



//                               }
//                       }
//                   ]
//             });
// }

// function filterPresentes(){
//   departamento = $("#dependencias").val();
//   table = $('#presentesTable').DataTable();
//           table.destroy();

//            var buttonCommon = {
//               exportOptions: {
//                   format: {
//                       body: function ( data, row, column, node ) {
//                           // Strip $ from salary column to make it numeric
//                           return column === 5 ?
//                               data.replace( /[$,]/g, '' ) :
//                               data;
//                       }
//                   }
//               }
//           };

//           table = $("#presentesTable").DataTable({
//             "paging":   false,
//             "scrollY":        "270px",
//             "scrollX":        false,
//             "scrollCollapse": true,
//             "processing": true,
//             "oLanguage": {"sUrl":"/js/EStables.js"},
//             "ajax": "/cargarTabla/presentes/"+departamento,
//                   columns: [
//                       { data: "nombre_completo" },
//                       { data: "cedula" },
//                       { data: "dependencia" },
//                       { data: "fecha_final" },
//                   ],
//                   dom: 'Bfrtip',
//                   buttons: [
//                      {
//                           extend:    'excelHtml5',
//                           text:      'Excel <i class="fa fa-file-excel-o"></i>',
//                           titleAttr: 'Excel',
//                           filename: 'Personal Presente',
//                           customize: function(xlsx) {
//                                 var sheet = xlsx.xl.worksheets['sheet1.xml'];
//                                 var col = $('col', sheet);
//                                 $(col[0]).attr('width', 35);
//                                 $(col[1]).attr('width', 10);
//                                 $(col[2]).attr('width', 40);
//                                 $(col[3]).attr('width', 20);
//                               /*recorre toda las filas 1 y pon un color*/
//                                 $('row c[r*="1"]', sheet).each( function () {
//                                         $(this).attr( 's', '20' );
//                                 });


//                               $('row c[r^="C"]', sheet).each( function () {
//                                   // Get the value
//                                   if ( $('is t', this).text() == 'DIRECCION DE ESTUDIOS TECNICOS' ) {
//                                       $(this).attr( 's', '14' );
//                                   }
//                               });


//                             }
//                         }
//                     ]
//             });
// }
// function filterAusentes(){
//    departamento = $("#dependencias").val();
//    motivo = $(".motivos").val();
//     if (departamento == '' || motivo == '')
//     {
//         dataError('Asegurate de elegir el Departamento y Motivo');
//     }
//     else{
//    table = $('#ausentesTable').DataTable();
//           table.destroy();
//           table = $("#ausentesTable").DataTable({
//             "paging":   false,
//             "scrollY":  "270px",
//             "scrollX":  false,
//               "scrollCollapse": true,
//             "oLanguage": {"sUrl":"/js/EStables.js"},
//           "ajax": "/cargarTabla/ausentes/"+departamento+'/'+motivo,
//                   columns: [
//                       { data: "nombre_completo" },
//                       { data: "cedula" },
//                       { data: "dependencia" },
//                       { data: "ausencia" },
//                       { data: "fecha_final" },
//                   ],
//                 dom: 'Bfrtip',
//                   buttons: [
//                        {
//                           extend:    'excelHtml5',
//                           text:      'Excel <i class="fa fa-file-excel-o"></i>',
//                           titleAttr: 'Excel',
//                           filename: 'Personal Ausente',
//                            customize: function(xlsx) {
//                                   var sheet = xlsx.xl.worksheets['sheet1.xml'];
//                                   var col = $('col', sheet);
//                                   $(col[0]).attr('width', 35);
//                                   $(col[1]).attr('width', 10);
//                                   $(col[2]).attr('width', 40);
//                                   $(col[3]).attr('width', 20);
//                                 /*recorre toda las filas 1 y pon un color*/
//                                   $('row c[r*="1"]', sheet).each( function () {
//                                           $(this).attr( 's', '20' );
//                                   });



//                               }
//                       }
//                   ]
//             });
//         }
// }
// function filterOtraNomina(){
//    departamento = $("#dependencias").val();
//     if (departamento == '')
//     {
//         dataError('Asegurate de elegir el Departamento');
//     }
//     else{
//    table = $('#listaOtraNomina').DataTable();
//           table.destroy();
//           table = $("#listaOtraNomina").DataTable({
//             "paging":   false,
//             "scrollY":  "270px",
//             "scrollX":  false,
//             "scrollCollapse": true,
//             "oLanguage": {"sUrl":"/js/EStables.js"},
//             "ajax": "/cargarTabla/otraNomina/"+departamento,
//                   columns: [
//                       { data: "nombre_completo" },
//                       { data: "cedula" },
//                       { data: "dependencia" },
//                       { data: "ausencia" },
//                       { data: "fecha_final" },
//                   ],
//                 dom: 'Bfrtip',
//                   buttons: [
//                        {
//                           extend:    'excelHtml5',
//                           text:      'Excel <i class="fa fa-file-excel-o"></i>',
//                           titleAttr: 'Excel',
//                           filename: 'Personal Ausente',
//                            customize: function(xlsx) {
//                                   var sheet = xlsx.xl.worksheets['sheet1.xml'];
//                                   var col = $('col', sheet);
//                                   $(col[0]).attr('width', 35);
//                                   $(col[1]).attr('width', 10);
//                                   $(col[2]).attr('width', 40);
//                                   $(col[3]).attr('width', 20);
//                                 /*recorre toda las filas 1 y pon un color*/
//                                   $('row c[r*="1"]', sheet).each( function () {
//                                           $(this).attr( 's', '20' );
//                                   });



//                               }
//                       }
//                   ]
//             });
//         }
// }
// function cuerpoTable(name)
// {

//   if (name == 'listaPersonas') {
//     URL = 'tablePersonal';
//     nameDIV = '#contentTablePersonal';
//   viewtable(URL,nameDIV)

//   }
//   if (name == 'listaNomina') {
//     URL = 'tableNomina';
//     nameDIV = '#contentTableNomina';
//   viewtable(URL,nameDIV)

//   }


// }
// function viewtable(URL,nameDIV){
//   $('.cargando').show();


//    $.get('/'+URL, function(response) {

//         $('.cargando').hide();

//         $(''+nameDIV+'').empty().append(response);
//         contRegister()

//   });
// }
// function tablaInicial(){
//     table = $('#tablepersonal').DataTable();
//     table.destroy();//destruit tabla

//     table = $("#tablepersonal").DataTable({
//         "oLanguage": {"sUrl":"/js/EStables.js"},
//         "paging":   false,
//         "scrollY":        "400px",
//         "scrollCollapse": true,
//         buttons: [
//                    {
//                       extend:    'excelHtml5',
//                       text:      'Excel <i class="fa fa-file-excel-o"></i>',
//                       titleAttr: 'Excel',
//                       filename: 'Empleados Registrados',
//                       customize: function(xlsx) {
//                                   var sheet = xlsx.xl.worksheets['sheet1.xml'];
//                                   var col = $('col', sheet);
//                                   $(col[0]).attr('width', 35);
//                                   $(col[1]).attr('width', 10);
//                                   $(col[2]).attr('width', 40);
//                                   $(col[3]).attr('width', 20);
//                                 /*recorre toda las filas 1 y pon un color*/
//                                   $('row c[r*="1"]', sheet).each( function () {
//                                           $(this).attr( 's', '20' );
//                                   });

//                                   $('row c[r^="C"]', sheet).each( function () {
//                                       // Get the value
//                                       if ( $('is t', this).text() == 'DIRECCION DE ESTUDIOS TECNICOS' ) {
//                                           $(this).attr( 's', '14' );
//                                       }
//                                   });

//                               }
//                   }
//               ]
//     });
// }
