
class RegistroAcLibroDeAlzas {

    constructor(popup, form, fila_table_delete, url, store_url, update_url, destroy_url, archivo_url, imprimir_url, index_url) {
        this.popup = popup;
        this.url = url;
        this.store_url = store_url;
        this.update_url = update_url;
        this.destroy_url = destroy_url;
        this.archivo_url = archivo_url;
        this.form = form;
        this.index_url = index_url;
        this.fila_table_delete = fila_table_delete
        this.imprimir_url = imprimir_url;
    }

    set setForm(form) {
        this.form = form;
    }
    set setFilaTableDelete(fila_table_delete) {
        this.fila_table_delete = fila_table_delete;
    }

    formatFechaHTML() {
        // crea un nuevo objeto `Date`
        let fecha_actual = new Date();
        let year = fecha_actual.getFullYear();
        let mes = fecha_actual.getMonth() + 1;
        let dia = fecha_actual.getDate();
        if (dia <= 9) {
            dia = "0" + dia;
        }
        if (mes <= 9) {
            mes = "0" + mes;
        }
        return `${year}-${mes}-${dia}`;
    }

    viewPopupMessage(type, titulo, mensaje) {
        let data = '';
        let btn_aceptar = '';
        let btn_cancelar = '';
        switch (type) {
            case 'sucess':
                data = `<div class="popup">
                               <img src="../assets/images/verificado.gif" alt=""> 
                               <h2 style="color: #04ae0c;">${titulo}</h2>
                               <p>${mensaje}</p>
                               <div class="popup-btn">
                                    <button type="button" class="btn-aceptar">Aseptar</button>                              
                                </div>
                        </div>`;
                this.popup.innerHTML = data;
                btn_aceptar = document.querySelector('.btn-aceptar');
                this.popup.classList.add('container-popup');
                //para cerrar el popup con animacion
                btn_aceptar.addEventListener('click', () => {
                    let popup_mensaje = document.querySelector('.popup');
                    popup_mensaje.style.animation = 'popup-close 1s forwards';
                    //luego que se iso la animacion ahora recien eliminamos la clase
                    setTimeout(() => {
                        this.popup.classList.remove('container-popup');
                        this.popup.innerHTML = '';
                    }, 500);
                });
                break;
            case 'error':
                data = `<div class="popup">
                               <img src="../assets/images/advertencia.gif" alt=""> 
                               <h2 style="color:#ff0000;">${titulo}</h2>
                               <p>${mensaje}</p>
                               <div class="popup-btn">
                                    <button type="button" class="btn-aceptar">Aseptar</button>                                 
                                </div>
                        </div>`;
                this.popup.innerHTML = data;
                btn_aceptar = document.querySelector('.btn-aceptar');

                this.popup.classList.add('container-popup');
                //para cerrar el popup con animacion
                btn_aceptar.addEventListener('click', () => {
                    let popup_mensaje = document.querySelector('.popup');
                    popup_mensaje.style.animation = 'popup-close 1s forwards';
                    //luego que se iso la animacion ahora recien eliminamos la clase
                    setTimeout(() => {
                        this.popup.classList.remove('container-popup');
                        this.popup.innerHTML = '';
                    }, 500);
                });

                break;

            case 'confirm-delete':

                data = `<div class="popup">
                               <img src="../assets/images/advertencia.gif" alt=""> 
                               <h2 style="color:#ff0000;">${titulo}</h2>
                               <p>${mensaje}</p>
                               <div class="popup-btn">
                                    <button type="button" class="btn-aceptar">Aseptar</button>
                                    <button type="button" class="btn-cancelar">Cancelar</button>
                                </div>
                        </div>`;
                this.popup.innerHTML = data;
                btn_aceptar = document.querySelector('.btn-aceptar');
                btn_cancelar = document.querySelector('.btn-cancelar');

                this.popup.classList.add('container-popup');
                //para cerrar el popup con animacion
                btn_aceptar.addEventListener('click', () => {
                    let popup_mensaje = document.querySelector('.popup');
                    popup_mensaje.style.animation = 'popup-close 1s forwards';
                    //luego que se iso la animacion ahora recien eliminamos la clase
                    setTimeout(() => {
                        this.popup.classList.remove('container-popup');
                        this.popup.innerHTML = '';

                        //el usuario confirmo la aliminacion
                        this.destroy();

                    }, 500);
                    return true;
                });

                //para cerrar el popup con animacion
                btn_cancelar.addEventListener('click', () => {
                    let popup_mensaje = document.querySelector('.popup');
                    popup_mensaje.style.animation = 'popup-close 1s forwards';
                    //luego que se iso la animacion ahora recien eliminamos la clase
                    setTimeout(() => {
                        this.popup.classList.remove('container-popup');
                        this.popup.innerHTML = '';
                        //el usuario cancelo la eliminacion

                    }, 500);
                    return false;
                });

                break;

            case 'auto-popup-error':
                data = `<div class="popup-auto">
                           <img src="../assets/images/advertencia.gif" alt=""> 
                           <h2 style="color:#0159bd;">${titulo}</h2>
                           <p>${mensaje}</p>
                         </div>`;
                this.popup.innerHTML = data;
                this.popup.classList.add('container-popup-auto');
                //para cerrar el popup con animacion
                setTimeout(() => {
                    let popup_mensaje = document.querySelector('.popup-auto');
                    popup_mensaje.style.animation = 'popup-auto-close 1s forwards';
                }, 3000);
                //eliminamos la clase
                setTimeout(() => {
                    this.popup.classList.remove('container-popup-auto');
                    this.popup.innerHTML = '';
                }, 3500);
                break;

            default:
                console.log('error desconocido');
                break;

        }
    }

