<?php

class CursoBean{
	private $idCurso;
	private $idCursoPadre;
	private $idModulo;
	private $nombre;
	private $descripcion;
	private $idCategoria;

	public function getIdCurso(){
		return $this->idCurso;
	}	

	public function setIdCurso($idCurso){
		$this->idCurso=$idCurso;
	}

	public function getIdCursoPadre(){
		return $this->idCursoPadre;
	}

	public function setIdCursoPadre($idCursoPadre){
		$this->idCursoPadre = $idCursoPadre;
	}

	public function getIdModulo(){
		return $this->idModulo;
	}

	public function setIdModulo($idModulo){
		$this->idModulo = $idModulo;
	}

	public function getNombre(){
		return $this->Nombre;
	}

	public function setNombre($nombre){
		$this->nombre=$nombre;
	}

	public function getDescripcion(){
		return $this->descripcion;
	}

	public function setDescripcion($descripcion){
		$this->descripcion = $descripcion;
	}

	public function getIdCategoria(){
		return $this->idCategoria;
	}

	public function setIdCategoria($idCategoria){
		return $this->idCategoria=$idCategoria;
	}
}