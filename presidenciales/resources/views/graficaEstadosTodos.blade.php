@extends('layouts.app')
@section('htmlheader_title')
Home
@endsection
@section('main-content')
<!-- nombre del panel -->
@section('contentheader_title')
Gráficas
@endsection


<script type="text/javascript">
	$(document).ready(function()
	{
		spinner = '<center style="margin-top:5rem;"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i></center>';
		$("#viewGrafico").html(spinner);
		dibujagrafico();
		$("#viewGrafico2").html(spinner);
		dibujagrafico2();
		dibujagrafico3();
		
		setInterval(function(){
			dibujagrafico();
			dibujagrafico2();
			dibujagrafico3();

		},30000);
	});

	function dibujagrafico(dibujar){

		$.get('/graficaJSONTodos', function(data) {
			// alert(JSON.stringify(data));
			var options={
				chart: {
					type: 'column'
				},
				title: {
					text: '<b>RESULTADOS GENERALES DE LAS ELECCIONES MUNICIPALES 2025</b>'
				},
				subtitle: {
					text: ''
				},
				xAxis: {
					type: 'category'
				},
				yAxis: {
					title: {
						text: 'Total'
					}

				},
				legend: {
					enabled: false
				},
				plotOptions: {
					series: {
						borderWidth: 0,
						dataLabels: {
							enabled: true,
							format: '{point.y} Personas '
						}
					}
				},

				tooltip: {
					headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
					pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> votantes<br/>'
				},
				colors: ['#6CF', '#f39c12', '#380261', '#ef0000', '#3ee297'],
				series: [{
					name: 'Personal',
					colorByPoint: true,
					data: [
					{
						name: 'Total del personal votante',
						y: data['total_personas'],
						drilldown: 'totales'
					},
					{
						name: 'Total de personal faltante por verificar si votó',
						y: data['total_personas_verificando'],
						drilldown: 'porverificar'
					},
					{
						name: 'Total del personal reportado como ya votó',
						y: data['total_personas_votaron'],
						drilldown: 'reportados'
					},
					{
						name: 'Total de personas reportado como no votará',
						y: data['total_personas_novotara'],
						drilldown: 'novotara'
					},
					// {
					// 	name: 'Total de personas movilizadas por el personal',
					// 	y: data['voto_m'],
					// 	drilldown: 'movilizados'
					// },
					]
				},{
					type: 'spline',
					name: 'Total del personal votante',

					color: '#6CF',

					data: [
					{
						name: 'PERSONAL VOTANTE',
						y: data['total_administrativos'],

					},
					],
					marker: {
						lineWidth: 2,
						lineColor: Highcharts.getOptions().colors[1],
						fillColor: 'white'
					}
				},{
					type: 'spline',
					name: 'Total del personal reportado como ya votó',

					color: '#380261',

					data: [
					{
						name: 'PERSONAL VOTANTE',
						y: data['total_administrativos_votaron'],

					},
					],
					marker: {
						lineWidth: 2,
						lineColor: Highcharts.getOptions().colors[1],
						fillColor: 'white'
					}
				},{
					type: 'spline',
					name: 'Personal que no Votará',

					color: 'red',

					data: [
					{
						name: 'PERSONAL VOTANTE',
						y: data['total_administrativos_novotara'],

					},
					],
					marker: {
						lineWidth: 2,
						lineColor: Highcharts.getOptions().colors[1],
						fillColor: 'white'
					}
				},
				// {
				// 	type: 'spline',
				// 	name: 'Total de personas movilizadas por el personal',

				// 	color: '#3ee297',

				// 	data: [
				// 	{
				// 		name: 'ADMINISTRATIVOS',
				// 		y: data['total_movilizados_administrativos'],
				// 	},
				// 	{
				// 		name: 'CONTRATADOS',
				// 		y: data['total_movilizados_contratados'],

				// 	},
				// 	{
				// 		name: 'JURIDICOS',
				// 		y: data['total_movilizados_administrativos'],

				// 	},
				// 	{
				// 		name: 'JUBILADOS',
				// 		y: data['total_movilizados_jubilados'],
				// 	},
				// 	],
				// 	marker: {
				// 		lineWidth: 2,
				// 		lineColor: Highcharts.getOptions().colors[1],
				// 		fillColor: 'white'
				// 	}
				// },
				],

				drilldown: {
					series: [
					{
						name: 'Total del personal votante',
						id: 'totales',
						data: [
						{
							name: 'PERSONAL VOTANTE',
							y: data['total_administrativos'],

						},
						
						]
					},
					{
						name: 'Total de personal faltante por verificar si votó',
						id: 'porverificar',
						data: [
						{
							name: 'PERSONAL VOTANTE',
							y: data['total_administrativos_verificando'],

						},
						
						]
					},
					{
						name: 'Total del personal reportado como ya votó',
						id: 'reportados',
						data: [
						{
							name: 'PERSONAL VOTANTE',
							y: data['total_administrativos_votaron'],

						},
						
						]
					},
					{
						name: 'Total del personal reportado como ya no votará',
						id: 'novotara',
						data: [
						{
							name: 'PERSONAL VOTANTE',
							y: data['total_administrativos_novotara'],

						},
						
						]
					},
					// {
					// 	name: 'Total de personas movilizadas por el personal',
					// 	id: 'movilizados',
					// 	data: [
					// 	{
					// 		name: 'ADMINISTRATIVOS',
					// 		y: data['total_movilizados_administrativos'],
					// 	},
					// 	{
					// 		name: 'CONTRATADOS',
					// 		y: data['total_movilizados_contratados'],

					// 	},
					// 	{
					// 		name: 'JURIDICOS',
					// 		y: data['total_movilizados_administrativos'],

					// 	},
					// 	{
					// 		name: 'JUBILADOS',
					// 		y: data['total_movilizados_jubilados'],
					// 	},
					// 	]
					// },
					]
				}
			}
			chart = new Highcharts.Chart('viewGrafico',options);

		});
}

