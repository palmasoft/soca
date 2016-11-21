<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?php echo Usuario::fotoPersona() ?>" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?php echo Usuario::nombreCompletoUsuario() ?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> Conectado</a>
      </div>
    </div>    
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <?php include 'menu.html.php'; ?>
  </section>
  <!-- /.sidebar -->
</aside>

<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

