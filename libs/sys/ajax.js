var _puede_salir_formulario = true;
var _arreglo_temporizadores = {
  recarga_estadisticas: null, contador_recarga: null
};

function iniciarPluginsSistema() {
  $("form").submit(function (evt) {
    evt.preventDefault();
  });
  $('.mayusculas').on("keyup", function (evt) {
    evt.preventDefault();
    $(this)[0].value = convertirAMayusculas($(this)[0].value);
  });

}

function mostrarContenidos(modulo, controlador, accion, datos) {
  if (!_puede_salir_formulario) {
    confirm(
      '<strong>¿Seguro que desea salir sin guardar los datos del formulario?</strong> ' +
      'Recuerde que para guardar debe hacer clic en el Boton <a class="btn btn-success" ><i class="icon-save" ></i> Guardar </a>.',
      function (RESPUESTA) {
        ejecutarAccionMuestraAreaTrabajo(modulo, controlador, accion, datos);
      }
    );
  } else {
    ejecutarAccionMuestraAreaTrabajo(modulo, controlador, accion, datos);
  }
}
function ejecutarAccionMuestraAreaTrabajo(modulo, controlador, accion, datos) {
  _puede_salir_formulario = true;
  _arreglo_temporizadores = new Object();
  _arreglo_temporizadores = {
    recarga_estadisticas: null,
    contador_recarga: null
  };
  bloqueoCargando();
  ajax("&componente=" + modulo + "&accion=" + accion + "&controlador=" + controlador + "&" + datos,
    function (respHTML) {
      actualizarAreaContenido(respHTML);
      desbloqueoCargando();
      iniciarPluginsSistema();
      irArriba();
    }
  );
}

function ejecutarAccion(modulo, controlador, accion, datos, script) {
  bloqueoCargando();
  ajax("&componente=" + modulo + "&accion=" + accion + "&controlador=" + controlador + "&" + datos, script);
}
function ejecutarAccionSinBloqueo(modulo, controlador, accion, datos, script) {
  ajax("&componente=" + modulo + "&accion=" + accion + "&controlador=" + controlador + "&" + datos,
    script
    );
}
function ejecutarAccionJson(modulo, controlador, accion, datos, script) {
  //bloqueoCargando();
  json("&componente=" + modulo + "&accion=" + accion + "&controlador=" + controlador + "&" + datos,
    script
    );
}
function ejecutarAccionJsonSinBloqueo(modulo, controlador, accion, datos, script) {
  json("&componente=" + modulo + "&accion=" + accion + "&controlador=" + controlador + "&" + datos,
    script
    );
}
function ejecutarAccionArchivos(modulo, controlador, accion, datos, script) {
  bloqueoCargando();
  datos.append('componente', modulo);
  datos.append('controlador', controlador);
  datos.append('accion', accion);
  ajaxArchivos(
    datos,
    script
    );
}
function ejecutarAccionEsperar(modulo, controlador, accion, datos, script) {
  bloqueoCargando();
  return  ajaxEsperar("&componente=" + modulo + "&accion=" + accion + "&controlador=" + controlador + "&" + datos,
    script
    );
}
function ejecutarAccionJsonArchivos(modulo, controlador, accion, datos, script) {
  bloqueoCargando();
  datos.append('componente', modulo);
  datos.append('accion', accion);
  datos.append('controlador', controlador);
  jsonArchivos(
    datos, "desbloqueoCargando();  " + script
    );
}
function ejecutarAccionJsonEsperar(modulo, controlador, accion, datos, script) {
  bloqueoCargando();
  return jsonEsperar("&componente=" + modulo + "&accion=" + accion + "&controlador=" + controlador + "&" + datos, "desbloqueoCargando();  " + script
    );
}


