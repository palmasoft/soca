<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of enBlanco
 *
 * @author Toshiba
 */
Modelos::cargar("Datos" . DS . "Sistema" . DS . "Usuarios");
class usuariosControlador extends Controladores {

  function mostrarPerfil() {
    Vistas::mostrar('perfilUsuario');
  }
 
}