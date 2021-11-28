function autocompletar() {
    const  inputProducto = document.querySelector('#producto');
    let indexFocus = -1;
    inputProducto.addEventListener('input', function () {
        const nombreproducto = this.value;
     console.log(nombreproducto);
        if (!nombreproducto)
            return false;
        cerrarlista();
        //lista
        const divList = document.createElement('div');
        divList.setAttribute('id', this.id + '-lista-autocompletar');
        divList.setAttribute('class', 'lista-autocompletar-items');
        this.parentNode.appendChild(divList);
        //conexion a BD
        httpRequest('controlador.php?producto=' + nombreproducto, function () {
            const arreglo = JSON.parse(this.responseText);

            //    validar
            if (arreglo.length == 0)
                return false;
            arreglo.forEach(item => {

                if (item.substr(0, nombreproducto.length) == nombreproducto) {
                    const elementolista = document.createElement('div');
                    elementolista.innerHTML = `<strong> ${item.substr(0, nombreproducto.length)}</strong>${item.substr(nombreproducto.length)} `;
                    elementolista.addEventListener('click', function () {
                        inputProducto.value = this.innerText;
                        cerrarlista();
                        return false;
                    });
                    divList.appendChild(elementolista);
                }
            });
        });

    }
    );
    inputProducto.addEventListener('keydown', function (e) {
        const divList = document.querySelector('#' + this.id + '-lista-autocompletar');
        let items;
        if (divList) {
            items = divList.querySelectorAll('div');
            switch (e.keyCode) {
                case 40: //tecla abajo
                    indexFocus++;
                    if (indexFocus > items.length - 1)
                        indexFocus = items.length - 1;
                    break;
                case 38: //tecla arriba
                    indexFocus--;
                    if (indexFocus < 0)
                        indexFocus = 0;
                    break
                case 13://presionas enter
                    e.preventDefault();
                    items[indexFocus].click();
                    indexFocus = -1;
                    break;
                default:
                    break;
            }
            seleccionar(items, indexFocus);
        }
    });
}
function seleccionar(items, indexFocus) {
    if (!items || indexFocus == -1)
        ;
    items.forEach(x => {
        x.classList.remove('autocompletar-active')
    });
    items[indexFocus].classList.add('autocompletar-active')
}
function cerrarlista() {
    const items = document.querySelectorAll('.lista-autocompletar-items');
    items.forEach(item => {
        item.parentNode.removeChild(item);
    });
    indexFocus = -1;
}
;
function httpRequest(url, callback) {
    const http = new XMLHttpRequest();
    http.open("GET", url);
    http.send();

    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            callback.apply(http);
        }
        ;
    };
}
function mayus(e) {
    e.value = e.value.toUpperCase();
}
autocompletar();

function Hallardescuento()
{
    const input = document.querySelector('#producto');
    const log = document.getElementById('descuento');
    console.log(input.value);
}
