<?php
session_start();
require_once __DIR__ . '/conexion.php';

$token = $_GET['token'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST["token"];
    $nueva = password_hash($_POST["nueva"], PASSWORD_BCRYPT);

    // Verifica el token
    $stmt = $conn->prepare("SELECT idusuario FROM tokens_recuperacion WHERE token = ? AND expira > NOW()");
    $stmt->execute([$token]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $stmt = $conn->prepare("UPDATE usuarios SET contrasenia = ? WHERE idusuario = ?");
        $stmt->execute([$nueva, $row['idusuario']]);

        // Borra el token usado
        $conn->prepare("DELETE FROM tokens_recuperacion WHERE token = ?")->execute([$token]);

        $_SESSION["mensaje"] = "Contraseña restablecida correctamente.";
        header("Location: login-form.php");
        exit();
    } else {
        $_SESSION["mensaje"] = "Token inválido o expirado.";
        header("Location: recuperar_contraseña.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h3 class="text-center">Nueva Contraseña</h3>
        <form method="POST" class="card p-4">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <div class="mb-3">
                <label class="form-label">Nueva contraseña</label>
                <input type="password" name="nueva" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Restablecer</button>
        </form>
    </div>
</body>
</html>