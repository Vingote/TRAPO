const formatoPrecio = new Intl.NumberFormat('es-AR', {
    style: 'currency',
    currency: 'ARS'
});

function crearElementoProducto(etiqueta, clase, texto) {
    const elemento = document.createElement(etiqueta);
    if (clase) elemento.className = clase;
    if (texto !== undefined) elemento.textContent = texto;
    return elemento;
}

function crearTarjetaProducto(p) {
    const producto = crearElementoProducto('div', 'producto');
    const card = crearElementoProducto('div', 'card-producto');

    const imagen = crearElementoProducto('img');
    imagen.src = p.imagen;
    imagen.alt = p.nombre;

    const contenido = crearElementoProducto('div', 'producto-contenido');

    const precios = crearElementoProducto('div');
    precios.append(
        crearElementoProducto('h3', 'producto-precio', formatoPrecio.format(p.precio)),
        crearElementoProducto('span', 'precio-tag', 'con transferencia: 10% OFF')
    );

    const boton = crearElementoProducto('button', 'agregar-carrito-btn');
    boton.type = 'button';
    boton.append(crearElementoProducto('span', '', 'AGREGAR AL CARRITO'));
    boton.addEventListener('click', () => actualizarCarrito(1));

    contenido.append(crearElementoProducto('h4', 'producto-nombre', p.nombre), precios, boton);
    card.append(imagen, contenido);
    producto.append(card);

    return producto;
}

async function cargarProductos(contenedor) {
    const consulta = contenedor.dataset.productos;

    try {
        const respuesta = await fetch('../api/productos.php?' + consulta);
        if (!respuesta.ok) throw new Error('Error ' + respuesta.status);

        const productos = await respuesta.json();

        if (productos.length === 0) {
            contenedor.textContent = 'Todavía no hay productos para mostrar.';
            return;
        }

        contenedor.replaceChildren(...productos.map(crearTarjetaProducto));
    } catch (error) {
        console.error(error);
        contenedor.textContent = 'No pudimos cargar los productos. Probá de nuevo en un rato.';
    }
}

document.querySelectorAll('[data-productos]').forEach(cargarProductos);