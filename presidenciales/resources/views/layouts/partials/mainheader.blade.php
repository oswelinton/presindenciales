<!-- Main Header -->
<header class="main-header">

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation" style="
    background-image: url({{ url('img/Login1.jpg') }});
    background-size: 102%;
    background-position: 0px 0px;
">        <!-- Sidebar toggle button-->
        <a href="#" data-toggle="offcanvas" role="button">
            <div class="sidebar-toggle" style="margin-top: 20px"></div>
            {{-- <span class="sr-only">{{ trans('adminlte_lang::message.togglenav') }}</span> --}}
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu" style="background: #fff">
            <ul class="nav navbar-nav">
                @if (Auth::check())
                    <li class="dropdown">
                        <a href="#"><img src="{{url('img/logos/tsj_black.jpg')}}" style="width: 175px"></a>
                    </li>
                @endif

            </ul>
        </div>
    </nav>
</header>