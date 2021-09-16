<?php 

    require '../../includes/app.php';

    use App\Vendedor;
    use Intervention\Image\ImageManagerStatic as Image;
    estaAutenticado();

    $vendedor = new Vendedor;
    $errores = Vendedor::getErrores();

    if($_SERVER["REQUEST_METHOD"] === 'POST') {
        $vendedor = new Vendedor($_POST);
        $nombreImagen = md5( uniqid( rand(), true) ) . ".jpg";
        if($_FILES["imagen"]["tmp_name"]):
            $image = Image::make($_FILES["imagen"]["tmp_name"])->fit(800, 600);
            $vendedor->setImagen($nombreImagen);
        endif;

        // Validar que no haya campos vacios
        $errores = $vendedor->validar();
        
        // No hay errores
        if( empty($errores) ) {
            /** SUBIDA DE ARCHIVOS **/
            // Crear carpeta
            if(!is_dir(CARPETA_IMAGENES)){
                mkdir(CARPETA_IMAGENES);
            }
            
            $resultado = $vendedor->guardar();

            if ($resultado) {
                // Guardar la imagen en el servidor
                $image->save(CARPETA_IMAGENES . $nombreImagen);
                // Redireccionar al usuario
                header('Location: /admin?resultado=1');
            }
        }
        
    }

    incluirTemplate('header');

?>


<main class="contenedor seccion">
    <h1>Registrar vendedor</h1>

    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error) { ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php } ?>

    <form class="formulario" method="POST" action="/admin/vendedores/crear.php" enctype="multipart/form-data">
        <?php include '../../includes/templates/formulario_vendedores.php' ?>

        <input type="submit" value="Registrar Vendedor" class="boton boton-verde">
    </form>
</main>