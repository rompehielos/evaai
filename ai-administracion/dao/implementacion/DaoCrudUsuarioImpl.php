﻿<?php

#include("../interfaces/IDaoCrudUsuario.php");
include ('/var/www/ai-adjuntos/class-ai-db.php');


 class DaoCrudUsuarioImpl{
 	// class DaoCrudUsuariolmpl implements IDaoCrudUsuario {
 	private $user;
 	private $pass;

	function __construct($usuario,$password){
 		$this->user = $usuario;
 		$this->pass = $password;

 	}
	public function inicioSesion() {		
		$db = new Conexion();		
		$db->query("CALL sp_InicioSesion(@mensaje, '$this->user', '$this->pass')");
		$resultado = $db->query("SELECT @mensaje AS nombre");
		$fila = $resultado->fetch_assoc();
		return $fila['nombre'];
	}	

}


