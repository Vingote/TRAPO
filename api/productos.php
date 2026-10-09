<?php

header('Content-Type: application/json; charset=utf-8');

try {
    $pdo = new PDO('mysql:host=db;dbname=trapo;charset=utf8mb4', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT id, nombre, precio, categoria, imagen, mas_vendido FROM productos';
    $condiciones = [];
    $params = [];

    if (isset($_GET['categoria'])) {
        $condiciones[] = 'categoria = :categoria';
        $params['categoria'] = $_GET['categoria'];
    }

    if (isset($_GET['mas_vendido'])) {
        $condiciones[] = 'mas_vendido = 1';
    }

    if ($condiciones) {
        $sql .= ' WHERE ' . implode(' AND ', $condiciones);
    }

    $sql .= ' ORDER BY categoria DESC, id DESC';

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $filas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $porductos = [];
    foreach ($filas as $fila) {
        $productos[] = [
            'id' => (int) $fila['id'],
            'nombre' => $fila['nombre'],
            'precio' => (float) $fila['precio'],
            'categoria' => $fila['categoria'],
            'imagen' => $fila['imagen'],
            'masVendido' => (bool) $fila['mas_vendido'],
        ];
    }

    echo json_encode($productos, JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'No se pudieron cargar los productos']);
}