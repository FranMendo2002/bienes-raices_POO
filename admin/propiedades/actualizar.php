<?php

use App\Propiedad;
use Intervention\Image\ImageManagerStatic as Image;

require '../../includes/app.php';

    estaAutenticado();

    // Validar la URL por ID válido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    

    if(!$id) {
        header('Location: /admin');
    }

    // Consultar para obtener los vendedores
    $query = "SELECT * FROM vendedores";
    $resultadoVendedor = mysqli_query($db, $query);

    // Obtener los datos de la propiedad
    $propiedad = Propiedad::find($id);


    // Areglo con mensajes de errores
    $errores = Propiedad::getErrores();


    // Ejecutar el codigo después de que el usuario envia el formulario
    if ($_SERVER["REQUEST_METHOD"] === 'POST') {
        // Asignar los atributos
        $propiedad->sincronizar($_POST);

        // Validamos
        $errores = $propiedad->validar();

        // Revisar que el arreglo de errores esté vacio
        if (empty($errores)) {
            // Generar un nombre unico
            $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

            // Subida de archivos
            if($_FILES["imagen"]["tmp_name"]){
                $image = Image::make($_FILES["imagen"]["tmp_name"])->fit(800, 600);
                $propiedad->setImagen($nombreImagen);
                // Almacenar la imagen
                $image->save(CARPETA_IMAGENES . $nombreImagen);
            }

            // Guardar los datos
            $resultado = $propiedad->guardar();
        }
    }

    incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Actualizar Propiedad</h1>

    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error) { ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php } ?>

    <form class="formulario" method="POST" enctype="multipart/form-data">
        <?php include '../../includes/templates/formulario_propiedades.php'; ?>

        <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
    </form>
</main>

<?php incluirTemplate('footer'); ?>