@extends('layouts.app')
@section('titulo', 'Kandor | Registro')
    @push('estilos')
        <link rel="stylesheet" href="{{ asset('css/modulos/login_registro.css') }}">
    @endpush


@section('contenido')
    <main>
        <!---------------------------
                SECCIÓN RGISTRO           
        ---------------------------->
        <!--Usé las mismas etiquetas y estilos del login y agrego inputs al form-->

        <section class="seccion-registro">

            <div class="container-login">


                <!--Lado izquierdo (Contenido del texto)-->
                <div class="cont-text">
                    <div class="text-superior">

                        <img src="assets/logos/Logo_estatico.svg" alt="logo">

                        <h2>Únete y comienza</h2>

                        <p>
                            Crea tu cuenta y empieza a organizar tus
                            tareas hoy mismo.
                        </p>

                    </div>


                    <!--Para el responsive-->
                    <div class="text-superior-responsive">

                        <img src="assets/logos/Logo_estatico.svg" alt="logo">

                        <h2>¡Crea tu cuenta!</h2>

                        <p>
                            Únete y comienza a organizar tus tareas
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
                <div class="cont-formulario registro">

                    <div class="text-form">

                        <h2>Crear cuenta</h2>
                        <p>Completa la información para registrarte.</p>

                    </div>

                    <form id="form_registro" action="{{ route('registro.enviar') }}" method="POST">
                        @csrf

                        <label for="nombre">Nombre completo</label>

                        <div class="cont-input">
                            <img src="assets/iconos/iconos login/icono_user.svg" alt="icono" style="width: 25px;">
                            <input type="text" name="name" id="nombre" placeholder="Tu nombre">
                        </div>

                        <label for="correo">Correo electrónico</label>

                        <div class="cont-input">
                            <img src="assets/iconos/iconos login/icono_correo.svg" alt="icono" style="width: 25px;">
                            <input type="email" name="email" id="correo" value="{{ old('email') }}" placeholder="ejemplo@gmail.com">
                        </div>

                        <label for="contrasena">Contraseña</label>

                        <div class="cont-input">
                            <img src="assets/iconos/iconos login/icono_user.svg" alt="icono" style="width: 25px;">
                            <input type="password" name="password" id="contrasena" placeholder="Ingresa una contraseña">

                            <!--Iconos de ocultar contraseña-->
                            <img src="assets/iconos/iconos login/icono_mostrar.svg" alt="icono" style="width: 25px;" class="icono-contr">
                            <img src="assets/iconos/iconos login/icono_ocultar.svg" alt="icono" style="width: 25px;" class="icono-contr oculto">
                        </div>

                        <label for="contrasena">Confirmar contraseña</label>

                        <div class="cont-input">
                            <img src="assets/iconos/iconos login/icono_user.svg" alt="icono" style="width: 25px;">
                            <input type="password" name="password_confirmation" id="contrasena_confirm" placeholder="Confirma tu contraseña">

                            <!--Iconos de ocultar contraseña-->
                            <img src="assets/iconos/iconos login/icono_mostrar.svg" alt="icono" style="width: 25px;" class="icono-contr">
                            <img src="assets/iconos/iconos login/icono_ocultar.svg" alt="icono" style="width: 25px;" class="icono-contr oculto">
                        </div>

                        <!-- <p id="mensaje" class="error"></p> -->

                        <button type="submit" class="btn-iniciar-s registro" id="btn-iniciar-s">Registrarse</button>
                    </form>

                    <div class="enlace-registro">
                        <p>¿Ya tienes cuenta? <a href="{{ route('login') }}" style="color: #1683F5;">Inicia sesión</a></p>
                    </div>

                    <p id="mensaje" class="error">
                        {{ $errors->first() }}
                    </p>

                </div>
            </div>

        </section>

    </main>
@endsection

@push('scripts')
    <script src="{{ asset('js/validar_registro.js') }}"></script>
    <script src="{{ asset('js/login.js') }}"></script>
@endpush
