<?php
session_start();
require 'db.php'; // Conexión a la base de datos
// Comprobamos si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger datos del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];
    $token = $_POST['token'] ?? ''; // Token opcional
    // Validamos que el nombre de usuario no esté vacío
    if (empty($username) || empty($password)) {
        $error = "El nombre de usuario y la contraseña son obligatorios.";
    } else {
        // Verificamos que el nombre de usuario no exista ya en la base de datos
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($existingUser) {
            $error = "El nombre de usuario ya existe. Elige otro.";
        } else {
            // Ciframos la contraseña
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            // Insertamos el nuevo usuario en la base de datos
            $stmt = $pdo->prepare("INSERT INTO users (username, password, token) VALUES (?, ?, ?)");
            $stmt->execute([$username, $hashedPassword, $token]);
            $_SESSION['success'] = "Usuario registrado con éxito. Ahora puedes iniciar sesión.";
            header("Location: login.php"); // Redirigirmos a la página de login
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
</head>
<body>
    <h1>Registro de Nuevo Usuario</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>
    <form method="POST">
        <label for="username">Nombre de Usuario:</label>
        <input type="text" name="username" id="username" required>
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <label for="token">Token de la API (opcional):</label>
        <input type="text" name="token" id="token">
        <br>
        <button type="submit">Registrar</button>
    </form>
    <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
</body>
</html>