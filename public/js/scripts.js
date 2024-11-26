

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

function soloNumeros(event) {
    var key = event.key;
    var regex = /^[0-9]$/; // Permite solo números
    var specialKeys = [8, 46, 37, 39]; // 8 para backspace, 46 para delete, 37 y 39 para las flechas izquierda y derecha

    if (!regex.test(key) && !specialKeys.includes(event.keyCode)) {
        event.preventDefault();
        return false;
    }
    return true;
}

function bloquearEspacios(event) {
    if (event.keyCode === 32) { // 32 es el código de la barra espaciadora
        event.preventDefault();
        return false;
    }
    return true;
}

function validarEmail(event) {
    var key = event.key;
    var regex = /^[a-zA-Z0-9@._-]+$/; // Permite letras, números, arroba, punto, guion bajo y guion

    if (!regex.test(key) && event.keyCode !== 8 && event.keyCode !== 46 && event.keyCode !== 37 && event.keyCode !== 39) {
        // Si la tecla no coincide con el regex y no es backspace (8), delete (46), flecha izquierda (37) o flecha derecha (39)
        event.preventDefault();
        return false;
    }
    return true;
}














