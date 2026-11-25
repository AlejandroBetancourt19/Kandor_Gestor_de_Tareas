/*==========================================
    GESTIÓN GLOBAL DE CLICS (MODALES Y ACCIONES)
==========================================*/
document.addEventListener("click", (e) => {
    
    // 1. ABRIR MODALES GENERALES (por atributo data-modal, ej: Nueva tarea, Nueva categoría)
    const botonAbrir = e.target.closest("[data-modal]");
    if (botonAbrir) {
        e.preventDefault();
        const modalId = botonAbrir.getAttribute("data-modal");
        const modal = document.getElementById(modalId);

        if (modal) {
            modal.style.display = "flex";
        }
        return;
    }

    // 2. ABRIR MODAL EDITAR TAREA
    const botonEditarTarea = e.target.closest(".btn-editar-tarea");
    if (botonEditarTarea) {
        e.preventDefault();
        const idTarea = botonEditarTarea.getAttribute("data-id");

        if (typeof listaTareasGlobal !== "undefined") {
            const tareaActual = listaTareasGlobal.find(t => t.id_tarea == idTarea);
            
            if (tareaActual) {
                const formEditar = document.getElementById("form-editar-tarea");
                if (formEditar) {
                    formEditar.querySelector("#id_tarea_editar").value = tareaActual.id_tarea;
                    formEditar.querySelector("#titulo-editar").value = tareaActual.titulo;
                    formEditar.querySelector("#descripcion-editar").value = tareaActual.descripcion || "";
                    formEditar.querySelector("#select-categoria-editar").value = tareaActual.id_categoria;
                    formEditar.querySelector("#estado-editar").value = tareaActual.estado;
                    formEditar.querySelector("#fecha-limite-editar").value = tareaActual.fecha_limite || "";
                }
            }
        }

        const modalEditar = document.getElementById("modal-editar-tarea");
        if (modalEditar) {
            modalEditar.style.display = "flex";
        }
        return;
    }

    // 3. ABRIR MODAL EDITAR CATEGORÍA
    const btnEditarCategoria = e.target.closest(".btn-editar-categoria");
    if (btnEditarCategoria) {
        e.preventDefault();
        const idCategoria = btnEditarCategoria.getAttribute("data-id");

        if (typeof listaCategoriasGlobal !== "undefined") {
            const categoriaActual = listaCategoriasGlobal.find(c => c.id_categoria == idCategoria);

            if (categoriaActual) {
                const formEditarCategoria = document.getElementById("form-categoria-editar");
                if (formEditarCategoria) {
                    formEditarCategoria.querySelector("#id_categoria_editar").value = categoriaActual.id_categoria;
                    formEditarCategoria.querySelector("#nombre-editar").value = categoriaActual.nombre;
                    
                    // Seleccionar el color correspondiente en los radios
                    const radioColor = formEditarCategoria.querySelector(`input[name="color_categoria"][value="${categoriaActual.color}"]`);
                    if (radioColor) {
                        radioColor.checked = true;
                    }
                }
            }
        }

        const modalEditarCategoria = document.getElementById("modal-editar-categoria");
        if (modalEditarCategoria) {
            modalEditarCategoria.style.display = "flex";
        }
        return;
    }

    // 4. CERRAR MODAL: Clic en cualquier botón con la clase "btn-cancelar"
    const botonCancelar = e.target.closest(".btn-cancelar");
    if (botonCancelar) {
        e.preventDefault();
        const modalPadre = botonCancelar.closest(".cont-modal");
        if (modalPadre) {
            modalPadre.style.display = "none";
        }
        return;
    }

    // 5. CERRAR MODAL: Clic en el fondo oscuro transparente fuera de la caja del modal
    if (e.target.classList.contains("cont-modal")) {
        e.target.style.display = "none";
        return;
    }
});