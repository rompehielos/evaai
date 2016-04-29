<?php
 class Usuario{

  private $id;
  private $nombre;
  private $apellido;
  private $correo;
  private $alias;
  private $clave;
  private $estado;

//function __construct($id,$nombre,$apellido,$correo,$alias,$clave,$estado){
function __construct($uno,$dos,$tres,$cuatro,$cinco,$seis,$siete){

	 $this->id = $id;
	 $this->nombre = $nombre;
	 $this->apellido = $apellido;
	 $this->correo = $correo;
	 $this->alias = $alias;
	 $this->clave = $clave;
	 $this->estado = $estado;
}

	//ID
	public function setId($id){
		$this->id = $id;
	}
	public function getId(){
		return $this->id;
	}


	//NOMBRE
	public function setNombre($nombre){
		$this->nombre = $nombre;
	}
	public function getNombre(){
		return $this->nombre;
	}


	//APELLIDO
	public function setApellido($apellido){
		$this->apellido = $apellido;
	}
	public function getApellido(){
		return $this->apellido;
	}


	//CORREO
	public function setCorreo($correo){
		$this->correo = $correo;
	}
	public function getCorreo(){
		return $this->correo;
	}

	//ALIAS
	public function setAlias($alias){

		$this->alias = $alias;
		echo $alias;
	}
	public function getAlias(){
		return $this->alias;
	}

	//CLAVE
	public function setClave($clave){
		$this->clave = $clave;
	}
	public function getClave(){
		return $this->clave;
	}

	//ESTADO
	public function setEstado($estado){
		$this->estado = $estado;
	}
	public function getEstado(){
		return $this->estado;
	}

}
