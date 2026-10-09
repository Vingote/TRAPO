<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$pdo = new PDO('mysql:host=db;charset=utf8mb4', 'root', 'root');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pdo->exec('CREATE DATABASE IF NOT EXISTS trapo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');

$pdo->exec('USE trapo');

$pdo->exec('
    CREATE TABLE IF NOT EXISTS productos (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(120) NOT NULL,
        precio DECIMAL(10, 2) NOT NULL,
        categoria VARCHAR(50) NOT NULL,
        imagen TEXT NOT NULL,
        mas_vendido TINYINT(1) NOT NULL DEFAULT 0
    )
');

$pdo->exec('
    CREATE TABLE IF NOT EXISTS clientes (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(120) NOT NULL,
        imagen TEXT NOT NULL,
        valoracion VARCHAR(10) NOT NULL,
        comentario VARCHAR(255) NOT NULL
    )
');

echo 'Tablas lista<br>';

$pdo->exec('TRUNCATE TABLE productos');
$pdo->exec('TRUNCATE TABLE clientes');

$stmtProductos = $pdo-> prepare(
    'INSERT INTO productos (nombre, precio, categoria, imagen, mas_vendido)
    VALUES (:nombre, :precio, :categoria, :imagen, :mas_vendido)'
);

$stmtClientes = $pdo-> prepare(
    'INSERT INTO clientes (nombre, imagen, valoracion, comentario)
    VALUES (:nombre, :imagen, :valoracion, :comentario)'
);

$productos = [
    ['nombre' => 'Jean Baggy Tokio Denim', 'precio' => 58499, 'categoria' => 'jeans', 'imagen' => '../assets/imagenes/baggy-denim/baggy-denim-1.webp', 'mas_vendido' => 1],
    ['nombre' => 'Jean Baggy Coffee', 'precio' => 43199, 'categoria' => 'jeans', 'imagen' => '../assets/imagenes/baggy-coffe/baggy-coffe-1.webp', 'mas_vendido' => 1],
    ['nombre' => 'Hoddie Negro Básico', 'precio' => 37799, 'categoria' => 'buzos', 'imagen' => '../assets/imagenes/hoddie-negro-basico/hoddie-negro-basico-1.webp', 'mas_vendido' => 1],
    ['nombre' => 'Remera Boxy Riot Verde Oliva', 'precio' => 26899, 'categoria' => 'remeras', 'imagen' => '../assets/imagenes/remera-riot-verde/remera-riot-verde-1.webp', 'mas_vendido' => 1],
    ['nombre' => 'Cinto Disel Clasico', 'precio' => 14399, 'categoria' => 'accesorios', 'imagen' => '../assets/imagenes/cinto-disel-clasico/cinto-disel-clasico-1.webp', 'mas_vendido' => 0],
    ['nombre' => 'Remera Boxy Figura', 'precio' => 35099, 'categoria' => 'remeras', 'imagen' => '../assets/imagenes/remera-figura/remera-boxy-figura-1.webp', 'mas_vendido' => 0],
    ['nombre' => 'Remera Boxy Rebel Negra', 'precio' => 35099, 'categoria' => 'remeras', 'imagen' => '../assets/imagenes/remera-rebel-negra/remera-boxy-rebel-negra-1.webp', 'mas_vendido' => 0],
    ['nombre' => 'Remera Boxy Tokyo', 'precio' => 35099, 'categoria' => 'remeras', 'imagen' => '../assets/imagenes/remera-tokyo/remera-boxy-tokyo-1.webp', 'mas_vendido' => 0],
    ['nombre' => 'Bermuda Baggy Praga Azul', 'precio' => 46799, 'categoria' => 'jeans', 'imagen' => '../assets/imagenes/bermuda-baggy-praga-azul/bermuda-baggy-praga-azul-1.webp', 'mas_vendido' => 0],
    ['nombre' => 'Jean Baggy Carbón', 'precio' => 35999, 'categoria' => 'jeans', 'imagen' => '../assets/imagenes/jean-baggy-carbon/jean-baggy-carbon-1.webp', 'mas_vendido' => 0],
    ['nombre' => 'Hoodie Realtree Tono Gris', 'precio' => 49499, 'categoria' => 'buzos', 'imagen' => '../assets/imagenes/hoodie-realtree-gris/hoodie-realtree-tono-gris-1.webp', 'mas_vendido' => 0],
    ['nombre' => 'Campera Minimalista Valentino Gris', 'precio' => 47699, 'categoria' => 'buzos', 'imagen' => '../assets/imagenes/campera-valentino-gris/campera-valentino-gris-1.webp', 'mas_vendido' => 0],
    ['nombre' => 'Campera Zip Básica Negra', 'precio' => 39599, 'categoria' => 'buzos', 'imagen' => '../assets/imagenes/campera-zip-basica-negra/campera-zip-basica-negra-1.webp', 'mas_vendido' => 0],
    ['nombre' => 'Campera Boxy Verde Oliva', 'precio' => 49499, 'categoria' => 'buzos', 'imagen' => '../assets/imagenes/campera-boxy-verde-oliva/campera-boxy-verde-oliva-1.webp', 'mas_vendido' => 0],
    ['nombre' => 'Cinto Blanco Savage Con Cadena Incluída', 'precio' => 12999, 'categoria' => 'accesorios', 'imagen' => '../assets/imagenes/cinto-blanco-savage-cadena/cinto-blanco-savage-cadena-1.webp', 'mas_vendido' => 0],
    ['nombre' => 'Cinto Negro Frontier', 'precio' => 12599, 'categoria' => 'accesorios', 'imagen' => '../assets/imagenes/cinto-negro-frontier/cinto-negro-frontier-1.webp', 'mas_vendido' => 0],
    ['nombre' => 'Cinto Básico Negro', 'precio' => 11699, 'categoria' => 'accesorios', 'imagen' => '../assets/imagenes/cinto-basico-negro/cinto-basico-negro-1.webp', 'mas_vendido' => 0],
    ['nombre' => 'Cinto Diesel Desgaste', 'precio' => 11999, 'categoria' => 'accesorios', 'imagen' => '../assets/imagenes/cinto-disel-desgaste/cinto-disel-desgaste-1.webp', 'mas_vendido' => 0],
];

$clientes = [
    ['nombre' => 'Cliente 1', 'imagen' => '../assets/imagenes/clientes/cliente-1.webp', 'valoracion' => '★★★★★', 'comentario' => '"Ya me llegoo 10 puntos todo, ya usé la ropa a full, muy zarpada, gracias genios"'],
    ['nombre' => 'Cliente 2', 'imagen' => '../assets/imagenes/clientes/cliente-2.webp', 'valoracion' => '★★★★★', 'comentario' => '"Acaba de llegar, muy lindas prendas y colores, 100% recomiendo"'],
    ['nombre' => 'Cliente 3', 'imagen' => '../assets/imagenes/clientes/cliente-3.webp', 'valoracion' => '★★★★★', 'comentario' => '"Hermosa remera, el corte es muy muy bueno, lo que buscaba"'],
    ['nombre' => 'Cliente 4', 'imagen' => '../assets/imagenes/clientes/cliente-4.webp', 'valoracion' => '★★★★★', 'comentario' => '"Muchísimas gracias amigos, lo recibí recién, muuy muy linda la ropa. Son las cabras"'],
    ['nombre' => 'Cliente 5', 'imagen' => '../assets/imagenes/clientes/cliente-5.webp', 'valoracion' => '★★★★★', 'comentario' => '"Muy bueno todo, los joggins están idos"'],
    ['nombre' => 'Cliente 6', 'imagen' => '../assets/imagenes/clientes/cliente-6.webp', 'valoracion' => '★★★★★', 'comentario' => '"Muy buena calidad de las prendas y excelente atención"']
];

foreach ($productos as $producto) {
    $stmtProductos->execute($producto);
}

echo 'Productos cargados: ' . count($productos) . '<br>';

foreach ($clientes as $cliente) {
    $stmtClientes->execute($cliente);
}

echo 'Clientes cargados: ' . count($clientes) . '<br>';