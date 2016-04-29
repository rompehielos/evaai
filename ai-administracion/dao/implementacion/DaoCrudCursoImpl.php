<?php

#include("../interfaces/IDaoCrudUsuario.php");
#include ('/var/www/ai-administracion/bibliotecas/conexion.php');

include ('/var/www/ai-adjuntos/class-ai-db.php');
include ('/var/www/ai-administracion/beans/CursoBean.php');

class DaoCrudCursoImpl {
	private $nombre;
	private $descripcion;

	private $conexion;
	private $pst;
	private $rs;

	function __construct(){}
/*
	function __construct($nombre, $descripcion){
		$this->nombre = $nombre;
		$this->descripcion = $descripcion;
	}*/

	public function ingresarCurso(UsuarioBean $usuarioBean){
		$query="insert into cursos (idCurso,idCursoPadre,idModulo,nombre,descripcion,idCategoria) values (".$usuarioBean->getIdCurso().",".$usuarioBean->getIdCursoPadre().",".$usuarioBean->getIdModulo().",'".$usuarioBean->getNombre()."','".$usuarioBean->getDescripcion()."',".$usuarioBean->getIdCategoria().")";

		$flag;
		echo $query;
		try{

			$this->conexion = new Conexion();			
			$flag=$this->conexion->query($query);
			$this->cerrarConexion();
		}catch(Exception $e){
			echo "Exception inresarCurso: ".$e->getMessage();
		}
		return $flag;
	}

	public function listarCurso(){
		
		
		$query = "select * from Curso where idCursoPadre is null or idCursoPadre<>0";
		$result = array();
		try{
			$this->conexion = new Conexion();
			$this->pst = $this->conexion->query($query);
			//$result = $this->pst->fetch_array(MYSQLI_BOTH);
			while($row = $this->pst->fetch_array()){
				$bean = new CursoBean();
				$curso = CursoBean();
				$curso->setIdCurso(4);
				$curso->setIdCursoPadre();
				$curso->setIdModulo(1);
				$curso->setNombre("Controlador de Versiones");
				$curso->setDescripcion("descripcion ...");
				$curso->setIdCategoria(0);
				array_push($result,$bean);
			}
		}catch(Exception $e){
			echo "Excepción listarCurso: ".$e->getMessage(). "\n";
		}
		
		return $result;



	}

	public function editarCurso(){

	}

	public function borrarCurso(){

	}
	

	public function cerrarConexion(){
		if($this->rs!=null){
			$this->rs->close();
		}

		if($this->pst!=null){
			$this->pst->close();
		}

		if($this->conexion!=null){
			$this->conexion->close();
		}
	}
}

include ('/var/www/ai-administracion/beans/CursoBean.php');
$init = new DaoCrudCursoImpl();

$curso = CursoBean();
$curso->setIdCurso(4);
//$curso->setIdCursoPadre();
$curso->setIdModulo(1);
$curso->setNombre("Controlador de Versiones");
$curso->setDescripcion("descripcion ...");
$curso->setIdCategoria(0);



$res=$init->ingresarCurso($curso);
echo "el valor es ".$res;
