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
		setInterval(function(){
			dibujagrafico();
		},30000);
	});

	function dibujagrafico(dibujar)
	{

		$.get('/graficaJSON', function(data) {
			// alert(JSON.stringify(data));
			var options={
				chart: {
					type: 'column'
				},
				title: {
					text: '<b>RESULTADOS GENERALES DE LAS VOTACIONES 2024 DEL PERSONAL</b>'
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
					pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> votos<br/>'
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
						name: 'ADMINISTRATIVOS',
						y: data['total_administrativos'],

					},
					{
						name: 'CONTRATADOS',
						y: data['total_contratados'],

					},
					{
						name: 'JURIDICOS',
						y: data['total_juridicos'],

					},
					{
						name: 'JUBILADOS',
						y: data['total_jubilados'],
					},],
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
						name: 'ADMINISTRATIVOS',
						y: data['total_administrativos_votaron'],

					},
					{
						name: 'CONTRATADOS',
						y: data['total_contratados_votaron'],

					},
					{
						name: 'JURIDICOS',
						y: data['total_juridicos_votaron'],

					},
					{
						name: 'JUBILADOS',
						y: data['total_jubilados_votaron'],
					},],
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
						name: 'ADMINISTRATIVOS',
						y: data['total_administrativos_novotara'],

					},
					{
						name: 'CONTRATADOS',
						y: data['total_contratados_novotara'],

					},
					{
						name: 'JURIDICOS',
						y: data['total_juridicos_novotara'],

					},
					{
						name: 'JUBILADOS',
						y: data['total_jubilados_novotara'],
					},],
					marker: {
						lineWidth: 2,
						lineColor: Highcharts.getOptions().colors[1],
						fillColor: 'white'
					}
				},{
					type: 'spline',
					name: 'Total de personas movilizadas por el personal',

					color: '#3ee297',

					data: [
					{
						name: 'ADMINISTRATIVOS',
						y: data['total_movilizados_administrativos'],
					},
					{
						name: 'CONTRATADOS',
						y: data['total_movilizados_contratados'],

					},
					{
						name: 'JURIDICOS',
						y: data['total_movilizados_administrativos'],

					},
					// {
					// 	name: 'JUBILADOS',
					// 	y: data['total_movilizados_jubilados'],
					// },
					],
					marker: {
						lineWidth: 2,
						lineColor: Highcharts.getOptions().colors[1],
						fillColor: 'white'
					}
				},],

				drilldown: {
					series: [
					{
						name: 'Total del personal votante',
						id: 'totales',
						data: [
						{
							name: 'ADMINISTRATIVOS',
							y: data['total_administrativos'],

						},
						{
							name: 'CONTRATADOS',
							y: data['total_contratados'],

						},
						{
							name: 'JURIDICOS',
							y: data['total_juridicos'],

						},
						{
							name: 'JUBILADOS',
							y: data['total_jubilados'],
						},
						]
					},
					{
						name: 'Total de personal faltante por verificar si votó',
						id: 'porverificar',
						data: [
						{
							name: 'ADMINISTRATIVOS',
							y: data['total_administrativos_verificando'],

						},
						{
							name: 'CONTRATADOS',
							y: data['total_contratados_verificando'],

						},
						{
							name: 'JURIDICOS',
							y: data['total_juridicos_verificando'],

						},
						{
							name: 'JUBILADOS',
							y: data['total_jubilados_verificando'],
						},
						]
					},
					{
						name: 'Total del personal reportado como ya votó',
						id: 'reportados',
						data: [
						{
							name: 'ADMINISTRATIVOS',
							y: data['total_administrativos_votaron'],

						},
						{
							name: 'CONTRATADOS',
							y: data['total_contratados_votaron'],

						},
						{
							name: 'JURIDICOS',
							y: data['total_juridicos_votaron'],

						},
						{
							name: 'JUBILADOS',
							y: data['total_jubilados_votaron'],
						},
						]
					},
					{
						name: 'Total del personal reportado como ya no votará',
						id: 'novotara',
						data: [
						{
							name: 'ADMINISTRATIVOS',
							y: data['total_administrativos_novotara'],

						},
						{
							name: 'CONTRATADOS',
							y: data['total_contratados_novotara'],

						},
						{
							name: 'JURIDICOS',
							y: data['total_juridicos_novotara'],

						},
						{
							name: 'JUBILADOS',
							y: data['total_jubilados_novotara'],
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

</script>

<div class="container-fluid">
	<div class="col-lg-12 col-sm-12 col-sm-offset-0">
		<div class="panel-body">
			<div id="viewGrafico" style="min-width: 310px; height: 400px; margin: 0 auto">
			</div>
			<label>Esta gráfica es mostrada y actualizada cada 30 segundos automaticamente</label>

		</div>
	</div>
</div>


<!-- jQuery 2.1.4 -->
<script src="{{ asset('/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="{{ asset('/js/highchart/highcharts.js') }}"></script>
<script src="{{ asset('/js/highchart/modules/data.js') }}"></script>
<script src="{{ asset('/js/highchart/drilldown.js') }}"></script>

@endsection


