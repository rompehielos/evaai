<?php

class Usuario {
	private $id, $nombre, $apellido, $email, /*$clave,*/ $status;
	
	public function crearUsuario() {
		
	}
	
	public function ponerId($id) {
		$usuario = $aidb->get_row("SELECT * FROM Usuarios WHERE id = $id LIMIT 1");
		if($usuario > 0) {
			$nombre = $usuario->nombre;
		}
	}
	
	public function guardarUsuario() {
		$create_user = $aidb->query("INSERT INTO Usuarios() VALUES()");
	}
	
	public function eliminarUsuario() {
		
	}
	
	public function iniciarSesion() {
	
	}
}
