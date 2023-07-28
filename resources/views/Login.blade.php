<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{asset('assets/iconos/css/material-design-iconic-font.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/css/normalize.css')}}" type="text/css" media="all">
    <link rel="stylesheet" href="{{asset('assets/css/home.css')}}" type="text/css" media="all">

    <title>Cooperativa Chima</title>
</head>

<body>
    <main class="container-login">
        <div class="image-logueo">
            <img class="logueo__img" src="{{asset('assets/images/img-login.jpg')}}" alt="imagen de logueo">
        </div>
        <form class="mi-form-control" action="{{route('route-logueo')}}" method="post">
            @csrf
            <h1 class="title-form">Iniciar Sesión</h1>
            <div class="image-logueo-logo">
                <img class="logueo-logo__img" src="{{asset('assets/images/logo-minero-1.png')}}"
                    alt="logo de la empresa">
            </div>
            <div class="campo-form-control">
                <label for="">Usuario</label>
                <input type="text" name="usuario" maxlength="150" value="{{old('usuario')}}">
            </div>
            <div class="campo-form-control">
                <label for="">Contraseña</label>
                <input type="password" name="password" maxlength="400" autocomplete="off">
            </div>

            <div class="btn-form">
                <button type="submit">INGRESAR <i class="zmdi zmdi-mail-send"></i></button>
                @error('credenciales-incorrectos')
                <p>{{$message}}</p>
                @enderror

            </div>

        </form>

    </main>

</body>

</html>