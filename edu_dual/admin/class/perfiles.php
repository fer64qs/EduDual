<?php
namespace Phppot;

use \Phppot\DataSource;

class Perfiles
{

    private $dbConn;

    private $ds;

    function __construct()
    {
        require_once "DataSource.php";
        $this->ds = new DataSource();
    }

    function getAllPerfiles()
    {
        $query = "select * FROM perfiles_usuarios order by nombre_perfil ASC;";
       // $paramType = "i";
        //$paramArray = array($memberId);
        $memberResult = $this->ds->select($query);
        
        return $memberResult;
    }
    
    




}
