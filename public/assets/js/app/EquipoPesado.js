
class EquipoPesado {

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
            //datos generales
            case 'nombre_comun_del_equipo':
                mensaje_error = document.getElementById('error-nombre_comun_del_equipo');
                mensaje_error.innerText = mensaje;
                break;
            case 'codigo_de_inventario_interno':
                mensaje_error = document.getElementById('error-codigo_de_inventario_interno');
                mensaje_error.innerText = mensaje;
                break;
            //datos de origen
            case 'fabricante':
                mensaje_error = document.getElementById('error-fabricante');
                mensaje_error.innerText = mensaje;
                break;
            case 'ano_vencimiento_de_garantia':
                mensaje_error = document.getElementById('error-ano_vencimiento_de_garantia');
                mensaje_error.innerText = mensaje;
                break;

            case 'ano_de_fabricacion':
                mensaje_error = document.getElementById('error-ano_de_fabricacion');
                mensaje_error.innerText = mensaje;
                break;

            case 'pais_de_origen':
                mensaje_error = document.getElementById('error-pais_de_origen');
                mensaje_error.innerText = mensaje;
                break;

            case 'modelo':
                mensaje_error = document.getElementById('error-modelo');
                mensaje_error.innerText = mensaje;
                break;

            case 'numero_de_serie':
                mensaje_error = document.getElementById('error-numero_de_serie');
                mensaje_error.innerText = mensaje;
                break;


            case 'ano_de_compra':
                mensaje_error = document.getElementById('error-ano_de_compra');
                mensaje_error.innerText = mensaje;
                break;
            //datos de uso en planta
            case 'ano_de_alta_planta':
                mensaje_error = document.getElementById('error-ano_de_alta_planta');
                mensaje_error.innerText = mensaje;
                break;
            case 'estado_del_equipo_al_momento_de_alta':
                mensaje_error = document.getElementById('error-estado_del_equipo_al_momento_de_alta');
                mensaje_error.innerText = mensaje;
                break;
            case 'horometro_al_inicio_operacion_planta':
                mensaje_error = document.getElementById('error-horometro_al_inicio_operacion_planta');
                mensaje_error.innerText = mensaje;
                break;
            case 'linea_de_produccion_asignada':
                mensaje_error = document.getElementById('error-linea_de_produccion_asignada');
                mensaje_error.innerText = mensaje;
                break;
            case 'ubicacion':
                mensaje_error = document.getElementById('error-ubicacion');
                mensaje_error.innerText = mensaje;
                break;
            //registro fotografico

            case 'archivo':
                mensaje_error = document.getElementById('error-archivo');
                mensaje_error.innerText = mensaje;
                break;
            //datos tecnicos
            case 'potencia_und':
                mensaje_error = document.getElementById('error-potencia_und');
                mensaje_error.innerText = mensaje;
                break;
            case 'potencia_valor_nominal':
                mensaje_error = document.getElementById('error-potencia_valor_nominal');
                mensaje_error.innerText = mensaje;
                break;
            case 'potencia_caracteristicas':
                mensaje_error = document.getElementById('error-potencia_caracteristicas');
                mensaje_error.innerText = mensaje;
                break;

            case 'voltaje_und':
                mensaje_error = document.getElementById('error-voltaje_und');
                mensaje_error.innerText = mensaje;
                break;
            case 'voltaje_valor_nominal':
                mensaje_error = document.getElementById('error-voltaje_valor_nominal');
                mensaje_error.innerText = mensaje;
                break;
            case 'voltaje_caracteristicas':
                mensaje_error = document.getElementById('error-voltaje_caracteristicas');
                mensaje_error.innerText = mensaje;
                break;

            case 'corriente_und':
                mensaje_error = document.getElementById('error-corriente_und');
                mensaje_error.innerText = mensaje;
                break;
            case 'corriente_valor_nominal':
                mensaje_error = document.getElementById('error-corriente_valor_nominal');
                mensaje_error.innerText = mensaje;
                break;
            case 'corriente_caracteristicas':
                mensaje_error = document.getElementById('error-corriente_caracteristicas');
                mensaje_error.innerText = mensaje;
                break;

