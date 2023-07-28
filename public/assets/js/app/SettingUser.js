

class SettingUser {

    constructor(popup, form, url, update_url) {
        this.popup = popup;
        this.update_url = update_url;
        this.form = form;
        this.url = url;
        this.timeoutId = null;
    }

    /**
     * @param {DataForm} form
     */
    set setForm(form) {
        this.form = form;
    }


    viewPopupMessage(type, titulo, mensaje) {
        let data = '';
        let btn_aceptar = '';
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
            case 'auto-popup-error':
                data = `<div class="popup-auto">
                               <img src="../assets/images/advertencia.gif" alt=""> 
                               <h2 style="color:#0159bd;">${titulo}</h2>
                               <p>${mensaje}</p>
                             </div>`;
                this.popup.innerHTML = data;
                this.popup.classList.add('container-popup-auto');
                //para cerrar el popup con animacion

                if (this.timeoutId != null) {
                    clearTimeout(this.timeoutId);
                }

                this.setTimeout = setTimeout(() => {

                    if (this.popup.classList.contains('container-popup-auto')) {
                        let popup_mensaje = document.querySelector('.popup-auto');
                        popup_mensaje.style.animation = 'popup-auto-close 1s forwards';
                    }


                }, 3000);

                //eliminamos la clase
                this.timeoutId = setTimeout(() => {
                   if (this.popup.classList.contains('container-popup-auto')) {
                        this.popup.classList.remove('container-popup-auto');
                        this.popup.innerHTML = '';
                    }
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

            case 'usuario':
                mensaje_error = document.getElementById('error-usuario');
                mensaje_error.innerText = mensaje;
                break;

            case 'password_new':
                mensaje_error = document.getElementById('error-password_new');
                mensaje_error.innerText = mensaje;
                mensaje_error = document.getElementById('error-password_new_confirmation');
                mensaje_error.innerText = mensaje;
                break;

            case 'password_old':
                mensaje_error = document.getElementById('error-password_old');
                mensaje_error.innerText = mensaje;
                break;

            case 'foto':
                mensaje_error = document.getElementById('error-foto');
                mensaje_error.innerText = mensaje;
                break;

            default: break;
        }//switch
    }

    clearMensajeErrorCampos() {
        let mensaje_error;

        mensaje_error = document.getElementById('error-usuario');
        mensaje_error.innerText = "";

        mensaje_error = document.getElementById('error-password_new');
        mensaje_error.innerText = "";

        mensaje_error = document.getElementById('error-password_new_confirmation');
        mensaje_error.innerText = "";

        mensaje_error = document.getElementById('error-password_old');
        mensaje_error.innerText = "";

        mensaje_error = document.getElementById('error-foto');
        mensaje_error.innerText = "";

    }



    update() {
        let form_data = new FormData(this.form);
        fetch(this.url + this.update_url, {
            method: 'post',
            body: form_data,
        }).then(response => response.json()).then(result => {

            if (result.status_code == 401) {
                this.viewPopupMessage('error', 'Acceso no autorizado', result.message);
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

            this.viewPopupMessage('sucess', 'Contraseña Cambiada', 'La contraseña se cambio correctamente!');

        }).catch(function (ex) {

            //  this.viewPopupMessage('error', 'Error Inesperado', 'Ocurrio un error inesperado al actualizar este registro!');
            console.log(ex);
        });

    }//update



}//class

let content_popup = document.querySelector('.container-popup-hidden');

// al utilizar fetch no es necesario enviar la url 'http://localhost:4000' javascript optiene la url por si solo pero en caso 
//si da errores  ahi talvez se nesesite enviar la url => uri=http://localhost:4000

let uri_update_user = "/api/update-password-usuarios";
let uri_base_ap = "";

let setting_user = new SettingUser(content_popup, null, uri_base_ap, uri_update_user);

var onClick = (element, event, selector, handler) => {
    element.addEventListener(event, e => {
        if (e.target.closest(selector)) {
            handler(e);
        }
    });
}

//para enviar y modificar registro 
onClick(document, 'click', '#btn-accion', e => {
    let form_data_user = document.getElementById('mi-form');
    setting_user.setForm = form_data_user;
    setting_user.update();

});








