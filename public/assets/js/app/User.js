

class User {

    constructor(popup, form, fila_table_delete, url, store_url, update_url, destroy_url, index_url) {
        this.popup = popup;
        this.url = url;
        this.store_url = store_url;
        this.update_url = update_url;
        this.destroy_url = destroy_url;
        this.form = form;
        this.index_url = index_url;
        this.fila_table_delete = fila_table_delete
    }

    /**
     * @param {DataForm} form
     */
    set setForm(form) {
        this.form = form;
    }

    /**
     * @param {any} fila_table_delete
     */
    set setFilaTableDelete(fila_table_delete) {
        this.fila_table_delete = fila_table_delete;
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

            case 'nombres':
                mensaje_error = document.getElementById('error-nombres');
                mensaje_error.innerText = mensaje;
                break;

            case 'apellidos':
                mensaje_error = document.getElementById('error-apellidos');
                mensaje_error.innerText = mensaje;
                break;

            case 'usuario':
                mensaje_error = document.getElementById('error-usuario');
                mensaje_error.innerText = mensaje;
                break;

            case 'password':
                mensaje_error = document.getElementById('error-password');
                mensaje_error.innerText = mensaje;
                mensaje_error = document.getElementById('error-password_confirmation');
                mensaje_error.innerText = mensaje;
                break;

            case 'foto':
                mensaje_error = document.getElementById('error-foto');
                mensaje_error.innerText = mensaje;
                break;

            case 'rol':
                mensaje_error = document.getElementById('error-rol');
                mensaje_error.innerText = mensaje;
                break;

            default: break;
        }//switch
    }

    clearMensajeErrorCampos(type) {
        let mensaje_error;

        mensaje_error = document.getElementById('error-nombres');
        mensaje_error.innerText = "";

        mensaje_error = document.getElementById('error-apellidos');
        mensaje_error.innerText = "";

        if (type == 'store') {
            mensaje_error = document.getElementById('error-usuario');
            mensaje_error.innerText = "";

            mensaje_error = document.getElementById('error-password');
            mensaje_error.innerText = "";

            mensaje_error = document.getElementById('error-password_confirmation');
            mensaje_error.innerText = "";
        }

        mensaje_error = document.getElementById('error-foto');
        mensaje_error.innerText = "";


        mensaje_error = document.getElementById('error-rol');
        mensaje_error.innerText = "";


    }

    clearInputsForm() {
    let input_form;

    input_form = document.getElementsByName('nombres');
    input_form[0].value = '';

    input_form = document.getElementsByName('apellidos');
    input_form[0].value = '';


    input_form = document.getElementsByName('usuario');
    input_form[0].value = '';

    input_form = document.getElementsByName('password');
    input_form[0].value = '';

    input_form = document.getElementsByName('password_confirmation');
    input_form[0].value = '';


    input_form = document.getElementsByName('foto');
    input_form[0].value = '';

    let foto = document.getElementById('vista-previa');
    foto.src = '../assets/images/image-preview.png';


    input_form = document.getElementsByName('rol');
    input_form[0].value = '';

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

        this.clearMensajeErrorCampos('store');
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
        console.log(ex);
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

    }).catch((ex) => {
        this.viewPopupMessage('error', 'Error Inesperado', 'Ocurrio un error inesperado al eliminar el registro!');
        console.log(ex);
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

        this.clearMensajeErrorCampos('update');

        if (result.errors_campos == true) {
            for (let campo in result['errors_campos_messages']) {
                this.viewMensajeErrorCampos(campo, result['errors_campos_messages'][campo][0]);
            }
            this.viewPopupMessage('auto-popup-error', 'Verificar Campos', 'Los datos introducidos son incorrectos!');
            return;
        }

        this.viewPopupMessage('sucess', 'Registro Actualizado', 'El registro se actualizo correctamente!');

    }).catch(function (ex) {

        //  this.viewPopupMessage('error', 'Error Inesperado', 'Ocurrio un error inesperado al actualizar este registro!');
        console.log(ex);
    });

}//update



}//class

let container_popup = document.querySelector('.container-popup-hidden');

// al utilizar fetch no es necesario enviar la url 'http://localhost:4000' javascript optiene la url por si solo pero en caso 
//si da errores  ahi talvez se nesesite enviar la url => uri=http://localhost:4000
let uri = "";
let uri_store = "/api/store-usuarios";
let uri_update = "/api/update-usuarios";
let uri_destroy = "/api/destroy-usuarios";
let uri_index = "/usuario";

let user = new User(container_popup, null, null, uri, uri_store, uri_update, uri_destroy, uri_index);

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
            user.setForm = form_data;
            user.store();
            break;

        case 'update':
            form_data = document.getElementById('mi-form');
            user.setForm = form_data;
            user.update();
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
    user.setForm = form_data;
    user.setFilaTableDelete = fila;
    user.confirmDestroy();

});




onClick(document, 'click', '#print', e => {
    let id = e.target.closest("#print").dataset.id_reg_print;
    let form_data = new FormData();
    form_data.append('id-reg', id);
    user.setForm = form_data;
    user.imprimirView();
});


onClick(document, 'click', '#btn-busqueda', e => {
    let input_buscar = document.getElementsByName('texto-a-buscar');

    let renderizar_texto = input_buscar[0].value;
    //eliminar todos los espacios en blanco sobrante del texto para hacer una busqueda consisa
    let texto_buscar = renderizar_texto.split(/\s+/).join(' ');

    let form_data = new FormData();
    form_data.append('txt-buscar', texto_buscar);
    user.setForm = form_data;
    user.buscarSocio();
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
//     user.setForm = form_data;
//     user.archivoApi();
//     console.log(id);
// });






