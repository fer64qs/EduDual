<?php
class DBC
{
    private static $instance = null;
    private static $dbcInfo = array();
    private static $iniFile = __DIR__ . "/dbconexion.ini";
    private static $configIniFile = __DIR__ . '/../config.ini';

    // Cargar datos de conexión desde INI
    private static function loadConfig()
    {
        if (file_exists(self::$iniFile)) {
            self::$dbcInfo = parse_ini_file(self::$iniFile);
        } elseif (file_exists(self::$configIniFile)) {
            $config = parse_ini_file(self::$configIniFile, true);
            if ($config === false || !isset($config['conexion'])) {
                die("Error al leer el archivo de configuración.");
            }

            $conexion = $config['conexion'];

            self::$dbcInfo = array(
                'host'     => $conexion['host'],
                'db'       => $conexion['db'],
                'user'     => $conexion['user'],
                'password' => $conexion['password']
            );
        } else {
            die("No se encontró archivo de configuración válido.");
        }
    }

    public static function get()
    {
        if (self::$instance == null) {
            try {
                self::loadConfig();

                self::$instance = new PDO(
                    'mysql:host=' . self::$dbcInfo['host'] . ';dbname=' . self::$dbcInfo['db'],
                    self::$dbcInfo['user'],
                    self::$dbcInfo['password'],
                    array(
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET lc_time_names='es_ES'"
                    )
                );
            } catch (PDOException $e) {
                echo "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
        }
        return self::$instance;
    }

    public function getPrepareSets($arr)
    {
        $prepareSets = array();
        foreach ($arr as $column => $value) {
            $prepareSets[] = "`$column` = :" . $column;
        }
        return $prepareSets;
    }
}
?>