var objAjaxPost;
function ajax(datos, script) {
  //alert(datos);
  var posting = $.post('api.php', datos);
  posting.done(function (data) {
    script(data);
//    asignarControlAccion();
    iniciarPluginsSistema();
//    inciar_plugins_plantilla();
    //ir_arriba();
  });
  posting.fail(function () {
    //alert("ATENCIÓN: Parece que no se puede realizar en la transmision de los datos. \r\nSi el problema persiste, por favor contacte al administrador del sistema.");
    desbloqueoCargando();
  });
  posting.always(function (data) {
//alert('Termino la ejecucion:' + data);     
    desbloqueoCargando();
  });
  objAjaxPost = posting;
}
function ajaxArchivos(datos, script) {
  var posting = $.ajax({
    url: 'api.php', //Url a donde la enviaremos
    type: 'POST', //Metodo que usaremos
    //dataType:"html",
    contentType: false, //Debe estar en false para que pase el objeto sin procesar
    data: datos, //Le pasamos el objeto que creamos con los archivos
    processData: false, //Debe estar en false para que JQuery no procese los datos a enviar
    cache: false //Para que el formulario no guarde cache
  }).done(function (data) {
    script(data);
    desbloqueoCargando();
//ir_arriba();
  });
  objAjaxPost = posting;
}
function ajaxEsperar(datos, script) {
  var posting = $.ajax({
    async: true,
    cache: false,
    dataType: "html",
    type: 'POST',
    url: "api.php",
    data: datos,
    success: function (respuesta) {
      script(respuesta);
      desbloqueoCargando();
      return respuesta;
    },
    beforeSend: function () {
    },
    error: function (objXMLHttpRequest) {
      //            alert("ATENCIÓN: Ha ocurrido un error en la operacion. <strong>Verifique que su conexion a internet este activa</strong> e intente nuevamente realizar la operacion.  \r\nSi el problema persiste, por favor contacte al administrador del sistema.");
      desbloqueoCargando();
    }
  });
  objAjaxPost = posting;
}
function abortarAjax() {
  objAjaxPost.abort();
}
function validarResultadoHTML(htmlMsg, funcExito, funcError) {

  var resp = htmlMsg.split("@pis_");
  //if (!$.isEmptyObject(resp)) {
  switch (resp[0]) {
    case 'ERROR':
      error(resp[1]);
      funcError();
      break;
    case 'INFO':
      informacion(resp[1]);
      funcExito();
      break;
    case 'EXITO':
      informacion(resp[1]);
      funcExito();
      break;
    case 'ALERTA':
      alerta(resp[1]);
      funcExito();
      break;
  }
  //}
}

function json(datos, script) {
  var posting = $.post('controlador.php', datos);
  posting.done(function (data) {
    if (!estaVacio(data)) {
      data = JSON.parse(data);
    }
    script(data);
//    asignarControlAccion();
    //ir_arriba();
  });
  posting.fail(function () {
    //        alert("ATENCIÓN: <strong>Verifique que su conexion a internet este activa</strong> e intente nuevamente realizar la operacion. Parece que no se puede realizar en la transmision de los datos. \r\nSi el problema persiste, por favor contacte al administrador del sistema.");
    desbloqueoCargando();
  });
  posting.always(function (data) {
//alert('Termino la ejecucion:' + data);     
  });
  objAjaxPost = posting;
}
function jsonArchivos(datos, script) {

  var posting = $.ajax({
    url: 'controlador.php', //Url a donde la enviaremos
    type: 'POST', //Metodo que usaremos
    dataType: 'json',
    contentType: false, //Debe estar en false para que pase el objeto sin procesar
    data: datos, //Le pasamos el objeto que creamos con los archivos
    processData: false, //Debe estar en false para que JQuery no procese los datos a enviar
    cache: false //Para que el formulario no guarde cache
  }).done(function (data) {
    eval(script);

  });
  objAjaxPost = posting;
}
function jsonEsperar(datos, script) {
  var posting = $.ajax({
    async: true,
    cache: false,
    dataType: "html",
    type: 'POST',
    url: "controlador.php",
    data: datos,
    success: function (respuesta) {
      eval(script);
      return respuesta;
    },
    beforeSend: function () {
    },
    error: function (objXMLHttpRequest) {
      //            alert("ATENCIÓN: <strong>Verifique que su conexion a internet este activa</strong> e intente nuevamente realizar la operacion.  Parece que no se puede realizar en la transmision de los datos. \r\nSi el problema persiste, por favor contacte al administrador del sistema.");
      desbloqueoCargando();
    }
  });
  objAjaxPost = posting;
}
function validarResultadoJSON(resp, funcExito, funcError) {
//if (!$.isEmptyObject(resp)) {
  switch (resp.resultado) {
    case 'ERROR':
      error(resp.mensaje);
      eval(funcError);
      break;
    case 'EXITO':
      informacion(resp.mensaje);
      eval(funcExito);
      break;
    case 'ALERTA':
      alert(resp.mensaje);
      eval(funcExito);
      break;
  }
//} 
}



