<?php
    require 'includes/app.php';
    incluirTemplate('header');
?>

<main class="contenedor seccion contenido-centrado">
    <h1>Guía para la decoracion de tu hogar</h1>
    <picture>
        <source srcset="build/img/destacada2.webp" type="image/webp">
        <source srcset="build/img/destacada2.jpg" type="image/jpeg">
        <img loading="lazy" src="build/img/destacada2.jpg" alt="Imagen de la propiedad">
    </picture>
    <p class="informacion-meta">Escrito el: <span>20/10/2021</span> por: <span>Admin</span></p>

    <div class="resumen-propiedad">
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloribus quod sunt quasi consectetur commodi
            explicabo, tenetur rerum, blanditiis ratione laboriosam aut odio id accusamus ab magni perferendis nam
            eos libero. Ipsam doloremque tenetur labore quidem exercitationem rem, laborum totam natus nostrum optio
            non earum impedit asperiores alias debitis. Quis facilis nemo labore omnis tenetur sed error nulla ea
            dolor dolorum!</p>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Alias aliquid voluptatibus magni laudantium
            reiciendis molestias maxime delectus, porro sapiente eum ratione commodi ut unde fuga officia dolore
            illum deserunt possimus.</p>
    </div>
</main>

<?php incluirTemplate('footer'); ?>