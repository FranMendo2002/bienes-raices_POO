<fieldset>
            <legend>Información General</legend>

            <label for="titulo">Título:</label>
            <input name="titulo" type="text" id="titulo" placeholder="Título de la propiedad" value="<?php echo s($propiedad->titulo); ?>">

            <label for="precio">Precio:</label>
            <input name="precio" type="number" id="precio" placeholder="Precio de la propiedad" value="<?php echo s($propiedad->precio); ?>">

            <label for="imagen">Imagen:</label>
            <input name="imagen" type="file" id="imagen" accept="image/jpeg, image/png">

            <label for="imagen">Descripcion:</label>
            <textarea name="descripcion" id="descripcion"><?php echo s($propiedad->descripcion); ?></textarea>
        </fieldset>

        <fieldset>
            <legend>Información Propiedad</legend>

            <label for="habitaciones">Habitaciones:</label>
            <input name="habitaciones" type="number" id="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($propiedad->habitaciones); ?>">

            <label for="wc">Baños:</label>
            <input name="wc" type="number" id="wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($propiedad->wc); ?>">

            <label for="estacionamiento">Estacionamiento:</label>
            <input name="estacionamiento" type="number" id="estacionamiento" placeholder="Ej: 3" min="0" max="9" value="<?php echo s($propiedad->estacionamiento); ?>">
        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>
        </fieldset>