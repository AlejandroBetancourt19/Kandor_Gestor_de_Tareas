// Función reutilizable para lanzar cualquier toast
function mostrarToast(titulo, mensaje, tipo = 'success') {
  const toast = document.getElementById('toastAlerta');
  const toastTitle = document.getElementById('toastTitle');
  const toastMessage = document.getElementById('toastMessage');
  const toastIcon = document.getElementById('toastIcon');

  if (!toast) return;

  // Cambiar textos
  toastTitle.textContent = titulo;
  toastMessage.textContent = mensaje;

  // Remover clases de tipos anteriores y asignar la nueva
  toast.className = 'toast-notification ' + tipo;

  // Cambiaricono segun el tipo
  if (tipo === 'success') {
    toastIcon.textContent = '✅';
  } else if (tipo === 'error') {
    toastIcon.textContent = '❌';
  } else if (tipo === 'warning') {
    toastIcon.textContent = '⚠️';
  }

  // Mostrar la burbuja
  toast.classList.add('mostrar');

  // Ocultar automaticamente despus de 4 segundos
  setTimeout(() => {
    toast.classList.remove('mostrar');
  }, 4000);
}

// Escuchar los parametros de la URL enviados desde PHp
document.addEventListener('DOMContentLoaded', () => {
  const urlParams = new URLSearchParams(window.location.search);

  // Éxito al crear la categoría
  if (urlParams.has('exito')) {
    mostrarToast('¡Éxito!', 'La categoría se ha creado correctamente.', 'success');
    window.history.replaceState({}, document.title, window.location.pathname);
  } 
  // Error: Categoría duplicada
  else if (urlParams.get('error') === 'categoria-existe') {
    mostrarToast('¡Atención!', 'La categoría que intentas agregar ya existe.', 'warning');
    window.history.replaceState({}, document.title, window.location.pathname);
  } 
  // Error de Base de Datos y otros errores
  else if (urlParams.get('error') === 'bd' || urlParams.has('error')) {
    mostrarToast('¡Error!', 'Ocurrió un problema al procesar la solicitud.', 'error');
    window.history.replaceState({}, document.title, window.location.pathname);
  }
});