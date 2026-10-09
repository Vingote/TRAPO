import { supabase } from './supabase.js';

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
    const { data, error } = await supabase
        .from('clientes')
        .select('id, nombre, imagen, valoracion, comentario')
        .order('id', { ascending: true });

    if (error) {
        console.error(error);
        contenedor.textContent = 'No pudimos cargar los clientes. Probá de nuevo en un rato.';
        return;
    }

    if (data.length === 0) {
        contenedor.textContent = 'Todavía no hay clientes para mostrar.';
        return;
    }

    contenedor.replaceChildren(...data.map(crearTarjetaCliente));
}

document.querySelectorAll('[data-clientes]').forEach(cargarClientes);