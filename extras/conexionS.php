<?php
class ConexionDB {
    private static $instancia;
    private $conexion;

    // Configuración de la base de datos
    private $host = "localhost";
    private $usuario = "root";
    private $contrasena = "";
    private $base_de_datos = "php";
    private $puerto = 3306;

    // Constructor privado para prevenir instanciación externa
    private function __construct() {
        $this->conexion = new mysqli(
            $this->host,
            $this->usuario,
            $this->contrasena,
            $this->base_de_datos,
            $this->puerto
        );
        
        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }

    // Método para obtener la instancia única de la conexión
    public static function obtenerInstancia() {
        if (!isset(self::$instancia)) {
            self::$instancia = new self();
        }
        return self::$instancia;
    }

    // Método para obtener la conexión a la base de datos
    public function obtenerConexion() {
        return $this->conexion;
    }

    // Evitar la clonación de la instancia
    private function __clone() {}

    // Evitar la serialización de la instancia
    public function __wakeup() {}
}

// Uso de la conexión singleton
$conexionUnica = ConexionDB::obtenerInstancia();
$conexion = $conexionUnica->obtenerConexion();

// Ahora puedes usar $conexion para realizar consultas a la base de datos


?>