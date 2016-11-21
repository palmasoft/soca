<!-- sidebar menu -->
<div i>
  <div >
    <ul class="sidebar-menu">
      <li class="header" ><a href="javascript:void(0);" onclick="mostrar_widgets_bienvenida();" ><i class="fa fa-pagelines"></i> Panel de Inicio <span class="fa fa-chevron-circle-right"></span></a>
        <?php foreach($_SESSION['OBJ_USR']->modulos as $Componente): ?>
          <?php if(count($Componente->permisos)): ?>
          <li class="treeview" >
            <a><i class="<?php echo $Componente->moduloIcono ?>"></i> <?php echo $Componente->moduloTitulo ?> <span class="fa fa-chevron-down"></span></a>
            <ul class="treeview-menu">
              <?php foreach($Componente->permisos as $Funcion): ?>
                <li><a href="javacript:void(0)" class="menu-funcion" 
                       data-modulo="<?php echo $Funcion->funcionModulo ?>" 
                       data-controlador="<?php echo $Funcion->funcionControlador ?>" 
                       data-tarea="<?php echo $Funcion->funcionFuncion ?>" >
                    <i class="<?php echo $Componente->funcionIcono ?>"></i> <?php echo $Funcion->funcionTitulo ?></a>
                </li>
              <?php endforeach; ?>
            </ul>
          </li>
        <?php endif; ?>
      <?php endforeach; ?>
    </ul>
  </div>
</div>

<!-- /sidebar menu -->

<script type="text/javascript">
  $(document).ready(function () {
    $('.menu-funcion').on("click", function (evt) {
      evt.preventDefault();
      alert('pailitas ceras');
      mostrarContenidos(
        $(this).attr('data-modulo'), $(this).attr('data-controlador'), $(this).attr('data-tarea')
        );
    });
  });
</script>


<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

