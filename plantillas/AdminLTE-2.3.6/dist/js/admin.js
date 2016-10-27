/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function cerrarSesion() {
  ejecutarAccion(
    'sistema', 'sesion', 'salir', '',
    function (data) {
      window.location = '/';
    }
  );
}