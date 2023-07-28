
class Socios {

    constructor(popup, form, url, store_url, update_url, destroy_url, index_url) {
        this.popup = popup;
        this.url = url;
        this.store_url = store_url;
        this.update_url = update_url;
        this.destroy_url = destroy_url;
        this.form = form;
        this.index_url = index_url;
    }

    set setForm(form) {
        this.form = form;
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
                        console.log('eliminacion cancelada');
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
            case 'estado_del_asociado':
                mensaje_error = document.getElementById('error-estado_del_asociado');
                mensaje_error.innerText = mensaje;
                break;
            case 'imagen':
                mensaje_error = document.getElementById('error-imagen');
                mensaje_error.innerText = mensaje;
                break;
            case 'nombres':
                mensaje_error = document.getElementById('error-nombres');
                mensaje_error.innerText = mensaje;
                break;
            case 'apellidos':
                mensaje_error = document.getElementById('error-apellidos');
                mensaje_error.innerText = mensaje;
                break;
            case 'ci':
                mensaje_error = document.getElementById('error-ci');
                mensaje_error.innerText = mensaje;
                break;
            case 'ci_valido':
                mensaje_error = document.getElementById('error-ci_valido');
                mensaje_error.innerText = mensaje;
                break;
            case 'fecha_de_nacimiento':
                mensaje_error = document.getElementById('error-fecha_de_nacimiento');
                mensaje_error.innerText = mensaje;
                break;
            case 'lugar_de_nacimiento':
                mensaje_error = document.getElementById('error-lugar_de_nacimiento');
                mensaje_error.innerText = mensaje;
                break;
            case 'estado_civil':
                mensaje_error = document.getElementById('error-estado_civil');
                mensaje_error.innerText = mensaje;
                break;
            case 'sexo':
                mensaje_error = document.getElementById('error-sexo');
                mensaje_error.innerText = mensaje;
                break;

            case 'celular':
                mensaje_error = document.getElementById('error-celular');
                mensaje_error.innerText = mensaje;
                break;
            //section origen de la procedencia
            case 'punta_de_trabajo':
                mensaje_error = document.getElementById('error-punta_de_trabajo');
                mensaje_error.innerText = mensaje;
                break;
            case 'grupo':
                mensaje_error = document.getElementById('error-grupo');
                mensaje_error.innerText = mensaje;
                break;
            case 'fecha_de_transferencia':
                mensaje_error = document.getElementById('error-fecha_de_transferencia');
                mensaje_error.innerText = mensaje;
                break;
            case 'susecion_de_derecho':
                mensaje_error = document.getElementById('error-susecion_de_derecho');
                mensaje_error.innerText = mensaje;
                break;
            case 'transfiriente_cc':
                mensaje_error = document.getElementById('error-transfiriente_cc');
                mensaje_error.innerText = mensaje;
                break;
            case 'parentesco':
                mensaje_error = document.getElementById('error-parentesco');
                mensaje_error.innerText = mensaje;
                break;
            case 'observacion':
                mensaje_error = document.getElementById('error-observacion');
                mensaje_error.innerText = mensaje;
                break;
            default: break;
        }//switch

    }

    clearMensajeErrorCampos() {
        let mensaje_error;

        mensaje_error = document.getElementById('error-estado_del_asociado');
        mensaje_error.innerText = "";

        mensaje_error = document.getElementById('error-imagen');
        mensaje_error.innerText = "";

        mensaje_error = document.getElementById('error-nombres');
        mensaje_error.innerText = "";

        mensaje_error = document.getElementById('error-apellidos');
        mensaje_error.innerText = "";

        mensaje_error = document.getElementById('error-ci');
        mensaje_error.innerText = "";

        mensaje_error = document.getElementById('error-ci_valido');
        mensaje_error.innerText = "";

        mensaje_error = document.getElementById('error-fecha_de_nacimiento');
        mensaje_error.innerText = "";

        mensaje_error = document.getElementById('error-lugar_de_nacimiento');
        mensaje_error.innerText = "";

        mensaje_error = document.getElementById('error-estado_civil');
        mensaje_error.innerText = "";

        mensaje_error = document.getElementById('error-sexo');
        mensaje_error.innerText = "";

        mensaje_error = document.getElementById('error-celular');
        mensaje_error.innerText = "";

        //section origen de la procedencia

        mensaje_error = document.getElementById('error-punta_de_trabajo');
        mensaje_error.innerText = "";

        mensaje_error = document.getElementById('error-grupo');
        mensaje_error.innerText = "";

        mensaje_error = document.getElementById('error-fecha_de_transferencia');
        mensaje_error.innerText = "";

        mensaje_error = document.getElementById('error-susecion_de_derecho');
        mensaje_error.innerText = "";

        mensaje_error = document.getElementById('error-transfiriente_cc');
        mensaje_error.innerText = "";

        mensaje_error = document.getElementById('error-parentesco');
        mensaje_error.innerText = "";

        mensaje_error = document.getElementById('error-observacion');
        mensaje_error.innerText = "";
    }


    clearInputsForm() {
        let input_form;
        //se incrementa el numero de registro
        input_form = document.getElementsByName('num_reg__');
        let number = parseInt(input_form[0].value) + 1;
        number = number.toString().padStart(5, '0');
        input_form[0].value = number;

        input_form = document.getElementsByName('estado_del_asociado');
        input_form[0].value = '';

        input_form = document.getElementsByName('imagen');
        input_form[0].value = '';
        let vista_previa = document.getElementById('vista-previa');
        vista_previa.src = "../assets/images/image-preview.png";


        input_form = document.getElementsByName('nombres');
        input_form[0].value = '';

        input_form = document.getElementsByName('apellidos');
        input_form[0].value = '';

        input_form = document.getElementsByName('ci');
        input_form[0].value = '';

        input_form = document.getElementsByName('ci_valido');
        input_form[0].value = this.formatFechaHTML();

        input_form = document.getElementsByName('fecha_de_nacimiento');
        input_form[0].value = '1990-01-01';

        input_form = document.getElementsByName('lugar_de_nacimiento');
        input_form[0].value = '';

        input_form = document.getElementsByName('estado_civil');
        input_form[0].value = '';

        input_form = document.getElementsByName('sexo');
        input_form[0].value = '';

        input_form = document.getElementsByName('celular');
        input_form[0].value = '';

        //section origen de la procedencia

        input_form = document.getElementsByName('punta_de_trabajo');
        input_form[0].value = '';

        input_form = document.getElementsByName('grupo');
        input_form[0].value = '';

        input_form = document.getElementsByName('fecha_de_transferencia');
        input_form[0].value = this.formatFechaHTML();

        input_form = document.getElementsByName('susecion_de_derecho');
        input_form[0].value = '';

        input_form = document.getElementsByName('transfiriente_cc');
        input_form[0].value = '';

        input_form = document.getElementsByName('parentesco');
        input_form[0].value = '';

        input_form = document.getElementsByName('observacion');
        input_form[0].value = '';
    }


    store() {
        let datos_formulario = new FormData(this.form);
        fetch(this.url + this.store_url, {
            method: 'post',
            body: datos_formulario
        }).then(response => response.json()).then(result => {
            this.clearMensajeErrorCampos();

            if (result.status_code == 401) {
                this.viewPopupMessage('error', 'Acceso no autorizado',result.message);
                console.log(result);
                return;
            }

            if (result.errors_db == true) {
                this.viewPopupMessage('error', 'Error', 'Error al registrar!');
                console.log(result);
                return;
            }

            if (result.errors_campos == true) {
                for (let campo in result['errors_campos_messages']) {
                    this.viewMensajeErrorCampos(campo, result['errors_campos_messages'][campo][0]);
                }
                this.viewPopupMessage('auto-popup-error', 'Verificar Campos', 'Los datos introducidos son incorrectos!');
            } else {
                this.clearInputsForm();
                this.viewPopupMessage('sucess', 'Registrado', 'El registro se guardo correctamente!');
            }
        }).catch(() => {
            this.viewPopupMessage('error', 'Error Inesperado', 'Error inesperado al guardar el registro!');
   
        });

    }//store

    confirmDestroy() {
        this.viewPopupMessage('confirm-delete', 'Confirmar', '¿Esta seguro de eliminar este registro?');
    }

    destroy() {
        //en btn-accion se encuentra el valor del id => data-id
        let id = document.getElementById('btn-accion').dataset.id;
        let dato = new FormData();
        dato.append('id', id);
        fetch(this.url + this.destroy_url, {
            method: 'post',
            body: dato,
        }).then(response => response.json()).then(result => {

            if (result.status_code == 401) {
                this.viewPopupMessage('error', 'Acceso no autorizado',result.message);
                console.log(result);
                return;
            }

            if (result.errors_db == true) {
                this.viewPopupMessage('error', 'Acceso no autorizado',result.message);
                console.log(result);
            } else {
                // let   base_url = window.location.hostname
                let base_url = window.location.host

                window.location.replace('http://' + base_url + this.index_url);
                console.log(base_url + this.index_url);
            }

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
            this.clearMensajeErrorCampos();
            if (result.status_code == 401) {
                this.viewPopupMessage('error', 'Acceso no autorizado',result.message);
                console.log(result);
                return;
            }

            if (result.errors_campos == true) {
                for (let campo in result['errors_campos_messages']) {
                    this.viewMensajeErrorCampos(campo, result['errors_campos_messages'][campo][0]);
                }
                this.viewPopupMessage('auto-popup-error', 'Verificar Campos', 'Los datos introducidos son incorrectos!');
                return;
            }

            if (result.errors_db == true) {
                this.viewPopupMessage('error', 'Error', 'Ocurrio un error al actualizar este registro!');
                console.log(result);
                return;
            }

            this.viewPopupMessage('sucess', 'Registro Actualizado', 'El registro se actualizo correctamente!');
        }).catch(function () {

            this.viewPopupMessage('error', 'Error Inesperado', 'Ocurrio un error inesperado al actualizar este registro!');
        });

    }//update

}//class


let btn_enviar = document.getElementById('btn-accion');
let container_popup = document.querySelector('.container-popup-hidden');

// al utilizar fetch no es necesario enviar la url 'http://localhost:4000' javascript optiene la url por si solo pero en caso 
//si da errores  ahi talvez se nesesite enviar la url => uri=http://localhost:4000
let uri = "";
let uri_store = "/api/store-socios";
let uri_update = "/api/update-socios";
let uri_destroy = "/api/destroy-socios";
let uri_index = "/socios";


let socios = new Socios(container_popup, null, uri, uri_store, uri_update, uri_destroy, uri_index);

btn_enviar.addEventListener('click', () => {

    let action = btn_enviar.dataset.accion;
    let form_data = "";
    switch (action) {
        case 'store':
            form_data = document.getElementById('mi-form');
            socios.setForm = form_data;
            socios.store();
            break;

        case 'confirm-destroy':
            socios.confirmDestroy();
            break;

        case 'update':
            form_data = document.getElementById('mi-form');
            socios.setForm = form_data;
            socios.update();
            break;

        default:
            console.log('NO HAY NINGUNA ACCION');
            break;
    }
});


