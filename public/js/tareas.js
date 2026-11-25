// Variable global para guardar la lista de tareas actual
let listaTareasGlobal = [];

document.addEventListener("DOMContentLoaded", () => {
    const formNuevaTarea = document.getElementById("form-nueva-tarea");
    const modalAggTarea = document.getElementById("modal-agg-tarea");
    const formEditarTarea = document.getElementById("form-editar-tarea");
    const modalEditarTarea = document.getElementById("modal-editar-tarea");

    // Cargar selectores y datos iniciales al abrir la vista
    cargarSelectCategorias();
    cargarYRenderizarTareas();

    // 1. Guardar nueva tarea
    if (formNuevaTarea) {
        formNuevaTarea.addEventListener("submit", async (e) => {
            e.preventDefault();

            const formData = new FormData(formNuevaTarea);

            try {
                const respuesta = await fetch("controllers/guardar_tarea.php", {
                    method: "POST",
                    body: formData
                });

                const resultado = await respuesta.json();

                if (resultado.status === "success") {
                    if (modalAggTarea) {
                        modalAggTarea.style.display = "none";
                    }
                    formNuevaTarea.reset();
                    mostrarToast("¡Éxito!", resultado.message, "success");
                    await cargarYRenderizarTareas();
                } else {
                    mostrarToast("¡Error!", resultado.message, "error");
                }
            } catch (error) {
                console.error("Error al guardar tarea:", error);
                mostrarToast("¡Error!", "No se pudo conectar con el servidor.", "error");
            }
        });
    }

    // 2. Guardar cambios de editar tarea
    if (formEditarTarea) {
        formEditarTarea.addEventListener("submit", async (e) => {
            e.preventDefault();

            const formData = new FormData(formEditarTarea);

            try {
                const respuesta = await fetch("controllers/editar_tarea.php", {
                    method: "POST",
                    body: formData
                });

                const resultado = await respuesta.json();

                if (resultado.status === "success") {
                    if (modalEditarTarea) {
                        modalEditarTarea.style.display = "none";
                    }
                    mostrarToast("¡Éxito!", resultado.message, "success");
                    await cargarYRenderizarTareas();
                } else {
                    mostrarToast("¡Error!", resultado.message, "error");
                }
            } catch (error) {
                console.error("Error al actualizar tarea:", error);
                mostrarToast("¡Error!", "No se pudo conectar con el servidor.", "error");
            }
        });
    }

    // Eliminar tarea (botón "Eliminar" del modal de editar)
    const btnEliminarTarea = document.querySelector(".btn-eliminar-tarea");
    let confirmandoEliminar = false;
    let temporizadorEliminar = null;

    function restablecerBotonEliminar() {
        confirmandoEliminar = false;
        if (btnEliminarTarea) btnEliminarTarea.textContent = "Eliminar";
    }

    if (btnEliminarTarea) {
        btnEliminarTarea.addEventListener("click", async () => {
            const idTarea = document.getElementById("id_tarea_editar").value;
            if(!idTarea) return;

            //primer clik pedimos confirmacion
            if (!confirmandoEliminar) {
                confirmandoEliminar = true;
                btnEliminarTarea.textContent ="¿Seguro? Clic otra vez";
                temporizadorEliminar = setTimeout(restablecerBotonEliminar, 3000);
                return;
            }

            //segundo clic ahora si eliminamos
            clearTimeout(temporizadorEliminar);
            restablecerBotonEliminar();


            const formData = new FormData();
            formData.append("id_tarea", idTarea);

            try {
                const respuesta = await fetch("/kandor_Gestor_de_Tareas/controllers/eliminar_tarea.php", {
                    method: "POST",
                    body: formData
                });

                const resultado = await respuesta.json();

                if (resultado.status === "success") {
                    modalEditarTarea.style.display = "none";
                    mostrarToast("¡Listo!", resultado.message, "success");
                    await cargarYRenderizarTareas();


                    //refrescar los contadores de la tabla de categorias
                    if (typeof cargarCategorias === "function") {
                        await cargarCategorias();
                    }

                } else {
                    mostrarToast ("¡Error!", resultado.message, "error");
                }

            } catch (error) {
                    console.error("Error al eliminar tarea:", error);
                    mostrarToast("¡Error!", "No se pudo conectar con el servidor.", "error");
                }
        });
    }
    

});

// Función para poblar los <select> de categorías (tanto en Crear como en Editar)
async function cargarSelectCategorias() {
    try {
        const respuesta = await fetch("controllers/obtener_categorias.php");
        const resultado = await respuesta.json();

        if (resultado.status === "success" && resultado.data) {
            const opcionesHtml = `<option value="">Selecciona una categoría</option>` + 
                resultado.data.map(cat => `<option value="${cat.id_categoria}">${cat.nombre}</option>`).join("");

            // Poblar select de crear tarea
            const selectCategoria = document.getElementById("select-categoria");
            if (selectCategoria) selectCategoria.innerHTML = opcionesHtml;

            // Poblar select de editar tarea
            const selectCategoriaEditar = document.getElementById("select-categoria-editar");
            if (selectCategoriaEditar) selectCategoriaEditar.innerHTML = opcionesHtml;
        }
    } catch (error) {
        console.error("Error cargando categorías para los select:", error);
    }
}

