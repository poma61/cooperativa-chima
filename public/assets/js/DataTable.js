
class DataTable {
    constructor(tabla, rows, select_view_pages, input_buscar) {
        this.input_buscar = input_buscar;
        this.tabla = tabla;
        this.pag_actual = 1;
        this.rows = rows;
        this.paginas = Math.floor((this.tabla.rows.length - 1) / this.rows) + 1;
        this.select_view_pages = select_view_pages;
    }
    set setTabla(tabla) {
        this.tabla = tabla;
    }
    set setRows(rows) {
        this.rows = rows;
    }

    set setPaginas(paginas) {
        this.paginas = paginas;
        this.pag_actual = 1;
    }

    setViewPageTable(tipo_btn) {
        switch (tipo_btn) {
            case 'anterior':
                if (this.pag_actual != 1) {
                    this.pag_actual--;
                } else {
                    return;
                }

                break;

            case 'siguiente':
                if (this.pag_actual != this.paginas) {
                    this.pag_actual++;
                } else {
                    return;
                }
                break;

            case "paginado":
                this.pag_actual = parseInt(this.select_view_pages.value);
                break;

            default: break;
        }

        let min_row = 1 + ((this.pag_actual - 1) * this.rows);
        let max_row = min_row + this.rows - 1;

        //mostrar el numero de pagina correspondiente
        for (let k = 0; k < this.select_view_pages.options.length; k++) {
            if (k + 1 == this.pag_actual) {
                this.select_view_pages.options[k].setAttribute('selected', '');
            } else {
               
                this.select_view_pages.options[k].removeAttribute('selected');
            }
        }
       
        for (let i = 1; i < this.tabla.rows.length; i++) {
            if (i >= min_row && i <= max_row) {
                this.tabla.rows[i].style.display = '';
            } else {
                this.tabla.rows[i].style.display = 'none';
            }
        }
    }//metodo

    setCantidadPagesTable(actualizar) {
        if (actualizar == true) {
            this.select_view_pages.innerHTML = '';
        }

        for (let i = 1; i <= this.paginas; i++) {
            let opcion = document.createElement('option');
            opcion.value = i;
            opcion.text = "Pagina " + i;
            this.select_view_pages.appendChild(opcion);
        }
        this.select_view_pages.options[0].setAttribute('selected', '');
    }

    buscarRegistros(evt) {
        let texto = evt.target.value;

        //para mayusculas y minusculas
        let expresion_regular = new RegExp(texto, "i")
        for (let p = 1; p <= this.tabla.rows.length - 1; p++) {
            let valor = this.tabla.rows[p];
            if (expresion_regular.test(valor.innerText)) {
                valor.style.display = '';
            } else {
                valor.style.display = 'none';
            }
        }
      //si el buscador esta vacio vuelve a mostrar la pagina
      // correspondiente de la tabla
        if(texto==''){
            p.setViewPageTable(null);
        }
    }
}//class

var table = document.getElementById('tabla-datos');
var btn_anterior = document.querySelector('.btn-anterior');
var btn_siguiente = document.querySelector('.btn-siguiente');
var cantidad_rows = document.querySelector('.cantidad-table-rows');
var pages_table = document.querySelector('.total-table-pages');
var input_buscar = document.querySelector('.busqueda');

var p = new DataTable(table, 20, pages_table, input_buscar);
p.setCantidadPagesTable(false);

cantidad_rows.addEventListener('change', function () {

    let cant_rows = parseInt(cantidad_rows.value);
    p.setRows = cant_rows;
    p.setPaginas = Math.floor((table.rows.length - 1) / cant_rows) + 1;
    p.setCantidadPagesTable(true);
    p.setViewPageTable(null);

});


btn_anterior.addEventListener('click', function () {
    p.setViewPageTable('anterior');

});

btn_siguiente.addEventListener('click', function () {
    p.setViewPageTable('siguiente');

});

pages_table.addEventListener('change', function () {
    p.setViewPageTable('paginado');
});


var time_out = null;
input_buscar.addEventListener('keyup', function (evt) {
    clearTimeout(time_out);
    time_out = setTimeout(function () {
        p.buscarRegistros(evt);
    },500);   

});






