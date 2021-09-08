<?php

    require '../includes/app.php';
    estaAutenticado();

    use App\Propiedad;

    // Implementar un método para obtener las propiedades
    $propiedades = Propiedad::all();

    // Muestra mensaje condicional
    $resultado = $_GET['resultado'] ?? null; // Revisa si existe el get, si no, asigna null

    if($_SERVER["REQUEST_METHOD"] === 'POST') {
        /* FILTER_VALIDATE_INT Valida un valor como integer, opcionalmente desde el rango especificado, y lo convierte a int en case de éxito. */
        $idEliminar = filter_var($_POST['id'], FILTER_VALIDATE_INT);

        if($idEliminar) {
            // Elimina el archivo
            $queryImg = "SELECT imagen FROM propiedades WHERE id=${idEliminar}";
            $resultadoImg = mysqli_query($db, $queryImg);
            $imgDelete = mysqli_fetch_assoc($resultadoImg)['imagen'];
            unlink('../imagenes/' . $imgDelete);

            // Elimina la propiedad
            $queryDelete = "DELETE FROM propiedades WHERE id=${idEliminar}";
            $resultadoDelete = mysqli_query($db, $queryDelete);
            if($resultadoDelete) {
                header('Location: /admin?resultado=3');
            }
        }
    }

    // Incluye un template
    incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Administrador de Bienes Raices</h1>

    <?php
        if( intval($resultado) === 1): ?>
            <p class="alerta exito">Anuncio Creado Correctamente</p>
        <?php elseif( intval($resultado) === 2):?>
            <p class="alerta actualizado">Anuncio Actualizado Correctamente</p>
        <?php elseif( intval($resultado) === 3): ?>
            <p class="alerta eliminado">Anuncio Eliminado Correctamente</p>
        <?php endif; ?>

    <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>

    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody> <!-- Mostrar los resultados -->
            <?php foreach( $propiedades as $propiedad): ?>
                <tr>
                    <td> <?php echo $propiedad->id ?> </td>
                    <td> <?php echo $propiedad->titulo ?> </td>
                    <td><img src="/imagenes/<?php echo $propiedad->imagen ?>" class="imagen-tabla"></td>
                    <td> <?php echo $propiedad->precio ?> </td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        
                        <a href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>
</main>

<?php 

    // Cerrar la conexion
    mysqli_close($db);

    incluirTemplate('footer'); 

?>