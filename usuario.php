<?php

    // Importar la conexion
    require 'includes/config/database.php';
    $db = conectarDB();

    // Crear un email y password
    $email = "correo@correo.com";
    $password = "123456";

    // Password hash toma 2 parametros, el password que hasheamos y el algoritmo
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    // Query para crear el usuario
    $query = "INSERT INTO usuarios (email, password) VALUES( '${email}', '${passwordHash}' )";
    //echo $query;

    // Agregarlo a la Base de Datos
    mysqli_query($db, $query);

?>