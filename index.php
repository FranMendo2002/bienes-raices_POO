<?php


    require 'includes/app.php';

    $inicio = true;
    incluirTemplate('header', $inicio);

?>

<main class="contenedor seccion">
    <h1>Más Sobre Nosotros</h1>
    <div class="iconos-nosotros">
        <div class="icono">
            <img src="build/img/icono1.svg" alt="Icono seguridad" loading="lazy">
            <h3>Seguridad</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi, vitae. At itaque, inventore architecto accusantium libero veritatis adipisci sapiente repellat harum enim aliquam aperiam laborum iure amet, consectetur minima quisquam?</p>
        </div>

        <div class="icono">
            <img src="build/img/icono2.svg" alt="Icono precio" loading="lazy">
            <h3>Precio</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi, vitae. At itaque, inventore architecto accusantium
                libero veritatis adipisci sapiente repellat harum enim aliquam aperiam laborum iure amet, consectetur minima
                quisquam?</p>
        </div>

        <div class="icono">
            <img src="build/img/icono3.svg" alt="Icono Tiempo" loading="lazy">
            <h3>A Tiempo</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi, vitae. At itaque, inventore architecto accusantium
                libero veritatis adipisci sapiente repellat harum enim aliquam aperiam laborum iure amet, consectetur minima
                quisquam?</p>
        </div>
    </div>
</main>

<section class="seccion contenedor">
    <h2>Casas y Departamentos en Venta</h2>
    
    <?php
    include 'includes/templates/anuncios.php';
    
    ?>

    <div class="ver-todas alinear-derecha">
        <a href="anuncios.php" class="boton-verde">Ver todas</a>
    </div>
</section>

<section class="imagen-contacto">
    <h2>Encuentra la casa de tus sueños</h2>
    <p>Llena el formulario de contacto y un asesor se pondra en
        contacto contigo a la brevedad
    </p>
    <a href="contacto.php" class="boton-amarillo">Contáctanos</a>
</section>

<div class="contenedor seccion seccion-inferior">
    <section class="blog">
        <h3>Nuestro Blog</h3>

        <article class="entrada-blog">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/blog1.webp" type="image/webp">
                    <source srcset="build/img/blog1.jpg" type="image/jpeg">
                    <img src="build/img/blog1.jpg" alt="Texto Entrada Blog">
                </picture>
            </div>
            <div class="texto-entrada">
                <a href="entrada.php">
                    <h4>Terraza en el techo de tu casa</h4>
                    <p class="informacion-meta">Escrito el <span>20/10/2021</span> por: <span>Admin</span></p>
                    <p>
                        Consejos para construir una terraza en el techo de tu casa con
                        los mejores materiales y ahorrando dinero
                    </p>
                </a>
            </div>
        </article>

        <article class="entrada-blog">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/blog2.webp" type="image/webp">
                    <source srcset="build/img/blog2.jpg" type="image/jpeg">
                    <img src="build/img/blog2.jpg" alt="Texto Entrada Blog">
                </picture>
            </div>
            <div class="texto-entrada">
                <a href="entrada.php">
                    <h4>Guía para la decoración de tu hogar</h4>
                    <p class="informacion-meta">Escrito el <span>20/10/2021</span> por: <span>Admin</span></p>
                    <p>
                        Maximiza el espacio en tu hogar con esta guía,
                        aprende a combinar muebles y colores para darle
                        vida a tu espacio
                    </p>
                </a>
            </div>
        </article>
    </section>

    <section class="testimoniales">
        <h3>Testimoniales</h3>

        <div class="testimonial">
            <blockquote>El personal tuvo una actitud excelente,
                muy profesional y atenta a mis necesidades.
                La casa era muy bonita y bien ubicada.
            </blockquote>
            <p>- Franco Mendoza</p>
        </div>
    </section>
</div>

<?php incluirTemplate('footer'); ?>