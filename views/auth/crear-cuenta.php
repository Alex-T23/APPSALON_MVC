<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Llena el siguiente formulario para crear una cuenta.</p>

<?php include_once __DIR__ . "/../templates/alertas.php" ?>

<form action="/crear-cuenta" method="POST" class="formulario">
    <div class="campo">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" placeholder="Escribe aquí tu Nombre" value="<?php echo s($usuario->nombre) ?>">
    </div>
    <div class="campo">
        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" placeholder="Escribe aquí tu Apellido" value="<?php echo s($usuario->apellido) ?>">
    </div>
    <div class="campo">
        <label for="telefono">Teléfono:</label>
        <input type="tel" id="telefono" name="telefono" placeholder="Escribe aquí tu Teléfono" value="<?php echo s($usuario->telefono) ?>">
    </div>
    <div class="campo">
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" placeholder="Escribe aquí tu E-mail" value="<?php echo s($usuario->email) ?>">
    </div>
    <div class="campo">
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" placeholder="Escribe aquí tu Contraseña">
    </div>

    <input type="submit" value="Crear Cuenta" class="boton">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/olvide">¿Olvidaste tu contraseña?</a>
</div>