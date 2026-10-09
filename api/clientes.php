<?php

header('Content-Type: application/json; charset=utf-8');

try {
    $pdo = new PDO('mysql:host=db;dbname=trapo;charset=utf8mb4', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT id, nombre, imagen,valoracion, comentario FROM clientes';

    $sql .= ' ORDER BY id ASC';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $filas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $clientes = [];
    foreach ($filas as $fila) {
        $clientes[] = [
            'id' => (int) $fila['id'],
            'nombre' => $fila['nombre'],
            'imagen' => $fila['imagen'],
            'valoracion' => $fila['valoracion'],
            'comentario' => $fila['comentario'],
        ];
    }

    echo json_encode($clientes, JSON_UNESCAPED_UNICODE);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'No se pudieron cargar los clientes']);
}