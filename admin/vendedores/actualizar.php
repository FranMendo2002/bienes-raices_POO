<?php 

    require '../../includes/app.php';

    use App\Vendedor;
    use Intervention\Image\ImageManagerStatic as Image;
    estaAutenticado();

    // Validar que sea un ID valido
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    if(!$id) {
        header('Location: /admin');
    }

    $vendedor = Vendedor::find($id);

    $errores = Vendedor::getErrores();

    if($_SERVER["REQUEST_METHOD"] === 'POST') {
        
        $vendedor->sincronizar($_POST);

        // Validacion
        $errores = $vendedor->validar();

        if( empty($errores) ) {
            $nombreImagen = md5( uniqid( rand(), true) ) . ".jpg";
            
            if($_FILES["imagen"]["tmp_name"]) {
                $image = Image::make($_FILES["imagen"]["tmp_name"])->fit(800, 600);
                $vendedor->borrarImagen();
                $vendedor->setImagen($nombreImagen);
                $image->save(CARPETA_IMAGENES . $nombreImagen);
            }
            // Guardar los datos
            $vendedor->guardar();
        }
        
        
    }

    incluirTemplate('header');

?>


<main class="contenedor seccion">
    <h1>Actualizar vendedor</h1>

    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error) { ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php } ?>

    <form class="formulario" method="POST"" enctype="multipart/form-data">
        <?php include '../../includes/templates/formulario_vendedores.php' ?>

        <input type="submit" value="Actualizar Vendedor" class="boton boton-verde">
    </form>
</main>