/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//******************************************************************************
//--------------------------VALIDACIÓN FORMULARIO LOGIN-------------------------
//******************************************************************************

function validacionLogin() {
    const form = document.getElementById("login");
    const mail = document.getElementById("email");
    const mailError = document.querySelector('#email + span.error');

    form.addEventListener('submit', function (event) {
        if (!mail.validity.valid) {
            errorMail();
            event.preventDefault();
        }
    });

    mail.addEventListener('blur', function (event) {
        if (mail.validity.valid) {
            mailError.innerHTML = '';
            mailError.className = 'error';
        } else {
            errorMail();
        }
    });

    function errorMail() {
        //Campo vacío
        if (mail.validity.valueMissing) {
            mailError.textContent = 'Debe introducir una dirección de correo electrónico.';
            //No cumple los requisitos del campo email
        } else if (mail.validity.typeMismatch) {
            mailError.textContent = 'El valor introducido debe ser una dirección de correo electrónico.';
            //Datos demasiado cortos
        }
        // Establece el estilo apropiado
        mailError.className = 'error active';
    }


}

//******************************************************************************
//------------------------------------CAPTCHA JS--------------------------------
//******************************************************************************
function captcha() {
    var n = new Array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    var op = new Array('+', '-', '*');
    var i;
    for (i = 0; i < 6; i++) {
        var a = n[Math.floor(Math.random() * n.length)];
        var b = n[Math.floor(Math.random() * n.length)];
        var op = op[Math.floor(Math.random() * op.length)]
    }
    var code = '';
    code = a + op + b;
    creaIMG(code);
    document.cookie = 'code=' + code + ';max-age=120';
}

function validCaptcha(txtInput) {
    var captchaMensaje = document.getElementById("mensajeCaptcha");
    var botonRefrescar = document.getElementById("refresh");
    var txt = document.getElementById("txtInput");
    var code = cargarCookie();
    var string1 = removeSpaces(code);
    var n1 = parseInt(string1.substr(0, 1));
    var op = string1.substr(1, 1);
    var n2 = parseInt(string1.substr(2, 1));
    var rdo;
    var string2 = removeSpaces(document.getElementById(txtInput).value);
    if (op == '+') {
        rdo = n1 + n2;
    }
    if (op == '*') {
        rdo = n1 * n2;
    }
    if (op == '-') {
        rdo = n1 - n2;
    }

    if (rdo == string2) {
        captchaMensaje.innerHTML = "Captcha correcto.";
        captchaMensaje.className = 'error';
        captchaCorrecto = true;
        botonRefrescar.style.visibility = 'hidden';
    } else {
        captchaMensaje.innerHTML = "Captcha incorrecto.";
        captchaMensaje.className = 'error active';
        txt.value = '';
        captcha();
    }
}

function cargarCookie() {
    var nom_cookie, valor_cookie, temp;
    var array_cookies = document.cookie.split('; ');
    for (var i = 0; i < array_cookies.length; i++) {
        temp = array_cookies[i].split('=');
        nom_cookie = temp[0];
        valor_cookie = temp[1];
        return valor_cookie;
    }
}
function removeSpaces(string) {
    return string.split(' ').join('');
}

function creaIMG(texto) {
    var ctxCanvas = document.getElementById('captcha').getContext('2d');
    var fontSize = "30px";
    var fontFamily = "Arial";
    var width = 250;
    var height = 50;
    //tamaño
    ctxCanvas.canvas.width = width;
    ctxCanvas.canvas.height = height;
    //color de fondo
    ctxCanvas.fillStyle = "whitesmoke";
    ctxCanvas.fillRect(0, 0, width, height);
    //puntos de distorsión
    ctxCanvas.setLineDash([7, 10]);
    ctxCanvas.lineDashOffset = 5;
    ctxCanvas.beginPath();
    var line;
    for (var i = 0; i < (width); i++) {
        line = i * 5;
        ctxCanvas.moveTo(line, 0);
        ctxCanvas.lineTo(0, line);
    }
    ctxCanvas.stroke();
    //formato texto
    ctxCanvas.direction = 'ltr';
    ctxCanvas.font = fontSize + " " + fontFamily;
    //texto posicion
    var x = (width / 9);
    var y = (height / 3) * 2;
    //color del borde del texto
    ctxCanvas.strokeStyle = "black";
    ctxCanvas.strokeText(texto, x, y);
    //color del texto
    ctxCanvas.fillStyle = "black";
    ctxCanvas.fillText(texto, x, y);
}
