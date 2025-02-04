<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/edu_dual/admin/view/DBC.php'); // Conexión a la base de datos
header('Content-Type: text/html; charset=utf-8');
// Función para cargar alumnos con sus carreras
function cargarEmpresas() {
    $pdo = DBC::get();
    $stmt = $pdo->query("SELECT 
        empresas.idempresa, 
        empresas.nombre_empresa, 
        empresas.rfc, 
        empresas.direccion, 
        empresas.telefono, 
        empresas.email, 
        empresas.representante
    FROM empresas");
    return $stmt->fetchAll();
}

// Procesar solicitudes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $action = $_POST['action'] ?? '';
    $id = $_POST['id'] ?? '';

    switch ($action) {
        case 'eliminar':
            eliminarEmpresa($id);
            break;
			case 'agregar':
            agregarEmpresa($_POST);
            break;
			case 'editar':
            actualizarEmpresa($id,$_POST);
            break;
			case 'obtenerEmpresa':
            obtenerEmpresa($id);
            break;
			case 'verificarcuenta':
			$email = $_POST['email'] ?? '';
            $idperfil = $_POST['idperfil'] ?? '';
            verificarSitieneCuenta($email, $idperfil);
			//echo "algo";
			break;
        default:
            echo json_encode(['success' => false, 'message' => 'Acción no válida']);
    }
}


