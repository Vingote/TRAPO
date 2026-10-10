import { supabase } from './supabase.js';

const formatoPrecio = new Intl.NumberFormat('es-AR', {
    style: 'currency',
    currency: 'ARS'
});

async function cargarDetalleProducto() {
    const parametrosURL = new URLSearchParams(window.location.search);
    const productoId = parametrosURL.get('id');

    if (!productoId) {
        window.location.href = './catalogo.html';
        return;
    }

    const { data: producto, error } = await supabase
        .from('productos')
        .select('*')
        .eq('id', productoId)
        .single();

    if (error || !producto) {
        console.error('Error al obtener el producto:', error);
        document.getElementById('producto-nombre').textContent = 'Producto no encontrado';
        return;
    }

    document.title = `${producto.nombre} | TRAPO`;
    
    const imagenEl = document.getElementById('producto-imagen');
    imagenEl.src = producto.imagen;
    imagenEl.alt = producto.nombre;

    document.getElementById('producto-nombre').textContent = producto.nombre;
    document.getElementById('producto-precio').textContent = formatoPrecio.format(producto.precio);
}

document.addEventListener('DOMContentLoaded', cargarDetalleProducto);