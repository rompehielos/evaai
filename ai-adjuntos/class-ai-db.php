<?php

class Conexion extends mysqli {



	public function __construct(){
		parent:: __construct('localhost','root','1turing1','dblearning');
		#	$this->query("SET NAMES'utf8';");
			#$this->connect_errno ? die('error en la Conexion');
	}

	public function cerrarConexion(){
		$this->close();
	}

	function obtener_fila($consulta){
		
		if ($resultado = $this->query($consulta)) {

		    /* obtener el array de objetos */
		    #while ($fila = $resultado->fetch_row()) {
			#printf ("%s (%s)\n", $fila[0], $fila[1]);
			return $resultado->fetch_row();
		}
		
		else {
			return null;
		}
		/* liberar el conjunto de resultados */

		$resultado->close();
	}
	
	function obtener_valor($consulta) {
		if ($resultado = $this->query($consulta)) {

		    /* obtener el array de objetos */
		    $fila = $resultado->fetch_row();
			return $fila[0];
		}
		
		else {
			return null;
		}
	}
}

global $aidb;
$aidb = new Conexion();



?>
