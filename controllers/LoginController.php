<?php

namespace Controllers;

use MVC\Router;
use Classes\Email;
use Model\Usuario;

class LoginController{
    public static function login(Router $router){
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();
            if(empty($alertas)){
                //comprobar que el usuario existe
                $usuario = Usuario::where('email', $auth->email);
                if($usuario){
                    //verificar la contraseña
                    if($usuario->comprobarPasswordAndVerificado($auth->password)){
                        //autenticar el usuario
                        session_start();

                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . ' ' . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        //redireccionamiento
                        if($usuario->admin === "1"){
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                        } else {
                            header('Location: /cita');
                        }
                    }
                } else {
                    Usuario::setAlerta('error', 'Usuario no encontrado');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/login', [
            'alertas' => $alertas
        ]);
    }
    public static function logout(){
        session_start();
        $_SESSION = [];
        header('Location: /');

    }
    public static function olvide(Router $router){
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if(empty($alertas)){
                $usuario = Usuario::where('email', $auth->email);
                if($usuario && $usuario->confirmado === "1"){
                    //generar un nuevo token de un solo uso
                    $usuario->crearToken();
                    $usuario->guardar();
                    //TO-DO: enviarl el email
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarInstrucciones();
                    //alertas
                    Usuario::setAlerta('exito', 'Revisa tu bandeja de entrada');

                } else{
                    Usuario::setAlerta('error', 'El Usuario no existe o no está verificado');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        
        $router->render('auth/olvide-password', [
            'alertas' => $alertas
        ]);
    }
    public static function recuperar(Router $router){
        $alertas = [];
        $error = false;
        $token = s($_GET['token']);
        //buscar al usuario por su token
        $usuario = Usuario::where('token', $token);
        if(empty($usuario)){
            Usuario::setAlerta('error', 'Token No Válido');
            $error = true;
        }
        $alertas = Usuario::getAlertas();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //leer la nueva contraseña y guardarla
            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();
            if(empty($alertas)){
                $usuario->password = null;
                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;
                $resultado = $usuario->guardar();
                if($resultado){
                    header('Location: /');
                }
            }
        }
        $router->render('auth/recuperar-password', [
            'alertas' => $alertas,
            'error' => $error
        ]);
    }
    public static function crear(Router $router){
        $usuario = new Usuario;
        //alertas vacias
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            //revisar que alertas este vacio
            if(empty($alertas)){
                //verificar que el usuario no este ya registrado
                $resultado = $usuario->existeUsuario();

                if($resultado->num_rows){
                    $alertas = Usuario::getAlertas();
                } else {
                    $usuario->hashPassword();

                    $usuario->crearToken();

                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);

                    $email->enviarConfirmacion();

                    $resultado = $usuario->guardar();
                    if($resultado){
                        header('Location: /mensaje');
                    }
                }
            }
        }

        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function confirmar(Router $router){
        $alertas = [];
        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);
        if(empty($usuario)){
            //mensaje de error
            Usuario::setAlerta('error', 'Token No Válido');
        } else {
            //confirmar usuario
            $usuario->confirmado = "1";
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta Confirmada Correctamente');
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/confirmar-cuenta',[
            'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router){
        $router->render("auth/mensaje");
    }
}