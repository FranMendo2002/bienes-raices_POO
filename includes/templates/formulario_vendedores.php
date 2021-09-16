<fieldset>
    <legend>Información General</legend>

    <label for="nombre">Nombre:</label>
    <input name="nombre" type="text" id="nombre" placeholder="Nombre del vendedor (max. 45)" value="<?php echo s($vendedor->nombre); ?>">

    <label for="apellido">Apellido:</label>
    <input name="apellido" type="text" id="apellido" placeholder="Apellido del vendedor (max. 45)" value="<?php echo s($vendedor->apellido); ?>">
</fieldset>

<fieldset>
    <legend>Información extra</legend>

    <label for="telefono">Telefono:</label>
    <input name="telefono" type="text" id="telefono" placeholder="Telefono del vendedor (max. 10)" value="<?php echo s($vendedor->telefono); ?>">

    <label for="imagen">Imagen:</label>
    <input name="imagen" type="file" id="imagen" accept="image/jpeg, image/png">
    
    <?php if($vendedor->imagen): ?>
        <img src="/imagenes/<?php echo $vendedor->imagen; ?>" alt="Imagen del vendedor <?php echo $vendedor->nombre; ?>" class="imagen-small">
    <?php endif; ?>
</fieldset>
