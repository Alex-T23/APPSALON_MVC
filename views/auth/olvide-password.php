<h1 class="nombre-pagina">Recuperar Contraseña</h1>
<p class="descripcion-pagina">Introduce tu E-mail para enviar un enlace de recuperación.</p>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<form action="/olvide" class="formulario" method="POST">
    <div class="campo">
        <label for="email">E-mail:</label>
        <input type="text" id="email" name="email" placeholder="Escribe aquí tu E-mail">
    </div>

    <input type="submit" class="boton" value="Enviar">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crea una aquí</a>
</div>