    viewMensajeErrorCampos(campo_error, mensaje) {
        let mensaje_error;
        switch (campo_error) {
            case 'fecha_emitida':
                mensaje_error = document.getElementById('error-fecha_emitida');
                mensaje_error.innerText = mensaje;
                break;
            case 'referencia':
                mensaje_error = document.getElementById('error-referencia');
                mensaje_error.innerText = mensaje;
                break;
            case 'descripcion':
                mensaje_error = document.getElementById('error-descripcion');
                mensaje_error.innerText = mensaje;
                break;
            case 'alza_de':
                mensaje_error = document.getElementById('error-alza_de');
                mensaje_error.innerText = mensaje;
                break;
            case 'peso_oro_fisico':
                mensaje_error = document.getElementById('error-peso_oro_fisico');
                mensaje_error.innerText = mensaje;
                break;

            case 'simbolo':
                mensaje_error = document.getElementById('error-simbolo');
                mensaje_error.innerText = mensaje;
                break;

            case 'archivo':
                mensaje_error = document.getElementById('error-archivo');
                mensaje_error.innerText = mensaje;
                break;

            default: break;
        }//switch
    }

    clearMensajeErrorCampos() {
        let mensaje_error;

        mensaje_error = document.getElementById('error-fecha_emitida');
        mensaje_error.innerText = "";

        mensaje_error = document.getElementById('error-referencia');
        mensaje_error.innerText = "";

        mensaje_error = document.getElementById('error-descripcion');
        mensaje_error.innerText = "";

        mensaje_error = document.getElementById('error-alza_de');
        mensaje_error.innerText = "";

        mensaje_error = document.getElementById('error-peso_oro_fisico');
        mensaje_error.innerText = "";

        mensaje_error = document.getElementById('error-simbolo');
        mensaje_error
        mensaje_error.innerText = "";

        mensaje_error = document.getElementById('error-archivo');
        mensaje_error.innerText = "";
    }

    clearInputsForm() {
        let input_form;
        //se incrementa el numero de registro
        input_form = document.getElementsByName('numero-de-registro');
        let number = parseInt(input_form[0].value) + 1;
        number = number.toString().padStart(5, '0');
        input_form[0].value = number;

        input_form = document.getElementsByName('fecha_emitida');
        input_form[0].value = this.formatFechaHTML();

        input_form = document.getElementsByName('referencia');
        input_form[0].value = '';

        input_form = document.getElementsByName('descripcion');
        input_form[0].value = '';

        input_form = document.getElementsByName('alza_de');
        input_form[0].value = '';

        input_form = document.getElementsByName('peso_oro_fisico');
        input_form[0].value = '0.00';

        input_form = document.getElementsByName('simbolo');
        input_form[0].value = 'Gr.';

        input_form = document.getElementsByName('archivo');
        input_form[0].value = '';

        let vista_previa = document.getElementById('vista-previa');
        vista_previa.src = "../assets/images/image-preview.png";
    }


    store() {
        let datos_formulario = new FormData(this.form);
        fetch(this.url + this.store_url, {
            method: 'post',
            body: datos_formulario,

        }).then(response => response.json()).then(result => {

            if (result.status_code == 401) {
                this.viewPopupMessage('error', 'Acceso no autorizado',result.message);
                console.log(result);
                return;
            }

            if (result.errors_db == true) {
                this.viewPopupMessage('error', 'Error', 'Ocurrio un error al guardar este registro!');
                console.log(result);
                return;
            }

            this.clearMensajeErrorCampos();
            if (result.errors_campos == true) {
                for (let campo in result['errors_campos_messages']) {
                    this.viewMensajeErrorCampos(campo, result['errors_campos_messages'][campo][0]);
                }
                this.viewPopupMessage('auto-popup-error', 'Verificar Campos', 'Los datos introducidos son incorrectos!');
                return;
            }

            this.clearInputsForm();
            this.viewPopupMessage('sucess', 'Registrado', 'El registro se guardo correctamente!');

        }).catch((ex) => {
            this.viewPopupMessage('error', 'Error Inesperado', 'Ocurrio un error inesperado al guardar el registro!');
            console.log(ex)
        });

    }//store

