function actualizarCarrito(cantidad) {
    const bolita = document.querySelector('.cant-productos-carrito');

    const cantidadActual = parseInt(bolita.textContent) || 0;

    const nuevaCantidad = cantidadActual + cantidad;

    bolita.textContent = nuevaCantidad;
    document.querySelector('.header-carrito')
        .setAttribute('aria-label', `Carrito, ${nuevaCantidad} productos`);

    bolita.classList.remove('rebota');
    void bolita.offsetWidth;
    bolita.classList.add('rebota');
}

const secciones = document.querySelectorAll('main > section:not(#hero)');

const observador = new IntersectionObserver((entradas) => {
    entradas.forEach((entrada) => {
        if (entrada.isIntersecting) {
            entrada.target.classList.add('visible');
            observador.unobserve(entrada.target);
        }
    });
}, { rootMargin: '0px 0px -10% 0px' });

secciones.forEach((seccion) => {
    seccion.classList.add('revelar');
    observador.observe(seccion);
});