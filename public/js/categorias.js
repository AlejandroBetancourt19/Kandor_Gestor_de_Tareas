// Variable global para almacenar las categorías y que puedan ser leídas al editar
let listaCategoriasGlobal = [];

document.addEventListener("DOMContentLoaded", () => {
    const formCategoria = document.getElementById("form-categoria");
    const modalCategoria = document.getElementById("modal-agg-categoria");
    const btnCrear = document.getElementById("btn-crear-categoria");
    
    const formEditarCategoria = document.getElementById("form-categoria-editar");
    const modalEditarCategoria = document.getElementById("modal-editar-categoria");
    
    // Cargar las categorías al iniciar la página
    cargarCategorias();

    // 1. CREAR CATEGORÍA
    if (btnCrear && formCategoria) {
        btnCrear.addEventListener("click", async (e) => {
            e.preventDefault(); 

            const formData = new FormData(formCategoria);

            try {
                const respuesta = await fetch("controllers/guardar_categoria.php", {
                    method: "POST",
                    body: formData
                });

                const resultado = await respuesta.json();

                if (resultado.status === "success") {
                    if (modalCategoria) {
                        modalCategoria.style.display = "none";
                    }
                    formCategoria.reset();

                    mostrarToast("¡Éxito!", resultado.message, "success");
                    await cargarCategorias();

                    if (typeof cargarSelectCategorias === "function") {
                        await cargarSelectCategorias();
                    }

                } else if (resultado.status === "existe") {
                    if (modalCategoria) {
                        modalCategoria.style.display = "none";
                    }
                    formCategoria.reset();

                    mostrarToast("¡Atención!", resultado.message, "warning");

                } else {
                    mostrarToast("¡Error!", resultado.message, "error");
                }

            } catch (error) {
                console.error("Error en la petición Fetch:", error);
                mostrarToast("¡Error!", "No se pudo conectar con el servidor.", "error");
            }
        });
    }

    // EDITAR CATEGORÍA Enviar cambios al servidor mediante Fetch
    if (formEditarCategoria) {
        formEditarCategoria.addEventListener("submit", async (e) => {
            e.preventDefault(); 

            const formData = new FormData(formEditarCategoria);

            try {
                const respuesta = await fetch("controllers/editar_categoria.php", {
                    method: "POST",
                    body: formData
                });

                const resultado = await respuesta.json();

                if (resultado.status === "success") {
                    if (modalEditarCategoria) {
                        modalEditarCategoria.style.display = "none";
                    }
                    mostrarToast("¡Éxito!", resultado.message, "success");
                    
                    //Recargar la tabla de categorías
                    await cargarCategorias();

                    //  Actualizar los selects de categorías en los modales de tareas
                    if (typeof cargarSelectCategorias === "function") {
                        await cargarSelectCategorias();
                    }

                    //Recargar las tareas del inicio para que reflejen los cambios
                    if (typeof cargarYRenderizarTareas === "function") {
                        await cargarYRenderizarTareas(); 
                    }
                } else {
                    mostrarToast("¡Error!", resultado.message, "error");
                }
            } catch (error) {
                console.error("Error al actualizar categoría:", error);
                mostrarToast("¡Error!", "No se pudo conectar con el servidor.", "error");
            }
        });
    }

    // ELIMINAR CATEGORÍA (Desde el modal de edición)
const btnEliminarCategoria = document.querySelector(".btn-eliminar-categoria");
if (btnEliminarCategoria) {
    btnEliminarCategoria.addEventListener("click", async () => {
        const idCategoria = document.getElementById("id_categoria_editar").value;

        if (!idCategoria) return;

        if (confirm("¿Estás seguro de que deseas eliminar esta categoría?")) {
            try {
                const respuesta = await fetch("/kandor_Gestor_de_Tareas/controllers/eliminar_categoria.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: `id_categoria=${idCategoria}`
                });

                const resultado = await respuesta.json();

                if (resultado.status === "success") {
                    // Si se elimina con éxito, cerramos el modal y actualizamos las vistas
                    if (modalEditarCategoria) {
                        modalEditarCategoria.style.display = "none";
                    }
                    mostrarToast("¡Éxito!", resultado.message, "success");
                    await cargarCategorias();

                    if (typeof cargarSelectCategorias === "function") {
                        await cargarSelectCategorias();
                    }
                } else {
                    // AQUÍ CAE SI TIENE TAREAS ASOCIADAS: Muestra el mensaje del servidor
                    mostrarToast("¡Atención!", resultado.message, "warning");
                }
            } catch (error) {
                console.error("Error al eliminar categoría:", error);
                mostrarToast("¡Error!", "No se pudo conectar con el servidor.", "error");
            }
        }
    });
}
});

// Función para obtener y pintar las categorías en la tabla dinámicamente
async function cargarCategorias() {
    const tbody = document.querySelector(".cont-tabla-categorias table tbody");
    if (!tbody) return;

    try {
        const respuesta = await fetch("controllers/obtener_categorias.php");
        const resultado = await respuesta.json();

        if (resultado.status === "success" && resultado.data && resultado.data.length > 0) {
            // Guardamos los datos globalmente para que acciones_btn.js pueda consultarlos
            listaCategoriasGlobal = resultado.data; 

            tbody.innerHTML = ""; // Limpiar tabla antes de pintar

            resultado.data.forEach(cat => {
                const tr = document.createElement("tr");

                tr.innerHTML = `
                    <td>${cat.nombre}</td>
                    <td>
                        <div class="color-categ" style="background-color: ${cat.color};"></div>
                    </td>
                    <td>
                        <p class="cant-tareas">${cat.total_tareas || 0}</p>
                    </td>
                    <td>
                        <img src="assets/iconos/iconos_dashboard/icono_editar.svg" alt="icono" style="width: 35px; transform: rotate(90deg); cursor: pointer;" class="btn-editar-categoria" data-id="${cat.id_categoria}">
                    </td>
                `;
                tbody.appendChild(tr);
            });
        } else {
            tbody.innerHTML = `<tr><td colspan="4" style="text-align: center; color: var(--text-secondary);">No hay categorías registradas.</td></tr>`;
        }
    } catch (error) {
        console.error("Error al cargar categorías:", error);
    }
}