            case 'capacidad_de_cucharon_und':
                mensaje_error = document.getElementById('error-capacidad_de_cucharon_und');
                mensaje_error.innerText = mensaje;
                break;
            case 'capacidad_de_cucharon_valor_nominal':
                mensaje_error = document.getElementById('error-capacidad_de_cucharon_valor_nominal');
                mensaje_error.innerText = mensaje;
                break;
            case 'capacidad_de_cucharon_caracteristicas':
                mensaje_error = document.getElementById('error-capacidad_de_cucharon_caracteristicas');
                mensaje_error.innerText = mensaje;
                break;
            case 'capacidad_de_diesel_und':
                mensaje_error = document.getElementById('error-capacidad_de_diesel_und');
                mensaje_error.innerText = mensaje;
                break;
            case 'capacidad_de_diesel_valor_nominal':
                mensaje_error = document.getElementById('error-capacidad_de_diesel_valor_nominal');
                mensaje_error.innerText = mensaje;
                break;
            case 'capacidad_de_diesel_caracteristicas':
                mensaje_error = document.getElementById('error-capacidad_de_diesel_caracteristicas');
                mensaje_error.innerText = mensaje;
                break;

            case 'otros_und':
                mensaje_error = document.getElementById('error-otros_und');
                mensaje_error.innerText = mensaje;
                break;
            case 'otros_valor_nominal':
                mensaje_error = document.getElementById('error-otros_valor_nominal');
                mensaje_error.innerText = mensaje;
                break;
            case 'otros_caracteristicas':
                mensaje_error = document.getElementById('error-otros_caracteristicas');
                mensaje_error.innerText = mensaje;
                break;
            //disponibilidad de informacion de soporte tecnico
            case 'manuales_impresos':
                mensaje_error = document.getElementById('error-manuales_impresos');
                mensaje_error.innerText = mensaje;
                break;
            case 'manuales_digitales':
                mensaje_error = document.getElementById('error-manuales_digitales');
                mensaje_error.innerText = mensaje;
                break;
            case 'otros_manuales':
                mensaje_error = document.getElementById('error-otros_manuales');
                mensaje_error.innerText = mensaje;
                break;
            case 'planos_mecanicos_digitales':
                mensaje_error = document.getElementById('error-planos_mecanicos_digitales');
                mensaje_error.innerText = mensaje;
                break;

            case 'planos_electricos_digitales':
                mensaje_error = document.getElementById('error-planos_electricos_digitales');
                mensaje_error.innerText = mensaje;
                break;
            case 'otros_planos':
                mensaje_error = document.getElementById('error-otros_planos');
                mensaje_error.innerText = mensaje;
                break;

