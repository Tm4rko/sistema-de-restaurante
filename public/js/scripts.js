

function soloLetras(event) {
    var key = event.key;
    var regex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]*$/;
    if (regex.test(key) || event.keyCode === 8 || event.keyCode === 32) {
        return true;
    } else {
        event.preventDefault();
        return false;
    }
}


function evitarLetraE(event) {
    var key = event.key;
    // Prevenir la entrada de la letra 'e' y 'E', y otros caracteres no numéricos
    if (key === 'e' || key === 'E' || key === '+' || key === '-') {
        event.preventDefault();
    }
}

function evitarPunto(event) {
    var key = event.key;
    // Prevenir la entrada de la letra 'e' y 'E', y otros caracteres no numéricos
    if (key === 'e' || key === 'E' || key === '+' || key === '-' || key === '.') {
        event.preventDefault();
    }
}