    confirmDestroy() {

        this.viewPopupMessage('confirm-delete', 'Confirmar', '¿Esta seguro de eliminar este registro?');
    }

    destroy() {

        fetch(this.url + this.destroy_url, {
            method: 'post',
            body: this.form,
        }).then(response => response.json()).then(result => {

            if (result.status_code == 401) {
                this.viewPopupMessage('error', 'Acceso no autorizado',result.message);
                console.log(result);
                return;
            }

            if (result.errors_db == true) {
                this.viewPopupMessage('error', 'Error', 'Ocurrio un error al eliminar este registro!');
                console.log(result);
                return;
            }

            //  location.reload();
            this.fila_table_delete.remove();

        }).catch(() => {
            this.viewPopupMessage('error', 'Error Inesperado', 'Ocurrio un error inesperado al eliminar el registro!');
        });

    }

    update() {
        let form_data = new FormData(this.form);
        fetch(this.url + this.update_url, {
            method: 'post',
            body: form_data,
        }).then(response => response.json()).then(result => {

            if (result.status_code == 401) {
                this.viewPopupMessage('error', 'Acceso no autorizado',result.message);
                console.log(result);
                return;
            }

            if (result.errors_db == true) {
                this.viewPopupMessage('error', 'Error', 'Ocurrio un error al actualizar este registro!');
                console.log(result);
                return;
            }

            this.clearMensajeErrorCampos();
            if (result.errors_campos == true) {
                for (let campo in result['errors_campos_messages']) {
                    this.viewMensajeErrorCampos(campo, result['errors_campos_messages'][campo][0]);
                }
                this.viewPopupMessage('auto-popup-error', 'Verificar Campos', 'Los datos introducidos son incorrectos!');
                return;
            }

            this.viewPopupMessage('sucess', 'Registro Actualizado', 'El registro se actualizo correctamente!');

        }).catch(function (ex) {
            console.log(ex);
            this.viewPopupMessage('error', 'Error Inesperado', 'Ocurrio un error inesperado al actualizar este registro!');

        });

    }//update

    archivoApi() {

        fetch(this.url + this.archivo_url, {
            method: 'post',
            body: this.form,
        }).then(response => {
            if (response.headers.get('Content-Type').includes('application/json')) {
                // La respuesta es un JSON
                return response.json();
            } else {
                // La respuesta es un Blob
                return response.blob();
            }
        }).then(result => {
            if (result instanceof Blob) {
                // manejar los datos de archivo binario
                let blob = URL.createObjectURL(result);

                let div_content = document.createElement('DIV');
                div_content.classList.add('popup-archivo');
                let data = null;
                if (result.type == 'application/pdf') {
                    data = `<i class="zmdi zmdi-close-circle" id="close-popup-all"></i>
                <h2>Archivo</h2>
                <embed src="${blob}"  type="application/pdf">`;
                } else {
                    data = `<i class="zmdi zmdi-close-circle" id="close-popup-all"></i>
                    <h2>Archivo</h2>
                             <img src="${blob}" alt="imagen" > `;
                }

                div_content.innerHTML = data;
                this.popup.append(div_content);
                this.popup.classList.add('container-popup');

                let btn_close_popup_all = document.getElementById('close-popup-all');
                btn_close_popup_all.addEventListener('click', (evt) => {
                    let div_content = evt.target.parentNode;
                    div_content.remove();
                    this.popup.classList.remove('container-popup');
                });

            } else {
                console.log(result);
                if (result.status_code == 401) {
                    this.viewPopupMessage('error', 'Acceso no autorizado',result.message);
                    return;
                }

                this.viewPopupMessage('error', 'Error', 'Ocurrio un error al obtener el archivo del registro!');

            }

        }).catch(function (ex) {
            console.log(ex);
        });

    }

