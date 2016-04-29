# Procedimientos Almacenados
# --------------------------------------------------------------------------------------
USE  dblearning;
DELIMITER //
DROP PROCEDURE IF  EXISTS sp_InicioSesion;
//
CREATE PROCEDURE sp_InicioSesion(OUT mensaje VARCHAR(24),
								 IN  alias VARCHAR(100),
								 IN  clave VARCHAR(400))
BEGIN 
	 IF EXISTS (SELECT * FROM dblearning.Usuario WHERE dblearning.Usuario.alias = alias AND 
	 												  dblearning.Usuario.clave = clave)THEN                                                      
			SET mensaje = (SELECT dblearning.Usuario.nombre FROM dblearning.Usuario WHERE dblearning.Usuario.alias = alias AND 
	 												  dblearning.Usuario.clave = clave);
	 ELSE
			SET mensaje = '0';
	 END IF;
END//

# --------------------------------------------------------------------------------------
USE dblearning
DELIMITER $$
DROP PROCEDURE IF EXISTS sp_ListarCursos
$$
CREATE PROCEDURE sp_ListarCursos(IN p_idUsuario INT)
BEGIN
	IF(p_idUsuario = 0) THEN
		SELECT dblearning.Curso.nombre AS 'Nombre'
		FROM dblearning.Curso;
	ELSE
		SELECT C.nombre AS 'Nombre'
		FROM dblearning.Matricula AS M INNER JOIN dblearning.CursoFecha AS CF  ON M.idCursoFecha = CF.idCursoFecha  
									   INNER JOIN dblearning.Curso AS C        ON C.idCurso = CF.idCurso
        WHERE CF.idUsuario = p_idUsuario;
	END IF;
END
$$
# -------------------------------------------------------------------------------------
DELIMITER //
DROP PROCEDURE IF EXISTS sp_Opciones;
//
CREATE PROCEDURE sp_Opciones(IN p_nombre VARCHAR(100))
BEGIN 

	SELECT O.valor AS 'valor' 
    FROM dblearning.Opciones AS O 
    WHERE O.nombre = p_nombre
    LIMIT 1;
	
END
//

#--------------------------------------------------------------------------------

