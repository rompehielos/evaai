
<html>
<section class="loginform cf">
<form name="login" action="controlador/usuarioControlador.php" method="POST" accept-charset="utf-8">
    <ul>
        <label for="usermail">Email</label>
        <input type="text" name="alias" id ="alias" required></li>

        <label for="password">Password</label>
        <input type="password" name="clave" id = "name" required></li>

        <input type="hidden" name="valor"  id = "login" value = "login"/>       

        <input type="submit" value="Login"></li>
    </ul>
</form>
</section>

</html>