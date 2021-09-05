<?php
require 'includes/funciones.php';
incluirTemplate('header');
?>

<main class="contenedor seccion seccion-nosotros">
    <h1>Conoce Sobre Nosotros</h1>
    <div class="sobre-nosotros">
        <div class="nosotros-imagen">
            <picture>
                <source srcset="build/img/nosotros.webp" type="image/webp">
                <source srcset="build/img/nosotros.jpg" type="image/jpeg">
                <img src="build/img/nosotros.jpg" alt="Nosotros" loading="lazy">
            </picture>
        </div>
        <section class="nosotros-texto">
            <h3>25 años de experiencia</h3>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Culpa cum autem dolorem repellat debitis ex reprehenderit sunt maiores laborum. Incidunt voluptas harum repellendus, molestiae deleniti provident error reprehenderit totam beatae laborum aut, maiores nisi optio quaerat magnam at ex. Asperiores fuga vero velit obcaecati.</p>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Tenetur necessitatibus eius molestias ad alias in! Architecto eum eaque sint blanditiis dolorum magnam facilis beatae asperiores sit, quo quidem, doloribus veritatis?</p>
        </section>
    </div>
</main>

<section class="contenedor seccion">
    <h1>Más Sobre Nosotros</h1>
    <div class="iconos-nosotros">
        <div class="icono">
            <img src="build/img/icono1.svg" alt="Icono seguridad" loading="lazy">
            <h3>Seguridad</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi, vitae. At itaque, inventore architecto
                accusantium libero veritatis adipisci sapiente repellat harum enim aliquam aperiam laborum iure amet,
                consectetur minima quisquam?</p>
        </div>

        <div class="icono">
            <img src="build/img/icono2.svg" alt="Icono precio" loading="lazy">
            <h3>Precio</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi, vitae. At itaque, inventore architecto
                accusantium
                libero veritatis adipisci sapiente repellat harum enim aliquam aperiam laborum iure amet, consectetur
                minima
                quisquam?</p>
        </div>

        <div class="icono">
            <img src="build/img/icono3.svg" alt="Icono Tiempo" loading="lazy">
            <h3>A Tiempo</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi, vitae. At itaque, inventore architecto
                accusantium
                libero veritatis adipisci sapiente repellat harum enim aliquam aperiam laborum iure amet, consectetur
                minima
                quisquam?</p>
        </div>
    </div>
</section>

<?php incluirTemplate('footer'); ?>