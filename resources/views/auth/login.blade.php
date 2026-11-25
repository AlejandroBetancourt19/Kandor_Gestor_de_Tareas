@extends('layouts.app')

@section('titulo', 'Kandor | Login')

@push('estilos')
    <link rel="stylesheet" href="{{ asset('css/modulos/login_registro.css') }}">
@endpush

@section('contenido')
    <main>

        <!---------------------------
                SECCIÓN LOGIN           
        ---------------------------->
        <section class="seccion-login">

            <div class="container-login">


                <!--Lado izquierdo (Contenido del texto)-->
                <div class="cont-text">
                    <div class="text-superior">

                        <img src="assets/logos/Logo_estatico.svg" alt="logo">

                        <h2>Organiza. Planifica. Avanza.</h2> 

                        <p>
                            Tu espacio de trabajo para gestionar
                            tareas de forma simple, rápida y eficiente.
                        </p>

                    </div>

                    <!--Para el responsive-->
                    <div class="text-superior-responsive">

                        <img src="assets/logos/Logo_estatico.svg" alt="logo">

                        <h2>¡Hola de nuevo!</h2>

                        <p>
                            inicia sesión para continuar
                        </p>

                    </div>

                    <div class="elements-inferiores">

                        <div class="iconos">
                            <img src="assets/iconos/iconos login/icono_organiz_v2.svg" alt="icono" class="icon1">
                            <p>Organiza tus tareas</p>
                        </div>

                        <div class="iconos">
                            <img src="assets/iconos/iconos login/icono_grupo_v2.svg" alt="icono" class="icon2">
                            <p>Trabaja en equipo</p>
                        </div>

                        <div class="iconos">
                            <img src="assets/iconos/iconos login/icono_grafica_v2.svg" alt="icono" class="icon3">
                            <p>Aunmenta tu productividad</p>
                        </div>

                    </div>
                </div>


                <!--Lado derecho (Contenido del formulario)-->
                <div class="cont-formulario">

                    <div class="text-form">

                        <h2>Iniciar sesión</h2>
                        <p>Bienvenido de nuevo, ingresa a tu cuenta.</p>

                    </div>

                    @if (session('ok'))
                        <p class="aviso-ok" style="
                            font-size: 16px; 
                            color: #20C997; 
                            font-weight: 600; 
                            text-align: center; 
                            display: flex; 
                            justify-content: 
                            center; 
                            margin-top: 15px;">
                            {{ session('ok') }}
                        </p>
                    @endif

                    <form action="{{ route('login.enviar') }}" method="POST" id="form-login"> <!-- se envian los datos a esa ruta--->
                        @csrf <!-- la llave de seguridad--->

                        <label for="correo">Correo electrónico</label>

                        <div class="cont-input">
                            <img src="assets/iconos/iconos login/icono_correo.svg" alt="icono" style="width: 25px;">
                            <input type="email" name="email" id="correo" value="{{ old('email') }}" placeholder="ejemplo@gmail.com">
                        </div>

                        <label for="contrasena">Contraseña</label>

                        <div class="cont-input">
                            <img src="assets/iconos/iconos login/icono_contraseña.svg" alt="icono" style="width: 25px;">
                            <input type="password" name="password" id="contrasena" placeholder="Ingresa tu contraseña">

                            <!--Iconos de ocultar contraseña-->
                            <img src="assets/iconos/iconos login/icono_mostrar.svg" alt="icono" style="width: 25px;" class="icono-contr">
                            <img src="assets/iconos/iconos login/icono_ocultar.svg" alt="icono" style="width: 25px;" class="icono-contr oculto">
                        </div>

                        <div class="recordarme-recupContr">

                            <div class="recordarme">
                                <input type="checkbox" name="recordarme" id="recordarme">
                                <label for="recordarme">Recordarme</label>
                            </div>

                            <button type="button" id="btn-recup-contraseña" class="btn-recup-contr">¿Olvidaste tu contraseña?</button>

                        </div>

                        <button type="submit" class="btn-iniciar-s" id="btn-iniciar-s">Iniciar sesión</button>
                    </form>

                    <div class="enlace-registro">
                        <p>¿No tienes cuenta? <a href="{{ route('registro') }}" style="color: #1683F5;">Regístrate aquí</a></p>
                    </div>

                    <p id="mensaje" class="error">
                        @error('email')
                            {{ $message }}
                        @enderror

                        @error('password')
                            {{ $message }}
                        @enderror
                    </p>

                </div>
            </div>

        </section>

    </main>
@endsection

@push('scripts')
    <script src="{{ asset('js/login.js') }}"></script>
    <script src="{{ asset('js/validar_login.js') }}"></script>
@endpush