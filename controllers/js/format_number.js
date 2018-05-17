//formateo de enteros con miles

/* -------------- FUNCIONES DE SETEO ---------------------------*/
function borraCaracter1(valor) {
    valor = valor.replace(/\./g,""); // BORRO LOS PUNTOS
    valor = valor.replace(/\,/g,"."); // REMPLAZO COMA POR PUNTO.
    return valor;
}
//Cadena de numeros sin puntos ni comas
function borraPunto(valor) {
    valor = valor.replace(/\./g,""); // BORRO LOS PUNTOS
    valor = valor.replace(/\,/g,""); // BORRO COMAS
    return valor;
}
//Formato sin decimal
function format_valores(id) {
    var valor = document.getElementById(id).value; //RECOJO VALOR DEL CAMPO
    valor = borraCaracter1(valor); //BORRO LOS PUNTOS Y REEMPLAZO COMA POR PUNTO
    if(isNaN(valor)) {
        alert("Ingrese sólo valores numéricos.");
        valor = "";
        document.getElementById(id).value = valor;
    } else {
        valor = parseFloat(valor).toLocaleString("es-CL", { maximumFractionDigits: 0});
        document.getElementById(id).value = valor;
    }
    return valor;
}