            default: break;

        }//switch
    }

    clearMensajeErrorCampos() {
        let mensaje_error;

        mensaje_error = document.getElementById('error-nombre_comun_del_equipo');
        mensaje_error.innerText = '';

        mensaje_error = document.getElementById('error-codigo_de_inventario_interno');
        mensaje_error.innerText = '';

        //datos de origen
        mensaje_error = document.getElementById('error-fabricante');
        mensaje_error.innerText = '';

        mensaje_error = document.getElementById('error-ano_vencimiento_de_garantia');
        mensaje_error.innerText = '';

        mensaje_error = document.getElementById('error-ano_de_fabricacion');
        mensaje_error.innerText = '';

        mensaje_error = document.getElementById('error-pais_de_origen');
        mensaje_error.innerText = '';

        mensaje_error = document.getElementById('error-modelo');
        mensaje_error.innerText = '';

        mensaje_error = document.getElementById('error-numero_de_serie');
        mensaje_error.innerText = '';

        mensaje_error = document.getElementById('error-ano_de_compra');
        mensaje_error.innerText = '';

        //datos de uso en planta

        mensaje_error = document.getElementById('error-ano_de_alta_planta');
        mensaje_error.innerText = '';

        mensaje_error = document.getElementById('error-estado_del_equipo_al_momento_de_alta');
        mensaje_error.innerText = '';

        mensaje_error = document.getElementById('error-horometro_al_inicio_operacion_planta');
        mensaje_error.innerText = '';

        mensaje_error = document.getElementById('error-linea_de_produccion_asignada');
        mensaje_error.innerText = '';

        mensaje_error = document.getElementById('error-ubicacion');
        mensaje_error.innerText = '';

        //registro fotografico
        mensaje_error = document.getElementById('error-archivo');
        mensaje_error.innerText = '';

        //datos tecnicos

        mensaje_error = document.getElementById('error-potencia_und');
        mensaje_error.innerText = '';

        mensaje_error = document.getElementById('error-potencia_valor_nominal');
        mensaje_error.innerText = '';

        mensaje_error = document.getElementById('error-potencia_caracteristicas');
        mensaje_error.innerText = '';

        mensaje_error = document.getElementById('error-voltaje_und');
        mensaje_error.innerText = '';

        mensaje_error = document.getElementById('error-voltaje_valor_nominal');
        mensaje_error.innerText = '';

        mensaje_error = document.getElementById('error-voltaje_caracteristicas');
        mensaje_error.innerText = '';

        mensaje_error = document.getElementById('error-corriente_und');
        mensaje_error.innerText = '';

        mensaje_error = document.getElementById('error-corriente_valor_nominal');
        mensaje_error.innerText = '';

        mensaje_error = document.getElementById('error-corriente_caracteristicas');
        mensaje_error.innerText = '';

        mensaje_error = document.getElementById('error-capacidad_de_cucharon_und');
        mensaje_error.innerText = '';

        mensaje_error = document.getElementById('error-capacidad_de_cucharon_valor_nominal');
        mensaje_error.innerText = '';

        mensaje_error = document.getElementById('error-capacidad_de_cucharon_caracteristicas');
        mensaje_error.innerText = '';

        mensaje_error = document.getElementById('error-capacidad_de_diesel_und');
        mensaje_error.innerText = '';

        mensaje_error = document.getElementById('error-capacidad_de_diesel_valor_nominal');
        mensaje_error.innerText = '';

        mensaje_error = document.getElementById('error-capacidad_de_diesel_caracteristicas');
        mensaje_error.innerText = '';

        mensaje_error = document.getElementById('error-otros_und');
        mensaje_error.innerText = '';

        mensaje_error = document.getElementById('error-otros_valor_nominal');
        mensaje_error.innerText = '';

        mensaje_error = document.getElementById('error-otros_caracteristicas');
        mensaje_error.innerText = '';

        //disponibilidad de informacion de soporte tecnico

        mensaje_error = document.getElementById('error-manuales_impresos');
        mensaje_error.innerText = '';

        mensaje_error = document.getElementById('error-manuales_digitales');
        mensaje_error.innerText = '';

        mensaje_error = document.getElementById('error-otros_manuales');
        mensaje_error.innerText = '';

        mensaje_error = document.getElementById('error-planos_mecanicos_digitales');
        mensaje_error.innerText = '';

        mensaje_error = document.getElementById('error-planos_electricos_digitales');
        mensaje_error.innerText = '';

        mensaje_error = document.getElementById('error-otros_planos');
        mensaje_error.innerText = '';


}