function accionBackground(modulo, controlador, accion, datos, script) {
  var posting = $.post('controlador.php', "&componente=" + modulo + "&accion=" + accion + "&controlador=" + controlador + "&" + datos,
    function () {
    },
    "json");
  posting.done(function (data) {
    script(data);
  });
}
function esActivaSesion() {
  ejecutarAccionJsonSinBloqueo(
    'sistema', 'sesion', 'estaActiva', '',
    function (data) {
      if (estaVacio(data.respuesta)) {
        salirSistema();
      }
    }
  );
}
function consultaMensajesUsuarios() {
  accionBackground(
    'sistema', 'sesion', 'mensajesUsuarioActivo', '',
    'mostrarResultadoGuardar(data);'
    );
}




function actualizarAreaContenido(data) {
  $('#div-areaTrabajo').html(data);
}
function irArriba() {
  $('html, body').animate({scrollTop: 0}, 179);
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

var htmlMiniCargando = '<div id="miniCargando" style="<i class="fa fa-cog"></i></div>';
var tMiniCargando = 0;
var timerMiniCargando = null;
function cargandoDentroObjeto(enDonde) {
  $("#" + enDonde).prepend(htmlMiniCargando);
  $("#" + enDonde + " #miniCargando").fadeIn(1500);
  tMiniCargando = 0;
  timerMiniCargando = setInterval(function () {

    var min = (tMiniCargando / 60);
    if (min >= 1) {
      $('#tiempo-minicargando').html(min.toFixed(2) + " Minutos");
    } else {
      $('#tiempo-minicargando').html(tMiniCargando + " Segundos");
    }

    tMiniCargando++;
  }, 1000);
}
function quitarCargandoDentroObjeto(enDonde) {
  $("#" + enDonde + " #miniCargando").fadeOut(1500);
  clearInterval(timerMiniCargando);
}

var seg = 0;
var relojCargando;
function bloqueoCargando() {
  var cargando = '<div id="fondoCargando"  style=" z-index:ZINDEXMASALTO; position:fixed; top:0; left:0; width:110%; height:110%; background-color:rgba(0,0,0,0.45); background-position:center center; background-repeat:repeat; overflow:hidden;" ></div>' +
    '<div style=" z-index:ZINDEXMASALTO; position:fixed; top:0; left:0px; width:110%; height:110%; background-color:transparent; background-position:center center; background-repeat:repeat; overflow:hidden;" >' +
    '<div style="margin: 1% auto; text-align: center;">' +
    '<div class="col-middle">' +
    '<div class="text-center text-center">' +
    '<img src="media/logos/logo-web.png" class="animated flip infinite" style="margin: auto; max-width: 100%; width: 210px;" />' +
    '<h1 class="texto-cargando">CARGANDO</h1>' +
    '<h2>espera mientras terminamos la operaci&oacute;n.</h2>' +
    '<p>Si esta operaci&oacute;n se esta demorando mucho, por favor <a href="http://puroingeniosamario.com.co/">reportalo aqu&iacute;</a> </p>' +
    '</div>' +
    '</div>' +
    '</div>' +
    '</div>' +
    '';
  var posicion = zIndex();
  cargandoHtml = cargando.replace('ZINDEXMASALTO', posicion);
  cargandoHtml = cargandoHtml.replace('ZINDEXMASALTO', posicion + 1);
  $('#cargando').show();
  $('#cargando').html(cargandoHtml);
}
function desbloqueoCargando() {
  seg = 0;
  $('#cargando').fadeOut();
  $('#cargando').html('');
  clearInterval(relojCargando);
}
function bloquearEscritorio() {
  var hg = screen.height;
  var wd = calculaAncho();
  $("#zona-modal").append("<div id='divFondoBloquearEscritorio' class='cssFondoBloquearEscritorio' style='width:" + wd + "px;height:" + hg + "px;background-color:black;opacity:0.4;filter:alpha(opacity=40);position:absolute;top:0;left:0;z-index:" + zIndex() + ";' ></div>");
}
function desBloquearEscritorio() {
  $("#divFondoBloquearEscritorio").remove();
}



bloqueoCargando();
$(document).ready(function () {
  setTimeout(desbloqueoCargando, 1234);
});