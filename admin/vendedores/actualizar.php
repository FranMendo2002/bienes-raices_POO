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
        
        if($_FILES["imagen"]["tmp_name"]) {
            $image = Image::make($_FILES["imagen"]["tmp_name"])->fit(800, 600);
            $vendedor->setImagen($nombreImagen);
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