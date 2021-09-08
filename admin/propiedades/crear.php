<?php

    require '../../includes/app.php';
    use App\Propiedad;
    use Intervention\Image\ImageManagerStatic as Image;

    estaAutenticado();

    $db = conectarDB();

    // Consultar para obtener los vendedores
    $query = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $query);

    // Areglo con mensajes de errores

    $errores = Propiedad::getErrores();

    $errores = [];
    $titulo = '';
    $precio = '';
    $descripcion = '';
    $habitaciones = '';
    $wc = '';
    $estacionamiento = '';
    $vendedorId = '';

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
        <fieldset>
            <legend>Información General</legend>

            <label for="titulo">Título:</label>
            <input name="titulo" type="text" id="titulo" placeholder="Título de la propiedad" value="<?php echo $titulo; ?>">

            <label for="precio">Precio:</label>
            <input name="precio" type="number" id="precio" placeholder="Precio de la propiedad" value="<?php echo $precio; ?>">

            <label for="imagen">Imagen:</label>
            <input name="imagen" type="file" id="imagen" accept="image/jpeg, image/png">

            <label for="imagen">Descripcion:</label>
            <textarea name="descripcion" id="descripcion"><?php echo $descripcion; ?></textarea>
        </fieldset>

        <fieldset>
            <legend>Información Propiedad</legend>

            <label for="habitaciones">Habitaciones:</label>
            <input name="habitaciones" type="number" id="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo $habitaciones; ?>">

            <label for="wc">Baños:</label>
            <input name="wc" type="number" id="wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo $wc; ?>">

            <label for="estacionamiento">Estacionamiento:</label>
            <input name="estacionamiento" type="number" id="estacionamiento" placeholder="Ej: 3" min="0" max="9" value="<?php echo $estacionamiento; ?>">
        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>

            <select name="vendedorId">
                <option value="">-- Seleccione un vendedor --</option>
                <?php 
                    while($vendedor = mysqli_fetch_assoc($resultado)) : ?>
                        <option <?php echo $vendedorId === $vendedor['id'] ? 'selected': ''; ?> value="<?php echo $vendedor["id"] ?>">
                            <!-- echo ($vendedor["nombre"]) . " " . ($vendedor["apellido"]); ?> -->

                            <?php echo ("{$vendedor['nombre']} {$vendedor['apellido']}"); ?>
                        </option>
                    <?php endwhile;
                ?>
            </select>
        </fieldset>

        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
    </form>
</main>

<?php incluirTemplate('footer'); ?>