<?php

include '../beans/Usuario.php';
include '/../interfaces/IDaoCrudUsuario.php';

 class DaoCrudUsuariolmpl implements IDaoCrudUsuario {
 	// class DaoCrudUsuariolmpl implements IDaoCrudUsuario {

	public function registrar($object){}
	public function inicioSession($object){
		sec_session_start();
		// Abstractfactory


 $mysqli->query("select");

	}	

}


?>