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
            email.classList.remove('is-invalid');
            email.classList.add('is-valid');
            emailError.textContent = '';
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
//******************************************************************************
//--------------------------VALIDACIÓN FORMULARIO REGISTRO----------------------
//******************************************************************************
function validarRegistro() {
//--------------------------ROLES
    if (document.getElementById("profesor") != null) {

        const admin = document.getElementById("admin");
        const asignaturas = document.getElementById("asignaturas");
        var radio = document.getElementById('profesor');
        var radio2 = document.getElementById('alumno');
        radio.addEventListener("change", validaRadio, false);
        function validaRadio()
        {
            var checked = radio.checked;
            if (checked) {
                admin.classList.remove('d-none');
                admin.classList.add('d-block');
                asignaturas.classList.remove('d-none');
                asignaturas.classList.add('d-block');
            }
        }
        radio2.addEventListener("change", validaRadio2, false);
        function validaRadio2()
        {
            var checked = radio2.checked;
            if (checked) {
                admin.classList.remove('d-block');
                admin.classList.add('d-none');
                asignaturas.classList.remove('d-block');
                asignaturas.classList.add('d-none');
            }
        }

    }


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
            nombre.classList.remove('is-invalid');
            nombreError.textContent = '';
        } else {
            error(nombre);
        }
    });
    apellidos.addEventListener('blur', function (event) {
        if (apellidos.validity.valid) {
            apellidosError.className = 'valid-feedback';
            apellidos.classList.add('is-valid');
            apellidos.classList.remove('is-invalid');
            apellidosError.textContent = '';
        } else {
            error(apellidos);
        }
    });
    email.addEventListener('blur', function (event) {
        if (email.validity.valid) {
            emailError.className = 'valid-feedback';
            email.classList.add('is-valid');
            email.classList.remove('is-invalid');
            emailError.textContent = '';
        } else {
            error(email);
        }
    });
    dni.addEventListener('blur', function (event) {
        if (dni.validity.valid) {
            dniError.className = 'valid-feedback';
            dni.classList.add('is-valid');
            dni.classList.remove('is-invalid');
            dniError.textContent = '';
        } else {
            error(dni);
        }
    });
    tfno.addEventListener('blur', function (event) {
        if (tfno.validity.valid) {
            tfnoError.className = 'valid-feedback';
            tfno.classList.add('is-valid');
            tfno.classList.remove('is-invalid');
            tfnoError.textContent = '';
        } else {
            error(tfno);
        }
    });
    pass.addEventListener('blur', function (event) {
        if (pass.validity.valid) {
            passError.className = 'valid-feedback';
            pass.classList.add('is-valid');
            pass.classList.remove('is-invalid');
            passError.textContent = '';
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
                pass2Error.textContent = '';
                pass2Error.className = 'valid-feedback';
                pass2.classList.add('is-valid');
                pass2.classList.remove('is-invalid');
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

//******************************************************************************
//--------------------------VALIDACIÓN FORMULARIOS PERFIL-----------------------
//******************************************************************************
function validacionTfnoPass() {
//TELEFONO
    const form = document.getElementById("editarTfno");
    const tfno = document.getElementById("tfno");
    const tfnoError = document.getElementById("tfnoError");
    //CONTRASEÑA
    const form2 = document.getElementById("editarPass");
    const pass = document.getElementById("pass");
    const passError = document.getElementById("passError");
    const pass2 = document.getElementById("pass2");
    const pass2Error = document.getElementById("pass2Error");
    var correcto;
    //----------------------TELEFONO---------------------------
    form.addEventListener('submit', function (event) {
        if (!tfno.validity.valid) {
            error(tfno);
            event.preventDefault();
        }
    });
    tfno.addEventListener('blur', function (event) {
        if (tfno.validity.valid) {
            tfnoError.className = 'valid-feedback';
            tfno.classList.add('is-valid');
            tfno.classList.remove('is-invalid');
            tfnoError.textContent = '';
        } else {
            error(tfno);
        }
    });
    function error(campo) {
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
    }

//--------------------CONTRASEÑA-------------------------
    form2.addEventListener('submit', function (event) {
        if (!pass.validity.valid) {
            error(pass);
            event.preventDefault();
        }
        comprobarContras();
        if (!correcto) {
            event.preventDefault();
        }
    });
    pass.addEventListener('blur', function (event) {
        if (pass.validity.valid) {
            passError.className = 'valid-feedback';
            pass.classList.add('is-valid');
            pass.classList.remove('is-invalid');
            passError.textContent = '';
        } else {
            error2(pass);
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
                pass2Error.textContent = '';
                pass2Error.className = 'valid-feedback';
                pass2.classList.add('is-valid');
                pass2.classList.remove('is-invalid');
            }
        }
    }

    function error2() {
        if (campo == pass) {
            if (pass.validity.valueMissing) {
                passError.textContent = 'Debe introducir su contraseña.';
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
function validarPregunta() {
    var tipoPregunta = document.getElementById('tipoPregunta');
    const addOpcion = document.getElementById("addOpcion");
    const addClave = document.getElementById("addClave");
    tipoPregunta.addEventListener("change", compruebaPregunta, false);
    function compruebaPregunta()
    {
        var opSelecc = tipoPregunta.options[tipoPregunta.selectedIndex].value;
        if (opSelecc == "SeleccionePregunta") {
            addClave.classList.add("d-none");
            addClave.classList.remove("d-block");
            addOpcion.classList.add("d-none");
            addOpcion.classList.remove("d-block");
        }
        if (opSelecc === "PreguntaCorta") {
            addClave.classList.add("d-block");
            addClave.classList.remove("d-none");
            addOpcion.classList.add("d-none");
            addOpcion.classList.remove("d-block");
        }
        if (opSelecc == "Test") {
            addClave.classList.add("d-none");
            addClave.classList.remove("d-block");
            addOpcion.classList.add("d-block");
            addOpcion.classList.remove("d-none");
        }
    }

}



//---------------------CLASES
var idClave = 0;
var idOpcion = 0;
var idPregunta = 0;
var palabrasClaves = [];
var opcionesTest = [];
var preguntas = [];
//OBJETO PALABRA CLAVE
var PalabraClave = function (id, nombre) {
    this.id = id;
    this.nombre = nombre;
    this.getId = function () {
        return this.id;
    };
    this.getNombre = function () {
        return this.nombre;
    };
};
//OBJETO OPCION TEST
var Opcion = function (id, opcion, correcto) {
    this.id = id;
    this.opcion = opcion;
    this.correcto = correcto;
    this.getId = function () {
        return this.id;
    };
    this.getOpcion = function () {
        return this.opcion;
    };
    this.getCorrecto = function () {
        return this.correcto;
    };
};
//OBJETO PREGUNTA
var Pregunta = function (id, tipo, asignatura, puntuacion, enunciado, datos) {
    this.id = id;
    this.tipo = tipo;
    this.asignatura = asignatura;
    this.puntuacion = puntuacion;
    this.enunciado = enunciado;
    this.datos = [];
    for (var i = 0; i < datos.length; i++) {
        this.datos.push(datos[i]);
    }
    this.getId = function () {
        return this.id;
    };
    this.getTipo = function () {
        return this.tipo;
    };
    this.getAsignatura = function () {
        return this.asignatura;
    };
    this.getPuntuacion = function () {
        return this.puntuacion;
    };
    this.getEnunciado = function () {
        return this.enunciado;
    };
    this.getDatos = function () {
        return this.datos;
    };
};
//AÑADIR PALABRA CLAVE A LA TABLA
function addPalabraClave() {
    const nombre = document.getElementById("palabraClave").value;
    if (nombre != "") {
        idClave++;
        var clave = new PalabraClave(idClave, nombre);
        palabrasClaves.push(clave);
        var cuerpoTabla = document.getElementById("bodyPalabrasClave");
        var fila = document.createElement("tr");
        var col1 = document.createElement("td");
        var id = document.createTextNode(clave.getId());
        col1.appendChild(id);
        var col2 = document.createElement("td");
        var nomb = document.createTextNode(clave.getNombre());
        col2.appendChild(nomb);
        fila.appendChild(col1);
        fila.appendChild(col2);
        cuerpoTabla.appendChild(fila);
    } else {
        alert('Escribe una palabra clave');
    }
    document.getElementById("palabraClave").value = "";
}


//AÑADIR OPCION A LA TABLA
function addOpcionT() {
    var opcion = document.getElementById("opcion").value;
    if (opcion != "") {
        var correcto = document.getElementById("correcto").checked;
        idOpcion++;
        var opcionTest = new Opcion(idOpcion, opcion, correcto);
        opcionesTest.push(opcionTest);
        var cuerpoTabla = document.getElementById("bodyOpciones");
        var fila = document.createElement("tr");
        var col1 = document.createElement("td");
        var id = document.createTextNode(opcionTest.getId());
        col1.appendChild(id);
        var col2 = document.createElement("td");
        var opciont = document.createTextNode(opcionTest.getOpcion());
        col2.appendChild(opciont);
        var col3 = document.createElement("td");
        var correc = document.createTextNode(opcionTest.getCorrecto());
        col3.appendChild(correc);
        fila.appendChild(col1);
        fila.appendChild(col2);
        fila.appendChild(col3);
        cuerpoTabla.appendChild(fila);
    } else {
        alert('Escribe una opción');
    }
    document.getElementById("opcion").value = "";
}

//******************************************************************************
//--------------------------VALIDACIÓN FORMULARIO CREAR EXAMEN------------------
//******************************************************************************
function validacionExamen() {
    var formulario = document.getElementById("formExamen");
    var asignaturas = document.getElementById("asignaturas");
    var contenido = document.getElementById("contenido");
    var descripcion = document.getElementById("descripcion");

    var asignaturaError = document.getElementById("asignaturaError");
    var contenidoError = document.getElementById("contenidoError");
    var descripcionError = document.getElementById("descripcionError");

    formulario.addEventListener('submit', function (event) {
        if (!contenido.validity.valid) {
            error(contenido);
            event.preventDefault();
        }
        if (!descripcion.validity.valid) {
            error(descripcion);
            event.preventDefault();

        }
        if (!asignaturaS()) {

            event.preventDefault();
        }
    });
    function asignaturaS() {
        correct = false;
        var asignaturaSeleccionada = asignaturas.options[asignaturas.selectedIndex].value;
        if (asignaturaSeleccionada != "Seleccione una asignatura") {
            correct = true;
            asignaturasError.className = 'valid-feedback';
            asignaturas.classList.remove('is-invalid');
            asignaturas.classList.add('is-valid');
            asignaturasError.textContent = '';
        } else {
            error(asignaturas);
        }
        return correct;
    }
    contenido.addEventListener('blur', function (event) {
        if (contenido.validity.valid) {
            contenidoError.className = 'valid-feedback';
            contenido.classList.remove('is-invalid');
            contenido.classList.add('is-valid');
            contenidoError.textContent = '';
        } else {
            error(contenido);
        }
    });
    descripcion.addEventListener('blur', function (event) {
        if (descripcion.validity.valid) {
            descripcionError.className = 'valid-feedback';
            descripcion.classList.remove('is-invalid');
            descripcion.classList.add('is-valid');
            descripcionError.textContent = '';
        } else {
            error(descripcion);
        }
    });
    function error(campo) {
        if (campo == contenido) {
            //Campo vacío
            if (contenido.validity.valueMissing) {
                contenidoError.textContent = 'Debe introducir el contenido del examen';

            }
            contenido.classList.remove('is-valid');
            contenido.classList.add('is-invalid');
            contenidoError.className = 'invalid-feedback';
        }
        if (campo == descripcion) {
            //Campo vacío
            if (descripcion.validity.valueMissing) {
                descripcionError.textContent = 'Debe introducir la descipcion del examen';

            }
            descripcion.classList.remove('is-valid');
            descripcion.classList.add('is-invalid');
            descripcionError.className = 'invalid-feedback';
        }
        if (campo == asignaturas) {
            asignaturasError.textContent = 'Debe seleccionar una asignatura';
            asignaturas.classList.remove('is-valid');
            asignaturas.classList.add('is-invalid');
            asignaturasError.className = 'invalid-feedback';

        }
    }

}


//AÑADIR PREGUNTAS
function addPregunta() {
    var enunciado = document.getElementById("enunciado").value;
    var puntuacion = document.getElementById("puntuacion").value;
    var asignatura = document.getElementById("asignaturas");
    var asignaturaSeleccionada = asignatura.options[asignatura.selectedIndex].value;
    var tipoPregunta = document.getElementById('tipoPregunta');
    var preguntaSeleccionada = tipoPregunta.options[tipoPregunta.selectedIndex].value;
    if (asignaturaSeleccionada != "Seleccione una asignatura") {
        if (enunciado != "") {
            if (puntuacion < 0 || puntuacion > 100) {
                alert("Escribe una puntuación válida (0-100)");
            } else {
                if (preguntaSeleccionada == 'Test') {
//alert('Crear pregunta tipo test');
                    if (opcionesTest.length >= 2) {
                        var correcto = false;
                        for (var i = 0; i < opcionesTest.length; i++) {
                            if (opcionesTest[i].getCorrecto()) {
                                correcto = true;
                            }
                        }
                        if (correcto) {
                            idPregunta++;
                            var preguntaTest = new Pregunta(idPregunta, 1, asignaturaSeleccionada, puntuacion, enunciado, opcionesTest);
                            preguntas.push(preguntaTest);
                            //Añadir vista previa
                            addVistaPrevia(preguntaTest);
                            //Vacíar todo
                            limpiarCampos();
                        } else {
                            alert("Debes marcar al menos una opción como correcta");
                        }
                    } else {
                        alert("Es necesario crear 2 opciones como mínimo; has creado " + opcionesTest.length + " opcion(es)");
                    }
                } else if (preguntaSeleccionada == 'PreguntaCorta') {
//alert('Crear pregunta corta');
                    if (palabrasClaves.length >= 1) {
                        idPregunta++;
                        var preguntaTXT = new Pregunta(idPregunta, 0, asignaturaSeleccionada, puntuacion, enunciado, palabrasClaves);
                        preguntas.push(preguntaTXT);
                        //Añadir vista previa
                        addVistaPrevia(preguntaTXT);
                        //Vacíar todo
                        limpiarCampos();
                    } else {
                        alert("Es necesario establecer una palabra clave como mínimo");
                    }
                } else {
                    alert("Seleccione un tipo de pregunta");
                }
            }
        } else {
            alert("Escribe un enunciado para la pregunta");
        }
    } else {
        alert("Seleccione una asignatura para la pregunta");
    }
}

function limpiarCampos() {
    var tablaClaves = document.getElementById("bodyPalabrasClave");
    var tablaOpciones = document.getElementById("bodyOpciones");
    document.getElementById("enunciado").value = "";
    //VACIAR VECTORES
    while (palabrasClaves.length) {
        palabrasClaves.pop();
    }
    while (opcionesTest.length) {
        opcionesTest.pop();
    }
//VACIAR ACORDEONES
    if (tablaOpciones.hasChildNodes()) {
        while (tablaOpciones.childNodes.length >= 1) {
            tablaOpciones.removeChild(tablaOpciones.firstChild);
        }
    }
    if (tablaClaves.hasChildNodes()) {
        while (tablaClaves.childNodes.length >= 1) {
            tablaClaves.removeChild(tablaClaves.firstChild);
        }
    }

}

function addVistaPrevia(pregunta) {
    var lista = document.getElementById("preguntasCreadas");
    var listali = document.createElement("li");
    listali.classList.add('list-group-item');
    listali.classList.add('border');
    var parr = document.createElement("p");
    var p = document.createTextNode(pregunta.getId() + ". " + pregunta.getEnunciado() + " - " + pregunta.getPuntuacion() + " (pnt)");
    parr.appendChild(p);
    listali.appendChild(parr);
    //Pregunta texto
    if (pregunta.getTipo() == 0) {
        var palabrasClave = pregunta.getDatos();
        var parr2 = document.createElement("p");
        var p2 = document.createTextNode("Palabras clave: ");
        parr2.appendChild(p2);
        for (var i = 0; i < palabrasClave.length; i++) {
            var palabra = palabrasClave[i];
            p2 = document.createTextNode(palabra.getNombre() + " ");
            parr2.appendChild(p2);
            listali.appendChild(parr2);
        }
//Pregunta tipo test
    } else {
        var opciones = pregunta.getDatos();
        for (var i = 0; i < opciones.length; i++) {
            var parr2 = document.createElement("p");
            var opcion = opciones[i];
            var texto;
            if (opcion.getCorrecto()) {
                texto = "Correcta";
            } else {
                texto = "Incorrecta";
            }
            var p3 = document.createTextNode(opcion.getId() + ") " + opcion.getOpcion() + " >>" + texto);
            parr2.appendChild(p3);
            listali.appendChild(parr2);
        }
    }

    lista.appendChild(listali);
}

//AÑADIR TODAS LAS PREGUNTAS 
function addPreguntas() {
    var formuAddPreguntas = document.getElementById("formuAddPreguntas");
    var json = document.getElementById("json");
    formuAddPreguntas.addEventListener('submit', function (event) {
        if (preguntas.length == 0) {
            event.preventDefault();
            alert('Añade al menos una pregunta');
        } else {
            json.value = JSON.stringify(preguntas);
        }
    });
}