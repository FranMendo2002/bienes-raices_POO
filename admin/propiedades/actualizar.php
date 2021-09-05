<?php

    require '../../includes/funciones.php';
    $auth = estaAutenticado();

    if(!$auth) {
        header('Location: /');
    }


    // Validar la URL por ID válido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    

    if(!$id) {
        header('Location: /admin');
    }

    // Base de datos
    require '../../includes/config/database.php';
    $db = conectarDB();

    // Consultar para obtener los vendedores
    $query = "SELECT * FROM vendedores";
    $resultadoVendedor = mysqli_query($db, $query);

    // Obtener los datos de la propiedad
    $query = "SELECT * FROM propiedades WHERE id=${id}";
    $resultadoPropiedades = mysqli_query($db, $query);
    $propiedad = mysqli_fetch_assoc($resultadoPropiedades);


    // Areglo con mensajes de errores
    $errores = [];

    $titulo = $propiedad['titulo'];
    $precio = $propiedad['precio'];
    $descripcion = $propiedad['descripcion'];
    $habitaciones = $propiedad['habitaciones'];
    $wc = $propiedad['wc'];
    $estacionamiento = $propiedad['estacionamiento'];
    $vendedorId = $propiedad['vendedorId'];
    $imagenPropiedad = $propiedad['imagen'];

    // Ejecutar el codigo después de que el usuario envia el formulario
    if ($_SERVER["REQUEST_METHOD"] === 'POST') {

        $titulo = mysqli_real_escape_string($db, $_POST['titulo'] );
        $precio = mysqli_real_escape_string($db, $_POST['precio'] );
        $descripcion = mysqli_real_escape_string($db, $_POST['descripcion'] );
        $habitaciones = mysqli_real_escape_string($db, $_POST['habitaciones'] );
        $wc = mysqli_real_escape_string($db, $_POST['wc'] );
        $estacionamiento = mysqli_real_escape_string($db, $_POST['estacionamiento'] );
        $vendedorId = mysqli_real_escape_string($db, $_POST['vendedor'] );
        $creado = date('Y/m/d');

        // Asignar files hacia una variable
        $imagen = $_FILES["imagen"];

        if (!$titulo) {
            $errores[] = "Debes añadir un titulo";
        }

        if (!$precio) {
            $errores[] = "El precio es obligatorio";
        }

        if (strlen($descripcion) < 50) {
            $errores[] = "La descripcion es obligatoria y debe tener al menos 50 caracteres";
        }

        if (!$habitaciones) {
            $errores[] = "El número de habitaciones es obligatorio";
        }

        if (!$wc) {
            $errores[] = "El número de baños es obligatorio";
        }

        if (!$estacionamiento) {
            $errores[] = "El número de estacionamientos es obligatorio";
        }

        if (!$vendedorId) {
            $errores[] = "Elige un vendedor";
        }
        // Validar por tamaño (1MB maximo)
        $medida = 1000 * 1000;
        
        if($imagen["size"] > $medida) {
            $errores[] = "La imagen es muy pesada";
        }

        // Revisar que el arreglo de errores esté vacio
        if (empty($errores)) {

            /** SUBIDA DE ARCHIVOS **/

            // Crear carpeta
            $carpetaImagenes = '../../imagenes/';
            
            if(!is_dir($carpetaImagenes)){
                mkdir($carpetaImagenes);
            }

            $nombreImagen = '';

            if($imagen['name']) {
                // Eliminar la imagen previa
                unlink($carpetaImagenes . $propiedad["imagen"]);

                // Generar un nombre unico
                $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

                // Subir la imagen
                move_uploaded_file( $imagen["tmp_name"], $carpetaImagenes . $nombreImagen );
            } else {
                $nombreImagen = $propiedad['imagen'];
            }

            


            // Actualizar la base de datos
            $query = "UPDATE propiedades SET titulo = '${titulo}', precio = '${precio}', imagen = '${nombreImagen}', descripcion = '${descripcion}', habitaciones = ${habitaciones}, wc = ${wc}, estacionamiento = ${estacionamiento}, vendedorId = ${vendedorId} WHERE id=${id}";

            $resultado = mysqli_query($db, $query);
            
            if ($resultado) {
                // Redireccionar al usuario
                header('Location: /admin?resultado=2');
            }
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
        <fieldset>
            <legend>Información General</legend>

            <label for="titulo">Título:</label>
            <input name="titulo" type="text" id="titulo" placeholder="Título de la propiedad" value="<?php echo $titulo; ?>">

            <label for="precio">Precio:</label>
            <input name="precio" type="number" id="precio" placeholder="Precio de la propiedad" value="<?php echo $precio; ?>">

            <label for="imagen">Imagen:</label>
            <input name="imagen" type="file" id="imagen" accept="image/jpeg, image/png">
            <p class="alerta warning">¡Atencion! Si inserta una nueva imagen, la anterior sera eliminada</p>

            <img src="/imagenes/<?php echo $imagenPropiedad ?>" alt="Imagen propiedad" class="imagen-small">

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

            <select name="vendedor">
                <option value="">-- Seleccione un vendedor --</option>
                <?php 
                    while($vendedor = mysqli_fetch_assoc($resultadoVendedor)) : ?>
                        <option <?php echo $vendedorId === $vendedor['id'] ? 'selected': ''; ?> value="<?php echo $vendedor["id"] ?>">
                            <!-- echo ($vendedor["nombre"]) . " " . ($vendedor["apellido"]); ?> -->

                            <?php echo ("{$vendedor['nombre']} {$vendedor['apellido']}"); ?>
                        </option>
                    <?php endwhile;
                ?>
            </select>
        </fieldset>

        <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
    </form>
</main>

<?php incluirTemplate('footer'); ?>