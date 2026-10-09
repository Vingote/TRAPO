import { supabase } from './supabase.js';

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
    const filtros = new URLSearchParams(contenedor.dataset.productos);

    let consulta = supabase
        .from('productos')
        .select('id, nombre, precio, categoria, imagen, mas_vendido')
        .order('id', { ascending: false });

    if (filtros.get('categoria')) {
        consulta = consulta.eq('categoria', filtros.get('categoria'));
    }

    if (filtros.has('mas_vendido')) {
        consulta = consulta.eq('mas_vendido', true);
    }

    const { data, error } = await consulta;

    if (error) {
        console.error(error);
        contenedor.textContent = 'No pudimos cargar los productos. Probá de nuevo en un rato.';
        return;
    }

    if (data.length === 0) {
        contenedor.textContent = 'Todavía no hay productos para mostrar.';
        return;
    }

    contenedor.replaceChildren(...data.map(crearTarjetaProducto));
}

document.querySelectorAll('[data-productos]').forEach(cargarProductos);