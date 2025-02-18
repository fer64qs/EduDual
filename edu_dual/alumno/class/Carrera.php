<?php
namespace Phppot;

use \Phppot\DataSource;

class Carrera
{
    private $ds;

    public function __construct()
    {
        require_once "DataSource.php";
        $this->ds = new DataSource();
    }

    // Obtener todas las carreras
    public function getAllCarreras()
    {
        $query = "SELECT * FROM carreras";
        return $this->ds->select($query);
    }

    // Obtener una carrera por ID
    public function getCarreraById($idCarrera)
    {
        $query = "SELECT * FROM carreras WHERE idcarrera = ?";
        $paramType = "i";
        $paramArray = array($idCarrera);
        return $this->ds->select($query, $paramType, $paramArray);
    }

    // Insertar una nueva carrera
    public function addCarrera($nombreCarrera, $abreviatura)
    {
        $query = "INSERT INTO carreras (nombre_carrera, abreviatura) VALUES (?, ?)";
        $paramType = "ss";
        $paramArray = array($nombreCarrera, $abreviatura);
        return $this->ds->insert($query, $paramType, $paramArray);
    }

    // Actualizar una carrera existente
    public function updateCarrera($idCarrera, $nombreCarrera, $abreviatura)
    {
        $query = "UPDATE carreras SET nombre_carrera = ?, abreviatura = ? WHERE idcarrera = ?";
        $paramType = "ssi";
        $paramArray = array($nombreCarrera, $abreviatura, $idCarrera);
        return $this->ds->execute($query, $paramType, $paramArray);
    }

    // Eliminar una carrera
    public function deleteCarrera($idCarrera)
    {
        $query = "DELETE FROM carreras WHERE idcarrera = ?";
        $paramType = "i";
        $paramArray = array($idCarrera);
        return $this->ds->execute($query, $paramType, $paramArray);
    }
}
?>
