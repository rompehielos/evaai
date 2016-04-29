<?php

class sesionControlador{

   function __construct() {
   // configura las funciones de la sesión personalizada.
   session_set_save_handler(array($this, 'open'), array($this, 'close'), array($this, 'read'), array($this, 'write'), array($this, 'destroy'), array($this, 'gc'));
 
   // Esta línea evita efectos inesperados al usar objetos como manipuladores de guardado.
   register_shutdown_function('session_write_close');
   }

   function inicio_sesion($session_name, $secure) {
         // Asegúrate de que la cookie de sesión no pueda accederse por javascript.
         $httponly = true;
       
         // algoritmo hash para usar con sessionid. (usa hash_algos() para ver una lista de los hash disponibles)
         $session_hash = 'sha512';
       
         // Revisa si hay un hash disponible
         if (in_array($session_hash, hash_algos())) {
            // Configura la función hash.
            ini_set('session.hash_function', $session_hash);
         }
         // Cuántos bits por caracter del hash.
         // Los valores posibles son '4' (0-9, a-f), '5' (0-9, a-v), y '6' (0-9, a-z, A-Z, "-", ",").
         ini_set('session.hash_bits_per_character', 5);
       
         // Fuerza a la sesión para que sólo use cookies, no variables URL.
         ini_set('session.use_only_cookies', 1);
       
         // Consigue los parámetros de la cookie de la sesión
         $cookieParams = session_get_cookie_params(); 
         // Configura los parámetros
         session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly); 
         // Cambia el nombre de la sesión
         session_name($session_name);
         // Ahora podemos iniciar la sesión
         session_start();
         // Esta línea regenera la sesión y elimina la anterior.
         // También genera una nueva clave de cifrado en la base de datos. 
         session_regenerate_id(true); 
   }

   function cerrar() {
         $this->db->cerrar();
         return true;
   }

   function leer($id) {
         if(!isset($this->read_stmt)) {
            $this->read_stmt = $this->db->prepare("SELECT clave FROM Log WHERE id = ? LIMIT 1");
         }
         $this->read_stmt->bind_param('s', $id);
         $this->read_stmt->execute();
         $this->read_stmt->store_result();
         $this->read_stmt->bind_result($data);
         $this->read_stmt->fetch();
         $key = $this->getkey($id);
         $data = $this->decrypt($data, $key);
         return $data;
   }

   function escribir($id, $data) {
         // Consigue una clave única
         $key = $this->getkey($id);
         // Cifra los datos
         $data = $this->encrypt($data, $key);
       
         $time = time();
         if(!isset($this->w_stmt)) {
            $this->w_stmt = $this->db->prepare("REPLACE INTO sesiones (id, horario, data, clave_sesion) VALUES (?, ?, ?, ?)");
         }
       
         $this->w_stmt->bind_param('siss', $id, $time, $data, $key);
         $this->w_stmt->execute();
         return true;
   }


   function destruir($id) {
         if(!isset($this->delete_stmt)) {
            $this->delete_stmt = $this->db->prepare("DELETE FROM sesiones WHERE id = ?");
         }
         $this->delete_stmt->bind_param('s', $id);
         $this->delete_stmt->execute();
         return true;
   }


   function gc($max) {
         if(!isset($this->gc_stmt)) {
            $this->gc_stmt = $this->db->prepare("DELETE FROM sesiones WHERE horario < ?");
         }
         $old = time() - $max;
         $this->gc_stmt->bind_param('s', $old);
         $this->gc_stmt->execute();
         return true;
   }

   private function getkey($id) {
         if(!isset($this->key_stmt)) {
            $this->key_stmt = $this->db->prepare("SELECT clave_sesion FROM sesiones WHERE id = ? LIMIT 1");
         }
         $this->key_stmt->bind_param('s', $id);
         $this->key_stmt->execute();
         $this->key_stmt->store_result();
         if($this->key_stmt->num_rows == 1) { 
            $this->key_stmt->bind_result($key);
            $this->key_stmt->fetch();
            return $key;
         } else {
            $random_key = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
            return $random_key;
         }
   }


   private function encrypt($data, $key) {
      $salt = 'cH!swe!retReGu7W6bEDRup7usuDUh9THeD2CHeGE*ewr4n39=E@rAsp7c-Ph@pH';
      $key = substr(hash('sha256', $salt.$key.$salt), 0, 32);
      $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
      $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
      $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $data, MCRYPT_MODE_ECB, $iv));
      return $encrypted;
   }

   private function decrypt($data, $key) {
      $salt = 'cH!swe!retReGu7W6bEDRup7usuDUh9THeD2CHeGE*ewr4n39=E@rAsp7c-Ph@pH';
      $key = substr(hash('sha256', $salt.$key.$salt), 0, 32);
      $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
      $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
      $decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, base64_decode($data), MCRYPT_MODE_ECB, $iv);
      return $decrypted;
   }
}

?>