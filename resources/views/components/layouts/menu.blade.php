<aside id="sidebar" class="sidebar break-point-lg has-bg-image">
    <div class="image-wrapper">
        <!-- <img src="{{--asset('assets/images/sidebar_fondo.jpg')--}}" alt="sidebar background" /> -->
    </div>
    <div class="sidebar-layout">
        <div class="sidebar-header">
            <span class="texto-moderno">Cooperativa
                Minera Chiman R.L.</span>
        </div>
        <br>
        <div class="imagen-admin">
            @if(Auth::user()->foto==null)
            <img src="{{asset('assets/images/avatar-user.png')}}" alt="imagen del usuario">
            @else
            <img src="data:image/all;base64,{{base64_encode(Auth::user()->foto)}}" alt="imagen del usuario">
            @endif
            <p class="texto-moderno">{{Auth::user()->nombres}}</p>
        </div>
        <div class="sidebar-content">
            <nav class="menu open-current-submenu">
                <ul>
                    <li class="menu-item">
                        <a href="{{route('route-cooperativa')}}">
                            <span class="menu-icon">
                                <i class="zmdi zmdi-home"></i>
                            </span>
                            <span class="menu-title">Cooperativa</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('route-socios')}}">
                            <span class="menu-icon">
                                <i class="zmdi zmdi-account-o"></i>
                            </span>
                            <span class="menu-title">Socios</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('route-personal-planta')}}">
                            <span class="menu-icon">
                                <i class="zmdi zmdi-accounts-outline"></i>
                            </span>
                            <span class="menu-title">Personal</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('route-registro-correspondencias-re')}}">
                            <span class="menu-icon">
                                <i class="zmdi zmdi-file"></i>
                            </span>
                            <span class="menu-title">Registro de Correspondencias</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('route-registro-memorandums')}}">
                            <span class="menu-icon">
                                <i class="zmdi zmdi-file-text"></i>
                            </span>
                            <span class="menu-title">Registro de Memorandums</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{route('route-frm-new-faltas-socios-as-acontecimientos')}}">
                            <span class="menu-icon">
                                <i class="zmdi zmdi-format-color-text"></i>
                            </span>
                            <span class="menu-title">Faltas</span>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('route-registro-de-actas')}}">
                            <span class="menu-icon">
                                <i class="zmdi zmdi-folder-star-alt"></i>
                            </span>
                            <span class="menu-title">Registro de Actas</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{route('route-frm-new-documentacion-pdte-csjo-admin')}}">
                            <span class="menu-icon">
                                <i class="zmdi zmdi-book"></i>
                            </span>
                            <span class="menu-title">Inventario de Archivos</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{route('route-frm-new-registro-comisiones-informes')}}">
                            <span class="menu-icon">
                                <i class="zmdi zmdi-collection-item"></i>
                            </span>
                            <span class="menu-title">Reg. Comisiones - Informes</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{route('route-frm-new-equipo-pesado')}}">
                            <span class="menu-icon">
                                <i class="zmdi zmdi-balance-wallet"></i>
                            </span>
                            <span class="menu-title">Equipo Pesado</span>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{route('route-frm-new-ingreso-almacen')}}">
                            <span class="menu-icon">
                                <i class="zmdi zmdi-store"></i>
                            </span>
                            <span class="menu-title">Almacen</span>
                        </a>
                    </li>


                    <li class="menu-item">
                        <a href="{{route('route-usuarios')}}">
                            <span class="menu-icon">
                                <i class="zmdi zmdi-accounts-list"></i>
                            </span>
                            <span class="menu-title">Usuarios</span>
                        </a>
                    </li>
                    <li class="menu-item">


                        <a style="cursor:pointer" id="btn-sesion">
                            <span class="menu-icon">
                                <i class="zmdi zmdi-lock-outline"></i>
                            </span>
                            <span class="menu-title">Cerrar Sesion</span>
                        </a>

                    </li>

                </ul>
            </nav>
        </div>
        <div class="sidebar-footer"><span>Cooperativa Minera Chiman R.L.</span></div>
    </div>
</aside>