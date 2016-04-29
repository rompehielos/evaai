<?php

class Conexion extends mysqli {
	public function __construct(){
		parent:: __construct('localhost','root','1turing1','dblearning');
			$this->query("SET NAMES'utf8';");
			#$this->connect_errno ? die('error en la Conexion');
	}
}

?>