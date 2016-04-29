<?php

/** Carga toda la base de Amauto Imperial. */
require( dirname(__FILE__) . '/ai-load.php' );

function cabecera() { ?>
<?php
session_start();


if(isset($_SESSION['nombre'])){
	echo "<p>Has iniciado sesion: " . $_SESSION['nombre'] . "";
echo "<p><a href='pagina3.php'>Cerrar Sesion</a></p>";


	
}

?>

<!DOCTYPE html>
<html>
	<head>
<!-- <script src='https://www.google.com/recaptcha/api.js'></script> -->
		<meta http-equiv="Content-Type" content="utf-8" />
		<title>EVAAI - Amauto Imperial</title>
		<script>
			window.onload = function () {
			document.login.clave.focus();
			document.login.addEventListener('submit', validarFormulario);
			}
			function validarFormulario(evObject) {
				evObject.preventDefault();
				var todoCorrecto = true;
				var formulario = document.login;
				for (var i=0; i<formulario.length; i++) {
					if(formulario[i].type =='text') {
						if (formulario[i].value == null || formulario[i].value.length == 0 || /^\s*$/.test(formulario[i].value)){
							console.log(formulario[i].name+ 'esta vacio');
							todoCorrecto=false;
						}
					}
				}
				if (todoCorrecto ==true) {formulario.submit();}
			}
		</script>
		<style>
			.formulario {
				position: absolute;
				width: 300px;
				border: solid 1px grey;
				margin: 0 auto;
				padding: 20px;
				top: 50%;
				left: 50%;
				transform: translateX(-50%) translateY(-50%);
			}
			input {
				font-size: 2em;
			}
			input[type=text], input[type=password] {
				border: none;
				border-bottom: 1px grey solid;
				width: 100%;
				margin-bottom: 30px;
			}
			input[type=submit] {
				background-color: #99b;
				width: 100%;
				padding: 5%;
			}
			footer {
				text-align: center;
				bottom: 2px;
				position: absolute;
				left: 50%;
				transform: translateX(-50%);
			}
		</style>
	</head>
	<body>



<?php
}

function pedestal() { ?>
			<footer>
				<p class="copyright">Entorno Virtual de Aprendizaje Amauto Imperial.</p>
			</footer>
		</body>
</html>
<?php
}

//***********
//Parte principal del formulario.
//***********
cabecera();
if ( isset( $_REQUEST['redirect_to'] ) ) {
	$redirect_to = $_REQUEST['redirect_to'];
}
else {
	$redirect_to = admin_url();
}
?>
		<section class="formulario">
			<form name="login" action="ai-administracion/controlador/usuarioControlador.php" method="post" accept-charset="utf-8">
				<input placeholder="Nombre" type="text" name="alias" id ="alias"  />
				<input placeholder="Clave" type="password" name="clave" id="clave" />
				<!-- <div class="g-recaptcha" data-sitekey="6Letyh0TAAAAAGWAlPYRC7f6yjYQV0CJr8vVkC0U"></div> -->
				<input type="hidden" name="valor"  id="valor" value="login"/>
				<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect_to ); ?>" />
				<input type="submit" value="Acceder" />
			</form>
		</section>
<?php
pedestal();
