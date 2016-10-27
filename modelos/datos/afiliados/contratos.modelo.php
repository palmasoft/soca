<?php
/**
 * @author Puro Ingenio Samario
 * @version 1.0
 * @created 25-mar.-2015 11:22:18 a. m.
 */
Modelos::cargar('Documentos' . DS . 'TiposDocumentos');
Modelos::cargar('Afiliados' . DS . 'ContratosBeneficios');
Modelos::cargar('Afiliados' . DS . 'ContratosPlanPagos');
Modelos::cargar('Afiliados' . DS . 'ContratosDocumentos');
class ContratosAfiliados extends Modelos {
  private static
   $nTabla = "contratosafiliados";
  private static
   $sqlBase = <<<sql
  SELECT   
    sedes.*  , contratosafiliados.*  , estadocontratos.*  , estadopagos.* , personas.*  
    , cotitular.personaTipoIdentificacion AS cotitularTipoIdentificacion
    , cotitular.personaIdentificacion AS cotitularIdentificacion
    , cotitular.personaNombres AS cotitularNombres
    , cotitular.personaApellidos AS cotitularApellidos
    , usuarios.usuarioTipo  , usuarios.usuarioNombre  , usuarios.usuarioCorreo 
  FROM  contratosafiliados   
  LEFT JOIN sedes     ON (      contratosafiliados.contratoSede = sedes.sedeId    ) 
  LEFT JOIN usuarios     ON (      contratosafiliados.contratoCreo = usuarios.usuarioId    ) 
  LEFT JOIN personas     ON (      contratosafiliados.contratoTitular = personas.personaId    ) 
  LEFT JOIN personas AS cotitular     ON (      contratosafiliados.contratoCotitular = cotitular.personaId    ) 
  LEFT JOIN estadocontratos     ON (      contratosafiliados.contratoEstado = estadocontratos.estadoContratoId    )
  LEFT JOIN estadopagos    ON (      contratosafiliados.contratoEstadoPago = estadopagos.estadoPagoId    )
sql;
  private static
   $sqlCompleta = <<<sqlCompleta
   SELECT 
      contratosafiliados.* , estadocontratos.* , estadopagos.*  , sedes.*  , tiposdocumentos.*
      , titular.personaTipoIdentificacion AS titularTipoIdentificacion
      , titular.personaIdentificacion AS titularIdentificacion
      , titular.personaNombres AS titularNombres
      , titular.personaApellidos AS titularApellidos
      , titular.personaProvincia AS titularProvincia
      , titular.personaCanton AS titularCanton 
      , titular.personaDireccion AS titularDireccion
      , titular.personaTelefono AS titularTelefono
      , titular.personaCelular AS titularCelular
      , titular.personaCorreoElectronico AS titularCorreoElectronico
      , cotitular.personaTipoIdentificacion AS cotitularTipoIdentificacion
      , cotitular.personaIdentificacion AS cotitularIdentificacion
      , cotitular.personaNombres AS cotitularNombres
      , cotitular.personaApellidos AS cotitularApellidos
      , cotitular.personaProvincia AS cotitularProvincia
      , cotitular.personaCanton AS cotitularCanton 
      , cotitular.personaDireccion AS cotitularDireccion
      , cotitular.personaTelefono AS cotitularTelefono
      , cotitular.personaCelular AS cotitularCelular
      , cotitular.personaCorreoElectronico AS cotitularCorreoElectronico
      , documentos.documentoCodigo
      , documentos.documentoTipo
      , documentos.documentoConsecutivo
      , documentos.documentoTitulo
      , documentos.documentoUrl 
      , usuarios.usuarioNombre
      , agente.personaIdentificacion AS agenteIdentificacion
      , agente.personaNombres AS agenteNombres
      , agente.personaApellidos AS agenteApellidos 
      , agente.personaCorreoElectronico AS agenteCorreoElectronico 
  FROM  contratosafiliados 
  LEFT JOIN personas AS titular     ON (      contratosafiliados.contratoTitular = titular.personaId    ) 
  LEFT JOIN personas AS cotitular     ON (      contratosafiliados.contratoCotitular = cotitular.personaId    ) 
  LEFT JOIN documentos     ON (      contratosafiliados.contratoDocumento = documentos.documentoId    ) 
  LEFT JOIN tiposdocumentos     ON (      contratosafiliados.contratoTipoDocumento = tiposdocumentos.tipoDocId    ) 
  LEFT JOIN usuarios     ON (      contratosafiliados.contratoCreo = usuarios.usuarioId    ) 
  LEFT JOIN sedes     ON (      contratosafiliados.contratoSede = sedes.sedeId    ) 
  LEFT JOIN personas AS agente     ON (      usuarios.usuarioPersona = agente.personaId    ) 
  LEFT JOIN estadocontratos     ON (      contratosafiliados.contratoEstado = estadocontratos.estadoContratoId    )
  LEFT JOIN estadopagos    ON (      contratosafiliados.contratoEstadoPago = estadopagos.estadoPagoId    )
sqlCompleta;