function dibujagrafico2(dibujar)
	{
		$.get('/graficaJSONTodos2', function(data) {
			// alert(JSON.stringify(data));
			// console.clear;
			// console.table(data);
			// console.log('Data Femenino');
			datafemenino=data['femenino'];
			// console.table(datafemenino);

			// console.log('Data Masculino');
			datamasculino=data['masculino'];
			// console.table(datamasculino);

			/*datafemenino=[900, 400,200,300];
			console.table(datafemenino);

			datamasculino= [1100, 500,400,200];
			console.table(datamasculino);*/


			var options={
				chart: {
					type: 'column'
				},
				title: {
					text: '<b>RESULTADOS GENERALES POR GENERO (MASCULINO / FEMENINO)</b>'
				},
				subtitle: {
					text: ''
				},
				xAxis: {
					//type: 'category'
					//categories: ['total_femenino', 'total_masculino']
					 categories: ['PERSONAL', 'VOTO', 'NO VOTARA','POR VERIFICAR']
				},
				// yAxis: {
				// 	allowDecimals: false,
				// 	min: 0,
				// 	title: {
				// 	     text: 'Total Por Genero'
				// 	}
			    yAxis: {
			        allowDecimals: false,
			        min: 0,
			        title: {
			            text: 'Total'
			        }
				},
				legend: {
					enabled: true
				},
				// plotOptions: {
				// 	column: {
			 //            stacking: 'normal'
			 //        }
				// },
				plotOptions: {
					series: {
						borderWidth: 0,
						dataLabels: {
							enabled: true,
							format: '{point.y}'
						}
					}
				},
				tooltip: {
					headerFormat: '<span style="font-size:11px">{series.name}:{y}</span><br>',
					pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> votantes<br/>'
				},
				// tooltip: {
			 //        format: '<b>{key}</b><br/>{series.name}: {y}<br/>' +
			 //            'Total: {point.stackTotal}'
			 //    },
				colors: ['#6CF', '#f3122d'],
				// series: [{
				// 	name: 'Personal',
				// 	colorByPoint: true,
				// 	data: [
				// 	{
				// 		name: 'Total del personal votante',
				// 		y: data['total_masculino'],
				// 		drilldown: 'totales'
				// 	},
				// 	{
				// 		name: 'Total de personal faltante por verificar si votó',
				// 		y: data['total_femenino'],
				// 		drilldown: 'porverificar'
				// 	},
				// 	{
				// 		name: 'Total del personal reportado como ya votó',
				// 		y: data['total_personas_votaron'],
				// 		drilldown: 'reportados'
				// 	},
				// 	{
				// 		name: 'Total de personas reportado como no votará',
				// 		y: data['total_personas_novotara'],
				// 		drilldown: 'novotara'
				// 	},
				// 	{
				// 		name: 'Total de personas movilizadas por el personal',
				// 		y: data['voto_m'],
				// 		drilldown: 'movilizados'
				// 	},]
				// },],
				series: [{
			        name: 'MASCULINO',
			        data: datamasculino
			        // data: [1100, 500,400,200]

			    }, {
			        name: 'FEMENINO',
			        data: datafemenino
			        // data: [900, 400,200,300]
			       
			    }],

			}
			chart = new Highcharts.Chart('viewGrafico2',options);
		});
}

