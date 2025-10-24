<?php
require_once __DIR__ . '/../models/Celular.php';

class CelularController {
    private $celularModel;

    public function __construct() {
        $this->celularModel = new Celular();
    }

    public function getConexion() {
        return $this->celularModel->getConexion();
    }

    public function listarCelulares($limit = null, $offset = null) {
        if ($limit !== null && $offset !== null) {
            $query = "SELECT * FROM celulares WHERE activo = TRUE LIMIT $limit OFFSET $offset";
            $resultado = $this->celularModel->getConexion()->query($query);
            $celulares = [];
            while ($fila = $resultado->fetch_assoc()) {
                $celulares[] = $fila;
            }
            return $celulares;
        } else {
            return $this->celularModel->obtenerCelulares();
        }
    }

    public function obtenerCelular($id) {
        return $this->celularModel->obtenerCelularPorId($id);
    }

    public function crearCelular(
        $imei,
        $numero_serie,
        $marca,
        $modelo,
        $procesador,
        $pantalla,
        $camara_principal_mpx,
        $camara_frontal_mpx,
        $bateria_mah,
        $carga_rapida,
        $ram_gb,
        $almacenamiento_gb,
        $sistema_operativo,
        $conectividad_5g,
        $nfc,
        $puerto_usb,
        $dual_sim,
        $peso_gramos,
        $grosor_mm,
        $precio_usd,
        $fecha_lanzamiento
    ) {
        return $this->celularModel->guardarCelular(
            $imei,
            $numero_serie,
            $marca,
            $modelo,
            $procesador,
            $pantalla,
            $camara_principal_mpx,
            $camara_frontal_mpx,
            $bateria_mah,
            $carga_rapida,
            $ram_gb,
            $almacenamiento_gb,
            $sistema_operativo,
            $conectividad_5g,
            $nfc,
            $puerto_usb,
            $dual_sim,
            $peso_gramos,
            $grosor_mm,
            $precio_usd,
            $fecha_lanzamiento
        );
    }

    public function editarCelular(
        $id,
        $imei,
        $numero_serie,
        $marca,
        $modelo,
        $procesador,
        $pantalla,
        $camara_principal_mpx,
        $camara_frontal_mpx,
        $bateria_mah,
        $carga_rapida,
        $ram_gb,
        $almacenamiento_gb,
        $sistema_operativo,
        $conectividad_5g,
        $nfc,
        $puerto_usb,
        $dual_sim,
        $peso_gramos,
        $grosor_mm,
        $precio_usd,
        $fecha_lanzamiento
    ) {
        return $this->celularModel->actualizarCelular(
            $id,
            $imei,
            $numero_serie,
            $marca,
            $modelo,
            $procesador,
            $pantalla,
            $camara_principal_mpx,
            $camara_frontal_mpx,
            $bateria_mah,
            $carga_rapida,
            $ram_gb,
            $almacenamiento_gb,
            $sistema_operativo,
            $conectividad_5g,
            $nfc,
            $puerto_usb,
            $dual_sim,
            $peso_gramos,
            $grosor_mm,
            $precio_usd,
            $fecha_lanzamiento
        );
    }

    public function borrarCelular($id) {
        return $this->celularModel->eliminarCelular($id);
    }

    public function contarCelulares() {
        $resultado = $this->celularModel->getConexion()->query("SELECT COUNT(*) as total FROM celulares WHERE activo = TRUE");
        return $resultado->fetch_assoc()['total'];
    }
    public function buscarCelulares($search)
{
    $search = "%" . $this->getConexion()->real_escape_string($search) . "%";
    $query = "
        SELECT *
        FROM celulares
        WHERE (imei LIKE ? OR numero_serie LIKE ? OR modelo LIKE ?)
        AND activo = TRUE
    ";
    $stmt = $this->celularModel->getConexion()->prepare($query);
    $stmt->bind_param("sss", $search, $search, $search);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $celulares = [];
    while ($fila = $resultado->fetch_assoc()) {
        $celulares[] = $fila;
    }
    return $celulares;
}

}
?>
