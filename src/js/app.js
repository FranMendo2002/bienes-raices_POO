document.addEventListener('DOMContentLoaded', function() {

    eventListeners();

    darkMode();

    //Eliminar texto de confirmación de CRUD en admin/index.php
    setInterval(function(){
    const mensajeConfirm = document.querySelector('.alerta');
            const padre = mensajeConfirm.parentElement;
            padre.removeChild(mensajeConfirm);
        }, 3500);
});

function darkMode() {

    const prefiereDarkMode = window.matchMedia('(prefers_color_schema: dark)');
    //console.log(prefiereDarkMode.matches);

    if(prefiereDarkMode.matches) {
        document.body.classList.add('dark-mode');
    } else {
        document.body.classList.remove('dark-mode');
    }

    prefiereDarkMode.addEventListener('change', function() {
        if(prefiereDarkMode.matches) {
            document.body.classList.add('dark-mode');
        } else {
            document.body.classList.remove('dark-mode');
        }
    });


    const botonDarkMode = document.querySelector('.dark-mode-boton');
    botonDarkMode.addEventListener('click', function () {
        document.body.classList.toggle('dark-mode');
    });
}

function eventListeners() {
    const mobileMenu = document.querySelector('.mobile-menu');
    
    mobileMenu.addEventListener('click', navegacionResponsive);
}

function navegacionResponsive() {
    const navegacion = document.querySelector('.navegacion');
    
    navegacion.classList.toggle('mostrar');
}