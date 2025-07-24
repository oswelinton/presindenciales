@extends('layouts.partials.htmlheader')
<style>
body {
  width: 100%;
  height: 100% !important;
  background-image: url('../img/Login2.jpg');
  background-size: cover;
  background-repeat: no-repeat;
  align-content: center;
}
.homes{
  background: #fff;
  height: 100px;
  width: 100px;
  border-radius: 100%;
  border: 1px solid #757575;

  transition-property: all;
  transition-duration: 0.25s;
  transform-style: linear;
}
.homes:hover{
  border: 2px solid #000;
  transition-property: all;
  transition-duration: 0.7s;
  transform-style: linear;
}
.circle-boton{
  position: relative;
  left: 0;
  right: 0;
  margin: 5vh auto;
}
.btn-blue-trans{
  background: transparent;
  border: 1px solid #FF821B;
  color:#000;
  border-radius: 20px;
  padding: 15px;
}
.btn-blue-trans:hover{
  background: #FF821B;
  border-color: #FF821B;
  color:#fff;
  border-radius: 20px;
  padding: 15px;
}
.inicio {
  position: absolute;
  width: 42px;
  left: 0;
  right: 0;
  margin: 28px auto;
  color: black;
}
.sesion{
  background: #fff;
  padding: 5rem;
  border-radius: 10px;
  width: 100%;
  height: 100%;
}
.nameUser{
  margin:1rem;
}
</style>
<body >


 <div class="container">
  <div id="login-box">
    <div class="logo">
      <div class="input-group circle-boton">
       <a href="{{url('Inicio')}}" >
        <div class="homes" title="Ir a página de Inicio" style="    margin-left: 104px;">
          <i class=" fa fa-home  fa-3x inicio"></i>
        </div>
      </a>

      <p class="text-center nameUser" style="color: #000">Usuario: {{ucwords(Auth::user()->name)}}</p>
    </div>

  </div><!-- /.logo -->
  <div class="">
    <div class="row">
      <div class="col-xs-12">
        <center>
          <div class="text-center">
            <a href="{{ url('/logout') }}" class="btn btn-info" ><i class="fa fa-sign-out"></i> Cerrar Sesión </a>
          </div>
        </center>
      </div><!-- /.col -->
    </div>
  </div>
</div>
</div>

<!-- Automatic element centering -->
</body>