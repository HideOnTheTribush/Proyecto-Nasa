<?php
require 'db.php'; // Incluimos archivo de conexión a la base de datos

// Datos para insertar
$username = 'newuser';
$password = 'newpassword'; // La contraseña debe ser cifrada antes de almacenarla
$token = 'your_nasa_token'; // Token de la API (opcional)

// Ciframos la contraseña
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Preparamos la consulta SQL para insertar un nuevo usuario
$stmt = $pdo->prepare("INSERT INTO users (username, password, token) VALUES (?, ?, ?)");

// Ejecutamos la consulta con los valores
$stmt->execute([$username, $hashedPassword, $token]);

echo "Usuario añadido correctamente";
?>
