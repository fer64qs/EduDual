<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT'] . '/edu_dual/admin/view/DBC.php');
header('Content-Type: text/html; charset=utf-8');

function cargarTablas() {
    $pdo = DBC::get();
    $stmt = $pdo->query("SHOW TABLES FROM edu_dual");
    $todas = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Excluir la tabla perfiles_usuarios
    return array_filter($todas, fn($tabla) => $tabla !== 'perfiles_usuarios');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    $tablas = $_POST['tablas'] ?? [];

    if (empty($tablas) || !is_array($tablas)) {
        echo json_encode(['success' => false, 'message' => 'No se proporcionaron tablas válidas']);
        exit;
    }

    // Usar userId desde sesión
    if (!isset($_SESSION['userId'])) {
        echo json_encode(['success' => false, 'message' => 'Sesión no iniciada. No se puede continuar.']);
        exit;
    }

    $usuarioActualId = $_SESSION['userId'];
    $tablasValidas = cargarTablas();
    $pdo = DBC::get();

    try {
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
        $resultado = [];

        foreach ($tablas as $tabla) {
            if (in_array($tabla, $tablasValidas)) {
                if ($tabla === 'usuarios') {
                    // Borrar todos menos el usuario que ejecuta
                    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE idusuario != :id");
                    $stmt->execute([':id' => $usuarioActualId]);
                    $resultado[] = "$tabla (excepto usuario actual)";
                } else {
                    $pdo->exec("TRUNCATE TABLE `$tabla`");
                    $resultado[] = "$tabla truncada";
                }
            }
        }

        $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

        echo json_encode([
            'success' => true,
            'message' => 'Tablas procesadas correctamente: ' . implode(', ', $resultado)
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error al truncar: ' . $e->getMessage()
        ]);
    }

    exit;
}
?>
