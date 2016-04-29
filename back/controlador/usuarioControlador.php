<?php
//AccesoBD
//include "../bibliotecas/shared/ez_sql_core.php";
//include '../bibliotecas/conexion.php';
// 
include '../dao/implementacion/DaoCrudUsuarioImpl.php';

 // Nuestra manera personalizada segura de iniciar sesión PHP.
 // sec_session_start();



if (isset($_POST['alias'], $_POST['clave'])) {
    $alias = $_POST['alias'];
    $clave = $_POST['clave']; // La contraseña con hash

//    $usuarioSesion = new Usuario;

//    $usuarioSesion.setAlias($alias);
//    $usuarioSesion.setClave($clave);

//    $usuarioSesion = 'jhon';
 
//    $usuarioDao = new DaoCrudUsuarioImpl();
//    $mensaje = $usuarioDao.inicioSesion($usuarioSesion);

    $mensaje = '1';

    if($mensaje == "1"){
        
echo $alias;
echo $clave;
        echo "valor:1";

    }
    else{
        echo "valor: 2";

        break;
    }

} else {
    // Las variables POST correctas no se enviaron a esta página.
    echo 'Solicitud no válida';
}
?>