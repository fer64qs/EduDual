<?php
namespace Phppot;

use \Phppot\DataSource;

class Alumno
{
    private $ds;

    function __construct()
    {
        require_once "DataSource.php";
        $this->ds = new DataSource();
    }

    // Obtener un alumno por su ID
    function getAlumnoById($idAlumno)
    {
        $query = "SELECT * FROM alumnos WHERE idalumno = ?";
        $paramType = "i";
        $paramArray = array($idAlumno);
        return $this->ds->select($query, $paramType, $paramArray);
    }

    // Obtener alumnos por carrera
    function getAlumnosByCarrera($idCarrera)
    {
        $query = "SELECT * FROM alumnos WHERE idcarrera = ?";
        $paramType = "i";
        $paramArray = array($idCarrera);
        return $this->ds->select($query, $paramType, $paramArray);
    }

    // Agregar un nuevo alumno
    function addAlumno($idCarrera, $apellidoP, $apellidoM, $nombre, $sexo, $numControl, $curp, $correo, $celular)
    {
        $query = "INSERT INTO alumnos (idcarrera, apellidop, apellidom, nombre, sexo, num_control, curp, correo, celular) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $paramType = "issssssss";
        $paramArray = array($idCarrera, $apellidoP, $apellidoM, $nombre, $sexo, $numControl, $curp, $correo, $celular);
        return $this->ds->insert($query, $paramType, $paramArray);
    }

    // Actualizar los datos de un alumno
    function updateAlumno($idAlumno, $idCarrera, $apellidoP, $apellidoM, $nombre, $sexo, $numControl, $curp, $correo, $celular)
    {
        $query = "UPDATE alumnos SET idcarrera = ?, apellidop = ?, apellidom = ?, nombre = ?, sexo = ?, num_control = ?, curp = ?, correo = ?, celular = ? WHERE idalumno = ?";
        $paramType = "issssssssi";
        $paramArray = array($idCarrera, $apellidoP, $apellidoM, $nombre, $sexo, $numControl, $curp, $correo, $celular, $idAlumno);
        return $this->ds->execute($query, $paramType, $paramArray);
    }

    // Eliminar un alumno por su ID
    function deleteAlumno($idAlumno)
    {
        $query = "DELETE FROM alumnos WHERE idalumno = ?";
        $paramType = "i";
        $paramArray = array($idAlumno);
        return $this->ds->execute($query, $paramType, $paramArray);
    }

    // Verificar si un alumno ya existe por número de control o correo
    function getAlumnoByNumControlOrCorreo($numControl, $correo)
    {
        $query = "SELECT * FROM alumnos WHERE num_control = ? OR correo = ?";
        $paramType = "ss";
        $paramArray = array($numControl, $correo);
        return $this->ds->select($query, $paramType, $paramArray);
    }
}
?>
