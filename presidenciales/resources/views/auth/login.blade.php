@extends('layouts.auth')
@section('htmlheader_title')
Log in
@endsection

@section('content')

<div class="capa loading" style="display: none;"></div>
<center>
    <div class="contentLoad loading" style="display: none;">
        <b class="loadcss" style="font-size: 2rem; color: white;">Cargando...</b>
        <i class="fa fa-refresh fa-spin fa-5x fa-fw loadcss" style="margin-top: 2.5rem; color: white;"></i>
    </div>
</center>
<body class="body" style="min-width: 1200px;min-height: 625px;width: 100vw;height: 100vh; color: white;">
    @if (Auth::guest())
    <section class="login-block">
        <div class="container" id="htmlldap" style="color: white;">
            <div class="row">
                <div class="col-md-4 login-sec" style="padding-right: 0px;padding-right: 0px;">
                    <!-- Imagen añadida aquí -->
                    <div class="text-center" style="margin-bottom: 20px;">
                        <img src="{{url('img/logos/dem.jpg')}}" alt="Logo" style="max-width: 150px; height: auto;">
                    </div>
                    <h2 class="text-center" > Iniciar Sesión</h2>
                    <form id="form_login" class="form_login" action="{{ url('/login') }}" method="post" autocomplete="off">
                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                       <div class="form-group has-feedback">
                        <input type="text" class="form-control" style="text-align: center;" placeholder="Nombre de Usuario" id="username" name="username" />
                        <span class="glyphicon glyphicon-user form-control-feedback" style="color: white;"></span>
                    </div>
                    <div class="form-group">
                        <input type="password" id="password1" class="form-control" style="text-align: center;" placeholder="{{ trans('adminlte_lang::message.password') }}" name="password" id="password" />
                        <input type="checkbox" class="vercontra" id="ver" style="display: none">
                        <label for="ver" style="position: absolute;right:5px;bottom: 185px;z-index: 2; display: block;width: 34px;height: 34px;line-height: 34px;text-align: center; color: white;"><i style="margin-top:2px; font-size: 1.8rem; cursor: pointer; color: white;" class="fa fa-eye fa-fw "></i></label>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-4"></div>
                                <div class="col-4">
                                    <button type="submit" class="btn btn-danger btn-sm btn-block btn-flat">{{ trans('adminlte_lang::message.buttonsign') }}</button>
                                </div>
                                <div class="col-4"></div>
                            </div>
                        </div><!-- /.col -->
                    </div>
                </form>
            </div>
            <div class="col-md-8 banner-sec" style="padding-right: 0px;padding-right: 0px; color: white;">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                            <div class="img-login"></div>
                            <div class="carousel-caption d-none d-md-block">
                                <div class="banner-text" style="color: white;">
                                    <center>
                                        <h2 style="color: black;">Sala Situacional Elecciones Municipales 2025<br> 
                                            <div style="font-size: 1rem; color: black;">
                                              CORPO CAPITAL
                                            </div>
                                        </h2>
                                        <p style="color: white;">"No hay amor más grande que el que uno siente aquí en el pecho por una causa, por una patria, por una gente, por un pueblo, por la causa humana." <br> </p>
                                        <div class="float-right" style="color: white;">Comandante Hugo Chávez</div>
                                    </center>
                                </div>  
                            </div>
                        </div>
                    </div>     
                </div>
            </div>
        </div>
    </div>
</section>
@else
@include('auth.partials.activo')
@endif
@include('layouts.partials.scripts_auth')
</body>
@endsection