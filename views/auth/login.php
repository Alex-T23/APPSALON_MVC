<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia Sesión con tus Datos.</p>

<?php include_once __DIR__ . "/../templates/alertas.php" ?>

<form action="/" class="formulario" method="POST">
    <div class="campo">
        <label for="email">Email</label>
        <input type="text" id="email" name="email" placeholder="Escribe aquí tu email">
    </div>
    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" placeholder="Escribe aquí tu contraseña">
    </div>

    <input type="submit" class="boton" value="Iniciar Sesión">
</form>

<div class="acciones">
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crea una aquí</a>
    <a href="/olvide">¿Olvidaste tu contraseña?</a>
</div>