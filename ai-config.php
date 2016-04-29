<?php
define('DB_NAME', 'dblearning');

define('DB_USER', 'root');

define('DB_PASSWORD', '1turing1');

define('DB_HOST', 'localhost');

define('DB_CHARSET', 'utf8');

define('DB_COLLATE', '');

/** Habilitar la depuración de Amauto Imperial. */
define('AI_DEBUG', false);

/** Absolute path to the Amauto Imperial directory. */
if ( !defined('ABSPATH') ) {
	define('ABSPATH', dirname(__FILE__) . '/');
}

/** Establece variables de Amauto Imperial e incluye archivos. */
require_once(ABSPATH . 'ai-settings.php');
