/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function login() {
    'use strict';
    window.addEventListener('load', function () {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('has-success');
            }, false);
        });
    }, false);

}

function validarRegistro() {
    //---------------------------VARIABLES
    const form = document.getElementById("registro");

    const nombre = document.getElementById("nombre");
    const apellidos = document.getElementById("apellidos");
    const dni = document.getElementById("dni");
    const tfno = document.getElementById("tfno");
    const pass = document.getElementById("pass");
    const pass2 = document.getElementById("pass2");

    const nombreError = document.getElementById("nombreError");
    const apellidosError = document.getElementById("apellidosError");
    const dniError = document.getElementById("dniError");
    const tfnoError = document.getElementById("tfnoError");
    const passError = document.getElementById("passError");
    const pass2Error = document.getElementById("pass2Error");

    //-----------------------------FORMULARIO SUBMIT
    var correcto;

    form.addEventListener('submit', function (event) {
        if (!nombre.validity.valid) {
            error(nombre);
            event.preventDefault();
        }

        comprobarContras();
        if (!correcto) {
            event.preventDefault();
        }
    });

    nombre.addEventListener('blur', function (event) {
        if (nombre.validity.valid) {
            nombreError.className = 'valid-feedback';
            nombre.className = 'is-valid';
            nombreError.textContent = 'Looks good!';
        } else {
            error(nombre);
        }
    });

    pass2.addEventListener('input', function (event) {
        comprobarContras();
    });

    function comprobarContras() {
        var c1 = pass.value;
        var c2 = pass2.value;
        if (c1 != c2) {
            pass2Error.textContent = 'Las contraseñas no coinciden.';
            pass2Error.className = 'invalid-feedback';
            pass2.className = 'is-invalid';
            correcto = false;
        } else {
            nombreError.textContent = 'Looks good!';
            nombreError.className = 'valid-feedback';
            nombre.className = 'is-valid';
            correcto = true;
        }
    }
    function error(campo) {
        if (campo == nombre) {
            //Campo vacío
            if (nombre.validity.valueMissing) {
                nombreError.textContent = 'Debe introducir un nombre.';
            } else if (nombre.validity.tooShort) {
                nombreError.textContent = 'El nombre debe tener al menos ' + nombre.minLength + ' caracteres; ha introducido ' + nombre.value.length;
            } else if (nombre.validity.tooLong) {
                nombreError.textContent = 'El nombre debe tener como máximo ' + nombre.maxLength + ' caracteres; ha introducido ' + nombre.value.length;
            }
            // Establece el estilo apropiado
            nombre.className = 'is-invalid';
            nombreError.className = 'invalid-feedback';
        }

    }

}