  static public
   function todos($ESTADO) {
    $query = self::$sqlBase . ' WHERE estadocontratos.estadoContratoCodigo = "' . $ESTADO . '" ORDER BY ' . self::$nTabla . '.contratoFecha DESC ';
    $resultado = self::consulta($query);
    if(count($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  static public
   function noAnulados() {
    $query = self::$sqlBase . ' WHERE estadocontratos.estadoContratoCodigo <> "ANULADO" '
     . 'ORDER BY ' . self::$nTabla . '.contratoFecha DESC ';
    $resultado = self::consulta($query);
    if(count($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  static public
   function todosDelUsuario($ESTADO, $USUARIO = NULL) {
    $query = self::$sqlBase . ' '
     . 'WHERE estadocontratos.estadoContratoCodigo = "' . $ESTADO . '" AND '
     . '' . self::$nTabla . '.contratoCreo = ' . ( is_null($USUARIO) ? Visitante::idUsuario() : $USUARIO ) . ' '
     . 'ORDER BY ' . self::$nTabla . '.contratoFecha DESC ';
    $resultado = self::consulta($query);
    if(count($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  static public
   function noAnuladosDelUsuario($USUARIO = NULL) {
    $query = self::$sqlBase . ' WHERE estadocontratos.estadoContratoCodigo <> "ANULADO" AND '
     . '' . self::$nTabla . '.contratoCreo = ' . ( is_null($USUARIO) ? Visitante::idUsuario() : $USUARIO ) . ' '
     . 'ORDER BY ' . self::$nTabla . '.contratoFecha DESC ';
    $resultado = self::consulta($query);
    if(count($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  static public
   function datos($contratoId) {
    $query = self::$sqlBase . " WHERE contratosafiliados.contratoId = ? ";
    $resultado = self::consulta($query, array($contratoId));
    if(count($resultado) > 0) {
      return $resultado[0];
    }
    return NULL;
  }

  static public
   function datosBasicos($contratoId) {
    $query = self::$sqlCompleta . " WHERE contratosafiliados.contratoId = ? ";
    $resultado = self::consulta($query, array($contratoId));
    if(count($resultado) > 0) {
      return $resultado[0];
    }
    return NULL;
  }

  static public
   function datosCompletos($contratoId) {
    $query = self::$sqlCompleta . " WHERE contratosafiliados.contratoId = ? ";
    $resultado = self::consulta($query, array($contratoId));
    if(count($resultado) > 0) {
      $objContrato = $resultado[0];
      $objContrato->Beneficios = ContratosAfiliadosBeneficios::delContrato($contratoId);
      $objContrato->PlanPagos = ContratosAfiliadosPlanPagos::delContrato($contratoId);
      $objContrato->PlanPagosCuotaInicial = ContratosAfiliadosPlanPagos::deCuotaInicialdelContrato($contratoId);
      $objContrato->PlanPagosValorContrato = ContratosAfiliadosPlanPagos::deValordelContrato($contratoId);

      $Pagare = TiposDocumentos::datosPorCodigo($objContrato->sedeCodigo . "" . TiposDocumentos::ContratoPagare);
      $objContrato->ContratoPagare = ContratosAfiliadosDocumentos::delTipoDelContrato($Pagare->tipoDocId, $contratoId);

      $Pagare2 = TiposDocumentos::datosPorCodigo($objContrato->sedeCodigo . "" . TiposDocumentos::ContratoPagareSaldoCuotaInicial);
      $objContrato->ContratoPagare2 = ContratosAfiliadosDocumentos::delTipoDelContrato($Pagare2->tipoDocId, $contratoId);
      
      $ContratoOtroSiUSO = TiposDocumentos::datosPorCodigo($objContrato->sedeCodigo . "" . TiposDocumentos::ContratoOtroSiUSO);
      $objContrato->ContratoOtroSiUSO = ContratosAfiliadosDocumentos::delTipoDelContrato($ContratoOtroSiUSO->tipoDocId,
        $contratoId);
      $ContratoOtroSiVIGENCIA = TiposDocumentos::datosPorCodigo($objContrato->sedeCodigo . "" . TiposDocumentos::ContratoOtroSiVIGENCIA);
      $objContrato->ContratoOtroSiVIGENCIA = ContratosAfiliadosDocumentos::delTipoDelContrato($ContratoOtroSiVIGENCIA->tipoDocId,
        $contratoId);
      $CartaActivacion = TiposDocumentos::datosPorCodigo($objContrato->sedeCodigo . "" . TiposDocumentos::CartaActivacion);
      $objContrato->CartaActivacion = ContratosAfiliadosDocumentos::delTipoDelContrato($CartaActivacion->tipoDocId,
        $contratoId);
      $BeneficiosOCGI = TiposDocumentos::datosPorCodigo($objContrato->sedeCodigo . "" . TiposDocumentos::BeneficiosOCGI);
      $objContrato->BeneficiosOCGI = ContratosAfiliadosDocumentos::delTipoDelContrato($BeneficiosOCGI->tipoDocId,
        $contratoId);

      return $objContrato;
    }
    return NULL;
  }

  static public
   function datosPorConsecutivo($contratosafiliados) {
    $query = self::$sqlBase . " WHERE contratosafiliados.contratoConsecutivo = ? ";
    $resultado = self::consulta($query, array($contratosafiliados));
    if(count($resultado) > 0) {
      return $resultado[0];
    }
    return NULL;
  }

  static public
   function delTitular($contratoTitular) {
    $query = self::$sqlBase . " WHERE contratosafiliados.contratoTitular = ? ";
    $resultado = self::consulta($query, array($contratoTitular));
    if(count($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

//
  //
  //
  //
  //
  //
  //
  
  static public
   function insertar(
  $contratoSede, $contratoFirmadoen, $contratoFecha, $contratoConsecutivo, $contratoAnosPlanPagos, $contratoAnos,
   $contratoGastosLegales, $contratoXpack, $contratoValorContrato, $contratoIvaContrato, $contratoValorAnoContrato,
   $contratoCuotaInicial, $contratoPagoInicial, $contratoSaldoCuotaInicial, $contratoNumCuotasCuotaInicial,
   $contratoValorCuotaCuotaInicial, $contratoSaldoFinanciar, $contratoNumCuotasFinanciar, $contratoValorCuotaFinanciar,
   $contratoEstadoPago, $contratoPorcentajePago, $contratoTitular, $contratoCotitular, $contratoBeneficiarios,
   $contratoObservaciones, $contratoTipoDocumento, $contratoDocumento) {
    $query = "INSERT INTO contratosafiliados (  "
     . "contratoSede, contratoFirmadoen, contratoFecha  , contratoConsecutivo  , contratoAnosPlanPagos  , contratoAnos  , contratoGastosLegales  , contratoXpack  , "
     . "contratoValorContrato  , contratoIvaContrato  , contratoValorAnoContrato, "
     . "contratoCuotaInicial  , contratoPagoInicial  , contratoSaldoCuotaInicial  , contratoNumCuotasCuotaInicial  , contratoValorCuotaCuotaInicial  , "
     . "contratoSaldoFinanciar  , contratoNumCuotasFinanciar  , contratoValorCuotaFinanciar  , contratoEstadoPago  , contratoPorcentajePago  , "
     . "contratoTitular  , contratoCotitular  , contratoBeneficiarios  , contratoObservaciones, contratoTipoDocumento, contratoDocumento  , contratoCreo"
     . ") VALUES  (?, ?, ? , ? , ? , ? , ? , ? ,? , ? , ? ,? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ?  ) ; ";
    $resultado = self::crearUltimoId(
      $query,
      array($contratoSede, $contratoFirmadoen, $contratoFecha, $contratoConsecutivo, $contratoAnosPlanPagos, $contratoAnos,
      $contratoGastosLegales,
      $contratoXpack, $contratoValorContrato, $contratoIvaContrato, $contratoValorAnoContrato, $contratoCuotaInicial, $contratoPagoInicial,
      $contratoSaldoCuotaInicial, $contratoNumCuotasCuotaInicial, $contratoValorCuotaCuotaInicial, $contratoSaldoFinanciar,
      $contratoNumCuotasFinanciar, $contratoValorCuotaFinanciar, $contratoEstadoPago, $contratoPorcentajePago, $contratoTitular,
      $contratoCotitular,
      $contratoBeneficiarios, $contratoObservaciones, $contratoTipoDocumento, $contratoDocumento, Visitante::idUsuario())
    );
    if(($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  public static
   function actualizarDocumento($idContrato, $idDocumento) {
    self::$campos = array();
    $query = "UPDATE " . self::$nTabla . " "
     . "SET contratoDocumento = ?   "
     . "WHERE " . self::$nTabla . ".contratoId = ? ; ";
    array_push(self::$campos, $idDocumento);
    array_push(self::$campos, $idContrato);
    $resultado = self::modificarRegistros($query, self::$campos);
    if(($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  public static
   function anular($idContrato) {
    self::$campos = array();
    $query = "UPDATE " . self::$nTabla . " "
     . "SET contratoEstado = 3, contratoAnulado = CURRENT_TIMESTAMP, contratoAnulo = ?   "
     . "WHERE " . self::$nTabla . ".contratoId = ? ; ";
    array_push(self::$campos, Visitante::idUsuario());
    array_push(self::$campos, $idContrato);
    $resultado = self::modificarRegistros($query, self::$campos);
    if(($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  public static
   function activar($idContrato) {
    self::$campos = array();
    $query = "UPDATE " . self::$nTabla . " "
     . "SET contratoEstado = 1, contratoActivado = CURRENT_TIMESTAMP, contratoActiva = ?   "
     . "WHERE " . self::$nTabla . ".contratoId = ? ; ";
    array_push(self::$campos, Visitante::idUsuario());
    array_push(self::$campos, $idContrato);
    $resultado = self::modificarRegistros($query, self::$campos);
    if(($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  public static
   function inactivar($idContrato) {
    self::$campos = array();
    $query = "UPDATE " . self::$nTabla . " "
     . "SET contratoEstado = 2, contratoInactivo = CURRENT_TIMESTAMP, contratoInactiva = ?   "
     . "WHERE " . self::$nTabla . ".contratoId = ? ; ";
    array_push(self::$campos, Visitante::idUsuario());
    array_push(self::$campos, $idContrato);
    $resultado = self::modificarRegistros($query, self::$campos);
    if(($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  public static
   function eliminar($idContrato) {
    self::$campos = array();
    $query = "DELETE FROM contratosafiliados WHERE contratoId = " . $idContrato . " ; "
     . "DELETE FROM oneclass_soca.contratosafiliadosbeneficios WHERE contratobeneficioContrato = " . $idContrato . "; "
     . "DELETE FROM oneclass_soca.contratosafiliadosdocumentos WHERE contratodocumentoContrato = " . $idContrato . "; "
     . "DELETE FROM oneclass_soca.contratosafiliadospagos WHERE contratoPagoContrato = " . $idContrato . "; "
     . "DELETE FROM oneclass_soca.contratosafiliadosplanpagos WHERE planpagosContrato = " . $idContrato . "; ";
    $resultado = self::modificarRegistros($query);
    if(($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

  static public
   function buscar($fecha_desde, $fecha_hasta, $sede, $estado, $servicio) {
    $sql = "SELECT
    contratosafiliados.*
    , sedes.sedeCodigo
    , sedes.sedeNombre
    , estadopagos.estadoPagoCodigo
    , estadopagos.estadoPagoTitulo
    , estadocontratos.estadoContratoCodigo
    , estadocontratos.estadoContratoTitulo
    , titular.personaTipoIdentificacion AS titularTipoIdentificacion
    , titular.personaIdentificacion AS titularIdentificacion
    , titular.personaNombres AS titularNombres
    , titular.personaApellidos AS titularApellidos
    , cotitular.personaTipoIdentificacion AS cotitularTipoIdentificacion
    , cotitular.personaIdentificacion AS cotitularIdentificacion
    , cotitular.personaNombres AS cotitularNombres
    , cotitular.personaApellidos AS cotitularApellidos
    , documentos.documentoUrl
    , documentos.documentoTitulo
    , usuarios.usuarioNombre
    , (SELECT SUM(contratosafiliadospagos.contratoPagoBase + contratosafiliadospagos.contratoPagoImpuestos) FROM contratosafiliadospagos  WHERE contratosafiliados.contratoId = contratosafiliadospagos.contratoPagoContrato ) AS totalPagado
FROM
    contratosafiliados
    INNER JOIN sedes 
        ON (contratosafiliados.contratoSede = sedes.sedeId)
    INNER JOIN estadopagos 
        ON (contratosafiliados.contratoEstadoPago = estadopagos.estadoPagoId)
    INNER JOIN estadocontratos 
        ON (contratosafiliados.contratoEstado = estadocontratos.estadoContratoId)
    INNER JOIN usuarios 
        ON (contratosafiliados.contratoCreo = usuarios.usuarioId)
    INNER JOIN documentos 
        ON (contratosafiliados.contratoDocumento = documentos.documentoId)
    INNER JOIN personas AS titular
        ON (contratosafiliados.contratoTitular = titular.personaId)
    LEFT JOIN personas AS cotitular
        ON (contratosafiliados.contratoCotitular = cotitular.personaId) ";
    $query = $sql . " WHERE ( contratosafiliados.contratoFecha BETWEEN ? AND  ? )  ";
    $DATOS = array($fecha_desde . ' 00:00:00', $fecha_hasta . ' 23:59:59');
    if($sede != 0) {
      $query .= ' AND  ( contratosafiliados.contratoSede = ? ) ';
      array_push($DATOS, $sede);
    }
    if($estado != 0) {
      $query .= ' AND  ( contratosafiliados.contratoEstadoPago = ? ) ';
      array_push($DATOS, $estado);
    }
    if($servicio != 0) {
      $query .= ' AND  ( contratosafiliados.contratoEstado = ? ) ';
      array_push($DATOS, $servicio);
    }



    $query .= ' ORDER BY contratosafiliados.contratoId ';
    $resultado = self::consulta($query, $DATOS);
    if(count($resultado) > 0) {
      return $resultado;
    }
    return NULL;
  }

}