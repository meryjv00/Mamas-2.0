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

    const email = document.getElementById("email");
    const nombre = document.getElementById("nombre");
    const apellidos = document.getElementById("apellidos");
    const dni = document.getElementById("dni");
    const tfno = document.getElementById("tfno");
    const pass = document.getElementById("pass");
    const pass2 = document.getElementById("pass2");

    const emailError = document.getElementById("emailError");
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
        if (!apellidos.validity.valid) {
            error(apellidos);
            event.preventDefault();
        }
        if (!email.validity.valid) {
            error(email);
            event.preventDefault();
        }
        if (!dni.validity.valid) {
            error(dni);
            event.preventDefault();
        }
        if (!tfno.validity.valid) {
            error(tfno);
            event.preventDefault();
        }
        if (!pass.validity.valid) {
            error(pass);
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
            nombre.classList.add('is-valid');
            nombreError.textContent = 'Looks good!';
        } else {
            error(nombre);
        }
    });
    apellidos.addEventListener('blur', function (event) {
        if (apellidos.validity.valid) {
            apellidosError.className = 'valid-feedback';
            apellidos.classList.add('is-valid');
            apellidosError.textContent = 'Looks good!';
        } else {
            error(apellidos);
        }
    });

    email.addEventListener('blur', function (event) {
        if (email.validity.valid) {
            emailError.className = 'valid-feedback';
            email.classList.add('is-valid');
            emailError.textContent = 'Looks good!';
        } else {
            error(email);
        }
    });

    dni.addEventListener('blur', function (event) {
        if (dni.validity.valid) {
            dniError.className = 'valid-feedback';
            dni.classList.add('is-valid');
            dniError.textContent = 'Looks good!';
        } else {
            error(dni);
        }
    });

    tfno.addEventListener('blur', function (event) {
        if (tfno.validity.valid) {
            tfnoError.className = 'valid-feedback';
            tfno.classList.add('is-valid');
            tfnoError.textContent = 'Looks good!';
        } else {
            error(tfno);
        }
    });

    pass.addEventListener('blur', function (event) {
        if (pass.validity.valid) {
            passError.className = 'valid-feedback';
            pass.classList.add('is-valid');
            passError.textContent = 'Looks good!';
        } else {
            error(pass);
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
            pass2.classList.remove('is-valid');
            pass2.classList.add('is-invalid');
            correcto = false;
        } else {
            correcto = true;
            if (!pass2.value.length == 0) {
                pass2Error.textContent = 'Looks good!';
                pass2Error.className = 'valid-feedback';
                pass2.classList.add('is-valid');
            }
        }
    }
    function error(campo) {
        if (campo == nombre) {
            //Campo vacío
            if (nombre.validity.valueMissing) {
                nombreError.textContent = 'Debe introducir su nombre.';
            } else if (nombre.validity.tooShort) {
                nombreError.textContent = 'Debe tener al menos ' + nombre.minLength + ' caracteres; ha introducido ' + nombre.value.length;
            } else if (nombre.validity.tooLong) {
                nombreError.textContent = 'Debe tener como máximo ' + nombre.maxLength + ' caracteres; ha introducido ' + nombre.value.length;
            }
            // Establece el estilo apropiado
            nombre.classList.remove('is-valid');
            nombre.classList.add('is-invalid');
            nombreError.className = 'invalid-feedback';
        }
        if (campo == apellidos) {
            //Campo vacío
            if (apellidos.validity.valueMissing) {
                apellidosError.textContent = 'Debe introducir sus apellidos.';
            } else if (apellidos.validity.tooShort) {
                apellidosError.textContent = 'Debe tener al menos ' + apellidos.minLength + ' caracteres; ha introducido ' + apellidos.value.length;
            } else if (apellidos.validity.tooLong) {
                apellidosError.textContent = 'Debe tener como máximo ' + apellidos.maxLength + ' caracteres; ha introducido ' + apellidos.value.length;
            }
            // Establece el estilo apropiado
            apellidos.classList.remove('is-valid');
            apellidos.classList.add('is-invalid');
            apellidosError.className = 'invalid-feedback';
        }
        if (campo == email) {
            //Campo vacío
            if (email.validity.valueMissing) {
                emailError.textContent = 'Debe introducir su dirección de correo electrónico.';
                //No cumple los requisitos del campo email
            } else if (email.validity.typeMismatch) {
                emailError.textContent = 'El valor introducido debe ser una dirección de correo electrónico ';
                //Datos demasiado cortos
            }
            // Establece el estilo apropiado
            email.classList.remove('is-valid');
            email.classList.add('is-invalid');
            emailError.className = 'invalid-feedback';
        }
        if (campo == dni) {
            //Campo vacío
            if (dni.validity.valueMissing) {
                dniError.textContent = 'Debe introducir su dni.';
                //No cumple con el pattern
            } else if (dni.validity.patternMismatch) {
                dniError.textContent = 'El valor introducido debe seguir este patron 00000000X';
            }
            // Establece el estilo apropiado
            dni.classList.remove('is-valid');
            dni.classList.add('is-invalid');
            dniError.className = 'invalid-feedback';
        }
        if (campo == tfno) {
            if (tfno.validity.valueMissing) {
                tfnoError.textContent = 'Debe introducir su teléfono.';
            }
            //No cumple con el pattern
            else if (tfno.validity.patternMismatch) {
                tfnoError.textContent = 'El valor introducido debe tener 9 números';
            }
            // Establece el estilo apropiado
            tfno.classList.remove('is-valid');
            tfno.classList.add('is-invalid');
            tfnoError.className = 'invalid-feedback';
        }
        if (campo == pass) {
            //Campo vacío
            if (pass.validity.valueMissing) {
                passError.textContent = 'Debe introducir una contraseña.';
                //Dato demasiado cortos
            } else if (pass.validity.tooShort) {
                passError.textContent = 'Debe tener al menos ' + pass.minLength + ' caracteres; ha introducido ' + pass.value.length;
                //Dato demasiado largo
            } else if (pass.validity.tooLong) {
                passError.textContent = 'Debe tener como máximo ' + pass.maxLength + ' caracteres; ha introducido ' + pass.value.length;
            }
            // Establece el estilo apropiado
            pass.classList.remove('is-valid');
            pass.classList.add('is-invalid');
            passError.className = 'invalid-feedback';
        }
    }

}
