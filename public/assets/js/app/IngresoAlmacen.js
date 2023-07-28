
class IngresoAlmacen {

    constructor(popup, form,fila_table_delete, url, store_url, update_url, destroy_url, index_url) {
        this.popup = popup;
        this.url = url;
        this.store_url = store_url;
        this.update_url = update_url;
        this.destroy_url = destroy_url;
        this.form = form;
        this.index_url = index_url;
        this.fila_table_delete = fila_table_delete;
    }

    /**
     * @param {FormData} form
     */
    set setForm(form) {
        this.form = form;
    }

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
            case 'n_de_documento':
                mensaje_error = document.getElementById('error-n_de_documento');
                mensaje_error.innerText = mensaje;
                break;
            case 'cantidad':
                mensaje_error = document.getElementById('error-cantidad');
                mensaje_error.innerText = mensaje;
                break;
            case 'um':
                mensaje_error = document.getElementById('error-um');
                mensaje_error.innerText = mensaje;
                break;
            case 'costo_unitario':
                mensaje_error = document.getElementById('error-costo_unitario');
                mensaje_error.innerText = mensaje;
                break;

            case 'divisa_costo_unitario':
                mensaje_error = document.getElementById('error-divisa_costo_unitario');
                mensaje_error.innerText = mensaje;
                break;

            case 'total':
                mensaje_error = document.getElementById('error-total');
                mensaje_error.innerText = mensaje;
                break;

            case 'divisa_total':
                mensaje_error = document.getElementById('error-divisa_total');
                mensaje_error.innerText = mensaje;
                break;

            case 'descripcion':
                mensaje_error = document.getElementById('error-descripcion');
                mensaje_error.innerText = mensaje;
                break;

            case 'codigo':
                mensaje_error = document.getElementById('error-codigo');
                mensaje_error.innerText = mensaje;
                break;

            case 'marca':
                mensaje_error = document.getElementById('error-marca');
                mensaje_error.innerText = mensaje;
                break;
            case 'proveedor':
                mensaje_error = document.getElementById('error-proveedor');
                mensaje_error.innerText = mensaje;
                break;

            case 'entregado_por':
                mensaje_error = document.getElementById('error-entregado_por');
                mensaje_error.innerText = mensaje;
                break;
            default: break;
        }//switch
    }

    clearMensajeErrorCampos() {
        let mensaje_error;
     
            mensaje_error = document.getElementById('error-n_de_documento');
            mensaje_error.innerText = "";
   
            mensaje_error = document.getElementById('error-cantidad');
            mensaje_error.innerText = "";
      
            mensaje_error = document.getElementById('error-um');
            mensaje_error.innerText = "";
   
            mensaje_error = document.getElementById('error-costo_unitario');
            mensaje_error.innerText = "";
    
            mensaje_error = document.getElementById('error-divisa_costo_unitario');
            mensaje_error.innerText = "";
    
            mensaje_error = document.getElementById('error-total');
            mensaje_error.innerText = "";
       
            mensaje_error = document.getElementById('error-divisa_total');
            mensaje_error.innerText = "";
       
            mensaje_error = document.getElementById('error-descripcion');
            mensaje_error.innerText = "";
       
            mensaje_error = document.getElementById('error-codigo');
            mensaje_error.innerText = "";
       
            mensaje_error = document.getElementById('error-marca');
            mensaje_error.innerText = "";
      
            mensaje_error = document.getElementById('error-proveedor');
            mensaje_error.innerText = "";
    
            mensaje_error = document.getElementById('error-entregado_por');
            mensaje_error.innerText = "";

    }

    clearInputsForm() {

        let input_form;
        //se incrementa el numero de registro
        input_form = document.getElementsByName('numero-de-registro');
        let number = parseInt(input_form[0].value) + 1;
        number = number.toString().padStart(5, '0');
        input_form[0].value = number;

        input_form = document.getElementsByName('n_de_documento');
        input_form[0].value = ""

        input_form = document.getElementsByName('cantidad');
        input_form[0].value = '';

        input_form = document.getElementsByName('um');
        input_form[0].value = '';

        input_form = document.getElementsByName('costo_unitario');
        input_form[0].value = "0.00";

        input_form = document.getElementsByName('divisa_costo_unitario');
        input_form[0].value = 'Bs.';

        input_form = document.getElementsByName('total');
        input_form[0].value = "0.00";

        input_form = document.getElementsByName('divisa_total');
        input_form[0].value = 'Bs.';

        input_form = document.getElementsByName('descripcion');
        input_form[0].value = '';

        input_form = document.getElementsByName('codigo');
        input_form[0].value = '';


        input_form = document.getElementsByName('marca');
        input_form[0].value = '';

        input_form = document.getElementsByName('proveedor');
        input_form[0].value = '';

        input_form = document.getElementsByName('entregado_por');
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

            } else {
                // let   base_url = window.location.hostname
            //    let base_url = window.location.host

              //  window.location.replace('http://' + base_url + this.index_url);
              this.fila_table_delete.remove();
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

}//class


let container_popup = document.querySelector('.container-popup-hidden');

// al utilizar fetch no es necesario enviar la url 'http://localhost:4000' javascript optiene la url por si solo pero en caso 
//si da errores  ahi talvez se nesesite enviar la url => uri=http://localhost:4000
let uri = "";
let uri_store = "/api/store-ingreso-almacen";
let uri_update = "/api/update-ingreso-almacen";
let uri_destroy = "/api/destroy-ingreso-almacen";
let uri_index = "/ingreso-almacen";

let ingreso_almacen = new IngresoAlmacen(container_popup, null,null, uri, uri_store, uri_update, uri_destroy, uri_index);

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
            ingreso_almacen.setForm = form_data;
            ingreso_almacen.store();
            break;

        case 'update':
            form_data = document.getElementById('mi-form');
            ingreso_almacen.setForm = form_data;
            ingreso_almacen.update();
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
    ingreso_almacen.setForm = form_data;
    ingreso_almacen.setFilaTableDelete = fila;
    ingreso_almacen.confirmDestroy();

});



