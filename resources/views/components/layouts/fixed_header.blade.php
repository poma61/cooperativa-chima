<header class="header">
    <a id="btn-collapse" href="#">
        <i class="zmdi zmdi-menu" id="color-100-btn-menu"></i>
    </a>
    <a id="btn-toggle" href="#" class="sidebar-toggler break-point-lg">
        <i class="zmdi zmdi-menu" id="color-100-btn-menu"></i>
    </a>

    <div class="opciones-header">
        <a href="{{route('route-frm-show-password-usuarios')}}" class="opciones__a"> <i class="zmdi zmdi-settings"></i></a>
        <p class="opciones__p">Bienvenido {{Auth::user()->nombres}}</p>
        <img class="logo__img" src="{{asset('assets/images/logo-minero-1.png')}}"  alt="logo de la empresa">
    </div>

</header>