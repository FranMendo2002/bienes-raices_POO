<?php

    require '../../includes/app.php';
    use App\Propiedad;
    use Intervention\Image\ImageManagerStatic as Image;

    estaAutenticado();

    $db = conectarDB();

    $propiedad = new Propiedad;

    // Consultar para obtener los vendedores
    $query = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $query);

    // Areglo con mensajes de errores

    $errores = Propiedad::getErrores();

    // Ejecutar el codigo después de que el usuario envia el formulario
    if ($_SERVER["REQUEST_METHOD"] === 'POST') {
        $propiedad = new Propiedad($_POST);

        // Generar un nombre unico
        $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

        // Seteamos la imagen
        // Realiza un resize a la imagen con intervention image
        if($_FILES["imagen"]["tmp_name"]){
            $image = Image::make($_FILES["imagen"]["tmp_name"])->fit(800, 600);
            $propiedad->setImagen($nombreImagen);
        }

        $errores = $propiedad->validar();

        // Revisar que el arreglo de errores esté vacio
        if (empty($errores)) {
            /** SUBIDA DE ARCHIVOS **/
            // Crear carpeta
            if(!is_dir(CARPETA_IMAGENES)){
                mkdir(CARPETA_IMAGENES);
            }
            
            // Guardar la imagen en el servidor
            $image->save(CARPETA_IMAGENES . $nombreImagen);
            $resultado = $propiedad->guardar();

            if ($resultado) {
                // Redireccionar al usuario
                header('Location: /admin?resultado=1');
            }
        }
    }

    incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Crear</h1>

    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error) { ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php } ?>

    <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
        <?php include '../../includes/templates/formulario_propiedades.php' ?>

        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
    </form>
</main>

<?php incluirTemplate('footer'); ?>