<!DOCTYPE html>
<html lang="en">
@section('htmlheader')
@include('layouts.partials.htmlheader')
@show
{{-- efecto cargador --}}
<div class="capa loading" style="display: none;z-index: 1060;"></div>
<center>
    <div class="contentLoad loading" style="display: none;z-index: 1080;">
        <b class="loadcss" style="font-size: 2rem;">Cargando...</b>
        <i class="fa fa-refresh fa-spin fa-5x fa-fw loadcss" style="margin-top: 2.5rem"></i>
    </div>
</center>
{{-- fin de efecto cargador --}}
<body class="skin-black sidebar-mini">
    <div class="wrapper">
        @include('layouts.partials.mainheader')

        @include('layouts.partials.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @include('layouts.partials.contentheader')
            <!-- Main content -->
            <section class="content">
                <!-- Your Page Content Here -->
                @yield('main-content')
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->
        @include('layouts.partials.controlsidebar')
        @include('layouts.partials.footer')
    </div><!-- ./wrapper -->
    <!-- Ventana  Modal -->
    <div id="detalles" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg " style="width: 100%;max-width: 1200px;min-width: 600px">
            <div class="modal-content">
                <!-- MOSTRAR CONTENIDO PROVENIENTE DE AJAX -->
                <div  id="ventaModal"></div>
            </div>
        </div>
    </div>
    @section('scripts')
    @include('layouts.partials.scripts')
    @show
</body>
</html>