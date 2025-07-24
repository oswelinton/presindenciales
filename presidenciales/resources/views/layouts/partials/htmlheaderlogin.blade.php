<head>
    <meta charset="UTF-8">
    <title> Sala Situacional </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="{{ asset('/css/b_4/bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="{{ asset('/fonts/ionicons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="{{ asset('/fonts/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />

    <link rel="icon" type="image/x-icon" href="{{url('img/logos/fav.ico')}}">

    <!-- icono arriba -->

    <link rel="stylesheet" type="text/css" href="{{asset('/css/toastr.css')}}">
    <link href="{{ asset('/css/slick/slick.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/slick/slick-theme.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('/js/b_4/bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/b_4/jquery-1.11.1.js') }}" type="text/javascript"></script>
    <style type="text/css">

    .login-block{
        background: #DE6262;  /* fallback for old browsers */
        background: -webkit-linear-gradient(to bottom, #000000, #f8f9fa);  /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to bottom, #000000, #f8f9fa); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        float:left;
        width:100vw;
        padding : 50px 0;
        height: 100vh;
    }
    /*.banner-sec{background:url(https://static.pexels.com/photos/33972/pexels-photo.jpg)  no-repeat left bottom; background-size:cover; min-height:500px; border-radius: 0 10px 10px 0; padding:0;}*/
    .container{background:#fff; border-radius: 10px; box-shadow:15px 20px 0px rgba(0,0,0,0.1);}
    .carousel-inner{border-radius:0 10px 10px 0;}
    .carousel-caption{text-align:left; left:5%;}
    .login-sec{padding: 125px 30px; position:relative;}
    .login-sec .copy-text{position:absolute; width:80%; bottom:20px; font-size:13px; text-align:center;}
    .login-sec .copy-text i{color:#FEB58A;}
    .login-sec .copy-text a{color:#E36262;}
    .login-sec h2{margin-bottom:30px; font-weight:800; font-size:30px; color: #e2191a ;}
    .login-sec h2:after{content:" "; width:200px; height:5px; background:#e2191a; display:block; margin-top:20px; border-radius:3px; margin-left:auto;margin-right:auto}
    .btn-login{background: #e2191a !important; color:#000; font-weight:600;}
    .banner-text{width:645px; position:absolute; bottom:150px; padding-left:20px;}
    .banner-text h2{color:#000; font-weight:600;}
    .banner-text h2:after{content:" "; width:543px; height:5px; background:#FFF; display:block; margin-top:20px; border-radius:3px;}
    .banner-text p{color:#000;}
.img-login{
    background-image: url({{ asset('/img/Login2.jpg') }});
    background-size: cover;
    width: 100%;height: 500px;
}
    /* capa de efecto para LOGIN*/
    .capa{
        background: rgba(0, 0, 0, 0.9);
        position: fixed;
        z-index: 4;
        width: 100%;
        height: 100%;
        top: 0;

    }
    .loadcss{
        position:absolute;
        z-index: 2;
        text-align: center;
        color: white;
    }
    .contentLoad{
        background: #fff;
        position: absolute;
        z-index: 40;
        margin: 20rem auto;
        left: 0;
        right: 0;
    }
    /* capa de efecto LOGIN */
</style>
</head>