// Obtener todas las tareas y distribuirlas en tarjetas y tabla
async function cargarYRenderizarTareas() {
    try {
        const respuesta = await fetch("controllers/obtener_tareas.php");
        const resultado = await respuesta.json();

        if (resultado.status === "success" && resultado.data) {
            listaTareasGlobal = resultado.data; // Guardamos en memoria para usar al editar
            renderizarTarjetasInicio(resultado.data);
            renderizarTablaTareas(resultado.data);
        }
    } catch (error) {
        console.error("Error al obtener tareas:", error);
    }
}

// Pintar las tareas en las columnas de Inicio y activar contadores
function renderizarTarjetasInicio(tareas) {
    const contPendiente = document.getElementById("pendiente");
    const contProceso = document.querySelector(".card.proceso .cont-tarea");
    const contCompletada = document.querySelector(".card.completada .cont-tarea");

    if (!contPendiente || !contProceso || !contCompletada) return;

    contPendiente.innerHTML = "";
    contProceso.innerHTML = "";
    contCompletada.innerHTML = "";

    let countPendiente = 0;
    let countProceso = 0;
    let countCompletado = 0;

    tareas.forEach(tarea => {
        const tareaDiv = document.createElement("div");
        tareaDiv.className = "tarea";
        tareaDiv.draggable = true;
        tareaDiv.id = `tarea-${tarea.id_tarea}`;
        tareaDiv.dataset.id = tarea.id_tarea;

        let claseFechaCss = "pendiente";
        let archivoIcono = "icono_fecha_pendiente.svg";

        if (tarea.estado === "en_proceso") {
            claseFechaCss = "proceso";
            archivoIcono = "icono_fecha_proceso.svg"; 
        } else if (tarea.estado === "completado") {
            claseFechaCss = "completada";
            archivoIcono = "icono_fecha_completada.svg";
        }

        tareaDiv.innerHTML = `
            <div class="info-tarea">
                <p class="titulo-tarea">${escapeHtml(tarea.titulo)}</p>
                <p class="categoria-tarea" style="background-color: ${tarea.categoria_color} !important;">
                    ${escapeHtml(tarea.categoria_nombre)}
                </p>
                <p class="fecha-tarea ${claseFechaCss}">
                    <img src="assets/iconos/iconos_dashboard/${archivoIcono}" alt="icono" style="width: 25px;"> 
                    ${tarea.fecha_limite || 'Sin fecha'}
                </p>
            </div>
            <div>
                <img src="assets/iconos/iconos_dashboard/icono_editar.svg" alt="editar" class="btn-editar-tarea" data-id="${tarea.id_tarea}" style="width: 25px; cursor: pointer;">
            </div>
        `;

        tareaDiv.addEventListener("dragstart", (e) => {
            e.dataTransfer.setData("text/plain", tarea.id_tarea);
        });

        if (tarea.estado === "pendiente") {
            contPendiente.appendChild(tareaDiv);
            countPendiente++;
        } else if (tarea.estado === "en_proceso") {
            contProceso.appendChild(tareaDiv);
            countProceso++;
        } else if (tarea.estado === "completado") {
            contCompletada.appendChild(tareaDiv);
            countCompletado++;
        }
    });

    actualizarContadorCard("pendiente", countPendiente);
    actualizarContadorCard("proceso", countProceso);
    actualizarContadorCard("completada", countCompletado);
}

// Pintar las tareas en la tabla del módulo "Mis tareas"
function renderizarTablaTareas(tareas) {
    const tbody = document.querySelector(".cont-tabla-tareas table tbody");
    if (!tbody) return;

    if (tareas.length === 0) {
        tbody.innerHTML = `<tr><td colspan="5" style="text-align: center; color: var(--text-secondary);">No hay tareas registradas.</td></tr>`;
        return;
    }

    tbody.innerHTML = "";

    tareas.forEach(tarea => {
        const tr = document.createElement("tr");

        tr.innerHTML = `
            <td>${escapeHtml(tarea.titulo)}</td>
            <td>
                <p class="tabla-categoria color" style="background-color: ${tarea.categoria_color} !important;">
                    ${escapeHtml(tarea.categoria_nombre)}
                </p>
            </td>
            <td>
                <p class="estado color" style="text-transform: capitalize;">
                    ${tarea.estado.replace('_', ' ')}
                </p>
            </td>
            <td>${tarea.fecha_limite || '-'}</td>
            <td>
                <img src="assets/iconos/iconos_dashboard/icono_editar.svg" alt="icono" style="width: 35px; transform: rotate(90deg); cursor: pointer;" class="btn-editar-tarea" data-id="${tarea.id_tarea}">
            </td>
        `;
        tbody.appendChild(tr);
    });
}

function actualizarContadorCard(claseCard, cantidad) {
    const contadorElem = document.querySelector(`.card.${claseCard} .cantidad p`);
    if (contadorElem) {
        contadorElem.textContent = cantidad;
    }
}

function escapeHtml(text) {
    if (!text) return "";
    return text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
}