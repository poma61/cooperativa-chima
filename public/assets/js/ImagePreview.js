// Obtener referencia al input y a la imagen

var seleccionArchivos = document.getElementById("seleccionar-archivo");
 var imagenPrevisualizacion = document.getElementById("vista-previa");
 // input = document.querySelector("vista-previa");
//  file-btn

// Escuchar cuando cambie
seleccionArchivos.addEventListener("change", () => {
  // Los archivos seleccionados, pueden ser muchos o uno
  let archivos = seleccionArchivos.files;
  // Si no hay archivos salimos de la función y quitamos la imagen
  if (!archivos || !archivos.length) {
    imagenPrevisualizacion.src = "";
    return;
  }
  // Ahora tomamos el primer archivo, el cual vamos a previsualizar
 let primerArchivo = archivos[0];
  // Lo convertimos a un objeto de tipo objectURL
  let objectURL = URL.createObjectURL(primerArchivo);
  // Y a la fuente de la imagen le ponemos el objectURL
  imagenPrevisualizacion.src = objectURL;
});