function dibujagrafico3(dibujar){

		$.get('/graficaJSONTodos3', function(data) {
			// alert(JSON.stringify(data));
			// dataTodas=[25,11, 6,8];

			// console.table(dataTodas);

			// data1825= [5, 2,2,1];
			data1825=data['data1825'];
			// console.table(data1825);

			// data2635= [9, 3,4,2];
			data2635=data['data2635'];

			// data3645= [5, 2,0,3];

			data3645=data['data3645'];

			// data4655= [4, 3,0,1];

			data4655=data['data4655'];

			// dataMayor55= [2, 1,0,1];

			dataMayor55=data['dataMayor55'];


			var options={
				chart: {
					type: 'column'
				},
				title: {
					text: '<b>RESULTADOS GENERALES POR INTERVALOS DE EDAD</b>'
				},
				subtitle: {
					text: ''
				},
				xAxis: {
					//type: 'category'
					//categories: ['total_femenino', 'total_masculino']
					 categories: ['PERSONAL', 'VOTO', 'NO VOTARA','POR VERIFICAR']
				},
				legend: {
					enabled: true
				},
				plotOptions: {
					series: {
						borderWidth: 0,
						dataLabels: {
							enabled: true,
							format: '{point.y}'
						}
					}
				},
				colors: ['#f39c12', '#380261', '#ef0000', '#2f7bb3','#39b32f'],
				series: [{
			        name: 'DE 18 A 25',
			        data: data1825
			        // data: [1100, 500,400,200]

			    }, {
			        name: 'DE 26 A 35',
			        data: data2635
			        // data: [900, 400,200,300]
			       
			    }, {
			        name: 'DE 36 A 45',
			        data: data3645
			        // data: [900, 400,200,300]
			       
			    }, {
			        name: 'DE 46 A 55',
			        data: data4655
			        // data: [900, 400,200,300]
			       
			    }, {
			        name: 'MAYORES DE 55',
			        data: dataMayor55
			        // data: [900, 400,200,300]
			       
			    }],
			}
			chart = new Highcharts.Chart('viewGrafico3',options);

		});
}
</script>




<div class="container-fluid">
	<div class="col-lg-12 col-sm-12 col-sm-offset-0">
		<div class="panel-body">
			<div id="viewGrafico" style="min-width: 310px; height: 380px; margin: 0 auto"></div>
		</div>
	</div>
	<div class="col-lg-12 col-sm-12 col-sm-offset-0">
		<div class="col-lg-6 col-sm-6 col-sm-offset-0">
			<div class="panel-body">
				<div id="viewGrafico2" style="min-width: 210px; height: 380px; margin: 0 "></div>
			</div>
		</div>
		<div class="col-lg-6 col-sm-6">
			<div class="panel-body">
				<div id="viewGrafico3" style="min-width: 210px; height: 380px; margin: 0 "></div>
			</div>
		</div>
		<center><label>Esta gráfica es mostrada y actualizada cada 30 segundos automaticamente</label></center>
	</div>
</div>


<!-- jQuery 2.1.4 -->
<script src="{{ asset('/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="{{ asset('/js/highchart/highcharts.js') }}"></script>
<script src="{{ asset('/js/highchart/modules/data.js') }}"></script>
<script src="{{ asset('/js/highchart/drilldown.js') }}"></script>

@endsection



