class CerrarSesion {
    constructor(popup, url, url_destroy_sesion) {
        this.popup = popup;
        this.url = url;
        this.url_destroy_sesion = url_destroy_sesion;
     this.timeoutId=null;
    }

    confirmDestroySesion() {
        let btn_aceptar = "";
        let btn_cancelar = "";

        let data = `<div class="popup">
                               <i class="zmdi zmdi-lock-outline" style="color: #d40505;"></i>
                               <h2 style="color:#ff0000;">Cerrar Sesion</h2>
                               <p>¿Esta seguro de salir del sistema?</p>
                               <div class="popup-btn">
                                    <button type="button" class="btn-aceptar">Aseptar</button>
                                    <button type="button" class="btn-cancelar">Cancelar</button>
                                </div>
                        </div>`;
        this.popup.innerHTML = data;
        btn_aceptar = document.querySelector(".btn-aceptar");
        btn_cancelar = document.querySelector(".btn-cancelar");


        //verificar y eliminar si el popup auto existe instanciadas de otras clases
        this.popup.classList.remove('container-popup-auto');


        this.popup.classList.add("container-popup");
        //para cerrar el popup con animacion
        btn_aceptar.addEventListener("click", () => {
            let popup_mensaje = document.querySelector(".popup");
            popup_mensaje.style.animation = "popup-close 1s forwards";
            //luego que se iso la animacion ahora recien eliminamos la clase

      
         this.timeoutId= setTimeout(() => {
                this.popup.classList.remove("container-popup");
                this.popup.innerHTML = "";

                //el usuario confirmo
                this.destroySesion();
            }, 500);

        

        });

        //para cerrar el popup con animacion
        btn_cancelar.addEventListener("click", () => {
            let popup_mensaje = document.querySelector(".popup");
            popup_mensaje.style.animation = "popup-close 1s forwards";
            //luego que se iso la animacion ahora recien eliminamos la clase
            setTimeout(() => {
                this.popup.classList.remove("container-popup");
                this.popup.innerHTML = "";
                //el usuario cancelo la peticion
                console.log("eliminacion cancelada");
            }, 500);
        });
    }

    destroySesion() {
        //  let id = document.getElementById('btn-accion').dataset.id;
        fetch(this.url + this.url_destroy_sesion, {
            method: "get",
        })
            .then((response) => response.json())
            .then((result) => {
                if (result.sucess == true) {
                    //  let   base_url = window.location.hostname
                    let base_url = window.location.host;
                    window.location.replace("http://" + base_url);
                }
            });
    }
} //class
let btn_sesion = document.getElementById("btn-sesion");
let container_popup_message = document.querySelector(".container-popup-hidden");

// al utilizar fetch no es necesario enviar la url 'http://localhost:4000' javascript optiene la url por si solo pero en caso
//si da errores  ahi talvez se nesesite enviar la url => uri=http://localhost:4000
let uri_base = "";
let uri_destroy_sesion = "/cerrar-sesion";

let cerrar_sesion = new CerrarSesion(
    container_popup_message,
    uri_base,
    uri_destroy_sesion
);
btn_sesion.addEventListener("click", () => {
    cerrar_sesion.confirmDestroySesion();
    // console.log(document.cookie)
});