    imprimirView() {
        fetch(this.url + this.imprimir_url, {
            method: 'post',
            body: this.form,
        }).then(response => {
            if (response.headers.get('Content-Type').includes('application/json')) {
                // La respuesta es un JSON
                return response.json();
            } else {
                // La respuesta es un Blob
                return response.blob();
            }
        }).then(result => {
            if (result instanceof Blob) {
                // manejar los datos de archivo binario
                let blob = URL.createObjectURL(result);

                let div_content = document.createElement('DIV');
                div_content.classList.add('popup-archivo');

                let data = `<i class="zmdi zmdi-close-circle" id="close-popup-all"></i>
                <h2>Imprimir</h2>
                <embed src="${blob}"  type="application/pdf">`;

                div_content.innerHTML = data;
                this.popup.append(div_content);
                this.popup.classList.add('container-popup');

                let btn_close_popup_all = document.getElementById('close-popup-all');
                btn_close_popup_all.addEventListener('click', (evt) => {
                    let div_content = evt.target.parentNode;
                    div_content.remove();
                    this.popup.classList.remove('container-popup');
                });

            } else {
                console.log(result);
                if (result.status_code == 401) {
                    this.viewPopupMessage('error', 'Acceso no autorizado',result.message);
                    return;
                }

                this.viewPopupMessage('error', 'Error', 'Ocurrio un error al obtener el vista previa de la impresion!');

            }

        }).catch(function (ex) {
            console.log(ex);
        });

    }

}//class

let container_popup = document.querySelector('.container-popup-hidden');

// al utilizar fetch no es necesario enviar la url 'http://localhost:4000' javascript optiene la url por si solo pero en caso 
//si da errores  ahi talvez se nesesite enviar la url => uri=http://localhost:4000
let uri = "";
let uri_store = "/api/store-registro-ac-libro-de-alzas";
let uri_update = "/api/update-registro-ac-libro-de-alzas";
let uri_destroy = "/api/destroy-registro-ac-libro-de-alzas";
let uri_archivo = "/api/archivo-registro-ac-libro-de-alzas";
let uri_imprimir = "/api/imprimir-id-registro-ac-libro-de-alzas";
let uri_index = "/registro-ac-libro-de-alzas";

let registro_ac_libro_de_alzas = new RegistroAcLibroDeAlzas(container_popup, null, null, uri, uri_store, uri_update, uri_destroy, uri_archivo, uri_imprimir, uri_index);

var onClick = (element, event, selector, handler) => {
    element.addEventListener(event, e => {
        if (e.target.closest(selector)) {
            handler(e);
        }
    });
}

//para enviar y modificar registro 
onClick(document, 'click', '#btn-accion', e => {

    let accion = e.target.closest("#btn-accion").dataset.action;
    let form_data = "";
    switch (accion) {
        case 'store':
            form_data = document.getElementById('mi-form');
            registro_ac_libro_de_alzas.setForm = form_data;
            registro_ac_libro_de_alzas.store();
            break;

        case 'update':
            form_data = document.getElementById('mi-form');
            registro_ac_libro_de_alzas.setForm = form_data;
            registro_ac_libro_de_alzas.update();
            break;

        default:
            console.log('NO HAY NINGUNA ACCION');
            break;
    }

});


onClick(document, 'click', '#delete', e => {
    let id = e.target.closest("#delete").dataset.id_reg;
    let form_data = new FormData();
    form_data.append('id-reg', id);

    let fila = e.target.closest("#delete").parentNode.parentNode;
    registro_ac_libro_de_alzas.setForm = form_data;
    registro_ac_libro_de_alzas.setFilaTableDelete = fila;
    registro_ac_libro_de_alzas.confirmDestroy();

});


onClick(document, 'click', '#file', e => {

    let id = e.target.closest("#file").dataset.id_registro;
    let form_data = new FormData();
    form_data.append('id-reg', id);
    registro_ac_libro_de_alzas.setForm = form_data;
    registro_ac_libro_de_alzas.archivoApi();

});

onClick(document, 'click', '#print', e => {
    let id = e.target.closest("#print").dataset.id_reg_print;
    let form_data = new FormData();
    form_data.append('id-reg', id);
    registro_ac_libro_de_alzas.setForm = form_data;
    registro_ac_libro_de_alzas.imprimirView();
});




// const eventMap = new Map();

// const addEvent = (selector, event, handler) => {
//     if (!eventMap.has(event)) {
//         eventMap.set(event, new Map());
//         document.addEventListener(event, e => {
//             const target = e.target;
//             eventMap.get(event).forEach((handler, selector) => {
//                 if (target.matches(selector)) {
//                     handler(e, target);
//                 }
//             });
//         });
//     }
//     eventMap.get(event).set(selector, handler);
// };


// addEvent('#file[data-id_registro]', 'click',  (e ,target)=> {
//    // e.stopPropagation();
//     let id = target.dataset.id_registro;
//     let form_data = new FormData();
//     form_data.append('id-reg', id);
//     registro_ac_libro_de_alzas.setForm = form_data;
//     registro_ac_libro_de_alzas.archivoApi();
//     console.log(id);
// });






