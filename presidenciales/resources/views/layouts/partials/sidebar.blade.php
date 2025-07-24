<aside class="main-sidebar" style="padding-top: 0;z-index: 2">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
      <li class="header">
        <img src="{{url('img/logos/dem.jpg')}}" style="width:140px;height: 70px;padding:10px;margin-left: 15px">
      </li>
      <!-- Optionally, you can add icons to the links -->
      <li @if(isset($personal) && !empty($personal))class="{{$personal}}"@endif>
        <a href="{{ url('/Inicio') }}"><i class='fa fa-list-alt  '></i> <span>Buscar Personal</span></a>
      </li>

      <li @if(isset($reportes) && !empty($reportes))class="{{$reportes}}"@endif>
        <a href="{{ url('/viewReportes') }}"><i class='fa fa-file-pdf-o'></i> <span>Visualizar Reportes</span></a>
      </li>

      <li @if(isset($graficas) && !empty($graficas))class="{{$graficas}}"@endif>
        <a href="{{ url('/viewGraficas') }}"><i class='fa fa-pie-chart'></i> <span>Visualizar Gráficas</span></a>
      </li>

      <li>
        <a href="{{ url('/logout') }}"><i class="fa fa-sign-out" aria-hidden="true"></i><span>Salir de Sistema</span></a>
      </li>

    </ul><!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>