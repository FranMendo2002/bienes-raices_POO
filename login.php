<?php

    // Conectar DB
    require 'includes/app.php';
    $db = conectarDB();

    $errores = [];

    // Autenticar el usuario

    if($_SERVER["REQUEST_METHOD"] === "POST") {

        // Datos sanitizados
        $email = mysqli_real_escape_string( $db, filter_var($_POST["email"], FILTER_VALIDATE_EMAIL));

        $password = mysqli_real_escape_string( $db, $_POST["password"] );

        if(!$email){
            $errores[] = "El email es obligatorio o no es válido";
        }

        if(!$password) {
            $errores[] = "La contraseña es obligatoria";
        }

        if(empty($errores)) {
            
            // Revisar si un usuario existe o no
            $query = "SELECT * FROM usuarios WHERE email = '${email}'";
            $resultado = mysqli_query($db, $query);

            if( $resultado->num_rows ){
                // Revisar si el password es correcto
                $usuario = mysqli_fetch_assoc($resultado);

                // Veriricar si el password es correcto
                $auth = password_verify($password, $usuario["password"]);

                if($auth) {
                    // El usuario está autenticado
                    session_start();

                    // Llenar el arreglo de la sesion
                    $_SESSION['usuario'] = $usuario['email'];
                    $_SESSION['login'] = true;

                    header('Location: /admin');
                } else {
                    $errores[] = "La contraseña es incorrecta";
                }

            } else {
                $errores[] = "El usuario ingresado no existe";
            }
        }
    }


    // Incluye el header
    incluirTemplate('header');
?>

<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar Sesión</h1>

    <?php
        foreach ($errores as $error):
    ?>
        <div class="alerta error">
            <?php echo $error ?>
        </div>
    <?php endforeach; ?>

    <form method="POST" class="formulario">
        <fieldset>
            <legend>Email y Password</legend>

            <label for="email">E-mail</label>
            <input name="email" id="email" type="email" placeholder="Tu email" required>

            <label for="password">Password</label>
            <input name="password" id="password" type="password" placeholder="Tu password" required>
        </fieldset>

        <input type="submit" value="Iniciar Sesión" class="boton boton-verde">

    </form>
</main>

<?php incluirTemplate('footer'); ?>