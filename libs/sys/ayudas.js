// JavaScript Document
function activarbotonformatos(idBoton, activar) {
  if (activar === 'false') {
    $("#" + idBoton).attr("disabled", "disabled");
  } else {
    $("#" + idBoton).removeAttr("disabled");
  }
}
function irarriba() {
  $('html, body').animate({scrollTop: 0}, 179);
}
function calcularEdadAnoMes(objIdAnos, objIdMes) {
  var an = $('#' + objIdAnos).val();
  var me = $('#' + objIdMes).val();
  var tAn = parseInt(an) + (parseInt(me) / 12);
  var dt = new Date();
  var tAc = dt.getFullYear() + ((dt.getMonth() + 1) / 12)
  var elapsed = (tAc - tAn);
  return Math.abs(elapsed);
}

function validacionformulario(form, errors) {
  if (errors) {
    var message = erroresvalidacion(errors);
    $(formulario).removeAlertBoxes();
    $(formulario).alertBox(message, {type: 'error'});
  } else {
    $(formulario).removeAlertBoxes();
  }
}
function erroresvalidacion(errors) {
  return errors == 1
    ? 'Falta 1 Campo por llenar.'
    : 'Faltan ' + errors + ' campos. Debes completarlos todos.';
}

function selectorColor() {
  $('.pslcolorpicker').miniColors({
    value: '#' + Math.floor(Math.random() * 16777215).toString(16),
    opacity: true,
    change: function (hex, rgb) {
    },
    open: function (hex, rgb) {
    },
    close: function (hex, rgb) {
    }
  });
}
function zIndex() {
  var allElems = document.getElementsByTagName ? document.getElementsByTagName("*") : document.all; // or test for that too
  var maxZIndex = 0;
  for (var i = 0; i < allElems.length; i++) {
    var elem = allElems[i];
    var cStyle = null;
    if (elem.currentStyle) {
      cStyle = elem.currentStyle;
    }
    else if (document.defaultView && document.defaultView.getComputedStyle) {
      cStyle = document.defaultView.getComputedStyle(elem, "");
    }
    var sNum;
    if (cStyle) {
      sNum = Number(cStyle.zIndex);
    } else {
      sNum = Number(elem.style.zIndex);
    }
    if (!isNaN(sNum)) {
      maxZIndex = Math.max(maxZIndex, sNum);
    }
  }
  return maxZIndex + 1;
}


// Cadenas
function comparaCampos(idCampoA, idCampoB) {
  var A = $('#' + idCampoA).attr('value');
  var B = $('#' + idCampoB).attr('value');

  if (A == B)
    return true;
  return false;
}

function calculaAltoPantalla() {
  if (document.layers) {
    alto = window.innerHeight;
  } else {
    alto = document.body.clientHeight;
  }
  return alto;
}

function calculaAnchoPantalla() {
  var ancho;
  if (document.layers) {
    ancho = window.innerWidth;
  } else {
    ancho = document.body.clientWidth;
  }
  return ancho;
}

function agregarzonamodal(html) {
  $('#zona-modal').html(html);
}

function seleccionarTodosCheckbox(grupo, idCheck) {
  alert(idCheck + '' + $('#' + idCheck).is(':checked'));
  $("input[name=" + idCheck + "]").change(function () {
    $("input[class=" + grupo + "]").each(function () {
      if ($("input[name=" + idCheck + "]:checked").length == 1) {
        this.checked = true;
      } else {
        this.checked = false;
      }
    });
  });

}
function traerrutanavegacion() {

}

function actualizarareacontenido(data) {
  $('areaTrabajo').html(data);
}

function cargarplugins() {

}



function estaVacio(val) {
  var res = (val === undefined || val === "" || val === 0 || val === null || val === false || val.length <= 0) ? true : false;
  return res;
}

function rellenarCeros(num, totalChars, padWith) {
  num = num + "";
  padWith = (padWith) ? padWith : "0";
  if (num.length < totalChars) {
    while (num.length < totalChars) {
      num = padWith + num;
    }
  } else {
  }

  if (num.length > totalChars) { //if padWith was a multiple character string and num was overpadded
    num = num.substring((num.length - totalChars), totalChars);
  } else {
  }

  return num;
}

function esFechaValida(aho, mes, dia) {
  var plantilla = new Date(aho, mes - 1, dia);//mes empieza de cero Enero = 0
  if (!plantilla || plantilla.getFullYear() == aho && plantilla.getMonth() == mes - 1 && plantilla.getDate() == dia) {
    return true;
  } else {
    return false;
  }
}

function formatoNumero(valor) {
  return new Intl.NumberFormat().format(valor);
}

restaFechas = function (f1, f2) {
  var aFecha1 = f1.split('-');
  var aFecha2 = f2.split('-');
  var fFecha1 = Date.UTC(aFecha1[2], aFecha1[1] - 1, aFecha1[0]);
  var fFecha2 = Date.UTC(aFecha2[2], aFecha2[1] - 1, aFecha2[0]);
  var dif = fFecha2 - fFecha1;
  var dias = Math.floor(dif / (1000 * 60 * 60 * 24));
  return dias;
};


restaFechaHoy = function (f1) {
  var aFecha1 = f1.split('-');
  var fFecha1 = Date.UTC(aFecha1[0], aFecha1[1] - 1, aFecha1[2]);
  var hoy = new Date();
  var dd = hoy.getDate();
  var mm = hoy.getMonth(); //hoy es 0!
  var yyyy = hoy.getFullYear();
  var fFecha2 = Date.UTC(yyyy, mm, dd);
  var dif = fFecha1 - fFecha2;
  var dias = Math.floor(dif / (1000 * 60 * 60 * 24));
  return dias;
};





