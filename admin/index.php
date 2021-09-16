<?php

    require '../includes/app.php';
    estaAutenticado();

    use App\Propiedad;
    use App\Vendedor;

    // Implementar un método para obtener las propiedades
    $propiedades = Propiedad::all();
    $vendedores = Vendedor::all();

    // Muestra mensaje condicional
    $resultado = $_GET['resultado'] ?? null; // Revisa si existe el get, si no, asigna null

    if($_SERVER["REQUEST_METHOD"] === 'POST') {

        /* FILTER_VALIDATE_INT Valida un valor como integer, opcionalmente desde el rango especificado, y lo convierte a int en case de éxito. */
        $idEliminar = filter_var($_POST['id'], FILTER_VALIDATE_INT);

        if($idEliminar) {
                $tipo = validarTipoContenido($_POST['tipo']);

                if($tipo){
                    if($_POST["tipo"]=== 'vendedor'){
                        $vendedor = Vendedor::find($idEliminar);
                        $resultado = $vendedor->eliminar();
                    }
                    if($_POST["tipo"]=== 'propiedad'){
                        $propiedad = Propiedad::find($idEliminar);
                        $resultado = $propiedad->eliminar();
                    }
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
            <p class="alerta exito">Registro Creado Correctamente</p>
        <?php elseif( intval($resultado) === 2):?>
            <p class="alerta actualizado">Registro Actualizado Correctamente</p>
        <?php elseif( intval($resultado) === 3): ?>
            <p class="alerta eliminado">Registro Eliminado Correctamente</p>
        <?php endif; ?>

    <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>

    <h2>Propiedades</h2>

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
                    <td>$ <?php echo $propiedad->precio ?> </td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>">
                            <input type="hidden" name="tipo" value="propiedad">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        
                        <a href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>

    <h2>Vendedores</h2>
    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody> <!-- Mostrar los resultados -->
            <?php foreach( $vendedores as $vendedor): ?>
                <tr>
                    <td> <?php echo $vendedor->id ?> </td>
                    <td> <?php echo $vendedor->nombre ?> </td>
                    <td> <?php echo $vendedor->apellido ?> </td>
                    <td> <?php echo $vendedor->telefono ?> </td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $vendedor->id; ?>">
                            <input type="hidden" name="tipo" value="vendedor">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        
                        <a href="/admin/vendedores/actualizar.php?id=<?php echo $vendedor->id; ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>
</main>

<?php 

    incluirTemplate('footer'); 

?>