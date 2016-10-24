/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.1.18-MariaDB : Database - oneclass_soca2
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `cantones` */

CREATE TABLE `cantones` (
  `cantonId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cantonProvincia` int(10) NOT NULL,
  `cantonCodigo` varchar(10) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `cantonNombre` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`cantonId`)
) ENGINE=MyISAM AUTO_INCREMENT=222 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

/*Table structure for table `cargosempleados` */

CREATE TABLE `cargosempleados` (
  `cargoEmpleadoId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cargoEmpleadoCodigo` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `cargoEmpleadoTitulo` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `cargoEmpleadoDesc` text COLLATE utf8_spanish2_ci,
  `cargoEmpleadoEstado` varchar(50) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'ACTIVO',
  PRIMARY KEY (`cargoEmpleadoId`),
  UNIQUE KEY `UQ_CargosEmpleados_cargoEmpleadoId` (`cargoEmpleadoId`),
  UNIQUE KEY `UQ_CargosEmpleados_cargoEmpleadoCodigo` (`cargoEmpleadoCodigo`),
  UNIQUE KEY `UQ_CargosEmpleados_cargoEmpleadoTitulo` (`cargoEmpleadoTitulo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

/*Table structure for table `componentes` */

CREATE TABLE `componentes` (
  `componenteId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `componenteCodigo` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `componenteTitulo` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `componenteIcono` varchar(50) COLLATE utf8_spanish2_ci DEFAULT 'fa fa-dashboard',
  PRIMARY KEY (`componenteId`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

/*Table structure for table `funciones` */

CREATE TABLE `funciones` (
  `funcionId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `funcionCodigo` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `funcionNombre` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `funcionModulo` varchar(50) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'sistema',
  `funcionLogica` varchar(50) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'informacion',
  `funcionTarea` varchar(50) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'mostrarInformacion',
  `funcionMenu` enum('SI','NO') COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'SI',
  `funcionPadre` int(10) NOT NULL DEFAULT '0',
  `funcionOrden` int(10) NOT NULL DEFAULT '99',
  PRIMARY KEY (`funcionId`),
  UNIQUE KEY `UQ_FuncionesSistema_funcionId` (`funcionId`),
  UNIQUE KEY `UQ_FuncionesSistema_funcionCodigo` (`funcionCodigo`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

/*Table structure for table `personas` */

CREATE TABLE `personas` (
  `personaId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `personaTipoIdentificacion` int(10) NOT NULL,
  `personaIdentificacion` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `personaRazonSocial` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `personaNombreComercial` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `personaNombres` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `personaApellidos` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `personaProvincia` int(10) DEFAULT NULL,
  `personaCanton` int(10) DEFAULT NULL,
  `personaDireccion` text COLLATE utf8_spanish2_ci,
  `personaTelefono` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `personaCelular` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `personaCorreoElectronico` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `personaLatitud` varchar(50) COLLATE utf8_spanish2_ci DEFAULT '11.2272989',
  `personaLongitud` varchar(50) COLLATE utf8_spanish2_ci DEFAULT '-74.1967533',
  `personaObservaciones` text COLLATE utf8_spanish2_ci,
  `personaLogo` varchar(255) COLLATE utf8_spanish2_ci DEFAULT '/archivos/img/fotos.png',
  `personaFotoReferencia` varchar(255) COLLATE utf8_spanish2_ci DEFAULT '/archivos/img/fotos.png',
  `personaFirmaEscaneada` varchar(255) COLLATE utf8_spanish2_ci DEFAULT '/archivos/img/firma.png',
  `personaFechaCreado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `personaUsuarioCrea` bigint(20) NOT NULL,
  `personaFechaModificado` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `personaUsuarioModifica` bigint(20) DEFAULT NULL,
  `personaFechaBorrado` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `personaUsuarioBorra` bigint(20) DEFAULT NULL,
  `personaEstado` enum('ACTIVO','BORRADO') COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'ACTIVO',
  PRIMARY KEY (`personaId`),
  UNIQUE KEY `UQ_personas_personaId` (`personaId`),
  UNIQUE KEY `UQ_personas_personaIdentificacion` (`personaIdentificacion`),
  KEY `IXFK_personas_TipoIdentificacion` (`personaTipoIdentificacion`),
  KEY `IXFK_personas_UsuarioCrea` (`personaUsuarioCrea`),
  KEY `IXFK_personas_UsuarioModifica` (`personaUsuarioModifica`),
  KEY `IXFK_personas_UsuarioBorra` (`personaUsuarioBorra`)
) ENGINE=InnoDB AUTO_INCREMENT=898 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

/*Table structure for table `provincias` */

CREATE TABLE `provincias` (
  `provinciaId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `provinciaCodigo` varchar(10) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `provinciaNombre` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`provinciaId`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

/*Table structure for table `sedes` */

CREATE TABLE `sedes` (
  `sedeId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sedeCodigo` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `sedeNombre` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `sedeDireccion` text CHARACTER SET utf8,
  `sedeColor` varchar(10) COLLATE utf8_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`sedeId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

/*Table structure for table `tiposidentificacion` */

CREATE TABLE `tiposidentificacion` (
  `tipoIdentificacionId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tipoIdentificacionCodigo` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `tipoIdentificacionTitulo` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `tipoIdentificacionEstado` enum('ACTIVO','INACTIVO') COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'ACTIVO',
  PRIMARY KEY (`tipoIdentificacionId`),
  UNIQUE KEY `UQ_TipoIdentificacion_tipoIdentificacionId` (`tipoIdentificacionId`),
  UNIQUE KEY `UQ_TipoIdentificacion_tipoIdentificacionCodigo` (`tipoIdentificacionCodigo`),
  UNIQUE KEY `UQ_TipoIdentificacion_tipoIdentificacionTItulo` (`tipoIdentificacionTitulo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

/*Table structure for table `usuarios` */

CREATE TABLE `usuarios` (
  `usuarioId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `usuarioSede` int(10) DEFAULT NULL,
  `usuarioPersona` bigint(20) NOT NULL,
  `usuarioCargo` int(10) NOT NULL,
  `usuarioTipo` enum('AGENTE','SUPERVISOR','ADMINISTRADOR','SUPER') COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'AGENTE',
  `usuarioNombre` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `usuarioClave` text COLLATE utf8_spanish2_ci,
  `usuarioCorreo` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `usuarioTelefono` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `usuarioUltimoIngreso` timestamp NULL DEFAULT NULL,
  `usuarioUltimaIp` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `usuarioUltimaUbicacionLatitud` varchar(50) COLLATE utf8_spanish2_ci DEFAULT '11.227442290719976',
  `usuarioUltimaUbicacionLongitud` varchar(50) COLLATE utf8_spanish2_ci DEFAULT '-74.196954430081',
  `usuarioCreado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuarioCreo` bigint(20) DEFAULT NULL,
  `usuarioEstado` enum('ACTIVO','DESACTIVO') COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'ACTIVO',
  `usuarioAvatar` varchar(255) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'archivos/oximeiser/avatares/default.png',
  PRIMARY KEY (`usuarioId`),
  UNIQUE KEY `UQ_Usuarios_usuarioId` (`usuarioId`),
  KEY `IXFK_Usuarios_CargosEmpleados` (`usuarioCargo`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

/*Table structure for table `usuariosfunciones` */

CREATE TABLE `usuariosfunciones` (
  `usuarioFuncionId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `usuarioFuncion` bigint(20) NOT NULL COMMENT 'EL usuario al que se le asigna la funcion usuarioFuncionAsignada',
  `usuarioFuncionAsignada` int(10) NOT NULL COMMENT 'funcion que se le asigna a usuarioFuncion',
  `usuarioFuncionAsignado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuarioFuncionAsigna` bigint(20) NOT NULL,
  PRIMARY KEY (`usuarioFuncionId`),
  UNIQUE KEY `UQ_UsuariosFunciones_usuarioFuncionId` (`usuarioFuncionId`),
  KEY `IXFK_UsuariosFunciones_Usuarios` (`usuarioFuncion`),
  KEY `IXFK_UsuariosFunciones_FuncionesSistema` (`usuarioFuncionAsignada`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
