<h1 class="nombre-pagina">Recuperar Contraseña</h1>
<p class="descripcion-pagina">Introduce tu nueva contraseña a continuación.</p>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>
<?php if($error) return; ?>

<form class="formulario" method="POST">
    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" placeholder="Nueva Contraseña" id="password" name="password">
    </div>
    <input type="submit" class="boton" value="Guardar Contraseña">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crea una aquí</a>
</div>