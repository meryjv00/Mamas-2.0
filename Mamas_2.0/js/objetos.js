/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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
    idClave = 0;
    idOpcion = 0;
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
