@extends('layouts.app')

@section('titulo', 'Kandor | Panel')

@push ('estilos')
    <link rel="stylesheet" href="{{ asset('css/resset_panel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reset_secciones.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reset_general.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modulos/panel.css') }}">
@endpush

@section('contenido')
    <!--=========================================
                HEADER
    ==========================================-->
    <header>
        <div class="cont-header">

            <div style="display: flex; align-items: center; gap: 12px;">
                <!-- Botón hamburguesa y cerrar menu móvil -->
                <button class="btn-menu-movil" id="btn-toggle-sidebar" aria-label="Menú">
                    <svg id="icono-menu" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
                
                <img src="{{ asset('assets/logos/Logo_estatico.svg') }}" alt="Logo" width="180px">
            </div>

            <div class="cont-header-derecho">
                <div class="buscador">
                    <form action="" method="">
                        <img src="{{ asset('assets/iconos/iconos_dashboard/icnono_buscar.svg') }}" alt="icono" style="width: 25px;">
                        <input type="search" id="buscar" name="buscar" placeholder="Buscar tareas...">
                    </form>
                </div>

                <div class="modo-oscuro-claro">
                    <img src="{{ asset('assets/iconos/iconos_dashboard/icono_sol.svg') }}" alt="icono" style="width: 35px; cursor: pointer;">
                    <img src="{{ asset('assets/iconos/iconos_dashboard/icono_luna.svg') }}" alt="icono" style="width: 35px; cursor: pointer;">
                </div>

                <div class="cuenta">
                    <img src="{{ asset('assets/iconos/iconos_dashboard/icono_user.svg') }}" alt="icono" style="width: 35px; cursor: pointer;" data-target="configuracion" class="btn-modulo">
                </div>
            </div>

        </div>
    </header>


    <!--=========================================
                CONTENEDOR GENERAL
    ==========================================-->
    <div class="contenedor-general">

        <!--Sidebar-->
        <section class="sidebar">
            <div class="contenido-superior">

                <div class="cuenta cuenta-sidebar">

                    <div class="foto-cuenta">
                        <img src="{{ asset('assets/iconos/iconos_dashboard/foto_usuario.svg') }}" alt="foto" id="foto-cuenta" style="width: 60px;" data-target="configuracion" class="btn-modulo">
                    </div>

                    <p class="nombre-usuario" id="nombre-usuario">
                        {{ auth()->user()->name }}
                    </p>

                </div>

                <div class="modulos">
                    <ul>
                        <li class="btn-modulo btn-activo" data-target="inicio">
                            <img src="{{ asset('assets/iconos/iconos_dashboard/icono_inicio.svg') }}" alt="icono" style="width: 35px;">
                            <p>Inicio</p>
                        </li>

                        <li class="btn-modulo" data-target="tareas">
                            <img src="{{ asset('assets/iconos/iconos_dashboard/icono_tareas.svg') }}" alt="icono" style="width: 35px;">
                            <p>Mis tareas</p>
                        </li>

                        <li class="btn-modulo" data-target="categorias">
                            <img src="{{ asset('assets/iconos/iconos_dashboard/icono_categorias.svg') }}" alt="icono" style="width: 35px;">
                            <p>Categorías</p>
                        </li>

                        <li class="btn-modulo" data-target="configuracion">
                            <img src="{{ asset('assets/iconos/iconos_dashboard/icono_configuracion.svg') }}" alt="icono" style="width: 35px;">
                            <p>Configuración</p>
                        </li>
                    </ul>
                </div>

            </div>

            <div class="contenido-inferior">
                <p>
                    <img src="{{ asset('assets/iconos/iconos_dashboard/icono_cerrar_sesion.svg') }}" alt="icono" style="width: 35px;">
                </p>

                <form action="{{ route('logout') }}" method="POST">
                        <button type="submit" class="btn-cerrar-sesion">Cerrar sesión</button>
                </form>
            </div>
        </section>


        <main>

            <!--SECCION INICIO-->
            <section class="seccion activa" id="inicio">

                <header class="header-panel">

                    <div class="text-saludo">
                        <h2 id="saludo">¡Hola, {{ auth()->user()->name }}</h2>
                        <p>Organiza tus tareas y haz que las cosas pasen.</p>
                    </div>

                    <div class="btn-nueva-tarea">
                        <button data-modal="modal-agg-tarea" class="nueva-tarea-btn"><img src="{{ asset('assets/iconos/iconos_dashboard/icono_agregar_blanco.svg') }}" alt="icono" style="width: 20px;"> Nueva tarea</button>
                    </div>
                </header>


                <!--contenedor de las cards del inicio-->
                <div class="cont-cards-inicio">

                    <!--card pendiente-->
                    <div class="card pendiente" data-estado="pendiente">

                        <header class="header-card pendiente">
                            <div class="estado">
                                <p>Pendiente</p>
                            </div>

                            <div class="cantidad pendiente">
                                <p>0</p>
                            </div>
                        </header>


                        <!--Contenedor de las tareas-->
                        <div class="cont-tarea" id="pendiente">

                            <div class="tarea" draggable="true" id="tarea1">
                                <div class="info-tarea">
                                    <p class="titulo-tarea"></p>

                                    <p class="categoria-tarea"></p>

                                    <p class="fecha-tarea pendiente"><img src="{{ asset('assets/iconos/iconos_dashboard/icono_fecha_pendiente.svg') }}" alt="icono" style="width: 25px;"></p>
                                </div>

                                <div>
                                    <img src="{{ asset('assets/iconos/iconos_dashboard/icono_editar.svg') }}" alt="icono" style="width: 35px; transform: rotate(90deg); cursor: pointer;" id="btn-editar">
                                </div>
                            </div>

                        </div>

                        <button data-modal="modal-agg-tarea" class="nueva-tarea-btn inferior pendiente">
                            <img src="{{ asset('assets/iconos/iconos_dashboard/icono_agg_pendiente.svg') }}" alt="icono" style="width: 20px;">
                            Agregar tarea
                        </button>

                    </div>


                    <!--card en proceso-->
                    <div class="card proceso" id="en-proceso" data-estado="en_proceso">

                        <header class="header-card proceso">
                            <div class="estado">
                                <p>En proceso</p>
                            </div>

                            <div class="cantidad proceso">
                                <p>0</p>
                            </div>
                        </header>


                        <!--Contenedor de las tareas-->
                        <div class="cont-tarea">

                        </div>

                        <button data-modal="modal-agg-tarea" class="nueva-tarea-btn inferior proceso">
                            <img src="{{ asset('assets/iconos/iconos_dashboard/icono_agg_proceso.svg') }}" alt="icono" style="width: 20px;">
                            Agregar tarea
                        </button>

                    </div>


                    <!--card completada-->
                    <div class="card completada" id="completada" data-estado="completado">

                        <header class="header-card completada">
                            <div class="estado">
                                <p>Completado</p>
                            </div>

                            <div class="cantidad completada">
                                <p>0</p>
                            </div>
                        </header>


                        <!--Contenedor de las tareas-->
                        <div class="cont-tarea">

                        </div>

                        <button data-modal="modal-agg-tarea" class="nueva-tarea-btn inferior completada">
                            <img src="{{ asset('assets/iconos/iconos_dashboard/icono_agg_complet.svg') }}" alt="icono" style="width: 20px;">
                            Agregar tarea
                        </button>

                    </div>

                </div>

            </section>


            <!--=======================================
                       SECCIÓN MIS TAREAS
            ========================================-->
            <section class="seccion" id="tareas">

                <header class="header-panel">

                    <div class="text-saludo">
                        <h2 id="saludo">Mis tareas</h2>
                        <p>{{ auth()->user()->name }}, Organiza tus tareas y alcanza tus objetivos.</p>
                    </div>

                    <div class="btn-nueva-tarea">
                        <button id="nueva-tarea" class="nueva-tarea-btn" data-modal="modal-agg-tarea"><img src="{{ asset('assets/iconos/iconos_dashboard/icono_agregar_blanco.svg') }}" alt="icono" style="width: 20px;"> Nueva tarea </button>
                    </div>
                </header>

                <div class="cont-mis-tareas">

                    <div class="filtros-tareas">
                        <button id="filtro-todas" class="btn-filtro activo">Todas</button>
                        <button id="filtro-pendientes" class="btn-filtro">Pendientes</button>
                        <button id="filtro-en-proceso" class="btn-filtro">En proceso</button>
                        <button id="filtro-completadas" class="btn-filtro">Completadas</button>
                    </div>

                    <div class="cont-tabla-tareas">
                        <table>
                            <thead>
                                <tr>
                                    <th>Titulo</th>
                                    <th>Categoría</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>-</td>
                                    <td>
                                        <p class="tabla-categoria color" id="categoria">-</p>
                                    </td>
                                    <td>
                                        <p class="estado color" id="estado">-</p>
                                    </td>
                                    <td>-</td>
                                    <td>
                                        <img src="{{ asset('assets/iconos/iconos_dashboard/icono_editar.svg') }}" alt="icono" style="width: 35px; transform: rotate(90deg); cursor: pointer;" id="btn-editar">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

            </section>


            <!--=======================================
                       SECCIÓN MIS CATEGORÍAS
            ========================================-->
            <section class="seccion" id="categorias">

                <header class="header-panel">

                    <div class="text-saludo">
                        <h2 id="saludo">Categorías</h2>
                        <p>Gestiona las categorías de tus tareas.</p>
                    </div>

                    <div class="btn-nueva-tarea">
                        <button data-modal="modal-agg-categoria" class="nueva-tarea-btn"><img src="{{ asset('assets/iconos/iconos_dashboard/icono_agregar_blanco.svg') }}" alt="icono" style="width: 20px;"> Nueva categoría</button>
                    </div>
                </header>

                <div class="cont-categorias">
                    <div class="cont-tabla-categorias">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Color</th>
                                    <th>Tareas</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>-</td>
                                    <td>
                                        <div class="color-categ" id="color-categ"></div>
                                    </td>
                                    <td>
                                        <p class="cant-tareas" id="cant-tareas">-</p>
                                    </td>
                                    <td>
                                        <img src="{{ asset('assets/iconos/iconos_dashboard/icono_editar.svg') }}" alt="icono" style="width: 35px; transform: rotate(90deg); cursor: pointer;" class="btn-editar-categoria" id="btn-editar-categoria">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </section>


            <!--=======================================
                       SECCIÓN CONFIGURACIÓN
            ========================================-->
            <section class="seccion" id="configuracion">
                <header class="header-panel"></header>
                <h1>En desarrollo</h1>
            </section>

        </main>

    </div>


    <!--============================================
                    MODAL AGG TAREA
    =============================================-->
    <div class="cont-modal" id="modal-agg-tarea">
        <div class="modal-agg-tarea">

            <div class="cont-form-tarea">
                <div class="titulo-modal">
                    <h2>Nueva tarea</h2>
                </div>

                <div class="cont-form-modal">
                    <form action="controllers/guardar_tarea.php" method="POST" id="form-nueva-tarea">

                        <label for="titulo">Título</label>
                        <input type="text" id="titulo" name="titulo" placeholder="Ej: Diseñar interfaz">

                        <label for="descripcion">Descripción</label>
                        <textarea name="descripcion" id="descripcion" placeholder="Agrega una descripción (opcional)..."></textarea>

                        <div class="categoria-estado-fecha">

                            <div class="select-categoria">
                                <label for="select-categoria">Categoría</label>
                                <select name="categoria_id" id="select-categoria" required>
                                    <option value="">Selecciona una categoría</option>
                                </select>
                            </div>

                            <div class="select-estado">
                                <label for="estado">Estado</label>
                                <select name="id-estado" id="estado">
                                    <option value="">Selecciona un estado</option>
                                </select>
                            </div>

                            <div class="fecha-limite">
                                <label for="fecha-limite">Fecha límite</label>
                                <input type="date" id="fecha-limite" name="fecha_limite">
                            </div>

                        </div>

                    </form>

                    <div class="cancelar-crear">
                        <button type="button" id="cancelarBtn" class="btn-cancelar">Cancelar</button>
                        <button type="submit" class="btn-crear" form="form-nueva-tarea">Crear tarea</button>
                    </div>

                </div>

            </div>

        </div>
    </div>


    <!--============================================
                    MODAL AGG CATEGORÍA
    =============================================-->
    <div class="cont-modal" id="modal-agg-categoria">

        <div class="modal-agg-categoria">
            <div class="cont-form-categoria">

                <div>
                    <h2>Nueva categoría</h2>
                </div>

                <form action="controllers/guardar_categoria.php" method="POST" id="form-categoria">

                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Ej: Diseño" required>

                    <div class="form-group">
                        <label>Color</label>
                        <div class="color-picker-grid">
                            <label class="color-option" style="background-color: #6366f1;"><input type="radio" name="color" value="#6366f1" checked></label>
                            <label class="color-option" style="background-color: #3b82f6;"><input type="radio" name="color" value="#3b82f6"></label>
                            <label class="color-option" style="background-color: #0ea5e9;"><input type="radio" name="color" value="#0ea5e9"></label>
                            <label class="color-option" style="background-color: #10b981;"><input type="radio" name="color" value="#10b981"></label>
                            <label class="color-option" style="background-color: #84cc16;"><input type="radio" name="color" value="#84cc16"></label>
                            <label class="color-option" style="background-color: #eab308;"><input type="radio" name="color" value="#eab308"></label>
                            <label class="color-option" style="background-color: #f59e0b;"><input type="radio" name="color" value="#f59e0b"></label>
                            <label class="color-option" style="background-color: #f97316;"><input type="radio" name="color" value="#f97316"></label>
                            <label class="color-option" style="background-color: #ef4444;"><input type="radio" name="color" value="#ef4444"></label>
                            <label class="color-option" style="background-color: #ec4899;"><input type="radio" name="color" value="#ec4899"></label>
                            <label class="color-option" style="background-color: #a855f7;"><input type="radio" name="color" value="#a855f7"></label>
                            <label class="color-option" style="background-color: #64748b;"><input type="radio" name="color" value="#64748b"></label>
                        </div>
                    </div>
                </form>

                <div class="cancelar-crear">
                    <button type="button" class="btn-cancelar">Cancelar</button>
                    <button type="submit" class="btn-crear" form="form-categoria" id="btn-crear-categoria">Crear categoría</button>
                </div>

            </div>
        </div>
    </div>


    <!-- MODAL EDITAR TAREA -->
    <div class="cont-modal" id="modal-editar-tarea">
        <div class="modal-editar-tarea">
            <div class="cont-form-tarea">
                <div class="titulo-modal">
                    <h2>Editar tarea</h2>
                </div>

                <div class="cont-form-modal">
                    <form action="controllers/editar_tarea.php" method="POST" id="form-editar-tarea">
                        <input type="hidden" name="id_tarea" id="id_tarea_editar">

                        <label for="titulo-editar">Título</label>
                        <input type="text" id="titulo-editar" name="titulo" placeholder="Ej: Diseñar interfaz" required>

                        <label for="descripcion-editar">Descripción</label>
                        <textarea name="descripcion" id="descripcion-editar" placeholder="Agrega una descripción (opcional)..."></textarea>

                        <div class="categoria-estado-fecha">
                            <div class="select-categoria">
                                <label for="select-categoria-editar">Categoría</label>
                                <select name="id_categoria" id="select-categoria-editar" required>
                                    <option value="">Selecciona una categoría</option>
                                </select>
                            </div>

                            <div class="select-estado">
                                <label for="estado-editar">Estado</label>
                                <select name="estado" id="estado-editar">
                                    <option value="pendiente">Pendiente</option>
                                    <option value="en_proceso">En proceso</option>
                                    <option value="completado">Completado</option>
                                </select>
                            </div>

                            <div class="fecha-limite">
                                <label for="fecha-limite-editar">Fecha límite</label>
                                <input type="date" id="fecha-limite-editar" name="fecha_limite">
                            </div>
                        </div>
                    </form>

                    <div class="botones-modal">
                        <div class="btn-eliminar">
                            <button type="button" class="btn-eliminar-tarea">Eliminar</button>
                        </div>

                        <div class="cancelar-crear">
                            <button type="button" class="btn-cancelar">Cancelar</button>
                            <button type="submit" class="btn-crear" form="form-editar-tarea">Guardar cambios</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <!--============================================
                    MODAL EDITAR CATEGORÍA
    =============================================-->
    <div class="cont-modal" id="modal-editar-categoria">
        <div class="modal-editar-categoria">
            <div class="cont-form-categoria">

                <div>
                    <h2>Editar categoría</h2>
                </div>

                <form action="controllers/guardar_categoria.php" method="POST" id="form-categoria-editar">
                    <input type="hidden" name="id_categoria" id="id_categoria_editar">

                    <label for="nombre-editar">Nombre</label>
                    <input type="text" id="nombre-editar" name="nombre" placeholder="Ej: Diseño" required>

                    <div class="form-group">
                        <label>Color</label>
                        <div class="color-picker-grid">
                            <label class="color-option" style="background-color: #6366f1;"><input type="radio" name="color" value="#6366f1" checked></label>
                            <label class="color-option" style="background-color: #3b82f6;"><input type="radio" name="color" value="#3b82f6"></label>
                            <label class="color-option" style="background-color: #0ea5e9;"><input type="radio" name="color" value="#0ea5e9"></label>
                            <label class="color-option" style="background-color: #10b981;"><input type="radio" name="color" value="#10b981"></label>
                            <label class="color-option" style="background-color: #84cc16;"><input type="radio" name="color" value="#84cc16"></label>
                            <label class="color-option" style="background-color: #eab308;"><input type="radio" name="color" value="#eab308"></label>
                            <label class="color-option" style="background-color: #f59e0b;"><input type="radio" name="color" value="#f59e0b"></label>
                            <label class="color-option" style="background-color: #f97316;"><input type="radio" name="color" value="#f97316"></label>
                            <label class="color-option" style="background-color: #ef4444;"><input type="radio" name="color" value="#ef4444"></label>
                            <label class="color-option" style="background-color: #ec4899;"><input type="radio" name="color" value="#ec4899"></label>
                            <label class="color-option" style="background-color: #a855f7;"><input type="radio" name="color" value="#a855f7"></label>
                            <label class="color-option" style="background-color: #64748b;"><input type="radio" name="color" value="#64748b"></label>
                        </div>
                    </div>
                </form>

                <div class="botones-modal">
                    <div class="btn-eliminar">
                        <button type="button" class="btn-eliminar-categoria">Eliminar</button>
                    </div>

                    <div class="cancelar-crear">
                        <button type="button" class="btn-cancelar">Cancelar</button>
                        <button type="submit" class="btn-crear" form="form-categoria-editar">Guardar</button>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- Notificación flotante Toast Dinámica -->
    <div id="toastAlerta" class="toast-notification">
        <span id="toastIcon" class="toast-icon">✅</span>
        <div class="toast-content">
            <strong id="toastTitle">¡Éxito!</strong>
            <p id="toastMessage">La categoría se ha creado correctamente.</p>
        </div>
    </div>

    <!-- SCRIPT MPVIL INTERACTIVO HAMBURGUESA CERRAR -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const btnToggle = document.getElementById("btn-toggle-sidebar");
            const sidebar = document.querySelector(".sidebar");
            const iconoMenu = document.getElementById("icono-menu");

            if (btnToggle && sidebar && iconoMenu) {
                btnToggle.addEventListener("click", function () {
                    sidebar.classList.toggle("activo");
                    
                    // Cambia el icono dinámicamente entre hamburguesa y X (cerrar)
                    if (sidebar.classList.contains("activo")) {
                        iconoMenu.innerHTML = `
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        `;
                    } else {
                        iconoMenu.innerHTML = `
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        `;
                    }
                });

                // Cierra autmaticamente el sidebar y restablece el icono al hacer clic en cualquier opcin de modulo o cerrar sesión
                const elementosMenu = sidebar.querySelectorAll(".btn-modulo, .contenido-inferior a");
                elementosMenu.forEach(item => {
                    item.addEventListener("click", function () {
                        if (window.innerWidth <= 768) {
                            sidebar.classList.remove("activo");
                            iconoMenu.innerHTML = `
                                <line x1="3" y1="12" x2="21" y2="12"></line>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <line x1="3" y1="18" x2="21" y2="18"></line>
                            `;
                        }
                    });
                });
            }
        });
    </script>
@endsection

@push('scripts')
    <script src="{{ asset('js/api.js') }}"></script>
    <script src="{{ asset('js/spa.js') }}"></script>
    <script src="{{ asset('js/acciones_btn.js') }}"></script>
    <script src="{{ asset('js/drag_and_drog.js') }}"></script>
    <script src="{{ asset('js/alertas.js') }}"></script>
    <script src="{{ asset('js/categorias.js') }}"></script>
    <script src="{{ asset('js/tareas.js') }}"></script>
    <script src="{{ asset('js/modo_claro_oscuro.js') }}"></script>
@endpush