function obtenerEmpresa($id) {
    $pdo = DBC::get();
    try {
        // Obtener los datos del alumno y la lista de carreras
        $stmtEmpresa = $pdo->prepare("SELECT 
            empresas.idempresa, 
            empresas.nombre_empresa, 
            empresas.rfc, 
            empresas.direccion, 
            empresas.telefono, 
            empresas.email,
            empresas.representante
            
        FROM empresas
        WHERE empresas.idempresa = :idempresa");
        $stmtEmpresa->execute([':idempresa' => $id]);
        $empresa = $stmtEmpresa->fetch();

    
        if ($empresa) {
            echo json_encode([
                'success' => true, 
                'empresa' => $empresa, 
                
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Empresa no encontrado']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al obtener los datos: ' . $e->getMessage()]);
    }
}

function actualizarEmpresa($id,$data) {
    $pdo = DBC::get();
	
	$data['nombre_empresa'] = mb_strtoupper($data['nombre_empresa'], 'UTF-8');
    $data['rfc'] = mb_strtoupper($data['rfc'], 'UTF-8');
    $data['direccion'] = mb_strtoupper($data['direccion'], 'UTF-8');
    $data['telefono'] = mb_strtoupper($data['telefono'], 'UTF-8');
    $data['email'] = strtolower(trim($data['email'])); // Opcional: correos en minúsculas
    $data['representante'] = mb_strtoupper($data['representante'], 'UTF-8');

    try {
        // Actualizar los datos del alumno en la base de datos
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM empresas WHERE nombre_empresa = :nombre_empresa");
        $stmt->execute([':nombre_empresa' => $data['nombre_empresa']]);
        if ($stmt->fetchColumn() > 0) {
        echo json_encode(['success' => false, 'message' => 'Ya existe una empresa con el mismo nombre.']);
        return;
    }
    
        $stmt = $pdo->prepare("UPDATE empresas SET 
        nombre_empresa = :nombre_empresa, 
        rfc = :rfc, 
        direccion = :direccion, 
        telefono = :telefono, 
        email = :email,
        representante = :representante
        WHERE idempresa = :idempresa");


        $stmt->execute([
            ':idempresa' => $data['id_empresa'],
            ':nombre_empresa' => $data['nombre_empresa'],
            ':rfc' => $data['rfc'],
            ':direccion' => $data['direccion'],
            ':telefono' => $data['telefono'],
            ':email' => $data['email'],
            ':representante' => $data['representante']
            
        ]);

        echo json_encode(['success' => true, 'message' => 'Empresa actualizado correctamente']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar los datos: ' . $e->getMessage()]);
    }
}



// Función para eliminar un empresa
function eliminarEmpresa($id) {
    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => 'ID de Empresa no proporcionado']);
        return;
    }

    $pdo = DBC::get();
    try {
        // Verificar si el empresa existe
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM empresas WHERE idempresa = :id");
        $stmt->execute([':id' => $id]);

        if ($stmt->fetchColumn() == 0) {
            echo json_encode(['success' => false, 'message' => 'La empresa no existe']);
            return;
        }

        // Eliminar el empresa
        $stmt = $pdo->prepare("DELETE FROM empresas WHERE idempresa = :id");
        $stmt->execute([':id' => $id]);

        echo json_encode(['success' => true, 'message' => 'Empresa eliminado exitosamente']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar el Empresa: ' . $e->getMessage()]);
    }
}




function agregarEmpresa($data) {
    $pdo = DBC::get();
	
	$data['nombre_empresa'] = mb_strtoupper($data['nombre_empresa'], 'UTF-8');
    $data['rfc'] = mb_strtoupper($data['rfc'], 'UTF-8');
    $data['direccion'] = mb_strtoupper($data['direccion'], 'UTF-8');
    $data['telefono'] = mb_strtoupper($data['telefono'], 'UTF-8');
    $data['email'] = strtolower(trim($data['email'])); // Opcional: correos en minúsculas
    $data['representante'] = mb_strtoupper($data['representante'], 'UTF-8');
	

    try {
        // Verificar si ya existe una empresa con el mismo RFC
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM empresas WHERE rfc = :rfc");
        $stmt->execute([':rfc' => $data['rfc']]);
        if ($stmt->fetchColumn() > 0) {
        echo json_encode(['success' => false, 'message' => 'Ya existe una empresa con el mismo RFC.']);
        return;
    }

// Verificar si ya existe una empresa con el mismo nombre
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM empresas WHERE nombre_empresa = :nombre_empresa");
        $stmt->execute([':nombre_empresa' => $data['nombre_empresa']]);
        if ($stmt->fetchColumn() > 0) {
        echo json_encode(['success' => false, 'message' => 'Ya existe una empresa con el mismo nombre.']);
        return;
    }


        // Si no existe, proceder con la inserción
        $stmt = $pdo->prepare("INSERT INTO empresas (nombre_empresa, rfc, direccion, telefono, email, representante) 
                               VALUES (:nombre_empresa, :rfc, :direccion, :telefono, :email, :representante)");
        $stmt->execute([
            ':nombre_empresa' => $data['nombre_empresa'],
            ':rfc' => $data['rfc'],
            ':direccion' => $data['direccion'],
            ':telefono' => $data['telefono'],
            ':email' => $data['email'],
            ':representante' => $data['representante'],
        ]);

        echo json_encode(['success' => true, 'message' => 'Empresa agregado exitosamente.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al agregar el Empresa: ' . $e->getMessage()]);
    }
}


function verificarSitieneCuenta($correo_int, $idperfil_int) {
    $pdo = DBC::get();

    try {
        $stmt = $pdo->prepare("
            SELECT COUNT(*) 
            FROM usuarios
            WHERE usuarios.email = :email
            AND usuarios.idperfil = :idperfil
        ");
        $stmt->execute([
            ':email' => $correo_int,
            ':idperfil' => $idperfil_int
        ]);

        $count = $stmt->fetchColumn();

        if ($count > 0) {
            // Empresa tiene cuenta
            echo json_encode(['success' => true, 'message' => 'La empresa ya tiene una cuenta de Usuario. Para gestionarla deberá hacerlo directamente desde el Catálogo de Usuarios.']);
        } else {
            // Empresa no tiene cuenta
            echo json_encode(['success' => false, 'message' => 'La empresa no tiene una cuenta de Usuario.']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al consultar: ' . $e->getMessage()]);
    }
}




?>