function validarfechaMayorQue(fechaInicial, fechaFinal)
{
  if (fechaFinal >= fechaInicial)
  {
    return false;
  }
  return true;
}

function imprimirareahtml(titulo, idArea) {
  w = window.open('', titulo, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, copyhistory=no, height=400');
  w.document.write($('#' + idArea).html());
  w.document.close();
  w.print();
}



function abrirsoportes(url, title) {
  var left = (screen.width / 2) - (600 / 2);
  var top = (screen.height / 2) - (400 / 2);
  return window.open('' + url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=600, height=400, top=' + top + ', left=' + left);
}
function descargar(url) {
  window.location.href = url;
}
function reemplazarCaracteres(buscar, frase) {
  return frase.replace(new RegExp(buscar, "g"), " ");
}


var timerRegistraGPS;
var geooptions = {
  enableHighAccuracy: true,
  maximumAge: 0,
  timeout: 27000
};
function posicionUsuario() {
  getLocation();
  timerRegistraGPS = setInterval(function () {
    getLocation();
  }, 1000 * 60 * 5);
}
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(registrarPosition, geoerror, geooptions);
  } else {
    alerta("Esta navegador no tiene soporte para GPS.");
    clearInterval(timerRegistraGPS);
  }
}
function registrarPosition(position) {
  //console.log("Latitude: " + position.coords.latitude + " Longitude: " + position.coords.longitude);
  $.post("controlador.php", {modulo: "sistema", controlador: "sesion", accion: "registrarUltimaUbicacion", latitud: position.coords.latitude, longitud: position.coords.longitude});
}
function geoerror() {
  console.log("no position.");
}

var minAlerta = 17;
function alertaRecogidaEquipos() {
  setTimeout(function () {
    consultaAlertas();
  }, minAlerta * 60 * 1000);
}
function consultaAlertas() {
  minAlerta = 17;
  ejecutarAccionSinBloqueo(
    'sistema', 'alertas', 'recogidaEquipos', '',
    function (resp) {
      var datos = JSON.parse(resp);
      var htmlItem = '<li>' +
        '<a>' +
//        '<span class="image">' +
//        '<img src="<?php echo Plantillas::$url ?>images/img.jpg" alt="Profile Image" />' +
//        '</span>' +
        '<span>' +
        '<span>nombre cliente /referencia</span>' +
        '<span class="time">Recibo </span>' +
        '</span>' +
        '<span class="message">direccion</span>' +
        '</a>' +
        '</li>';
      $("#menuAlertas").html("");
      $("#numAlertas").html("0");
      for (var k in datos) {
        var claseAlerta = "alert-info";
        var diasParaRecoger = (restaFechaHoy(datos[k].reciboFechaRecogida));
        if (diasParaRecoger === 0) {
          sonarAlertaEquiposRecoger();
          claseAlerta = "alert-warnning";
        } else if (diasParaRecoger < 0) {
          sonarAlertaEquiposVencidosRecoger();
          claseAlerta = "alert-danger";
          minAlerta = 2.5;
        }
        $("#menuAlertas").append(
          '<li class="alert ' + claseAlerta + '" >' +
//          '<div class="col-sm-4 col-xs-12" ><span class="image">' +
//          '<a href="' + datos[k].personaFotoReferencia + '" target="blank" >' +
//          '<img src="imagen.php?url=' + datos[k].personaFotoReferencia + '" alt="' + datos[k].personaRazonSocial + '" style="max-width: 100%" />' +
//          '</a>' +
//          '</span></div>' +
          '<div class="col-sm-12 col-xs-12" ><span>' +
          '<div class="time"><a target="blank" href="' + datos[k].documentoUrl + '" >Recibo ' + datos[k].reciboNumero + '</a><br />recoger el ' + datos[k].reciboFechaRecogida + '</div>' +
          '<div>' + datos[k].personaRazonSocial + '</div>' +
          '</span>' +
          '<div class="message">' + datos[k].reciboDireccion + '</div>' +
          '<div class=""><a target="blank" href="https://www.google.com.co/maps/place/11%C2%B013\'42.7%22N+74%C2%B011\'51.9%22W/@' + datos[k].reciboLatitud + ',' + datos[k].reciboLongitud + ',20z/data=!3m1!4b1!4m2!3m1!1s0x0:0x0" >ver mapa</a></div>' +
          '</div>' +
          '</li>'
          );
      }
      $("#numAlertas").html(parseInt(k) + 1);



      alertaRecogidaEquipos();
    }
  );
}
var audioElement = document.createElement('audio');
audioElement.setAttribute('src', '/archivos/oximeiser/sonidos/alerta.mp3');
audioElement.setAttribute('autoplay', 'autoplay');
function sonidoAlertaRecogida(volumen) {
  audioElement.play();
  $(audioElement).prop("volume", volumen);

}
function sonarAlertaEquiposRecoger() {
  setTimeout(function (e) {
    sonidoAlertaRecogida(0.005);
//    setTimeout(function (e) {
//      sonidoAlertaRecogida(0.003);
//    }, 1234 * 5);
//    setTimeout(function (e) {
//      sonidoAlertaRecogida(0.001);
//    }, 1234 * 10);
  }, 123);
}
function sonarAlertaEquiposVencidosRecoger() {
  setTimeout(function (e) {
//    setTimeout(function (e) {
//      sonidoAlertaRecogida(0.005);
//    }, 4560);
//    setTimeout(function (e) {
//      sonidoAlertaRecogida(0.01);
//    }, 3450);
//    setTimeout(function (e) {
//      sonidoAlertaRecogida(0.01);
//    }, 2340);
//    setTimeout(function (e) {
//      sonidoAlertaRecogida(0.005);
//    }, 1230);
    sonidoAlertaRecogida(0.01);
  }, 500);
}