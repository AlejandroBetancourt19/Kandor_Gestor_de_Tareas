/*=================================
     SPA PARA LOGIN Y REGISTRO
=================================*/
document.addEventListener('DOMContentLoaded', () => {
    // Seleccionamos todos los botones del sidebar y todas las secciones del main
    const botonesModulo = document.querySelectorAll('.sidebar .modulos .btn-modulo');
    const secciones = document.querySelectorAll('main .seccion');

    botonesModulo.forEach(boton => {
        boton.addEventListener('click', () => {
            // Obtenemos el identificador de la sección destino desde el atributo data-target
            const targetId = boton.getAttribute('data-target');

            // Gestionamos la clase activa en los botones del sidebar
            botonesModulo.forEach(b => b.classList.remove('btn-activo'));
            boton.classList.add('btn-activo');

            //  Mostramos la sección correspondiente y ocultamos las demás
            secciones.forEach(seccion => {
                // Comparamos el id de la sección con el target
                if (seccion.id === targetId) {
                    seccion.classList.add('activa');
                } else {
                    seccion.classList.remove('activa');
                }
            });
        });
    });
});