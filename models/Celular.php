<?php
require_once __DIR__ . '/../config/database.php';

class Celular {
    private $conexion;

    public function __construct() {
        $this->conexion = conectarDB();
    }

    public function getConexion() {
        return $this->conexion;
    }

    public function obtenerCelulares() {
        $query = "SELECT * FROM celulares WHERE activo = TRUE";
        $resultado = $this->conexion->query($query);
        $celulares = [];
        while ($fila = $resultado->fetch_assoc()) {
            $celulares[] = $fila;
        }
        return $celulares;
    }

    public function obtenerCelularPorId($id) {
        $stmt = $this->conexion->prepare("SELECT * FROM celulares WHERE id = ? AND activo = TRUE");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

    public function guardarCelular(
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
        $stmt = $this->conexion->prepare(
            "INSERT INTO celulares (
                imei, numero_serie, marca, modelo, procesador, pantalla, camara_principal_mpx,
                camara_frontal_mpx, bateria_mah, carga_rapida, ram_gb, almacenamiento_gb,
                sistema_operativo, conectividad_5g, nfc, puerto_usb, dual_sim, peso_gramos,
                grosor_mm, precio_usd, fecha_lanzamiento
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        
        // CORRECCIÓN: La cadena de tipos debe tener 21 caracteres (s=string, i=integer, d=decimal)
        // imei(s), numero_serie(s), marca(s), modelo(s), procesador(s), pantalla(s), 
        // camara_principal_mpx(i), camara_frontal_mpx(i), bateria_mah(i), carga_rapida(i), 
        // ram_gb(i), almacenamiento_gb(i), sistema_operativo(s), conectividad_5g(i), 
        // nfc(i), puerto_usb(s), dual_sim(i), peso_gramos(i), grosor_mm(d), precio_usd(d), fecha_lanzamiento(s)
        $stmt->bind_param(
            "ssssssiiiiiisissiidds", // 21 caracteres para 21 parámetros
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
        
        return $stmt->execute();
    }

    public function actualizarCelular(
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
        // VALIDACIÓN: Convertir fecha vacía a NULL
        $fecha_lanzamiento = empty($fecha_lanzamiento) ? null : $fecha_lanzamiento;
        
        $stmt = $this->conexion->prepare(
            "UPDATE celulares SET
                imei = ?,
                numero_serie = ?,
                marca = ?,
                modelo = ?,
                procesador = ?,
                pantalla = ?,
                camara_principal_mpx = ?,
                camara_frontal_mpx = ?,
                bateria_mah = ?,
                carga_rapida = ?,
                ram_gb = ?,
                almacenamiento_gb = ?,
                sistema_operativo = ?,
                conectividad_5g = ?,
                nfc = ?,
                puerto_usb = ?,
                dual_sim = ?,
                peso_gramos = ?,
                grosor_mm = ?,
                precio_usd = ?,
                fecha_lanzamiento = ?
            WHERE id = ?"
        );
        
        // CORRECCIÓN: También corregir el método de actualización (22 parámetros: 21 campos + 1 ID)
        $stmt->bind_param(
            "ssssssiiiiiisissiiddsi", // 22 caracteres para 22 parámetros (incluyendo el ID al final)
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
            $fecha_lanzamiento,
            $id
        );
        
        return $stmt->execute();
    }

    public function eliminarCelular($id) {
        $stmt = $this->conexion->prepare("UPDATE celulares SET activo = FALSE WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>