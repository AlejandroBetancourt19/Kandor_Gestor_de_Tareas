document.addEventListener("DOMContentLoaded", function () {
    const contModo = document.querySelector(".modo-oscuro-claro");
    if (!contModo) return;

    const iconos = contModo.querySelectorAll("img");
    const iconoSol = iconos[0];  // Primer icono (Sol)
    const iconoLuna = iconos[1]; // Segundo icono (Luna)

    // Función para mostrar un solo icono según el estado
    function actualizarIconos(esClaro) {
        if (esClaro) {
            if (iconoSol) iconoSol.style.display = "none";
            if (iconoLuna) iconoLuna.style.display = "block";
        } else {
            if (iconoSol) iconoSol.style.display = "block";
            if (iconoLuna) iconoLuna.style.display = "none";
        }
    }

    // 1. Cargar preferencia guardada previamente
    const modoGuardado = localStorage.getItem("kanban_theme");
    if (modoGuardado === "light") {
        document.body.classList.add("light-mode");
        actualizarIconos(true);
    } else {
        actualizarIconos(false);
    }

    // 2. Clic en el Sol -> Activa modo claro y muestra la Luna
    if (iconoSol) {
        iconoSol.addEventListener("click", function () {
            document.body.classList.add("light-mode");
            localStorage.setItem("kanban_theme", "light");
            actualizarIconos(true);
        });
    }

    // 3. Clic en la Luna -> Activa modo oscuro y muestra el Sol
    if (iconoLuna) {
        iconoLuna.addEventListener("click", function () {
            document.body.classList.remove("light-mode");
            localStorage.setItem("kanban_theme", "dark");
            actualizarIconos(false);
        });
    }
});