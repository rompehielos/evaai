<?php

$modo = isset($_POST['valor']) ? $_POST['valor'] : 'login';

switch ($modo) {
    case 'login':
            if(isset($_POST['valor'])){
                if(!empty($_POST['alias']) and !empty($_POST['clave'])) {
                    include('/var/www/ai-administracion/dao/implementacion/DaoCrudUsuarioImpl.php');
                    $login = new DaoCrudUsuarioImpl($_POST['alias'], $_POST['clave']);
                    
                    $nombre  = $login->inicioSesion();
                    
                    if(!empty($nombre)){
                        #echo("Bienvenido, $nombre,soy Evaai");
                        $redireccion = $_REQUEST['redirect_to'];
                        header("Location: $redireccion");
                    }
                    else {
                        #echo("Zopencudo usuario.");
                        //La cabecera deberìa retornar a la misma ai-login.php.
						header("Location: ".$_SERVER['HTTP_REFERER']);
                    }
                }
            }
}
?>