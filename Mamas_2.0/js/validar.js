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
    const email = document.getElementById("email");
    const emailError = document.getElementById("emailError");

    form.addEventListener('submit', function (event) {
        if (!email.validity.valid) {
            error(email);
            event.preventDefault();
        }
    });

    email.addEventListener('blur', function (event) {
        if (email.validity.valid) {
            emailError.className = 'valid-feedback';
            email.classList.add('is-valid');

        } else {
            error(email);
        }
    });

    function error(campo) {
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
    }
}