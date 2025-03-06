<?php
require_once "../class/DataSource.php";
require_once "../class/Alumno.php";

use Phppot\Alumno;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header('Content-Type: application/json'); // Asegurar que siempre enviamos JSON como respuesta

    // Identificar la acción (insertar, actualizar, eliminar o seleccionar)
    $action = $_POST['action'];

    // Crear una instancia de la clase Alumno
    $alumno = new Alumno();

    switch ($action) {
        case "insert":
            // Obtener los datos para insertar
            $idCarrera = $_POST['idcarrera'];
            $apellidoP = strtoupper($_POST['apellidop']);
            $apellidoM = strtoupper($_POST['apellidom']);
            $nombre = strtoupper($_POST['nombre']);
            $sexo = strtoupper($_POST['sexo']);
            $numControl = strtoupper($_POST['num_control']);
            $curp = strtoupper($_POST['curp']);
            $correo = $_POST['correo'];
            $celular = $_POST['celular'];

            // Verificar duplicados
            $existingAlumno = $alumno->getAlumnoByNumControlOrCorreo($numControl, $correo);
            if ($existingAlumno) {
                echo json_encode(["status" => "error", "message" => "El alumno con ese número de control o correo ya existe."]);
                exit;
            }

            // Insertar el alumno
            $insertId = $alumno->addAlumno($idCarrera, $apellidoP, $apellidoM, $nombre, $sexo, $numControl, $curp, $correo, $celular);

            if ($insertId) {
                echo json_encode(["status" => "success", "message" => "Alumno registrado correctamente."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error al registrar al alumno."]);
            }
            break;

        case "update":
            // Obtener los datos para actualizar
            $idAlumno = $_POST['idalumno'];
            $idCarrera = $_POST['idcarrera'];
            $apellidoP = strtoupper($_POST['apellidop']);
            $apellidoM = strtoupper($_POST['apellidom']);
            $nombre = strtoupper($_POST['nombre']);
            $sexo = strtoupper($_POST['sexo']);
            $numControl = strtoupper($_POST['num_control']);
            $curp = strtoupper($_POST['curp']);
            $correo = $_POST['correo'];
            $celular = $_POST['celular'];

            // Actualizar el alumno
            $updated = $alumno->updateAlumno($idAlumno, $idCarrera, $apellidoP, $apellidoM, $nombre, $sexo, $numControl, $curp, $correo, $celular);

            if ($updated) {
                echo json_encode(["status" => "success", "message" => "Alumno actualizado correctamente."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error al actualizar al alumno."]);
            }
            break;

        case "delete":
            // Obtener el ID del alumno a eliminar
            $idAlumno = $_POST['idalumno'];

            // Eliminar el alumno
            $deleted = $alumno->deleteAlumno($idAlumno);

            if ($deleted) {
                echo json_encode(["status" => "success", "message" => "Alumno eliminado correctamente."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Error al eliminar al alumno."]);
            }
            break;

        case "select":
            // Obtener todos los alumnos o uno específico
            if (isset($_POST['idalumno'])) {
                $idAlumno = $_POST['idalumno'];
                $result = $alumno->getAlumnoById($idAlumno);
            } else {
                $result = $alumno->getAllAlumnos();
            }

            echo json_encode(["status" => "success", "data" => $result]);
            break;

        default:
            echo json_encode(["status" => "error", "message" => "Acción no válida."]);
            break;
    }
}
?>