clearInputsForm() {

    let input_form;
    //datos generales
    input_form = document.getElementsByName('nombre_comun_del_equipo');
    input_form[0].value = "";

    input_form = document.getElementsByName('codigo_de_inventario_interno');
    input_form[0].value = '';
    //datos de origen
    input_form = document.getElementsByName('fabricante');
    input_form[0].value = '';

    input_form = document.getElementsByName('ano_vencimiento_de_garantia');
    input_form[0].value = '';

    input_form = document.getElementsByName('ano_de_fabricacion');
    input_form[0].value = '';

    input_form = document.getElementsByName('pais_de_origen');
    input_form[0].value = '';

    input_form = document.getElementsByName('modelo');
    input_form[0].value = '';


    input_form = document.getElementsByName('numero_de_serie');
    input_form[0].value = '';

    input_form = document.getElementsByName('ano_de_compra');
    input_form[0].value = '';

    //datos de uso en planta
    input_form = document.getElementsByName('ano_de_alta_planta');
    input_form[0].value = '';

    input_form = document.getElementsByName('estado_del_equipo_al_momento_de_alta');
    input_form[0].value = '';

    input_form = document.getElementsByName('horometro_al_inicio_operacion_planta');
    input_form[0].value = '';

    input_form = document.getElementsByName('linea_de_produccion_asignada');
    input_form[0].value = '';

    input_form = document.getElementsByName('ubicacion');
    input_form[0].value = '';


    //registro fotografico
    input_form = document.getElementsByName('archivo');
    input_form[0].value = '';

    let vista_previa = document.getElementById('vista-previa');
    vista_previa.src = "../assets/images/image-preview.png";

    //datos tecnicos
    input_form = document.getElementsByName('potencia_und');
    input_form[0].value = '';

    input_form = document.getElementsByName('potencia_valor_nominal');
    input_form[0].value = '';

    input_form = document.getElementsByName('potencia_caracteristicas');
    input_form[0].value = '';

    input_form = document.getElementsByName('voltaje_und');
    input_form[0].value = '';

    input_form = document.getElementsByName('voltaje_valor_nominal');
    input_form[0].value = '';

    input_form = document.getElementsByName('voltaje_caracteristicas');
    input_form[0].value = '';

    input_form = document.getElementsByName('corriente_und');
    input_form[0].value = '';

    input_form = document.getElementsByName('corriente_valor_nominal');
    input_form[0].value = '';

    input_form = document.getElementsByName('corriente_caracteristicas');
    input_form[0].value = '';

    input_form = document.getElementsByName('capacidad_de_cucharon_und');
    input_form[0].value = '';

    input_form = document.getElementsByName('capacidad_de_cucharon_valor_nominal');
    input_form[0].value = '';

    input_form = document.getElementsByName('capacidad_de_cucharon_caracteristicas');
    input_form[0].value = '';


    input_form = document.getElementsByName('capacidad_de_diesel_und');
    input_form[0].value = '';

    input_form = document.getElementsByName('capacidad_de_diesel_valor_nominal');
    input_form[0].value = '';

    input_form = document.getElementsByName('capacidad_de_diesel_caracteristicas');
    input_form[0].value = '';

    input_form = document.getElementsByName('otros_und');
    input_form[0].value = '';

    input_form = document.getElementsByName('otros_valor_nominal');
    input_form[0].value = '';

    input_form = document.getElementsByName('otros_caracteristicas');
    input_form[0].value = '';

    //disponibilidad de informacion de soporte tecnico
    input_form = document.getElementsByName('manuales_impresos');
    input_form[0].value = '';

    input_form = document.getElementsByName('manuales_digitales');
    input_form[0].value = '';

    input_form = document.getElementsByName('otros_manuales');
    input_form[0].value = '';

    input_form = document.getElementsByName('planos_mecanicos_digitales');
    input_form[0].value = '';

    input_form = document.getElementsByName('planos_electricos_digitales');
    input_form[0].value = '';

    input_form = document.getElementsByName('otros_planos');
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
    //en btn-accion se encuentra el valor del id => data-id
    let id = document.getElementById('btn-accion').dataset.id_reg;

    let dato = new FormData();
    dato.append('id-reg', id);
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
            this.viewPopupMessage('error', 'Error', 'Ocurrio un error al eliminar este registro!');
            console.log(result);

        } else {
            // let   base_url = window.location.hostname
            let base_url = window.location.host

            window.location.replace('http://' + base_url + this.index_url);
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


let btn_enviar = document.getElementById('btn-accion');
let container_popup = document.querySelector('.container-popup-hidden');

// al utilizar fetch no es necesario enviar la url 'http://localhost:4000' javascript optiene la url por si solo pero en caso 
//si da errores  ahi talvez se nesesite enviar la url => uri=http://localhost:4000
let uri = "";
let uri_store = "/api/store-equipo-pesado";
let uri_update = "/api/update-equipo-pesado";
let uri_destroy = "/api/destroy-equipo-pesado";
let uri_index = "/equipo-pesado";

let equipo_pesado = new EquipoPesado(container_popup, null, uri, uri_store, uri_update, uri_destroy, uri_index);

btn_enviar.addEventListener('click', () => {

    let accion = btn_enviar.dataset.action;
    let form_data = "";
    switch (accion) {
        case 'store':
            form_data = document.getElementById('mi-form');
            equipo_pesado.setForm = form_data;
            equipo_pesado.store();
            break;

        case 'confirm-destroy':
            equipo_pesado.confirmDestroy();
            break;

        case 'update':
            form_data = document.getElementById('mi-form');
            equipo_pesado.setForm = form_data;
            equipo_pesado.update();
            break;

        default:
            console.log('NO HAY NINGUNA ACCION');
            break;
    }
});


