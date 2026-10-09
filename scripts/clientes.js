function crearElementoCliente(etiqueta, clase, texto) {
    const elemento = document.createElement(etiqueta);
    if (clase) elemento.className = clase;
    if (texto !== undefined) elemento.textContent = texto;
    return elemento;
}

function crearTarjetaCliente(c) {
    const card = crearElementoCliente('div', 'card-cliente');

    const imagen = crearElementoCliente('img', 'cliente-img');
    imagen.src = c.imagen;
    imagen.alt = c.nombre;

    const valoracion = crearElementoCliente('h4', 'cliente-sticker', c.valoracion);

    const comentario = crearElementoCliente('span', 'cliente-comt', c.comentario);

    card.append(imagen, valoracion, comentario);

    return card;
}

async function cargarClientes(contenedor) {
    const consulta = contenedor.dataset.clientes;

    try {
        const respuesta = await fetch('./api/clientes.php?' + consulta);
        if (!respuesta.ok) throw new Error('Error ' + respuesta.status);

        const productos = await respuesta.json();

        if (productos.length === 0) {
            contenedor.textContent = 'Todavía no hay clientes para mostrar.';
            return;
        }

        contenedor.replaceChildren(...productos.map(crearTarjetaCliente));
    } catch (error) {
        console.error(error);
        contenedor.textContent = 'No pudimos cargar los clientes. Probá de nuevo en un rato.';
    }
}

document.querySelectorAll('[data-clientes]').forEach(cargarClientes);