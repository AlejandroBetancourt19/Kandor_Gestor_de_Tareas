document.addEventListener("DOMContentLoaded", () => {
    const columnas = document.querySelectorAll(".cont-tarea");

    columnas.forEach(columna => {
        columna.addEventListener("dragover", (e) => {
            e.preventDefault(); // Necesario para permitir el drop
        });

        columna.addEventListener("drop", async (e) => {
            e.preventDefault();
            const idTarea = e.dataTransfer.getData("text/plain");
            const elementoTarea = document.getElementById(`tarea-${idTarea}`);

            if (elementoTarea && columna) {
                // Mover visualmente el elemento a la columna destino
                columna.appendChild(elementoTarea);

                // Obtener el nuevo estado desde el atributo data-estado de la tarjeta contenedora padre
                const cardPadre = columna.closest(".card");
                const nuevoEstado = cardPadre ? cardPadre.dataset.estado : null;

                if (nuevoEstado && idTarea) {
                    try {
                        const respuesta = await fetch("controllers/actualizar_estado_tarea.php", {
                            method: "POST",
                            headers: { "Content-Type": "application/json" },
                            body: JSON.stringify({ id_tarea: idTarea, estado: nuevoEstado })
                        });

                        const resultado = await respuesta.json();
                        if (resultado.status === "success") {
                            // Refrescar para sincronizar contadores y la tabla de Mis Tareas
                            if (typeof cargarYRenderizarTareas === "function") {
                                cargarYRenderizarTareas();
                            }
                        } else {
                            mostrarToast("Error", "No se pudo actualizar el estado de la tarea", "error");
                        }
                    } catch (error) {
                        console.error("Error en Drag & Drop fetch:", error);
                    }
                }
            }
        });
    });
});